<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_model extends CI_Model
{
    //input values
    public function input_values()
    {
        $data = array(
            'application_name' => $this->input->post('application_name', true),
            'about_footer' => $this->input->post('about_footer', true),
            'optional_url_button_name' => $this->input->post('optional_url_button_name', true),
            'copyright' => $this->input->post('copyright', true),
            'contact_address' => $this->input->post('contact_address', true),
            'contact_email' => $this->input->post('contact_email', true),
            'contact_phone' => $this->input->post('contact_phone', true),
            'contact_text' => $this->input->post('contact_text', false),
            'facebook_url' => $this->input->post('facebook_url', true),
            'twitter_url' => $this->input->post('twitter_url', true),
            'instagram_url' => $this->input->post('instagram_url', true),
            'pinterest_url' => $this->input->post('pinterest_url', true),
            'linkedin_url' => $this->input->post('linkedin_url', true),
            'vk_url' => $this->input->post('vk_url', true),
            'telegram_url' => $this->input->post('telegram_url', true),
            'youtube_url' => $this->input->post('youtube_url', true),
            'cookies_warning' => $this->input->post('cookies_warning', true),
            'cookies_warning_text' => $this->input->post('cookies_warning_text', true),
        );
        return $data;
    }

    //get settings
    public function get_settings($lang_id)
    {
        $sql = "SELECT * FROM settings WHERE lang_id = ?";
        $query = $this->db->query($sql, array(clean_number($lang_id)));
        return $query->row();
    }

    //get settings
    public function get_general_settings()
    {
        $query = $this->db->query("SELECT * FROM general_settings WHERE id = 1");
        return $query->row();
    }

    //update settings
    public function update_settings()
    {
        $general = array(
            'timezone' => $this->input->post('timezone', false),
            'facebook_comment' => $this->input->post('facebook_comment', false),
            'custom_css_codes' => $this->input->post('custom_css_codes', false),
            'custom_javascript_codes' => $this->input->post('custom_javascript_codes', false)
        );

        $this->db->where('id', 1);
        $this->db->update('general_settings', $general);

        $lang_id = $this->input->post('lang_id', true);
        $data = $this->input_values();

        $this->db->where('lang_id', $lang_id);
        return $this->db->update('settings', $data);
    }

    //set theme
    public function set_theme()
    {
        $data = array(
            'dark_mode' => $this->input->post('dark_mode', true)
        );

        $data_user = array(
            'site_mode' => $data['dark_mode'] == 1 ? 'dark' : 'light'
        );
        $this->db->where('id', clean_number($this->auth_user->id));
        $this->db->update('users', $data_user);

        $this->db->where('id', 1);
        return $this->db->update('visual_settings', $data);
    }

    //update route settings
    public function update_route_settings()
    {
        $data = array(
            'admin' => $this->input->post('admin', true),
            'profile' => $this->input->post('profile', true),
            'tag' => $this->input->post('tag', true),
            'reading_list' => $this->input->post('reading_list', true),
            'settings' => $this->input->post('settings', true),
            'social_accounts' => $this->input->post('social_accounts', true),
            'preferences' => $this->input->post('preferences', true),
            'visual_settings' => $this->input->post('visual_settings', true),
            'change_password' => $this->input->post('change_password', true),
            'forgot_password' => $this->input->post('forgot_password', true),
            'reset_password' => $this->input->post('reset_password', true),
            'register' => $this->input->post('register', true),
            'posts' => $this->input->post('posts', true),
            'search' => $this->input->post('search', true),
            'rss_feeds' => $this->input->post('rss_feeds', true),
            'gallery_album' => $this->input->post('gallery_album', true),
            'logout' => $this->input->post('logout', true)
        );

        foreach ($data as $key => $value) {
            $data[$key] = str_slug($data[$key], true);
        }

        $this->db->where('id', 1);
        return $this->db->update('routes', $data);
    }

    //update preferences
    public function update_preferences($form)
    {
        if ($form == 'general') {
            $data = array(
                'multilingual_system' => $this->input->post('multilingual_system', true),
                'registration_system' => $this->input->post('registration_system', true),
                'show_rss' => $this->input->post('show_rss', true),
                'newsletter' => $this->input->post('newsletter', true),
                'file_manager_show_files' => $this->input->post('file_manager_show_files', true),
                'audio_download_button' => $this->input->post('audio_download_button', true)
            );
        } elseif ($form == 'homepage') {
            $data = array(
                'show_featured_section' => $this->input->post('show_featured_section', true),
                'show_latest_posts' => $this->input->post('show_latest_posts', true),
                'show_newsticker' => $this->input->post('show_newsticker', true),
                'sort_slider_posts' => $this->input->post('sort_slider_posts', true),
                'sort_featured_posts' => $this->input->post('sort_featured_posts', true)
            );
        } elseif ($form == 'posts') {
            $data = array(
                'comment_system' => $this->input->post('comment_system', true),
                'comment_approval_system' => $this->input->post('comment_approval_system', true),
                'facebook_comment_active' => $this->input->post('facebook_comment_active', true),
                'emoji_reactions' => $this->input->post('emoji_reactions', true),
                'show_post_author' => $this->input->post('show_post_author', true),
                'show_post_date' => $this->input->post('show_post_date', true),
                'show_hits' => $this->input->post('show_hits', true),
                'approve_added_user_posts' => $this->input->post('approve_added_user_posts', true),
                'approve_updated_user_posts' => $this->input->post('approve_updated_user_posts', true),
                'pagination_per_page' => $this->input->post('pagination_per_page', true)
            );
        } elseif ($form == 'post_formats') {
            $data = array(
                'post_format_article' => $this->input->post('post_format_article', true),
                'post_format_gallery' => $this->input->post('post_format_gallery', true),
                'post_format_sorted_list' => $this->input->post('post_format_sorted_list', true),
                'post_format_video' => $this->input->post('post_format_video', true),
                'post_format_audio' => $this->input->post('post_format_audio', true),
                'post_format_trivia_quiz' => $this->input->post('post_format_trivia_quiz', true),
                'post_format_personality_quiz' => $this->input->post('post_format_personality_quiz', true)
            );
        }
        if (!empty($data)) {
            $this->db->where('id', 1);
            return $this->db->update('general_settings', $data);
        }
        return false;
    }

    //update cache system
    public function update_cache_system()
    {
        $data = array(
            'cache_system' => $this->input->post('cache_system', true),
            'refresh_cache_database_changes' => $this->input->post('refresh_cache_database_changes', true),
            'cache_refresh_time' => $this->input->post('cache_refresh_time', true) * 60
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update social facebook settings
    public function update_social_facebook_settings()
    {
        $data = array(
            'facebook_app_id' => trim($this->input->post('facebook_app_id', true)),
            'facebook_app_secret' => trim($this->input->post('facebook_app_secret', true))
        );

        //update
        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update social google settings
    public function update_social_google_settings()
    {
        $data = array(
            'google_client_id' => trim($this->input->post('google_client_id', true)),
            'google_client_secret' => trim($this->input->post('google_client_secret', true))
        );

        //update
        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update social vk settings
    public function update_social_vk_settings()
    {
        $data = array(
            'vk_app_id' => trim($this->input->post('vk_app_id', true)),
            'vk_secure_key' => trim($this->input->post('vk_secure_key', true))
        );

        //update
        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update font settings
    public function update_font_settings()
    {
        $data = array(
            'primary_font' => $this->input->post('primary_font', true),
            'secondary_font' => $this->input->post('secondary_font', true),
            'tertiary_font' => $this->input->post('tertiary_font', true),
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update email settings
    public function update_email_settings()
    {
        $data = array(
            'mail_library' => $this->input->post('mail_library', true),
            'mail_protocol' => $this->input->post('mail_protocol', true),
            'mail_title' => $this->input->post('mail_title', true),
            'mail_host' => $this->input->post('mail_host', true),
            'mail_port' => $this->input->post('mail_port', true),
            'mail_username' => $this->input->post('mail_username', true),
            'mail_password' => $this->input->post('mail_password', true)
        );

        //update
        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update contact email settings
    public function update_contact_email_settings()
    {
        $data = array(
            'mail_contact' => $this->input->post('mail_contact', true),
            'mail_contact_status' => $this->input->post('mail_contact_status', true)
        );

        //update
        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update email verification settings
    public function email_verification_settings()
    {
        $data = array(
            'email_verification' => $this->input->post('email_verification', true)
        );

        //update
        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update seo settings
    public function update_seo_settings()
    {
        $general = array(
            'google_analytics' => $this->input->post('google_analytics', false),
        );

        $this->db->where('id', 1);
        $this->db->update('general_settings', $general);

        $data = array(
            'site_title' => $this->input->post('site_title', true),
            'home_title' => $this->input->post('home_title', true),
            'site_description' => $this->input->post('site_description', true),
            'keywords' => $this->input->post('keywords', true),
        );

        $lang_id = $this->input->post('lang_id', true);

        $this->db->where('lang_id', $lang_id);
        return $this->db->update('settings', $data);
    }

    //update recaptcha settings
    public function update_recaptcha_settings()
    {
        $data = array(
            'recaptcha_site_key' => $this->input->post('recaptcha_site_key', true),
            'recaptcha_secret_key' => $this->input->post('recaptcha_secret_key', true),
            'recaptcha_lang' => $this->input->post('recaptcha_lang', true),
        );

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //update maintenance mode settings
    public function update_maintenance_mode_settings()
    {
        $data = array(
            'maintenance_mode_title' => $this->input->post('maintenance_mode_title', true),
            'maintenance_mode_description' => $this->input->post('maintenance_mode_description', true),
            'maintenance_mode_status' => $this->input->post('maintenance_mode_status', true),
        );

        if (empty($data["maintenance_mode_status"])) {
            $data["maintenance_mode_status"] = 0;
        }

        $this->db->where('id', 1);
        return $this->db->update('general_settings', $data);
    }

    //get routes
    public function get_routes()
    {
        $query = $this->db->query("SELECT * FROM routes WHERE id = 1");
        return $query->row();
    }

    //get selected fonts
    public function get_selected_fonts()
    {
        $pf_id = clean_number($this->settings->primary_font);
        $sf_id = clean_number($this->settings->secondary_font);
        $tf_id = clean_number($this->settings->tertiary_font);
        $sql = "SELECT font_url AS primary_font_url, font_family AS primary_font_family, 
                (SELECT font_url FROM fonts WHERE id = ?) AS secondary_font_url,
                (SELECT font_family FROM fonts WHERE id = ?) AS secondary_font_family,                              
                (SELECT font_url FROM fonts WHERE id = ?) AS tertiary_font_url,
                (SELECT font_family FROM fonts WHERE id = ?) AS tertiary_font_family
                FROM fonts WHERE id = ?";
        $query = $this->db->query($sql, array($sf_id, $sf_id, $tf_id, $tf_id, $pf_id));
        return $query->row();
    }

    //get fonts
    public function get_fonts()
    {
        $query = $this->db->query("SELECT * FROM fonts ORDER BY font_name");
        return $query->result();
    }

    //get font
    public function get_font($id)
    {
        $sql = "SELECT * FROM fonts WHERE id =  ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->row();
    }

    //add font
    public function add_font()
    {
        $data = array(
            'font_name' => $this->input->post('font_name', true),
            'font_url' => $this->input->post('font_url', false),
            'font_family' => $this->input->post('font_family', true),
            'is_default' => 0
        );
        return $this->db->insert('fonts', $data);
    }

    //set site font
    public function set_site_font()
    {
        $lang_id = $this->input->post('lang_id', true);
        $data = array(
            'primary_font' => $this->input->post('primary_font', true),
            'secondary_font' => $this->input->post('secondary_font', true),
            'tertiary_font' => $this->input->post('tertiary_font', true)
        );
        $this->db->where('lang_id', clean_number($lang_id));
        return $this->db->update('settings', $data);
    }

    //update font
    public function update_font($id)
    {
        $data = array(
            'font_name' => $this->input->post('font_name', true),
            'font_url' => $this->input->post('font_url', false),
            'font_family' => $this->input->post('font_family', true)
        );
        $this->db->where('id', clean_number($id));
        return $this->db->update('fonts', $data);
    }

    //delete font
    public function delete_font($id)
    {
        $font = $this->get_font($id);
        if (!empty($font)) {
            $this->db->where('id', $font->id);
            return $this->db->delete('fonts');
        }
        return false;
    }

}