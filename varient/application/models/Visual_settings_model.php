<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Visual_settings_model extends CI_Model
{
    //input values
    public function input_values()
    {
        $data = array(
            'post_list_style' => $this->input->post('post_list_style', true),
            'site_color' => $this->input->post('site_color', true),
            'site_block_color' => $this->input->post('site_block_color', true),
        );
        return $data;
    }

    //get settings
    public function get_settings()
    {
        $query = $this->db->query("SELECT * FROM visual_settings WHERE id = 1");
        return $query->row();
    }

    //update settings
    public function update_settings()
    {
        $data = $this->visual_settings_model->input_values();

        $data_user = array(
            'site_color' => $data['site_color']
        );
        $this->db->where('id', clean_number($this->auth_user->id));
        $this->db->update('users', $data_user);

        $this->load->model('upload_model');
        $logo_path = $this->upload_model->logo_upload('logo');
        $logo_footer_path = $this->upload_model->logo_upload('logo_footer');
        $logo_email_path = $this->upload_model->logo_upload('logo_email');
        $favicon_path = $this->upload_model->favicon_upload('favicon');
        if (!empty($logo_path)) {
            $data["logo"] = $logo_path;
        }
        if (!empty($logo_footer_path)) {
            $data["logo_footer"] = $logo_footer_path;
        }
        if (!empty($logo_email_path)) {
            $data["logo_email"] = $logo_email_path;
        }
        if (!empty($favicon_path)) {
            $data["favicon"] = $favicon_path;
        }

        $this->db->where('id', 1);
        return $this->db->update('visual_settings', $data);
    }

}