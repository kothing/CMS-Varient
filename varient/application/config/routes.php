<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$general_settings = $this->config->item('general_settings');
$routes = $this->config->item('routes');

$route['default_controller'] = 'home_controller';
$route['404_override'] = 'home_controller/error_404';
$route['translate_uri_dashes'] = FALSE;
$route['index'] = 'home_controller/index';
$route['error-404'] = 'home_controller/error_404';

$route[$routes->posts]['GET'] = 'home_controller/posts';
$route[$routes->gallery_album . '/(:num)']['GET'] = 'home_controller/gallery_album/$1';
$route[$routes->tag . '/(:any)']['GET'] = 'home_controller/tag/$1';
$route[$routes->reading_list]['GET'] = 'home_controller/reading_list';
$route[$routes->search]['GET'] = 'home_controller/search';


//rss routes
$route[$routes->rss_feeds]['GET'] = 'home_controller/rss_feeds';
$route['rss/latest-posts']['GET'] = 'home_controller/rss_latest_posts';
$route['rss/category/(:any)']['GET'] = 'home_controller/rss_by_category/$1';
$route['rss/author/(:any)']['GET'] = 'home_controller/rss_by_user/$1';

//auth routes
$route[$routes->register]['GET'] = 'auth_controller/register';
$route[$routes->change_password]['GET'] = 'auth_controller/change_password';
$route[$routes->forgot_password]['GET'] = 'auth_controller/forgot_password';
$route[$routes->reset_password]['GET'] = 'auth_controller/reset_password';
$route['connect-with-facebook'] = 'auth_controller/connect_with_facebook';
$route['facebook-callback'] = 'auth_controller/facebook_callback';
$route['connect-with-google'] = 'auth_controller/connect_with_google';
$route['connect-with-vk'] = 'auth_controller/connect_with_vk';

//profile routes
$route[$routes->profile . '/(:any)']['GET'] = 'profile_controller/profile/$1';
$route[$routes->settings]['GET'] = 'profile_controller/update_profile';
$route[$routes->settings . '/' . $routes->social_accounts]['GET'] = 'profile_controller/social_accounts';
$route[$routes->settings . '/' . $routes->preferences]['GET'] = 'profile_controller/preferences';
$route[$routes->settings . '/' . $routes->visual_settings]['GET'] = 'profile_controller/visual_settings';
$route[$routes->settings . '/' . $routes->change_password]['GET'] = 'profile_controller/change_password';

$route[$routes->logout]['GET'] = 'common_controller/logout';
$route['confirm']['GET'] = 'auth_controller/confirm_email';
$route["unsubscribe"]['GET'] = 'auth_controller/unsubscribe';
$route["cron/update-feeds"]['GET'] = 'cron_controller/check_feed_posts';
$route["cron/update-sitemap"]['GET'] = 'cron_controller/update_sitemap';
$route["cron/check-scheduled-posts"]['GET'] = 'cron_controller/check_scheduled_posts';

//POST routes
$route['forgot-password-post']['POST'] = 'auth_controller/forgot_password_post';
$route['register-post']['POST'] = 'auth_controller/register_post';
$route['reset-password-post']['POST'] = 'auth_controller/reset_password_post';
$route['change-password-post']['POST'] = 'profile_controller/change_password_post';
$route['preferences-post']['POST'] = 'profile_controller/preferences_post';
$route['visual-settings-post']['POST'] = 'profile_controller/visual_settings_post';
$route['social-accounts-post']['POST'] = 'profile_controller/social_accounts_post';
$route['update-profile-post']['POST'] = 'profile_controller/update_profile_post';
$route['add-to-newsletter']['POST'] = 'home_controller/add_to_newsletter';
$route['follow-unfollow-user']['POST'] = 'profile_controller/follow_unfollow_user';
$route['contact-post']['POST'] = 'home_controller/contact_post';
$route['download-file']['POST'] = 'home_controller/download_post_file';
$route['download-audio']['POST'] = 'home_controller/download_audio';
$route['delete-old-pageviews']['POST'] = 'ajax_controller/delete_old_pageviews';
$route['preview/(:any)']['GET'] = 'home_controller/preview/$1';

$route['(:any)/(:num)']['GET'] = 'home_controller/gallery_post/$1/$2';
/*
*-------------------------------------------------------------------------------------------------
* ADMIN ROUTES
*-------------------------------------------------------------------------------------------------
*/
$route[$routes->admin] = 'admin_controller/index';
$route[$routes->admin . "/login"] = 'common_controller/admin_login';
$route[$routes->admin . "/navigation"] = 'admin_controller/navigation';
$route[$routes->admin . "/update-menu-link/(:num)"] = 'admin_controller/update_menu_link/$1';
$route[$routes->admin . "/preferences"] = 'admin_controller/preferences';
$route[$routes->admin . "/themes"] = 'admin_controller/themes';
//page
$route[$routes->admin . "/add-page"] = 'page_controller/add_page';
$route[$routes->admin . "/update-page/(:num)"] = 'page_controller/update_page/$1';
$route[$routes->admin . "/pages"] = 'page_controller/pages';
//post
$route[$routes->admin . "/post-format"] = 'post_controller/post_format';
$route[$routes->admin . "/add-post"] = 'post_controller/add_post';
$route[$routes->admin . "/posts"] = 'post_controller/posts';
$route[$routes->admin . "/slider-posts"] = 'post_controller/slider_posts';
$route[$routes->admin . "/featured-posts"] = 'post_controller/featured_posts';
$route[$routes->admin . "/breaking-news"] = 'post_controller/breaking_news';
$route[$routes->admin . "/recommended-posts"] = 'post_controller/recommended_posts';
$route[$routes->admin . "/pending-posts"] = 'post_controller/pending_posts';
$route[$routes->admin . "/scheduled-posts"] = 'post_controller/scheduled_posts';
$route[$routes->admin . "/drafts"] = 'post_controller/drafts';
$route[$routes->admin . "/update-post/(:num)"] = 'post_controller/update_post/$1';

//rss
$route[$routes->admin . "/import-feed"] = 'rss_controller/import_feed';
$route[$routes->admin . "/feeds"] = 'rss_controller/feeds';
$route[$routes->admin . "/update-feed/(:num)"] = 'rss_controller/update_feed/$1';

//category
$route[$routes->admin . "/categories"] = 'category_controller/categories';
$route[$routes->admin . "/categories"] = 'category_controller/categories';
$route[$routes->admin . "/subcategories"] = 'category_controller/subcategories';
$route[$routes->admin . "/update-category/(:num)"] = 'category_controller/update_category/$1';
$route[$routes->admin . "/update-subcategory/(:num)"] = 'category_controller/update_subcategory/$1';
//widget
$route[$routes->admin . "/add-widget"] = 'widget_controller/add_widget';
$route[$routes->admin . "/widgets"] = 'widget_controller/widgets';
$route[$routes->admin . "/update-widget/(:num)"] = 'widget_controller/update_widget/$1';
//poll
$route[$routes->admin . "/add-poll"] = 'poll_controller/add_poll';
$route[$routes->admin . "/polls"] = 'poll_controller/polls';
$route[$routes->admin . "/update-poll/(:num)"] = 'poll_controller/update_poll/$1';
//gallery
$route[$routes->admin . "/gallery-categories"] = 'category_controller/gallery_categories';
$route[$routes->admin . "/gallery-albums"] = 'gallery_controller/gallery_albums';
$route[$routes->admin . "/update-gallery-category/(:num)"] = 'category_controller/update_gallery_category/$1';
$route[$routes->admin . "/update-gallery-album/(:num)"] = 'gallery_controller/update_gallery_album/$1';
$route[$routes->admin . "/gallery"] = 'gallery_controller/gallery';
$route[$routes->admin . "/update-gallery-image/(:num)"] = 'gallery_controller/update_gallery_image/$1';
//contact
$route[$routes->admin . "/contact-messages"] = 'admin_controller/contact_messages';
//newsletter
$route[$routes->admin . "/send-email-subscribers"] = 'admin_controller/send_email_subscribers';
$route[$routes->admin . "/send-email-subscriber/(:num)"] = 'admin_controller/send_email_subscriber/$1';
$route[$routes->admin . "/subscribers"] = 'admin_controller/subscribers';
//comments
$route[$routes->admin . "/comments"] = 'admin_controller/comments';
$route[$routes->admin . "/pending-comments"] = 'admin_controller/pending_comments';
//ad_spaces
$route[$routes->admin . "/ad-spaces"] = 'admin_controller/ad_spaces';
$route[$routes->admin . "/seo-tools"] = 'admin_controller/seo_tools';
$route[$routes->admin . "/social-login-configuration"] = 'admin_controller/social_login_configuration';
$route[$routes->admin . "/cache-system"] = 'admin_controller/cache_system';
$route[$routes->admin . "/preferences"] = 'admin_controller/preferences';
//font
$route[$routes->admin . "/font-settings"] = 'admin_controller/font_settings';
$route[$routes->admin . "/update-font/(:num)"] = 'admin_controller/update_font/$1';
//language
$route[$routes->admin . "/language-settings"] = 'language_controller/languages';
$route[$routes->admin . "/update-language/(:num)"] = 'language_controller/update_language/$1';
$route[$routes->admin . "/update-phrases/(:num)"] = 'language_controller/update_phrases/$1';
$route[$routes->admin . "/search-phrases"] = 'language_controller/search_phrases';
//settings
$route[$routes->admin . "/visual-settings"] = 'admin_controller/visual_settings';
$route[$routes->admin . "/email-settings"] = 'admin_controller/email_settings';
$route[$routes->admin . "/settings"] = 'admin_controller/settings';
$route[$routes->admin . "/route-settings"] = 'admin_controller/route_settings';
//users
$route[$routes->admin . "/users"] = 'admin_controller/users';
$route[$routes->admin . '/administrators'] = 'admin_controller/administrators';
$route[$routes->admin . '/add-user'] = 'admin_controller/add_user';
$route[$routes->admin . '/edit-user/(:num)'] = 'admin_controller/edit_user/$1';
$route[$routes->admin . '/roles-permissions'] = 'admin_controller/roles_permissions';
$route[$routes->admin . '/edit-role/(:num)'] = 'admin_controller/edit_role/$1';
$route[$routes->admin . "/email-preview"] = 'admin_controller/email_preview';

/*
*-------------------------------------------------------------------------------------------------
* DYNAMIC ROUTES
*-------------------------------------------------------------------------------------------------
*/
$languages = $this->config->item('languages');
foreach ($languages as $language) {
    if ($language->status == 1 && $general_settings->site_lang != $language->id) {
        $key = $language->short_form;
        $route[$key] = "home_controller/index";
        $route[$key . '/' . $routes->posts]['GET'] = 'home_controller/posts';
        $route[$key . '/' . $routes->gallery_album . '/(:num)']['GET'] = 'home_controller/gallery_album/$1';
        $route[$key . '/' . $routes->tag . '/(:any)']['GET'] = 'home_controller/tag/$1';
        $route[$key . '/' . $routes->reading_list]['GET'] = 'home_controller/reading_list';
        $route[$key . '/' . $routes->search]['GET'] = 'home_controller/search';

        $route[$key . '/' . $routes->rss_feeds]['GET'] = 'home_controller/rss_feeds';
        $route[$key . '/rss/latest-posts']['GET'] = 'home_controller/rss_latest_posts';
        $route[$key . '/rss/category/(:any)']['GET'] = 'home_controller/rss_by_category/$1';
        $route[$key . '/rss/author/(:any)']['GET'] = 'home_controller/rss_by_user/$1';

        $route[$key . '/' . $routes->register]['GET'] = 'auth_controller/register';
        $route[$key . '/' . $routes->change_password]['GET'] = 'auth_controller/change_password';
        $route[$key . '/' . $routes->forgot_password]['GET'] = 'auth_controller/forgot_password';
        $route[$key . '/' . $routes->reset_password]['GET'] = 'auth_controller/reset_password';

        $route[$key . '/' . $routes->profile . '/(:any)']['GET'] = 'profile_controller/profile/$1';
        $route[$key . '/' . $routes->settings]['GET'] = 'profile_controller/update_profile';
        $route[$key . '/' . $routes->settings . '/' . $routes->social_accounts]['GET'] = 'profile_controller/social_accounts';
        $route[$key . '/' . $routes->settings . '/' . $routes->preferences]['GET'] = 'profile_controller/preferences';
        $route[$key . '/' . $routes->settings . '/' . $routes->visual_settings]['GET'] = 'profile_controller/visual_settings';
        $route[$key . '/' . $routes->settings . '/' . $routes->change_password]['GET'] = 'profile_controller/change_password';

        $route[$key . '/' . $routes->logout]['GET'] = 'common_controller/logout';
        $route[$key . '/confirm']['GET'] = 'auth_controller/confirm_email';
        $route[$key . "/unsubscribe"]['GET'] = 'auth_controller/unsubscribe';

        $route[$key . '/(:any)/(:num)'] = 'home_controller/gallery_post/$1/$2';
        $route[$key . '/(:any)/(:any)']['GET'] = 'home_controller/subcategory/$1/$2';
        $route[$key . '/(:any)'] = 'home_controller/any/$1';
    }
}

$route['(:any)/(:any)']['GET'] = 'home_controller/subcategory/$1/$2';
$route['(:any)']['GET'] = 'home_controller/any/$1';
