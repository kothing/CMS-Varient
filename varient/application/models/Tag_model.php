<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tag_model extends CI_Model
{
    //add post tags
    public function add_post_tags($post_id)
    {
        //tags
        $tags = trim($this->input->post('tags', true));

        $tags_array = explode(",", $tags);
        if (!empty($tags_array)) {
            foreach ($tags_array as $tag) {
                $tag = trim($tag);
                if (strlen($tag) > 1) {
                    $data = array(
                        'post_id' => clean_number($post_id),
                        'tag' => trim($tag),
                        'tag_slug' => str_slug(trim($tag))
                    );
                    if (empty($data["tag_slug"]) || $data["tag_slug"] == "-") {
                        $data["tag_slug"] = "tag-" . uniqid();
                    }
                    //insert tag
                    $this->db->insert('tags', $data);
                }
            }
        }
    }

    //update post tags
    public function update_post_tags($post_id)
    {
        //delete old tags
        $this->delete_post_tags($post_id);
        //add new tags
        $tags = trim($this->input->post('tags', true));

        $tags_array = explode(",", $tags);
        if (!empty($tags_array)) {
            foreach ($tags_array as $tag) {
                $tag = trim($tag);
                if (strlen($tag) > 1) {
                    $data = array(
                        'post_id' => clean_number($post_id),
                        'tag' => trim($tag),
                        'tag_slug' => str_slug(trim($tag))
                    );

                    if (empty($data["tag_slug"]) || $data["tag_slug"] == "-") {
                        $data["tag_slug"] = "tag-" . uniqid();
                    }
                    //insert tag
                    $this->db->insert('tags', $data);
                }
            }
        }
    }

    //get random tags
    public function get_random_tags()
    {
        $this->db->join('posts', 'posts.id = tags.post_id');
        $this->db->join('users', 'posts.user_id = users.id');
        $this->db->select('tags.tag_slug, tags.tag');
        $this->db->group_by('tags.tag_slug, tags.tag');
        $this->db->where('posts.status', 1);
        $this->db->where('posts.lang_id', clean_number($this->selected_lang->id));
        $this->db->where('posts.visibility', 1);
        $this->db->where('posts.is_scheduled', 0);
        $this->db->order_by('rand()');
        $this->db->limit(15);
        $query = $this->db->get('tags');
        return $query->result();
    }

    //get tags
    public function get_tags()
    {
        $this->db->join('posts', 'posts.id = tags.post_id');
        $this->db->join('users', 'posts.user_id = users.id');
        $this->db->select('tags.tag_slug, tags.tag');
        $this->db->group_by('tags.tag_slug, tags.tag');
        $this->db->order_by('tags.tag');
        $this->db->where('posts.status', 1);
        $this->db->where('posts.lang_id', clean_number($this->selected_lang->id));
        $this->db->where('posts.visibility', 1);
        $this->db->where('posts.is_scheduled', 0);
        $query = $this->db->get('tags');
        return $query->result();
    }

    //get sitemap tags
    public function get_sitemap_tags()
    {
        $this->db->join('posts', 'posts.id = tags.post_id');
        $this->db->join('users', 'posts.user_id = users.id');
        $this->db->select('tags.tag_slug, tags.tag');
        $this->db->group_by('tags.tag_slug, tags.tag');
        $this->db->order_by('tags.tag');
        $this->db->where('posts.status', 1);
        $this->db->where('posts.visibility', 1);
        $this->db->where('posts.is_scheduled', 0);
        $this->db->limit(5000);
        $query = $this->db->get('tags');
        return $query->result();
    }

    //get tag
    public function get_tag($tag_slug)
    {
        $this->db->join('posts', 'posts.id = tags.post_id');
        $this->db->join('users', 'posts.user_id = users.id');
        $this->db->select('tags.*, posts.lang_id as tag_lang_id');
        $this->db->order_by('tags.tag');
        $this->db->where('tags.tag_slug', clean_str($tag_slug));
        $this->db->where('posts.status', 1);
        $this->db->where('posts.visibility', 1);
        $this->db->where('posts.is_scheduled', 0);
        $query = $this->db->get('tags');
        return $query->row();
    }

    //get posts tags
    public function get_post_tags($post_id)
    {
        $sql = "SELECT * FROM tags WHERE post_id = ?";
        $query = $this->db->query($sql, array(clean_number($post_id)));
        return $query->result();
    }

    //get posts tags string
    public function get_post_tags_string($post_id)
    {
        $str = "";
        $count = 0;
        $tags_array = $this->get_post_tags($post_id);
        foreach ($tags_array as $item) {
            if ($count > 0) {
                $str .= ",";
            }
            $str .= $item->tag;
            $count++;
        }
        return $str;
    }

    //delete tags
    public function delete_post_tags($post_id)
    {
        $tags = $this->get_post_tags($post_id);
        if (!empty($tags)) {
            foreach ($tags as $tag) {
                //delete
                $this->db->where('id', $tag->id);
                $this->db->delete('tags');
            }
        }
    }

}