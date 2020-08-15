<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php $category = get_category($category_id, $this->categories);
if (!empty($category)):
    $category_posts = get_posts_by_category_id($category_id, $this->categories); ?>
    <li class="dropdown megamenu-fw mega-li-<?php echo $category->id; ?> <?php echo (uri_string() == html_escape($category->name_slug)) ? 'active' : ''; ?>">
        <a href="<?php echo generate_category_url($category); ?>" class="dropdown-toggle disabled" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo html_escape($category->name); ?>
            <span class="caret"></span>
        </a>
        <!--Check if has posts-->
        <?php if (!empty($category_posts)): ?>
            <ul class="dropdown-menu megamenu-content dropdown-top" role="menu" data-mega-ul="<?php echo $category->id; ?>">
                <li>
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="sub-menu-right single-sub-menu">
                                <div class="row row-menu-right">
                                    <?php $count = 0;
                                    foreach ($category_posts as $post):
                                        if ($count < 5):?>
                                            <div class="col-sm-3 menu-post-item">
                                                <?php if (check_post_img($post)): ?>
                                                    <div class="post-item-image">
                                                        <a href="<?php echo generate_post_url($post); ?>">
                                                            <?php $this->load->view("post/_post_image", ["post_item" => $post, "type" => "medium"]); ?>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                                <h3 class="title">
                                                    <a href="<?php echo generate_post_url($post); ?>">
                                                        <?php echo html_escape(character_limiter($post->title, 45, '...')); ?>
                                                    </a>
                                                </h3>
                                                <p class="post-meta">
                                                    <?php $this->load->view("post/_post_meta", ["post" => $post]); ?>
                                                </p>
                                            </div>
                                        <?php endif;
                                        $count++;
                                    endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        <?php endif; ?>
    </li>
<?php endif; ?>


