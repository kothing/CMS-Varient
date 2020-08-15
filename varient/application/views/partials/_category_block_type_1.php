<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $subcategories = get_subcategories($category->id, $this->categories); ?>
<div class="col-sm-12 col-xs-12">
    <div class="row">
        <section class="section section-block-1">
            <div class="section-head" style="border-bottom: 2px solid <?php echo html_escape($category->color); ?>;">
                <h4 class="title" style="background-color: <?php echo html_escape($category->color); ?>">
                    <a href="<?php echo generate_category_url($category); ?>" style="color: <?php echo html_escape($category->color); ?>">
                        <?php echo html_escape($category->name); ?>
                    </a>
                </h4>
                <!--Include subcategories-->
                <?php $this->load->view('partials/_block_subcategories', ['category' => $category, 'subcategories' => $subcategories]); ?>
            </div><!--End section head-->
            <div class="section-content">
                <div class="tab-content pull-left">
                    <div role="tabpanel" class="tab-pane fade in active" id="all-<?php echo $category->id; ?>">
                        <div class="row">
                            <?php $category_posts = get_posts_by_category_id($category->id, $this->categories);
                            if (!empty($category_posts)):
                                $i = 0;
                                foreach ($category_posts as $post):
                                    if ($i < 2): ?>
                                        <div class="col-sm-6 col-xs-12">
                                            <?php $this->load->view("post/_post_item", ["post" => $post]); ?>
                                        </div>
                                    <?php endif;
                                    $i++;
                                endforeach;
                            endif; ?>
                        </div>

                        <div class="row block-1-bottom">
                            <?php if (!empty($category_posts)):
                                $i = 0;
                                foreach ($category_posts as $post):
                                    if ($i > 1 && $i < 8):
                                        if ($i % 2 == 0): ?>
                                            <div class="col-sm-12 col-xs-12"></div>
                                        <?php endif; ?>
                                        <div class="col-sm-6 col-xs-12">
                                            <?php $this->load->view("post/_post_item_small", ["post" => $post]); ?>
                                        </div>
                                    <?php endif;
                                    $i++;
                                endforeach;
                            endif; ?>
                        </div>
                    </div>

                    <?php if (!empty($subcategories)):
                        foreach ($subcategories as $subcategory): ?>
                            <div role="tabpanel" class="tab-pane fade in" id="<?php echo html_escape($subcategory->name_slug); ?>-<?php echo html_escape($subcategory->id); ?>">
                                <div class="row">
                                    <?php $category_posts = get_posts_by_category_id($subcategory->id, $this->categories);
                                    if (!empty($category_posts)):
                                        $i = 0;
                                        foreach ($category_posts as $post):
                                            if ($i < 2): ?>
                                                <div class="col-sm-6 col-xs-12">
                                                    <?php $this->load->view("post/_post_item", ["post" => $post]); ?>
                                                </div>
                                            <?php endif;
                                            $i++;
                                        endforeach;
                                    endif; ?>
                                </div>
                                <div class="row block-1-bottom">
                                    <?php if (!empty($category_posts)):
                                        $i = 0;
                                        foreach ($category_posts as $post):
                                            if ($i > 1 && $i < 8):
                                                if ($i % 2 == 0): ?>
                                                    <div class="col-sm-12 col-xs-12"></div>
                                                <?php endif; ?>
                                                <div class="col-sm-6 col-xs-12">
                                                    <?php $this->load->view("post/_post_item_small", ["post" => $post]); ?>
                                                </div>
                                            <?php endif;
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