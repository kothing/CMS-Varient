<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Newsletter_model extends CI_Model
{
    //add to subscriber
    public function add_subscriber($email)
    {
        $data = array(
            'email' => $email
        );
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('subscribers', $data);
    }

    //update subscriber token
    public function update_subscriber_token($email)
    {
        $subscriber = $this->get_subscriber($email);
        if (!empty($subscriber)) {
            if (empty($subscriber->token)) {
                $data = array(
                    'token' => generate_unique_id()
                );
                $this->db->where('email', $email);
                $this->db->update('subscribers', $data);
            }
        }
    }

    //get subscribers
    public function get_subscribers()
    {
        $query = $this->db->query("SELECT * FROM subscribers ORDER BY id DESC");
        return $query->result();
    }

    //get subscriber
    public function get_subscriber($email)
    {
        $sql = "SELECT * FROM subscribers WHERE email =  ?";
        $query = $this->db->query($sql, array(clean_str($email)));
        return $query->row();
    }

    //get subscriber by id
    public function get_subscriber_by_id($id)
    {
        $sql = "SELECT * FROM subscribers WHERE id =  ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->row();
    }

    //delete from subscribers
    public function delete_from_subscribers($id)
    {
        $this->db->where('id', clean_number($id));
        return $this->db->delete('subscribers');
    }

    //get subscriber by token
    public function get_subscriber_by_token($token)
    {
        $sql = "SELECT * FROM subscribers WHERE token =  ?";
        $query = $this->db->query($sql, array(clean_str($token)));
        return $query->row();
    }

    //unsubscribe email
    public function unsubscribe_email($email)
    {
        $this->db->where('email', clean_str($email));
        $this->db->delete('subscribers');
    }
}