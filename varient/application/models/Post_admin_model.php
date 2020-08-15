<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Post_admin_model extends CI_Model
{
    //input values
    public function input_values()
    {
        $data = array(
            'lang_id' => $this->input->post('lang_id', true),
            'title' => trim($this->input->post('title', false)),
            'title_slug' => $this->input->post('title_slug', true),
            'summary' => $this->input->post('summary', false),
            'category_id' => $this->input->post('category_id', true),
            'content' => $this->input->post('content', false),
            'optional_url' => $this->input->post('optional_url', true),
            'need_auth' => $this->input->post('need_auth', true),
            'is_slider' => $this->input->post('is_slider', true),
            'is_featured' => $this->input->post('is_featured', true),
            'is_recommended' => $this->input->post('is_recommended', true),
            'is_breaking' => $this->input->post('is_breaking', true),
            'visibility' => $this->input->post('visibility', true),
            'show_right_column' => $this->input->post('show_right_column', true),
            'keywords' => $this->input->post('keywords', true),
            'image_description' => $this->input->post('image_description', true),
        );
        return $data;
    }

    //add post
    public function add_post($post_type)
    {
        $data = $this->set_data($post_type);
        $is_scheduled = $this->input->post('scheduled_post', true);
        $date_published = $this->input->post('date_published', true);

        $data['is_scheduled'] = 0;
        if ($is_scheduled) {
            $data["is_scheduled"] = 1;
        }

        if (!empty($date_published)) {
            $data["created_at"] = $date_published;
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
        }

        $data['show_post_url'] = 0;
        $data["post_type"] = $post_type;
        $data['user_id'] = user()->id;
        $data['status'] = $this->input->post('status', true);

        //add post image
        $data["image_big"] = "";
        $data["image_default"] = "";
        $data["image_slider"] = "";
        $data["image_mid"] = "";
        $data["image_small"] = "";
        $data["image_mime"] = "jpg";
        $data["image_url"] = "";
        $post_image_id = $this->input->post('post_image_id', true);
        if (!empty($post_image_id)) {
            $image = $this->file_model->get_image($post_image_id);
            if (!empty($image)) {
                $data["image_big"] = $image->image_big;
                $data["image_default"] = $image->image_default;
                $data["image_slider"] = $image->image_slider;
                $data["image_mid"] = $image->image_mid;
                $data["image_small"] = $image->image_small;
                $data["image_mime"] = $image->image_mime;
            }
        }
        if (!empty($this->input->post('image_url', true))) {
            $data["image_url"] = $this->input->post('image_url', true);
        }
        return $this->db->insert('posts', $data);
    }

    //update post
    public function update_post($id, $post_type)
    {
        $data = $this->set_data($post_type);
        $data["created_at"] = $this->input->post('date_published', true);
        $data["user_id"] = $this->input->post('user_id', true);

        $data['is_scheduled'] = $this->input->post('scheduled_post', true);
        if (empty($data['is_scheduled'])) {
            $data['is_scheduled'] = 0;
        }

        $publish = $this->input->post('publish', true);
        if (!empty($publish) && $publish == 1) {
            $data["status"] = 1;
        }

        //update post image
        $post_image_id = $this->input->post('post_image_id', true);
        if (!empty($post_image_id)) {
            $image = $this->file_model->get_image($post_image_id);
            if (!empty($image)) {
                $data["image_big"] = $image->image_big;
                $data["image_default"] = $image->image_default;
                $data["image_slider"] = $image->image_slider;
                $data["image_mid"] = $image->image_mid;
                $data["image_small"] = $image->image_small;
                $data["image_mime"] = $image->image_mime;
                $data["image_url"] = "";
            }
        }
        if (!empty($this->input->post('image_url', true))) {
            $data["image_url"] = $this->input->post('image_url', true);
            $data["image_big"] = "";
            $data["image_default"] = "";
            $data["image_slider"] = "";
            $data["image_mid"] = "";
            $data["image_small"] = "";
            $data["image_mime"] = "jpg";
        }
        $data['updated_at'] = date('Y-m-d H:i:s');

        $this->db->where('id', clean_number($id));
        return $this->db->update('posts', $data);
    }

    //set post data
    public function set_data($post_type)
    {
        $data = $this->input_values();

        if (!isset($data['is_featured'])) {
            $data['is_featured'] = 0;
        }
        if (!isset($data['is_breaking'])) {
            $data['is_breaking'] = 0;
        }
        if (!isset($data['is_slider'])) {
            $data['is_slider'] = 0;
        }
        if (!isset($data['is_recommended'])) {
            $data['is_recommended'] = 0;
        }
        if (!isset($data['need_auth'])) {
            $data['need_auth'] = 0;
        }
        if (!isset($data['show_right_column'])) {
            $data['show_right_column'] = 0;
        }
        //set category
        $subcategory_id = $this->input->post('subcategory_id', true);
        if (!empty($subcategory_id)) {
            $data['category_id'] = $subcategory_id;
        }

        $data['show_item_numbers'] = 0;
        if (!empty($this->input->post('show_item_numbers', true))) {
            $data['show_item_numbers'] = 1;
        }

        if (empty($data["title_slug"])) {
            //slug for title
            $data["title_slug"] = str_slug($data["title"]);
        } else {
            $data["title_slug"] = remove_special_characters($data["title_slug"], true);
        }
        if ($post_type == "video") {
            $data["video_url"] = $this->input->post('video_url', true);
            $data["video_embed_code"] = $this->input->post('video_embed_code', true);
            $data['video_path'] = $this->input->post('video_path', true);
        }
        return $data;
    }

    //update slug
    public function update_slug($id)
    {
        $post = $this->get_post($id);
        if (!empty($post)) {
            if (empty($post->title_slug) || $post->title_slug == "-") {
                $data = array(
                    'title_slug' => $post->id
                );
                $this->db->where('id', $post->id);
                $this->db->update('posts', $data);
            } else {
                if ($this->check_slug_exists($post->title_slug, $post->id) == true) {
                    $data = array(
                        'title_slug' => $post->title_slug . "-" . $post->id
                    );
                    $this->db->where('id', $post->id);
                    $this->db->update('posts', $data);
                }
            }
        }
        return false;
    }

    //check slug exists
    public function check_slug_exists($slug, $id)
    {
        $sql = "SELECT * FROM posts WHERE title_slug = ? AND id != ?";
        $query = $this->db->query($sql, array(clean_str($slug), clean_number($id)));
        if (!empty($query->row())) {
            return true;
        }
        return false;
    }

    //check post exists
    public function check_post_exists($title, $title_hash)
    {
        $sql = "SELECT * FROM posts WHERE title = ? OR title_hash = ?";
        $query = $this->db->query($sql, array(clean_str($title), clean_str($title_hash)));
        if (!empty($query->row())) {
            return true;
        }
        return false;
    }

    //get post
    public function get_post($id)
    {
        $sql = "SELECT * FROM posts WHERE id =  ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->row();
    }

    //get posts count
    public function get_posts_count()
    {
        $sql = "SELECT COUNT(id) AS count FROM posts WHERE is_scheduled = 0 AND status = 1 AND visibility = 1";
        $query = $this->db->query($sql);
        if (!check_user_permission('manage_all_posts')) {
            $sql = "SELECT COUNT(id) AS count FROM posts WHERE is_scheduled = 0 AND status = 1 AND visibility = 1 AND user_id = ?";
            $query = $this->db->query($sql, array(clean_number($this->auth_user->id)));
        }
        return $query->row()->count;
    }

    //get pending posts count
    public function get_pending_posts_count()
    {
        $sql = "SELECT COUNT(id) AS count FROM posts WHERE is_scheduled = 0 AND status = 1 AND visibility = 0";
        $query = $this->db->query($sql);
        if (!check_user_permission('manage_all_posts')) {
            $sql = "SELECT COUNT(id) AS count FROM posts WHERE is_scheduled = 0 AND status = 1 AND visibility = 0 AND user_id = ?";
            $query = $this->db->query($sql, array(clean_number($this->auth_user->id)));
        }
        return $query->row()->count;
    }

    //get drafts count
    public function get_drafts_count()
    {
        $sql = "SELECT COUNT(id) AS count FROM posts WHERE status = 0";
        $query = $this->db->query($sql);
        if (!check_user_permission('manage_all_posts')) {
            $sql = "SELECT COUNT(id) AS count FROM posts WHERE status = 0 AND user_id = ?";
            $query = $this->db->query($sql, array(clean_number($this->auth_user->id)));
        }
        return $query->row()->count;
    }

    //get scheduled posts count
    public function get_scheduled_posts_count()
    {
        $sql = "SELECT COUNT(id) AS count FROM posts WHERE status = 1 AND is_scheduled = 1";
        $query = $this->db->query($sql);
        if (!check_user_permission('manage_all_posts')) {
            $sql = "SELECT COUNT(id) AS count FROM posts WHERE status = 1 AND is_scheduled = 1 AND user_id = ?";
            $query = $this->db->query($sql, array(clean_number($this->auth_user->id)));
        }
        return $query->row()->count;
    }

    //filter by values
    public function filter_posts()
    {
        $lang_id = $this->input->get('lang_id', true);
        $post_type = $this->input->get('post_type', true);
        $user = $this->input->get('user', true);
        $category = $this->input->get('category', true);
        $subcategory = $this->input->get('subcategory', true);
        $q = trim($this->input->get('q', true));
        if (!empty($subcategory)) {
            $category = $subcategory;
        }
        $user_id = null;
        if (check_user_permission('manage_all_posts')) {
            if (!empty($user)) {
                $user_id = $user;
            }
        } else {
            $user_id = $this->auth_user->id;
        }

        if (!empty($user_id)) {
            $this->db->where('posts.user_id', clean_number($user_id));
        }
        if (!empty($lang_id)) {
            $this->db->where('posts.lang_id', clean_number($lang_id));
        }
        if (!empty($post_type)) {
            $this->db->where('posts.post_type', clean_str($post_type));
        }
        if (!empty($category)) {
            $category_ids = generate_ids_string(get_category_tree($category, $this->categories));
            if (!empty($category_ids)) {
                $this->db->where('posts.category_id IN (' . $category_ids . ')');
            }
        }
        if (!empty($q)) {
            $this->db->like('posts.title', clean_str($q));
        }
    }

    //filter by list
    public function filter_posts_list($list)
    {
        if (!empty($list)) {
            if ($list == "slider_posts") {
                $this->db->where('posts.is_slider', 1);
            }
            if ($list == "featured_posts") {
                $this->db->where('posts.is_featured', 1);
            }
            if ($list == "breaking_news") {
                $this->db->where('posts.is_breaking', 1);
            }
            if ($list == "recommended_posts") {
                $this->db->where('posts.is_recommended', 1);
            }
        }
    }

    //get paginated posts
    public function get_paginated_posts($per_page, $offset, $list)
    {
        $this->filter_posts();
        $this->filter_posts_list($list);
        $this->db->where('posts.visibility', 1);
        $this->db->where('posts.status', 1);
        $this->db->where('posts.is_scheduled', 0);
        $this->db->order_by('posts.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('posts');
        return $query->result();
    }

    //get paginated posts count
    public function get_paginated_posts_count($list)
    {
        $this->filter_posts();
        $this->filter_posts_list($list);
        $this->db->select('COUNT(posts.id) as count');
        $this->db->where('posts.visibility', 1);
        $this->db->where('posts.status', 1);
        $this->db->where('posts.is_scheduled', 0);
        $query = $this->db->get('posts');
        return $query->row()->count;
    }

    //get paginated pending posts
    public function get_paginated_pending_posts($per_page, $offset)
    {
        $this->filter_posts();
        $this->db->where('posts.visibility', 0);
        $this->db->where('posts.status', 1);
        $this->db->where('posts.is_scheduled', 0);
        $this->db->order_by('posts.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('posts');
        return $query->result();
    }

    //get paginated pending posts count
    public function get_paginated_pending_posts_count()
    {
        $this->filter_posts();
        $this->db->select('COUNT(posts.id) as count');
        $this->db->where('posts.visibility', 0);
        $this->db->where('posts.status', 1);
        $this->db->where('posts.is_scheduled', 0);
        $query = $this->db->get('posts');
        return $query->row()->count;
    }

    //get paginated scheduled posts
    public function get_paginated_scheduled_posts($per_page, $offset)
    {
        $this->filter_posts();
        $this->db->where('posts.status', 1);
        $this->db->where('posts.is_scheduled', 1);
        $this->db->order_by('posts.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('posts');
        return $query->result();
    }

    //get paginated scheduled posts count
    public function get_paginated_scheduled_posts_count()
    {
        $this->filter_posts();
        $this->db->select('COUNT(posts.id) as count');
        $this->db->where('posts.status', 1);
        $this->db->where('posts.is_scheduled', 1);
        $query = $this->db->get('posts');
        return $query->row()->count;
    }

    //get paginated drafts
    public function get_paginated_drafts($per_page, $offset)
    {
        $this->filter_posts();
        $this->db->where('posts.status !=', 1);
        $this->db->order_by('posts.created_at', 'DESC');
        $this->db->limit($per_page, $offset);
        $query = $this->db->get('posts');
        return $query->result();
    }

    //get paginated drafts count
    public function get_paginated_drafts_count()
    {
        $this->filter_posts();
        $this->db->select('COUNT(posts.id) as count');
        $this->db->where('posts.status !=', 1);
        $query = $this->db->get('posts');
        return $query->row()->count;
    }

    //get feed posts count
    public function get_feed_posts_count($feed_id)
    {
        $this->filter_posts();
        $this->db->select('COUNT(posts.id) as count');
        $this->db->where('feed_id', clean_number($feed_id));
        $this->db->where('posts.visibility', 1);
        $this->db->where('posts.status', 1);
        $this->db->where('posts.is_scheduled', 0);
        $query = $this->db->get('posts');
        return $query->row()->count;
    }

    //get posts by feed id
    public function get_posts_by_feed_id($feed_id)
    {
        $sql = "SELECT * FROM posts WHERE feed_id = ?";
        $query = $this->db->query($sql, array(clean_number($feed_id)));
        return $query->result();
    }

    //get sitemap posts
    public function get_sitemap_posts()
    {
        $this->db->where('posts.visibility', 1);
        $this->db->where('posts.status', 1);
        $this->db->where('posts.is_scheduled', 0);
        $this->db->order_by('posts.created_at', 'DESC');
        $this->db->limit(10000);
        $query = $this->db->get('posts');
        return $query->result();
    }

    //add or remove post from slider
    public function post_add_remove_slider($id)
    {
        //get post
        $post = $this->get_post($id);
        if (!empty($post)) {
            $result = "";
            if ($post->is_slider == 1) {
                //remove from slider
                $data = array(
                    'is_slider' => 0,
                );
                $result = "removed";
            } else {
                //add to slider
                $data = array(
                    'is_slider' => 1,
                );
                $result = "added";
            }
            $this->db->where('id', $post->id);
            $this->db->update('posts', $data);
            return $result;
        }
    }

    //add or remove post from featured
    public function post_add_remove_featured($id)
    {
        //get post
        $post = $this->get_post($id);
        if (!empty($post)) {
            $result = "";
            if ($post->is_featured == 1) {
                //remove from featured
                $data = array(
                    'is_featured' => 0,
                );
                $result = "removed";
            } else {
                //add to featured
                $data = array(
                    'is_featured' => 1,
                );
                $result = "added";
            }
            $this->db->where('id', $post->id);
            $this->db->update('posts', $data);
            return $result;
        }
    }

    //add or remove post from breaking
    public function post_add_remove_breaking($id)
    {
        //get post
        $post = $this->get_post($id);
        if (!empty($post)) {
            $result = "";
            if ($post->is_breaking == 1) {
                //remove from breaking
                $data = array(
                    'is_breaking' => 0,
                );
                $result = "removed";
            } else {
                //add to breaking
                $data = array(
                    'is_breaking' => 1,
                );
                $result = "added";
            }

            $this->db->where('id', $post->id);
            $this->db->update('posts', $data);
            return $result;
        }
    }

    //approve post
    public function approve_post($id)
    {
        $data = array(
            'visibility' => 1,
        );
        $this->db->where('id', clean_number($id));
        return $this->db->update('posts', $data);
    }

    //publish post
    public function publish_post($id)
    {
        $data = array(
            'is_scheduled' => 0,
            'created_at' => date('Y-m-d H:i:s')
        );
        $this->db->where('id', clean_number($id));
        return $this->db->update('posts', $data);
    }

    //check scheduled posts
    public function check_scheduled_posts()
    {
        $date = date('Y-m-d H:i:s');
        $sql = "SELECT * FROM posts WHERE is_scheduled = 1";
        $query = $this->db->query($sql);
        $posts = $query->result();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                if ($post->created_at <= $date) {
                    $data = array(
                        'is_scheduled' => 0,
                    );
                    $this->db->where('id', $post->id);
                    $this->db->update('posts', $data);
                }
            }
            reset_cache_data_on_change();

            echo "All scheduled posts have been checked.";
        } else {
            echo "There are no scheduled posts.";
        }
    }

    //publish draft
    public function publish_draft($id)
    {
        $data = array(
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s')
        );
        $this->db->where('id', clean_number($id));
        return $this->db->update('posts', $data);
    }

    //add or remove post from recommended
    public function post_add_remove_recommended($id)
    {
        //get post
        $post = $this->get_post($id);
        if (!empty($post)) {
            $result = "";
            if ($post->is_recommended == 1) {
                //remove from recommended
                $data = array(
                    'is_recommended' => 0,
                );
                $result = "removed";
            } else {
                //add to recommended
                $data = array(
                    'is_recommended' => 1,
                );
                $result = "added";
            }
            $this->db->where('id', $post->id);
            $this->db->update('posts', $data);
            return $result;
        }
    }

    //save feaured post order
    public function save_featured_post_order($id, $order)
    {
        //get post
        $post = $this->get_post($id);
        if (!empty($post)) {
            $data = array(
                'featured_order' => clean_number($order),
            );
            $this->db->where('id', $post->id);
            $this->db->update('posts', $data);
        }
    }

    //save home slider post order
    public function save_home_slider_post_order($id, $order)
    {
        //get post
        $post = $this->get_post($id);
        if (!empty($post)) {
            $data = array(
                'slider_order' => clean_number($order),
            );
            $this->db->where('id', $post->id);
            $this->db->update('posts', $data);
        }
    }

    //post bulk options
    public function post_bulk_options($operation, $post_ids)
    {
        $data = array();
        if ($operation == 'add_slider') {
            $data['is_slider'] = 1;
        } elseif ($operation == 'remove_slider') {
            $data['is_slider'] = 0;
        } elseif ($operation == 'add_featured') {
            $data['is_featured'] = 1;
        } elseif ($operation == 'remove_featured') {
            $data['is_featured'] = 0;
        } elseif ($operation == 'add_breaking') {
            $data['is_breaking'] = 1;
        } elseif ($operation == 'remove_breaking') {
            $data['is_breaking'] = 0;
        } elseif ($operation == 'add_recommended') {
            $data['is_recommended'] = 1;
        } elseif ($operation == 'remove_recommended') {
            $data['is_recommended'] = 0;
        } elseif ($operation == 'publish_scheduled') {
            $data['is_scheduled'] = 0;
        } elseif ($operation == 'approve') {
            $data['visibility'] = 1;
        } elseif ($operation == 'publish_draft') {
            $data['status'] = 1;
        }
        if (!empty($post_ids)) {
            foreach ($post_ids as $id) {
                $post = $this->get_post($id);
                if (!empty($post)) {
                    $this->db->where('id', $id);
                    $this->db->update('posts', $data);
                }
            }
        }
    }

    //delete post
    public function delete_post($id)
    {
        $post = $this->get_post($id);
        if (!empty($post)) {
            if (!check_post_ownership($post->user_id)) {
                return false;
            }
            //delete additional images
            $this->post_file_model->delete_post_additional_images($post->id);
            //delete audios
            $this->post_file_model->delete_post_audios($post->id);
            //delete gallery post items
            if ($post->post_type == "gallery") {
                $this->post_item_model->delete_post_list_items($post->id, 'gallery');
            }
            if ($post->post_type == "sorted_list") {
                $this->post_item_model->delete_post_list_items($post->id, 'sorted_list');
            }
            //delete quiz questions
            if ($post->post_type == "trivia_quiz" || $post->post_type == "personality_quiz") {
                $this->quiz_model->delete_quiz_questions($post->id);
                $this->quiz_model->delete_quiz_results($post->id);
            }

            //delete post tags
            $this->tag_model->delete_post_tags($post->id);

            $this->db->where('id', $post->id);
            return $this->db->delete('posts');
        }
        return false;
    }

    //delete multi post
    public function delete_multi_posts($post_ids)
    {
        if (!empty($post_ids)) {
            foreach ($post_ids as $id) {
                $this->delete_post($id);
            }
        }
    }
}