<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Page_model extends CI_Model
{
    //input values
    public function input_values()
    {
        $data = array(
            'lang_id' => $this->input->post('lang_id', true),
            'title' => $this->input->post('title', true),
            'slug' => $this->input->post('slug', true),
            'description' => $this->input->post('description', true),
            'keywords' => $this->input->post('keywords', true),
            'page_content' => $this->input->post('page_content', false),
            'page_order' => $this->input->post('page_order', true),
            'parent_id' => $this->input->post('parent_id', true),
            'visibility' => $this->input->post('visibility', true),
            'title_active' => $this->input->post('title_active', true),
            'breadcrumb_active' => $this->input->post('breadcrumb_active', true),
            'right_column_active' => $this->input->post('right_column_active', true),
            'need_auth' => $this->input->post('need_auth', true),
            'location' => $this->input->post('location', true),
            'page_type' => "page",
        );
        return $data;
    }

    //add page
    public function add()
    {
        $data = $this->page_model->input_values();

        if (empty($data["slug"])) {
            //slug for title
            $data["slug"] = str_slug($data["title"]);
            if (empty($data["slug"])) {
                $data["slug"] = "page-" . uniqid();
            }
        } else {
            $data["slug"] = remove_special_characters($data["slug"], true);
        }
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('pages', $data);
    }

    //update page
    public function update($id)
    {
        //set values
        $data = $this->page_model->input_values();
        if (empty($data["slug"])) {
            //slug for title
            $data["slug"] = str_slug($data["title"]);
            if (empty($data["slug"])) {
                $data["slug"] = "page-" . uniqid();
            }
        } else {
            $data["slug"] = remove_special_characters($data["slug"], true);
        }

        $page = $this->get_page_by_id($id);
        if (!empty($page)) {
            $this->db->where('id', $page->id);
            return $this->db->update('pages', $data);
        }
        return false;
    }

    //get pages
    public function get_pages()
    {
        $query = $this->db->query("SELECT * FROM pages ORDER BY page_order");
        return $query->result();
    }

    //get pages
    public function get_pages_by_lang($lang_id)
    {
        $sql = "SELECT * FROM pages WHERE lang_id =  ? ORDER BY page_order";
        $query = $this->db->query($sql, array(clean_number($lang_id)));
        return $query->result();
    }

    //get page
    public function get_page($slug)
    {
        $sql = "SELECT * FROM pages WHERE slug =  ?";
        $query = $this->db->query($sql, array(clean_str($slug)));
        return $query->row();
    }

    //get page by lang
    public function get_page_by_lang($slug, $lang_id)
    {
        $sql = "SELECT * FROM pages WHERE lang_id = ? AND slug =  ?";
        $query = $this->db->query($sql, array(clean_number($lang_id), clean_str($slug)));
        return $query->row();
    }

    //get page by default name
    public function get_page_by_default_name($default_name, $lang_id)
    {
        $sql = "SELECT * FROM pages WHERE page_default_name =  ? AND lang_id = ?";
        $query = $this->db->query($sql, array(clean_str($default_name), clean_number($lang_id)));
        return $query->row();
    }

    //get page by id
    public function get_page_by_id($id)
    {
        $sql = "SELECT * FROM pages WHERE id =  ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->row();
    }

    //get subpages
    public function get_subpages($parent_id)
    {
        $sql = "SELECT * FROM pages WHERE parent_id = ?";
        $query = $this->db->query($sql, array(clean_number($parent_id)));
        return $query->result();
    }

    //delete page
    public function delete($id)
    {
        $page = $this->get_page_by_id($id);
        if (!empty($page)) {
            $this->db->where('id', $page->id);
            return $this->db->delete('pages');
        }
        return false;
    }
}