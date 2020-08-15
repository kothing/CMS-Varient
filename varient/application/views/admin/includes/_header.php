<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo xss_clean($title); ?> - <?php echo trans("admin"); ?>&nbsp;<?php echo xss_clean($this->settings->site_title); ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" type="image/png" href="<?php echo get_favicon($this->visual_settings); ?>"/>
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700&display=swap&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/font-awesome/css/font-awesome.min.css">
    <link href="<?php echo base_url(); ?>assets/vendor/font-icons/css/vr-icons.min.css" rel="stylesheet"/>
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/AdminLTE.min.css">
    <!-- AdminLTE Skins -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/_all-skins.min.css">
    <!-- Datatables -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/datatables/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/datatables/jquery.dataTables_themeroller.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/icheck/square/purple.css">
    <!-- Page -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/pace/pace.min.css">
    <!-- Tags Input -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/tagsinput/jquery.tagsinput.min.css">
    <!-- Color Picker css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/colorpicker/bootstrap-colorpicker.min.css">
    <!-- File Manager css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/plugins/file-manager/file-manager.css">
    <!-- Custom css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css">
    <!-- Datetimepicker css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/custom.css">
    <!-- RTL -->
    <?php if (!empty($this->control_panel_lang)):
        if ($this->control_panel_lang->text_direction == 'rtl'):?>
            <link href="<?php echo base_url(); ?>assets/admin/css/rtl.css" rel="stylesheet"/>
        <?php endif;
    else:
        if ($this->selected_lang->text_direction == "rtl"):?>
            <link href="<?php echo base_url(); ?>assets/admin/css/rtl.css" rel="stylesheet"/>
        <?php
        endif;
    endif; ?>

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url(); ?>assets/admin/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/sweetalert/sweetalert.min.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script>
        var csfr_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var csfr_cookie_name = '<?php echo $this->config->item('csrf_cookie_name'); ?>';
        var base_url = '<?php echo base_url(); ?>';
        var fb_app_id = '<?php echo $this->general_settings->facebook_app_id; ?>';
        var txt_select_image = '<?php echo trans("select_image"); ?>';
        var sweetalert_ok = '<?php echo trans("ok"); ?>';
        var sweetalert_cancel = '<?php echo trans("cancel"); ?>';
    </script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo admin_url(); ?>" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b><?php echo html_escape($this->settings->application_name); ?></b> <?php echo trans("panel"); ?></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </a>
            <div class="navbar-custom-menu">
                <?php echo form_open('admin_controller/control_panel_language_post', ['id' => 'form_control_panel_lang']); ?>
                <ul class="nav navbar-nav">
                    <li>
                        <a class="btn btn-sm btn-success pull-left btn-site-prev" target="_blank" href="<?php echo base_url(); ?>"><i class="fa fa-eye"></i> <?php echo trans("view_site"); ?></a>
                    </li>

                    <li class="dropdown user-menu">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                            <i class="fa fa-globe"></i>&nbsp;
                            <?php if (!empty($this->control_panel_lang)) {
                                echo $this->control_panel_lang->name;
                            } ?>
                            <span class="fa fa-caret-down"></span>
                        </a>

                        <ul class="dropdown-menu">
                            <?php
                            foreach ($this->languages as $language):
                                $lang_url = base_url() . $language->short_form . "/";
                                if ($language->id == $this->general_settings->site_lang) {
                                    $lang_url = base_url();
                                } ?>
                                <li>
                                    <button type="submit" value="<?php echo $language->id; ?>" name="lang_id" class="control-panel-lang-btn"><?php echo character_limiter($language->name, 20, '...'); ?></button>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                    </li>
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <img src="<?php echo get_user_avatar($this->auth_user); ?>" class="user-image" alt="">
                            <span class="hidden-xs"><?php echo $this->auth_user->username; ?> <i class="fa fa-caret-down"></i> </span>
                        </a>
                        <ul class="dropdown-menu  pull-right" role="menu" aria-labelledby="user-options">
                            <li>
                                <a href="<?php echo generate_profile_url($this->auth_user->slug); ?>"><i class="fa fa-user"></i> <?php echo trans("profile"); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo generate_url('settings'); ?>"><i class="fa fa-cog"></i> <?php echo trans("update_profile"); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo generate_url('settings', 'change_password'); ?>"><i class="fa fa-lock"></i> <?php echo trans("change_password"); ?></a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="<?php echo generate_url('logout'); ?>"><i class="fa fa-sign-out"></i> <?php echo trans("logout"); ?></a>
                            </li>
                        </ul>
                    </li>

                </ul>
                <?php echo form_close(); ?>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<?php echo get_user_avatar($this->auth_user); ?>" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p><?php echo html_escape($this->auth_user->username); ?></p>
                    <a href="#"><i class="fa fa-circle text-success"></i> <?php echo trans("online"); ?></a>
                </div>
            </div>


            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header"><?php echo trans("main_navigation"); ?></li>
                <li>
                    <a href="<?php echo admin_url(); ?>">
                        <i class="fa fa-home"></i>
                        <span><?php echo trans("home"); ?></span>
                    </a>
                </li>
                <?php if (check_user_permission('navigation')): ?>
                    <li>
                        <a href="<?php echo admin_url(); ?>navigation?lang=<?php echo $this->general_settings->site_lang; ?>">
                            <i class="fa fa-th"></i>
                            <span><?php echo trans("navigation"); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (is_admin()): ?>
                    <li>
                        <a href="<?php echo admin_url(); ?>themes">
                            <i class="fa fa-leaf"></i>
                            <span><?php echo trans("themes"); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (check_user_permission('pages')): ?>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-file-text"></i> <span><?php echo trans("pages"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="<?php echo admin_url(); ?>add-page"><?php echo trans("add_page"); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo admin_url(); ?>pages"><?php echo trans("pages"); ?></a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (check_user_permission('add_post')): ?>
                    <li>
                        <a href="<?php echo admin_url(); ?>post-format">
                            <i class="fa fa-file"></i>
                            <span><?php echo trans("add_post"); ?></span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-bars"></i> <span><?php echo trans("posts"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="<?php echo admin_url(); ?>posts"><?php echo trans("posts"); ?></a>
                            </li>
                            <?php if (check_user_permission('manage_all_posts')): ?>
                                <li>
                                    <a href="<?php echo admin_url(); ?>slider-posts"><?php echo trans("slider_posts"); ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo admin_url(); ?>featured-posts"><?php echo trans("featured_posts"); ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo admin_url(); ?>breaking-news"><?php echo trans("breaking_news"); ?></a>
                                </li>
                                <li>
                                    <a href="<?php echo admin_url(); ?>recommended-posts"><?php echo trans("recommended_posts"); ?></a>
                                </li>
                            <?php endif; ?>
                            <li>
                                <a href="<?php echo admin_url(); ?>pending-posts"><?php echo trans("pending_posts"); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo admin_url(); ?>scheduled-posts"><?php echo trans("scheduled_posts"); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo admin_url(); ?>drafts"><?php echo trans("drafts"); ?></a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (check_user_permission('rss_feeds')): ?>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-rss"></i> <span><?php echo trans("rss_feeds"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="<?php echo admin_url(); ?>import-feed"><?php echo trans("import_rss_feed"); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo admin_url(); ?>feeds"><?php echo trans("rss_feeds"); ?></a>
                            </li>

                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (check_user_permission('categories')): ?>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-folder-open"></i> <span><?php echo trans("categories"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="<?php echo admin_url(); ?>categories"><?php echo trans("categories"); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo admin_url(); ?>subcategories"><?php echo trans("subcategories"); ?></a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (check_user_permission('widgets')): ?>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-th"></i> <span><?php echo trans("widgets"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="<?php echo admin_url(); ?>add-widget"><?php echo trans("add_widget"); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo admin_url(); ?>widgets"><?php echo trans("widgets"); ?></a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (check_user_permission('polls')): ?>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-list"></i> <span><?php echo trans("polls"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="<?php echo admin_url(); ?>add-poll"><?php echo trans("add_poll"); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo admin_url(); ?>polls"><?php echo trans("polls"); ?></a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (check_user_permission('gallery')): ?>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-image"></i> <span><?php echo trans("gallery"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="<?php echo admin_url(); ?>gallery"><?php echo trans("images"); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo admin_url(); ?>gallery-albums"><?php echo trans("albums"); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo admin_url(); ?>gallery-categories"><?php echo trans("categories"); ?></a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (check_user_permission('comments_contact')): ?>
                    <li>
                        <a href="<?php echo admin_url(); ?>contact-messages">
                            <i class="fa fa-paper-plane" aria-hidden="true"></i>
                            <span><?php echo trans("contact_messages"); ?></span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-comments"></i> <span><?php echo trans("comments"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="<?php echo admin_url(); ?>pending-comments"><?php echo trans("pending_comments"); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo admin_url(); ?>comments"><?php echo trans("approved_comments"); ?></a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (check_user_permission('newsletter')): ?>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-envelope"></i> <span><?php echo trans("newsletter"); ?></span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="<?php echo admin_url(); ?>send-email-subscribers"><?php echo trans("send_email_subscribers"); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo admin_url(); ?>subscribers"><?php echo trans("subscribers"); ?></a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (check_user_permission('ad_spaces')): ?>
                    <li>
                        <a href="<?php echo admin_url(); ?>ad-spaces">
                            <i class="fa fa-dollar" aria-hidden="true"></i>
                            <span><?php echo trans("ad_spaces"); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (check_user_permission('users')): ?>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-users"></i>
                            <span><?php echo trans("users"); ?></span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <?php if (is_admin()): ?>
                                <li><a href="<?php echo admin_url(); ?>add-user"> <?php echo trans("add_user"); ?></a></li>
                                <li><a href="<?php echo admin_url(); ?>administrators"> <?php echo trans("administrators"); ?></a></li>
                            <?php endif; ?>
                            <li><a href="<?php echo admin_url(); ?>users"> <?php echo trans("users"); ?></a></li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (is_admin()): ?>
                    <li>
                        <a href="<?php echo admin_url(); ?>roles-permissions">
                            <i class="fa fa-key" aria-hidden="true"></i>
                            <span><?php echo trans("roles_permissions"); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (check_user_permission('seo_tools')): ?>
                    <li>
                        <a href="<?php echo admin_url(); ?>seo-tools"><i class="fa fa-wrench"></i>
                            <span><?php echo trans("seo_tools"); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (is_admin()): ?>
                    <li>
                        <a href="<?php echo admin_url(); ?>social-login-configuration"><i class="fa fa-share-alt"></i>
                            <span><?php echo trans("social_login_configuration"); ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo admin_url(); ?>cache-system">
                            <i class="fa fa-database"></i>
                            <span><?php echo trans("cache_system"); ?></span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (check_user_permission('settings')): ?>
                    <li class="header"><?php echo trans("settings"); ?></li>
                    <li>
                        <a href="<?php echo admin_url(); ?>preferences">
                            <i class="fa fa-check-square-o"></i>
                            <span><?php echo trans("preferences"); ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo admin_url(); ?>route-settings">
                            <i class="fa fa-map-signs"></i>
                            <span><?php echo trans("route_settings"); ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo admin_url(); ?>email-settings">
                            <i class="fa fa-cog"></i>
                            <span><?php echo trans("email_settings"); ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo admin_url(); ?>visual-settings">
                            <i class="fa fa-paint-brush"></i>
                            <span><?php echo trans("visual_settings"); ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo admin_url(); ?>font-settings"><i class="fa fa-font" aria-hidden="true"></i>
                            <span><?php echo trans("font_settings"); ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo admin_url(); ?>language-settings">
                            <i class="fa fa-language"></i>
                            <span><?php echo trans("language_settings"); ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo admin_url(); ?>settings">
                            <i class="fa fa-cogs"></i>
                            <span><?php echo trans("general_settings"); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
