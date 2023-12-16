<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\EmailModel;
use App\Models\PostModel;
use App\Models\ProfileModel;

class ProfileController extends BaseController
{
    protected $authModel;
    protected $profileModel;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->authModel = new AuthModel();
        $this->profileModel = new ProfileModel();
    }

    /**
     * Profile Page
     */
    public function profile($slug)
    {
        $data['user'] = $this->authModel->getUserBySlug($slug);
        if (empty($data["user"])) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = $data['user']->username;
        $data['description'] = $data['user']->username . " - " . $this->settings->site_title;
        $data['keywords'] = $data['user']->username . ', ' . $this->settings->application_name;

        $countKey = 'posts_count_profile' . $data['user']->id;
        $postsKey = 'posts_profile' . $data['user']->id;
        $postModel = new PostModel();
        $data['numRows'] = getCachedData($countKey);
        if (empty($data['numRows'])) {
            $data['numRows'] = $postModel->getUserPostsCount($data['user']->id);
            setCacheData($countKey, $data['numRows']);
        }
        $pager = paginate($this->generalSettings->pagination_per_page, $data['numRows']);
        $data['posts'] = getCachedData($postsKey . '_page' . $pager->currentPage);
        if (empty($data['posts'])) {
            $data['posts'] = $postModel->getUserPostsPaginated($data['user']->id, $this->generalSettings->pagination_per_page, $pager->offset);
            setCacheData($postsKey . '_page' . $pager->currentPage, $data['posts']);
        }
        $data['following'] = $this->profileModel->getFollowingUsers($data['user']->id);
        $data['followers'] = $this->profileModel->getFollowers($data['user']->id);
        $data['headerNoMargin'] = true;

        echo loadView('partials/_header', $data);
        echo loadView('profile/profile', $data);
        echo loadView('partials/_footer');
    }

    /**
     * Edit Profile
     */
    public function editProfile()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("update_profile");
        $data['description'] = trans("update_profile") . " - " . $this->settings->site_title;
        $data['keywords'] = trans("update_profile") . "," . $this->settings->application_name;
        $data["activeTab"] = 'update_profile';

        echo loadView('partials/_header', $data);
        echo loadView('settings/edit_profile', $data);
        echo loadView('partials/_footer');
    }

    /**
     * Edit Profile Post
     */
    public function editProfilePost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $submit = inputPost('submit');
        if ($submit == 'resend_activation_email') {
            //send activation email
            $emailModel = new EmailModel();
            $emailModel->sendEmailActivation(user()->id);
            $this->session->setFlashdata('success', trans("msg_send_confirmation_email"));
            redirectToBackURL();
        }
        $val = \Config\Services::validation();
        $val->setRule('email', trans("email"), 'required|max_length[255]');
        $val->setRule('username', trans("username"), 'required|max_length[255]');
        $val->setRule('slug', trans("slug'"), 'required|max_length[255]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            redirectToBackURL();
        } else {
            $data = [
                'username' => cleanStr(inputPost('username')),
                'slug' => cleanSlug(inputPost('slug')),
                'email' => cleanStr(inputPost('email')),
                'about_me' => inputPost('about_me')
            ];
            if (!$this->authModel->isEmailUnique($data['email'], user()->id)) {
                $this->session->setFlashdata('error', trans("message_email_unique_error"));
                redirectToBackURL();
            }
            if (!$this->authModel->isUniqueUsername($data['username'], user()->id)) {
                $this->session->setFlashdata('error', trans("msg_username_unique_error"));
                redirectToBackURL();
            }
            if ($this->authModel->isSlugUnique($data['slug'], user()->id)) {
                $this->session->setFlashdata('error', trans("msg_slug_used"));
                redirectToBackURL();
            }
            if ($this->profileModel->editProfile($data)) {
                //check email changed
                $this->session->setFlashdata('success', trans("msg_updated"));
                if ($this->profileModel->checkEmailChanged(user()->id)) {
                    $this->session->setFlashdata('success', trans("msg_send_confirmation_email"));
                }
                redirectToBackURL();
            }
        }
        $this->session->setFlashdata('error', trans("msg_error"));
        redirectToBackURL();
    }

    /**
     * Social Accounts
     */
    public function socialAccounts()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("social_accounts");
        $data['description'] = trans("social_accounts") . " - " . $this->settings->site_title;
        $data['keywords'] = trans("social_accounts") . "," . $this->settings->application_name;

        $data['activeTab'] = 'social_accounts';

        echo loadView('partials/_header', $data);
        echo loadView('settings/social_accounts', $data);
        echo loadView('partials/_footer');
    }

    /**
     * Social Accounts Post
     */
    public function socialAccountsPost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        if ($this->profileModel->editSocialAccounts()) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        redirectToBackURL();
    }

    /**
     * Preferences
     */
    public function preferences()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("preferences");
        $data['description'] = trans("preferences") . " - " . $this->settings->site_title;
        $data['keywords'] = trans("preferences") . "," . $this->settings->application_name;

        $data['activeTab'] = 'preferences';

        echo loadView('partials/_header', $data);
        echo loadView('settings/preferences', $data);
        echo loadView('partials/_footer');
    }

    /**
     * Preferences Post
     */
    public function preferencesPost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        if ($this->profileModel->editPreferences()) {
            $this->session->setFlashdata('success', trans("msg_updated"));
        } else {
            $this->session->setFlashdata('error', trans("msg_error"));
        }
        redirectToBackURL();
    }

    /**
     * Change Password
     */
    public function changePassword()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("change_password");
        $data['description'] = trans("change_password") . " - " . $this->settings->site_title;
        $data['keywords'] = trans("change_password") . "," . $this->settings->application_name;

        $data['activeTab'] = 'change_password';

        echo loadView('partials/_header', $data);
        echo loadView('settings/change_password', $data);
        echo loadView('partials/_footer');
    }

    /**
     * Change Password Post
     */
    public function changePasswordPost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $val = \Config\Services::validation();
        if (!empty(user()->password)) {
            $val->setRule('old_password', trans("old_password"), 'required');
        }
        $val->setRule('password', trans("password"), 'required|min_length[4]|max_length[200]');
        $val->setRule('password_confirm', trans("confirm_password"), 'required|matches[password]|max_length[200]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            redirectToBackURL();
        } else {
            if ($this->profileModel->changePassword()) {
                $this->session->setFlashdata('success', trans("message_change_password_success"));
            } else {
                $this->session->setFlashdata('error', trans("message_change_password_error"));
            }
        }
        redirectToBackURL();
    }

    /**
     * Delete Account
     */
    public function deleteAccount()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("delete_account");
        $data['description'] = trans("delete_account") . " - " . $this->settings->site_title;
        $data['keywords'] = trans("delete_account") . "," . $this->settings->application_name;

        $data['activeTab'] = 'delete_account';

        echo loadView('partials/_header', $data);
        echo loadView('settings/delete_account', $data);
        echo loadView('partials/_footer');
    }

    /**
     * Delete Account Post
     */
    public function deleteAccountPost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $confirm = inputPost('confirm');
        $password = inputPost('password');
        if (empty($confirm)) {
            $this->session->setFlashdata('error', trans("msg_error"));
            redirectToBackURL();
        }
        if (!password_verify($password, user()->password)) {
            $this->session->setFlashdata('error', trans("msg_wrong_password"));
            redirectToBackURL();
        }
        //delete account
        $this->authModel->deleteUser(user()->id);
        redirectToBackURL();
    }

    /**
     * Follow Unfollow User
     */
    public function followUnfollowUserPost()
    {
        if (!authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $this->profileModel->followUnFollowUser();
        redirectToBackURL();
    }
}