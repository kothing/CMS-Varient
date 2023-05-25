<?php $subCategories = getSubcategories($category->id, $baseCategories); ?>
<div class="section section-category">
    <div class="container-xl">
        <div class="section-title">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="title"><?= esc($category->name); ?></h3>
                <?= loadView('partials/_block_subcategories', ['category' => $category, 'subCategories' => $subCategories]); ?>
            </div>
        </div>
        <div class="section-content section-cat-block">
            <div class="tab-content">
                <div class="tab-pane fade show active" id="tabCategoryAll<?= esc($category->id); ?>" role="tabpanel">
                    <div class="row">
                        <?php $categoryPosts = getPostsByCategoryId($category->id, $baseCategories, $baseLatestCategoryPosts);
                        $i = 0;
                        if (!empty($categoryPosts)):
                            foreach ($categoryPosts as $item):
                                if ($i <= 3):?>
                                    <div class="col-sm-12 col-md-6 col-lg-3 col-post-item-vr">
                                        <div class="post-item post-item-vr">
                                            <div class="image">
                                                <?php if (checkPostImg($item)): ?>
                                                    <a href="<?= generatePostURL($item); ?>" class="img-link"<?php postURLNewTab($item); ?>>
                                                        <img src="<?= IMG_BASE64_1x1; ?>" data-src="<?= getPostImage($item, 'slider'); ?>" alt="<?= esc($item->title); ?>" class="img-fluid lazyload" width="306" height="340"/>
                                                        <?php getMediaIcon($item, 'media-icon'); ?>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                            <div class="caption">
                                                <h3 class="title">
                                                    <a href="<?= generatePostURL($item); ?>" class="img-link"<?php postURLNewTab($item); ?> style="display: block; color: #fff;">
                                                        <?= esc(characterLimiter($item->title, 50, '...')); ?>
                                                    </a>
                                                </h3>
                                                <p class="post-meta m0">
                                                    <?= loadView('post/_post_meta', ['postItem' => $item]); ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif;
                                $i++;
                            endforeach;
                        endif; ?>
                    </div>
                    <div class="row">
                        <?php $i = 0;
                        if (!empty($categoryPosts)):
                            foreach ($categoryPosts as $item):
                                if ($i > 3 && $i < 13):?>
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <?= loadView('post/_post_item_small', ['postItem' => $item, 'showLabel' => false]); ?>
                                    </div>
                                <?php endif;
                                $i++;
                            endforeach;
                        endif; ?>
                    </div>
                </div>
                <?php if (!empty($subCategories)):
                    foreach ($subCategories as $subCategory):
                        $categoryPosts = getPostsByCategoryId($subCategory->id, $baseCategories, $baseLatestCategoryPosts); ?>
                        <div class="tab-pane fade" id="tabCategory<?= esc($subCategory->id); ?>" role="tabpanel">
                            <div class="row">
                                <?php $i = 0;
                                if (!empty($categoryPosts)):
                                    foreach ($categoryPosts as $item):
                                        if ($i <= 3):?>
                                            <div class="col-sm-12 col-md-6 col-lg-3 col-post-item-vr">
                                                <div class="post-item post-item-vr">
                                                    <?php if (checkPostImg($item)): ?>
                                                        <div class="image">
                                                            <a href="<?= generatePostURL($item); ?>" class="img-link"<?php postURLNewTab($item); ?>>
                                                                <img src="<?= IMG_BASE64_1x1; ?>" data-src="<?= getPostImage($item, 'slider'); ?>" alt="<?= esc($item->title); ?>" class="img-fluid lazyload" width="306" height="340"/>
                                                                <?php getMediaIcon($item, 'media-icon'); ?>
                                                            </a>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="caption">
                                                        <h3 class="title">
                                                            <a href="<?= generatePostURL($item); ?>" class="img-link"<?php postURLNewTab($item); ?> style="display: block; color: #fff;">
                                                                <?= esc(characterLimiter($item->title, 50, '...')); ?>
                                                            </a>
                                                        </h3>
                                                        <p class="post-meta m0">
                                                            <?= loadView('post/_post_meta', ['postItem' => $item]); ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif;
                                        $i++;
                                    endforeach;
                                endif; ?>
                            </div>
                            <div class="row">
                                <?php $i = 0;
                                if (!empty($categoryPosts)):
                                    foreach ($categoryPosts as $item):
                                        if ($i > 3 && $i < 13):?>
                                            <div class="col-sm-12 col-md-6 col-lg-4">
                                                <?= loadView('post/_post_item_small', ['postItem' => $item, 'showLabel' => false]); ?>
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
    </div>
</div>