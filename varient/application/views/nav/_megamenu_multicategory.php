<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $category = get_category($category_id, $this->categories);
if (!empty($category)):
    $category_posts = get_posts_by_category_id($category_id, $this->categories); ?>
    <li class="dropdown megamenu-fw mega-li-<?php echo $category->id; ?> <?php echo (uri_string() == html_escape($category->name_slug)) ? 'active' : ''; ?>">
        <a href="<?php echo generate_category_url($category); ?>" class="dropdown-toggle disabled" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo html_escape($category->name); ?> <span class="caret"></span></a>
        <!--Check if has posts-->
        <?php if (!empty($category_posts) && count($category_posts) > 0): ?>
            <ul class="dropdown-menu megamenu-content dropdown-top" role="menu" aria-expanded="true" data-mega-ul="<?php echo $category->id; ?>">
                <li>
                    <div class="sub-menu-left">
                        <ul class="nav-sub-categories">
                            <li data-category-filter="all" class="li-sub-category active">
                                <a href="<?php echo generate_category_url($category); ?>">
                                    <?php echo trans("all"); ?>
                                </a>
                            </li>
                            <?php $subcategories = get_subcategories($category->id, $this->categories);
                            if (!empty($subcategories)):
                                foreach ($subcategories as $subcategory):
                                    if ($subcategory->show_on_menu == 1):?>
                                        <li data-category-filter="<?php echo html_escape($subcategory->name_slug); ?>-<?php echo html_escape($subcategory->id); ?>" class="li-sub-category">
                                            <a href="<?php echo generate_category_url($subcategory); ?>">
                                                <?php echo html_escape($subcategory->name); ?>
                                            </a>
                                        </li>
                                    <?php endif;
                                endforeach;
                            endif; ?>
                        </ul>
                    </div>

                    <div class="sub-menu-right">
                        <div class="sub-menu-inner filter-all active">
                            <div class="row row-menu-right">
                                <!--Posts-->
                                <?php $i = 0;
                                if (!empty($category_posts)):
                                    foreach ($category_posts as $post):
                                        if ($i < 4): ?>
                                            <div class="col-sm-3 menu-post-item">
                                                <?php if (check_post_img($post)): ?>
                                                    <div class="post-item-image">
                                                        <a href="<?php echo generate_post_url($post); ?>">
                                                            <?php $this->load->view("post/_post_image", ["post_item" => $post, "type" => "medium"]); ?>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                                <h3 class="title">
                                                    <a href="<?php echo generate_post_url($post); ?>"><?php echo html_escape(character_limiter($post->title, 45, '...')); ?></a>
                                                </h3>
                                                <p class="post-meta">
                                                    <?php $this->load->view("post/_post_meta", ["post" => $post]); ?>
                                                </p>
                                            </div>
                                        <?php endif;
                                        $i++;
                                    endforeach;
                                endif; ?>
                            </div>
                        </div>


                        <?php if (!empty($subcategories)):
                            foreach ($subcategories as $subcategory):
                                if ($subcategory->show_on_menu == 1):?>
                                    <div class="sub-menu-inner filter-<?php echo html_escape($subcategory->name_slug); ?>-<?php echo $subcategory->id; ?>">
                                        <div class="row row-menu-right">
                                            <?php $category_posts = get_posts_by_category_id($subcategory->id, $this->categories);
                                            if (!empty($category_posts)):
                                                $i = 0;
                                                foreach ($category_posts as $post): ?>
                                                    <?php if ($i < 4): ?>
                                                        <div class="col-sm-3 menu-post-item">
                                                            <?php if (check_post_img($post)): ?>
                                                                <div class="post-item-image post-item-image-mn">
                                                                    <a href="<?php echo generate_post_url($post); ?>">
                                                                        <?php $this->load->view("post/_post_image", ["post_item" => $post, "type" => "medium"]); ?>
                                                                    </a>
                                                                </div>
                                                            <?php endif; ?>
                                                            <h3 class="title">
                                                                <a href="<?php echo generate_post_url($post); ?>"><?php echo html_escape(character_limiter($post->title, 45, '...')); ?></a>
                                                            </h3>
                                                            <p class="post-meta">
                                                                <?php $this->load->view("post/_post_meta", ["post" => $post]); ?>
                                                            </p>
                                                        </div>
                                                    <?php endif;
                                                    $i++;
                                                endforeach;
                                            endif; ?>
                                        </div>
                                    </div>
                                <?php endif;
                            endforeach;
                        endif; ?>


                    </div>
                </li>
            </ul>
        <?php endif; ?>
    </li>
<?php endif; ?>