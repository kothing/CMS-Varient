<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Common_controller extends Core_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Admin Login
     */
    public function admin_login()
    {
        get_method();
        //check if logged in
        if (auth_check()) {
            redirect(admin_url());
        }

        $data['title'] = trans("login");
        $data['description'] = trans("login") . " - " . $this->settings->site_title;
        $data['keywords'] = trans("login") . ', ' . $this->settings->application_name;
        $this->load->view('admin/login', $data);

    }

    /**
     * Admin Login Post
     */
    public function admin_login_post()
    {
        post_method();
        //validate inputs
        $this->form_validation->set_rules('email', trans("form_email"), 'required|xss_clean|max_length[200]');
        $this->form_validation->set_rules('password', trans("form_password"), 'required|xss_clean|max_length[30]');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->auth_model->input_values());
            redirect($this->agent->referrer());
        } else {
            $user = $this->auth_model->get_user_by_email($this->input->post('email', true));
            if (!empty($user) && $user->role != 'admin' && $this->general_settings->maintenance_mode_status == 1) {
                $this->session->set_flashdata('error', "Site under construction! Please try again later.");
                redirect($this->agent->referrer());
            }
            if ($this->auth_model->login()) {
                redirect(admin_url());
            } else {
                //error
                $this->session->set_flashdata('form_data', $this->auth_model->input_values());
                $this->session->set_flashdata('error', trans("login_error"));
                redirect($this->agent->referrer());
            }
        }
    }

    /**
     * Logout
     */
    public function logout()
    {
        get_method();
        $this->auth_model->logout();
        redirect($this->agent->referrer());
    }
}
