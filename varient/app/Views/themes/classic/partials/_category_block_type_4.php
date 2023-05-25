<?php $subCategories = getSubcategories($category->id, $baseCategories); ?>
<div class="col-sm-12 col-xs-12">
    <div class="row">
        <section class="section section-block-4">
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
                                    if ($i < 3):?>
                                        <div class="col-sm-4">
                                            <?= loadView("post/_post_item_mid", ["post" => $post]); ?>
                                        </div>
                                    <?php endif;
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
                                            if ($i < 3):?>
                                                <div class="col-sm-4">
                                                    <?= loadView("post/_post_item_mid", ["post" => $post]); ?>
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