<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if ($this->general_settings->show_post_author == 1): ?>
    <a href="<?php echo generate_profile_url($post->author_slug); ?>"><?php echo html_escape($post->author_username); ?></a>
<?php endif; ?>
<?php if ($this->general_settings->show_post_date == 1): ?>
    <span><?php echo helper_date_format($post->created_at); ?></span>
<?php endif; ?>
<?php if ($this->general_settings->comment_system == 1): ?>
    <span><i class="icon-comment"></i><?php echo $post->comment_count; ?></span>
<?php endif; ?>
<?php if ($this->general_settings->show_hits): ?>
    <span class="m-r-0"><i class="icon-eye"></i><?php echo (isset($post->pageviews_count)) ? $post->pageviews_count : $post->pageviews; ?></span>
<?php endif; ?>