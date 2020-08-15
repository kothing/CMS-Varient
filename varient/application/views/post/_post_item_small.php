<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!--Post item small-->
<div class="post-item-small<?php echo check_post_img($post, 'class'); ?>">
    <?php if (check_post_img($post)): ?>
        <div class="left">
            <a href="<?php echo generate_post_url($post); ?>">
                <?php $this->load->view("post/_post_image", ["post_item" => $post, "type" => "small"]); ?>
            </a>
        </div>
    <?php endif; ?>
    <div class="right">
        <h3 class="title">
            <a href="<?php echo generate_post_url($post); ?>">
                <?php echo html_escape(character_limiter($post->title, 55, '...')); ?>
            </a>
        </h3>
        <p class="small-post-meta">
            <?php $this->load->view("post/_post_meta", ["post" => $post]); ?>
        </p>
    </div>
</div>