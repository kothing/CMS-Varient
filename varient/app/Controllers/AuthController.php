<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\CategoryModel;
use App\Models\EmailModel;
use App\Models\NewsletterModel;

class AuthController extends BaseController
{
    protected $authModel;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->authModel = new AuthModel();
    }

    /**
     * Login Post
     */
    public function loginPost()
    {
        if (authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $val = \Config\Services::validation();
        $val->setRule('email', trans("email"), 'required|max_length[255]');
        $val->setRule('password', trans("password"), 'required|max_length[255]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            echo loadView('partials/_messages');
        } else {
            $model = new AuthModel();
            $result = $model->login();
            if ($result == "success") {
                echo json_encode(['result' => 1]);
            } elseif ($result == "banned") {
                $this->session->setFlashdata('error', trans("message_ban_error"));
                $data = [
                    'result' => 0,
                    'error_message' => loadView('partials/_messages')
                ];
                echo json_encode($data);
            } else {
                $this->session->setFlashdata('error', trans("login_error"));
                $data = [
                    'result' => 0,
                    'error_message' => loadView('partials/_messages')
                ];
                echo json_encode($data);
            }
        }
        $this->session->setFlashdata('errors', '');
        $this->session->setFlashdata('error', '');
        $this->session->setFlashdata('success', '');
    }

    /**
     * Connect with Facebook
     */
    public function connectWithFacebook()
    {
        $state = generateToken();
        $fbUrl = "https://www.facebook.com/v2.10/dialog/oauth?client_id=" . $this->generalSettings->facebook_app_id . "&redirect_uri=" . langBaseUrl() . "/facebook-callback&scope=email&state=" . $state;
        $this->session->set('oauth2state', $state);
        $this->session->set('fbLoginReferrer', previous_url());
        return redirect()->to($fbUrl);
    }

    /**
     * Facebook Callback
     */
    public function facebookCallback()
    {
        require_once APPPATH . "ThirdParty/facebook/vendor/autoload.php";
        $provider = new \League\OAuth2\Client\Provider\Facebook([
            'clientId' => $this->generalSettings->facebook_app_id,
            'clientSecret' => $this->generalSettings->facebook_app_secret,
            'redirectUri' => langBaseUrl() . '/facebook-callback',
            'graphApiVersion' => 'v2.10',
        ]);
        if (!isset($_GET['code'])) {
            echo 'Error: Invalid Login';
            exit();
            // Check given state against previously stored one to mitigate CSRF attack
        } elseif (empty($_GET['state']) || ($_GET['state'] !== $this->session->get('oauth2state'))) {
            $this->session->remove('oauth2state');
            echo 'Error: Invalid State';
            exit();
        }
        $token = $provider->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);
        try {
            $user = $provider->getResourceOwner($token);
            $fbUser = new \stdClass();
            $fbUser->id = $user->getId();
            $fbUser->email = $user->getEmail();
            $fbUser->name = $user->getName();
            $fbUser->firstName = $user->getFirstName();
            $fbUser->lastName = $user->getLastName();
            $fbUser->pictureURL = $user->getPictureUrl();
            $model = new AuthModel();
            $model->loginWithFacebook($fbUser);
            if (!empty($this->session->get('fbLoginReferrer'))) {
                return redirect()->to($this->session->get('fbLoginReferrer'));
            } else {
                return redirect()->to(langBaseUrl());
            }
        } catch (\Exception $e) {
            echo 'Error: Invalid User';
            exit();
        }
    }

    /**
     * Connect with Google
     */
    public function connectWithGoogle()
    {
        require_once APPPATH . 'ThirdParty/google/vendor/autoload.php';
        $provider = new \League\OAuth2\Client\Provider\Google([
            'clientId' => $this->generalSettings->google_client_id,
            'clientSecret' => $this->generalSettings->google_client_secret,
            'redirectUri' => base_url('connect-with-google'),
        ]);

        if (!empty($_GET['error'])) {
            exit('Got error: ' . esc($_GET['error'], ENT_QUOTES, 'UTF-8'));
        } elseif (empty($_GET['code'])) {
            $authUrl = $provider->getAuthorizationUrl();
            $_SESSION['oauth2state'] = $provider->getState();
            $this->session->set('gLoginReferrer', previous_url());
            return redirect()->to($authUrl);
        } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
            unset($_SESSION['oauth2state']);
            exit('Invalid state');
        } else {
            $token = $provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);
            try {
                $user = $provider->getResourceOwner($token);
                $gUser = new \stdClass();
                $gUser->id = $user->getId();
                $gUser->email = $user->getEmail();
                $gUser->name = $user->getName();
                $gUser->firstName = $user->getFirstName();
                $gUser->lastName = $user->getLastName();
                $gUser->avatar = $user->getAvatar();

                $model = new AuthModel();
                $model->loginWithGoogle($gUser);
                if (!empty($this->session->get('gLoginReferrer'))) {
                    return redirect()->to($this->session->get('gLoginReferrer'));
                } else {
                    return redirect()->to(langBaseUrl());
                }
            } catch (Exception $e) {
                exit('Something went wrong: ' . $e->getMessage());
            }
        }
    }

    /**
     * Connect with VK
     */
    public function connectWithVK()
    {
        require_once APPPATH . "ThirdParty/vkontakte/vendor/autoload.php";
        $provider = new \J4k\OAuth2\Client\Provider\Vkontakte([
            'clientId' => $this->generalSettings->vk_app_id,
            'clientSecret' => $this->generalSettings->vk_secure_key,
            'redirectUri' => base_url('connect-with-vk'),
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
            $this->session->set('vkLoginReferrer', previous_url());
            return redirect()->to($authUrl);
        } // Anti-CSRF
        elseif ($isSessionActive && (empty($state) || ($state !== $_SESSION[$sessionState]))) {
            unset($_SESSION[$sessionState]);
            throw new \RuntimeException('Invalid state');
        } else {
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

                $userDetails = json_decode($response);
                $vkUser = new \stdClass();
                $vkUser->id = $providerAccessToken->getValues()['user_id'];
                $vkUser->email = $providerAccessToken->getValues()['email'];
                $vkUser->name = @$userDetails->response['0']->first_name . " " . @$userDetails->response['0']->last_name;
                $vkUser->avatar = @$userDetails->response['0']->photo_200;

                $model = new AuthModel();
                $model->loginWithVK($vkUser);
                if (!empty($this->session->get('vkLoginReferrer'))) {
                    return redirect()->to($this->session->get('vkLoginReferrer'));
                } else {
                    return redirect()->to(langBaseUrl());
                }
            } catch (IdentityProviderException $e) {
                error_log($e->getMessage());
            }
        }
    }

    /**
     * Register
     */
    public function register()
    {
        if ($this->generalSettings->registration_system != 1 || authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("register");
        $data['description'] = trans("register") . " - " . $this->settings->site_title;
        $data['keywords'] = trans("register") . "," . $this->settings->application_name;


        echo loadView('partials/_header', $data);
        echo loadView('auth/register');
        echo loadView('partials/_footer');
    }

    /**
     * Register Post
     */
    public function registerPost()
    {
        if ($this->generalSettings->registration_system != 1 || authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $val = \Config\Services::validation();
        $val->setRule('username', trans("username"), 'required|min_length[4]|max_length[100]');
        $val->setRule('email', trans("email"), 'required|max_length[255]');
        $val->setRule('password', trans("password"), 'required|min_length[4]|max_length[200]');
        $val->setRule('confirm_password', trans("confirm_password"), 'required|matches[password]');
        $val->setRule('terms_conditions', trans("terms_conditions"), 'required');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->to(generateURL('register'))->withInput();
        } else {
            if (reCAPTCHA('validate', $this->generalSettings) == 'invalid') {
                $this->session->setFlashdata('error', trans("msg_recaptcha"));
                return redirect()->to(generateURL('register'))->withInput();
            }
            $email = inputPost('email');
            $username = inputPost('username');
            if (!$this->authModel->isUniqueUsername($username)) {
                $this->session->setFlashdata('error', trans("msg_username_unique_error"));
                return redirect()->to(generateURL('register'))->withInput();
            }
            if (!$this->authModel->isEmailUnique($email)) {
                $this->session->setFlashdata('error', trans("message_email_unique_error"));
                return redirect()->to(generateURL('register'))->withInput();
            }
            if ($this->authModel->register()) {
                if ($this->generalSettings->email_verification == 1) {
                    $this->session->setFlashdata('success', trans("msg_send_confirmation_email"));
                } else {
                    $this->session->setFlashdata('success', trans("msg_register_success"));
                }
                return redirect()->to(generateURL('settings'));
            } else {
                $this->session->setFlashdata('error', trans("msg_error"));
                return redirect()->to(generateURL('register'))->withInput();
            }
        }
        return redirect()->to(generateURL('register'));
    }

    /**
     * Forgot Password
     */
    public function forgotPassword()
    {
        if (authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("forgot_password");
        $data['description'] = trans("forgot_password") . " - " . $this->settings->application_name;
        $data['keywords'] = trans("forgot_password") . "," . $this->settings->application_name;

        echo loadView('partials/_header', $data);
        echo loadView('auth/forgot_password');
        echo loadView('partials/_footer');
    }

    /**
     * Forgot Password Post
     */
    public function forgotPasswordPost()
    {
        if (authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $email = cleanStr(inputPost('email'));
        $user = $this->authModel->getUserByEmail($email);
        if (empty($user)) {
            $this->session->setFlashdata('error', trans("reset_password_error"));
        } else {
            $emailModel = new EmailModel();
            $emailModel->sendEmailResetPassword($user->id);
            $this->session->setFlashdata('success', trans("reset_password_success"));
        }
        return redirect()->to(generateURL('forgot_password'));
    }

    /**
     * Reset Password
     */
    public function resetPassword()
    {
        if (authCheck()) {
            return redirect()->to(langBaseUrl());
        }
        $data['title'] = trans("reset_password");
        $data['description'] = trans("reset_password") . ' - ' . $this->settings->application_name;
        $data['keywords'] = trans("reset_password") . ',' . $this->settings->application_name;
        $token = cleanStr(inputGet('token'));
        $data['user'] = $this->authModel->getUserByToken($token);
        $data['passResetCompleted'] = $this->session->getFlashdata('pass_reset_completed');
        if (empty($data['user']) && empty($data['passResetCompleted'])) {
            return redirect()->to(langBaseUrl());
        }

        echo loadView('partials/_header', $data);
        echo loadView('auth/reset_password');
        echo loadView('partials/_footer');
    }

    /**
     * Reset Password Post
     */
    public function resetPasswordPost()
    {
        $success = inputPost('success');
        if ($success == 1) {
            return redirect()->to(langBaseUrl());
        }
        $val = \Config\Services::validation();
        $val->setRule('password', trans("new_password"), 'required|min_length[4]|max_length[200]');
        $val->setRule('password_confirm', trans("confirm_password"), 'required|matches[password]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            $token = cleanStr(inputPost('token'));
            if ($this->authModel->resetPassword($token)) {
                $this->session->setFlashdata('pass_reset_completed', 1);
                $this->session->setFlashdata('success', trans("message_change_password_success"));
            } else {
                $this->session->setFlashdata('error', trans("message_change_password_error"));
            }
        }
        return redirect()->to(generateURL('reset_password'));
    }

    /**
     * Confirm Email
     */
    public function confirmEmail()
    {
        $data['title'] = trans("confirm_your_email");
        $data['description'] = trans("confirm_your_email") . " - " . $this->settings->application_name;
        $data['keywords'] = trans("confirm_your_email") . "," . $this->settings->application_name;

        $token = cleanStr(inputGet('token'));
        $data['user'] = $this->authModel->getUserByToken($token);
        if (empty($data['user'])) {
            return redirect()->to(langBaseUrl());
        }
        if ($data['user']->email_status == 1) {
            return redirect()->to(langBaseUrl());
        }
        if ($this->authModel->verifyEmail($data['user'])) {
            $data['success'] = trans("msg_confirmed");
        } else {
            $data['error'] = trans("msg_error");
        }

        echo loadView('partials/_header', $data);
        echo loadView('auth/confirm_email', $data);
        echo loadView('partials/_footer');
    }

    /**
     * Unsubscribe
     */
    public function unsubscribe()
    {
        $data['title'] = trans("unsubscribe");
        $data['description'] = trans("unsubscribe");
        $data['keywords'] = trans("unsubscribe");
        $data['pageConfirm'] = true;

        $token = cleanStr(inputGet('token'));
        $newsletterModel = new NewsletterModel();
        $subscriber = $newsletterModel->getSubscriberByToken($token);
        if (empty($subscriber)) {
            return redirect()->to(langBaseUrl());
        }
        $newsletterModel->unsubscribeEmail($subscriber->email);

        echo loadView('partials/_header', $data);
        echo loadView('auth/unsubscribe');
        echo loadView('partials/_footer');
    }
}
