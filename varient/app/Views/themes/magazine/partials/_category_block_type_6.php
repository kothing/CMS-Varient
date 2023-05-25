<section class="section section-videos">
    <div class="container-xl">
        <div class="section-title">
            <h3 class="title"><?= esc($category->name); ?></h3>
        </div>
        <div class="row gx-1 gy-1">
            <?php $categoryPosts = getPostsByCategoryId($category->id, $baseCategories, $baseLatestCategoryPosts);
            if (!empty($categoryPosts)):
                $i = 0;
                foreach ($categoryPosts as $postItem):
                    if ($i <= 1): ?>
                        <div class="col-sm-12 col-md-6 col-lg-4 video-large">
                            <div class="image">
                                <a href="<?= generatePostURL($postItem); ?>"<?php postURLNewTab($postItem); ?>>
                                    <img src="<?= IMG_BASE64_600x460; ?>" alt="bg" class="img-fluid img-bg" width="430" height="515"/>
                                    <div class="img-container">
                                        <img src="<?= IMG_BASE64_600x460; ?>" data-src="<?= getPostImage($postItem, 'slider'); ?>" alt="<?= esc($postItem->title); ?>" class="lazyload img-fluid" width="430" height="515"/>
                                    </div>
                                    <?php getMediaIcon($postItem, 'media-icon'); ?>
                                </a>
                            </div>
                            <div class="caption">
                                <a href="<?= generateCategoryURLById($postItem->category_id, $baseCategories); ?>">
                                    <span class="badge badge-category" style="background-color: <?= esc($postItem->category_color); ?>"><?= esc($postItem->category_name); ?></span>
                                </a>
                                <h3 class="title">
                                    <a href="<?= generatePostURL($postItem); ?>" class="img-link"<?php postURLNewTab($postItem); ?>>
                                        <?= esc(characterLimiter($postItem->title, 60, '...')); ?>
                                    </a>
                                </h3>
                                <p class="post-meta">
                                    <?= loadView("post/_post_meta", ['postItem' => $postItem]); ?>
                                </p>
                            </div>
                        </div>
                    <?php endif;
                    $i++;
                endforeach;
            endif; ?>
            <div class="col-md-12 col-lg-4">
                <div class="row gx-1 gy-1">
                    <?php $categoryPosts = getPostsByCategoryId($category->id, $baseCategories, $baseLatestCategoryPosts);
                    if (!empty($categoryPosts)):
                        $i = 0;
                        foreach ($categoryPosts as $postItem):
                            if ($i > 1 && $i <= 3):?>
                                <div class="col-sm-12 col-md-6 col-lg-12 video-small">
                                    <div class="image">
                                        <a href="<?= generatePostURL($postItem); ?>"<?php postURLNewTab($postItem); ?>>
                                            <img src="<?= IMG_BASE64_450x280; ?>" alt="bg" class="img-fluid img-bg" width="430" height="255"/>
                                            <div class="img-container">
                                                <img src="<?= IMG_BASE64_450x280; ?>" data-src="<?= getPostImage($postItem, 'mid'); ?>" alt="<?= esc($postItem->title); ?>" class="lazyload img-fluid" width="430" height="255"/>
                                            </div>
                                            <?php getMediaIcon($postItem, 'media-icon'); ?>
                                        </a>
                                    </div>
                                    <div class="caption">
                                        <a href="<?= generateCategoryURLById($postItem->category_id, $baseCategories); ?>">
                                            <span class="badge badge-category" style="background-color: <?= esc($postItem->category_color); ?>"><?= esc($postItem->category_name); ?></span>
                                        </a>
                                        <h3 class="title">
                                            <a href="<?= generatePostURL($postItem); ?>" class="img-link"<?php postURLNewTab($postItem); ?>>
                                                <?= esc(characterLimiter($postItem->title, 60, '...')); ?>
                                            </a>
                                        </h3>
                                        <p class="post-meta">
                                            <?= loadView('post/_post_meta', ['postItem' => $postItem]); ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endif;
                            $i++;
                        endforeach;
                    endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>