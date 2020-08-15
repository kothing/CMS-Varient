<?php defined('BASEPATH') or exit('No direct script access allowed');

class Auth_controller extends Home_Core_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('bcrypt');
    }

    /**
     * Login Post
     */
    public function login_post()
    {
        post_method();
        $this->reset_flash_data();
        //validate inputs
        $this->form_validation->set_rules('email', trans("form_email"), 'required|xss_clean|max_length[200]');
        $this->form_validation->set_rules('password', trans("form_password"), 'required|xss_clean|max_length[30]');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->auth_model->input_values());
            $this->load->view('partials/_messages');
        } else {
            if ($this->auth_model->login()) {
                $data = array(
                    'result' => 1
                );
                //remember user
                $remember_me = $this->input->post('remember_me', true);
                if ($remember_me == 1) {
                    $this->auth_model->remember_me(user()->id);
                }
                echo json_encode($data);
            } else {
                $data = array(
                    'result' => 0,
                    'error_message' => $this->load->view('partials/_messages', '', true)
                );
                echo json_encode($data);
            }
            $this->reset_flash_data();
        }
    }

    /**
     * Connect with Facebook
     */
    public function connect_with_facebook()
    {
        get_method();
        $fb_url = "https://www.facebook.com/v3.3/dialog/oauth?client_id=" . $this->general_settings->facebook_app_id . "&redirect_uri=" . base_url() . "facebook-callback&scope=email&state=" . generate_unique_id();

        $this->session->set_userdata('fb_login_referrer', $this->agent->referrer());
        redirect($fb_url);
        exit();
    }

    /**
     * Facebook Callback
     */
    public function facebook_callback()
    {
        //include facebook login
        require_once APPPATH . "third_party/facebook/vendor/autoload.php";

        $fb = new \Facebook\Facebook([
            'app_id' => $this->general_settings->facebook_app_id,
            'app_secret' => $this->general_settings->facebook_app_secret,
            'default_graph_version' => 'v2.10',
        ]);
        try {
            $helper = $fb->getRedirectLoginHelper();
            $permissions = ['email'];
            if (isset($_GET['state'])) {
                $helper->getPersistentDataHandler()->set('state', $_GET['state']);
            }
            $accessToken = $helper->getAccessToken();
            if (empty($accessToken)) {
                redirect(lang_base_url());
            }
            $response = $fb->get('/me?fields=name,email', $accessToken);
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $user = $response->getGraphUser();
        $fb_user = new stdClass();
        $fb_user->id = $user->getId();
        $fb_user->email = $user->getEmail();
        $fb_user->name = $user->getName();

        $this->auth_model->login_with_facebook($fb_user);

        if (!empty($this->session->userdata('fb_login_referrer'))) {
            redirect($this->session->userdata('fb_login_referrer'));
        } else {
            redirect(base_url());
        }
    }


    /**
     * Connect with Google
     */
    public function connect_with_google()
    {
        require_once APPPATH . "third_party/google/vendor/autoload.php";

        $provider = new League\OAuth2\Client\Provider\Google([
            'clientId' => $this->general_settings->google_client_id,
            'clientSecret' => $this->general_settings->google_client_secret,
            'redirectUri' => base_url() . 'connect-with-google',
        ]);

        if (!empty($_GET['error'])) {
            // Got an error, probably user denied access
            exit('Got error: ' . htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'));
        } elseif (empty($_GET['code'])) {

            // If we don't have an authorization code then get one
            $authUrl = $provider->getAuthorizationUrl();
            $_SESSION['oauth2state'] = $provider->getState();
            $this->session->set_userdata('g_login_referrer', $this->agent->referrer());
            header('Location: ' . $authUrl);
            exit();

        } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
            // State is invalid, possible CSRF attack in progress
            unset($_SESSION['oauth2state']);
            exit('Invalid state');
        } else {
            // Try to get an access token (using the authorization code grant)
            $token = $provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);
            // Optional: Now you have a token you can look up a users profile data
            try {
                // We got an access token, let's now get the owner details
                $user = $provider->getResourceOwner($token);

                $g_user = new stdClass();
                $g_user->id = $user->getId();
                $g_user->email = $user->getEmail();
                $g_user->name = $user->getName();
                $g_user->avatar = $user->getAvatar();

                $this->auth_model->login_with_google($g_user);

                if (!empty($this->session->userdata('g_login_referrer'))) {
                    redirect($this->session->userdata('g_login_referrer'));
                } else {
                    redirect(base_url());
                }

            } catch (Exception $e) {
                // Failed to get user details
                exit('Something went wrong: ' . $e->getMessage());
            }
        }
    }


    /**
     * Connect with VK
     */
    public function connect_with_vk()
    {
        require_once APPPATH . "third_party/vkontakte/vendor/autoload.php";
        $provider = new J4k\OAuth2\Client\Provider\Vkontakte([
            'clientId' => $this->general_settings->vk_app_id,
            'clientSecret' => $this->general_settings->vk_secure_key,
            'redirectUri' => base_url() . 'connect-with-vk',
            'scopes' => ['email'],
        ]);
        // Authorize if needed
        if (PHP_SESSION_NONE === session_status()) session_start();
        $isSessionActive = PHP_SESSION_ACTIVE === session_status();
        $code = !empty($_GET['code']) ? $_GET['code'] : null;
        $state = !empty($_GET['state']) ? $_GET['state'] : null;
        $sessionState = 'oauth2state';

        // No code – get some
        if (!$code) {
            $authUrl = $provider->getAuthorizationUrl();
            if ($isSessionActive) $_SESSION[$sessionState] = $provider->getState();
            $this->session->set_userdata('vk_login_referrer', $this->agent->referrer());
            header("Location: $authUrl");
            die();
        } // Anti-CSRF
        elseif ($isSessionActive && (empty($state) || ($state !== $_SESSION[$sessionState]))) {
            unset($_SESSION[$sessionState]);
            throw new \RuntimeException('Invalid state');
        } // Exchange code to access_token
        else {
            try {
                $providerAccessToken = $provider->getAccessToken('authorization_code', ['code' => $code]);

                $user = $providerAccessToken->getValues();
                //get user details with cURL
                $url = 'http://api.vk.com/method/users.get?uids=' . $providerAccessToken->getValues()['user_id'] . '&access_token=' . $providerAccessToken->getToken() . '&v=5.95&fields=photo_200,status';
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                $response = curl_exec($ch);
                curl_close($ch);
                $user_details = json_decode($response);

                $vk_user = new stdClass();
                $vk_user->id = $providerAccessToken->getValues()['user_id'];
                $vk_user->email = $providerAccessToken->getValues()['email'];
                $vk_user->name = @$user_details->response['0']->first_name . " " . @$user_details->response['0']->last_name;
                $vk_user->avatar = @$user_details->response['0']->photo_200;

                $this->auth_model->login_with_vk($vk_user);

                if (!empty($this->session->userdata('vk_login_referrer'))) {
                    redirect($this->session->userdata('vk_login_referrer'));
                } else {
                    redirect(base_url());
                }
            } catch (IdentityProviderException $e) {
                // Log error
                error_log($e->getMessage());
            }
        }
    }

    /**
     * Register
     */
    public function register()
    {
        get_method();
        $this->is_registration_active();
        //check if logged in
        if (auth_check()) {
            redirect(lang_base_url());
        }
        $data['title'] = trans("register");
        $data['description'] = trans("register") . " - " . $this->settings->site_title;
        $data['keywords'] = trans("register") . "," . $this->settings->application_name;

        $this->load->view('partials/_header', $data);
        $this->load->view('auth/register');
        $this->load->view('partials/_footer');
    }

    /**
     * Register Post
     */
    public function register_post()
    {
        post_method();
        $this->reset_flash_data();
        //validate inputs
        $this->form_validation->set_rules('username', trans("form_username"), 'required|xss_clean|min_length[4]|max_length[100]');
        $this->form_validation->set_rules('email', trans("form_email"), 'required|xss_clean|max_length[200]');
        $this->form_validation->set_rules('password', trans("form_password"), 'required|xss_clean|min_length[4]|max_length[30]');
        $this->form_validation->set_rules('confirm_password', trans("form_confirm_password"), 'required|xss_clean|matches[password]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->auth_model->input_values());
            redirect($this->agent->referrer());
        } else {
            if (!$this->recaptcha_verify_request()) {
                $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                $this->session->set_flashdata('error', trans("msg_recaptcha"));
                redirect($this->agent->referrer());
            }
            $email = $this->input->post('email', true);
            $username = $this->input->post('username', true);
            //is username unique
            if (!$this->auth_model->is_unique_username($username)) {
                $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                $this->session->set_flashdata('error', trans("msg_username_unique_error"));
                redirect($this->agent->referrer());
            }
            //is email unique
            if (!$this->auth_model->is_unique_email($email)) {
                $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                $this->session->set_flashdata('error', trans("message_email_unique_error"));
                redirect($this->agent->referrer());
            }
            //register
            $user = $this->auth_model->register();
            if ($user) {
                $this->auth_model->login_direct($user);
                if ($this->general_settings->email_verification == 1) {
                    $this->session->set_flashdata('success', trans("msg_send_confirmation_email"));
                } else {
                    $this->session->set_flashdata('success', trans("msg_register_success"));
                }
                redirect(generate_url('register'));
            } else {
                //error
                $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                $this->session->set_flashdata('error', trans("message_register_error"));
                redirect($this->agent->referrer());
            }
        }
    }


    /**
     * Forgot Password
     */
    public function forgot_password()
    {
        get_method();
        //check if logged in
        if (auth_check()) {
            redirect(lang_base_url());
        }
        $data['title'] = trans("forgot_password");
        $data['description'] = trans("forgot_password") . " - " . $this->settings->application_name;
        $data['keywords'] = trans("forgot_password") . "," . $this->settings->application_name;

        $this->load->view('partials/_header', $data);
        $this->load->view('auth/forgot_password');
        $this->load->view('partials/_footer');
    }


    /**
     * Forgot Password Post
     */
    public function forgot_password_post()
    {
        post_method();
        //check auth
        if (auth_check()) {
            redirect(lang_base_url());
        }
        $email = clean_str($this->input->post('email', true));
        //get user
        $user = $this->auth_model->get_user_by_email($email);
        //if user not exists
        if (empty($user)) {
            $this->session->set_flashdata('error', html_escape(trans("reset_password_error")));
            redirect($this->agent->referrer());
        } else {
            $this->load->model("email_model");
            $this->email_model->send_email_reset_password($user->id);
            $this->session->set_flashdata('success', trans("reset_password_success"));
            redirect($this->agent->referrer());
        }
    }

    /**
     * Reset Password
     */
    public function reset_password()
    {
        get_method();
        //check if logged in
        if (auth_check()) {
            redirect(lang_base_url());
        }
        $data['title'] = trans("reset_password");
        $data['description'] = trans("reset_password") . " - " . $this->settings->application_name;
        $data['keywords'] = trans("reset_password") . "," . $this->settings->application_name;
        $token = clean_str($this->input->get('token', true));
        //get user
        $data["user"] = $this->auth_model->get_user_by_token($token);
        $data["success"] = $this->session->flashdata('success');
        if (empty($data["user"]) && empty($data["success"])) {
            redirect(lang_base_url());
        }

        $this->load->view('partials/_header', $data);
        $this->load->view('auth/reset_password');
        $this->load->view('partials/_footer');
    }

    /**
     * Reset Password Post
     */
    public function reset_password_post()
    {
        post_method();
        $success = $this->input->post('success', true);
        if ($success == 1) {
            redirect(lang_base_url());
        }
        $this->form_validation->set_rules('password', trans("new_password"), 'required|xss_clean|min_length[4]|max_length[50]');
        $this->form_validation->set_rules('password_confirm', trans("password_confirm"), 'required|xss_clean|matches[password]');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->profile_model->change_password_input_values());
            redirect($this->agent->referrer());
        } else {
            $user_id = clean_number($this->input->post('id', true));
            if ($this->auth_model->reset_password($user_id)) {
                $this->session->set_flashdata('success', trans("message_change_password_success"));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('error', trans("message_change_password_error"));
                redirect($this->agent->referrer());
            }
        }
    }

    /**
     * Confirm Email
     */
    public function confirm_email()
    {
        get_method();
        $data['title'] = trans("confirm_your_email");
        $data['description'] = trans("confirm_your_email") . " - " . $this->settings->application_name;
        $data['keywords'] = trans("confirm_your_email") . "," . $this->settings->application_name;

        $token = clean_str($this->input->get("token", true));
        $data["user"] = $this->auth_model->get_user_by_token($token);

        if (empty($data["user"])) {
            redirect(lang_base_url());
        }
        if ($data["user"]->email_status == 1) {
            redirect(lang_base_url());
        }

        if ($this->auth_model->verify_email($data["user"])) {
            $data["success"] = trans("msg_confirmed");
        } else {
            $data["error"] = trans("msg_error");
        }
        $this->load->view('partials/_header', $data);
        $this->load->view('auth/confirm_email', $data);
        $this->load->view('partials/_footer');
    }

    /**
     * Unsubscribe
     */
    public function unsubscribe()
    {
        get_method();
        $data['title'] = trans("unsubscribe");
        $data['description'] = trans("unsubscribe");
        $data['keywords'] = trans("unsubscribe");
        $data['page_confirm'] = true;

        $token = clean_str($this->input->get("token"));
        $subscriber = $this->newsletter_model->get_subscriber_by_token($token);
        if (empty($subscriber)) {
            redirect(lang_base_url());
        }
        $this->newsletter_model->unsubscribe_email($subscriber->email);

        $this->load->view('partials/_header', $data);
        $this->load->view('auth/unsubscribe');
        $this->load->view('partials/_footer');
    }

    //reset flash data
    private function reset_flash_data()
    {
        $this->session->set_flashdata('errors', "");
        $this->session->set_flashdata('error', "");
        $this->session->set_flashdata('success', "");
    }

    //check if membership system active
    private function is_registration_active()
    {
        if ($this->general_settings->registration_system != 1) {
            redirect(lang_base_url());
        }
    }

}
