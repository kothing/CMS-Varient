<?php defined('BASEPATH') or exit('No direct script access allowed');

class Post_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

        $this->slider_posts_limit = 20;
        $this->breaking_posts_limit = 20;
        $this->random_posts_limit = 15;
        $this->recommended_posts_limit = 5;
        $this->popular_posts_limit = 5;
        $this->latest_posts_limit = 6;
        $this->related_posts_limit = 6;
    }

    //build sql query string
    public function query_string($join_tags = false)
    {
        $sql = "SELECT posts.id, posts.lang_id, posts.title, posts.title_slug, posts.summary, posts.category_id, posts.image_big, posts.image_slider, posts.image_mid, 
                posts.image_small, posts.image_mime, posts.slider_order, posts.featured_order, posts.post_type, posts.image_url, posts.user_id, posts.pageviews, posts.created_at,
                categories.name AS category_name, categories.name_slug AS category_slug , categories.color AS category_color, 
                users.username AS author_username, users.slug AS author_slug,
                (SELECT COUNT(comments.id) FROM comments WHERE posts.id = comments.post_id AND comments.parent_id = 0 AND comments.status = 1) AS comment_count
                FROM posts
                INNER JOIN categories ON categories.id = posts.category_id
                INNER JOIN users ON users.id = posts.user_id ";
        if ($join_tags == true) {
            $sql .= "INNER JOIN tags ON tags.post_id = posts.id ";
        }
        $sql .= "WHERE posts.is_scheduled = 0 AND posts.visibility = 1 AND posts.status = 1 ";
        return $sql;
    }

    //get posts max id
    public function get_posts_max_id()
    {
        $max_id = 1;
        $sql = "SELECT MAX(id) AS max_id FROM posts WHERE posts.lang_id = ?";
        $query = $this->db->query($sql, array(clean_number($this->selected_lang->id)));
        if (!empty($query->row())) {
            $max_id = $query->row()->max_id;
        }
        return $max_id;
    }

    //get latest posts
    public function get_latest_posts($lang_id, $limit)
    {
        $sql = "SELECT * FROM (" . $this->query_string() . " AND posts.lang_id = ? ORDER BY posts.created_at DESC LIMIT ?) AS table_posts";
        $query = $this->db->query($sql, array(clean_number($lang_id), clean_number($limit)));
        return $query->result();
    }

    //load more posts
    public function load_more_posts($lang_id, $last_id, $limit)
    {
        $sql = "SELECT * FROM (" . $this->query_string() . " AND posts.lang_id = ? AND posts.id < ? ORDER BY posts.id DESC LIMIT ?) AS table_posts";
        $query = $this->db->query($sql, array(clean_number($lang_id), clean_number($last_id), clean_number($limit)));
        return $query->result();
    }

    //get latest posts by category
    public function get_latest_category_posts()
    {
        $sql = "SELECT id FROM
                (SELECT id, category_id, @row_number := IF(@prev = category_id, @row_number + 1, 1) AS row_number, @prev := category_id
                FROM posts
                JOIN (SELECT @prev := NULL, @row_number := 0) AS vars
                WHERE posts.is_scheduled = 0 AND posts.visibility = 1 AND posts.status = 1
                ORDER BY category_id, created_at DESC
                ) AS table_posts
                WHERE row_number <= 10";
        $query = $this->db->query($sql);
        $result = $query->result();
        $post_ids_array = array();
        if (!empty($result)) {
            foreach ($result as $item) {
                array_push($post_ids_array, $item->id);
            }
        }
        $post_ids = generate_ids_string($post_ids_array);
        if (!empty($post_ids)) {
            $sql = "SELECT posts.id, posts.title, posts.title_slug, posts.summary, posts.category_id, posts.image_big, posts.image_slider, posts.image_mid,
                posts.image_small, posts.image_mime, posts.slider_order, posts.featured_order, posts.post_type, posts.image_url, posts.user_id, posts.pageviews, posts.lang_id, posts.created_at,
                categories.name AS category_name, categories.name_slug AS category_slug , categories.color AS category_color,
                users.username AS author_username, users.slug AS author_slug,
                (SELECT COUNT(comments.id) FROM comments WHERE posts.id = comments.post_id AND comments.parent_id = 0 AND comments.status = 1) AS comment_count
                FROM posts
                INNER JOIN categories ON categories.id = posts.category_id
                INNER JOIN users ON users.id = posts.user_id
                WHERE posts.id IN (" . $post_ids . ") AND posts.lang_id = ?
                ORDER BY posts.created_at DESC";
            $query = $this->db->query($sql, array(clean_number($this->selected_lang->id)));
            return $query->result();
        }
        return array();
    }

    //get slider posts
    public function get_slider_posts()
    {
        $sql = "SELECT * FROM (" . $this->query_string() . " AND posts.lang_id = ? AND posts.is_slider = 1 ORDER BY posts.slider_order LIMIT ?) AS table_posts";
        $query = $this->db->query($sql, array(clean_number($this->selected_lang->id), $this->slider_posts_limit));
        return $query->result();
    }

    //get featured posts
    public function get_featured_posts()
    {
        $sql = "SELECT * FROM (" . $this->query_string() . " AND posts.lang_id = ? AND is_featured = 1 ORDER BY posts.featured_order LIMIT ?) AS table_posts";
        $query = $this->db->query($sql, array(clean_number($this->selected_lang->id), 4));
        return $query->result();
    }

    //get recommended posts
    public function get_recommended_posts()
    {
        $sql = "SELECT * FROM (" . $this->query_string() . " AND posts.lang_id = ? AND posts.is_recommended ORDER BY posts.created_at DESC LIMIT ?) AS table_posts";
        $query = $this->db->query($sql, array(clean_number($this->selected_lang->id), $this->recommended_posts_limit));
        return $query->result();
    }

    //get breaking news
    public function get_breaking_news()
    {
        $sql = "SELECT * FROM (" . $this->query_string() . " AND posts.lang_id = ? AND posts.is_breaking = 1 ORDER BY posts.created_at DESC LIMIT ?) AS table_posts";
        $query = $this->db->query($sql, array(clean_number($this->selected_lang->id), $this->breaking_posts_limit));
        return $query->result();
    }

    //get random posts
    public function get_random_posts()
    {
        $ids_array = generate_unique_numbers_array(1, $this->post_max_id, 50);
        $ids_string = generate_ids_string($ids_array);
        if (!empty($ids_string)) {
            $sql = "SELECT * FROM (
                    SELECT posts.id, posts.title, posts.title_slug, posts.summary, posts.category_id, posts.image_big, posts.image_slider, posts.image_mid, 
                    posts.image_small, posts.image_mime, posts.post_type, posts.image_url, posts.user_id, posts.pageviews, posts.created_at,
                    categories.name AS category_name, categories.name_slug AS category_slug , categories.color AS category_color,
                    users.username AS author_username, users.slug AS author_slug,
                    (SELECT COUNT(comments.id) FROM comments WHERE posts.id = comments.post_id AND comments.parent_id = 0 AND comments.status = 1) AS comment_count
                    FROM posts
                    INNER JOIN categories ON categories.id = posts.category_id
                    INNER JOIN users ON users.id = posts.user_id
                    WHERE posts.is_scheduled = 0 AND posts.visibility = 1 AND posts.status = 1 AND posts.lang_id = ? AND posts.id IN ({$ids_string}) LIMIT 30
                ) as table_posts";
            $query = $this->db->query($sql, array(clean_number($this->selected_lang->id)));
            $posts = $query->result();
            shuffle($posts);
            return $posts;
        }
        return array();
    }

    //get popular posts weekly
    public function get_popular_posts_weekly($lang_id)
    {
        $sql = "SELECT posts.id, posts.title, posts.title_slug, posts.post_type, posts.image_small, posts.image_mime, posts.image_url, users.slug AS author_slug, users.username AS author_username, posts.created_at, hit_counts.count AS pageviews_count,
                (SELECT COUNT(comments.id) FROM comments WHERE posts.id = comments.post_id AND comments.parent_id = 0 AND comments.status = 1) AS comment_count
			    FROM posts
			    INNER JOIN (SELECT COUNT(post_pageviews_week.id) AS count, post_pageviews_week.post_id FROM post_pageviews_week GROUP BY post_pageviews_week.post_id ORDER BY count DESC LIMIT ?) AS hit_counts ON hit_counts.post_id = posts.id
                INNER JOIN users ON users.id = posts.user_id
                INNER JOIN categories ON categories.id = posts.category_id
                WHERE posts.is_scheduled = 0 AND posts.visibility = 1 AND posts.status = 1 AND posts.lang_id = ? ORDER BY count DESC LIMIT ?";
        $query = $this->db->query($sql, array($this->popular_posts_limit, clean_number($lang_id), $this->popular_posts_limit));
        return complete_popular_posts($query->result(), $lang_id);
    }

    //get popular posts monthly
    public function get_popular_posts_monthly($lang_id)
    {
        $sql = "SELECT posts.id, posts.title, posts.title_slug, posts.post_type, posts.image_small, posts.image_mime, posts.image_url, users.slug AS author_slug, users.username AS author_username, posts.created_at, hit_counts.count AS pageviews_count,
                (SELECT COUNT(comments.id) FROM comments WHERE posts.id = comments.post_id AND comments.parent_id = 0 AND comments.status = 1) AS comment_count
			    FROM posts
			    INNER JOIN (SELECT COUNT(post_pageviews_month.id) AS count, post_pageviews_month.post_id FROM post_pageviews_month GROUP BY post_pageviews_month.post_id ORDER BY count DESC LIMIT ?) AS hit_counts ON hit_counts.post_id = posts.id
                INNER JOIN users ON users.id = posts.user_id
                INNER JOIN categories ON categories.id = posts.category_id
                WHERE posts.is_scheduled = 0 AND posts.visibility = 1 AND posts.status = 1 AND posts.lang_id = ? ORDER BY count DESC LIMIT ?";
        $query = $this->db->query($sql, array($this->popular_posts_limit, clean_number($lang_id), $this->popular_posts_limit));
        return complete_popular_posts($query->result(), $lang_id);
    }

    //get popular posts all time
    public function get_popular_posts_all_time($lang_id)
    {
        $sql = "SELECT posts.id, posts.title, posts.title_slug, posts.post_type, posts.image_small, posts.image_mime, posts.image_url, users.slug AS author_slug, users.username AS author_username, posts.created_at, posts.pageviews AS pageviews_count,
                (SELECT COUNT(comments.id) FROM comments WHERE posts.id = comments.post_id AND comments.parent_id = 0 AND comments.status = 1) AS comment_count
			    FROM posts
                INNER JOIN users ON users.id = posts.user_id
                INNER JOIN categories ON categories.id = posts.category_id
                WHERE posts.is_scheduled = 0 AND posts.visibility = 1 AND posts.status = 1 AND posts.lang_id = ? ORDER BY pageviews DESC LIMIT ?";
        $query = $this->db->query($sql, array(clean_number($lang_id), $this->popular_posts_limit));
        return complete_popular_posts($query->result(), $lang_id);
    }

    //get paginated posts
    public function get_paginated_posts($offset, $per_page)
    {
        $sql = "SELECT * FROM (" . $this->query_string() . " AND posts.lang_id = ? ORDER BY posts.created_at DESC LIMIT ?,?) AS table_posts";
        $query = $this->db->query($sql, array(clean_number($this->selected_lang->id), clean_number($offset), clean_number($per_page)));
        return $query->result();
    }

    //get total post count
    public function get_total_post_count()
    {
        $sql = "SELECT COUNT(posts.id) AS count FROM posts
                INNER JOIN categories ON categories.id = posts.category_id
                INNER JOIN users ON users.id = posts.user_id
                WHERE posts.is_scheduled = 0 AND posts.visibility = 1 AND posts.status = 1 AND posts.lang_id = ?";
        $query = $this->db->query($sql, array(clean_number($this->selected_lang->id)));
        return $query->row()->count;
    }

    //get category posts
    public function get_category_posts($category_id, $limit)
    {
        $category_ids = generate_ids_string(get_category_tree($category_id, $this->categories));
        if (empty($category_ids)) {
            return array();
        }
        $sql = "SELECT * FROM (" . $this->query_string() . " AND posts.lang_id = ? AND posts.category_id IN ({$category_ids}) ORDER BY posts.created_at DESC LIMIT ?) AS table_posts";
        $query = $this->db->query($sql, array(clean_number($this->selected_lang->id), clean_number($limit)));
        return $query->result();
    }

    //get paginated category posts
    public function get_paginated_category_posts($category_id, $offset, $per_page)
    {
        $category_ids = generate_ids_string(get_category_tree($category_id, $this->categories));
        if (empty($category_ids)) {
            return array();
        }
        $sql = "SELECT * FROM (" . $this->query_string() . " AND posts.lang_id = ? AND posts.category_id IN ({$category_ids}) ORDER BY posts.created_at DESC LIMIT ?,?) AS table_posts";
        $query = $this->db->query($sql, array(clean_number($this->selected_lang->id), clean_number($offset), clean_number($per_page)));
        return $query->result();
    }

    //get post count by category
    public function get_post_count_by_category($category_id)
    {
        $category_ids = generate_ids_string(get_category_tree($category_id, $this->categories));
        if (empty($category_ids)) {
            return array();
        }
        $sql = "SELECT COUNT(table_posts.id) AS count FROM (" . $this->query_string() . " AND posts.lang_id = ? AND posts.category_id IN ({$category_ids})) AS table_posts";
        $query = $this->db->query($sql, array(clean_number($this->selected_lang->id)));
        return $query->row()->count;
    }

    //get paginated tag posts
    public function get_paginated_tag_posts($tag_slug, $offset, $per_page)
    {
        $sql = "SELECT * FROM (" . $this->query_string(true) . " AND posts.lang_id = ? AND tags.tag_slug=? ORDER BY posts.created_at DESC LIMIT ?,?) AS table_posts";
        $query = $this->db->query($sql, array(clean_number($this->selected_lang->id), clean_str($tag_slug), clean_number($offset), clean_number($per_page)));
        return $query->result();
    }

    //get post count by tag
    public function get_post_count_by_tag($tag_slug)
    {
        $sql = "SELECT COUNT(table_posts.id) AS count FROM (" . $this->query_string(true) . " AND posts.lang_id = ? AND tags.tag_slug=?) AS table_posts";
        $query = $this->db->query($sql, array(clean_number($this->selected_lang->id), clean_str($tag_slug)));
        return $query->row()->count;
    }

    //get post
    public function get_post($slug)
    {
        $sql = "SELECT posts.*,
                categories.name AS category_name, categories.name_slug AS category_slug , categories.color AS category_color, 
                users.username AS author_username, users.slug AS author_slug,
                (SELECT COUNT(comments.id) FROM comments WHERE posts.id = comments.post_id AND comments.parent_id = 0 AND comments.status = 1) AS comment_count
                FROM posts
                INNER JOIN categories ON categories.id = posts.category_id
                INNER JOIN users ON users.id = posts.user_id
                WHERE posts.is_scheduled = 0 AND posts.visibility = 1 AND posts.status = 1 AND posts.title_slug = ? AND posts.lang_id = ?";
        $query = $this->db->query($sql, array(clean_str($slug), clean_number($this->selected_lang->id)));
        return $query->row();
    }

    //get preview post
    public function get_post_preview($slug)
    {
        $sql = "SELECT posts.*,
                categories.name AS category_name, categories.name_slug AS category_slug , categories.color AS category_color, 
                users.username AS author_username, users.slug AS author_slug,
                (SELECT COUNT(comments.id) FROM comments WHERE posts.id = comments.post_id AND comments.parent_id = 0 AND comments.status = 1) AS comment_count
                FROM posts
                INNER JOIN categories ON categories.id = posts.category_id
                INNER JOIN users ON users.id = posts.user_id
                WHERE posts.title_slug = ?";
        $query = $this->db->query($sql, array(clean_str($slug)));
        return $query->row();
    }

    //get user post by id
    public function get_post_by_id($post_id)
    {
        $sql = "SELECT * FROM posts WHERE id = ?";
        $query = $this->db->query($sql, array(clean_number($post_id)));
        return $query->row();
    }

    //get related posts
    public function get_related_posts($category_id, $post_id)
    {
        $category_ids = generate_ids_string(get_category_tree($category_id, $this->categories));
        if (empty($category_ids)) {
            return array();
        }
        $sql = "SELECT * FROM (" . $this->query_string() . " AND posts.id != ? AND posts.category_id IN ({$category_ids}) LIMIT 1000) AS table_posts ORDER BY RAND() LIMIT ?";
        $query = $this->db->query($sql, array(clean_number($post_id), $this->related_posts_limit));
        return $query->result();
    }

    //get user posts
    public function get_user_posts($user_id, $limit)
    {
        $sql = "SELECT * FROM (" . $this->query_string() . " AND posts.lang_id = ? AND posts.user_id = ? ORDER BY posts.created_at DESC LIMIT ?) AS table_posts";
        $query = $this->db->query($sql, array(clean_number($this->selected_lang->id), clean_number($user_id), clean_number($limit)));
        return $query->result();
    }

    //get paginated user posts
    public function get_paginated_user_posts($user_id, $offset, $per_page)
    {
        $sql = "SELECT * FROM (" . $this->query_string() . " AND posts.lang_id = ? AND posts.user_id=? ORDER BY posts.created_at DESC LIMIT ?,?) AS table_posts";
        $query = $this->db->query($sql, array(clean_number($this->selected_lang->id), clean_number($user_id), clean_number($offset), clean_number($per_page)));
        return $query->result();
    }

    //get post count by user
    public function get_post_count_by_user($user_id)
    {
        $sql = "SELECT COUNT(table_posts.id) AS count FROM (" . $this->query_string() . " AND posts.lang_id = ? AND posts.user_id=?) AS table_posts";
        $query = $this->db->query($sql, array(clean_number($this->selected_lang->id), clean_number($user_id)));
        return $query->row()->count;
    }

    //get paginated search posts
    public function get_paginated_search_posts($q, $offset, $per_page)
    {
        $like = '%' . $q . '%';
        $sql = "SELECT * FROM (" . $this->query_string() . " AND posts.lang_id = ? AND (posts.title LIKE ? OR posts.summary LIKE ? OR posts.content LIKE ?) ORDER BY posts.created_at DESC LIMIT ?,?) AS table_posts";
        $query = $this->db->query($sql, array(clean_number($this->selected_lang->id), $like, $like, $like, clean_number($offset), clean_number($per_page)));
        return $query->result();
    }

    //get search post count
    public function get_search_post_count($q)
    {
        $like = '%' . $q . '%';
        $sql = "SELECT COUNT(table_posts.id) AS count FROM (" . $this->query_string() . " AND posts.lang_id = ? AND (posts.title LIKE ? OR posts.summary LIKE ? OR posts.content LIKE ?)) AS table_posts";
        $query = $this->db->query($sql, array(clean_number($this->selected_lang->id), $like, $like, $like));
        return $query->row()->count;
    }

    //get previous post
    public function get_previous_post($id)
    {
        $sql = "SELECT * FROM posts WHERE posts.is_scheduled = 0 AND posts.visibility=1 AND posts.status=1 AND posts.id < ? AND posts.lang_id= ? ORDER BY posts.created_at DESC LIMIT 1";
        $query = $this->db->query($sql, array(clean_number($id), clean_number($this->selected_lang->id)));
        return $query->row();
    }

    //get next post
    public function get_next_post($id)
    {
        $sql = "SELECT * FROM posts WHERE posts.is_scheduled = 0 AND posts.visibility=1 AND posts.status=1 AND posts.id > ? AND posts.lang_id= ? ORDER BY posts.created_at LIMIT 1";
        $query = $this->db->query($sql, array(clean_number($id), clean_number($this->selected_lang->id)));
        return $query->row();
    }

    //increase pageviews count
    public function increase_post_pageviews_count($post)
    {
        if (!empty($post)) {
            if (!isset($_COOKIE['var_post_' . $post->id])) {
                $data = array(
                    'pageviews' => $post->pageviews + 1,
                );
                $this->db->where('id', $post->id);
                if (!empty($this->db->update('posts', $data))) {
                    helper_setcookie('var_post_' . $post->id, '1');
                    $this->db->insert('post_pageviews_week', ['post_id' => $post->id, 'ip_address' => @$this->input->ip_address(), 'created_at' => date('Y-m-d H:i:s')]);
                    $this->db->insert('post_pageviews_month', ['post_id' => $post->id, 'ip_address' => @$this->input->ip_address(), 'created_at' => date('Y-m-d H:i:s')]);
                }
            }
        }
    }

    //delete old page views
    public function delete_old_pageviews()
    {
        $now = date('Y-m-d H:i:s');
        $week = strtotime("-7 days", strtotime($now));
        $month = strtotime("-30 days", strtotime($now));
        $this->db->query("DELETE FROM post_pageviews_week WHERE created_at < '" . date('Y-m-d H:i:s', $week) . "'");
        $this->db->query("DELETE FROM post_pageviews_month WHERE created_at < '" . date('Y-m-d H:i:s', $month) . "'");
        //update last update
        $this->db->where('id', 1);
        $this->db->update('general_settings', ['last_popular_post_update' => date('Y-m-d H:i:s')]);
    }

}
