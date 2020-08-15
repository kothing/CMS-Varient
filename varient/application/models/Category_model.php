<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model
{
    //input values
    public function input_values()
    {
        $data = array(
            'lang_id' => $this->input->post('lang_id', true),
            'name' => $this->input->post('name', true),
            'name_slug' => $this->input->post('name_slug', true),
            'parent_id' => $this->input->post('parent_id', true),
            'description' => $this->input->post('description', true),
            'keywords' => $this->input->post('keywords', true),
            'color' => $this->input->post('color', true),
            'category_order' => $this->input->post('category_order', true),
            'show_at_homepage' => $this->input->post('show_at_homepage', true),
            'show_on_menu' => $this->input->post('show_on_menu', true),
            'block_type' => $this->input->post('block_type', true),
        );
        return $data;
    }

    //add category
    public function add_category()
    {
        $data = $this->input_values();
        if (empty($data["name_slug"])) {
            //slug for title
            $data["name_slug"] = str_slug($data["name"]);
        } else {
            $data["name_slug"] = remove_special_characters($data["name_slug"], true);
        }
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('categories', $data);
    }

    //add subcategory
    public function add_subcategory()
    {
        $data = $this->input_values();

        $category = $this->get_category($data["parent_id"]);
        if ($category) {
            $data["color"] = $category->color;
        } else {
            $data["color"] = "#0a0a0a";
        }

        if (empty($data["name_slug"])) {
            //slug for title
            $data["name_slug"] = str_slug($data["name"]);
        } else {
            $data["name_slug"] = remove_special_characters($data["name_slug"], true);
        }
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('categories', $data);
    }

    //update slug
    public function update_slug($id)
    {
        $category = $this->get_category($id);
        if (!empty($category)) {
            if (empty($category->name_slug) || $category->name_slug == "-") {
                $data = array(
                    'name_slug' => $category->id
                );
                $this->db->where('id', $category->id);
                $this->db->update('categories', $data);
            } else {
                if ($this->check_slug_exists($category->name_slug, $category->id) == true) {
                    $data = array(
                        'name_slug' => $category->name_slug . "-" . $category->id
                    );
                    $this->db->where('id', $id);
                    $this->db->update('categories', $data);
                }
            }
        }
    }

    //check slug
    public function check_slug_exists($slug, $id)
    {
        $sql = "SELECT * FROM categories WHERE categories.name_slug = ? AND categories.id != ?";
        $query = $this->db->query($sql, array(clean_str($slug), clean_number($id)));
        if (!empty($query->row())) {
            return true;
        }
        return false;
    }

    //get category
    public function get_category($id)
    {
        $sql = "SELECT categories.*, (SELECT name_slug FROM categories AS tbl_categories WHERE tbl_categories.id = categories.parent_id) as parent_slug FROM categories WHERE categories.id =  ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->row();
    }

    //get category by slug
    public function get_category_by_slug($slug)
    {
        $sql = "SELECT categories.*, (SELECT name_slug FROM categories AS tbl_categories WHERE tbl_categories.id = categories.parent_id) as parent_slug FROM categories WHERE categories.name_slug =  ?";
        $query = $this->db->query($sql, array(clean_str($slug)));
        return $query->row();
    }

    //get parent categories
    public function get_parent_categories()
    {
        $query = $this->db->query("SELECT * FROM categories WHERE categories.parent_id = 0");
        return $query->result();
    }

    //get parent categories by lang
    public function get_parent_categories_by_lang($lang_id)
    {
        $sql = "SELECT * FROM categories WHERE categories.parent_id = 0 AND categories.lang_id =  ?";
        $query = $this->db->query($sql, array(clean_number($lang_id)));
        return $query->result();
    }

    //get categories
    public function get_categories()
    {
        $query = $this->db->query("SELECT categories.*, (SELECT name_slug FROM categories AS tbl_categories WHERE tbl_categories.id = categories.parent_id) as parent_slug FROM categories ORDER BY category_order");
        return $query->result();
    }

    //get categories by lang
    public function get_categories_by_lang($lang_id)
    {
        $sql = "SELECT categories.*, (SELECT name_slug FROM categories AS tbl_categories WHERE tbl_categories.id = categories.parent_id) as parent_slug FROM categories WHERE categories.lang_id =  ? ORDER BY category_order";
        $query = $this->db->query($sql, array(clean_number($lang_id)));
        return $query->result();
    }

    //get subcategories
    public function get_subcategories()
    {
        $query = $this->db->query("SELECT * FROM categories WHERE categories.parent_id != 0");
        return $query->result();
    }

    //get subcategories by lang
    public function get_subcategories_by_lang($lang_id)
    {
        $sql = "SELECT * FROM categories WHERE categories.parent_id != 0 AND categories.lang_id =  ?";
        $query = $this->db->query($sql, array(clean_number($lang_id)));
        return $query->result();
    }

    //get subcategories by parent id
    public function get_subcategories_by_parent_id($parent_id)
    {
        $sql = "SELECT * FROM categories WHERE categories.parent_id = ?";
        $query = $this->db->query($sql, array(clean_number($parent_id)));
        return $query->result();
    }

    //get category count
    public function get_category_count()
    {
        $sql = "SELECT COUNT(categories.id) AS count FROM categories";
        $query = $this->db->query($sql);
        return $query->row()->count;
    }

    //update category
    public function update_category($id)
    {
        $id = clean_number($id);
        $data = $this->input_values();
        if (empty($data["name_slug"])) {
            //slug for title
            $data["name_slug"] = str_slug($data["name"]);
        } else {
            $data["name_slug"] = remove_special_characters($data["name_slug"], true);
        }

        $category = $this->get_category($id);
        //check if parent
        if ($category->parent_id == 0) {
            $this->update_subcategories_color($id, $data["color"]);
        } else {
            $parent = $this->get_category($data["parent_id"]);
            if ($parent) {
                $data["color"] = $parent->color;
            } else {
                $data["color"] = "#0a0a0a";
            }
        }

        $this->db->where('id', $id);
        return $this->db->update('categories', $data);
    }

    //update subcategory color
    public function update_subcategories_color($parent_id, $color)
    {
        $categories = $this->get_subcategories_by_parent_id($parent_id);
        if (!empty($categories)) {
            foreach ($categories as $item) {
                $data = array(
                    'color' => $color,
                );
                $this->db->where('parent_id', $parent_id);
                return $this->db->update('categories', $data);
            }
        }
    }

    //delete category
    public function delete_category($id)
    {
        $category = $this->get_category($id);
        if (!empty($category)) {
            $this->db->where('id', $category->id);
            return $this->db->delete('categories');
        } else {
            return false;
        }
    }

}