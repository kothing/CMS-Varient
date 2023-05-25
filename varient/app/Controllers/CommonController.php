<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\AwsModel;
use App\Models\FileModel;
use CodeIgniter\Controller;
use Config\Globals;

class CommonController extends Controller
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->session = \Config\Services::session();
        $this->generalSettings = Globals::$generalSettings;
        $this->settings = Globals::$settings;
    }

    /**
     * Admin Login
     */
    public function adminLogin()
    {
        if (authCheck()) {
            return redirect()->to(adminUrl());
        }
        $data['title'] = trans("login");
        $data['description'] = trans("login") . " - " . $this->settings->site_title;
        $data['keywords'] = trans("login") . ', ' . $this->settings->application_name;
        $data['generalSettings'] = $this->generalSettings;
        $data['baseSettings'] = $this->settings;
        echo view('admin/login', $data);
    }


    /**
     * Admin Login Post
     */
    public function adminLoginpost()
    {
        $val = \Config\Services::validation();
        $val->setRule('email', trans("email"), 'required|max_length[200]');
        $val->setRule('password', trans("password"), 'required|max_length[200]');
        if (!$this->validate(getValRules($val))) {
            $this->session->setFlashdata('errors', $val->getErrors());
            return redirect()->back()->withInput();
        } else {
            $authModel = new AuthModel();
            $user = $authModel->getUserByEmail(inputPost('email'));
            if (!empty($user) && $user->role != 'admin' && $this->generalSettings->maintenance_mode_status == 1) {
                $this->session->setFlashdata('error', "Site under construction! Please try again later.");
                return redirect()->to(adminUrl('login'));
            }
            if ($authModel->login() == 'success') {
                return redirect()->to(adminUrl());
            } else {
                $this->session->setFlashdata('error', trans("login_error"));
                return redirect()->to(adminUrl('login'));
            }
        }
    }

    /**
     * Switch Dark Mode
     */
    public function switchDarkMode()
    {
        $mode = inputPost('theme_mode');
        if ($mode == 'light' || $mode == 'dark') {
            helperSetCookie('theme_mode', $mode);
        }
        redirectToBackURL();
    }

    /**
     * Download File
     */
    public function downloadFile()
    {
        $fileType = inputPost('file_type');
        $id = inputPost('id');
        $path = '';
        $name = '';
        $storage = 'local';
        $fileModel = new FileModel();
        if ($fileType == 'file') {
            $row = $fileModel->getFile($id);
            if (!empty($row)) {
                $path = FCPATH . $row->file_path;
                $name = $row->file_name;
                $storage = $row->storage;
            }
        }
        if ($fileType == 'audio') {
            $row = $fileModel->getAudio($id);
            if (!empty($row)) {
                $path = FCPATH . $row->audio_path;
                $name = $row->audio_name;
                $storage = $row->storage;
            }
        }
        if ($fileType == 'sitemap') {
            $fileName = inputPost('file_name');
            $security = \Config\Services::security();
            $fileName = $security->sanitizeFilename($fileName);
            if (file_exists(FCPATH . $fileName)) {
                return $this->response->download(FCPATH . $fileName, null)->setFileName($fileName);
            }
        }
        $response = \Config\Services::response();
        if ($storage == 'aws_s3') {
            $awsModel = new AwsModel();
            $awsModel->downloadFile($path);
        } else {
            if (file_exists($path)) {
                if (!empty($name)) {
                    return $this->response->download($path, null)->setFileName($name);
                }
                return $this->response->download($path, null);
            }
        }
        return redirect()->back();
    }

    /**
     * Logout
     */
    public function logout()
    {
        $model = new AuthModel();
        $model->logout();
        return redirect()->back();
    }

}
