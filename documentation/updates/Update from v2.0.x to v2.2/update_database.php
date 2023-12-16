<?php
defined('ENVIRONMENT') || define('ENVIRONMENT', 'development');
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
chdir(__DIR__);
$pathsConfig = FCPATH . 'app/Config/Paths.php';
require realpath($pathsConfig) ?: $pathsConfig;
$paths = new Config\Paths();
$bootstrap = rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';
$app = require realpath($bootstrap) ?: $bootstrap;

$dbArray = new \Config\Database();
$connection = mysqli_connect($dbArray->default['hostname'], $dbArray->default['username'], $dbArray->default['password'], $dbArray->default['database']);
if (empty($connection)) {
    echo 'Database connection failed! Check your database credentials in the "app/Config/Database.php" file.';
    exit();
}
$connection->query("SET CHARACTER SET utf8");
$connection->query("SET NAMES utf8");

function runQuery($sql)
{
    global $connection;
    return mysqli_query($connection, $sql);
}

if (isset($_POST["btn_submit"])) {
    update($connection);
    $success = 'The update has been successfully completed! Please delete the "update_database.php" file.';
}

function update()
{
    updateFrom20To21();
    sleep(1);
    updateFrom21To22();
}

function updateFrom20To21()
{
    runQuery("DROP TABLE post_pageviews_week;");
    runQuery("DROP TABLE ad_spaces;");
    $tblThemes = "CREATE TABLE `themes` (
      `id` INT AUTO_INCREMENT PRIMARY KEY,
      `theme` varchar(255) DEFAULT NULL,
      `theme_folder` varchar(255) NOT NULL,
      `theme_name` varchar(255) DEFAULT NULL,
      `theme_color` varchar(100) DEFAULT NULL,
      `block_color` varchar(100) DEFAULT NULL,
      `mega_menu_color` varchar(255) DEFAULT NULL,
      `is_active` tinyint(1) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    $tblAdSpaces = "CREATE TABLE `ad_spaces` (
      `id` INT AUTO_INCREMENT PRIMARY KEY,
      `lang_id` int(11) DEFAULT 1,
      `ad_space` text DEFAULT NULL,
      `ad_code_desktop` text DEFAULT NULL,
      `desktop_width` int(11) DEFAULT NULL,
      `desktop_height` int(11) DEFAULT NULL,
      `ad_code_mobile` text DEFAULT NULL,
      `mobile_width` int(11) DEFAULT NULL,
      `mobile_height` int(11) DEFAULT NULL,
      `display_category_id` int(11) DEFAULT NULL,
      `paragraph_number` int(11) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    runQuery($tblThemes);
    runQuery($tblAdSpaces);
    runQuery("ALTER TABLE general_settings DROP COLUMN `post_list_style`;");
    runQuery("ALTER TABLE general_settings DROP COLUMN `site_color`;");
    runQuery("ALTER TABLE general_settings DROP COLUMN `site_block_color`;");
    runQuery("ALTER TABLE general_settings CHANGE mail_library mail_service varchar(100) DEFAULT 'swift';");
    runQuery("ALTER TABLE general_settings ADD COLUMN `mailjet_api_key` varchar(255);");
    runQuery("ALTER TABLE general_settings ADD COLUMN `mailjet_secret_key` varchar(255);");
    runQuery("ALTER TABLE general_settings ADD COLUMN `mailjet_email_address` varchar(255);");
    runQuery("ALTER TABLE routes DROP COLUMN `visual_settings`;");
    runQuery("ALTER TABLE users ADD COLUMN `cover_image` varchar(255);");
    runQuery("ALTER TABLE widgets ADD COLUMN `display_category_id` INT;");

    $sqlThemes = "INSERT INTO `themes` (`id`, `theme`, `theme_folder`, `theme_name`, `theme_color`, `block_color`, `mega_menu_color`, `is_active`) VALUES
(1, 'classic', 'classic', 'Classic', '#19bc9c', '#161616', NULL, 0),
(2, 'magazine', 'magazine', 'Magazine', '#2d65fe', '#161616', '#f9f9f9', 1),
(3, 'news', 'magazine', 'News', '#0f88f1', '#101010', '#1e1e1e', 0);";
    runQuery($sqlThemes);
    $sqlFonts="INSERT INTO `fonts` (`font_name`, `font_key`, `font_url`, `font_family`, `font_source`, `has_local_file`, `is_default`) VALUES
('Inter', 'inter', '<link href=\"https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap\" rel=\"stylesheet\">', 'font-family: \"Inter\", sans-serif;', 'local', 1, 0),
('PT Serif', 'pt-serif', '<link href=\"https://fonts.googleapis.com/css2?family=PT+Serif:wght@400;700&display=swap\" rel=\"stylesheet\">', 'font-family: \"PT Serif\", serif;', 'local', 1, 0)";
    runQuery($sqlFonts);
    runQuery("DELETE FROM widgets WHERE `type`='random-slider-posts';");
    runQuery("UPDATE general_settings SET `version` = '2.1' WHERE id = 1;");

    sleep(1);
    //add new translations
    $p = array();
    $p["category_select_widget"] = "Select the widgets you want to show in the sidebar";
    $p["where_to_display"] = "Where To Display";
    $p["change"] = "Change";
    $p["theme_settings"] = "Theme Settings";
    $p["color_code"] = "Color Code";
    $p["mail_service"] = "Mail Service";
    $p["api_key"] = "API Key";
    $p["mailjet_email_address"] = "Mailjet Email Address";
    $p["mailjet_email_address_exp"] = "The address you created your Mailjet account with";
    $p["warning_edit_profile_image"] = "Click on the save changes button after selecting your image";
    $p["top_headlines"] = "Top Headlines";
    $p["ad_space_header"] = "Header";
    $p["ad_space_index_top"] = "Index (Top)";
    $p["ad_space_index_bottom"] = "Index (Bottom)";
    $p["ad_space_post_top"] = "Post Details (Top)";
    $p["ad_space_post_bottom"] = "Post Details (Bottom)";
    $p["ad_space_posts_top"] = "Posts (Top)";
    $p["ad_space_posts_bottom"] = "Posts (Bottom)";
    $p["ad_space_posts_exp"] = "This ad will be displayed on Posts, Category, Profile, Tag, Search and Profile pages";
    $p["logo_footer"] = "Logo Footer";
    $p["ad_space_in_article"] = "In-Article";
    $p["paragraph"] = "Paragraph";
    $p["ad_space_paragraph_exp"] = "The ad will be displayed after the paragraph number you selected";
    $p["banner_desktop"] = "Desktop Banner";
    $p["banner_mobile"] = "Mobile Banner";
    $p["banner_desktop_exp"] = "This ad will be displayed on screens larger than 992px";
    $p["banner_mobile_exp"] = "This ad will be displayed on screens smaller than 992px";
    $p["sidebar"] = "Sidebar";
    $p["ad_size"] = "Ad Size";
    $p["width"] = "Width";
    $p["height"] = "Height";
    $p["create_ad_exp"] = "If you do not have an ad code, you can create an ad code by selecting an image and adding an URL";
    $p["mega_menu_color"] = "Mega Menu Color";
    addTranslations($p);
    //delete old translations
    runQuery("DELETE FROM language_translations WHERE `label`='category_bottom_ad_space';");
    runQuery("DELETE FROM language_translations WHERE `label`='category_top_ad_space';");
    runQuery("DELETE FROM language_translations WHERE `label`='font_warning';");
    runQuery("DELETE FROM language_translations WHERE `label`='header_top_ad_space';");
    runQuery("DELETE FROM language_translations WHERE `label`='index_bottom_ad_space';");
    runQuery("DELETE FROM language_translations WHERE `label`='index_top_ad_space';");
    runQuery("DELETE FROM language_translations WHERE `label`='mail_library';");
    runQuery("DELETE FROM language_translations WHERE `label`='posts_bottom_ad_space';");
    runQuery("DELETE FROM language_translations WHERE `label`='posts_top_ad_space';");
    runQuery("DELETE FROM language_translations WHERE `label`='post_bottom_ad_space';");
    runQuery("DELETE FROM language_translations WHERE `label`='post_list_style';");
    runQuery("DELETE FROM language_translations WHERE `label`='post_top_ad_space';");
    runQuery("DELETE FROM language_translations WHERE `label`='profile_bottom_ad_space';");
    runQuery("DELETE FROM language_translations WHERE `label`='profile_top_ad_space';");
    runQuery("DELETE FROM language_translations WHERE `label`='reading_list_bottom_ad_space';");
    runQuery("DELETE FROM language_translations WHERE `label`='reading_list_top_ad_space';");
    runQuery("DELETE FROM language_translations WHERE `label`='search_bottom_ad_space';");
    runQuery("DELETE FROM language_translations WHERE `label`='search_top_ad_space';");
    runQuery("DELETE FROM language_translations WHERE `label`='sidebar_bottom_ad_space';");
    runQuery("DELETE FROM language_translations WHERE `label`='sidebar_top_ad_space';");
    runQuery("DELETE FROM language_translations WHERE `label`='tag_bottom_ad_space';");
    runQuery("DELETE FROM language_translations WHERE `label`='tag_top_ad_space';");
    runQuery("DELETE FROM language_translations WHERE `label`='visual_settings';");
}

function updateFrom21To22()
{
    $tblPostPollVotes = "CREATE TABLE `post_poll_votes` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `post_id` int(11) DEFAULT NULL,
    `question_id` int(11) DEFAULT NULL,
    `answer_id` int(11) DEFAULT NULL,
    `user_id` int(11) DEFAULT 0
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

    runQuery($tblPostPollVotes);
    runQuery("ALTER TABLE general_settings ADD COLUMN `post_format_poll` TINYINT(1) DEFAULT 1");
    runQuery("ALTER TABLE general_settings ADD COLUMN `image_file_format` varchar(30) DEFAULT 'JPG'");
    runQuery("ALTER TABLE general_settings ADD COLUMN `google_news` TINYINT(1) DEFAULT 0");
    runQuery("ALTER TABLE posts ADD COLUMN `is_poll_public` TINYINT(1) DEFAULT 0");
    runQuery("ALTER TABLE quiz_answers ADD COLUMN `total_votes` INT DEFAULT 0");
    runQuery("ALTER TABLE settings ADD COLUMN `tiktok_url` varchar(500)");
    runQuery("ALTER TABLE users ADD COLUMN `tiktok_url` varchar(500)");
    runQuery("ALTER TABLE users ADD COLUMN `personal_website_url` varchar(500)");
    runQuery("UPDATE general_settings SET `version` = '2.2' WHERE id = 1;");
    sleep(1);
    //update role names
    runQuery("UPDATE roles_permissions SET `role_name` = 'a:1:{i:0;a:2:{s:7:\"lang_id\";s:1:\"1\";s:4:\"name\";s:5:\"Admin\";}}' WHERE `role` = 'admin';");
    runQuery("UPDATE roles_permissions SET `role_name` = 'a:1:{i:0;a:2:{s:7:\"lang_id\";s:1:\"1\";s:4:\"name\";s:9:\"Moderator\";}}' WHERE `role` = 'moderator';");
    runQuery("UPDATE roles_permissions SET `role_name` = 'a:1:{i:0;a:2:{s:7:\"lang_id\";s:1:\"1\";s:4:\"name\";s:6:\"Author\";}}' WHERE `role` = 'author';");
    runQuery("UPDATE roles_permissions SET `role_name` = 'a:1:{i:0;a:2:{s:7:\"lang_id\";s:1:\"1\";s:4:\"name\";s:4:\"User\";}}' WHERE `role` = 'user';");
    //add new translations
    $p = array();
    $p["ad_space_index_top"] = "Index (Top)";
    $p["ad_space_index_bottom"] = "Index (Bottom)";
    $p["ad_space_post_top"] = "Post Details (Top)";
    $p["ad_space_post_bottom"] = "Post Details (Bottom)";
    $p["ad_space_posts_top"] = "Posts (Top)";
    $p["ad_space_posts_bottom"] = "Posts (Bottom)";
    $p["ad_space_in_article"] = "In-Article";
    $p["image_file_format"] = "Image File Format";
    $p["personal_website_url"] = "Personal Website URL";
    $p["poll_exp"] = "Get user opinions about something";
    $p["total_votes"] = "Total Votes";
    $p["google_news"] = "Google News";
    $p["generate_feed_url"] = "Generate Feed URL";
    $p["limit"] = "Limit";
    $p["google_news_exp"] = "According to Google News rules, there can be a maximum of 1000 publications in an XML file. Therefore, it is not recommended to increase this limit.";
    $p["google_news_cache_exp"] = "This system uses cache system. So the records in your XML file will be automatically updated every 15 minutes.";
    $p["accept_cookies"] = "Accept Cookies";
    addTranslations($p);
    //delete old translations
    runQuery("DELETE FROM language_translations WHERE `label`='add_subcategory';");
    runQuery("DELETE FROM language_translations WHERE `label`='subcategories';");
    //add indexes
    runQuery("ALTER TABLE audios ADD INDEX idx_user_id (user_id);");
    runQuery("ALTER TABLE comments ADD INDEX idx_user_id (user_id);");
    runQuery("ALTER TABLE files ADD INDEX idx_user_id (user_id);");
    runQuery("ALTER TABLE followers ADD INDEX idx_following_id (following_id);");
    runQuery("ALTER TABLE followers ADD INDEX idx_follower_id (follower_id);");
    runQuery("ALTER TABLE images ADD INDEX idx_user_id (user_id);");
    runQuery("ALTER TABLE payouts ADD INDEX idx_user_id (user_id);");
    runQuery("ALTER TABLE poll_votes ADD INDEX idx_poll_id (poll_id);");
    runQuery("ALTER TABLE poll_votes ADD INDEX idx_user_id (user_id);");
    runQuery("ALTER TABLE post_audios ADD INDEX idx_post_id (post_id);");
    runQuery("ALTER TABLE post_audios ADD INDEX idx_audio_id (audio_id);");
    runQuery("ALTER TABLE post_files ADD INDEX idx_post_id (post_id);");
    runQuery("ALTER TABLE post_files ADD INDEX idx_file_id (file_id);");
    runQuery("ALTER TABLE post_gallery_items ADD INDEX idx_post_id (post_id);");
    runQuery("ALTER TABLE post_images ADD INDEX idx_post_id (post_id);");
    runQuery("ALTER TABLE post_pageviews_month ADD INDEX idx_post_user_id (post_user_id);");
    runQuery("ALTER TABLE post_poll_votes ADD INDEX idx_post_id (post_id);");
    runQuery("ALTER TABLE post_poll_votes ADD INDEX idx_question_id (question_id);");
    runQuery("ALTER TABLE post_poll_votes ADD INDEX idx_user_id (user_id);");
    runQuery("ALTER TABLE post_poll_votes ADD INDEX idx_answer_id (answer_id);");
    runQuery("ALTER TABLE post_sorted_list_items ADD INDEX idx_post_id (post_id);");
    runQuery("ALTER TABLE quiz_answers ADD INDEX idx_question_id (question_id);");
    runQuery("ALTER TABLE quiz_images ADD INDEX idx_user_id (user_id);");
    runQuery("ALTER TABLE quiz_questions ADD INDEX idx_post_id (post_id);");
    runQuery("ALTER TABLE quiz_results ADD INDEX idx_post_id (post_id);");
    runQuery("ALTER TABLE reactions ADD INDEX idx_post_id (post_id);");
    runQuery("ALTER TABLE reading_lists ADD INDEX idx_post_id (post_id);");
    runQuery("ALTER TABLE reading_lists ADD INDEX idx_user_id (user_id);");
    runQuery("ALTER TABLE videos ADD INDEX idx_user_id (user_id);");
}

function addTranslations($translations)
{
    $languages = runQuery("SELECT * FROM languages;");
    if (!empty($languages->num_rows)) {
        while ($language = mysqli_fetch_array($languages)) {
            foreach ($translations as $key => $value) {
                $trans = runQuery("SELECT * FROM language_translations WHERE label ='" . $key . "' AND lang_id = " . $language['id']);
                if (empty($trans->num_rows)) {
                    runQuery("INSERT INTO `language_translations` (`lang_id`, `label`, `translation`) VALUES (" . $language['id'] . ", '" . $key . "', '" . $value . "');");
                }
            }
        }
    }
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Varient - Update Wizard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #444 !important;
            font-size: 14px;
            background: #007991;
            background: -webkit-linear-gradient(to left, #007991, #6fe7c2);
            background: linear-gradient(to left, #007991, #6fe7c2);
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
                        <h2 class="title">Update from v2.0.x to v2.2</h2>
                        <br><br>
                        <div class="messages">
                            <?php if (!empty($error)) { ?>
                                <div class="alert alert-danger">
                                    <strong><?= $error; ?></strong>
                                </div>
                            <?php } ?>
                            <?php if (!empty($success)) { ?>
                                <div class="alert alert-success">
                                    <strong><?= $success; ?></strong>
                                    <style>.alert-info {
                                            display: none;
                                        }</style>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="step-contents">
                            <div class="tab-1">
                                <?php if (empty($success)): ?>
                                    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
                                        <div class="tab-footer text-center">
                                            <button type="submit" name="btn_submit" class="btn-custom">Update My Database</button>
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