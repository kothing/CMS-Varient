<?php defined('BASEPATH') or exit('No direct script access allowed');

class Core_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_version();
        //general settings
        $this->general_settings = $this->config->item('general_settings');
        $this->routes = $this->config->item('routes');
        //set timezone
        if (!empty($this->general_settings->timezone)) {
            date_default_timezone_set($this->general_settings->timezone);
        }
        //lang base url
        $this->lang_base_url = base_url();
        //languages
        $this->languages = $this->config->item('languages');
        //site lang
        $this->site_lang = $this->language_model->get_language($this->general_settings->site_lang);
        if (empty($this->site_lang)) {
            $this->site_lang = $this->language_model->get_first_language();
        }
        $this->selected_lang = $this->site_lang;
        //set language
        $lang_segment = $this->uri->segment(1);
        foreach ($this->languages as $lang) {
            if ($lang_segment == $lang->short_form) {
                if ($this->general_settings->multilingual_system == 1):
                    $this->selected_lang = $lang;
                    $this->lang_base_url = base_url() . $lang->short_form . "/";
                else:
                    redirect(base_url());
                endif;
            }
        }
        //set lang base url
        if ($this->general_settings->site_lang == $this->selected_lang->id) {
            $this->lang_base_url = base_url();
        } else {
            $this->lang_base_url = base_url() . $this->selected_lang->short_form . "/";
        }
        //check language folder
        if (!file_exists(APPPATH . "language/" . $this->selected_lang->folder_name)) {
            echo "Language folder doesn't exists!";
            exit();
        }
        $this->config->set_item('language', $this->selected_lang->folder_name);
        $this->lang->load("site_lang", $this->selected_lang->folder_name);
        //check rtl enabled
        $this->rtl = false;
        if ($this->selected_lang->text_direction == "rtl") {
            $this->rtl = true;
        }
        //check remember
        $this->auth_model->check_remember();
        //check auth
        $this->auth_check = auth_check();
        if ($this->auth_check) {
            $this->auth_user = user();
        }
        //roles and permissions
        $this->roles_permissions = $this->auth_model->get_roles_permissions();
        //settings
        $this->visual_settings = $this->visual_settings_model->get_settings();
        $this->settings = $this->settings_model->get_settings($this->selected_lang->id);
        //get site fonts
        $this->fonts = $this->settings_model->get_selected_fonts();
        //set site color
        $this->site_color = get_site_color();
        //set dark mode
        $this->dark_mode = check_dark_mode_enabled();
        //update last seen
        $this->auth_model->update_last_seen();
    }
}

class Home_Core_Controller extends Core_Controller
{
    public function __construct()
    {
        parent::__construct();

        //maintenance mode
        if ($this->general_settings->maintenance_mode_status == 1) {
            if (!is_admin()) {
                $this->maintenance_mode();
            }
        }

        //menu links
        $this->menu_links = get_cached_data('menu_links');
        if (empty($this->menu_links)) {
            $this->menu_links = $this->navigation_model->get_menu_links($this->selected_lang->id);
            set_cache_data('menu_links', $this->menu_links);
        }
        //categories
        $this->categories = get_cached_data('categories');
        if (empty($this->categories)) {
            $this->categories = get_categories();
            set_cache_data('categories', $this->categories);
        }
        //max post id
        $this->post_max_id = get_cached_data('post_max_id');
        if (empty($this->post_max_id)) {
            $this->post_max_id = $this->post_model->get_posts_max_id();
            set_cache_data('post_max_id', $this->post_max_id);
        }
        //latest category posts
        $this->latest_category_posts = get_cached_data('latest_category_posts');
        if (empty($this->latest_category_posts)) {
            $this->latest_category_posts = $this->post_model->get_latest_category_posts();
            set_cache_data('latest_category_posts', $this->latest_category_posts);
        }
        //random posts
        $this->random_posts = get_cached_data('random_posts');
        if (empty($this->random_posts)) {
            $this->random_posts = $this->post_model->get_random_posts();
            set_cache_data('random_posts', $this->random_posts);
        }
        //widgets
        $this->widgets = get_cached_data('widgets');
        if (empty($this->widgets)) {
            $this->widgets = $this->widget_model->get_widgets();
            set_cache_data('widgets', $this->widgets);
        }
        //random tags
        $this->random_tags = get_cached_data('random_tags');
        if (empty($this->random_tags)) {
            $this->random_tags = $this->tag_model->get_random_tags();
            set_cache_data('random_tags', $this->random_tags);
        }

        $this->polls = $this->poll_model->get_polls();
        $this->ads = $this->ad_model->get_ads();

        //recaptcha status
        $this->recaptcha_status = true;
        if (empty($this->general_settings->recaptcha_site_key) || empty($this->general_settings->recaptcha_secret_key)) {
            $this->recaptcha_status = false;
        }
    }

    //maintenance mode
    public function maintenance_mode()
    {
        $this->load->view('maintenance');
    }

    //verify recaptcha
    public function recaptcha_verify_request()
    {
        if (!$this->recaptcha_status) {
            return true;
        }

        $this->load->library('recaptcha');
        $recaptcha = $this->input->post('g-recaptcha-response');
        if (!empty($recaptcha)) {
            $response = $this->recaptcha->verifyResponse($recaptcha);
            if (isset($response['success']) && $response['success'] === true) {
                return true;
            }
        }
        return false;
    }

    public function paginate($url, $total_rows)
    {
        $per_page = $this->general_settings->pagination_per_page;
        //initialize pagination
        $page = $this->security->xss_clean($this->input->get('page'));
        $page = clean_number($page);
        if (empty($page) || $page < 0) {
            $page = 0;
        }
        if ($page != 0) {
            $page = $page - 1;
        }
        $config['num_links'] = 4;
        $config['base_url'] = $url;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['reuse_query_string'] = true;
        $this->pagination->initialize($config);
        return array('per_page' => $per_page, 'offset' => $page * $per_page, 'current_page' => $page + 1);
    }

}

class Admin_Core_Controller extends Core_Controller
{

    public function __construct()
    {
        parent::__construct();

        if (!auth_check()) {
            redirect(admin_url() . "login");
        }

        //set control panel lang
        $this->control_panel_lang = $this->selected_lang;
        if (!empty($this->session->userdata('vr_control_panel_lang'))) {
            $this->control_panel_lang = $this->session->userdata('vr_control_panel_lang');
            $this->config->set_item('language', $this->control_panel_lang->folder_name);
            $this->lang->load("site_lang", $this->control_panel_lang->folder_name);
        }
        //categories
        $this->categories = $this->category_model->get_categories();
    }

    public function paginate($url, $total_rows)
    {
        //initialize pagination
        $page = $this->security->xss_clean($this->input->get('page'));
        $per_page = $this->input->get('show', true);
        $page = clean_number($page);
        if (empty($page) || $page < 0) {
            $page = 0;
        }

        if ($page != 0) {
            $page = $page - 1;
        }

        if (empty($per_page)) {
            $per_page = 15;
        }

        $config['num_links'] = 4;
        $config['base_url'] = $url;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['reuse_query_string'] = true;
        $this->pagination->initialize($config);

        return array('per_page' => $per_page, 'offset' => $page * $per_page);
    }
}

