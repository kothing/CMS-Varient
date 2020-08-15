<?php
define('BASEPATH', "/");
define('ENVIRONMENT', 'production');
require_once "application/config/database.php";
$license_code = '';
$purchase_code = '';

if (!function_exists('curl_init')) {
    $error = 'cURL is not available on your server! Please enable cURL to continue the installation. You can read the documentation for more information.';
}

//set database credentials
$database = $db['default'];
$db_host = $database['hostname'];
$db_name = $database['database'];
$db_user = $database['username'];
$db_password = $database['password'];

/* Connect */
$connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);
$connection->query("SET CHARACTER SET utf8");
$connection->query("SET NAMES utf8");
if (!$connection) {
    $error = "Connect failed! Please check your database credentials.";
}

if (isset($_POST["btn_submit"])) {
    $input_code = trim($_POST['license_code']);
    //current URL
    $http = 'http';
    if (isset($_SERVER['HTTPS'])) {
        $http = 'https';
    }
    $host = $_SERVER['HTTP_HOST'];
    $requestUri = $_SERVER['REQUEST_URI'];
    $current_url = $http . '://' . htmlentities($host) . '/' . htmlentities($requestUri);
    //check license
    $url = "http://license.codingest.com/api/check_varient_license_code?license_code=" . $input_code . "&domain=" . $current_url;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    if (empty($response)) {
        $url = "https://license.codingest.com/api/check_varient_license_code?license_code=" . $input_code . "&domain=" . $current_url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
    }
    $data = json_decode($response);
    if (!empty($data)) {
        if ($data->code == "error") {
            $error = "Invalid License Code!";
        } else {
            $license_code = $input_code;
            $purchase_code = $data->code;
            update_13_to_14($license_code, $purchase_code, $connection);
            sleep(1);
            update_14_to_15($license_code, $purchase_code, $connection);
            sleep(1);
            update_15_to_16($license_code, $purchase_code, $connection);
            sleep(1);
            update_16_to_17($license_code, $purchase_code, $connection);
            sleep(1);
            /* close connection */
            mysqli_close($connection);
            $success = 'The update has been successfully completed! Please delete the "update_database.php" file.';
        }
    } else {
        $error = "Invalid License Code!";
    }
}

function update_13_to_14($license_code, $purchase_code, $connection)
{
    $sql_general_settings = "CREATE TABLE `general_settings` (
        `id` INT AUTO_INCREMENT PRIMARY KEY, 
        `site_lang` INT DEFAULT 1,
        `multilingual_system` INT DEFAULT 1,
        `site_color` VARCHAR(100) DEFAULT 'default',
        `show_hits` INT DEFAULT 1,
        `show_rss` INT DEFAULT 1,
        `show_newsticker` INT DEFAULT 1,
        `pagination_per_page` INT DEFAULT 16,
        `google_analytics` Text,
        `primary_font` VARCHAR(255),
        `secondary_font` VARCHAR(255),
        `tertiary_font` VARCHAR(255),
        `mail_protocol` VARCHAR(100) DEFAULT 'smtp',
        `mail_host` VARCHAR(255),
        `mail_port` VARCHAR(255) DEFAULT '587',
        `mail_username` VARCHAR(255),
        `mail_password` VARCHAR(255),
        `mail_title` VARCHAR(255),
        `facebook_app_id` VARCHAR(500),
        `facebook_app_secret` VARCHAR(500),
        `google_app_name` VARCHAR(500),
        `google_client_id` VARCHAR(500),
        `google_client_secret` VARCHAR(500),
        `facebook_comment` Text,
        `facebook_comment_active` INT DEFAULT 1,
        `show_featured_section` INT DEFAULT 1,
        `show_latest_posts` INT DEFAULT 1,
        `registration_system` INT DEFAULT 1,
        `comment_system` INT DEFAULT 1,
        `show_post_author` INT DEFAULT 1,
        `show_post_date` INT DEFAULT 1,
        `menu_limit` INT DEFAULT 8,
        `copyright` VARCHAR(500),
        `head_code` Text,
        `vr_key` VARCHAR(500),
        `purchase_code` VARCHAR(255),
        `recaptcha_site_key` VARCHAR(255),
        `recaptcha_secret_key` VARCHAR(255),
        `recaptcha_lang` VARCHAR(50),
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP
        )";

    $sql_settings = "CREATE TABLE `settings` (
        `id` INT AUTO_INCREMENT PRIMARY KEY, 
        `lang_id` INT DEFAULT 1,
        `site_title` VARCHAR(255),
        `home_title` VARCHAR(255),
        `site_description` VARCHAR(500),
        `keywords` VARCHAR(500),
        `application_name` VARCHAR(255),
        `facebook_url` VARCHAR(500),
        `twitter_url` VARCHAR(500),
        `google_url` VARCHAR(500),
        `instagram_url` VARCHAR(500),
        `pinterest_url` VARCHAR(500),
        `linkedin_url` VARCHAR(500),
        `vk_url` VARCHAR(500),
        `youtube_url` VARCHAR(500),
        `optional_url_button_name` VARCHAR(500) DEFAULT 'Click',
        `about_footer` VARCHAR(1000),
        `contact_text` Text,
        `contact_address` VARCHAR(500),
        `contact_email` VARCHAR(255),
        `contact_phone` VARCHAR(255),
        `map_api_key` VARCHAR(500),
        `latitude` VARCHAR(255),
        `longitude` VARCHAR(255),
        `copyright` VARCHAR(500),
        `cookies_warning` INT DEFAULT 1,
        `cookies_warning_text` Text,
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP
        )";

    $sql_images = "CREATE TABLE `images` (
        `id` INT AUTO_INCREMENT PRIMARY KEY, 
        `lang_id` INT DEFAULT 1,
        `image_big` VARCHAR(255),
        `image_default` VARCHAR(255),
        `image_slider` VARCHAR(255),
        `image_mid` VARCHAR(255),
         `image_small` VARCHAR(255)
        )";

    $sql_languages = "CREATE TABLE `languages` (
        `id` INT AUTO_INCREMENT PRIMARY KEY, 
        `name` VARCHAR(255),
        `short_form` VARCHAR(255),
        `language_code` VARCHAR(100),
        `folder_name` VARCHAR(255),
        `text_direction` VARCHAR(50),
        `status` INT DEFAULT 1,
        `language_order` INT DEFAULT 1
        )";

    $sql_post_audios = "CREATE TABLE `post_audios` (
        `id` INT AUTO_INCREMENT PRIMARY KEY, 
        `post_id` INT,
        `audio_id` INT
        )";

    $sql_videos = "CREATE TABLE `videos` (
        `id` INT AUTO_INCREMENT PRIMARY KEY, 
        `video_name` VARCHAR(255),
        `video_path` VARCHAR(255)
        )";

    /* update database */
    mysqli_query($connection, "DROP TABLE settings;");
    mysqli_query($connection, $sql_general_settings);
    mysqli_query($connection, $sql_settings);
    mysqli_query($connection, $sql_images);
    mysqli_query($connection, $sql_languages);
    mysqli_query($connection, $sql_post_audios);
    mysqli_query($connection, $sql_videos);
    sleep(1);
    mysqli_query($connection, "ALTER TABLE categories ADD COLUMN `lang_id` INT DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE gallery ADD COLUMN `lang_id` INT DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE gallery_categories ADD COLUMN `lang_id` INT DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE pages ADD COLUMN `lang_id` INT DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE polls ADD COLUMN `lang_id` INT DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE posts ADD COLUMN `lang_id` INT DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE posts ADD COLUMN `image_description` VARCHAR(500);");
    mysqli_query($connection, "ALTER TABLE rss_feeds ADD COLUMN `lang_id` INT DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE widgets ADD COLUMN `lang_id` INT DEFAULT 1;");
    mysqli_query($connection, "DELETE FROM pages WHERE slug='index';");
    mysqli_query($connection, "ALTER TABLE posts ADD COLUMN `show_post_url` INT DEFAULT 1;");
    mysqli_query($connection, "UPDATE pages SET slug='rss-feeds' WHERE slug='rss-channels';");

    mysqli_query($connection, "INSERT INTO `general_settings` (`site_lang`, `multilingual_system`, `site_color`, `show_hits`, `show_rss`, `show_newsticker`, `pagination_per_page`, `google_analytics`, `primary_font`, `secondary_font`, `tertiary_font`, `mail_protocol`, `mail_host`, `mail_port`, `mail_username`, `mail_password`, `mail_title`, `facebook_app_id`, `facebook_app_secret`, `google_app_name`, `google_client_id`, `google_client_secret`, `facebook_comment`, `facebook_comment_active`, `show_featured_section`, `show_latest_posts`, `registration_system`, `comment_system`, `show_post_author`, `show_post_date`, `menu_limit`, `copyright`, `head_code`, `vr_key`, `purchase_code`, `recaptcha_site_key`, `recaptcha_secret_key`, `recaptcha_lang`) VALUES
        (1, 1, 'default', 1, 1, 1, 16, '', 'open_sans', 'roboto', 'verdana', 'smtp', '', '', '', '', '', '', '', 'Varient', '', '', '', 1, 1, 1, 1, 1, 1, 1, 8, 'Copyright © 2018 Varient - All Rights Reserved.', '', '" . $license_code . "', '" . $purchase_code . "', '', '', 'en')");

    mysqli_query($connection, "INSERT INTO `settings` (`id`, `lang_id`, `site_title`, `home_title`, `site_description`, `keywords`, `application_name`, `facebook_url`, `twitter_url`, `google_url`, `instagram_url`, `pinterest_url`, `linkedin_url`, `vk_url`, `youtube_url`, `optional_url_button_name`, `about_footer`, `contact_text`, `contact_address`, `contact_email`, `contact_phone`, `map_api_key`, `latitude`, `longitude`, `copyright`, `cookies_warning`, `cookies_warning_text`) VALUES
(1, 1, 'Varient - News Magazine', 'Index', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Click Here To See More', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Copyright © 2018 Varient - All Rights Reserved.', 1, '<p>This site uses cookies. By continuing to browse the site you are agreeing to our use of cookies</p>\r\n');");

    mysqli_query($connection, "INSERT INTO `widgets` (`lang_id`, `title`, `type`, `widget_order`, `visibility`, `is_custom`) VALUES (1, 'Follow Us', 'follow-us', 1, 1, 0);");
    mysqli_query($connection, "INSERT INTO `languages` (`name`, `short_form`, `language_code`, `folder_name`, `text_direction`, `status`, `language_order`) VALUES ('English', 'en', 'en_us', 'default', 'ltr', 1, 1);");

    //add images to images table
    $sql = "SELECT * FROM posts ORDER BY id";
    $result = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_array($result)) {

        if (!empty($row['image_mid'])) {
            $insert = "INSERT INTO images (lang_id, image_big, image_default, image_slider, image_mid, image_small) VALUES (1, '" . $row['image_big'] . "', '" . $row['image_default'] . "', '" . $row['image_slider'] . "', '" . $row['image_mid'] . "', '" . $row['image_small'] . "')";
            mysqli_query($connection, $insert);
        }

    }
    sleep(1);
    //add videos to videos table
    $i = 1;
    $sql = "SELECT * FROM posts ORDER BY id";
    $result = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_array($result)) {

        if (!empty($row['video_path'])) {
            $insert = "INSERT INTO videos (video_name, video_path) VALUES ('video-" . $i . "', '" . $row['video_path'] . "')";
            mysqli_query($connection, $insert);
        }

        $i++;
    }
    sleep(1);
    //add audios to post_audios table
    $sql = "SELECT * FROM audios ORDER BY id";
    $result = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_array($result)) {

        if (!empty($row['post_id'])) {
            $insert = "INSERT INTO post_audios (post_id, audio_id) VALUES ('" . $row['post_id'] . "', '" . $row['id'] . "')";
            mysqli_query($connection, $insert);
        }

    }

    mysqli_query($connection, "ALTER TABLE audios DROP COLUMN `post_id`;");
}

function update_14_to_15($license_code, $purchase_code, $connection)
{
    $sql_reactions = "CREATE TABLE `reactions` (
        `id` INT AUTO_INCREMENT PRIMARY KEY, 
        `post_id` INT,
        `re_like` INT DEFAULT 0,
        `re_dislike` INT DEFAULT 0,
        `re_love` INT DEFAULT 0,
        `re_funny` INT DEFAULT 0,
        `re_angry` INT DEFAULT 0,
        `re_sad` INT DEFAULT 0,
        `re_wow` INT DEFAULT 0
        )ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    /* update database */
    mysqli_query($connection, $sql_reactions);
    mysqli_query($connection, "ALTER TABLE posts ADD COLUMN `show_right_column` INT DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE posts CHANGE COLUMN `video_image_url` `image_url` TEXT;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `emoji_reactions` INT DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `newsletter` INT DEFAULT 1;");

    $sql_follow = "CREATE TABLE `followers` (
        `id` INT AUTO_INCREMENT PRIMARY KEY, 
        `following_id` INT,
        `follower_id` INT
        )ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $sql_hits = "CREATE TABLE `post_hits` (
        `id` INT AUTO_INCREMENT PRIMARY KEY, 
        `post_id` INT,
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP
        )ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $sql_roles = "CREATE TABLE `roles_permissions` (
        `id` INT AUTO_INCREMENT PRIMARY KEY, 
        `role` VARCHAR(255),
        `role_name` VARCHAR(255),
        `admin_panel` INT,
        `add_post` INT,
        `manage_all_posts` INT,
        `navigation` INT,
        `pages` INT,
        `rss_feeds` INT,
        `categories` INT,
        `widgets` INT,
        `polls` INT,
        `gallery` INT,
        `comments_contact` INT,
        `newsletter` INT,
        `ad_spaces` INT,
        `users` INT,
        `seo_tools` INT,
        `settings` INT
        )ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    /* update database */
    mysqli_query($connection, $sql_follow);
    mysqli_query($connection, $sql_hits);
    mysqli_query($connection, $sql_roles);
    sleep(1);
    mysqli_query($connection, "ALTER TABLE audios ADD COLUMN `user_id` INT DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `mail_contact_status` INT DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `mail_contact` VARCHAR(255);");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `cache_system` INT DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `cache_refresh_time` INT DEFAULT 1800;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `refresh_cache_database_changes` INT DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `email_verification` INT DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `file_manager_show_files` INT DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `approve_added_user_posts` INT DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `approve_updated_user_posts` INT DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `timezone` VARCHAR(255) DEFAULT 'America/New_York';");
    mysqli_query($connection, "ALTER TABLE images ADD COLUMN `user_id` INT DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE rss_feeds ADD COLUMN `add_posts_as_draft` INT DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE users ADD COLUMN `email_status` INT DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE users ADD COLUMN `token` VARCHAR(500);");
    mysqli_query($connection, "ALTER TABLE users ADD COLUMN `last_seen` timestamp;");
    mysqli_query($connection, "ALTER TABLE videos ADD COLUMN `user_id` INT DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE visual_settings ADD COLUMN `logo_email` VARCHAR(255);");
    //add roles
    mysqli_query($connection, "INSERT INTO `roles_permissions` 
(`role`, `role_name`, `admin_panel`, `add_post`, `manage_all_posts`, `navigation`, `pages`, `rss_feeds`, `categories`, `widgets`, `polls`, `gallery`, `comments_contact`, `newsletter`, `ad_spaces`, `users`, `seo_tools`, `settings`) 
VALUES ('admin', 'Admin', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);");
    mysqli_query($connection, "INSERT INTO `roles_permissions` 
(`role`, `role_name`, `admin_panel`, `add_post`, `manage_all_posts`, `navigation`, `pages`, `rss_feeds`, `categories`, `widgets`, `polls`, `gallery`, `comments_contact`, `newsletter`, `ad_spaces`, `users`, `seo_tools`, `settings`) 
VALUES ('moderator', 'Moderator', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0);");
    mysqli_query($connection, "INSERT INTO `roles_permissions` 
(`role`, `role_name`, `admin_panel`, `add_post`, `manage_all_posts`, `navigation`, `pages`, `rss_feeds`, `categories`, `widgets`, `polls`, `gallery`, `comments_contact`, `newsletter`, `ad_spaces`, `users`, `seo_tools`, `settings`) 
VALUES ('author', 'Author', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);");
    mysqli_query($connection, "INSERT INTO `roles_permissions` 
(`role`, `role_name`, `admin_panel`, `add_post`, `manage_all_posts`, `navigation`, `pages`, `rss_feeds`, `categories`, `widgets`, `polls`, `gallery`, `comments_contact`, `newsletter`, `ad_spaces`, `users`, `seo_tools`, `settings`) 
VALUES ('user', 'User', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);");
}

function update_15_to_16($license_code, $purchase_code, $connection)
{
    $sql_gallery_albums = "CREATE TABLE `gallery_albums` (
        `id` INT AUTO_INCREMENT PRIMARY KEY, 
        `lang_id` int(11) DEFAULT '1',
        `name` varchar(255) DEFAULT NULL,
        `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $sql_post_gallery_items = "CREATE TABLE `post_gallery_items` (
          `id` INT AUTO_INCREMENT PRIMARY KEY, 
          `post_id` int(11) DEFAULT NULL,
          `title` varchar(500) DEFAULT NULL,
          `content` text,
          `image` varchar(255) DEFAULT NULL,
          `image_large` varchar(255) DEFAULT NULL,
          `image_description` varchar(255) DEFAULT NULL,
          `item_order` smallint(6) DEFAULT NULL,
          `is_collapsed` tinyint(1) DEFAULT '0'
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $sql_post_ordered_list_items = "CREATE TABLE `post_ordered_list_items` (
           `id` INT AUTO_INCREMENT PRIMARY KEY, 
          `post_id` int(11) DEFAULT NULL,
          `title` varchar(500) DEFAULT NULL,
          `content` text,
          `image` varchar(255) DEFAULT NULL,
          `image_large` varchar(255) DEFAULT NULL,
          `image_description` varchar(255) DEFAULT NULL,
          `item_order` smallint(6) DEFAULT NULL,
          `is_collapsed` tinyint(1) DEFAULT '0'
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    /* update database */
    mysqli_query($connection, $sql_gallery_albums);
    mysqli_query($connection, $sql_post_gallery_items);
    mysqli_query($connection, $sql_post_ordered_list_items);
    sleep(1);
    mysqli_query($connection, "ALTER TABLE comments ADD COLUMN `email` VARCHAR(255);");
    mysqli_query($connection, "ALTER TABLE comments ADD COLUMN `name` VARCHAR(255);");
    mysqli_query($connection, "ALTER TABLE comments ADD COLUMN `ip_address` VARCHAR(100);");
    mysqli_query($connection, "ALTER TABLE comments ADD COLUMN `like_count` INT DEFAULT 0;");
    mysqli_query($connection, "DROP TABLE comment_likes;");
    mysqli_query($connection, "ALTER TABLE gallery ADD COLUMN `album_id` INT DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE gallery ADD COLUMN `is_album_cover` TINYINT(1) DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE gallery_categories ADD COLUMN `album_id` INT DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `mail_library` VARCHAR(100) DEFAULT 'swift';");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `google_client_id` VARCHAR(500);");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `google_client_secret` VARCHAR(500);");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `vk_app_id` VARCHAR(500);");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `vk_secure_key` VARCHAR(500);");
    mysqli_query($connection, "ALTER TABLE general_settings DROP COLUMN `google_app_name`;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `sort_slider_posts` VARCHAR(100) DEFAULT 'by_slider_order';");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `sort_featured_posts` VARCHAR(100) DEFAULT 'by_featured_order';");
    mysqli_query($connection, "ALTER TABLE general_settings DROP COLUMN `copyright`;");
    mysqli_query($connection, "ALTER TABLE post_images DROP COLUMN `created_at`;");
    mysqli_query($connection, "ALTER TABLE tags DROP COLUMN `created_at`;");
    mysqli_query($connection, "ALTER TABLE images ADD COLUMN `image_mime` VARCHAR(50) DEFAULT 'jpg';");
    mysqli_query($connection, "ALTER TABLE newsletters ADD COLUMN `token` VARCHAR(255);");
    mysqli_query($connection, "ALTER TABLE posts ADD COLUMN `title_hash` VARCHAR(500);");
    mysqli_query($connection, "ALTER TABLE posts ADD COLUMN `image_mime` VARCHAR(20) DEFAULT 'jpg';");
    mysqli_query($connection, "ALTER TABLE posts ADD COLUMN `is_scheduled` TINYINT(1) DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE posts ADD COLUMN `show_item_numbers` TINYINT(1) DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE rss_feeds ADD COLUMN `image_mime` VARCHAR(20) DEFAULT 'jpg';");
    mysqli_query($connection, "ALTER TABLE settings DROP COLUMN `google_url`;");
    mysqli_query($connection, "ALTER TABLE settings ADD COLUMN `telegram_url` VARCHAR(500);");
    mysqli_query($connection, "ALTER TABLE users ADD COLUMN `vk_id` VARCHAR(255);");
    mysqli_query($connection, "ALTER TABLE users ADD COLUMN `telegram_url` VARCHAR(500);");
    mysqli_query($connection, "ALTER TABLE users ADD COLUMN `show_email_on_profile` TINYINT(1) DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE users ADD COLUMN `show_rss_feeds` TINYINT(1) DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE users DROP COLUMN `google_url`;");

    $del = "DELETE FROM pages WHERE slug='register';";
    mysqli_query($connection, $del);
    $del = "DELETE FROM pages WHERE slug='reset-password';";
    mysqli_query($connection, $del);
    $del = "DELETE FROM pages WHERE slug='posts';";
    mysqli_query($connection, $del);
    $del = "DELETE FROM pages WHERE slug='rss-feeds';";
    mysqli_query($connection, $del);
    $del = "DELETE FROM pages WHERE slug='reading-list';";
    mysqli_query($connection, $del);

    $sql = "SELECT * FROM languages";
    $result = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_array($result)) {
        if (!empty($row['id'])) {
            $insert = "INSERT INTO pages (`lang_id`, `title`, `slug`, `description`, `keywords`, `is_custom`, `page_content`, `page_order`, `visibility`, `title_active`, `breadcrumb_active`, `right_column_active`, `need_auth`, `location`, `parent_id`, `page_type`) 
                VALUES ('" . $row['id'] . "', 'Terms & Conditions', 'terms-conditions', 'Varient Terms Conditions Page','varient, terms, conditions', 0, NULL, 1, 1, 1, 1, 0, 0, 'footer', 0, 'page')";
            mysqli_query($connection, $insert);

            $insert = "INSERT INTO  gallery_albums (`lang_id`, `name`) 
                VALUES ('" . $row['id'] . "', 'Album 1')";
            mysqli_query($connection, $insert);
        }
    }
}

function update_16_to_17($license_code, $purchase_code, $connection)
{
    $table_sessions = "CREATE TABLE IF NOT EXISTS `ci_sessions` (
    `id` varchar(128) NOT NULL,
    `ip_address` varchar(45) NOT NULL,
    `timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
    `data` blob NOT NULL,
    KEY `ci_sessions_timestamp` (`timestamp`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $table_files = "CREATE TABLE `files` (
      `id` INT AUTO_INCREMENT PRIMARY KEY,
      `file_name` varchar(255) DEFAULT NULL,
      `file_path` varchar(255) DEFAULT NULL,
      `user_id` int(11) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $table_fonts = "CREATE TABLE `fonts` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `font_name` varchar(255) DEFAULT NULL,
    `font_url` varchar(2000) DEFAULT NULL,
    `font_family` varchar(500) DEFAULT NULL,
    `is_default` tinyint(1) DEFAULT '0'
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $table_post_files = "CREATE TABLE `post_files` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `post_id` int(11) DEFAULT NULL,
    `file_id` int(11) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $table_quiz_answers = "CREATE TABLE `quiz_answers` (
     `id` INT AUTO_INCREMENT PRIMARY KEY,
      `question_id` int(11) DEFAULT NULL,
      `image_path` varchar(255) DEFAULT NULL,
      `answer_text` varchar(500) DEFAULT NULL,
      `is_correct` tinyint(1) DEFAULT NULL,
      `assigned_result_id` int(11) DEFAULT 0
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $table_quiz_images = "CREATE TABLE `quiz_images` (
     `id` INT AUTO_INCREMENT PRIMARY KEY,
      `image_default` varchar(255) DEFAULT NULL,
      `image_small` varchar(255) DEFAULT NULL,
      `file_name` varchar(255) NOT NULL,
      `image_mime` varchar(20) DEFAULT 'jpg',
      `user_id` int(11) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $table_quiz_questions = "CREATE TABLE `quiz_questions` (
     `id` INT AUTO_INCREMENT PRIMARY KEY,
      `post_id` int(11) DEFAULT NULL,
      `question` varchar(500) DEFAULT NULL,
      `image_path` varchar(255) DEFAULT NULL,
      `description` text,
      `question_order` int(11) DEFAULT '1',
      `answer_format` varchar(30) DEFAULT 'small_image'
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $table_quiz_results = "CREATE TABLE `quiz_results` (
     `id` INT AUTO_INCREMENT PRIMARY KEY,
      `post_id` int(11) DEFAULT NULL,
      `result_title` varchar(500) DEFAULT NULL,
      `image_path` varchar(255) DEFAULT NULL,
      `description` text,
      `min_correct_count` mediumint(9) DEFAULT NULL,
      `max_correct_count` mediumint(9) DEFAULT NULL,
      `result_order` int(11) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $table_routes = "CREATE TABLE `routes` (
     `id` INT AUTO_INCREMENT PRIMARY KEY,
      `admin` varchar(100) DEFAULT 'admin',
      `profile` varchar(100) DEFAULT 'profile',
      `tag` varchar(100) DEFAULT 'tag',
      `reading_list` varchar(100) DEFAULT 'reading-list',
      `settings` varchar(100) DEFAULT 'settings',
      `social_accounts` varchar(100) DEFAULT 'social-accounts',
      `preferences` varchar(100) DEFAULT 'preferences',
      `visual_settings` varchar(100) DEFAULT 'visual-settings',
      `change_password` varchar(100) DEFAULT 'change-password',
      `forgot_password` varchar(100) DEFAULT 'forgot-password',
      `reset_password` varchar(100) DEFAULT 'reset-password',
      `register` varchar(100) DEFAULT 'register',
      `posts` varchar(100) DEFAULT 'posts',
      `search` varchar(100) DEFAULT 'search',
      `rss_feeds` varchar(100) DEFAULT 'rss-feeds',
      `gallery_album` varchar(100) DEFAULT 'gallery-album',
      `logout` varchar(100) DEFAULT 'logout'
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    mysqli_query($connection, $table_sessions);
    mysqli_query($connection, $table_files);
    mysqli_query($connection, $table_fonts);
    mysqli_query($connection, $table_post_files);
    mysqli_query($connection, $table_quiz_answers);
    mysqli_query($connection, $table_quiz_images);
    mysqli_query($connection, $table_quiz_questions);
    mysqli_query($connection, $table_quiz_results);
    mysqli_query($connection, $table_routes);
    sleep(1);
    mysqli_query($connection, "ALTER TABLE audios DROP COLUMN `musician`;");
    mysqli_query($connection, "ALTER TABLE comments ADD COLUMN `status` TINYINT(1) DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE general_settings DROP COLUMN `site_color`;");
    mysqli_query($connection, "ALTER TABLE general_settings DROP COLUMN `primary_font`;");
    mysqli_query($connection, "ALTER TABLE general_settings DROP COLUMN `secondary_font`;");
    mysqli_query($connection, "ALTER TABLE general_settings DROP COLUMN `tertiary_font`;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `comment_approval_system` TINYINT(1) DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE general_settings CHANGE `head_code` `custom_css_codes` MEDIUMTEXT;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `custom_javascript_codes` MEDIUMTEXT;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `adsense_activation_code` TEXT;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `audio_download_button` TINYINT(1) DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `text_editor_lang` VARCHAR(30) DEFAULT 'en';");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `show_home_link` TINYINT(1) DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `post_format_article` TINYINT(1) DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `post_format_gallery` TINYINT(1) DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `post_format_sorted_list` TINYINT(1) DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `post_format_video` TINYINT(1) DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `post_format_audio` TINYINT(1) DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `post_format_trivia_quiz` TINYINT(1) DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `post_format_personality_quiz` TINYINT(1) DEFAULT 1;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `maintenance_mode_title` VARCHAR(500) DEFAULT 'Coming Soon!';");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `maintenance_mode_description` VARCHAR(5000) DEFAULT \"Our website is under construction. We'll be here soon with our new awesome site.\";");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `maintenance_mode_status` TINYINT(1) DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `sitemap_frequency` VARCHAR(30) DEFAULT 'monthly';");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `sitemap_last_modification` VARCHAR(30) DEFAULT 'server_response';");
    mysqli_query($connection, "ALTER TABLE general_settings ADD COLUMN `sitemap_priority` VARCHAR(30) DEFAULT 'automatically';");
    mysqli_query($connection, "ALTER TABLE general_settings DROP COLUMN `created_at`;");
    mysqli_query($connection, "ALTER TABLE images ADD COLUMN `file_name` VARCHAR(255);");
    mysqli_query($connection, "RENAME TABLE newsletters TO subscribers;");
    mysqli_query($connection, "ALTER TABLE pages ADD COLUMN `page_default_name` VARCHAR(100);");
    mysqli_query($connection, "ALTER TABLE posts CHANGE `hit` `pageviews` INT(11) DEFAULT 0;");
    mysqli_query($connection, "ALTER TABLE posts ADD COLUMN `updated_at` TIMESTAMP NULL;");
    mysqli_query($connection, "ALTER TABLE posts ADD COLUMN `video_url` VARCHAR(2000);");
    mysqli_query($connection, "ALTER TABLE post_gallery_items DROP COLUMN `is_collapsed`;");
    mysqli_query($connection, "ALTER TABLE post_ordered_list_items DROP COLUMN `is_collapsed`;");
    mysqli_query($connection, "RENAME TABLE post_ordered_list_items TO post_sorted_list_items;");
    mysqli_query($connection, "RENAME TABLE post_hits TO post_pageviews;");
    mysqli_query($connection, "ALTER TABLE post_pageviews ADD COLUMN `ip_address` VARCHAR(30);");
    mysqli_query($connection, "ALTER TABLE rss_feeds ADD COLUMN `image_saving_method` VARCHAR(30) DEFAULT 'url';");
    mysqli_query($connection, "ALTER TABLE rss_feeds DROP COLUMN `image_big`;");
    mysqli_query($connection, "ALTER TABLE rss_feeds DROP COLUMN `image_default`;");
    mysqli_query($connection, "ALTER TABLE rss_feeds DROP COLUMN `image_slider`;");
    mysqli_query($connection, "ALTER TABLE rss_feeds DROP COLUMN `image_mid`;");
    mysqli_query($connection, "ALTER TABLE rss_feeds DROP COLUMN `image_small`;");
    mysqli_query($connection, "ALTER TABLE rss_feeds DROP COLUMN `image_mime`;");
    mysqli_query($connection, "ALTER TABLE settings ADD COLUMN `primary_font` SMALLINT(6) DEFAULT 19;");
    mysqli_query($connection, "ALTER TABLE settings ADD COLUMN `secondary_font` SMALLINT(6) DEFAULT 25;");
    mysqli_query($connection, "ALTER TABLE settings ADD COLUMN `tertiary_font` SMALLINT(6) DEFAULT 32;");
    mysqli_query($connection, "ALTER TABLE settings DROP COLUMN IF EXISTS `created_at`;");
    mysqli_query($connection, "ALTER TABLE users ADD COLUMN `site_mode` VARCHAR(10);");
    mysqli_query($connection, "ALTER TABLE users ADD COLUMN `site_color` VARCHAR(30);");
    mysqli_query($connection, "ALTER TABLE visual_settings ADD COLUMN `dark_mode` TINYINT(1) DEFAULT 0;");

    //add routes
    $sql_routes = "INSERT INTO `routes` (`id`, `admin`, `profile`, `tag`, `reading_list`, `settings`, `social_accounts`, `preferences`, `visual_settings`, `change_password`, `forgot_password`, `reset_password`, `register`, `posts`, `search`, `rss_feeds`, `gallery_album`, `logout`) VALUES
(1, 'admin', 'profile', 'tag', 'reading-list', 'settings', 'social-accounts', 'preferences', 'visual-settings', 'change-password', 'forgot-password', 'reset-password', 'register', 'posts', 'search', 'rss-feeds', 'gallery-album', 'logout');";
    mysqli_query($connection, $sql_routes);

    //add fonts
    $sql_fonts="INSERT INTO `fonts` (`id`, `font_name`, `font_url`, `font_family`, `is_default`) VALUES
(1, 'Arial', NULL, 'font-family: Arial, Helvetica, sans-serif', 1),
(2, 'Arvo', '<link href=\"https://fonts.googleapis.com/css?family=Arvo:400,700&display=swap\" rel=\"stylesheet\">\r\n', 'font-family: \"Arvo\", Helvetica, sans-serif', 0),
(3, 'Averia Libre', '<link href=\"https://fonts.googleapis.com/css?family=Averia+Libre:300,400,700&display=swap\" rel=\"stylesheet\">\r\n', 'font-family: \"Averia Libre\", Helvetica, sans-serif', 0),
(4, 'Bitter', '<link href=\"https://fonts.googleapis.com/css?family=Bitter:400,400i,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Bitter\", Helvetica, sans-serif', 0),
(5, 'Cabin', '<link href=\"https://fonts.googleapis.com/css?family=Cabin:400,500,600,700&display=swap&subset=latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Cabin\", Helvetica, sans-serif', 0),
(6, 'Cherry Swash', '<link href=\"https://fonts.googleapis.com/css?family=Cherry+Swash:400,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Cherry Swash\", Helvetica, sans-serif', 0),
(7, 'Encode Sans', '<link href=\"https://fonts.googleapis.com/css?family=Encode+Sans:300,400,500,600,700&display=swap&subset=latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Encode Sans\", Helvetica, sans-serif', 0),
(8, 'Helvetica', NULL, 'font-family: Helvetica, sans-serif', 1),
(9, 'Hind', '<link href=\"https://fonts.googleapis.com/css?family=Hind:300,400,500,600,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">', 'font-family: \"Hind\", Helvetica, sans-serif', 0),
(10, 'Josefin Sans', '<link href=\"https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,600,700&display=swap&subset=latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Josefin Sans\", Helvetica, sans-serif', 0),
(11, 'Kalam', '<link href=\"https://fonts.googleapis.com/css?family=Kalam:300,400,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Kalam\", Helvetica, sans-serif', 0),
(12, 'Khula', '<link href=\"https://fonts.googleapis.com/css?family=Khula:300,400,600,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Khula\", Helvetica, sans-serif', 0),
(13, 'Lato', '<link href=\"https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">', 'font-family: \"Lato\", Helvetica, sans-serif', 0),
(14, 'Lora', '<link href=\"https://fonts.googleapis.com/css?family=Lora:400,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Lora\", Helvetica, sans-serif', 0),
(15, 'Merriweather', '<link href=\"https://fonts.googleapis.com/css?family=Merriweather:300,400,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Merriweather\", Helvetica, sans-serif', 0),
(16, 'Montserrat', '<link href=\"https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Montserrat\", Helvetica, sans-serif', 0),
(17, 'Mukta', '<link href=\"https://fonts.googleapis.com/css?family=Mukta:300,400,500,600,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Mukta\", Helvetica, sans-serif', 0),
(18, 'Nunito', '<link href=\"https://fonts.googleapis.com/css?family=Nunito:300,400,600,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Nunito\", Helvetica, sans-serif', 0),
(19, 'Open Sans', '<link href=\"https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese\" rel=\"stylesheet\">', 'font-family: \"Open Sans\", Helvetica, sans-serif', 0),
(20, 'Oswald', '<link href=\"https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext,vietnamese\" rel=\"stylesheet\">', 'font-family: \"Oswald\", Helvetica, sans-serif', 0),
(21, 'Oxygen', '<link href=\"https://fonts.googleapis.com/css?family=Oxygen:300,400,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Oxygen\", Helvetica, sans-serif', 0),
(22, 'Poppins', '<link href=\"https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap&subset=devanagari,latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Poppins\", Helvetica, sans-serif', 0),
(23, 'PT Sans', '<link href=\"https://fonts.googleapis.com/css?family=PT+Sans:400,700&display=swap&subset=cyrillic,cyrillic-ext,latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"PT Sans\", Helvetica, sans-serif', 0),
(24, 'Raleway', '<link href=\"https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">\r\n', 'font-family: \"Raleway\", Helvetica, sans-serif', 0),
(25, 'Roboto', '<link href=\"https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese\" rel=\"stylesheet\">', 'font-family: \"Roboto\", Helvetica, sans-serif', 0),
(26, 'Roboto Condensed', '<link href=\"https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Roboto Condensed\", Helvetica, sans-serif', 0),
(27, 'Roboto Slab', '<link href=\"https://fonts.googleapis.com/css?family=Roboto+Slab:300,400,500,600,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Roboto Slab\", Helvetica, sans-serif', 0),
(28, 'Rokkitt', '<link href=\"https://fonts.googleapis.com/css?family=Rokkitt:300,400,500,600,700&display=swap&subset=latin-ext,vietnamese\" rel=\"stylesheet\">\r\n', 'font-family: \"Rokkitt\", Helvetica, sans-serif', 0),
(29, 'Source Sans Pro', '<link href=\"https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese\" rel=\"stylesheet\">', 'font-family: \"Source Sans Pro\", Helvetica, sans-serif', 0),
(30, 'Titillium Web', '<link href=\"https://fonts.googleapis.com/css?family=Titillium+Web:300,400,600,700&display=swap&subset=latin-ext\" rel=\"stylesheet\">', 'font-family: \"Titillium Web\", Helvetica, sans-serif', 0),
(31, 'Ubuntu', '<link href=\"https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext\" rel=\"stylesheet\">', 'font-family: \"Ubuntu\", Helvetica, sans-serif', 0),
(32, 'Verdana', NULL, 'font-family: Verdana, Helvetica, sans-serif', 1);";
    mysqli_query($connection, $sql_fonts);

    //update page default names
    $sql = "SELECT * FROM pages ORDER BY id";
    $result = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $page_default_name = "";
        if ($row['slug'] == 'contact') {
            $page_default_name = 'contact';
        }
        if ($row['slug'] == 'gallery') {
            $page_default_name = 'gallery';
        }
        if ($row['slug'] == 'terms-conditions') {
            $page_default_name = 'terms_conditions';
        }
        if (!empty($page_default_name)) {
            mysqli_query($connection, "UPDATE pages SET `page_default_name`='" . $page_default_name . "' WHERE id=" . $row['id']);
        }
    }

    //update posts
    $sql = "SELECT * FROM posts ORDER BY id";
    $result = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $cat_id = 0;
        if (!empty($row['subcategory_id'])) {
            $cat_id = $row['subcategory_id'];
        } elseif (!empty($row['category_id'])) {
            $cat_id = $row['category_id'];
        }
        $post_type = $row['post_type'];
        if ($post_type == "post") {
            $post_type = 'article';
        }
        if ($post_type == "ordered_list") {
            $post_type = 'sorted_list';
        }
        mysqli_query($connection, "UPDATE posts SET `category_id`=" . $cat_id . ", `post_type`='" . $post_type . "' WHERE id=" . $row['id']);
    }
    sleep(1);
    mysqli_query($connection, "ALTER TABLE posts DROP COLUMN `subcategory_id`;");

    //update rss feeds
    $sql = "SELECT * FROM rss_feeds ORDER BY id";
    $result = mysqli_query($connection, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $cat_id = 0;
        if (!empty($row['subcategory_id'])) {
            $cat_id = $row['subcategory_id'];
        } elseif (!empty($row['category_id'])) {
            $cat_id = $row['category_id'];
        }
        mysqli_query($connection, "UPDATE rss_feeds SET `category_id`=" . $cat_id . " WHERE id=" . $row['id']);
    }
    sleep(1);
    mysqli_query($connection, "ALTER TABLE rss_feeds DROP COLUMN `subcategory_id`;");

    //add keys
    mysqli_query($connection, "ALTER TABLE comments ADD INDEX idx_parent_id (parent_id);");
    mysqli_query($connection, "ALTER TABLE comments ADD INDEX idx_post_id (post_id);");
    mysqli_query($connection, "ALTER TABLE comments ADD INDEX idx_status (status);");
    mysqli_query($connection, "ALTER TABLE posts ADD INDEX idx_lang_id (lang_id);");
    mysqli_query($connection, "ALTER TABLE posts ADD INDEX idx_category_id (category_id);");
    mysqli_query($connection, "ALTER TABLE posts ADD INDEX idx_is_slider (is_slider);");
    mysqli_query($connection, "ALTER TABLE posts ADD INDEX idx_is_featured (is_featured);");
    mysqli_query($connection, "ALTER TABLE posts ADD INDEX idx_is_recommended (is_recommended);");
    mysqli_query($connection, "ALTER TABLE posts ADD INDEX idx_is_breaking (is_breaking);");
    mysqli_query($connection, "ALTER TABLE posts ADD INDEX idx_is_scheduled (is_scheduled);");
    mysqli_query($connection, "ALTER TABLE posts ADD INDEX idx_visibility (visibility);");
    mysqli_query($connection, "ALTER TABLE posts ADD INDEX idx_user_id (user_id);");
    mysqli_query($connection, "ALTER TABLE posts ADD INDEX idx_status (status);");
    mysqli_query($connection, "ALTER TABLE posts ADD INDEX idx_created_at (created_at)");
    mysqli_query($connection, "ALTER TABLE post_pageviews ADD INDEX idx_post_id (post_id)");
    mysqli_query($connection, "ALTER TABLE post_pageviews ADD INDEX idx_created_at (created_at)");
    mysqli_query($connection, "ALTER TABLE tags ADD INDEX idx_post_id (post_id)");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Varient - Update Wizard</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700" rel="stylesheet">
    <!-- Font-awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #444 !important;
            font-size: 14px;

            background: #007991; /* fallback for old browsers */
            background: -webkit-linear-gradient(to left, #007991, #6fe7c2); /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to left, #007991, #6fe7c2); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

        }

        .logo-cnt {
            text-align: center;
            color: #fff;
            padding: 60px 0 60px 0;
        }

        .logo-cnt .logo {
            font-size: 42px;
            line-height: 42px;
        }

        .logo-cnt p {
            font-size: 22px;
        }

        .install-box {
            width: 100%;
            padding: 30px;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            margin: auto;
            background-color: #fff;
            border-radius: 4px;
            display: block;
            float: left;
            margin-bottom: 100px;
        }

        .form-input {
            box-shadow: none !important;
            border: 1px solid #ddd;
            height: 44px;
            line-height: 44px;
            padding: 0 20px;
        }

        .form-input:focus {
            border-color: #239CA1 !important;
        }

        .btn-custom {
            background-color: #239CA1 !important;
            border-color: #239CA1 !important;
            border: 0 none;
            border-radius: 4px;
            box-shadow: none;
            color: #fff !important;
            font-size: 16px;
            font-weight: 300;
            height: 40px;
            line-height: 40px;
            margin: 0;
            min-width: 105px;
            padding: 0 20px;
            text-shadow: none;
            vertical-align: middle;
        }

        .btn-custom:hover, .btn-custom:active, .btn-custom:focus {
            background-color: #239CA1;
            border-color: #239CA1;
            opacity: .8;
        }

        .tab-content {
            width: 100%;
            float: left;
            display: block;
        }

        .tab-footer {
            width: 100%;
            float: left;
            display: block;
        }

        .buttons {
            display: block;
            float: left;
            width: 100%;
            margin-top: 30px;
        }

        .title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
            margin-top: 0;
            text-align: center;
        }

        .sub-title {
            font-size: 14px;
            font-weight: 400;
            margin-bottom: 30px;
            margin-top: 0;
            text-align: center;
        }

        .alert {
            text-align: center;
        }

        .alert strong {
            font-weight: 500 !important;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-sm-12 col-md-offset-2">

            <div class="row">
                <div class="col-sm-12 logo-cnt">
                    <h1>Varient</h1>
                    <p>Welcome to the Update Wizard</p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="install-box">
                        <h2 class="title">Update from v1.3.x to v1.7.1</h2>
                        <br><br>
                        <div class="messages">
                            <?php if (!empty($error)) { ?>
                                <div class="alert alert-danger">
                                    <strong><?php echo $error; ?></strong>
                                </div>
                            <?php } ?>
                            <?php if (!empty($success)) { ?>
                                <div class="alert alert-success">
                                    <strong><?php echo $success; ?></strong>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="step-contents">
                            <div class="tab-1">
                                <?php if (empty($success)): ?>
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                        <div class="tab-content">
                                            <div class="tab_1">
                                                <div class="form-group">
                                                    <label for="email">License Code</label>
                                                    <textarea name="license_code" class="form-control form-input" style="resize: vertical; min-height: 80px; height: 80px; line-height: 24px;padding: 10px;" placeholder="Enter License Code" required><?php echo $license_code; ?></textarea>
                                                    <small style="margin-top: 10px;display: block">*If you have forgotten your license code, you can get your license code by entering your domain and purchase code from here: <a href="http://license.codingest.com/varient-license" target="_blank">http://license.codingest.com/varient-license</a>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-footer">
                                            <button type="submit" name="btn_submit" class="btn-custom pull-right">Update My Database</button>
                                        </div>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
