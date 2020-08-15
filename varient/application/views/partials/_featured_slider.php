<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!--Featured Slider-->
<div class="slider-container">
    <div class="featured-slider" id="featured-slider">
        <?php
        $count = 0;
        foreach ($slider_posts as $post):
            if ($count < 20):?>
                <div class="featured-slider-item">
                    <a href="<?php echo generate_category_url_by_id($post->category_id); ?>">
                        <span class="category-label" style="background-color: <?php echo html_escape($post->category_color); ?>"><?php echo html_escape($post->category_name); ?></span>
                    </a>
                    <a href="<?php echo generate_post_url($post); ?>" class="img-link">
                        <?php $this->load->view("post/_post_image", ["post_item" => $post, "type" => "featured_slider"]); ?>
                    </a>
                    <div class="caption">
                        <h2 class="title">
                            <?php echo html_escape(character_limiter($post->title, 120, '...')); ?>
                        </h2>
                        <p class="post-meta">
                            <?php $this->load->view("post/_post_meta", ["post" => $post]); ?>
                        </p>
                    </div>
                </div>
            <?php endif;
            $count++;
        endforeach; ?>
    </div>
    <div id="featured-slider-nav" class="featured-slider-nav">
        <button class="prev"><i class="icon-arrow-slider-left"></i></button>
        <button class="next"><i class="icon-arrow-slider-right"></i></button>
    </div>
</div>
