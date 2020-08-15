-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 13, 2020 at 07:46 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;

--
-- Database: `install_varient`
--

-- --------------------------------------------------------

--
-- Table structure for table `ad_spaces`
--

CREATE TABLE `ad_spaces` (
  `id` int(11) NOT NULL,
  `ad_space` text DEFAULT NULL,
  `ad_code_728` text DEFAULT NULL,
  `ad_code_468` text DEFAULT NULL,
  `ad_code_300` text DEFAULT NULL,
  `ad_code_234` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ad_spaces`
--

INSERT INTO `ad_spaces` (`id`, `ad_space`, `ad_code_728`, `ad_code_468`, `ad_code_300`, `ad_code_234`) VALUES
(1, 'index_top', NULL, NULL, NULL, NULL),
(2, 'index_bottom', NULL, NULL, NULL, NULL),
(3, 'post_top', NULL, NULL, NULL, NULL),
(4, 'post_bottom', NULL, NULL, NULL, NULL),
(5, 'category_top', NULL, NULL, NULL, NULL),
(6, 'category_bottom', NULL, NULL, NULL, NULL),
(7, 'tag_top', NULL, NULL, NULL, NULL),
(8, 'tag_bottom', NULL, NULL, NULL, NULL),
(9, 'search_top', NULL, NULL, NULL, NULL),
(10, 'search_bottom', NULL, NULL, NULL, NULL),
(11, 'profile_top', NULL, NULL, NULL, NULL),
(12, 'profile_bottom', NULL, NULL, NULL, NULL),
(13, 'reading_list_top', NULL, NULL, NULL, NULL),
(14, 'reading_list_bottom', NULL, NULL, NULL, NULL),
(15, 'sidebar_top', NULL, NULL, NULL, NULL),
(16, 'sidebar_bottom', NULL, NULL, NULL, NULL),
(17, 'header', NULL, NULL, NULL, NULL),
(18, 'posts_top', NULL, NULL, NULL, NULL),
(19, 'posts_bottom', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `audios`
--

CREATE TABLE `audios` (
  `id` int(11) NOT NULL,
  `audio_name` varchar(255) DEFAULT NULL,
  `audio_path` varchar(255) DEFAULT NULL,
  `download_button` tinyint(1) DEFAULT 1,
  `user_id` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `lang_id` int(11) DEFAULT 1,
  `name` varchar(255) DEFAULT NULL,
  `name_slug` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT 0,
  `description` varchar(500) DEFAULT NULL,
  `keywords` varchar(500) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `block_type` varchar(255) DEFAULT NULL,
  `category_order` int(11) DEFAULT 0,
  `show_at_homepage` tinyint(1) DEFAULT 1,
  `show_on_menu` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT 0,
  `post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `comment` varchar(5000) DEFAULT NULL,
  `ip_address` varchar(100) DEFAULT NULL,
  `like_count` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `message` varchar(5000) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `id` int(11) NOT NULL,
  `following_id` int(11) DEFAULT NULL,
  `follower_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fonts`
--

CREATE TABLE `fonts` (
  `id` int(11) NOT NULL,
  `font_name` varchar(255) DEFAULT NULL,
  `font_url` varchar(2000) DEFAULT NULL,
  `font_family` varchar(500) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fonts`
--

INSERT INTO `fonts` (`id`, `font_name`, `font_url`, `font_family`, `is_default`) VALUES
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
(32, 'Verdana', NULL, 'font-family: Verdana, Helvetica, sans-serif', 1);

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `lang_id` int(11) DEFAULT 1,
  `title` varchar(500) DEFAULT NULL,
  `album_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `path_big` varchar(255) DEFAULT NULL,
  `path_small` varchar(255) DEFAULT NULL,
  `is_album_cover` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_albums`
--

CREATE TABLE `gallery_albums` (
  `id` int(11) NOT NULL,
  `lang_id` int(11) DEFAULT 1,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_categories`
--

CREATE TABLE `gallery_categories` (
  `id` int(11) NOT NULL,
  `lang_id` int(11) DEFAULT 1,
  `name` varchar(255) DEFAULT NULL,
  `album_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` int(11) NOT NULL,
  `site_lang` int(11) NOT NULL DEFAULT 1,
  `multilingual_system` tinyint(1) DEFAULT 1,
  `show_hits` tinyint(1) DEFAULT 1,
  `show_rss` tinyint(1) DEFAULT 1,
  `show_newsticker` tinyint(1) DEFAULT 1,
  `pagination_per_page` smallint(6) DEFAULT 10,
  `google_analytics` text DEFAULT NULL,
  `mail_library` varchar(100) DEFAULT 'swift',
  `mail_protocol` varchar(100) DEFAULT 'smtp',
  `mail_host` varchar(255) DEFAULT NULL,
  `mail_port` varchar(255) DEFAULT '587',
  `mail_username` varchar(255) DEFAULT NULL,
  `mail_password` varchar(255) DEFAULT NULL,
  `mail_title` varchar(255) DEFAULT NULL,
  `google_client_id` varchar(500) DEFAULT NULL,
  `google_client_secret` varchar(500) DEFAULT NULL,
  `vk_app_id` varchar(500) DEFAULT NULL,
  `vk_secure_key` varchar(500) DEFAULT NULL,
  `facebook_app_id` varchar(500) DEFAULT NULL,
  `facebook_app_secret` varchar(500) DEFAULT NULL,
  `facebook_comment` text DEFAULT NULL,
  `facebook_comment_active` tinyint(1) DEFAULT 1,
  `show_featured_section` tinyint(1) DEFAULT 1,
  `show_latest_posts` tinyint(1) DEFAULT 1,
  `registration_system` tinyint(1) DEFAULT 1,
  `comment_system` tinyint(1) DEFAULT 1,
  `comment_approval_system` tinyint(1) DEFAULT 1,
  `show_post_author` tinyint(1) DEFAULT 1,
  `show_post_date` tinyint(1) DEFAULT 1,
  `menu_limit` tinyint(4) DEFAULT 8,
  `custom_css_codes` mediumtext DEFAULT NULL,
  `custom_javascript_codes` mediumtext DEFAULT NULL,
  `adsense_activation_code` text DEFAULT NULL,
  `vr_key` varchar(500) DEFAULT NULL,
  `purchase_code` varchar(255) DEFAULT NULL,
  `recaptcha_site_key` varchar(255) DEFAULT NULL,
  `recaptcha_secret_key` varchar(255) DEFAULT NULL,
  `recaptcha_lang` varchar(50) DEFAULT NULL,
  `emoji_reactions` tinyint(1) DEFAULT 1,
  `mail_contact_status` tinyint(1) DEFAULT 0,
  `mail_contact` varchar(255) DEFAULT NULL,
  `cache_system` tinyint(1) DEFAULT 0,
  `cache_refresh_time` int(11) DEFAULT 1800,
  `refresh_cache_database_changes` tinyint(1) DEFAULT 0,
  `email_verification` tinyint(1) DEFAULT 0,
  `file_manager_show_files` tinyint(1) DEFAULT 1,
  `audio_download_button` tinyint(1) DEFAULT 1,
  `approve_added_user_posts` tinyint(1) DEFAULT 1,
  `approve_updated_user_posts` tinyint(1) DEFAULT 1,
  `timezone` varchar(255) DEFAULT 'America/New_York',
  `sort_slider_posts` varchar(100) DEFAULT 'by_slider_order',
  `sort_featured_posts` varchar(100) DEFAULT 'by_featured_order',
  `newsletter` tinyint(1) DEFAULT 1,
  `text_editor_lang` varchar(30) DEFAULT 'en',
  `show_home_link` tinyint(1) DEFAULT 1,
  `post_format_article` tinyint(1) DEFAULT 1,
  `post_format_gallery` tinyint(1) DEFAULT 1,
  `post_format_sorted_list` tinyint(1) DEFAULT 1,
  `post_format_video` tinyint(1) DEFAULT 1,
  `post_format_audio` tinyint(1) DEFAULT 1,
  `post_format_trivia_quiz` tinyint(1) DEFAULT 1,
  `post_format_personality_quiz` tinyint(1) DEFAULT 1,
  `maintenance_mode_title` varchar(500) DEFAULT 'Coming Soon!',
  `maintenance_mode_description` varchar(5000) DEFAULT NULL,
  `maintenance_mode_status` tinyint(1) DEFAULT 0,
  `sitemap_frequency` varchar(30) DEFAULT 'monthly',
  `sitemap_last_modification` varchar(30) DEFAULT 'server_response',
  `sitemap_priority` varchar(30) DEFAULT 'automatically',
  `last_popular_post_update` timestamp NULL DEFAULT NULL,
  `version` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `site_lang`, `multilingual_system`, `show_hits`, `show_rss`, `show_newsticker`, `pagination_per_page`, `google_analytics`, `mail_library`, `mail_protocol`, `mail_host`, `mail_port`, `mail_username`, `mail_password`, `mail_title`, `google_client_id`, `google_client_secret`, `vk_app_id`, `vk_secure_key`, `facebook_app_id`, `facebook_app_secret`, `facebook_comment`, `facebook_comment_active`, `show_featured_section`, `show_latest_posts`, `registration_system`, `comment_system`, `comment_approval_system`, `show_post_author`, `show_post_date`, `menu_limit`, `custom_css_codes`, `custom_javascript_codes`, `adsense_activation_code`, `vr_key`, `purchase_code`, `recaptcha_site_key`, `recaptcha_secret_key`, `recaptcha_lang`, `emoji_reactions`, `mail_contact_status`, `mail_contact`, `cache_system`, `cache_refresh_time`, `refresh_cache_database_changes`, `email_verification`, `file_manager_show_files`, `audio_download_button`, `approve_added_user_posts`, `approve_updated_user_posts`, `timezone`, `sort_slider_posts`, `sort_featured_posts`, `newsletter`, `text_editor_lang`, `show_home_link`, `post_format_article`, `post_format_gallery`, `post_format_sorted_list`, `post_format_video`, `post_format_audio`, `post_format_trivia_quiz`, `post_format_personality_quiz`, `maintenance_mode_title`, `maintenance_mode_description`, `maintenance_mode_status`, `sitemap_frequency`, `sitemap_last_modification`, `sitemap_priority`, `last_popular_post_update`, `version`) VALUES
(1, 1, 1, 1, 1, 1, 16, NULL, 'swift', 'smtp', NULL, '587', NULL, NULL, 'Varient', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, 1, 1, 1, 1, 1, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'en', 1, 0, NULL, 0, 180000, 0, 1, 1, 1, 1, 1, 'America/New_York', 'by_slider_order', 'by_featured_order', 1, 'en', 1, 1, 1, 1, 1, 1, 1, 1, 'Coming Soon!', 'Our website is under construction. We\'ll be here soon with our new awesome site.', 0, 'weekly', 'server_response', 'automatically', NULL, '1.7.1');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `lang_id` int(11) DEFAULT 1,
  `image_big` varchar(255) DEFAULT NULL,
  `image_default` varchar(255) DEFAULT NULL,
  `image_slider` varchar(255) DEFAULT NULL,
  `image_mid` varchar(255) DEFAULT NULL,
  `image_small` varchar(255) DEFAULT NULL,
  `image_mime` varchar(50) DEFAULT 'jpg',
  `file_name` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `short_form` varchar(255) NOT NULL,
  `language_code` varchar(100) NOT NULL,
  `folder_name` varchar(255) NOT NULL,
  `text_direction` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `language_order` smallint(6) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `short_form`, `language_code`, `folder_name`, `text_direction`, `status`, `language_order`) VALUES
(1, 'English', 'en', 'en-US', 'default', 'ltr', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `lang_id` int(11) DEFAULT 1,
  `title` varchar(500) DEFAULT NULL,
  `slug` varchar(500) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `keywords` varchar(500) DEFAULT NULL,
  `is_custom` tinyint(1) DEFAULT 1,
  `page_default_name` varchar(100) DEFAULT NULL,
  `page_content` mediumtext DEFAULT NULL,
  `page_order` smallint(6) DEFAULT 1,
  `visibility` tinyint(1) DEFAULT 1,
  `title_active` tinyint(1) DEFAULT 1,
  `breadcrumb_active` tinyint(1) DEFAULT 1,
  `right_column_active` tinyint(1) DEFAULT 1,
  `need_auth` tinyint(1) DEFAULT 0,
  `location` varchar(255) DEFAULT 'top',
  `link` varchar(1000) DEFAULT NULL,
  `parent_id` int(11) DEFAULT 0,
  `page_type` varchar(50) DEFAULT 'page',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `lang_id`, `title`, `slug`, `description`, `keywords`, `is_custom`, `page_default_name`, `page_content`, `page_order`, `visibility`, `title_active`, `breadcrumb_active`, `right_column_active`, `need_auth`, `location`, `link`, `parent_id`, `page_type`, `created_at`) VALUES
(1, 1, 'Contact', 'contact', 'Varient Contact Page', 'varient, contact, page', 0, 'contact', NULL, 1, 1, 1, 1, 0, 0, 'top', NULL, 0, 'page', '2020-02-18 11:09:21'),
(2, 1, 'Gallery', 'gallery', 'Varient Gallery Page', 'varient, gallery, page', 0, 'gallery', NULL, 1, 1, 1, 1, 0, 0, 'main', NULL, 0, 'page', '2020-02-18 11:11:40'),
(3, 1, 'Terms & Conditions', 'terms-conditions', 'Varient Terms Conditions Page', 'Terms, Conditions, Varient', 0, 'terms_conditions', NULL, 1, 1, 1, 1, 0, 0, 'footer', NULL, 0, 'page', '2020-02-18 11:12:40');

-- --------------------------------------------------------

--
-- Table structure for table `polls`
--

CREATE TABLE `polls` (
  `id` int(11) NOT NULL,
  `lang_id` int(11) DEFAULT 1,
  `question` text DEFAULT NULL,
  `option1` text DEFAULT NULL,
  `option2` text DEFAULT NULL,
  `option3` text DEFAULT NULL,
  `option4` text DEFAULT NULL,
  `option5` text DEFAULT NULL,
  `option6` text DEFAULT NULL,
  `option7` text DEFAULT NULL,
  `option8` text DEFAULT NULL,
  `option9` text DEFAULT NULL,
  `option10` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `vote_permission` varchar(50) DEFAULT 'all',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `poll_votes`
--

CREATE TABLE `poll_votes` (
  `id` int(11) NOT NULL,
  `poll_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `vote` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `lang_id` int(11) DEFAULT 1,
  `title` varchar(500) DEFAULT NULL,
  `title_slug` varchar(500) DEFAULT NULL,
  `title_hash` varchar(500) DEFAULT NULL,
  `keywords` varchar(500) DEFAULT NULL,
  `summary` varchar(5000) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `image_big` varchar(255) DEFAULT NULL,
  `image_default` varchar(255) DEFAULT NULL,
  `image_slider` varchar(255) DEFAULT NULL,
  `image_mid` varchar(255) DEFAULT NULL,
  `image_small` varchar(255) DEFAULT NULL,
  `image_mime` varchar(20) DEFAULT 'jpg',
  `optional_url` varchar(1000) DEFAULT NULL,
  `pageviews` int(11) DEFAULT 0,
  `need_auth` tinyint(1) DEFAULT 0,
  `is_slider` tinyint(1) DEFAULT 0,
  `slider_order` tinyint(1) DEFAULT 1,
  `is_featured` tinyint(1) DEFAULT 0,
  `featured_order` tinyint(1) DEFAULT 1,
  `is_recommended` tinyint(1) DEFAULT 0,
  `is_breaking` tinyint(1) DEFAULT 1,
  `is_scheduled` tinyint(1) DEFAULT 0,
  `visibility` tinyint(1) DEFAULT 1,
  `show_right_column` tinyint(1) DEFAULT 1,
  `post_type` varchar(50) DEFAULT 'post',
  `video_path` varchar(255) DEFAULT NULL,
  `image_url` varchar(2000) DEFAULT NULL,
  `video_url` varchar(2000) DEFAULT NULL,
  `video_embed_code` varchar(2000) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `feed_id` int(11) DEFAULT NULL,
  `post_url` varchar(1000) DEFAULT NULL,
  `show_post_url` tinyint(1) DEFAULT 1,
  `image_description` varchar(500) DEFAULT NULL,
  `show_item_numbers` tinyint(1) DEFAULT 1,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `post_audios`
--

CREATE TABLE `post_audios` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `audio_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `post_files`
--

CREATE TABLE `post_files` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `file_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `post_gallery_items`
--

CREATE TABLE `post_gallery_items` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `title` varchar(500) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_large` varchar(255) DEFAULT NULL,
  `image_description` varchar(255) DEFAULT NULL,
  `item_order` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `post_images`
--

CREATE TABLE `post_images` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `image_big` varchar(255) DEFAULT NULL,
  `image_default` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `post_pageviews_month`
--

CREATE TABLE `post_pageviews_month` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `ip_address` varchar(30) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `post_pageviews_week`
--

CREATE TABLE `post_pageviews_week` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `ip_address` varchar(30) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `post_sorted_list_items`
--

CREATE TABLE `post_sorted_list_items` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `title` varchar(500) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_large` varchar(255) DEFAULT NULL,
  `image_description` varchar(255) DEFAULT NULL,
  `item_order` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_answers`
--

CREATE TABLE `quiz_answers` (
  `id` int(11) NOT NULL,
  `question_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `answer_text` varchar(500) DEFAULT NULL,
  `is_correct` tinyint(1) DEFAULT NULL,
  `assigned_result_id` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_images`
--

CREATE TABLE `quiz_images` (
  `id` int(11) NOT NULL,
  `image_default` varchar(255) DEFAULT NULL,
  `image_small` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `image_mime` varchar(20) DEFAULT 'jpg',
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions`
--

CREATE TABLE `quiz_questions` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `question` varchar(500) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `question_order` int(11) DEFAULT 1,
  `answer_format` varchar(30) DEFAULT 'small_image'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `quiz_results`
--

CREATE TABLE `quiz_results` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `result_title` varchar(500) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `min_correct_count` mediumint(9) DEFAULT NULL,
  `max_correct_count` mediumint(9) DEFAULT NULL,
  `result_order` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reactions`
--

CREATE TABLE `reactions` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `re_like` int(11) DEFAULT 0,
  `re_dislike` int(11) DEFAULT 0,
  `re_love` int(11) DEFAULT 0,
  `re_funny` int(11) DEFAULT 0,
  `re_angry` int(11) DEFAULT 0,
  `re_sad` int(11) DEFAULT 0,
  `re_wow` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reading_lists`
--

CREATE TABLE `reading_lists` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `roles_permissions`
--

CREATE TABLE `roles_permissions` (
  `id` int(11) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `role_name` varchar(255) DEFAULT NULL,
  `admin_panel` tinyint(1) DEFAULT NULL,
  `add_post` tinyint(1) DEFAULT NULL,
  `manage_all_posts` tinyint(1) DEFAULT NULL,
  `navigation` tinyint(1) DEFAULT NULL,
  `pages` tinyint(1) DEFAULT NULL,
  `rss_feeds` tinyint(1) DEFAULT NULL,
  `categories` tinyint(1) DEFAULT NULL,
  `widgets` tinyint(1) DEFAULT NULL,
  `polls` tinyint(1) DEFAULT NULL,
  `gallery` tinyint(1) DEFAULT NULL,
  `comments_contact` tinyint(1) DEFAULT NULL,
  `newsletter` tinyint(1) DEFAULT NULL,
  `ad_spaces` tinyint(1) DEFAULT NULL,
  `users` tinyint(1) DEFAULT NULL,
  `seo_tools` tinyint(1) DEFAULT NULL,
  `settings` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles_permissions`
--

INSERT INTO `roles_permissions` (`id`, `role`, `role_name`, `admin_panel`, `add_post`, `manage_all_posts`, `navigation`, `pages`, `rss_feeds`, `categories`, `widgets`, `polls`, `gallery`, `comments_contact`, `newsletter`, `ad_spaces`, `users`, `seo_tools`, `settings`) VALUES
(1, 'admin', 'Admin', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(2, 'moderator', 'Moderator', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0),
(3, 'author', 'Author', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(4, 'user', 'User', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `id` int(11) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `admin`, `profile`, `tag`, `reading_list`, `settings`, `social_accounts`, `preferences`, `visual_settings`, `change_password`, `forgot_password`, `reset_password`, `register`, `posts`, `search`, `rss_feeds`, `gallery_album`, `logout`) VALUES
(1, 'admin', 'profile', 'tag', 'reading-list', 'settings', 'social-accounts', 'preferences', 'visual-settings', 'change-password', 'forgot-password', 'reset-password', 'register', 'posts', 'search', 'rss-feeds', 'gallery-album', 'logout');

-- --------------------------------------------------------

--
-- Table structure for table `rss_feeds`
--

CREATE TABLE `rss_feeds` (
  `id` int(11) NOT NULL,
  `lang_id` int(11) DEFAULT 1,
  `feed_name` varchar(500) DEFAULT NULL,
  `feed_url` varchar(1000) DEFAULT NULL,
  `post_limit` smallint(6) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `image_saving_method` varchar(30) DEFAULT 'url',
  `auto_update` tinyint(1) DEFAULT 1,
  `read_more_button` tinyint(1) DEFAULT 1,
  `read_more_button_text` varchar(255) DEFAULT 'Read More',
  `user_id` int(11) DEFAULT NULL,
  `add_posts_as_draft` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL DEFAULT 1,
  `site_title` varchar(255) DEFAULT NULL,
  `home_title` varchar(255) DEFAULT 'Index',
  `site_description` varchar(500) DEFAULT NULL,
  `keywords` varchar(500) DEFAULT NULL,
  `application_name` varchar(255) DEFAULT NULL,
  `primary_font` smallint(6) DEFAULT 1,
  `secondary_font` smallint(6) DEFAULT 2,
  `tertiary_font` smallint(6) DEFAULT 31,
  `facebook_url` varchar(500) DEFAULT NULL,
  `twitter_url` varchar(500) DEFAULT NULL,
  `instagram_url` varchar(500) DEFAULT NULL,
  `pinterest_url` varchar(500) DEFAULT NULL,
  `linkedin_url` varchar(500) DEFAULT NULL,
  `vk_url` varchar(500) DEFAULT NULL,
  `telegram_url` varchar(500) DEFAULT NULL,
  `youtube_url` varchar(500) DEFAULT NULL,
  `optional_url_button_name` varchar(500) DEFAULT 'Click Here To See More',
  `about_footer` varchar(1000) DEFAULT NULL,
  `contact_text` text DEFAULT NULL,
  `contact_address` varchar(500) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(255) DEFAULT NULL,
  `copyright` varchar(500) DEFAULT NULL,
  `cookies_warning` tinyint(1) DEFAULT 0,
  `cookies_warning_text` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `lang_id`, `site_title`, `home_title`, `site_description`, `keywords`, `application_name`, `primary_font`, `secondary_font`, `tertiary_font`, `facebook_url`, `twitter_url`, `instagram_url`, `pinterest_url`, `linkedin_url`, `vk_url`, `telegram_url`, `youtube_url`, `optional_url_button_name`, `about_footer`, `contact_text`, `contact_address`, `contact_email`, `contact_phone`, `copyright`, `cookies_warning`, `cookies_warning_text`) VALUES
(1, 1, 'Varient - News Magazine', 'Index', 'Varient Index Page', 'index, home, varient', 'Varient', 19, 25, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Click Here To See More', NULL, NULL, NULL, NULL, NULL, 'Copyrigt 2020 Varient - All Rights Reserved.', 0, '<p>This site uses cookies. By continuing to browse the site you are agreeing to our use of cookies.</p>');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `tag_slug` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT 'name@domain.com',
  `email_status` tinyint(1) DEFAULT 0,
  `token` varchar(500) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(100) DEFAULT 'user',
  `user_type` varchar(50) DEFAULT 'registered',
  `google_id` varchar(255) DEFAULT NULL,
  `facebook_id` varchar(255) DEFAULT NULL,
  `vk_id` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `about_me` varchar(5000) DEFAULT NULL,
  `facebook_url` varchar(500) DEFAULT NULL,
  `twitter_url` varchar(500) DEFAULT NULL,
  `instagram_url` varchar(500) DEFAULT NULL,
  `pinterest_url` varchar(500) DEFAULT NULL,
  `linkedin_url` varchar(500) DEFAULT NULL,
  `vk_url` varchar(500) DEFAULT NULL,
  `telegram_url` varchar(500) DEFAULT NULL,
  `youtube_url` varchar(500) DEFAULT NULL,
  `last_seen` timestamp NULL DEFAULT NULL,
  `show_email_on_profile` tinyint(1) DEFAULT 1,
  `show_rss_feeds` tinyint(1) DEFAULT 1,
  `site_mode` varchar(10) DEFAULT NULL,
  `site_color` varchar(30) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `video_name` varchar(255) DEFAULT NULL,
  `video_path` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `visual_settings`
--

CREATE TABLE `visual_settings` (
  `id` int(11) NOT NULL,
  `dark_mode` tinyint(1) NOT NULL DEFAULT 0,
  `post_list_style` varchar(100) NOT NULL DEFAULT 'vertical',
  `site_color` varchar(100) NOT NULL DEFAULT 'default',
  `site_block_color` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `logo_footer` varchar(255) DEFAULT NULL,
  `logo_email` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `visual_settings`
--

INSERT INTO `visual_settings` (`id`, `dark_mode`, `post_list_style`, `site_color`, `site_block_color`, `logo`, `logo_footer`, `logo_email`, `favicon`) VALUES
(1, 0, 'vertical', 'default', '#161616', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `widgets`
--

CREATE TABLE `widgets` (
  `id` int(11) NOT NULL,
  `lang_id` int(11) DEFAULT 1,
  `title` varchar(500) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `widget_order` int(11) DEFAULT 1,
  `visibility` int(11) DEFAULT 1,
  `is_custom` int(11) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `widgets`
--

INSERT INTO `widgets` (`id`, `lang_id`, `title`, `content`, `type`, `widget_order`, `visibility`, `is_custom`, `created_at`) VALUES
(1, 1, 'Follow Us', NULL, 'follow-us', 2, 1, 0, '2020-02-18 12:54:39'),
(2, 1, 'Popular Posts', NULL, 'popular-posts', 1, 1, 0, '2020-02-18 12:54:39'),
(3, 1, 'Recommended Posts', NULL, 'recommended-posts', 3, 1, 0, '2020-02-18 12:54:39'),
(4, 1, 'Random Posts', NULL, 'random-slider-posts', 4, 1, 0, '2020-02-18 12:54:39'),
(5, 1, 'Tags', NULL, 'tags', 5, 1, 0, '2020-02-18 12:54:39'),
(6, 1, 'Voting Poll', NULL, 'poll', 6, 1, 0, '2020-02-18 12:54:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ad_spaces`
--
ALTER TABLE `ad_spaces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audios`
--
ALTER TABLE `audios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_parent_id` (`parent_id`),
  ADD KEY `idx_post_id` (`post_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fonts`
--
ALTER TABLE `fonts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_albums`
--
ALTER TABLE `gallery_albums`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_categories`
--
ALTER TABLE `gallery_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `polls`
--
ALTER TABLE `polls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `poll_votes`
--
ALTER TABLE `poll_votes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_category_id` (`category_id`),
  ADD KEY `idx_is_slider` (`is_slider`),
  ADD KEY `idx_is_featured` (`is_featured`),
  ADD KEY `idx_is_recommended` (`is_recommended`),
  ADD KEY `idx_is_breaking` (`is_breaking`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_lang_id` (`lang_id`),
  ADD KEY `idx_is_scheduled` (`is_scheduled`),
  ADD KEY `idx_visibility` (`visibility`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `post_audios`
--
ALTER TABLE `post_audios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_files`
--
ALTER TABLE `post_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_gallery_items`
--
ALTER TABLE `post_gallery_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_images`
--
ALTER TABLE `post_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_pageviews_month`
--
ALTER TABLE `post_pageviews_month`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_post_id` (`post_id`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `post_pageviews_week`
--
ALTER TABLE `post_pageviews_week`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_post_id` (`post_id`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `post_sorted_list_items`
--
ALTER TABLE `post_sorted_list_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_answers`
--
ALTER TABLE `quiz_answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_images`
--
ALTER TABLE `quiz_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reactions`
--
ALTER TABLE `reactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reading_lists`
--
ALTER TABLE `reading_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rss_feeds`
--
ALTER TABLE `rss_feeds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_post_id` (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visual_settings`
--
ALTER TABLE `visual_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `widgets`
--
ALTER TABLE `widgets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ad_spaces`
--
ALTER TABLE `ad_spaces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `audios`
--
ALTER TABLE `audios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `followers`
--
ALTER TABLE `followers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fonts`
--
ALTER TABLE `fonts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery_albums`
--
ALTER TABLE `gallery_albums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery_categories`
--
ALTER TABLE `gallery_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `polls`
--
ALTER TABLE `polls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `poll_votes`
--
ALTER TABLE `poll_votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_audios`
--
ALTER TABLE `post_audios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_files`
--
ALTER TABLE `post_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_gallery_items`
--
ALTER TABLE `post_gallery_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_images`
--
ALTER TABLE `post_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_pageviews_month`
--
ALTER TABLE `post_pageviews_month`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_pageviews_week`
--
ALTER TABLE `post_pageviews_week`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_sorted_list_items`
--
ALTER TABLE `post_sorted_list_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_answers`
--
ALTER TABLE `quiz_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_images`
--
ALTER TABLE `quiz_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quiz_results`
--
ALTER TABLE `quiz_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reactions`
--
ALTER TABLE `reactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reading_lists`
--
ALTER TABLE `reading_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rss_feeds`
--
ALTER TABLE `rss_feeds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `visual_settings`
--
ALTER TABLE `visual_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `widgets`
--
ALTER TABLE `widgets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
