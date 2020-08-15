<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_model extends CI_Model
{
    //update profile
    public function update_profile($data, $user_id)
    {
        $this->load->model('upload_model');
        $temp_path = $this->upload_model->upload_temp_image('file', 'path');
        if (!empty($temp_path)) {
            $data["avatar"] = $this->upload_model->avatar_upload($this->auth_user->id, $temp_path);
            $this->upload_model->delete_temp_image($temp_path);
            //delete old
            delete_file_from_server($this->auth_user->avatar);
        }

        $this->session->set_userdata('vr_user_old_email', $this->auth_user->email);

        $this->db->where('id', clean_number($user_id));
        return $this->db->update('users', $data);
    }

    //check email updated
    public function check_email_updated($user_id)
    {
        if ($this->general_settings->email_verification == 1) {
            $user = $this->auth_model->get_user($user_id);
            if (!empty($user)) {
                if (!empty($this->session->userdata('vr_user_old_email')) && $this->session->userdata('vr_user_old_email') != $user->email) {
                    //send confirm email
                    $this->load->model("email_model");
                    $this->email_model->send_email_activation($user->id);
                    $data = array(
                        'email_status' => 0
                    );
                    $this->db->where('id', $user->id);
                    return $this->db->update('users', $data);
                }
            }
            if (!empty($this->session->userdata('vr_user_old_email'))) {
                $this->session->unset_userdata('vr_user_old_email');
            }
        }
        return false;
    }

    //update update social accounts
    public function update_social_accounts()
    {
        $data = array(
            'facebook_url' => $this->input->post('facebook_url', true),
            'twitter_url' => $this->input->post('twitter_url', true),
            'instagram_url' => $this->input->post('instagram_url', true),
            'pinterest_url' => $this->input->post('pinterest_url', true),
            'linkedin_url' => $this->input->post('linkedin_url', true),
            'vk_url' => $this->input->post('vk_url', true),
            'telegram_url' => $this->input->post('telegram_url', true),
            'youtube_url' => $this->input->post('youtube_url', true)
        );

        $this->db->where('id', clean_number($this->auth_user->id));
        return $this->db->update('users', $data);
    }

    //update preferences
    public function update_preferences()
    {
        $data = array(
            'show_email_on_profile' => $this->input->post('show_email_on_profile', true),
            'show_rss_feeds' => $this->input->post('show_rss_feeds', true)
        );
        if (empty($data['show_email_on_profile'])) {
            $data['show_email_on_profile'] = 0;
        }
        if (empty($data['show_rss_feeds'])) {
            $data['show_rss_feeds'] = 0;
        }

        $this->db->where('id', clean_number($this->auth_user->id));
        return $this->db->update('users', $data);
    }

    //update visual settings
    public function visual_settings()
    {
        $data = array(
            'site_mode' => $this->input->post('site_mode', true),
            'site_color' => $this->input->post('site_color', true)
        );
        $this->db->where('id', clean_number($this->auth_user->id));
        return $this->db->update('users', $data);
    }

    //edit user
    public function edit_user($id)
    {
        $user = $this->auth_model->get_user($id);
        if (!empty($user)) {
            $data = array(
                'username' => $this->input->post('username', true),
                'email' => $this->input->post('email', true),
                'slug' => $this->input->post('slug', true),
                'about_me' => $this->input->post('about_me', true),
                'facebook_url' => $this->input->post('facebook_url', true),
                'twitter_url' => $this->input->post('twitter_url', true),
                'instagram_url' => $this->input->post('instagram_url', true),
                'pinterest_url' => $this->input->post('pinterest_url', true),
                'linkedin_url' => $this->input->post('linkedin_url', true),
                'vk_url' => $this->input->post('vk_url', true),
                'youtube_url' => $this->input->post('youtube_url', true)
            );

            $this->load->model('upload_model');
            $temp_path = $this->upload_model->upload_temp_image('file', 'path');
            if (!empty($temp_path)) {
                $data["avatar"] = $this->upload_model->avatar_upload($user->id, $temp_path);
                $this->upload_model->delete_temp_image($temp_path);
                //delete old
                delete_file_from_server($user->avatar);
            }

            $this->db->where('id', $user->id);
            return $this->db->update('users', $data);
        }
    }

    //change password input values
    public function change_password_input_values()
    {
        $data = array(
            'old_password' => $this->input->post('old_password', true),
            'password' => $this->input->post('password', true),
            'password_confirm' => $this->input->post('password_confirm', true)
        );
        return $data;
    }

    //change password
    public function change_password($old_password_exists)
    {
        $this->load->library('bcrypt');
        $user = $this->auth_user;
        if (!empty($user)) {
            $data = $this->change_password_input_values();
            if ($old_password_exists == 1) {
                //password does not match stored password.
                if (!$this->bcrypt->check_password($data['old_password'], $user->password)) {
                    $this->session->set_flashdata('error', trans("wrong_password_error"));
                    $this->session->set_flashdata('form_data', $this->change_password_input_values());
                    redirect($this->agent->referrer());
                }
            }
            $data = array(
                'password' => $this->bcrypt->hash_password($data['password'])
            );
            $this->db->where('id', $user->id);
            return $this->db->update('users', $data);
        } else {
            return false;
        }
    }

    //follow user
    public function follow_unfollow_user()
    {
        $data = array(
            'following_id' => clean_number($this->input->post('profile_id', true)),
            'follower_id' => $this->auth_user->id
        );
        $follow = $this->get_follow($data["following_id"], $data["follower_id"]);
        if (empty($follow)) {
            //add follower
            $this->db->insert('followers', $data);
        } else {
            $this->db->where('id', $follow->id);
            $this->db->delete('followers');
        }
    }

    //follow
    public function get_follow($following_id, $follower_id)
    {
        $sql = "SELECT * FROM followers WHERE following_id = ? AND follower_id = ?";
        $query = $this->db->query($sql, array(clean_number($following_id), clean_number($follower_id)));
        return $query->row();
    }

    //is user follows
    public function is_user_follows($following_id, $follower_id)
    {
        $follow = $this->get_follow($following_id, $follower_id);
        if (empty($follow)) {
            return false;
        }
        return true;
    }

    //get followers
    public function get_followers($following_id)
    {
        $sql = "SELECT users.* FROM followers 
                INNER JOIN users ON followers.follower_id = users.id
                WHERE followers.following_id = ?";
        $query = $this->db->query($sql, array(clean_number($following_id)));
        return $query->result();
    }

    //get following users
    public function get_following_users($follower_id)
    {
        $sql = "SELECT users.* FROM followers 
                INNER JOIN users ON followers.following_id = users.id
                WHERE followers.follower_id = ?";
        $query = $this->db->query($sql, array(clean_number($follower_id)));
        return $query->result();
    }

}