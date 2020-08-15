<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
    <!--if facebook url exists-->
<?php if (!empty($this->settings->facebook_url)) : ?>
    <li>
        <a class="facebook" href="<?php echo html_escape($this->settings->facebook_url); ?>"
           target="_blank"><i class="icon-facebook"></i></a>
    </li>
<?php endif; ?>
    <!--if twitter url exists-->
<?php if (!empty($this->settings->twitter_url)) : ?>
    <li>
        <a class="twitter" href="<?php echo html_escape($this->settings->twitter_url); ?>"
           target="_blank"><i class="icon-twitter"></i></a>
    </li>
<?php endif; ?>
    <!--if pinterest url exists-->
<?php if (!empty($this->settings->pinterest_url)) : ?>
    <li>
        <a class="pinterest" href="<?php echo html_escape($this->settings->pinterest_url); ?>"
           target="_blank"><i class="icon-pinterest"></i></a>
    </li>
<?php endif; ?>
    <!--if instagram url exists-->
<?php if (!empty($this->settings->instagram_url)) : ?>
    <li>
        <a class="instagram" href="<?php echo html_escape($this->settings->instagram_url); ?>"
           target="_blank"><i class="icon-instagram"></i></a>
    </li>
<?php endif; ?>
    <!--if linkedin url exists-->
<?php if (!empty($this->settings->linkedin_url)) : ?>
    <li>
        <a class="linkedin" href="<?php echo html_escape($this->settings->linkedin_url); ?>"
           target="_blank"><i class="icon-linkedin"></i></a>
    </li>
<?php endif; ?>

    <!--if vk url exists-->
<?php if (!empty($this->settings->vk_url)) : ?>
    <li>
        <a class="vk" href="<?php echo html_escape($this->settings->vk_url); ?>"
           target="_blank"><i class="icon-vk"></i></a>
    </li>
<?php endif; ?>

    <!--if telegram url exists-->
<?php if (!empty($this->settings->telegram_url)) : ?>
    <li>
        <a class="telegram" href="<?php echo html_escape($this->settings->telegram_url); ?>"
           target="_blank"><i class="icon-telegram"></i></a>
    </li>
<?php endif; ?>

    <!--if youtube url exists-->
<?php if (!empty($this->settings->youtube_url)) : ?>
    <li>
        <a class="youtube" href="<?php echo html_escape($this->settings->youtube_url); ?>"
           target="_blank"><i class="icon-youtube"></i></a>
    </li>
<?php endif; ?>

    <!--if rss active-->
<?php if (!empty($this->general_settings->show_rss) && $rss_hide == false) : ?>
    <li>
        <a class="rss" href="<?php echo generate_url('rss_feeds'); ?>"><i class="icon-rss"></i>
        </a>
    </li>
<?php endif; ?>