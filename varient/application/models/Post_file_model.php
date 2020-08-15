<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Post_file_model extends CI_Model
{

    /*
    *------------------------------------------------------------------------------------------
    * IMAGES
    *------------------------------------------------------------------------------------------
    */

    //delete post main image
    public function delete_post_main_image($post_id)
    {
        $post = $this->post_admin_model->get_post($post_id);
        if (!empty($post)) {
            $data = array(
                'image_big' => "",
                'image_default' => "",
                'image_slider' => "",
                'image_mid' => "",
                'image_small' => "",
                'image_url' => ""
            );
            $this->db->where('id', $post->id);
            $this->db->update('posts', $data);
        }
    }


    /*
    *------------------------------------------------------------------------------------------
    * ADDITIONAL IMAGES
    *------------------------------------------------------------------------------------------
    */

    //add post additional images
    public function add_post_additional_images($post_id)
    {
        $image_ids = $this->input->post('additional_post_image_id', true);
        if (!empty($image_ids)) {
            foreach ($image_ids as $image_id) {
                $image = $this->file_model->get_image($image_id);

                if (!empty($image)) {
                    $item = array(
                        'post_id' => $post_id,
                        'image_big' => $image->image_big,
                        'image_default' => $image->image_default,
                    );
                    if (!empty($item["image_default"])) {
                        $this->db->insert('post_images', $item);
                    }
                }
            }
        }
    }

    //delete additional image
    public function delete_post_additional_image($file_id)
    {
        $image = $this->get_post_additional_image($file_id);
        if (!empty($image)) {
            $this->db->where('id', $image->id);
            $this->db->delete('post_images');
        }
    }

    //delete additional images
    public function delete_post_additional_images($post_id)
    {
        $images = $this->get_post_additional_images($post_id);
        if (!empty($images)) {
            foreach ($images as $image) {
                $this->db->where('id', $image->id);
                $this->db->delete('post_images');
            }
        }
    }

    //get post additional images
    public function get_post_additional_images($post_id)
    {
        $sql = "SELECT * FROM post_images WHERE post_id = ?";
        $query = $this->db->query($sql, array(clean_number($post_id)));
        return $query->result();
    }

    //get post additional image
    public function get_post_additional_image($file_id)
    {
        $sql = "SELECT * FROM post_images WHERE id = ?";
        $query = $this->db->query($sql, array(clean_number($file_id)));
        return $query->row();
    }


    /*
    *------------------------------------------------------------------------------------------
    * AUDIOS
    *------------------------------------------------------------------------------------------
    */

    //get post audio
    public function get_post_audio($post_id, $audio_id)
    {
        $sql = "SELECT * FROM post_audios WHERE post_audios.post_id = ? AND post_audios.id = ?";
        $query = $this->db->query($sql, array(clean_number($post_id), clean_number($audio_id)));
        return $query->row();
    }

    //add post audios
    public function add_post_audios($post_id)
    {
        $audio_ids = $this->input->post('post_audio_id', true);
        if (!empty($audio_ids)) {
            foreach ($audio_ids as $audio_id) {
                $audio = $this->file_model->get_audio($audio_id);
                if (!empty($audio)) {
                    $item = array(
                        'post_id' => $post_id,
                        'audio_id' => $audio->id,
                    );
                    $this->db->insert('post_audios', $item);
                }
            }
        }
    }

    //get post audios
    public function get_post_audios($post_id)
    {
        $sql = "SELECT audios.*, post_audios.id as post_audio_id FROM audios 
                INNER JOIN post_audios ON audios.id = post_audios.audio_id
                WHERE post_audios.post_id = ? ORDER BY post_audios.id";
        $query = $this->db->query($sql, array(clean_number($post_id)));
        return $query->result();
    }

    //delete post audio
    public function delete_post_audio($post_audio_id)
    {
        $this->db->where('id', clean_number($post_audio_id));
        $this->db->delete('post_audios');
    }

    //delete post audios
    public function delete_post_audios($post_id)
    {
        $this->db->where('post_audios.post_id', clean_number($post_id));
        $query = $this->db->get('post_audios');
        $audios = $query->result();
        if (!empty($audios)) {
            foreach ($audios as $audio) {
                $this->db->where('id', $audio->id);
                $this->db->delete('post_audios');
            }
        }
    }


    /*
    *------------------------------------------------------------------------------------------
    * VIDEOS
    *------------------------------------------------------------------------------------------
    */

    //delete post video
    public function delete_post_video($post_id)
    {
        $post = $this->post_admin_model->get_post($post_id);
        if (!empty($post)) {
            $data = array(
                'video_path' => ""
            );
            $this->db->where('id', $post->id);
            return $this->db->update('posts', $data);
        }
    }


    /*
    *------------------------------------------------------------------------------------------
    * FILES
    *------------------------------------------------------------------------------------------
    */

    //add post files
    public function add_post_files($post_id)
    {
        $file_ids = $this->input->post('post_selected_file_id', true);
        if (!empty($file_ids)) {
            foreach ($file_ids as $file_id) {
                $file = $this->file_model->get_file($file_id);
                if (!empty($file)) {
                    $item = array(
                        'post_id' => $post_id,
                        'file_id' => $file_id
                    );
                    $this->db->insert('post_files', $item);
                }
            }
        }
    }

    //get post file
    public function get_post_file($id)
    {
        $sql = "SELECT * FROM post_files WHERE id =  ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->row();
    }

    //get post files
    public function get_post_files($post_id)
    {
        $sql = "SELECT files.*, post_files.id as post_file_id FROM post_files 
                INNER JOIN files ON files.id = post_files.file_id
                WHERE post_files.post_id = ? ORDER BY post_files.id";
        $query = $this->db->query($sql, array(clean_number($post_id)));
        return $query->result();
    }

    //delete post file
    public function delete_post_file($id)
    {
        $file = $this->get_post_file($id);
        print_r($file);
        if (!empty($file)) {
            $this->db->where('id', $id);
            $this->db->delete('post_files');
        }
    }

}