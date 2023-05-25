<?php $subCategories = getSubcategories($category->id, $baseCategories); ?>
<div class="col-sm-12 col-xs-12">
    <div class="row">
        <section class="section section-block-1">
            <div class="section-head" style="border-bottom: 2px solid <?= esc($category->color); ?>;">
                <h4 class="title" style="background-color: <?= esc($category->color); ?>"><a href="<?= generateCategoryURL($category); ?>" style="color: <?= esc($category->color); ?>"><?= esc($category->name); ?></a></h4>
                <?= loadView('partials/_block_subcategories', ['category' => $category, 'subCategories' => $subCategories]); ?>
            </div>
            <div class="section-content">
                <div class="tab-content pull-left">
                    <div role="tabpanel" class="tab-pane fade in active" id="all-<?= $category->id; ?>">
                        <div class="row">
                            <?php $categoryPosts = getPostsByCategoryId($category->id, $baseCategories, $baseLatestCategoryPosts);
                            if (!empty($categoryPosts)):
                                $i = 0;
                                foreach ($categoryPosts as $post):
                                    if ($i < 2): ?>
                                        <div class="col-sm-6 col-xs-12">
                                            <?= loadView("post/_post_item", ["post" => $post]); ?>
                                        </div>
                                    <?php endif;
                                    $i++;
                                endforeach;
                            endif; ?>
                        </div>
                        <div class="row block-1-bottom">
                            <?php if (!empty($categoryPosts)):
                                $i = 0;
                                foreach ($categoryPosts as $post):
                                    if ($i > 1 && $i < 8):
                                        if ($i % 2 == 0): ?>
                                            <div class="col-sm-12 col-xs-12"></div>
                                        <?php endif; ?>
                                        <div class="col-sm-6 col-xs-12">
                                            <?= loadView("post/_post_item_small", ["post" => $post]); ?>
                                        </div>
                                    <?php endif;
                                    $i++;
                                endforeach;
                            endif; ?>
                        </div>
                    </div>
                    <?php if (!empty($subCategories)):
                        foreach ($subCategories as $subCategory): ?>
                            <div role="tabpanel" class="tab-pane fade in" id="<?= esc($subCategory->name_slug); ?>-<?= esc($subCategory->id); ?>">
                                <div class="row">
                                    <?php $categoryPosts = getPostsByCategoryId($subCategory->id, $baseCategories, $baseLatestCategoryPosts);
                                    if (!empty($categoryPosts)):
                                        $i = 0;
                                        foreach ($categoryPosts as $post):
                                            if ($i < 2): ?>
                                                <div class="col-sm-6 col-xs-12">
                                                    <?= loadView("post/_post_item", ["post" => $post]); ?>
                                                </div>
                                            <?php endif;
                                            $i++;
                                        endforeach;
                                    endif; ?>
                                </div>
                                <div class="row block-1-bottom">
                                    <?php if (!empty($categoryPosts)):
                                        $i = 0;
                                        foreach ($categoryPosts as $post):
                                            if ($i > 1 && $i < 8):
                                                if ($i % 2 == 0): ?>
                                                    <div class="col-sm-12 col-xs-12"></div>
                                                <?php endif; ?>
                                                <div class="col-sm-6 col-xs-12">
                                                    <?= loadView("post/_post_item_small", ["post" => $post]); ?>
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