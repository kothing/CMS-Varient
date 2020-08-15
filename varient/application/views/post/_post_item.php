<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!--Post row item-->
<div class="post-item<?php echo check_post_img($post, 'class'); ?>">
    <?php if (isset($show_label)): ?>
        <a href="<?php echo generate_category_url_by_id($post->category_id); ?>">
            <span class="category-label" style="background-color: <?php echo html_escape($post->category_color); ?>"><?php echo html_escape($post->category_name); ?></span>
        </a>
    <?php endif;?>
    <?php if (check_post_img($post)): ?>
        <div class="post-item-image">
            <a href="<?php echo generate_post_url($post); ?>">
                <?php $this->load->view("post/_post_image", ["post_item" => $post, "type" => "medium"]); ?>
            </a>
        </div>
    <?php endif; ?>
    <h3 class="title">
        <a href="<?php echo generate_post_url($post); ?>">
            <?php echo html_escape(character_limiter($post->title, 55, '...')); ?>
        </a>
    </h3>
    <p class="post-meta">
        <?php $this->load->view("post/_post_meta", ["post" => $post]); ?>
    </p>
    <p class="description">
        <?php echo html_escape(character_limiter($post->summary, 80, '...')); ?>
    </p>
</div>