<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Post_item_model extends CI_Model
{
    //add post list items
    public function add_post_list_items($post_id, $post_type)
    {
        $titles = $this->input->post('list_item_title', true);
        $orders = $this->input->post('list_item_order', true);
        $images = $this->input->post('list_item_image', true);
        $large_images = $this->input->post('list_item_image_large', true);
        $contents = $this->input->post('list_item_content', false);
        $image_descriptions = $this->input->post('list_item_image_description', true);

        if (!empty($titles)) {
            for ($i = 0; $i < count($titles); $i++) {
                $data = array(
                    'post_id' => $post_id,
                    'title' => !empty($titles[$i]) ? $titles[$i] : '',
                    'content' => !empty($contents[$i]) ? $contents[$i] : '',
                    'image' => !empty($images[$i]) ? $images[$i] : '',
                    'image_large' => !empty($large_images[$i]) ? $large_images[$i] : '',
                    'image_description' => !empty($image_descriptions[$i]) ? $image_descriptions[$i] : '',
                    'item_order' => !empty($orders[$i]) ? $orders[$i] : 1
                );
                //add to database
                if ($post_type == 'gallery') {
                    $this->db->insert('post_gallery_items', $data);
                } elseif ($post_type == 'sorted_list') {
                    $this->db->insert('post_sorted_list_items', $data);
                }
            }
        }
    }

    //update post list items
    public function update_post_list_items($post_id, $post_type)
    {
        $post_list_items = $this->get_post_list_items($post_id, $post_type);
        if (!empty($post_list_items)) {
            foreach ($post_list_items as $post_list_item) {
                $item_order = $this->input->post('list_item_order_' . $post_list_item->id, true);
                if (!isset($item_order)) {
                    $item_order = 1;
                }
                $data = array(
                    'title' => $this->input->post('list_item_title_' . $post_list_item->id, true),
                    'content' => $this->input->post('list_item_content_' . $post_list_item->id, false),
                    'image' => $this->input->post('list_item_image_' . $post_list_item->id, true),
                    'image_large' => $this->input->post('list_item_image_large_' . $post_list_item->id, true),
                    'image_description' => $this->input->post('list_item_image_description_' . $post_list_item->id, true),
                    'item_order' => $item_order
                );
                //update
                if ($post_type == 'gallery') {
                    $this->db->where('id', $post_list_item->id);
                    $this->db->update('post_gallery_items', $data);
                } elseif ($post_type == 'sorted_list') {
                    $this->db->where('id', $post_list_item->id);
                    $this->db->update('post_sorted_list_items', $data);
                }
            }
        }
    }

    //add post list item
    public function add_post_list_item($post_id, $post_type)
    {
        $max_order = $this->get_post_list_max_order($post_id, $post_type);
        if (empty($max_order)) {
            $max_order = 0;
        }
        $data = array(
            'post_id' => $post_id,
            'title' => "",
            'content' => "",
            'image' => "",
            'image_large' => "",
            'image_description' => "",
            'item_order' => $max_order + 1
        );
        //add to database
        if ($post_type == 'gallery') {
            $this->db->insert('post_gallery_items', $data);
        } elseif ($post_type == 'sorted_list') {
            $this->db->insert('post_sorted_list_items', $data);
        }
        return $this->db->insert_id();
    }

    //get post list items
    public function get_post_list_items($post_id, $post_type)
    {
        if ($post_type == 'gallery') {
            $sql = "SELECT post_gallery_items.*, 'gallery' AS item_post_type FROM post_gallery_items WHERE post_id = ? ORDER BY item_order";
        } else {
            $sql = "SELECT post_sorted_list_items.*, 'sorted_list' AS item_post_type FROM post_sorted_list_items WHERE post_id = ? ORDER BY item_order";
        }
        $query = $this->db->query($sql, array(clean_number($post_id)));
        return $query->result();
    }

    //get post list item
    public function get_post_list_item($item_id, $post_type)
    {
        if ($post_type == 'gallery') {
            $sql = "SELECT post_gallery_items.*, 'gallery' AS item_post_type FROM post_gallery_items WHERE id = ?";
        } else {
            $sql = "SELECT post_sorted_list_items.*, 'sorted_list' AS item_post_type FROM post_sorted_list_items WHERE id = ?";
        }
        $query = $this->db->query($sql, array(clean_number($item_id)));
        return $query->row();
    }

    //get gallery post item by order
    public function get_gallery_post_item_by_order($post_id, $order)
    {
        $order = clean_number($order);
        $nth_row = $order - 1;
        if ($nth_row <= 0) {
            $nth_row = 0;
        }
        $sql = "SELECT * FROM post_gallery_items WHERE post_id = ? ORDER BY item_order";
        $query = $this->db->query($sql, array(clean_number($post_id)));
        return $query->row($nth_row);
    }

    //get post list items count
    public function get_post_list_items_count($post_id, $post_type)
    {
        if ($post_type == 'gallery') {
            $sql = "SELECT COUNT(id) AS count FROM post_gallery_items WHERE post_id = ?";
        } else {
            $sql = "SELECT COUNT(id) AS count FROM post_sorted_list_items WHERE post_id = ?";
        }
        $query = $this->db->query($sql, array(clean_number($post_id)));
        return $query->row()->count;
    }

    //get post list max order value
    public function get_post_list_max_order($post_id, $post_type)
    {
        if ($post_type == 'gallery') {
            $sql = "SELECT MAX(item_order) AS max_order FROM post_gallery_items WHERE post_id = ?";
        } else {
            $sql = "SELECT MAX(item_order) AS max_order FROM post_sorted_list_items WHERE post_id = ?";
        }
        $query = $this->db->query($sql, array(clean_number($post_id)));
        return $query->row()->max_order;
    }

    //delete post list item
    public function delete_post_list_item($item_id, $post_type)
    {
        $item = $this->get_post_list_item($item_id, $post_type);
        if (!empty($item)) {
            $post = $this->post_admin_model->get_post($item->post_id);
            if (!empty($post)) {
                if (!check_post_ownership($post->user_id)) {
                    return false;
                }
                if ($post_type == 'gallery') {
                    $this->db->where('id', $item->id);
                    return $this->db->delete('post_gallery_items');
                } else {
                    $this->db->where('id', $item->id);
                    return $this->db->delete('post_sorted_list_items');
                }
            }
        }
        return false;
    }

    //delete post list items
    public function delete_post_list_items($post_id, $post_type)
    {
        $items = $this->get_post_list_items($post_id, $post_type);
        if (!empty($items)) {
            foreach ($items as $item) {
                $this->delete_post_list_item($item->id, $post_type);
            }
        }
    }

}