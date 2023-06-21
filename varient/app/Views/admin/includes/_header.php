<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= esc($title); ?> - <?= trans("admin"); ?>&nbsp;<?= esc($baseSettings->site_title); ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" type="image/png" href="<?= getFavicon(); ?>"/>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap-v3/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/font-awesome/css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/AdminLTE.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/_all-skins.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/datatables/dataTables.bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/datatables/jquery.dataTables_themeroller.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/icheck/square/purple.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/pace/pace.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/tagsinput/jquery.tagsinput.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/colorpicker/bootstrap-colorpicker.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/file-manager/file-manager-2.1.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/file-uploader/css/jquery.dm-uploader.min.css'); ?>"/>
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/file-uploader/css/styles-1.0.css'); ?>"/>
    <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/tippy/svg-arrow.css'); ?>"/>
    <link rel="stylesheet" href="<?= base_url('assets/admin/css/custom-2.1.css'); ?>">
    <script src="<?= base_url('assets/admin/js/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/sweetalert/sweetalert.min.js'); ?>"></script>
    <script>var directionality = "ltr";</script>
    <?php if ($activeLang->text_direction == 'rtl'): ?>
        <link href="<?= base_url('assets/admin/css/rtl-2.1.css'); ?>" rel="stylesheet"/>
        <script>directionality = "rtl";</script>
    <?php endif; ?>
    <script>
        var VrConfig = {baseURL: '<?= base_url(); ?>', csrfTokenName: '<?= csrf_token() ?>', csrfCookieName: '<?= config('App')->CSRFCookieName; ?>', sysLangId: '<?= $activeLang->id; ?>', textSelectImage: "<?= trans("select_image"); ?>", textOk: "<?= trans("ok"); ?>", textCancel: "<?= trans("cancel"); ?>", textProcessing: "<?= trans("txt_processing"); ?>"};

        function getCsrfHash() {
            var name = VrConfig.csrfCookieName + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }

        function addCsrf(data) {
            data[VrConfig.csrfTokenName] = getCsrfHash();
            data['sysLangId'] = VrConfig.sysLangId;
        }
    </script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <header class="main-header">
        <nav class="navbar navbar-static-top" role="navigation">
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <svg width="24" height="24" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="menu-fold-icon">
                    <path d="M6 9 H42" stroke="#555" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M19 19 H42" stroke="#555" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M19 29 H42" stroke="#555" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M11 19 L6 24 L11 29" stroke="#555" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M6 39 H42" stroke="#555" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <svg width="24" height="24" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="menu-unfold-icon">
                    <path d="M6 9 H42" stroke="#555" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M19 19 H42" stroke="#555" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M19 29 H42" stroke="#555" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M6 19 L11 24 L6 29" stroke="#555" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M6 39 H42" stroke="#555" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li>
                        <a class="btn btn-sm btn-success pull-left btn-site-prev" target="_blank" href="<?= base_url(); ?>">
                            <i class="fa fa-eye"></i> <?= trans("view_site"); ?>
                        </a>
                    </li>
                    <li class="dropdown user-menu">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                            <i class="fa fa-globe"></i>&nbsp;
                            <?= esc($activeLang->name); ?>
                            <span class="fa fa-caret-down"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <?php if (!empty($activeLanguages)):
                                foreach ($activeLanguages as $language): ?>
                                    <li>
                                        <form action="<?= base_url('AdminController/setActiveLanguagePost'); ?>" method="post">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" name="back_url" value="<?= currentFullURL(); ?>">
                                            <button type="submit" value="<?= $language->id; ?>" name="lang_id" class="control-panel-lang-btn"><?= characterLimiter($language->name, 20, '...'); ?></button>
                                        </form>
                                    </li>
                                <?php endforeach;
                            endif; ?>
                        </ul>
                    </li>
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <img src="<?= getUserAvatar(user()->avatar); ?>" class="user-image" alt="">
                            <span class="hidden-xs"><?= esc(user()->username); ?>
                                <i class="fa fa-caret-down"></i>
                            </span>
                        </a>
                        <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="user-options">
                            <li>
                                <a href="<?= generateProfileURL(user()->slug); ?>">
                                    <i class="fa fa-user"></i> <?= trans("profile"); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?= generateURL('settings'); ?>">
                                    <i class="fa fa-cog"></i> <?= trans("update_profile"); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?= generateURL('settings', 'change_password'); ?>">
                                    <i class="fa fa-lock"></i> <?= trans("change_password"); ?>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="<?= generateURL('logout'); ?>">
                                    <i class="fa fa-sign-out"></i> <?= trans("logout"); ?>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <aside class="main-sidebar">
        <section class="sidebar">
            <a class="logo" href="<?= adminUrl(); ?>">
                <span class="logo-mini">
                    <i class="fa fa-dashboard fa-lg"></i>
                </span>
                <span class="logo-lg">
                    <b><?= esc($baseSettings->application_name); ?></b> 
                    <?= trans("panel"); ?>
                </span>
            </a>
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<?= getUserAvatar(user()->avatar); ?>" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p class="name"><?= esc(user()->username); ?></p>
                    <span class="status">
                        <i class="fa fa-circle text-success"></i> <?= trans("online"); ?>
                    </span>
                </div>
            </div>
            <dv class="sidebar-scrollbar">
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header"><?= trans("main_navigation"); ?></li>
                    <li class="nav-home<?php echo empty(getSegmentValue(2)) ? ' active' : '' ; ?>">
                        <a href="<?= adminUrl(); ?>">
                            <i class="fa fa-home"></i>
                            <span class="label-name"><?= trans("home"); ?></span>
                        </a>
                    </li>
                    <?php if (checkUserPermission('navigation')): ?>
                        <li class="nav-navigation<?php isAdminNavActive(['navigation']); ?>">
                            <a href="<?= adminUrl('navigation?lang=' . $activeLang->id); ?>">
                                <i class="fa fa-th"></i>
                                <span class="label-name"><?= trans("navigation"); ?></span>
                            </a>
                        </li>
                    <?php endif;
                    if (isAdmin()): ?>
                        <li class="nav-themes<?php isAdminNavActive(['themes']); ?>">
                            <a href="<?= adminUrl('themes'); ?>">
                                <i class="fa fa-paint-brush"></i>
                                <span class="label-name"><?= trans("themes"); ?></span>
                            </a>
                        </li>
                    <?php endif;
                    if (checkUserPermission('pages')): ?>
                        <li class="nav-pages<?php isAdminNavActive(['pages']); ?>">
                            <a href="<?= adminUrl('pages'); ?>">
                                <i class="fa fa-file-text"></i>
                                <span class="label-name"><?= trans("pages"); ?></span>
                            </a>
                        </li>
                    <?php endif;
                    if (checkUserPermission('add_post')): ?>
                        <li class="nav-treeview treeview<?php isAdminNavActive(['posts', 'slider-posts', 'featured-posts', 'breaking-news', 'recommended-posts', 'pending-posts', 'scheduled-posts', 'drafts', 'update-post']); ?>">
                            <a href="#">
                                <i class="fa fa-bars"></i> 
                                <span class="label-name"><?= trans("posts"); ?></span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="nav-posts<?php isAdminNavActive(['posts']); ?>">
                                    <a href="<?= adminUrl('posts'); ?>"><?= trans("posts"); ?></a>
                                </li>
                                <?php if (checkUserPermission('manage_all_posts')): ?>
                                    <li class="nav-slider-posts<?php isAdminNavActive(['slider-posts']); ?>">
                                        <a href="<?= adminUrl('slider-posts'); ?>">
                                            <?= trans("slider_posts"); ?>
                                        </a>
                                    </li>
                                    <li class="nav-featured-posts<?php isAdminNavActive(['featured-posts']); ?>">
                                        <a href="<?= adminUrl('featured-posts'); ?>">
                                            <?= trans("featured_posts"); ?>
                                        </a>
                                    </li>
                                    <li class="nav-breaking-news<?php isAdminNavActive(['breaking-news']); ?>">
                                        <a href="<?= adminUrl('breaking-news'); ?>">
                                            <?= trans("breaking_news"); ?>
                                        </a>
                                    </li>
                                    <li class="nav-recommended-posts<?php isAdminNavActive(['recommended-posts']); ?>">
                                        <a href="<?= adminUrl('recommended-posts'); ?>">
                                            <?= trans("recommended_posts"); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <li class="nav-pending-posts<?php isAdminNavActive(['pending-posts']); ?>">
                                    <a href="<?= adminUrl('pending-posts'); ?>">
                                        <?= trans("pending_posts"); ?>
                                    </a>
                                </li>
                                <li class="nav-scheduled-posts<?php isAdminNavActive(['scheduled-posts']); ?>">
                                    <a href="<?= adminUrl('scheduled-posts'); ?>">
                                        <?= trans("scheduled_posts"); ?>
                                    </a>
                                </li>
                                <li class="nav-drafts<?php isAdminNavActive(['drafts']); ?>">
                                    <a href="<?= adminUrl('drafts'); ?>">
                                        <?= trans("drafts"); ?>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-post-format nav-add-post<?php isAdminNavActive(['post-format']); ?>">
                            <a href="<?= adminUrl('post-format'); ?>">
                                <i class="fa fa-cubes"></i>
                                <span class="label-name"><?= trans("add_post"); ?></span>
                            </a>
                        </li>
                        <li class="nav-import-posts<?php isAdminNavActive(['bulk-post-upload']); ?>">
                            <a href="<?= adminUrl('bulk-post-upload'); ?>">
                                <i class="fa fa-upload"></i>
                                <span class="label-name"><?= trans("bulk_post_upload"); ?></span>
                            </a>
                        </li>
                    <?php endif;
                    if (checkUserPermission('categories')): ?>
                        <li class="nav-treeview treeview<?php isAdminNavActive(['categories', 'subcategories', 'add-category', 'add-subcategory', 'edit-category', 'edit-subcategory']); ?>">
                            <a href="#">
                                <i class="fa fa-folder-open"></i>
                                <span class="label-name"><?= trans("categories"); ?></span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="nav-categories<?php isAdminNavActive(['categories']); ?>">
                                    <a href="<?= adminUrl('categories'); ?>">
                                        <?= trans("categories"); ?>
                                    </a>
                                </li>
                                <li class="nav-subcategories<?php isAdminNavActive(['subcategories']); ?>">
                                    <a href="<?= adminUrl('subcategories'); ?>">
                                        <?= trans("subcategories"); ?>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php endif;
                    if (checkUserPermission('rss_feeds')): ?>
                        <li class="nav-feeds<?php isAdminNavActive(['feeds']); ?>">
                            <a href="<?= adminUrl('feeds'); ?>">
                                <i class="fa fa-rss" aria-hidden="true"></i>
                                <span class="label-name"><?= trans("rss_feeds"); ?></span>
                            </a>
                        </li>
                    <?php endif;
                    if (checkUserPermission('widgets')): ?>
                        <li class="nav-widgets<?php isAdminNavActive(['widgets']); ?>">
                            <a href="<?= adminUrl('widgets'); ?>">
                                <i class="fa fa-tasks" aria-hidden="true"></i>
                                <span class="label-name"><?= trans("widgets"); ?></span>
                            </a>
                        </li>
                    <?php endif;
                    if (checkUserPermission('polls')): ?>
                        <li class="nav-polls<?php isAdminNavActive(['polls']); ?>">
                            <a href="<?= adminUrl('polls'); ?>">
                                <i class="fa fa-hand-paper-o" aria-hidden="true"></i>
                                <span class="label-name"><?= trans("polls"); ?></span>
                            </a>
                        </li>
                    <?php endif;
                    if (checkUserPermission('gallery')): ?>
                        <li class="treeview<?php isAdminNavActive(['gallery-images', 'gallery-albums', 'gallery-categories', 'update-gallery-image', 'update-gallery-album', 'update-gallery-category', 'gallery-add-image']); ?>">
                            <a href="#">
                                <i class="fa fa-image"></i> 
                                <span class="label-name"><?= trans("gallery"); ?></span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="nav-gallery-images<?php isAdminNavActive(['gallery-images']); ?>">
                                    <a href="<?= adminUrl('gallery-images'); ?>">
                                        <?= trans("images"); ?>
                                    </a>
                                </li>
                                <li class="nav-gallery-albums<?php isAdminNavActive(['gallery-albums']); ?>">
                                    <a href="<?= adminUrl('gallery-albums'); ?>">
                                        <?= trans("albums"); ?>
                                    </a>
                                </li>
                                <li class="nav-gallery-categories<?php isAdminNavActive(['gallery-categories']); ?>">
                                    <a href="<?= adminUrl('gallery-categories'); ?>">
                                        <?= trans("gallery_categories"); ?>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php endif;
                    if (checkUserPermission('comments_contact')): ?>
                        <li class="nav-contact-messages<?php isAdminNavActive(['contact-messages']); ?>">
                            <a href="<?= adminUrl('contact-messages'); ?>">
                                <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                <span class="label-name"><?= trans("contact_messages"); ?>
                            </span>
                        </a>
                        </li>
                        <li class="nav-treeview treeview<?php isAdminNavActive(['comments', 'pending-comments']); ?>">
                            <a href="#">
                                <i class="fa fa-comments"></i> 
                                <span class="label-name"><?= trans("comments"); ?></span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="nav-pending-comments<?php isAdminNavActive(['pending-comments']); ?>">
                                    <a href="<?= adminUrl('pending-comments'); ?>">
                                        <?= trans("pending_comments"); ?>
                                    </a>
                                </li>
                                <li class="nav-comments<?php isAdminNavActive(['comments']); ?>">
                                    <a href="<?= adminUrl('comments'); ?>">
                                        <?= trans("approved_comments"); ?>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php endif;
                    if (checkUserPermission('newsletter')): ?>
                        <li class="nav-newsletter<?php isAdminNavActive(['newsletter']); ?>">
                            <a href="<?= adminUrl('newsletter'); ?>">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                <span class="label-name"><?= trans("newsletter"); ?></span>
                            </a>
                        </li>
                    <?php endif;
                    if (checkUserPermission('reward_system')): ?>
                        <li class="nav-treeview treeview<?php isAdminNavActive(['reward-system']); ?>">
                            <a href="#">
                                <i class="fa fa-money"></i> 
                                <span class="label-name"><?= trans("reward_system"); ?></span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="nav-reward-system<?php isAdminNavActive(['reward-system']); ?>">
                                    <a href="<?= adminUrl('reward-system'); ?>">
                                        <?= trans("reward_system"); ?>
                                    </a>
                                </li>
                                <li class="nav-reward-system-earnings<?php isAdminNavActive(['earnings'], 3); ?>">
                                    <a href="<?= adminUrl('reward-system/earnings'); ?>">
                                        <?= trans("earnings"); ?>
                                    </a>
                                </li>
                                <li class="nav-reward-system-payouts<?php isAdminNavActive(['payouts'], 3); ?>">
                                    <a href="<?= adminUrl('reward-system/payouts'); ?>">
                                        <?= trans("payouts"); ?>
                                    </a>
                                </li>
                                <li class="nav-reward-system-pageviews<?php isAdminNavActive(['pageviews'], 3); ?>">
                                    <a href="<?= adminUrl('reward-system/pageviews'); ?>">
                                        <?= trans("pageviews"); ?>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php endif;
                    if (checkUserPermission('ad_spaces')): ?>
                        <li class="nav-ad-spaces<?php isAdminNavActive(['ad-spaces']); ?>">
                            <a href="<?= adminUrl('ad-spaces'); ?>">
                                <i class="fa fa-dollar" aria-hidden="true"></i>
                                <span class="label-name"><?= trans("ad_spaces"); ?></span>
                            </a>
                        </li>
                    <?php endif;
                    if (checkUserPermission('users')): ?>
                        <li class="nav-treeview treeview<?php isAdminNavActive(['users', 'add-user', 'administrators', 'edit-user']); ?>">
                            <a href="#">
                                <i class="fa fa-users"></i>
                                <span class="label-name"><?= trans("users"); ?></span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <?php if (isAdmin()): ?>
                                    <li class="nav-add-user<?php isAdminNavActive(['add-user']); ?>">
                                        <a href="<?= adminUrl('add-user'); ?>"> 
                                            <?= trans("add_user"); ?>
                                        </a>
                                    </li>
                                    <li class="nav-administrators<?php isAdminNavActive(['administrators']); ?>">
                                        <a href="<?= adminUrl('administrators'); ?>"> 
                                            <?= trans("administrators"); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <li class="nav-users<?php isAdminNavActive(['users']); ?>">
                                    <a href="<?= adminUrl('users'); ?>"> 
                                        <?= trans("users"); ?>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php endif;
                    if (isAdmin()): ?>
                        <li class="nav-roles-permissions<?php isAdminNavActive(['roles-permissions']); ?>">
                            <a href="<?= adminUrl('roles-permissions'); ?>">
                                <i class="fa fa-key" aria-hidden="true"></i>
                                <span class="label-name"><?= trans("roles_permissions"); ?></span>
                            </a>
                        </li>
                    <?php endif;
                    if (checkUserPermission('seo_tools')): ?>
                        <li class="nav-seo-tools<?php isAdminNavActive(['seo-tools']); ?>">
                            <a href="<?= adminUrl('seo-tools'); ?>">
                                <i class="fa fa-wrench"></i>
                                <span class="label-name"><?= trans("seo_tools"); ?></span>
                            </a>
                        </li>
                    <?php endif;
                    if (isAdmin()): ?>
                        <li class="nav-storage<?php isAdminNavActive(['storage']); ?>">
                            <a href="<?= adminUrl('storage'); ?>">
                                <i class="fa fa-cloud-upload"></i>
                                <span class="label-name"><?= trans("storage"); ?></span>
                            </a>
                        </li>
                        <li class="nav-cache-system<?php isAdminNavActive(['cache-system']); ?>">
                            <a href="<?= adminUrl('cache-system'); ?>">
                                <i class="fa fa-database"></i>
                                <span class="label-name"><?= trans("cache_system"); ?></span>
                            </a>
                        </li>
                    <?php endif;
                    if (checkUserPermission('settings')): ?>
                        <li class="header"><?= trans("settings"); ?></li>
                        <li class="nav-preferences<?php isAdminNavActive(['preferences']); ?>">
                            <a href="<?= adminUrl('preferences'); ?>">
                                <i class="fa fa-sliders"></i>
                                <span class="label-name"><?= trans("preferences"); ?></span>
                            </a>
                        </li>
                        <li class="nav-route-settings<?php isAdminNavActive(['route-settings']); ?>">
                            <a href="<?= adminUrl('route-settings'); ?>">
                                <i class="fa fa-map-signs"></i>
                                <span class="label-name"><?= trans("route_settings"); ?></span>
                            </a>
                        </li>
                        <li class="nav-email-settings<?php isAdminNavActive(['email-settings']); ?>">
                            <a href="<?= adminUrl('email-settings'); ?>">
                                <i class="fa fa-inbox"></i>
                                <span class="label-name"><?= trans("email_settings"); ?></span>
                            </a>
                        </li>
                        <li class="nav-font-settings<?php isAdminNavActive(['font-settings']); ?>">
                            <a href="<?= adminUrl('font-settings'); ?>">
                                <i class="fa fa-font" aria-hidden="true"></i>
                                <span class="label-name"><?= trans("font_settings"); ?></span>
                            </a>
                        </li>
                        <li class="nav-social-login-settings<?php isAdminNavActive(['social-login-settings']); ?>">
                            <a href="<?= adminUrl('social-login-settings'); ?>">
                                <i class="fa fa-share-alt" aria-hidden="true"></i>
                                <span class="label-name"><?= trans("social_login_settings"); ?></span>
                            </a>
                        </li>
                        <li class="nav-language-settings<?php isAdminNavActive(['language-settings']); ?>">
                            <a href="<?= adminUrl('language-settings'); ?>">
                                <i class="fa fa-language"></i>
                                <span class="label-name"><?= trans("language_settings"); ?></span>
                            </a>
                        </li>
                        <li class="nav-general-settings<?php isAdminNavActive(['general-settings']); ?>">
                            <a href="<?= adminUrl('general-settings'); ?>">
                                <i class="fa fa-cogs"></i>
                                <span class="label-name"><?= trans("general_settings"); ?></span>
                            </a>
                        </li>
                    <?php endif;
                    if (isAdmin()): ?>
                        <li>
                            <div class="database-backup">
                                <form action="<?= base_url('AdminController/downloadDatabaseBackup'); ?>" method="post">
                                    <?= csrf_field(); ?>
                                    <button type="submit" class="btn btn-block"><i class="fa fa-download"></i>&nbsp;&nbsp;<?= trans("download_database_backup"); ?></button>
                                </form>
                            </div>
                        </li>
                    <?php endif; ?>
                </ul>
            </dv>
            <div class="sidebar-footer"><p>&nbsp;</p></li>
        </section>
    </aside>
    <div class="content-wrapper">
        <section class="content">
