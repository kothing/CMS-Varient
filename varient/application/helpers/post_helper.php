<?php

//get posts by category
if (!function_exists('get_posts_by_category_id')) {
    function get_posts_by_category_id($category_id, $categories)
    {
        $ci =& get_instance();
        if (!empty($ci->latest_category_posts)) {
            $category_tree = get_category_tree($category_id, $categories);
            if (!empty($category_tree)) {
                return array_filter($ci->latest_category_posts, function ($item) use ($category_tree) {
                    return in_array($item->category_id, $category_tree);
                });
            }
        }
        return null;
    }
}

//get category
if (!function_exists('get_category')) {
    function get_category($id, $categories)
    {
        $ci =& get_instance();
        $category = null;
        if (!empty($categories)) {
            $category = array_filter($categories, function ($item) use ($id) {
                return $item->id == $id;
            });
            foreach ($category as $key => $value) {
                $category = $value;
                break;
            }
        }
        return $category;
    }
}

//get categories
if (!function_exists('get_categories')) {
    function get_categories()
    {
        $ci =& get_instance();
        $categories = get_cached_data('categories');
        if (empty($categories)) {
            $categories = $ci->category_model->get_categories_by_lang($ci->selected_lang->id);
            set_cache_data('categories', $categories);
        }
        return $categories;
    }
}

//get subcategories
if (!function_exists('get_subcategories')) {
    function get_subcategories($parent_id, $categories)
    {
        if (!empty($categories)) {
            return array_filter($categories, function ($item) use ($parent_id) {
                return $item->parent_id == $parent_id;
            });
        }
        return null;
    }
}

//get category tree
if (!function_exists('get_category_tree')) {
    function get_category_tree($category_id, $categories)
    {
        $tree = array();
        $category_id = clean_number($category_id);
        if (!empty($category_id)) {
            array_push($tree, $category_id);
            $subcategories = get_subcategories($category_id, $categories);
            if (!empty($subcategories)) {
                foreach ($subcategories as $subcategory) {
                    array_push($tree, $subcategory->id);
                }
            }
        }
        return $tree;
    }
}

//get parent category tree
if (!function_exists('get_parent_category_tree')) {
    function get_parent_category_tree($category_id, $categories)
    {
        $tree = array();
        $category_id = clean_number($category_id);
        if (!empty($category_id)) {
            $category = get_category($category_id, $categories);
            if (!empty($category) && $category->parent_id != 0) {
                $parent = get_category($category->parent_id, $categories);
                if (!empty($parent)) {
                    array_push($tree, $parent);
                }
            }
            array_push($tree, $category);
        }
        return $tree;
    }
}

//generate ids string
if (!function_exists('generate_ids_string')) {
    function generate_ids_string($array)
    {
        if (empty($array)) {
            return "0";
        } else {
            $array_new = array();
            foreach ($array as $item) {
                if (!empty(clean_number($item))) {
                    array_push($array_new, clean_number($item));
                }
            }
            return implode(',', $array_new);
        }
    }
}

//generate unique numbers
if (!function_exists('generate_unique_numbers_array')) {
    function generate_unique_numbers_array($min, $max, $count)
    {
        if ($count >= $max) {
            $count = $max - 1;
        }
        $array = array();
        while (count($array) <= $count) {
            $num = mt_rand($min, $max);
            if (!in_array($num, $array)) {
                array_push($array, $num);
            }
        }
        return $array;
    }
}

//set cached data
if (!function_exists('set_cache_data')) {
    function set_cache_data($key, $data)
    {
        $ci =& get_instance();
        $key = $key . "_lang" . $ci->selected_lang->id;
        if ($ci->general_settings->cache_system == 1) {
            $ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
            $ci->cache->save($key, $data, $ci->general_settings->cache_refresh_time);
        }
    }
}

//set cached data by lang
if (!function_exists('set_cache_data_by_lang')) {
    function set_cache_data_by_lang($key, $data, $lang_id)
    {
        $ci =& get_instance();
        $key = $key . "_lang" . $lang_id;
        if ($ci->general_settings->cache_system == 1) {
            $ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
            $ci->cache->save($key, $data, $ci->general_settings->cache_refresh_time);
        }
    }
}


//get cached data
if (!function_exists('get_cached_data')) {
    function get_cached_data($key)
    {
        $ci =& get_instance();
        $key = $key . "_lang" . $ci->selected_lang->id;
        if ($ci->general_settings->cache_system == 1) {
            $ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
            if ($data = $ci->cache->get($key)) {
                return $data;
            }
        }
        return false;
    }
}

//get cached data by lang
if (!function_exists('get_cached_data_by_lang')) {
    function get_cached_data_by_lang($key, $lang_id)
    {
        $ci =& get_instance();
        $key = $key . "_lang" . $lang_id;
        if ($ci->general_settings->cache_system == 1) {
            $ci->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
            if ($data = $ci->cache->get($key)) {
                return $data;
            }
        }
        return false;
    }
}

//reset cache data
if (!function_exists('reset_cache_data')) {
    function reset_cache_data()
    {
        $ci =& get_instance();
        $path = $ci->config->item('cache_path');
        $cache_path = ($path == '') ? APPPATH . 'cache/' : $path;
        $handle = opendir($cache_path);
        while (($file = readdir($handle)) !== FALSE) {
            if ($file != '.htaccess' && $file != 'index.html') {
                @unlink($cache_path . '/' . $file);
            }
        }
        closedir($handle);
    }
}

//reset cache data on change
if (!function_exists('reset_cache_data_on_change')) {
    function reset_cache_data_on_change()
    {
        $ci =& get_instance();
        $settings = $ci->settings_model->get_general_settings();
        if ($settings->refresh_cache_database_changes == 1) {
            reset_cache_data();
        }
    }
}

//get total post count
if (!function_exists('get_total_post_count')) {
    function get_total_post_count()
    {
        $ci =& get_instance();
        $total_posts_count = get_cached_data('total_posts_count');
        if (empty($total_posts_count)) {
            $total_posts_count = $ci->post_model->get_total_post_count();
            set_cache_data('total_posts_count', $total_posts_count);
        }
        return $total_posts_count;
    }
}

//get latest posts
if (!function_exists('get_latest_posts')) {
    function get_latest_posts($lang_id, $limit)
    {
        $ci =& get_instance();
        $key = "latest_posts_limit" . $limit;
        $latest_posts = get_cached_data($key);
        if (empty($latest_posts)) {
            $latest_posts = $ci->post_model->get_latest_posts($lang_id, $limit);
            set_cache_data_by_lang($key, $latest_posts, $lang_id);
        }
        return $latest_posts;
    }
}

//load more posts
if (!function_exists('load_more_posts')) {
    function load_more_posts($lang_id, $last_id, $limit)
    {
        $ci =& get_instance();
        $key = "latest_posts_lastid_" . $last_id . "_limit" . $limit;
        $posts = get_cached_data_by_lang($key, $lang_id);
        if (empty($posts)) {
            $posts = $ci->post_model->load_more_posts($lang_id, $last_id, $limit);
            set_cache_data_by_lang($key, $posts, $lang_id);
        }
        return $posts;
    }
}

//get slider posts
if (!function_exists('get_slider_posts')) {
    function get_slider_posts()
    {
        $ci =& get_instance();
        $slider_posts = get_cached_data('slider_posts');
        if (empty($slider_posts)) {
            $slider_posts = $ci->post_model->get_slider_posts();
            set_cache_data('slider_posts', $slider_posts);
        }
        return $slider_posts;
    }
}

//get featured posts
if (!function_exists('get_featured_posts')) {
    function get_featured_posts()
    {
        $ci =& get_instance();
        $featured_posts = get_cached_data('featured_posts');
        if (empty($featured_posts)) {
            $featured_posts = $ci->post_model->get_featured_posts();
            set_cache_data('featured_posts', $featured_posts);
        }
        return $featured_posts;
    }
}

//get breaking news
if (!function_exists('get_breaking_news')) {
    function get_breaking_news()
    {
        $ci =& get_instance();
        $breaking_news = get_cached_data('breaking_news');
        if (empty($breaking_news)) {
            $breaking_news = $ci->post_model->get_breaking_news();
            set_cache_data('breaking_news', $breaking_news);
        }
        return $breaking_news;
    }
}

//get breaking news
if (!function_exists('get_quiz_question_answers')) {
    function get_quiz_question_answers($question_id)
    {
        $ci =& get_instance();
        return $ci->quiz_model->get_quiz_question_answers($question_id);
    }
}

//complete popular posts
if (!function_exists('complete_popular_posts')) {
    function complete_popular_posts($popular_posts, $lang_id)
    {
        $ci =& get_instance();
        if (count($popular_posts) >= 5) {
            return $popular_posts;
        }
        if (!empty($ci->latest_category_posts)) {
            foreach ($ci->latest_category_posts as $post) {
                if ($post->lang_id == $lang_id) {
                    $in_array = false;
                    foreach ($popular_posts as $popular_post) {
                        if ($popular_post->id == $post->id) {
                            $in_array = true;
                        }
                    }
                    if ($in_array == false) {
                        $new_popular = clone $post;
                        $new_popular->pageviews = 0;
                        array_push($popular_posts, $new_popular);
                    }
                    if (count($popular_posts) >= 5) {
                        return $popular_posts;
                        break;
                    }
                }
            }
        }
        return $popular_posts;
    }
}

//get popular posts
if (!function_exists('get_popular_posts')) {
    function get_popular_posts($date_type, $lang_id)
    {
        $ci =& get_instance();
        $popular_posts = array();
        if ($date_type == "week") {
            $popular_posts = get_cached_data_by_lang('popular_posts_week', $lang_id);
            if (empty($popular_posts)) {
                $popular_posts = $ci->post_model->get_popular_posts_weekly($lang_id);
                set_cache_data_by_lang('popular_posts_week', $popular_posts, $lang_id);
            }
        } elseif ($date_type == "month") {
            $popular_posts = get_cached_data_by_lang('popular_posts_month', $lang_id);
            if (empty($popular_posts)) {
                $popular_posts = $ci->post_model->get_popular_posts_monthly($lang_id);
                set_cache_data_by_lang('popular_posts_month', $popular_posts, $lang_id);
            }
        } else {
            $popular_posts = get_cached_data_by_lang('popular_posts_all', $lang_id);
            if (empty($popular_posts)) {
                $popular_posts = $ci->post_model->get_popular_posts_all_time($lang_id);
                set_cache_data_by_lang('popular_posts_all', $popular_posts, $lang_id);
            }
        }
        return $popular_posts;
    }
}

//get recommended posts
if (!function_exists('get_recommended_posts')) {
    function get_recommended_posts()
    {
        $ci =& get_instance();
        $recommended_posts = get_cached_data('recommended_posts');
        if (empty($recommended_posts)) {
            $recommended_posts = $ci->post_model->get_recommended_posts();
            set_cache_data('recommended_posts', $recommended_posts);
        }
        return $recommended_posts;
    }
}