<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery_category_model extends CI_Model
{
    //input values
    public function input_values()
    {
        $data = array(
            'lang_id' => $this->input->post('lang_id', true),
            'album_id' => $this->input->post('album_id', true),
            'name' => $this->input->post('name', true)
        );
        return $data;
    }

    //add category
    public function add()
    {
        $data = $this->input_values();
        return $this->db->insert('gallery_categories', $data);
    }

    //get all gallery categories
    public function get_all_categories()
    {
        $query = $this->db->query("SELECT * FROM gallery_categories ORDER BY id DESC");
        return $query->result();
    }

    //get gallery categories
    public function get_categories_by_selected_lang()
    {
        $sql = "SELECT * FROM gallery_categories WHERE lang_id = ?";
        $query = $this->db->query($sql, array(clean_number($this->selected_lang->id)));
        return $query->result();
    }

    //get gallery categories by lang
    public function get_categories_by_lang($lang_id)
    {
        $sql = "SELECT * FROM gallery_categories WHERE lang_id = ?";
        $query = $this->db->query($sql, array(clean_number($lang_id)));
        return $query->result();
    }

    //get gallery categories by album
    public function get_categories_by_album($album_id)
    {
        $sql = "SELECT * FROM gallery_categories WHERE album_id = ?";
        $query = $this->db->query($sql, array(clean_number($album_id)));
        return $query->result();
    }

    //get category count
    public function get_category_count()
    {
        $sql = "SELECT COUNT(id) AS count FROM gallery_categories WHERE lang_id = ?";
        $query = $this->db->query($sql, array(clean_number($lang_id)));
        return $query->row()->count;
    }

    //get category
    public function get_category($id)
    {
        $sql = "SELECT * FROM gallery_categories WHERE id = ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->row();
    }

    //update category
    public function update($id)
    {
        $id = clean_number($id);
        $data = $this->input_values();

        $this->db->where('id', $id);
        return $this->db->update('gallery_categories', $data);
    }

    //delete category
    public function delete($id)
    {
        $category = $this->get_category($id);
        if (!empty($category)) {
            $this->db->where('id', $category->id);
            return $this->db->delete('gallery_categories');
        } else {
            return false;
        }
    }

    /*
     * ------------------------------------------------------------------------------
     * GALLERY ALBUMS
     * ------------------------------------------------------------------------------
     */

    //add album
    public function add_album()
    {
        $data = array(
            'lang_id' => $this->input->post('lang_id', true),
            'name' => $this->input->post('name', true)
        );
        return $this->db->insert('gallery_albums', $data);
    }

    //update album
    public function update_album($id)
    {
        $data = array(
            'lang_id' => $this->input->post('lang_id', true),
            'name' => $this->input->post('name', true)
        );
        $this->db->where('id', $id);
        return $this->db->update('gallery_albums', $data);
    }

    //get albums
    public function get_albums()
    {
        $query = $this->db->query("SELECT * FROM gallery_albums ORDER BY id DESC");
        return $query->result();
    }

    //get albums by lang
    public function get_albums_by_lang($lang_id)
    {
        $sql = "SELECT * FROM gallery_albums WHERE lang_id = ?";
        $query = $this->db->query($sql, array(clean_number($lang_id)));
        return $query->result();
    }

    //get album category count
    public function get_album_category_count($album_id)
    {
        $sql = "SELECT COUNT(id) AS count FROM gallery_categories WHERE lang_id = ? AND album_id= ?";
        $query = $this->db->query($sql, array(clean_number($this->selected_lang->id), clean_number($album_id)));
        return $query->row()->count;
    }

    //get album
    public function get_album($id)
    {
        $sql = "SELECT * FROM gallery_albums WHERE id = ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->row();
    }

    //delete album
    public function delete_album($id)
    {
        $album = $this->get_album($id);
        if (!empty($album)) {
            $this->db->where('id', $album->id);
            return $this->db->delete('gallery_albums');
        }
        return false;
    }

}