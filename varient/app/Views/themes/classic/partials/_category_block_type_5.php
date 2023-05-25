<?php $subCategories = getSubcategories($category->id, $baseCategories); ?>
<div class="col-sm-12 col-xs-12">
    <div class="row">
        <section class="section">
            <div class="section-head" style="border-bottom: 2px solid <?= esc($category->color); ?>;">
                <h4 class="title" style="background-color: <?= esc($category->color); ?>"><a href="<?= generateCategoryURL($category); ?>" style="color: <?= esc($category->color); ?>"><?= esc($category->name); ?></a></h4>
                <?= loadView('partials/_block_subcategories', ['category' => $category, 'subCategories' => $subCategories]); ?>
            </div>
            <div class="section-content">
                <div class="tab-content pull-left">
                    <div role="tabpanel" class="tab-pane fade in active" id="all-<?= esc($category->id); ?>">
                        <div class="row">
                            <?php $categoryPosts = getPostsByCategoryId($category->id, $baseCategories, $baseLatestCategoryPosts);
                            $i = 0;
                            if (!empty($categoryPosts)):
                                foreach ($categoryPosts as $post):
                                    if ($i < 4):
                                        if ($i < 1): ?>
                                            <div class="col-sm-12 col-xs-12">
                                                <div class="post-item-video-big<?= checkPostImg($post, 'class'); ?>">
                                                    <?php if (checkPostImg($post)): ?>
                                                        <div class="post-item-image">
                                                            <a href="<?= generatePostURL($post); ?>"<?php postURLNewTab($post); ?>>
                                                                <?= loadView("post/_post_image", ["postItem" => $post, "type" => "big"]); ?>
                                                                <div class="overlay"></div>
                                                            </a>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="caption caption-video-image">
                                                        <a href="<?= generateCategoryURL($category); ?>"><span class="category-label" style="background-color: <?= esc($category->color); ?>"><?= esc($category->name); ?></span></a>
                                                        <h3 class="title"><a href="<?= generatePostURL($post); ?>"<?php postURLNewTab($post); ?>><?= esc(characterLimiter($post->title, 55, '...')); ?></a></h3>
                                                        <p class="small-post-meta"><?= loadView("post/_post_meta", ["post" => $post]); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="col-sm-4 col-xs-12">
                                                <?= loadView("post/_post_item_mid", ["post" => $post]); ?>
                                            </div>
                                        <?php endif;
                                    endif;
                                    $i++;
                                endforeach;
                            endif; ?>
                        </div>
                    </div>
                    <?php if (!empty($subCategories)):
                        foreach ($subCategories as $subCategory): ?>
                            <div role="tabpanel" class="tab-pane fade in " id="<?= esc($subCategory->name_slug); ?>-<?= esc($subCategory->id); ?>">
                                <div class="row">
                                    <?php $categoryPosts = getPostsByCategoryId($subCategory->id, $baseCategories, $baseLatestCategoryPosts);
                                    $i = 0;
                                    if (!empty($categoryPosts)):
                                        foreach ($categoryPosts as $post):
                                            if ($i < 4):
                                                if ($i < 1): ?>
                                                    <div class="col-sm-12 col-xs-12">
                                                        <div class="post-item-video-big<?= checkPostImg($post, 'class'); ?>">
                                                            <?php if (checkPostImg($post)): ?>
                                                                <div class="post-item-image">
                                                                    <a href="<?= generatePostURL($post); ?>"<?php postURLNewTab($post); ?>>
                                                                        <?= loadView("post/_post_image", ["postItem" => $post, "type" => "big"]); ?>
                                                                        <div class="overlay"></div>
                                                                    </a>
                                                                </div>
                                                            <?php endif; ?>
                                                            <div class="caption caption-video-image">
                                                                <a href="<?= generateCategoryURL($subCategory); ?>"><span class="category-label" style="background-color: <?= esc($category->color); ?>"><?= esc($subCategory->name); ?></span></a>
                                                                <h3 class="title"><a href="<?= generatePostURL($post); ?>"<?php postURLNewTab($post); ?>><?= esc(characterLimiter($post->title, 55, '...')); ?></a></h3>
                                                                <p class="small-post-meta"><?= loadView("post/_post_meta", ["post" => $post]); ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="col-sm-4 col-xs-12">
                                                        <?= loadView("post/_post_item_mid", ["post" => $post]); ?>
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