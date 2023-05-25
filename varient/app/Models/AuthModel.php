<?php namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('users');
        $this->builderRoles = $this->db->table('roles_permissions');
    }

    //input values
    public function inputValues()
    {
        return [
            'username' => inputPost('username'),
            'email' => inputPost('email'),
            'password' => inputPost('password')
        ];
    }

    //login
    public function login()
    {
        $data = $this->inputValues();
        $user = $this->getUserByEmail($data['email']);
        if (!empty($user)) {
            if (!password_verify($data['password'], $user->password)) {
                return false;
            }
            if ($user->status == 0) {
                return 'banned';
            }
            $this->loginUser($user);
            return "success";
        }
        return false;
    }

    //login user
    public function loginUser($user)
    {
        if (!empty($user)) {
            $userData = array(
                'vr_ses_id' => $user->id,
                'vr_ses_role' => $user->role,
                'vr_ses_pass' => md5($user->password ?? '')
            );
            $this->session->set($userData);
        }
    }

    //login with facebook
    public function loginWithFacebook($fbUser)
    {
        if (!empty($fbUser)) {
            $user = $this->getUserByEmail($fbUser->email);
            if (empty($user)) {
                if (empty($fbUser->name)) {
                    $fbUser->name = 'user-' . uniqid();
                }
                $username = $this->generateUniqueUsername($fbUser->name);
                $slug = $this->generateUniqueSlug($username);
                $data = [
                    'facebook_id' => $fbUser->id,
                    'email' => $fbUser->email,
                    'email_status' => 1,
                    'token' => generateToken(),
                    'username' => $username,
                    'slug' => $slug,
                    'avatar' => '',
                    'user_type' => 'facebook',
                    'last_seen' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                ];
                if (!empty($data['email'])) {
                    $this->builder->insert($data);
                    $user = $this->getUserByEmail($fbUser->email);
                    if (!empty($user)) {
                        $this->downloadSocialProfileImage($user, $fbUser->pictureURL);
                    }
                }
            }
            if (!empty($user)) {
                if ($user->status == 0) {
                    return false;
                }
                //login
                $this->loginUser($user);
            }
        }
    }

    //login with google
    public function loginWithGoogle($gUser)
    {
        if (!empty($gUser)) {
            $user = $this->getUserByEmail($gUser->email);
            if (empty($user)) {
                if (empty($gUser->name)) {
                    $gUser->name = 'user-' . uniqid();
                }
                $username = $this->generateUniqueUsername($gUser->name);
                $slug = $this->generateUniqueSlug($username);
                $data = [
                    'google_id' => $gUser->id,
                    'email' => $gUser->email,
                    'email_status' => 1,
                    'token' => generateToken(),
                    'username' => $username,
                    'slug' => $slug,
                    'avatar' => '',
                    'user_type' => 'google',
                    'last_seen' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                ];
                if (!empty($data['email'])) {
                    $this->builder->insert($data);
                    $user = $this->getUserByEmail($gUser->email);
                    if (!empty($user)) {
                        $this->downloadSocialProfileImage($user, $gUser->avatar);
                    }
                }
            }
            if (!empty($user)) {
                if ($user->status == 0) {
                    return false;
                }
                //login
                $this->loginUser($user);
            }
        }
    }

    //login with vk
    public function loginWithVK($vkUser)
    {
        if (!empty($vkUser)) {
            $user = $this->getUserByEmail($vkUser->email);
            if (empty($user)) {
                if (empty($vkUser->name)) {
                    $vkUser->name = 'user-' . uniqid();
                }
                $username = $this->generateUniqueUsername($vkUser->name);
                $slug = $this->generateUniqueSlug($username);
                $data = [
                    'vk_id' => $vkUser->id,
                    'email' => $vkUser->email,
                    'email_status' => 1,
                    'token' => generateToken(),
                    'username' => $username,
                    'slug' => $slug,
                    'avatar' => '',
                    'user_type' => 'vkontakte',
                    'last_seen' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                ];
                if (!empty($data['email'])) {
                    $this->builder->insert($data);
                    $user = $this->getUserByEmail($vkUser->email);
                    if (!empty($user)) {
                        $this->downloadSocialProfileImage($user, $vkUser->avatar);
                    }
                }
            }
            if (!empty($user)) {
                if ($user->status == 0) {
                    return false;
                }
                //login
                $this->loginUser($user);
            }
        }
    }

    //download social profile image
    public function downloadSocialProfileImage($user, $imgURL)
    {
        if (!empty($user) && !empty($imgURL)) {
            $uploadModel = new UploadModel();
            $tempPath = $uploadModel->downloadTempImage($imgURL, 'jpg', 'profile_temp');
            if (!empty($tempPath) && file_exists($tempPath)) {
                $data['avatar'] = $uploadModel->uploadAvatar($user->id, $tempPath);
            }
            if (!empty($data) && !empty($data['avatar'])) {
                $this->builder->where('id', $user->id)->update($data);
            }
        }
    }

    //register
    public function register()
    {
        $data = $this->inputValues();
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['user_type'] = 'registered';
        $data["slug"] = $this->generateUniqueSlug($data['username']);
        $data['status'] = 1;
        $data['token'] = generateToken();
        $data['role'] = 'user';
        $data['last_seen'] = date('Y-m-d H:i:s');
        $data['created_at'] = date('Y-m-d H:i:s');
        if ($this->builder->insert($data)) {
            $id = $this->db->insertID();
            $user = $this->getUser($id);
            if ($this->generalSettings->email_verification == 1 && !empty($user)) {
                $data['email_status'] = 0;
                $emailModel = new EmailModel();
                $emailModel->sendEmailActivation($user->id);
            } else {
                $data['email_status'] = 1;
            }
            if (!empty($user)) {
                $this->loginUser($user);
            }
            return true;
        }
        return false;
    }

    //add user
    public function addUser()
    {
        $data = $this->inputValues();
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['user_type'] = "registered";
        $data["slug"] = $this->generateUniqueSlug($data["username"]);
        $data['status'] = 1;
        $data['email_status'] = 1;
        $data['token'] = generateToken();
        $data['role'] = inputPost('role');
        $data['last_seen'] = date('Y-m-d H:i:s');
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->builder->insert($data);
    }

    //generate unique username
    public function generateUniqueUsername($username)
    {
        $newUsername = $username;
        if (!empty($this->getUserByUsername($newUsername))) {
            $newUsername = $username . " 1";
            if (!empty($this->getUserByUsername($newUsername))) {
                $newUsername = $username . " 2";
                if (!empty($this->getUserByUsername($newUsername))) {
                    $newUsername = $username . " 3";
                    if (!empty($this->getUserByUsername($newUsername))) {
                        $newUsername = $username . "-" . uniqid();
                    }
                }
            }
        }
        return $newUsername;
    }

    //generate uniqe slug
    public function generateUniqueSlug($username)
    {
        $slug = strSlug($username);
        if (!empty($this->getUserBySlug($slug))) {
            $slug = strSlug($username . "-1");
            if (!empty($this->getUserBySlug($slug))) {
                $slug = strSlug($username . "-2");
                if (!empty($this->getUserBySlug($slug))) {
                    $slug = strSlug($username . "-3");
                    if (!empty($this->getUserBySlug($slug))) {
                        $slug = strSlug($username . "-" . uniqid());
                    }
                }
            }
        }
        return $slug;
    }

    //logout
    public function logout()
    {
        $this->session->remove('vr_ses_id');
        $this->session->remove('vr_ses_role');
        $this->session->remove('vr_ses_pass');
    }

    //reset password
    public function resetPassword($token)
    {
        $user = $this->getUserByToken($token);
        if (!empty($user)) {
            $data = [
                'password' => password_hash(inputPost('password'), PASSWORD_DEFAULT),
                'token' => generateToken()
            ];
            return $this->builder->where('id', $user->id)->update($data);
        }
        return false;
    }

    //verify email
    public function verifyEmail($user)
    {
        if (!empty($user)) {
            $data = [
                'email_status' => 1,
                'token' => generateToken()
            ];
            return $this->builder->where('id', $user->id)->update($data);
        }
        return false;
    }

    //change user role
    public function changeUserRole($id, $role)
    {
        $user = $this->getUser($id);
        if (!empty($user)) {
            return $this->builder->where('id', $user->id)->update(['role' => $role]);
        }
        return false;
    }

    //ban user
    public function banUser($user)
    {
        if (!empty($user)) {
            if ($user->status == 1) {
                $data = ['status' => 0];
            } else {
                $data = ['status' => 1];
            }
            return $this->builder->where('id', $user->id)->update($data);
        }
        return false;
    }

    //get user by id
    public function getUser($id)
    {
        return $this->builder->where('id', cleanNumber($id))->get()->getRow();
    }

    //get user by email
    public function getUserByEmail($email)
    {
        return $this->builder->where('email', removeForbiddenCharacters($email))->get()->getRow();
    }

    //get user by username
    public function getUserByUsername($username)
    {
        return $this->builder->where('username', removeForbiddenCharacters($username))->get()->getRow();
    }

    //get user by slug
    public function getUserBySlug($slug)
    {
        return $this->builder->where('slug', cleanSlug($slug))->get()->getRow();
    }

    //get user by token
    public function getUserByToken($token)
    {
        return $this->builder->where('token', removeForbiddenCharacters($token))->get()->getRow();
    }

    //get user by vk id
    public function getUserByVKId($vkId)
    {
        return $this->builder->where('vk_id', cleanStr($vkId))->get()->getRow();
    }

    //get users
    public function getUsers()
    {
        return $this->builder->where('role !=', 'admin')->get()->getResult();
    }

    //get all users
    public function getAllUsers()
    {
        return $this->builder->get()->getResult();
    }

    //get users have posts
    public function getUsersHavePosts()
    {
        return $this->builder->join('posts', 'posts.user_id = users.id')->select('users.*')->distinct()->get()->getResult();
    }

    //get users
    public function getAdministrators()
    {
        return $this->builder->where('role', 'admin')->get()->getResult();
    }

    //get active users
    public function getActiveUsers()
    {
        return $this->builder->where('status', 1)->orderBy('username')->get()->getResult();
    }

    //get latest users
    public function getLatestUsers()
    {
        return $this->builder->orderBy('id DESC')->get(6)->getResult();
    }

    //user count
    public function getUserCount()
    {
        return $this->builder->countAllResults();
    }

    //get roles and permissions
    public function getRolesPermissions()
    {
        return $this->builderRoles->get()->getResult();
    }

    //get role
    public function getRole($id)
    {
        return $this->builderRoles->where('id', cleanNumber($id))->get()->getRow();
    }

    //get role by key
    public function getRoleByKey($key)
    {
        return $this->builderRoles->where('role', cleanStr($key))->get()->getRow();
    }

    //update role
    public function editRole($id)
    {
        $data = [
            'admin_panel' => inputPost('admin_panel') == 1 ? 1 : 0,
            'add_post' => inputPost('add_post') == 1 ? 1 : 0,
            'manage_all_posts' => inputPost('manage_all_posts') == 1 ? 1 : 0,
            'navigation' => inputPost('navigation') == 1 ? 1 : 0,
            'pages' => inputPost('pages') == 1 ? 1 : 0,
            'rss_feeds' => inputPost('rss_feeds') == 1 ? 1 : 0,
            'categories' => inputPost('categories') == 1 ? 1 : 0,
            'widgets' => inputPost('widgets') == 1 ? 1 : 0,
            'polls' => inputPost('polls') == 1 ? 1 : 0,
            'gallery' => inputPost('gallery') == 1 ? 1 : 0,
            'comments_contact' => inputPost('comments_contact') == 1 ? 1 : 0,
            'newsletter' => inputPost('newsletter') == 1 ? 1 : 0,
            'ad_spaces' => inputPost('ad_spaces') == 1 ? 1 : 0,
            'users' => inputPost('users') == 1 ? 1 : 0,
            'seo_tools' => inputPost('seo_tools') == 1 ? 1 : 0,
            'settings' => inputPost('settings') == 1 ? 1 : 0,
        ];
        return $this->builderRoles->where('id', cleanNumber($id))->update($data);
    }

    //edit user
    public function editUser($id)
    {
        $user = $this->getUser($id);
        if (!empty($user)) {
            $data = [
                'username' => inputPost('username'),
                'email' => inputPost('email'),
                'slug' => inputPost('slug'),
                'about_me' => inputPost('about_me'),
                'facebook_url' => inputPost('facebook_url'),
                'twitter_url' => inputPost('twitter_url'),
                'instagram_url' => inputPost('instagram_url'),
                'pinterest_url' => inputPost('pinterest_url'),
                'linkedin_url' => inputPost('linkedin_url'),
                'vk_url' => inputPost('vk_url'),
                'youtube_url' => inputPost('youtube_url'),
                'balance' => inputPost('balance'),
                'total_pageviews' => inputPost('total_pageviews')
            ];
            $uploadModel = new UploadModel();
            $file = $uploadModel->uploadTempFile('file', true);
            if (!empty($file) && !empty($file['path'])) {
                $data["avatar"] = $uploadModel->uploadAvatar($user->id, $file['path']);
                @unlink(FCPATH . $user->avatar);
                $uploadModel->deleteTempFile($file['path']);
            }
            return $this->builder->where('id', $user->id)->update($data);
        }
        return false;
    }

    //is slug unique
    public function isSlugUnique($slug, $id)
    {
        if (!empty($this->builder->where('id !=', cleanNumber($id))->where('slug', cleanSlug($slug))->get()->getRow())) {
            return true;
        }
        return false;
    }

    //check if email is unique
    public function isEmailUnique($email, $userId = 0)
    {
        $user = $this->getUserByEmail($email);
        if ($userId == 0) {
            if (!empty($user)) {
                return false;
            }
            return true;
        } else {
            if (!empty($user) && $user->id != $userId) {
                return false;
            }
            return true;
        }
    }

    //check if username is unique
    public function isUniqueUsername($username, $userId = 0)
    {
        $user = $this->getUserByUsername($username);
        if ($userId == 0) {
            if (!empty($user)) {
                return false;
            }
            return true;
        } else {
            if (!empty($user) && $user->id != $userId) {
                return false;
            }
            return true;
        }
    }

    //update last seen time
    public function updateLastSeen()
    {
        if (authCheck()) {
            $this->builder->where('id', user()->id)->update(['last_seen' => date('Y-m-d H:i:s')]);
        }
    }

    //get paginated users count
    public function getUsersCount()
    {
        $this->filterUsers();
        return $this->builder->where('role !=', 'admin')->countAllResults();
    }

    //get paginated users
    public function getUsersPaginated($perPage, $offset)
    {
        $this->filterUsers();
        return $this->builder->where('role !=', 'admin')->orderBy('created_at DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //users filter
    public function filterUsers()
    {
        $q = inputGet('q');
        if (!empty($q)) {
            $this->builder->groupStart()->like('username', cleanStr($q))->orLike('email', cleanStr($q))->groupEnd();
        }
        $status = inputGet('status');
        if ($status != null && ($status == 1 || $status == 0)) {
            $this->builder->where('status', cleanNumber($status));
        }
        $role = inputGet('role');
        if (!empty($role)) {
            $this->builder->where('role', cleanStr($role));
        }
        $emailStatus = inputGet('email_status');
        if ($emailStatus != null && ($emailStatus == 1 || $emailStatus == 0)) {
            $this->builder->where('email_status', cleanNumber($emailStatus));
        }
        $rewardSystem = inputGet('reward_system');
        if ($rewardSystem != null && ($rewardSystem == 1 || $rewardSystem == 0)) {
            $this->builder->where('reward_system_enabled', cleanNumber($rewardSystem));
        }
    }

    //delete user
    public function deleteUser($id)
    {
        $user = $this->getUser($id);
        if (!empty($user)) {
            if (file_exists(FCPATH . $user->avatar)) {
                @unlink(FCPATH . $user->avatar);
            }
            $this->db->table('comments')->where('user_id', $user->id)->delete();
            $this->db->table('reading_lists')->where('user_id', $user->id)->delete();
            $posts = $this->db->table('posts')->where('user_id', $user->id)->get()->getResult();
            if (!empty($posts)) {
                foreach ($posts as $post) {
                    $postAdminModel = new PostAdminModel();
                    $postAdminModel->deletePost($post->id);
                }
            }
            return $this->builder->where('id', $user->id)->delete();
        }
        return false;
    }
}
