<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="<?php echo $this->selected_lang->short_form ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo xss_clean($title); ?> - <?php echo xss_clean($this->settings->site_title); ?></title>
    <meta name="description" content="<?php echo addslashes(xss_clean($description)); ?>"/>
    <meta name="keywords" content="<?php echo xss_clean($keywords); ?>"/>
    <meta name="author" content="Codingest"/>
    <meta property="og:locale" content="en_US"/>
    <meta property="og:site_name" content="<?php echo xss_clean($this->settings->application_name); ?>"/>
<?php if (isset($post_type)): ?>
    <meta property="og:type" content="<?php echo $og_type; ?>"/>
    <meta property="og:title" content="<?php echo $og_title; ?>"/>
    <meta property="og:description" content="<?php echo addslashes(xss_clean($description)); ?>"/>
    <meta property="og:url" content="<?php echo $og_url; ?>"/>
    <meta property="og:image" content="<?php echo $og_image; ?>"/>
    <meta property="og:image:width" content="<?php echo $og_width; ?>"/>
    <meta property="og:image:height" content="<?php echo $og_height; ?>"/>
    <meta property="article:author" content="<?php echo $og_author; ?>"/>
    <meta property="fb:app_id" content="<?php echo $this->general_settings->facebook_app_id; ?>"/>
<?php foreach ($og_tags as $tag): ?>
    <meta property="article:tag" content="<?php echo xss_clean($tag->tag); ?>"/>
<?php endforeach; ?>
    <meta property="article:published_time" content="<?php echo $og_published_time; ?>"/>
    <meta property="article:modified_time" content="<?php echo $og_modified_time; ?>"/>
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:site" content="@<?php echo xss_clean($this->settings->application_name); ?>"/>
    <meta name="twitter:creator" content="@<?php echo xss_clean($og_creator); ?>"/>
    <meta name="twitter:title" content="<?php echo xss_clean($post->title); ?>"/>
    <meta name="twitter:description" content="<?php echo addslashes(xss_clean($description)); ?>"/>
    <meta name="twitter:image" content="<?php echo $og_image; ?>"/>
<?php else: ?>
    <meta property="og:image" content="<?php echo get_logo($this->general_settings); ?>"/>
    <meta property="og:image:width" content="240"/>
    <meta property="og:image:height" content="90"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="<?php echo xss_clean($title); ?> - <?php echo xss_clean($this->settings->site_title); ?>"/>
    <meta property="og:description" content="<?php echo addslashes(xss_clean($description)); ?>"/>
    <meta property="og:url" content="<?php echo base_url(); ?>"/>
    <meta property="fb:app_id" content="<?php echo $this->general_settings->facebook_app_id; ?>"/>
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:site" content="@<?php echo xss_clean($this->settings->application_name); ?>"/>
    <meta name="twitter:title" content="<?php echo xss_clean($title); ?> - <?php echo xss_clean($this->settings->site_title); ?>"/>
    <meta name="twitter:description" content="<?php echo xss_clean($description); ?>"/>
<?php endif; ?>
    <link rel="canonical" href="<?php echo current_url(); ?>"/>
<?php if ($this->general_settings->multilingual_system == 1):
foreach ($this->languages as $language):
if ($language->id == $this->site_lang->id):?>
    <link rel="alternate" href="<?php echo base_url(); ?>" hreflang="<?php echo $language->language_code ?>"/>
<?php else: ?>
    <link rel="alternate" href="<?php echo base_url() . $language->short_form . "/"; ?>" hreflang="<?php echo $language->language_code ?>"/>
<?php endif; endforeach; endif; ?>
    <link rel="shortcut icon" type="image/png" href="<?php echo get_favicon($this->visual_settings); ?>"/>
    <!-- Font-icons CSS -->
    <link href="<?php echo base_url(); ?>assets/vendor/font-icons/css/vr-icons.min.css" rel="stylesheet"/>
    <?php echo !empty($this->fonts->primary_font_url) ? $this->fonts->primary_font_url : ''; ?>
    <?php echo !empty($this->fonts->secondary_font_url) ? $this->fonts->secondary_font_url : ''; ?>
    <?php echo !empty($this->fonts->tertiary_font_url) ? $this->fonts->tertiary_font_url : ''; ?>

    <link href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="<?php echo base_url(); ?>assets/css/style-1.7.1.min.css" rel="stylesheet"/>
    <!-- Plugins -->
    <link href="<?php echo base_url(); ?>assets/css/plugins-1.7.css" rel="stylesheet"/>
<?php if ($this->dark_mode == 1) : ?>
    <link href="<?php echo base_url(); ?>assets/css/dark.min.css" rel="stylesheet"/>
<?php endif; ?>
    <!-- Color CSS -->
<?php if ($this->site_color == '') : ?>
    <link href="<?php echo base_url(); ?>assets/css/colors/default.min.css" rel="stylesheet"/>
<?php else : ?>
    <link href="<?php echo base_url(); ?>assets/css/colors/<?php echo $this->site_color; ?>.min.css" rel="stylesheet"/>
<?php endif; ?>
    <script>var rtl = false;</script>
<?php if ($this->selected_lang->text_direction == "rtl"): ?>
    <link href="<?php echo base_url(); ?>assets/css/rtl.min.css" rel="stylesheet"/><script>var rtl = true;</script>
<?php endif; ?>
    <?php $this->load->view('partials/_font_style'); ?>
    <?php echo $this->general_settings->custom_css_codes; ?>

    <script src="<?php echo base_url(); ?>assets/js/jquery-1.12.4.min.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<header id="header">
    <?php $this->load->view('nav/_nav_top'); ?>
    <div class="logo-banner">
        <div class="container">
            <div class="col-sm-12">
                <div class="row">
                    <div class="left">
                        <a href="<?php echo lang_base_url(); ?>">
                            <img src="<?php echo $this->dark_mode == 1 ? get_logo_footer($this->visual_settings) : get_logo($this->visual_settings); ?>" alt="logo" class="logo">
                        </a>
                    </div>
                    <div class="right">
                        <div class="pull-right">
                            <!--Include banner-->
                            <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "header"]); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/.container-->
    </div><!--/.top-bar-->
    <?php $this->load->view('nav/_nav_main'); ?>

    <div class="mobile-nav-container">
        <div class="nav-mobile-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="nav-mobile-header-container">
                        <div class="menu-icon">
                            <a href="javascript:void(0)" class="btn-open-mobile-nav"><i class="icon-menu"></i></a>
                        </div>
                        <div class="mobile-logo">
                            <a href="<?php echo lang_base_url(); ?>">
                                <img src="<?php echo $this->dark_mode == 1 ? get_logo_footer($this->visual_settings) : get_logo($this->visual_settings); ?>" alt="logo" class="logo">
                            </a>
                        </div>
                        <div class="mobile-search">
                            <a class="search-icon"><i class="icon-search"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</header>
<div id="overlay_bg" class="overlay-bg"></div>

<div class="mobile-nav-search">
    <div class="search-form">
        <?php echo form_open(generate_url('search'), ['method' => 'get']); ?>
        <input type="text" name="q" maxlength="300" pattern=".*\S+.*"
               class="form-control form-input"
               placeholder="<?php echo trans("placeholder_search"); ?>" required>
        <button class="btn btn-default"><i class="icon-search"></i></button>
        <?php echo form_close(); ?>
    </div>
</div>
<?php $this->load->view('nav/_nav_mobile'); ?>
<?php $this->load->view('partials/_modals'); ?>


