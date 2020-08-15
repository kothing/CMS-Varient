<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Page_controller extends Admin_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_permission('pages');
    }

    /**
     * Add Page
     */
    public function add_page()
    {
        $data['title'] = trans("add_page");
        $data['menu_links'] = $this->navigation_model->get_menu_links($this->selected_lang->id);
        $data['admin_settings'] = $this->post_admin_model;
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/page/add', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Add Page Post
     */
    public function add_page_post()
    {
        //validate inputs
        $this->form_validation->set_rules('title', trans("title"), 'required|xss_clean|max_length[500]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->page_model->input_values());
            redirect($this->agent->referrer());
        } else {
            if ($this->page_model->add()) {
                $this->session->set_flashdata('success', trans("page") . " " . trans("msg_suc_added"));
                reset_cache_data_on_change();
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('form_data', $this->page_model->input_values());
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }

    /**
     * Pages
     */
    public function pages()
    {
        $data['title'] = trans("pages");
        $data['pages'] = $this->page_model->get_pages();
        $data['lang_search_column'] = 2;

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/page/pages', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Update Page
     */
    public function update_page($id)
    {
        $data['title'] = trans("update_page");
        //find page
        $data['page'] = $this->page_model->get_page_by_id($id);
        $data['admin_settings'] = $this->post_admin_model;
        //page not found
        if (empty($data['page'])) {
            redirect($this->agent->referrer());
        }
        $data['menu_links'] = $this->navigation_model->get_menu_links($data['page']->lang_id);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/page/update', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Update Page Post
     */
    public function update_page_post()
    {
        //validate inputs
        $this->form_validation->set_rules('title', trans("title"), 'required|xss_clean|max_length[500]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->page_model->input_values());
            redirect($this->agent->referrer());
        } else {
            //get id
            $id = $this->input->post('id', true);
            $redirect_url = $this->input->post('redirect_url', true);

            if ($this->page_model->update($id)) {
                $this->session->set_flashdata('success', trans("page") . " " . trans("msg_suc_updated"));
                reset_cache_data_on_change();
                if (!empty($redirect_url)) {
                    redirect($redirect_url);
                } else {
                    redirect(admin_url() . 'pages');
                }
            } else {
                $this->session->set_flashdata('form_data', $this->page_model->input_values());
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }

    /**
     * Delete Page Post
     */
    public function delete_page_post()
    {
        $id = $this->input->post('id', true);
        $page = $this->page_model->get_page_by_id($id);
        if (empty($page)) {
            redirect($this->agent->referrer());
        }
        //check if page custom or not
        if ($page->is_custom == 0) {
            $lang = $this->language_model->get_language($page->lang_id);
            if (!empty($lang)) {
                $this->session->set_flashdata('error', trans("msg_page_delete"));
            }
        } else {
            if (count($this->page_model->get_subpages($id)) > 0) {
                $this->session->set_flashdata('error', trans("msg_delete_subpages"));
                exit();
            }
            if ($this->page_model->delete($id)) {
                $this->session->set_flashdata('success', trans("page") . " " . trans("msg_suc_deleted"));
                reset_cache_data_on_change();
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
            }
        }
    }

}