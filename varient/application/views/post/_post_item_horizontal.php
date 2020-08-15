<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!--Post row item-->
<div class="col-sm-12 col-xs-12">
    <div class="row">
        <div class="post-item-horizontal<?php echo check_post_img($post, 'class'); ?>">
            <?php if (isset($show_label)): ?>
                <a href="<?php echo generate_category_url_by_id($post->category_id); ?>">
                    <span class="category-label category-label-horizontal" style="background-color: <?php echo html_escape($post->category_color); ?>"><?php echo html_escape($post->category_name); ?></span>
                </a>
            <?php endif; ?>
            <?php if (check_post_img($post)): ?>
                <div class="col-sm-5 col-xs-12 item-image">
                    <div class="post-item-image">
                        <a href="<?php echo generate_post_url($post); ?>">
                            <?php $this->load->view("post/_post_image", ["post_item" => $post, "type" => "medium"]); ?>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
            <div class="col-sm-7 col-xs-12 item-content">
                <h3 class="title">
                    <a href="<?php echo generate_post_url($post); ?>">
                        <?php echo html_escape(character_limiter($post->title, 55, '...')); ?>
                    </a>
                </h3>
                <p class="small-post-meta">
                    <?php $this->load->view("post/_post_meta", ["post" => $post]); ?>
                </p>
                <p class="description">
                    <?php echo html_escape(character_limiter($post->summary, 130, '...')); ?>
                </p>
            </div>
        </div>
    </div>
</div>