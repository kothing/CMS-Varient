<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!--Widget: Recommended Posts-->
<div class="sidebar-widget">
    <div class="widget-head">
        <h4 class="title"><?php echo html_escape($widget->title); ?></h4>
    </div>
    <div class="widget-body">
        <ul class="recommended-posts">
            <!--Print Picked Posts-->
            <?php $count = 0;
            $recommended_posts = get_recommended_posts();
            if (!empty($recommended_posts)):
                foreach ($recommended_posts as $post):
                    if ($count == 0): ?>
                        <?php if (check_post_img($post)): ?>
                            <li class="recommended-posts-first">
                                <div class="post-item-image">
                                    <a href="<?php echo generate_post_url($post); ?>">
                                        <?php $this->load->view("post/_post_image", ["post_item" => $post, "type" => "medium"]); ?>
                                        <div class="overlay"></div>
                                    </a>
                                </div>
                                <div class="caption">
                                    <a href="<?php echo generate_category_url_by_id($post->category_id); ?>">
                                        <span class="category-label" style="background-color: <?php echo html_escape($post->category_color); ?>"><?php echo html_escape($post->category_name); ?></span>
                                    </a>
                                    <h3 class="title">
                                        <a href="<?php echo generate_post_url($post); ?>">
                                            <?php echo html_escape(character_limiter($post->title, 55, '...')); ?>
                                        </a>
                                    </h3>
                                    <p class="small-post-meta">
                                        <?php $this->load->view("post/_post_meta", ["post" => $post]); ?>
                                    </p>
                                </div>
                            </li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li>
                            <?php $this->load->view("post/_post_item_small", ["post" => $post]); ?>
                        </li>
                    <?php endif;
                    $count++;
                endforeach;
            endif; ?>

        </ul>
    </div>
</div>