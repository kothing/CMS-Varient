<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Language_controller extends Admin_Core_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_permission('settings');
    }

    /**
     * Languages
     */
    public function languages()
    {
        $data["title"] = trans("language_settings");
        $data["languages"] = $this->language_model->get_languages();
        $data['language_translations'] =$this->language_model;

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/language/languages', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Set Language Post
     */
    public function set_language_post()
    {
        if ($this->language_model->set_language()) {
            $this->session->set_flashdata('success_form', trans("language") . " " . trans("msg_suc_updated"));
            $this->session->set_flashdata("mes_set_language", 1);
            redirect($this->agent->referrer());
        } else {
            $this->session->set_flashdata('form_data', $this->language_model->input_values());
            $this->session->set_flashdata('error_form', trans("msg_error"));
            $this->session->set_flashdata("mes_set_language", 1);
            redirect($this->agent->referrer());
        }
    }

    /**
     * Add Language Post
     */
    public function add_language_post()
    {
        //validate inputs
        $this->form_validation->set_rules('name', trans("language_name"), 'required|xss_clean|max_length[200]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors_form', validation_errors());
            $this->session->set_flashdata('form_data', $this->language_model->input_values());
            redirect($this->agent->referrer());
        } else {
            if ($this->language_model->add_language()) {
                //last id
                $last_id = $this->db->insert_id();
                $this->language_model->add_language_rows($last_id);

                $this->session->set_flashdata('success_form', trans("language") . " " . trans("msg_suc_added"));
                redirect($this->agent->referrer());
            } else {
                $this->session->set_flashdata('form_data', $this->language_model->input_values());
                $this->session->set_flashdata('error_form', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }

    /**
     * Update Language
     */
    public function update_language($id)
    {
        $data['title'] = trans("update_language");
        $data['language_translations'] =$this->language_model;
        //get language
        $data['language'] = $this->language_model->get_language($id);
        if (empty($data['language'])) {
            redirect($this->agent->referrer());
        }
        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/language/update_language', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Update Language Post
     */
    public function update_language_post()
    {
        //validate inputs
        $this->form_validation->set_rules('name', trans("language_name"), 'required|xss_clean|max_length[200]');

        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('errors', validation_errors());
            $this->session->set_flashdata('form_data', $this->language_model->input_values());
            redirect($this->agent->referrer());
        } else {

            $id = $this->input->post('id', true);

            if ($this->language_model->update_language($id)) {
                $this->session->set_flashdata('success', trans("language") . " " . trans("msg_suc_updated"));
                redirect(admin_url() . 'language-settings');
            } else {
                $this->session->set_flashdata('form_data', $this->language_model->input_values());
                $this->session->set_flashdata('error', trans("msg_error"));
                redirect($this->agent->referrer());
            }
        }
    }

    /**
     * Delete Language Post
     */
    public function delete_language_post()
    {
        $id = $this->input->post('id', true);
        $language = $this->language_model->get_language($id);

        if ($language->folder_name == "default") {
            $this->session->set_flashdata('error', trans("msg_language_delete"));
        } else {
            if ($this->language_model->delete_language($id)) {
                $this->session->set_flashdata('success', trans("language") . " " . trans("msg_suc_deleted"));
            } else {
                $this->session->set_flashdata('error', trans("msg_error"));
            }
        }
    }

    /**
     * Update Phrases
     */
    public function update_phrases($id)
    {
        $data['title'] = trans('edit_translations');
        //get language
        $data['language'] = $this->language_model->get_language($id);
        if (empty($data['language'])) {
            redirect($this->agent->referrer());
        }
        $data['page'] = $this->input->get('page', true);
        if (empty($data['page'])) {
            redirect(admin_url() . "update-phrases/" . $id . "?page=1");
        }
        $data["phrases"] = $this->language_model->get_phrases($data['language']->folder_name);
        $data["tab_count"] = ceil(count($data["phrases"]) / 50);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/language/phrases', $data);
        $this->load->view('admin/includes/_footer');
    }

    /**
     * Update Phrases Post
     */
    public function update_phrases_post()
    {
        $id = $this->input->post("id");
        $data['language'] = $this->language_model->get_language($id);

        if (empty($data['language'])) {
            redirect($this->agent->referrer());
        }

        $phrases = $this->input->post(array('phrase'));
        $labels = $this->input->post(array('label'));

        $this->language_model->update_language_file($data['language']->folder_name, $phrases, $labels);

        $this->session->set_flashdata('success', trans("phrases") . " " . trans("msg_suc_updated"));
        sleep(3);
        redirect($this->agent->referrer());
    }

    /**
     * Search Phrases
     */
    public function search_phrases()
    {
        $id = trim($this->input->get('id', TRUE));
        $data["q"] = trim($this->input->get('q', TRUE));
        if (empty($data['q'])) {
            redirect($this->agent->referrer());
        }

        $data['title'] = trans('edit_translations');

        //get language
        $data['language'] = $this->language_model->get_language($id);

        if (empty($data['language'])) {
            redirect($this->agent->referrer());
        }
        $data["phrases"] = $this->language_model->search_phrases($data['language']->folder_name, $data["q"]);

        $this->load->view('admin/includes/_header', $data);
        $this->load->view('admin/language/search_phrases', $data);
        $this->load->view('admin/includes/_footer');
    }

}
