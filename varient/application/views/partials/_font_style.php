<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
    body {<?php echo $this->fonts->primary_font_family; ?>  } .font-1,.post-content .post-summary {<?php echo $this->fonts->secondary_font_family; ?>}.font-text{<?php echo $this->fonts->tertiary_font_family; ?>}.h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {<?php echo $this->fonts->secondary_font_family; ?>}.section-mid-title .title {<?php echo $this->fonts->secondary_font_family; ?>}.section .section-content .title {<?php echo $this->fonts->secondary_font_family; ?>}.section .section-head .title {<?php echo $this->fonts->primary_font_family; ?>}.sidebar-widget .widget-head .title {<?php echo $this->fonts->primary_font_family; ?>}.post-content .post-text {<?php echo $this->fonts->tertiary_font_family; ?>}
    .top-bar,.news-ticker-title,.section .section-head .title,.sidebar-widget .widget-head,.section-mid-title .title, #comments .comment-section > .nav-tabs > .active > a {
        background-color: <?php echo $this->visual_settings->site_block_color; ?>
    }
    .section .section-head,.section-mid-title, .comment-section .nav-tabs {
        border-bottom: 2px solid <?php echo $this->visual_settings->site_block_color; ?>;
    }
    .post-content .post-summary h2 {<?php echo $this->fonts->tertiary_font_family; ?>}
</style>