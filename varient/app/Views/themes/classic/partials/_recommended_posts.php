<div class="sidebar-widget">
    <div class="widget-head"><h4 class="title"><?= esc($widget->title); ?></h4></div>
    <div class="widget-body">
        <ul class="recommended-posts">
            <?php $count = 0;
            $recommendedPosts = getRecommendedPosts();
            if (!empty($recommendedPosts)):
                foreach ($recommendedPosts as $post):
                    if ($count == 0): ?>
                        <?php if (checkPostImg($post)): ?>
                            <li class="recommended-posts-first">
                                <div class="post-item-image">
                                    <a href="<?= generatePostURL($post); ?>"<?php postURLNewTab($post); ?>>
                                        <?= loadView("post/_post_image", ["postItem" => $post, "type" => "medium"]); ?>
                                        <div class="overlay"></div>
                                    </a>
                                </div>
                                <div class="caption">
                                    <a href="<?= generateCategoryURLById($post->category_id, $baseCategories); ?>"><span class="category-label" style="background-color: <?= esc($post->category_color); ?>"><?= esc($post->category_name); ?></span></a>
                                    <h3 class="title"><a href="<?= generatePostURL($post); ?>"<?php postURLNewTab($post); ?>><?= esc(characterLimiter($post->title, 55, '...')); ?></a></h3>
                                    <p class="small-post-meta">
                                        <?= loadView("post/_post_meta", ["post" => $post]); ?>
                                    </p>
                                </div>
                            </li>
                        <?php endif;
                    else: ?>
                        <li>
                            <?= loadView("post/_post_item_small", ["post" => $post]); ?>
                        </li>
                    <?php endif;
                    $count++;
                endforeach;
            endif; ?>
        </ul>
    </div>
</div>