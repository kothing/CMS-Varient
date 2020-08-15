<?php
/*
 * Custom Helpers
 *
 */

if (strpos($_SERVER['REQUEST_URI'], '/index.php') !== false) {
    $ci =& get_instance();
    $ci->load->helper('url');
    redirect(current_url());
    exit();
}

//post method
if (!function_exists('post_method')) {
    function post_method()
    {
        $ci =& get_instance();
        if ($ci->input->method(FALSE) != 'post') {
            exit();
        }
    }
}

//get method
if (!function_exists('get_method')) {
    function get_method()
    {
        $ci =& get_instance();
        if ($ci->input->method(FALSE) != 'get') {
            exit();
        }
    }
}


//lang base url
if (!function_exists('lang_base_url')) {
    function lang_base_url()
    {
        $ci =& get_instance();
        return $ci->lang_base_url;
    }
}

//check auth
if (!function_exists('auth_check')) {
    function auth_check()
    {
        $ci =& get_instance();
        return $ci->auth_model->is_logged_in();
    }
}

//check admin
if (!function_exists('is_admin')) {
    function is_admin()
    {
        $ci =& get_instance();
        return $ci->auth_model->is_admin();
    }
}

//check user permission
if (!function_exists('check_user_permission')) {
    function check_user_permission($section)
    {
        $ci =& get_instance();
        if ($ci->auth_check) {
            $user_role = $ci->auth_user->role;
            if ($user_role == 'admin') {
                return true;
            }
            $role_permission = array_filter($ci->roles_permissions, function ($item) use ($user_role) {
                return $item->role == $user_role;
            });
            foreach ($role_permission as $key => $value) {
                $role_permission = $value;
                break;
            }
            if (!empty($role_permission) && $role_permission->$section == 1) {
                return true;
            }
        }
        return false;
    }
}

//check permission
if (!function_exists('check_permission')) {
    function check_permission($section)
    {
        if (!check_user_permission($section)) {
            redirect(lang_base_url());
        }
    }
}

//check post delete permission
if (!function_exists('check_post_ownership')) {
    function check_post_ownership($post_owner_id)
    {
        $ci =& get_instance();
        if ($ci->auth_user->id == $post_owner_id) {
            return true;
        }
        return check_user_permission('manage_all_posts');
    }
}

//check permission
if (!function_exists('check_admin')) {
    function check_admin()
    {
        if (!is_admin()) {
            redirect(lang_base_url());
        }
    }
}


//admin url
if (!function_exists('admin_url')) {
    function admin_url()
    {
        $ci =& get_instance();
        return base_url() . $ci->routes->admin . '/';
    }
}

//get site color
if (!function_exists('get_site_color')) {
    function get_site_color()
    {
        $ci =& get_instance();
        if ($ci->auth_check) {
            if (!empty($ci->auth_user)) {
                if (!empty($ci->auth_user->site_color)) {
                    return $ci->auth_user->site_color;
                }
            }
        }
        return $ci->visual_settings->site_color;
    }
}

//check if dark mode enabled
if (!function_exists('check_dark_mode_enabled')) {
    function check_dark_mode_enabled()
    {
        $ci =& get_instance();
        if ($ci->auth_check) {
            if (!empty($ci->auth_user)) {
                if (!empty($ci->auth_user->site_mode) && $ci->auth_user->site_mode == 'dark') {
                    return 1;
                } else {
                    return 0;
                }
            }
        }
        return $ci->visual_settings->dark_mode;
    }
}

//get route
if (!function_exists('get_route')) {
    function get_route($key, $slash = false)
    {
        $ci =& get_instance();
        $route = $key;
        if (!empty($ci->routes->$key)) {
            $route = $ci->routes->$key;
            if ($slash == true) {
                $route .= '/';
            }
        }
        return $route;
    }
}

//generate post url
if (!function_exists('generate_post_url')) {
    function generate_post_url($post)
    {
        if (!empty($post)) {
            return lang_base_url() . $post->title_slug;
        }
        return "#";
    }
}

//generate category url
if (!function_exists('generate_category_url')) {
    function generate_category_url($category)
    {
        if (!empty($category)) {
            if (!empty($category->parent_slug)) {
                return lang_base_url() . $category->parent_slug . "/" . $category->name_slug;
            } else {
                return lang_base_url() . $category->name_slug;
            }
        }
        return "#";
    }
}

//generate category url by id
if (!function_exists('generate_category_url_by_id')) {
    function generate_category_url_by_id($category_id)
    {
        $ci =& get_instance();
        $category = get_category(clean_number($category_id), $ci->categories);
        if (!empty($category)) {
            if (!empty($category->parent_slug)) {
                return lang_base_url() . $category->parent_slug . "/" . $category->name_slug;
            } else {
                return lang_base_url() . $category->name_slug;
            }
        }
        return "#";
    }
}

//generate tag url
if (!function_exists('generate_tag_url')) {
    function generate_tag_url($tag_slug)
    {
        if (!empty($tag_slug)) {
            return lang_base_url() . get_route('tag', true) . $tag_slug;
        }
        return "#";
    }
}

//generate profile url
if (!function_exists('generate_profile_url')) {
    function generate_profile_url($user_slug)
    {
        if (!empty($user_slug)) {
            return lang_base_url() . get_route('profile', true) . $user_slug;
        }
        return "#";
    }
}

//generate static url
if (!function_exists('generate_url')) {
    function generate_url($route_1, $route_2 = null)
    {
        if (!empty($route_2)) {
            return lang_base_url() . get_route($route_1, true) . get_route($route_2);
        } else {
            return lang_base_url() . get_route($route_1);
        }
    }
}

//generate menu item url
if (!function_exists('generate_menu_item_url')) {
    function generate_menu_item_url($item)
    {
        $ci =& get_instance();
        if (empty($item)) {
            return lang_base_url() . "#";
        }
        if ($item->item_type == 'page') {
            if (!empty($item->item_link)) {
                return $item->item_link;
            } else {
                return lang_base_url() . $item->item_slug;
            }
        } elseif ($item->item_type == 'category') {
            if (!empty($item->item_parent_slug)) {
                return lang_base_url() . $item->item_parent_slug . "/" . $item->item_slug;
            } else {
                return lang_base_url() . $item->item_slug;
            }
        } else {
            return lang_base_url() . "#";
        }
    }
}


//get logged user
if (!function_exists('user')) {
    function user()
    {
        $ci =& get_instance();
        $user = $ci->auth_model->get_logged_user();
        if (empty($user)) {
            $ci->auth_model->logout();
        } else {
            return $user;
        }
    }
}

//get user by id
if (!function_exists('get_user')) {
    function get_user($user_id)
    {
        $ci =& get_instance();
        return $ci->auth_model->get_user($user_id);
    }
}

//get parent link
if (!function_exists('helper_get_parent_link')) {
    function helper_get_parent_link($parent_id, $type)
    {
        // Get a reference to the controller object
        $ci =& get_instance();
        return $ci->navigation_model->get_parent_link($parent_id, $type);
    }
}

//get sub menu links
if (!function_exists('get_sub_menu_links')) {
    function get_sub_menu_links($menu_links, $parent_id, $type)
    {
        $ci =& get_instance();
        $sub_links = array();
        if (!empty($menu_links)) {
            $sub_links = array_filter($menu_links, function ($item) use ($parent_id, $type) {
                return $item->item_type == $type && $item->item_parent_id == $parent_id;
            });
        }
        return $sub_links;
    }
}

//get navigation item type
if (!function_exists('get_navigation_item_type')) {
    function get_navigation_item_type($menu_item)
    {
        if (!empty($menu_item)) {
            if ($menu_item->item_type == "category") {
                return trans("category");
            } else {
                if (!empty($menu_item->item_link)) {
                    return trans("link");
                } else {
                    return trans("page");
                }
            }
        }
    }
}

//get navigation item edit link
if (!function_exists('get_navigation_item_edit_link')) {
    function get_navigation_item_edit_link($menu_item)
    {
        if (!empty($menu_item)) {
            if ($menu_item->item_type == "category") {
                if ($menu_item->item_parent_id == 0) {
                    return admin_url() . 'update-category/' . $menu_item->item_id . '?redirect_url=' . current_url() . '?' . $_SERVER['QUERY_STRING'];
                } else {
                    return admin_url() . 'update-subcategory/' . $menu_item->item_id . '?redirect_url=' . current_url() . '?' . $_SERVER['QUERY_STRING'];
                }
            } else {
                if (!empty($menu_item->item_link)) {
                    return admin_url() . 'update-menu-link/' . $menu_item->item_id;
                } else {
                    return admin_url() . 'update-page/' . $menu_item->item_id . '?redirect_url=' . current_url() . '?' . $_SERVER['QUERY_STRING'];
                }
            }
        }
    }
}

//get navigation item delete function
if (!function_exists('get_navigation_item_delete_function')) {
    function get_navigation_item_delete_function($menu_item)
    {
        if (!empty($menu_item)) {
            if ($menu_item->item_type == "category") {
                return "delete_item('category_controller/delete_category_post','" . $menu_item->item_id . "','" . trans("confirm_category") . "');";
            } else {
                if (!empty($menu_item->item_link)) {
                    return "delete_item('admin_controller/delete_navigation_post','" . $menu_item->item_id . "','" . trans("confirm_link") . "');";
                } else {
                    return "delete_item('page_controller/delete_page_post','" . $menu_item->item_id . "','" . trans("confirm_page") . "');";
                }
            }
        }
    }
}

//check post image exist
if (!function_exists('check_post_img')) {
    function check_post_img($post, $type = '')
    {
        $is_exist = false;
        if (!empty($post)) {
            if (!empty($post->image_mid) || !empty($post->image_small) || !empty($post->image_url)) {
                $is_exist = true;
            }
        }
        if ($is_exist == false && $type == 'class') {
            echo " post-item-no-image";
        } else {
            if ($type != 'class') {
                return $is_exist;
            }
        }
    }
}

//get post images
if (!function_exists('get_post_image')) {
    function get_post_image($post, $image_size)
    {
        if (!empty($post)) {

            if (!empty($post->image_url)) {
                return $post->image_url;
            } else {
                if ($image_size == "big") {
                    return base_url() . $post->image_big;
                } elseif ($image_size == "default") {
                    return base_url() . $post->image_default;
                } elseif ($image_size == "slider") {
                    return base_url() . $post->image_slider;
                } elseif ($image_size == "mid") {
                    return base_url() . $post->image_mid;
                } elseif ($image_size == "small") {
                    return base_url() . $post->image_small;
                }
            }

        }
    }
}


//get post images
if (!function_exists('get_post_additional_images')) {
    function get_post_additional_images($post_id)
    {
        $ci =& get_instance();
        return $ci->post_file_model->get_post_additional_images($post_id);
    }
}

//get post files
if (!function_exists('get_post_files')) {
    function get_post_files($post_id)
    {
        $ci =& get_instance();
        return $ci->post_file_model->get_post_files($post_id);
    }
}

//get post audios
if (!function_exists('get_post_audios')) {
    function get_post_audios($post_id)
    {
        $ci =& get_instance();
        return $ci->post_file_model->get_post_audios($post_id);
    }
}


//get ad codes
if (!function_exists('get_ad_codes')) {
    function get_ad_codes($ad_space)
    {
        $ci =& get_instance();
        $ad = null;
        if (!empty($ci->ads)) {
            $ad = array_filter($ci->ads, function ($item) use ($ad_space) {
                return $item->ad_space == $ad_space;
            });
            foreach ($ad as $key => $value) {
                $ad = $value;
                break;
            }
        }
        return $ad;
    }
}

//get translated message
if (!function_exists('trans')) {
    function trans($string)
    {
        $ci =& get_instance();
        return $ci->lang->line($string);
    }
}

//print old form data
if (!function_exists('old')) {
    function old($field)
    {
        $ci =& get_instance();
        if (isset($ci->session->flashdata('form_data')[$field])) {
            return html_escape($ci->session->flashdata('form_data')[$field]);
        }
    }
}

//delete image from server
if (!function_exists('delete_image_from_server')) {
    function delete_image_from_server($path)
    {
        $full_path = FCPATH . $path;
        if (strlen($path) > 15 && file_exists($full_path)) {
            unlink($full_path);
        }
    }
}

//delete file from server
if (!function_exists('delete_file_from_server')) {
    function delete_file_from_server($path)
    {
        $full_path = FCPATH . $path;
        if (strlen($path) > 15 && file_exists($full_path)) {
            unlink($full_path);
        }
    }
}

//get user avatar
if (!function_exists('get_user_avatar')) {
    function get_user_avatar($user)
    {
        $ci =& get_instance();
        if (!empty($user)) {
            if (!empty($user->avatar) && file_exists(FCPATH . $user->avatar)) {
                return base_url() . $user->avatar;
            } elseif (!empty($user->avatar)) {
                return $user->avatar;
            } else {
                return base_url() . "assets/img/user.png";
            }
        } else {
            return base_url() . "assets/img/user.png";
        }
    }
}

//get user avatar by id
if (!function_exists('get_user_avatar_by_id')) {
    function get_user_avatar_by_id($user_id)
    {
        $ci =& get_instance();

        $user = $ci->auth_model->get_user($user_id);
        if (!empty($user)) {
            if (!empty($user->avatar) && file_exists(FCPATH . $user->avatar)) {
                return base_url() . $user->avatar;
            } elseif (!empty($user->avatar)) {
                return $user->avatar;
            } else {
                return base_url() . "assets/img/user.png";
            }
        } else {
            return base_url() . "assets/img/user.png";
        }
    }
}

//get page by default name
if (!function_exists('get_page_by_default_name')) {
    function get_page_by_default_name($default_name, $lang_id)
    {
        $ci =& get_instance();
        return $ci->page_model->get_page_by_default_name($default_name, $lang_id);
    }
}

//get page link by default name
if (!function_exists('get_page_link_by_default_name')) {
    function get_page_link_by_default_name($default_name, $lang_id)
    {
        $ci =& get_instance();
        $page = get_page_by_default_name($default_name, $lang_id);
        if (!empty($page)) {
            return lang_base_url() . $page->slug;
        }
        return "#";
    }
}

//get page title
if (!function_exists('get_page_title')) {
    function get_page_title($page)
    {
        if (!empty($page)) {
            return html_escape($page->title);
        } else {
            return "";
        }
    }
}

//get page description
if (!function_exists('get_page_description')) {
    function get_page_description($page)
    {
        if (!empty($page)) {
            return html_escape($page->description);
        } else {
            return "";
        }
    }
}

//get page keywords
if (!function_exists('get_page_keywords')) {
    function get_page_keywords($page)
    {
        if (!empty($page)) {
            return html_escape($page->keywords);
        } else {
            return "";
        }
    }
}

//get subcomments
if (!function_exists('get_subcomments')) {
    function get_subcomments($comment_id)
    {
        // Get a reference to the controller object
        $ci =& get_instance();
        return $ci->comment_model->get_subcomments($comment_id);
    }
}

//calculate total vote of poll option
if (!function_exists('calculate_total_vote_poll_option')) {
    function calculate_total_vote_poll_option($poll)
    {
        $total = 0;
        if (!empty($poll)) {
            for ($i = 1; $i <= 10; $i++) {
                $op = "option{$i}_vote_count";
                $total += $poll->$op;
            }
        }
        return $total;
    }
}

//date format
if (!function_exists('helper_date_format')) {
    function helper_date_format($datetime)
    {
        $date = date("M j, Y", strtotime($datetime));
        $date = str_replace("Jan", trans("January"), $date);
        $date = str_replace("Feb", trans("February"), $date);
        $date = str_replace("Mar", trans("March"), $date);
        $date = str_replace("Apr", trans("April"), $date);
        $date = str_replace("May", trans("May"), $date);
        $date = str_replace("Jun", trans("June"), $date);
        $date = str_replace("Jul", trans("July"), $date);
        $date = str_replace("Aug", trans("August"), $date);
        $date = str_replace("Sep", trans("September"), $date);
        $date = str_replace("Oct", trans("October"), $date);
        $date = str_replace("Nov", trans("November"), $date);
        $date = str_replace("Dec", trans("December"), $date);
        return $date;

    }
}

//get logo
if (!function_exists('get_logo')) {
    function get_logo($settings)
    {
        if (!empty($settings)) {
            if (!empty($settings->logo) && file_exists(FCPATH . $settings->logo)) {
                return base_url() . $settings->logo;
            } else {
                return base_url() . "assets/img/logo.svg";
            }
        } else {
            return base_url() . "assets/img/logo.svg";
        }
    }
}

//get logo footer
if (!function_exists('get_logo_footer')) {
    function get_logo_footer($settings)
    {
        if (!empty($settings)) {
            if (!empty($settings->logo_footer) && file_exists(FCPATH . $settings->logo_footer)) {
                return base_url() . $settings->logo_footer;
            } else {
                return base_url() . "assets/img/logo-footer.svg";
            }
        } else {
            return base_url() . "assets/img/logo-footer.svg";
        }
    }
}

//get logo email
if (!function_exists('get_logo_email')) {
    function get_logo_email($settings)
    {
        if (!empty($settings)) {
            if (!empty($settings->logo_email) && file_exists(FCPATH . $settings->logo_email)) {
                return base_url() . $settings->logo_email;
            } else {
                return base_url() . "assets/img/logo.png";
            }
        } else {
            return base_url() . "assets/img/logo.png";
        }
    }
}

//get favicon
if (!function_exists('get_favicon')) {
    function get_favicon($settings)
    {
        if (!empty($settings)) {
            if (!empty($settings->favicon) && file_exists(FCPATH . $settings->favicon)) {
                return base_url() . $settings->favicon;
            } else {
                return base_url() . "assets/img/favicon.png";
            }
        } else {
            return base_url() . "assets/img/favicon.png";
        }
    }
}

//get settings
if (!function_exists('get_settings')) {
    function get_settings($lang_id)
    {
        $ci =& get_instance();
        $ci->load->model('settings_model');
        return $ci->settings_model->get_settings($lang_id);
    }
}

//get general settings
if (!function_exists('get_general_settings')) {
    function get_general_settings()
    {
        $ci =& get_instance();
        $ci->load->model('settings_model');
        return $ci->settings_model->get_general_settings();
    }
}

//get admin url
if (!function_exists('get_admin_url')) {
    function get_admin_url()
    {
        // Get a reference to the controller object
        $ci =& get_instance();
        $ci->load->model('settings_model');
        $settings = $ci->settings_model->get_general_settings();
        if (!empty($settings)) {
            return $settings->admin_url();
        }
    }
}

//date diff
if (!function_exists('date_difference')) {
    function date_difference($date1, $date2, $format = '%a')
    {
        $datetime_1 = date_create($date1);
        $datetime_2 = date_create($date2);
        $diff = date_diff($datetime_1, $datetime_2);
        return $diff->format($format);
    }
}

//date difference in hours
function date_difference_in_hours($date1, $date2)
{
    $datetime_1 = date_create($date1);
    $datetime_2 = date_create($date2);
    $diff = date_diff($datetime_1, $datetime_2);
    $days = $diff->format('%a');
    $hours = $diff->format('%h');
    return $hours + ($days * 24);
}

//get feed posts count
if (!function_exists('get_feed_posts_count')) {
    function get_feed_posts_count($feed_id)
    {
        $ci =& get_instance();
        return $ci->post_admin_model->get_feed_posts_count($feed_id);
    }
}

//get language
if (!function_exists('get_language')) {
    function get_language($id)
    {
        $ci =& get_instance();
        $language = null;
        if (!empty($ci->languages)) {
            $language = array_filter($ci->languages, function ($item) use ($id) {
                return $item->id == $id;
            });
            foreach ($language as $key => $value) {
                $language = $value;
                break;
            }
        }
        return $language;
    }
}

//set cookie
if (!function_exists('helper_setcookie')) {
    function helper_setcookie($name, $value)
    {
        setcookie($name, $value, time() + (86400 * 30), "/"); //30 days
    }
}

//delete cookie
if (!function_exists('helper_deletecookie')) {
    function helper_deletecookie($name)
    {
        if (isset($_COOKIE[$name])) {
            setcookie($name, "", time() - 3600, "/");
        }
    }
}

//get gallery album
if (!function_exists('get_gallery_album')) {
    function get_gallery_album($id)
    {
        $ci =& get_instance();
        return $ci->gallery_category_model->get_album($id);
    }
}

//get gallery category
if (!function_exists('get_gallery_category')) {
    function get_gallery_category($id)
    {
        $ci =& get_instance();
        return $ci->gallery_category_model->get_category($id);
    }
}

//get page keywords
if (!function_exists('get_gallery_cover_image')) {
    function get_gallery_cover_image($album_id)
    {
        $ci =& get_instance();
        return $ci->gallery_model->get_cover_image($album_id);
    }
}

//print date
if (!function_exists('formatted_date')) {
    function formatted_date($timestamp)
    {
        return date("Y-m-d / H:i", strtotime($timestamp));
    }
}

//print formatted hour
if (!function_exists('formatted_hour')) {
    function formatted_hour($timestamp)
    {
        return date("H:i", strtotime($timestamp));
    }
}

//is reaction voted
if (!function_exists('is_reaction_voted')) {
    function is_reaction_voted($post_id, $reaction)
    {
        if (isset($_SESSION["vr_reaction_" . $reaction . "_" . $post_id]) && $_SESSION["vr_reaction_" . $reaction . "_" . $post_id] == '1') {
            return true;
        } else {
            return false;
        }
    }
}

//get recaptcha
if (!function_exists('generate_recaptcha')) {
    function generate_recaptcha()
    {
        $ci =& get_instance();
        if ($ci->recaptcha_status) {
            $ci->load->library('recaptcha');
            echo '<div class="form-group">';
            echo $ci->recaptcha->getWidget();
            echo $ci->recaptcha->getScriptTag();
            echo ' </div>';
        }
    }
}

//check user follows
if (!function_exists('is_user_follows')) {
    function is_user_follows($following_id, $follower_id)
    {
        $ci =& get_instance();
        return $ci->profile_model->is_user_follows($following_id, $follower_id);
    }
}

//get file name without extension
if (!function_exists('get_file_name_without_extension')) {
    function get_file_name_without_extension($file_name)
    {
        $ci =& get_instance();
        $ci->load->model('upload_model');
        return $ci->upload_model->get_file_name_without_extension($file_name);
    }
}

//get post base url
if (!function_exists('get_base_url_by_language_id')) {
    function get_base_url_by_language_id($lang_id)
    {
        $ci =& get_instance();
        if ($lang_id == $ci->general_settings->site_lang) {
            return base_url();
        } else {
            $lang = get_language($lang_id);
            if (!empty($lang)) {
                return base_url() . $lang->short_form . "/";
            }
        }
    }
}

//generate unique id
if (!function_exists('generate_unique_id')) {
    function generate_unique_id()
    {
        $id = uniqid("", TRUE);
        $id = str_replace(".", "-", $id);
        return $id . "-" . rand(10000000, 99999999);
    }
}

function time_ago($timestamp)
{
    $time_ago = strtotime($timestamp);
    $current_time = time();
    $time_difference = $current_time - $time_ago;
    $seconds = $time_difference;
    $minutes = round($seconds / 60);           // value 60 is seconds
    $hours = round($seconds / 3600);           //value 3600 is 60 minutes * 60 sec
    $days = round($seconds / 86400);          //86400 = 24 * 60 * 60;
    $weeks = round($seconds / 604800);          // 7*24*60*60;
    $months = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60
    $years = round($seconds / 31553280);     //(365+365+365+365+366)/5 * 24 * 60 * 60
    if ($seconds <= 60) {
        return trans("just_now");
    } else if ($minutes <= 60) {
        if ($minutes == 1) {
            return "1 " . trans("minute") . " " . trans("ago");
        } else {
            return $minutes . " " . trans("minutes") . " " . trans("ago");
        }
    } else if ($hours <= 24) {
        if ($hours == 1) {
            return "1 " . trans("hour") . " " . trans("ago");
        } else {
            return $hours . " " . trans("hours") . " " . trans("ago");
        }
    } else if ($days <= 30) {
        if ($days == 1) {
            return "1 " . trans("day") . " " . trans("ago");
        } else {
            return $days . " " . trans("days") . " " . trans("ago");
        }
    } else if ($months <= 12) {
        if ($months == 1) {
            return "1 " . trans("month") . " " . trans("ago");
        } else {
            return $months . " " . trans("months") . " " . trans("ago");
        }
    } else {
        if ($years == 1) {
            return "1 " . trans("year") . " " . trans("ago");
        } else {
            return $years . " " . trans("years") . " " . trans("ago");
        }
    }
}

function is_user_online($timestamp)
{
    $time_ago = strtotime($timestamp);
    $current_time = time();
    $time_difference = $current_time - $time_ago;
    $seconds = $time_difference;
    $minutes = round($seconds / 60);
    if ($minutes <= 3) {
        return true;
    } else {
        return false;
    }
}

//generate slug
if (!function_exists('str_slug')) {
    function str_slug($str)
    {
        $str = trim($str);
        return url_title(convert_accented_characters($str), "-", true);
    }
}

//clean slug
if (!function_exists('clean_slug')) {
    function clean_slug($slug)
    {
        $ci =& get_instance();
        $slug = urldecode($slug);
        $slug = $ci->security->xss_clean($slug);
        $slug = remove_special_characters($slug, true);
        return $slug;
    }
}

//clean number
if (!function_exists('clean_number')) {
    function clean_number($num)
    {
        $ci =& get_instance();
        $num = trim($num);
        $num = $ci->security->xss_clean($num);
        $num = intval($num);
        return $num;
    }
}

//clean string
if (!function_exists('clean_str')) {
    function clean_str($str)
    {
        $ci =& get_instance();
        $str = $ci->security->xss_clean($str);
        $str = remove_special_characters($str, false);
        return $str;
    }
}

//remove special characters
if (!function_exists('remove_special_characters')) {
    function remove_special_characters($str, $is_slug = false)
    {
        $str = trim($str);
        $str = str_replace('#', '', $str);
        $str = str_replace(';', '', $str);
        $str = str_replace('!', '', $str);
        $str = str_replace('"', '', $str);
        $str = str_replace('$', '', $str);
        $str = str_replace('%', '', $str);
        $str = str_replace('(', '', $str);
        $str = str_replace(')', '', $str);
        $str = str_replace('*', '', $str);
        $str = str_replace('+', '', $str);
        $str = str_replace('/', '', $str);
        $str = str_replace('\'', '', $str);
        $str = str_replace('<', '', $str);
        $str = str_replace('>', '', $str);
        $str = str_replace('=', '', $str);
        $str = str_replace('?', '', $str);
        $str = str_replace('[', '', $str);
        $str = str_replace(']', '', $str);
        $str = str_replace('\\', '', $str);
        $str = str_replace('^', '', $str);
        $str = str_replace('`', '', $str);
        $str = str_replace('{', '', $str);
        $str = str_replace('}', '', $str);
        $str = str_replace('|', '', $str);
        $str = str_replace('~', '', $str);
        if ($is_slug == true) {
            $str = str_replace(" ", '-', $str);
            $str = str_replace("'", '', $str);
        }
        return $str;
    }
}


//remove forbidden characters
if (!function_exists('remove_forbidden_characters')) {
    function remove_forbidden_characters($str)
    {
        $str = str_replace(';', '', $str);
        $str = str_replace('"', '', $str);
        $str = str_replace('$', '', $str);
        $str = str_replace('%', '', $str);
        $str = str_replace('*', '', $str);
        $str = str_replace('/', '', $str);
        $str = str_replace('\'', '', $str);
        $str = str_replace('<', '', $str);
        $str = str_replace('>', '', $str);
        $str = str_replace('=', '', $str);
        $str = str_replace('?', '', $str);
        $str = str_replace('[', '', $str);
        $str = str_replace(']', '', $str);
        $str = str_replace('\\', '', $str);
        $str = str_replace('^', '', $str);
        $str = str_replace('`', '', $str);
        $str = str_replace('{', '', $str);
        $str = str_replace('}', '', $str);
        $str = str_replace('|', '', $str);
        $str = str_replace('~', '', $str);
        return $str;
    }
}

//convert xml characters
if (!function_exists('convert_to_xml_character')) {
    function convert_to_xml_character($string)
    {
        return str_replace(array('&', '<', '>', '\'', '"'), array('&amp;', '&lt;', '&gt;', '&apos;', '&quot;'), $string);
    }
}

//check version
if (!function_exists('check_version')) {
    function check_version()
    {
        $ci =& get_instance();
        if (!$ci->db->field_exists('version', 'general_settings')) {
            $ci->db->query("ALTER TABLE general_settings ADD COLUMN `version` VARCHAR(30) DEFAULT '1.7.1';");

            if (!$ci->db->field_exists('last_popular_post_update', 'general_settings')) {
                $ci->db->query("ALTER TABLE general_settings ADD COLUMN `last_popular_post_update` TIMESTAMP;");
            }

            $table_week = "CREATE TABLE `post_pageviews_week` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `post_id` int(11) DEFAULT NULL,
            `ip_address` varchar(30) DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            $ci->db->query($table_week);

            $ci->db->query("ALTER TABLE post_pageviews_week ADD INDEX idx_post_id (post_id)");
            $ci->db->query("ALTER TABLE post_pageviews_week ADD INDEX idx_created_at (created_at)");
            $ci->db->query("RENAME TABLE post_pageviews TO post_pageviews_month;");
        }
    }
}

?>
