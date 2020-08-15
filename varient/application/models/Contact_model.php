<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_model extends CI_Model
{
    //input values
    public function input_values()
    {
        $data = array(
            'name' => $this->input->post('name', true),
            'email' => $this->input->post('email', true),
            'message' => $this->input->post('message', true)
        );
        return $data;
    }

    //add contact message
    public function add_contact_message()
    {
        $data = $this->input_values();
        //send email
        if ($this->general_settings->mail_contact_status == 1) {
            $this->load->model("email_model");
            $this->email_model->send_email_contact_message($data["name"], $data["email"], $data["message"]);
        }
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('contacts', $data);
    }

    //get contact messages
    public function get_contact_messages()
    {
        $query = $this->db->query("SELECT * FROM contacts ORDER BY contacts.id DESC");
        return $query->result();
    }

    //get contact message
    public function get_contact_message($id)
    {
        $sql = "SELECT * FROM contacts WHERE contacts.id = ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->row();
    }

    //get last contact messages
    public function get_last_contact_messages()
    {
        $query = $this->db->query("SELECT * FROM contacts ORDER BY contacts.id DESC LIMIT 5");
        return $query->result();
    }

    //delete contact message
    public function delete_contact_message($id)
    {
        $contact = $this->get_contact_message($id);
        if (!empty($contact)) {
            $this->db->where('id', $contact->id);
            return $this->db->delete('contacts');
        }
        return false;
    }

    //delete multi contact messages
    public function delete_multi_messages($messages_ids)
    {
        if (!empty($messages_ids)) {
            foreach ($messages_ids as $id) {
                $this->delete_contact_message($id);
            }
        }
    }

}
