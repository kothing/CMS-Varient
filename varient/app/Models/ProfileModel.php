<?php namespace App\Models;

use CodeIgniter\Model;

class ProfileModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('users');
        $this->builderFollowers = $this->db->table('followers');
    }

    //update profile
    public function editProfile($data)
    {
        $uploadModel = new UploadModel();
        $file = $uploadModel->uploadTempFile('file', true);
        if (!empty($file) && !empty($file['path'])) {
            $data['avatar'] = $uploadModel->uploadAvatar(user()->id, $file['path']);
            @unlink(FCPATH . user()->avatar);
            $uploadModel->deleteTempFile($file['path']);
        }
        $imageCover = $uploadModel->uploadTempFile('image_cover', true);
        if (!empty($imageCover) && !empty($imageCover['path'])) {
            $data['cover_image'] = $uploadModel->uploadCoverImage(user()->id, $imageCover['path']);
            @unlink(FCPATH . user()->cover_image);
            $uploadModel->deleteTempFile($imageCover['path']);
        }
        $this->session->set('vr_user_old_email', user()->email);
        return $this->builder->where('id', cleanNumber(user()->id))->update($data);
    }

    //check email updated
    public function checkEmailChanged($userId)
    {
        if ($this->generalSettings->email_verification == 1) {
            $user = getUserById($userId);
            if (!empty($user)) {
                if (!empty($this->session->get('vr_user_old_email')) && $this->session->get('vr_user_old_email') != $user->email) {
                    $emailModel = new EmailModel();
                    $emailModel->sendEmailActivation($user->id);
                    return $this->builder->where('id', $user->id)->update(['email_status' => 0]);
                }
            }
            if (!empty($this->session->get('vr_user_old_email'))) {
                $this->session->remove('vr_user_old_email');
            }
        }
        return false;
    }

    //edit update social accounts
    public function editSocialAccounts()
    {
        $data = [
            'facebook_url' => inputPost('facebook_url'),
            'twitter_url' => inputPost('twitter_url'),
            'instagram_url' => inputPost('instagram_url'),
            'pinterest_url' => inputPost('pinterest_url'),
            'linkedin_url' => inputPost('linkedin_url'),
            'vk_url' => inputPost('vk_url'),
            'telegram_url' => inputPost('telegram_url'),
            'youtube_url' => inputPost('youtube_url')
        ];
        return $this->builder->where('id', cleanNumber(user()->id))->update($data);
    }

    //edit preferences
    public function editPreferences()
    {
        $data = [
            'show_email_on_profile' => inputPost('show_email_on_profile'),
            'show_rss_feeds' => inputPost('show_rss_feeds')
        ];
        if (empty($data['show_email_on_profile'])) {
            $data['show_email_on_profile'] = 0;
        }
        if (empty($data['show_rss_feeds'])) {
            $data['show_rss_feeds'] = 0;
        }
        return $this->builder->where('id', cleanNumber(user()->id))->update($data);
    }

    //change password
    public function changePassword()
    {
        $data = [
            'old_password' => inputPost('old_password'),
            'password' => inputPost('password'),
            'password_confirm' => inputPost('password_confirm')
        ];
        $user = user();
        if (!empty($user)) {
            if (!empty($user->password)) {
                if (!password_verify($data['old_password'], $user->password)) {
                    $this->session->setFlashdata('error', trans("wrong_password_error"));
                    redirectToBackURL();
                }
            }
            $password = password_hash($data['password'], PASSWORD_DEFAULT);
            if ($this->builder->where('id', $user->id)->update(['password' => $password])) {
                $this->session->set('vr_ses_pass', md5($password ?? ''));
                return true;
            }
        }
        return false;
    }

    //follow user
    public function followUnFollowUser()
    {
        $data = [
            'following_id' => cleanNumber(inputPost('profile_id')),
            'follower_id' => user()->id
        ];
        $follow = $this->getFollow($data['following_id'], $data['follower_id']);
        if (!empty($follow)) {
            $this->builderFollowers->where('id', $follow->id)->delete();
        } else {
            $this->builderFollowers->insert($data);
        }
    }

    //get follow
    public function getFollow($followingId, $followerId)
    {
        return $this->builderFollowers->where('following_id', cleanNumber($followingId))->where('follower_id', cleanNumber($followerId))->get()->getRow();
    }

    //is user follows
    public function isUserFollows($followingId, $followerId)
    {
        if (!empty($this->getFollow($followingId, $followerId))) {
            return true;
        }
        return false;
    }

    //get followers
    public function getFollowers($followingId)
    {
        return $this->builderFollowers->join('users', 'followers.follower_id = users.id')->select('users.*')->where('followers.following_id', cleanNumber($followingId))->get()->getResult();
    }

    //get following users
    public function getFollowingUsers($followerId)
    {
        return $this->builderFollowers->join('users', 'followers.following_id = users.id')->select('users.*')->where('followers.follower_id', cleanNumber($followerId))->get()->getResult();
    }

}