<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Navigation_model extends CI_Model
{
    //input values
    public function input_values()
    {
        $data = array(
            'lang_id' => $this->input->post('lang_id', true),
            'title' => $this->input->post('title', true),
            'link' => $this->input->post('link', true),
            'page_order' => $this->input->post('page_order', true),
            'visibility' => $this->input->post('visibility', true),
            'parent_id' => $this->input->post('parent_id', true),
            'location' => "main",
            'page_type' => "link",
        );
        return $data;
    }

    //add link
    public function add_link()
    {
        $data = $this->input_values();
        //slug for title
        if (empty($data["slug"])) {
            $data["slug"] = str_slug($data["title"]);
        }
        if (empty($data['link'])) {
            $data['link'] = "#";
        }
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('pages', $data);
    }

    //update link
    public function update_link($id)
    {
        $data = $this->input_values();
        //slug for title
        if (empty($data["slug"])) {
            $data["slug"] = str_slug($data["title"]);
        }
        $this->db->where('id', clean_number($id));
        return $this->db->update('pages', $data);
    }

    //sort menu items
    public function sort_menu_items()
    {
        $json_menu_items = $this->input->post('json_menu_items', true);
        $menu_items = json_decode($json_menu_items);
        foreach ($menu_items as $menu_item) {
            if ($menu_item->item_type == 'page') {
                $page = $this->page_model->get_page_by_id($menu_item->item_id);
                if (!empty($page)) {
                    $data = array(
                        'parent_id' => clean_number($menu_item->parent_id),
                        'page_order' => clean_number($menu_item->new_order)
                    );
                    $this->db->where('id', $page->id);
                    $this->db->update('pages', $data);
                }
            } elseif ($menu_item->item_type == 'category') {
                $category = $this->category_model->get_category($menu_item->item_id);
                if (!empty($category)) {
                    $data = array(
                        'parent_id' => clean_number($menu_item->parent_id),
                        'category_order' => clean_number($menu_item->new_order)
                    );
                    $this->db->where('id', $category->id);
                    $this->db->update('categories', $data);
                }
            }
        }
    }

    //get parent link
    public function get_parent_link($parent_id, $type)
    {
        $parent_id = clean_number($parent_id);
        if ($type == "page" || $type == "link") {
            return $this->page_model->get_page_by_id($parent_id);
        }
        if ($type == "category") {
            return $this->category_model->get_category($parent_id);
        }
    }

    //get menu links
    public function get_menu_links($lang_id)
    {
        $sql = "SELECT * FROM (
        (SELECT categories.id AS item_id, categories.lang_id AS item_lang_id, categories.name AS item_name, categories.name_slug AS item_slug, categories.category_order AS item_order, 'main' 
        AS item_location, 'category' AS item_type, '#' AS item_link, categories.parent_id AS item_parent_id, categories.show_on_menu AS item_visibility FROM categories WHERE categories.lang_id = ?) 
        UNION
        (SELECT pages.id AS item_id, pages.lang_id AS item_lang_id, pages.title AS item_name, pages.slug AS item_slug, pages.page_order AS item_order, pages.location AS item_location, 'page' 
        AS item_type, pages.link AS item_link, pages.parent_id AS item_parent_id, pages.visibility AS item_visibility FROM pages WHERE pages.lang_id = ?)) AS menu_items ORDER BY item_order";
        $query = $this->db->query($sql, array($lang_id, $lang_id));
        return $query->result();
    }

    //get all menu links
    public function get_all_menu_links()
    {
        $sql = "SELECT * FROM (
        (SELECT categories.id AS item_id, categories.lang_id AS item_lang_id, categories.name AS item_name, categories.name_slug AS item_slug, categories.category_order AS item_order, 'main' 
        AS item_location, 'category' AS item_type, '#' AS item_link, categories.parent_id AS item_parent_id, categories.show_on_menu AS item_visibility FROM categories) 
        UNION
        (SELECT pages.id AS item_id, pages.lang_id AS item_lang_id, pages.title AS item_name, pages.slug AS item_slug, pages.page_order AS item_order, pages.location AS item_location, 'page' 
        AS item_type, pages.link AS item_link, pages.parent_id AS item_parent_id, pages.visibility AS item_visibility FROM pages)) AS menu_items ORDER BY item_order";
        $query = $this->db->query($sql);
        return $query->result();
    }

    //hide show home link
    public function hide_show_home_link()
    {
        if ($this->general_settings->show_home_link == 1) {
            $data = array(
                'show_home_link' => 0
            );
        }else{
            $data = array(
                'show_home_link' => 1
            );
        }
        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update menu limit
    public function update_menu_limit()
    {
        $data = array(
            'menu_limit' => $this->input->post('menu_limit', true),
        );
        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }
}