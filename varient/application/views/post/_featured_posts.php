<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-sm-12 section-featured">
    <div class="row">
        <div class="container">
            <div id="featured">
                <div class="featured-left">
                    <!--Include Featured Slider-->
                    <?php if (!empty($slider_posts)): ?>
                        <?php $this->load->view('partials/_featured_slider'); ?>
                    <?php else: ?>
                        <img src="<?php echo base_url().IMG_PATH_BG_SL; ?>" alt="bg" class="img-responsive img-bg noselect img-no-slider" style="pointer-events: none"/>
                    <?php endif; ?>
                </div>
                <div class="featured-right">
                    <div class="featured-boxes-top">
                        <?php $count = 1;
                        foreach ($featured_posts as $item):
                            if ($count <= 2): ?>
                                <div class="featured-box box-<?php echo $count; ?>">
                                    <div class="box-inner">
                                        <a href="<?php echo generate_category_url_by_id($item->category_id); ?>">
                                            <span class="category-label" style="background-color: <?php echo html_escape($item->category_color); ?>"><?php echo html_escape($item->category_name); ?></span>
                                        </a>
                                        <a href="<?php echo generate_post_url($item); ?>">
                                            <?php $this->load->view("post/_post_image", ["post_item" => $item, "type" => "featured"]); ?>
                                            <div class="overlay"></div>
                                        </a>
                                        <div class="caption">
                                            <h3 class="title">
                                                <?php echo html_escape(character_limiter($item->title, 50, '...')); ?>
                                            </h3>
                                            <p class="post-meta">
                                                <?php $this->load->view("post/_post_meta", ["post" => $item]); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif;
                            $count++;
                        endforeach; ?>
                    </div>
                    <div class="featured-boxes-bottom">
                        <?php $count = 1;
                        foreach ($featured_posts as $item):
                            if ($count > 2 && $count <= 4): ?>
                                <div class="featured-box box-<?php echo $count; ?>">
                                    <div class="box-inner">
                                        <a href="<?php echo generate_category_url_by_id($item->category_id); ?>">
                                            <span class="category-label" style="background-color: <?php echo html_escape($item->category_color); ?>"><?php echo html_escape($item->category_name); ?></span>
                                        </a>
                                        <a href="<?php echo generate_post_url($item); ?>">
                                            <?php $this->load->view("post/_post_image", ["post_item" => $item, "type" => "featured"]); ?>
                                            <div class="overlay"></div>
                                        </a>
                                        <div class="caption">
                                            <h3 class="title">
                                                <?php echo html_escape(character_limiter($item->title, 50, '...')); ?>
                                            </h3>
                                            <p class="post-meta">
                                                <?php $this->load->view("post/_post_meta", ["post" => $item]); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif;
                            $count++;
                        endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>