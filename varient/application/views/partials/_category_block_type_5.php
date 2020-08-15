<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $subcategories = get_subcategories($category->id, $this->categories); ?>
<div class="col-sm-12 col-xs-12">
    <div class="row">
        <section class="section">
            <div class="section-head" style="border-bottom: 2px solid <?php echo html_escape($category->color); ?>;">
                <h4 class="title" style="background-color: <?php echo html_escape($category->color); ?>">
                    <a href="<?php echo generate_category_url($category); ?>" style="color: <?php echo html_escape($category->color); ?>">
                        <?php echo html_escape($category->name); ?>
                    </a>
                </h4>
                <!--Include subcategories-->
                <?php $this->load->view('partials/_block_subcategories', ['category' => $category, 'subcategories' => $subcategories]); ?>
            </div>
            <div class="section-content">
                <div class="tab-content pull-left">
                    <div role="tabpanel" class="tab-pane fade in active" id="all-<?php echo html_escape($category->id); ?>">
                        <div class="row">
                            <?php $category_posts = get_posts_by_category_id($category->id, $this->categories);
                            $i = 0;
                            if (!empty($category_posts)):
                                foreach ($category_posts as $post):
                                    if ($i < 4):
                                        if ($i < 1): ?>
                                            <div class="col-sm-12 col-xs-12">
                                                <div class="post-item-video-big<?php echo check_post_img($post, 'class'); ?>">
                                                    <?php if (check_post_img($post)): ?>
                                                        <div class="post-item-image">
                                                            <a href="<?php echo generate_post_url($post); ?>">
                                                                <?php $this->load->view("post/_post_image", ["post_item" => $post, "type" => "big"]); ?>
                                                                <div class="overlay"></div>
                                                            </a>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="caption caption-video-image">
                                                        <a href="<?php echo generate_category_url($category); ?>">
                                                            <span class="category-label" style="background-color: <?php echo html_escape($category->color); ?>"><?php echo html_escape($category->name); ?></span>
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
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="col-sm-4 col-xs-12">
                                                <?php $this->load->view("post/_post_item_mid", ["post" => $post]); ?>
                                            </div>
                                        <?php endif;
                                    endif;
                                    $i++;
                                endforeach;
                            endif; ?>
                        </div>
                    </div>

                    <?php if (!empty($subcategories)):
                        foreach ($subcategories as $subcategory): ?>
                            <div role="tabpanel" class="tab-pane fade in " id="<?php echo html_escape($subcategory->name_slug); ?>-<?php echo html_escape($subcategory->id); ?>">
                                <div class="row">
                                    <?php $category_posts = get_posts_by_category_id($subcategory->id, $this->categories);
                                    $i = 0;
                                    if (!empty($category_posts)):
                                        foreach ($category_posts as $post):
                                            if ($i < 4):
                                                if ($i < 1): ?>
                                                    <div class="col-sm-12 col-xs-12">
                                                        <div class="post-item-video-big<?php echo check_post_img($post, 'class'); ?>">
                                                            <?php if (check_post_img($post)): ?>
                                                                <div class="post-item-image">
                                                                    <a href="<?php echo generate_post_url($post); ?>">
                                                                        <?php $this->load->view("post/_post_image", ["post_item" => $post, "type" => "big"]); ?>
                                                                        <div class="overlay"></div>
                                                                    </a>
                                                                </div>
                                                            <?php endif; ?>
                                                            <div class="caption caption-video-image">
                                                                <a href="<?php echo generate_category_url($subcategory); ?>">
                                                                    <span class="category-label" style="background-color: <?php echo html_escape($category->color); ?>"><?php echo html_escape($subcategory->name); ?></span>
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
                                                        </div>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="col-sm-4 col-xs-12">
                                                        <?php $this->load->view("post/_post_item_mid", ["post" => $post]); ?>
                                                    </div>
                                                <?php endif;
                                            endif;
                                            $i++;
                                        endforeach;
                                    endif; ?>
                                </div>
                            </div>
                        <?php endforeach;
                    endif; ?>
                </div>
            </div>
        </section>
    </div>
</div>