<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!--Widget: Random Slider-->
<div class="sidebar-widget">
    <div class="widget-head">
        <h4 class="title"><?php echo html_escape($widget->title); ?></h4>
    </div>
    <div class="widget-body">
        <div class="random-slider-container">
            <div id="random-slider" class="random-slider">
                <!--Print Random Posts-->
                <?php if (!empty($this->random_posts)):
                    $i = 0;
                    foreach ($this->random_posts as $post):
                        if ($i < 10):?>
                            <!--Post row item-->
                            <div class="post-item<?php echo check_post_img($post, 'class'); ?>">
                                <a href="<?php echo generate_category_url_by_id($post->category_id); ?>">
                                    <span class="category-label category-label-random-slider" style="background-color: <?php echo html_escape($post->category_color); ?>"><?php echo html_escape($post->category_name); ?></span>
                                </a>
                                <?php if (check_post_img($post)): ?>
                                    <div class="post-item-image">
                                        <a href="<?php echo generate_post_url($post); ?>">
                                            <?php $this->load->view("post/_post_image", ["post_item" => $post, "type" => "random_slider"]); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <h3 class="title title-random-slider">
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
                        <?php endif;
                        $i++;
                    endforeach;
                endif; ?>
            </div>
            <div id="random-slider-nav" class="slider-nav random-slider-nav">
                <button class="prev"><i class="icon-arrow-left"></i></button>
                <button class="next"><i class="icon-arrow-right"></i></button>
            </div>
        </div>
    </div>
</div>