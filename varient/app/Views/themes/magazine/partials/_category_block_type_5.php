<?php $limit = 15;
$categoryPosts = getPostsByCategoryId($category->id, $baseCategories, $baseLatestCategoryPosts); ?>
<section class="section section-cat-slider">
    <div class="container-xl">
        <div class="section-title">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="title"><?= esc($category->name); ?></h3>
                <div id="category_slider_nav_<?= $category->id; ?>" class="nav-sm-buttons">
                    <button class="prev" aria-label="prev"><i class="icon-arrow-left"></i></button>
                    <button class="next" aria-label="next"><i class="icon-arrow-right"></i></button>
                </div>
            </div>
        </div>
        <div class="section-content category-slider-container" <?= $rtl == true ? 'dir="rtl"' : ''; ?>>
            <div id="category_slider_<?= $category->id; ?>" class="row slider-row">
                <?php if (!empty($categoryPosts)):
                    $i = 0;
                    foreach ($categoryPosts as $item): ?>
                        <div class="col-lg-3 slider-col">
                            <div class="post-item">
                                <a href="<?= generateCategoryURLById($item->category_id, $baseCategories); ?>">
                                    <span class="badge badge-category" style="background-color: <?= esc($postItem->category_color); ?>"><?= esc($item->category_name); ?></span>
                                </a>
                                <?php if (checkPostImg($item)): ?>
                                    <div class="image ratio img-slider-ratio">
                                        <a href="<?= generatePostURL($item); ?>" class="img-link"<?php postURLNewTab($item); ?>>
                                            <img src="<?= IMG_BASE64_1x1; ?>" data-lazy="<?= getPostImage($item, 'slider'); ?>" alt="<?= esc($item->title); ?>" class="img-fluid" width="306" height="234"/>
                                            <?php getMediaIcon($item, 'media-icon'); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <h3 class="title">
                                    <a href="<?= generatePostURL($item); ?>" class="img-link"<?php postURLNewTab($item); ?>>
                                        <?= esc(characterLimiter($item->title, 64, '...')); ?>
                                    </a>
                                </h3>
                                <p class="small-post-meta">
                                    <?= loadView('post/_post_meta', ['postItem' => $item]); ?>
                                </p>
                            </div>
                        </div>
                        <?php $i++;
                    endforeach;
                endif; ?>
            </div>
        </div>
    </div>
</section>