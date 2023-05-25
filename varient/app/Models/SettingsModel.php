<?php namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('settings');
        $this->builderGeneral = $this->db->table('general_settings');
        $this->builderWidgets = $this->db->table('widgets');
        $this->builderFonts = $this->db->table('fonts');
        $this->checkVersion();
    }

    //input values
    public function inputValues()
    {
        return [
            'application_name' => inputPost('application_name'),
            'about_footer' => inputPost('about_footer'),
            'optional_url_button_name' => inputPost('optional_url_button_name'),
            'copyright' => inputPost('copyright'),
            'contact_address' => inputPost('contact_address'),
            'contact_email' => inputPost('contact_email'),
            'contact_phone' => inputPost('contact_phone'),
            'contact_text' => inputPost('contact_text'),
            'facebook_url' => inputPost('facebook_url'),
            'twitter_url' => inputPost('twitter_url'),
            'instagram_url' => inputPost('instagram_url'),
            'pinterest_url' => inputPost('pinterest_url'),
            'linkedin_url' => inputPost('linkedin_url'),
            'vk_url' => inputPost('vk_url'),
            'telegram_url' => inputPost('telegram_url'),
            'youtube_url' => inputPost('youtube_url'),
            'cookies_warning' => inputPost('cookies_warning'),
            'cookies_warning_text' => inputPost('cookies_warning_text')
        ];
    }

    //update settings
    public function updateSettings($langId)
    {
        $general = [
            'timezone' => inputPost('timezone'),
            'facebook_comment_active' => inputPost('facebook_comment_active'),
            'facebook_comment' => inputPost('facebook_comment'),
            'custom_header_codes' => inputPost('custom_header_codes'),
            'custom_footer_codes' => inputPost('custom_footer_codes')
        ];

        $uploadModel = new UploadModel();
        $logoPath = $uploadModel->uploadLogo('logo');
        $logoFooterPath = $uploadModel->uploadLogo('logo_footer');
        $logoEmailPath = $uploadModel->uploadLogo('logo_email');
        $faviconPath = $uploadModel->uploadFavicon('favicon');
        if (!empty($logoPath) && !empty($logoPath['path'])) {
            $general['logo'] = $logoPath['path'];
        }
        if (!empty($logoFooterPath) && !empty($logoFooterPath['path'])) {
            $general['logo_footer'] = $logoFooterPath['path'];
        }
        if (!empty($logoEmailPath) && !empty($logoEmailPath['path'])) {
            $general['logo_email'] = $logoEmailPath['path'];
        }
        if (!empty($faviconPath) && !empty($faviconPath['path'])) {
            $general['favicon'] = $faviconPath['path'];
        }

        $this->builderGeneral->where('id', 1)->update($general);
        $data = $this->inputValues();
        return $this->builder->where('lang_id', cleanNumber($langId))->update($data);
    }

    //update recaptcha settings
    public function updateRecaptchaSettings()
    {
        $data = [
            'recaptcha_site_key' => inputPost('recaptcha_site_key'),
            'recaptcha_secret_key' => inputPost('recaptcha_secret_key')
        ];
        return $this->builderGeneral->where('id', 1)->update($data);
    }

    //update maintenance mode settings
    public function updateMaintenanceModeSettings()
    {
        $data = [
            'maintenance_mode_title' => inputPost('maintenance_mode_title'),
            'maintenance_mode_description' => inputPost('maintenance_mode_description'),
            'maintenance_mode_status' => inputPost('maintenance_mode_status')
        ];
        if (empty($data["maintenance_mode_status"])) {
            $data["maintenance_mode_status"] = 0;
        }
        return $this->builderGeneral->where('id', 1)->update($data);
    }

    //update preferences
    public function updatePreferences($form)
    {
        if ($form == 'general') {
            $data = [
                'multilingual_system' => inputPost('multilingual_system'),
                'registration_system' => inputPost('registration_system'),
                'show_rss' => inputPost('show_rss'),
                'rss_content_type' => inputPost('rss_content_type'),
                'file_manager_show_files' => inputPost('file_manager_show_files'),
                'audio_download_button' => inputPost('audio_download_button'),
                'show_user_email_on_profile' => inputPost('show_user_email_on_profile'),
                'pwa_status' => inputPost('pwa_status')
            ];
        } elseif ($form == 'homepage') {
            $data = [
                'show_featured_section' => inputPost('show_featured_section'),
                'show_latest_posts' => inputPost('show_latest_posts'),
                'show_newsticker' => inputPost('show_newsticker'),
                'show_latest_posts_on_slider' => inputPost('show_latest_posts_on_slider'),
                'show_latest_posts_on_featured' => inputPost('show_latest_posts_on_featured'),
                'sort_slider_posts' => inputPost('sort_slider_posts'),
                'sort_featured_posts' => inputPost('sort_featured_posts')
            ];
        } elseif ($form == 'posts') {
            $data = [
                'post_url_structure' => inputPost('post_url_structure'),
                'comment_system' => inputPost('comment_system'),
                'comment_approval_system' => inputPost('comment_approval_system'),
                'emoji_reactions' => inputPost('emoji_reactions'),
                'show_post_author' => inputPost('show_post_author'),
                'show_post_date' => inputPost('show_post_date'),
                'show_hits' => inputPost('show_hits'),
                'approve_added_user_posts' => inputPost('approve_added_user_posts'),
                'approve_updated_user_posts' => inputPost('approve_updated_user_posts'),
                'redirect_rss_posts_to_original' => inputPost('redirect_rss_posts_to_original'),
                'pagination_per_page' => inputPost('pagination_per_page')
            ];
        } elseif ($form == 'post_formats') {
            $data = [
                'post_format_article' => inputPost('post_format_article'),
                'post_format_gallery' => inputPost('post_format_gallery'),
                'post_format_sorted_list' => inputPost('post_format_sorted_list'),
                'post_format_video' => inputPost('post_format_video'),
                'post_format_audio' => inputPost('post_format_audio'),
                'post_format_trivia_quiz' => inputPost('post_format_trivia_quiz'),
                'post_format_personality_quiz' => inputPost('post_format_personality_quiz')
            ];
        } elseif ($form == 'post_deletion') {
            $data = [
                'auto_post_deletion' => inputPost('auto_post_deletion'),
                'auto_post_deletion_days' => inputPost('auto_post_deletion_days'),
                'auto_post_deletion_delete_all' => inputPost('auto_post_deletion_delete_all')
            ];
        }
        if (!empty($data)) {
            return $this->builderGeneral->where('id', 1)->update($data);
        }
        return false;
    }

    //update allowed file extensions post
    public function updateAllowedFileExtensions()
    {
        $input = inputPost('allowed_file_extensions');
        $extArray = @explode(',', $input);
        if (!empty($extArray)) {
            $exts = json_encode($extArray);
            $exts = strReplace('[', '', $exts);
            $exts = strReplace(']', '', $exts);
            $exts = strReplace('.', '', $exts);
            if (!empty($exts)) {
                $exts = strtolower($exts);
            }
            $data = ['allowed_file_extensions' => $exts];
            return $this->builderGeneral->where('id', 1)->update($data);
        }
        return false;
    }

    //update seo settings
    public function updateSeoSettings()
    {
        $submit = inputPost('submit');
        if ($submit == 'google_analytics') {
            $data = [
                'google_analytics' => inputPost('google_analytics'),
            ];
            return $this->builderGeneral->where('id', 1)->update($data);
        } elseif ($submit == 'settings') {
            $langId = inputPost('lang_id');
            $data = [
                'site_title' => inputPost('site_title'),
                'home_title' => inputPost('home_title'),
                'site_description' => inputPost('site_description'),
                'keywords' => inputPost('keywords')
            ];
            return $this->builder->where('lang_id', cleanNumber($langId))->update($data);
        }
        return true;
    }

    //update route settings
    public function updateRouteSettings()
    {
        $data = [
            'admin' => inputPost('admin'),
            'profile' => inputPost('profile'),
            'tag' => inputPost('tag'),
            'reading_list' => inputPost('reading_list'),
            'settings' => inputPost('settings'),
            'social_accounts' => inputPost('social_accounts'),
            'preferences' => inputPost('preferences'),
            'change_password' => inputPost('change_password'),
            'forgot_password' => inputPost('forgot_password'),
            'reset_password' => inputPost('reset_password'),
            'delete_account' => inputPost('delete_account'),
            'register' => inputPost('register'),
            'posts' => inputPost('posts'),
            'search' => inputPost('search'),
            'rss_feeds' => inputPost('rss_feeds'),
            'gallery_album' => inputPost('gallery_album'),
            'earnings' => inputPost('earnings'),
            'payouts' => inputPost('payouts'),
            'set_payout_account' => inputPost('set_payout_account'),
            'logout' => inputPost('logout')
        ];
        foreach ($data as $key => $value) {
            $data[$key] = strSlug($data[$key]);
            if (empty($data[$key])) {
                $data[$key] = uniqid();
            }
        }
        return $this->db->table('routes')->where('id', 1)->update($data);
    }

    //update email settings
    public function updateEmailSettings()
    {
        $data = [
            'mail_protocol' => inputPost('mail_protocol'),
            'mail_service' => inputPost('mail_service'),
            'mail_title' => inputPost('mail_title'),
            'mail_encryption' => inputPost('mail_encryption'),
            'mail_host' => inputPost('mail_host'),
            'mail_port' => inputPost('mail_port'),
            'mail_username' => inputPost('mail_username'),
            'mail_password' => inputPost('mail_password'),
            'mail_reply_to' => inputPost('mail_reply_to'),
            'mailjet_api_key' => inputPost('mailjet_api_key'),
            'mailjet_secret_key' => inputPost('mailjet_secret_key'),
            'mailjet_email_address' => inputPost('mailjet_email_address')
        ];
        return $this->builderGeneral->where('id', 1)->update($data);
    }

    //update contact email settings
    public function updateContactEmailSettings()
    {
        $data = [
            'mail_contact' => inputPost('mail_contact'),
            'mail_contact_status' => inputPost('mail_contact_status')
        ];
        return $this->builderGeneral->where('id', 1)->update($data);
    }

    //update email verification settings
    public function emailVerificationSettings()
    {
        $data = [
            'email_verification' => inputPost('email_verification')
        ];
        return $this->builderGeneral->where('id', 1)->update($data);
    }

    //update storage settings
    public function updateStorageSettings()
    {
        $data = [
            'storage' => inputPost('storage')
        ];
        return $this->builderGeneral->where('id', 1)->update($data);
    }

    //update aws s3
    public function updateAwsS3()
    {
        $data = [
            'aws_key' => inputPost('aws_key'),
            'aws_secret' => inputPost('aws_secret'),
            'aws_bucket' => inputPost('aws_bucket'),
            'aws_region' => inputPost('aws_region')
        ];
        return $this->builderGeneral->where('id', 1)->update($data);
    }

    //update cache system
    public function updateCacheSystem()
    {
        $data = [
            'cache_system' => inputPost('cache_system'),
            'refresh_cache_database_changes' => inputPost('refresh_cache_database_changes'),
            'cache_refresh_time' => inputPost('cache_refresh_time') * 60
        ];
        return $this->builderGeneral->where('id', 1)->update($data);
    }

    //update social settings
    public function updateSocialSettings()
    {
        $submit = inputPost('submit');
        if ($submit == 'facebook') {
            $data = [
                'facebook_app_id' => inputPost('facebook_app_id'),
                'facebook_app_secret' => inputPost('facebook_app_secret')
            ];
        } elseif ($submit == 'google') {
            $data = [
                'google_client_id' => inputPost('google_client_id'),
                'google_client_secret' => inputPost('google_client_secret')
            ];
        } elseif ($submit == 'vk') {
            $data = [
                'vk_app_id' => inputPost('vk_app_id'),
                'vk_secure_key' => inputPost('vk_secure_key')
            ];
        }
        if (!empty($data)) {
            return $this->builderGeneral->where('id', 1)->update($data);
        }
        return true;
    }

    //get settings
    public function getSettings($langId)
    {
        return $this->builder->where('lang_id', cleanNumber($langId))->get()->getRow();
    }

    //get general settings
    public function getGeneralSettings()
    {
        return $this->builderGeneral->where('id', 1)->get()->getRow();
    }

    //get routes
    public function getRoutes()
    {
        return $this->db->table('routes')->where('id', 1)->get()->getRow();
    }

    //set theme mode
    public function setThemeMode()
    {
        $mode = inputPost('theme_mode');
        if ($mode == 'light' || $mode == 'dark') {
            helperSetCookie('theme_mode', $mode);
            $this->builderGeneral->where('id', 1)->update(['theme_mode' => $mode]);
        }
    }

    //set theme
    public function setTheme()
    {
        $id = inputPost('theme_id');
        $theme = $this->getTheme($id);
        if (!empty($theme)) {
            $this->db->table('themes')->update(['is_active' => 0]);
            $this->db->table('themes')->where('id', $theme->id)->update(['is_active' => 1]);
        }
    }

    //set theme settings
    public function setThemeSettings()
    {
        $id = inputPost('id');
        $theme = $this->getTheme($id);
        if (!empty($theme)) {
            $data = [
                'theme_color' => inputPost('theme_color'),
                'block_color' => inputPost('block_color'),
                'mega_menu_color' => inputPost('mega_menu_color')
            ];
            $this->db->table('themes')->where('id', $theme->id)->update($data);
        }
    }

    //get theme
    public function getTheme($id)
    {
        return $this->db->table('themes')->where('id', cleanNumber($id))->get()->getRow();
    }

    //get themes
    public function getThemes()
    {
        return $this->db->table('themes')->get()->getResult();
    }

    //set last cron update
    public function setLastCronUpdate()
    {
        return $this->builderGeneral->where('id', 1)->update(['last_cron_update' => date('Y-m-d H:i:s')]);
    }

    //delete old sessions
    function deleteOldSessions()
    {
        $now = date('Y-m-d H:i:s');
        $this->db->table('ci_sessions')->where("timestamp < DATE_SUB('" . $now . "', INTERVAL 6 DAY)")->delete();
    }

    //download database backup
    public function downloadBackup()
    {
        $prefs = array(
            'tables' => array(),
            'ignore' => array(),
            'filename' => '',
            'format' => 'gzip', // gzip, zip, txt
            'add_drop' => TRUE,
            'add_insert' => TRUE,
            'newline' => "\n",
            'foreign_key_checks' => TRUE
        );
        if (count($prefs['tables']) === 0) {
            $prefs['tables'] = $this->db->listTables();
        }
        // Extract the prefs for simplicity
        extract($prefs);
        $output = '';
        // Do we need to include a statement to disable foreign key checks?
        if ($foreign_key_checks === FALSE) {
            $output .= 'SET foreign_key_checks = 0;' . $newline;
        }
        foreach ((array)$tables as $table) {
            // Is the table in the "ignore" list?
            if (in_array($table, (array)$ignore, TRUE)) {
                continue;
            }
            // Get the table schema
            $query = $this->db->query('SHOW CREATE TABLE ' . $this->db->escapeIdentifiers($this->db->database . '.' . $table));
            // No result means the table name was invalid
            if ($query === FALSE) {
                continue;
            }
            // Write out the table schema
            $output .= '#' . $newline . '# TABLE STRUCTURE FOR: ' . $table . $newline . '#' . $newline . $newline;

            if ($add_drop === TRUE) {
                $output .= 'DROP TABLE IF EXISTS ' . $this->db->protectIdentifiers($table) . ';' . $newline . $newline;
            }
            $i = 0;
            $result = $query->getResultArray();
            foreach ($result[0] as $val) {
                if ($i++ % 2) {
                    $output .= $val . ';' . $newline . $newline;
                }
            }
            // If inserts are not needed we're done...
            if ($add_insert === FALSE) {
                continue;
            }
            // Grab all the data from the current table
            $query = $this->db->query('SELECT * FROM ' . $this->db->protectIdentifiers($table));

            if ($query->getFieldCount() === 0) {
                continue;
            }
            // Fetch the field names and determine if the field is an
            // integer type. We use this info to decide whether to
            // surround the data with quotes or not
            $i = 0;
            $field_str = '';
            $isInt = array();
            while ($field = $query->resultID->fetch_field()) {
                // Most versions of MySQL store timestamp as a string
                $isInt[$i] = in_array($field->type, array(MYSQLI_TYPE_TINY, MYSQLI_TYPE_SHORT, MYSQLI_TYPE_INT24, MYSQLI_TYPE_LONG), TRUE);

                // Create a string of field names
                $field_str .= $this->db->escapeIdentifiers($field->name) . ', ';
                $i++;
            }
            // Trim off the end comma
            $field_str = preg_replace('/, $/', '', $field_str);
            // Build the insert string
            foreach ($query->getResultArray() as $row) {
                $valStr = '';
                $i = 0;
                foreach ($row as $v) {
                    if ($v === NULL) {
                        $valStr .= 'NULL';
                    } else {
                        // Escape the data if it's not an integer
                        $valStr .= ($isInt[$i] === FALSE) ? $this->db->escape($v) : $v;
                    }
                    // Append a comma
                    $valStr .= ', ';
                    $i++;
                }
                // Remove the comma at the end of the string
                $valStr = preg_replace('/, $/', '', $valStr);
                // Build the INSERT string
                $output .= 'INSERT INTO ' . $this->db->protectIdentifiers($table) . ' (' . $field_str . ') VALUES (' . $valStr . ');' . $newline;
            }
            $output .= $newline . $newline;
        }
        // Do we need to include a statement to re-enable foreign key checks?
        if ($foreign_key_checks === FALSE) {
            $output .= 'SET foreign_key_checks = 1;' . $newline;
        }
        return $output;
    }

    /*
    *------------------------------------------------------------------------------------------
     * WIDGETS
    *------------------------------------------------------------------------------------------
    */

    //input values
    public function inputValuesWidget()
    {
        return [
            'lang_id' => inputPost('lang_id'),
            'title' => inputPost('title'),
            'content' => inputPost('content'),
            'widget_order' => inputPost('widget_order'),
            'visibility' => inputPost('visibility'),
            'is_custom' => inputPost('is_custom'),
            'display_category_id' => inputPost('display_category_id')
        ];
    }

    //add widget
    public function addWidget()
    {
        $data = $this->inputValuesWidget();
        $data['is_custom'] = 1;
        $data['type'] = 'custom';
        if (empty($data['display_category_id']) || $data['display_category_id'] == 'latest_posts') {
            $data['display_category_id'] = '';
        }
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->builderWidgets->insert($data);
    }

    //update widget
    public function editWidget($id)
    {
        $widget = $this->getWidget($id);
        if (!empty($widget)) {
            $data = $this->inputValuesWidget();
            $data['is_custom'] = $widget->is_custom;
            if (empty($data['display_category_id']) || $data['display_category_id'] == 'latest_posts') {
                $data['display_category_id'] = '';
            }
            return $this->builderWidgets->where('id', $widget->id)->update($data);
        }
        return true;
    }

    //get widgets
    public function getWidgets()
    {
        return $this->builderWidgets->orderBy('widget_order')->get()->getResult();
    }

    //get widgets by lang
    public function getWidgetsByLang($langId)
    {
        return $this->builderWidgets->where('lang_id', cleanNumber($langId))->orderBy('widget_order')->get()->getResult();
    }

    //get widget
    public function getWidget($id)
    {
        return $this->builderWidgets->where('id', cleanNumber($id))->get()->getRow();
    }

    //delete widget
    public function deleteWidget($id)
    {
        $widget = $this->getWidget($id);
        if (!empty($widget)) {
            return $this->builderWidgets->where('id', $widget->id)->delete();
        }
        return false;
    }

    /*
    *------------------------------------------------------------------------------------------
     * FONTS
    *------------------------------------------------------------------------------------------
    */

    //get selected fonts
    public function getSelectedFonts($settings)
    {
        $arrayFonts = array();
        $fonts = $this->builderFonts->whereIn('id', [cleanNumber($settings->primary_font), cleanNumber($settings->secondary_font), cleanNumber($settings->tertiary_font)], false)->get()->getResult();
        if (!empty($fonts)) {
            foreach ($fonts as $font) {
                if ($font->id == $settings->primary_font) {
                    $arrayFonts['primary'] = $font;
                }
                if ($font->id == $settings->secondary_font) {
                    $arrayFonts['secondary'] = $font;
                }
                if ($font->id == $settings->tertiary_font) {
                    $arrayFonts['tertiary'] = $font;
                }
            }
        }
        return $arrayFonts;
    }

    //get fonts
    public function getFonts()
    {
        return $this->builderFonts->get()->getResult();
    }

    //get font
    public function getFont($id)
    {
        return $this->builderFonts->where('id', cleanNumber($id))->get()->getRow();
    }

    //add font
    public function addFont()
    {
        $data = [
            'font_name' => inputPost('font_name'),
            'font_url' => inputPost('font_url'),
            'font_family' => inputPost('font_family'),
            'font_source' => 'google',
            'has_local_file' => 0,
            'is_default' => 0
        ];
        $data['font_key'] = strSlug($data['font_name']);
        return $this->builderFonts->insert($data);
    }

    //edit font
    public function editFont($id)
    {
        $font = $this->getFont($id);
        if (!empty($font)) {
            $data = [
                'font_name' => inputPost('font_name'),
                'font_url' => inputPost('font_url'),
                'font_family' => inputPost('font_family')
            ];
            if ($font->has_local_file) {
                $data['font_source'] = inputPost('font_source');
            }
            return $this->builderFonts->where('id', cleanNumber($id))->update($data);
        }
        return false;
    }

    //update font settings
    public function setDefaultFonts()
    {
        $langId = inputPost('lang_id');
        $data = [
            'primary_font' => inputPost('primary_font'),
            'secondary_font' => inputPost('secondary_font'),
            'tertiary_font' => inputPost('tertiary_font'),
        ];
        return $this->db->table('settings')->where('lang_id', cleanNumber($langId))->update($data);
    }

    //delete font
    public function deleteFont($id)
    {
        $font = $this->getFont($id);
        if (!empty($font)) {
            return $this->builderFonts->where('id', $font->id)->delete();
        }
        return false;
    }

    //check version
    public function checkVersion()
    {
        if ($this->generalSettings->version != '2.1.1') {
            $p = array();
            $p["ad_space_index_top"] = "Index (Top)";
            $p["ad_space_index_bottom"] = "Index (Bottom)";
            $p["ad_space_post_top"] = "Post Details (Top)";
            $p["ad_space_post_bottom"] = "Post Details (Bottom)";
            $p["ad_space_posts_top"] = "Posts (Top)";
            $p["ad_space_posts_bottom"] = "Posts (Bottom)";
            $p["ad_space_in_article"] = "In-Article";

            $languages = $this->db->table('languages')->get()->getResult();
            if (!empty($languages)) {
                foreach ($languages as $language) {
                    foreach ($p as $key => $value) {
                        $row = $this->db->table('language_translations')->where('label', $key)->where('lang_id', $language->id)->get()->getRow();
                        if (empty($row)) {
                            $new = [
                                'lang_id' => $language->id,
                                'label' => $key,
                                'translation' => $value
                            ];
                            $this->db->table('language_translations')->insert($new);
                        }
                    }
                }
            }
            $this->builderGeneral->where('id', 1)->update(['version' => '2.1.1']);
        }
    }
}
