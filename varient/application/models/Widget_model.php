<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Widget_model extends CI_Model
{
    //input values
    public function input_values()
    {
        $data = array(
            'lang_id' => $this->input->post('lang_id', true),
            'title' => $this->input->post('title', true),
            'content' => $this->input->post('content', false),
            'widget_order' => $this->input->post('widget_order', true),
            'type' => $this->input->post('type', true),
            'visibility' => $this->input->post('visibility', true),
            'is_custom' => $this->input->post('is_custom', true),
        );
        return $data;
    }

    //add widget
    public function add()
    {
        $data = $this->input_values();
        $data['is_custom'] = 1;
        $data['created_at'] = date('Y-m-d H:i:s');

        return $this->db->insert('widgets', $data);
    }

    //update widget
    public function update($id)
    {
        $data = $this->input_values();
        $this->db->where('id', clean_number($id));
        return $this->db->update('widgets', $data);
    }

    //get widgets
    public function get_widgets()
    {
        $sql = "SELECT * FROM widgets WHERE lang_id =  ? ORDER BY widget_order";
        $query = $this->db->query($sql, array(clean_number($this->selected_lang->id)));
        return $query->result();
    }

    //get widgets by lang
    public function get_widgets_by_lang($lang_id)
    {
        $sql = "SELECT * FROM widgets WHERE lang_id =  ? ORDER BY widget_order";
        $query = $this->db->query($sql, array(clean_number($lang_id)));
        return $query->result();
    }

    //get all widgets
    public function get_all_widgets()
    {
        $sql = "SELECT * FROM widgets ORDER BY widget_order";
        $query = $this->db->query($sql);
        return $query->result();
    }

    //get widget
    public function get_widget($id)
    {
        $sql = "SELECT * FROM widgets WHERE id =  ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->row();
    }

    //delete widget
    public function delete($id)
    {
        $widget = $this->get_widget($id);
        if (!empty($widget)) {
            $this->db->where('id', $widget->id);
            return $this->db->delete('widgets');
        }
        return false;
    }

}