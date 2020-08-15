<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Widget_controller extends Admin_Core_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_permission('widgets');
    }

    /**
     * Add Widget
     */
    public function add_widget()
    {
        $data['title'] = trans("add_widget");
        $data['admin_settings'] = $this->post_admin_model;
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/widget/add', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Widgets
     */
    public function widgets()
    {
        $data['title'] = trans("widgets");
        $data['widgets'] = $this->widget_model->get_all_widgets();
        $data['lang_search_column'] = 2;
        $data['admin_settings'] = $this->post_admin_model;

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/widget/widgets', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Add Widget Post
     */
    public function add_widget_post()
    {
        //validate inputs
        $this->form_validation->set_rules('title', trans("title"), 'required|xss_clean|max_length[400]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->widget_model->input_values());
            redirect($this->agent->referrer());
        } else {
            if ($this->widget_model->add()) {
                $this->session->set_flashdata('success', trans("widget") . " " . trans("msg_suc_added"));
                reset_cache_data_on_change();
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('form_data', $this->widget_model->input_values());
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }

    /**
     * Update Widget
     */
    public function update_widget($id)
    {
        $data['title'] = trans("update_widget");
        //get widget
        $data['widget'] = $this->widget_model->get_widget($id);
        if (empty($data['widget'])) {
            redirect($this->agent->referrer());
        }
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/widget/update', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Update Widget Post
     */
    public function update_widget_post()
    {
        //widget id
        $id = $this->input->post('id', true);
        //validate inputs
        $this->form_validation->set_rules('title', trans("title"), 'required|xss_clean|max_length[400]');
        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->widget_model->input_values());
            redirect($this->agent->referrer());
        } else {
            if ($this->widget_model->update($id)) {
                $this->session->set_flashdata('success', trans("widget") . " " . trans("msg_suc_updated"));
                reset_cache_data_on_change();
                redirect(admin_url() . "widgets");
            } else {
                $this->session->set_flashdata('form_data', $this->widget_model->input_values());
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }

    /**
     * Delete Widget Post
     */
    public function delete_widget_post()
    {
        $id = $this->input->post('id', true);
        $widget = $this->widget_model->get_widget($id);
        //check if widget custom or not
        if ($widget->is_custom == 0) {
            $lang = $this->language_model->get_language($widget->lang_id);
            if (!empty($lang)) {
                $this->session->set_flashdata('error', trans("msg_widget_delete"));
            }
        } else {
            if ($this->widget_model->delete($id)) {
                $this->session->set_flashdata('success', trans("widget") . " " . trans("msg_suc_deleted"));
                reset_cache_data_on_change();
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
            }
        }
    }

}
