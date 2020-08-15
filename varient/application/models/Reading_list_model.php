<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reading_list_model extends CI_Model
{
    //add to reading list
    public function add_to_reading_list($post_id)
    {
        if ($this->auth_check && !empty($post_id)) {
            $data = array(
                'post_id' => clean_number($post_id),
                'user_id' => $this->auth_user->id,
                'created_at' => date('Y-m-d H:i:s')
            );
            return $this->db->insert('reading_lists', $data);
        }
        return false;
    }

    //delete from reading list
    public function delete_from_reading_list($post_id)
    {
        if ($this->auth_check && !empty($post_id)) {
            $this->db->where('post_id', clean_number($post_id));
            $this->db->where('user_id', $this->auth_user->id);
            return $this->db->delete('reading_lists');
        }
        return false;
    }

    //get reading list post ids
    public function get_reading_list_post_ids()
    {
        $sql = "SELECT posts.id FROM posts INNER JOIN reading_lists ON posts.id = reading_lists.post_id WHERE reading_lists.user_id = ?";
        $query = $this->db->query($sql, array(clean_number($this->auth_user->id)));
        $result = $query->result();
        $post_ids = array();
        if (!empty($result)) {
            $post_ids = array_map(function ($item) {
                return $item->id;
            }, $result);
        }
        return $post_ids;
    }

    //get paginated reading list posts
    public function get_paginated_reading_list_posts($offset, $per_page)
    {
        $ids_string = generate_ids_string($this->get_reading_list_post_ids());
        $sql = "SELECT * FROM (" . $this->post_model->query_string() . " AND posts.id IN({$ids_string}) ORDER BY posts.created_at DESC LIMIT ?,?) AS table_posts";
        $query = $this->db->query($sql, array(clean_number($offset), clean_number($per_page)));
        return $query->result();
    }

    //get paginated reading list posts count
    public function get_reading_list_posts_count()
    {
        $ids_string = generate_ids_string($this->get_reading_list_post_ids());
        $sql = "SELECT COUNT(table_posts.id) AS count FROM (" . $this->post_model->query_string() . " AND posts.id IN({$ids_string})) AS table_posts";
        $query = $this->db->query($sql);
        return $query->row()->count;
    }

    //check post is in the reading list or not
    public function is_post_in_reading_list($post_id)
    {
        if ($this->auth_check) {
            $post_ids = $this->get_reading_list_post_ids();
            if (in_array(clean_number($post_id), $post_ids)) {
                return true;
            }
        }
        return false;
    }

}