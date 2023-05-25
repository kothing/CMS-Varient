<?php $limit = 8;
$categoryWidgets = getCategoryWidgets($category->id, $baseWidgets, $adSpaces, $activeLang->id);
$mainClass = 'col-sm-12';
$subClass = 'col-sm-12 col-md-6 col-lg-3';
if ($categoryWidgets->hasWidgets) {
    $mainClass = 'col-sm-12 col-md-12 col-lg-8';
    $subClass = 'col-sm-12 col-md-6 col-lg-4';
    $limit = 9;
}
$subCategories = getSubcategories($category->id, $baseCategories); ?>
<div class="section section-category">
    <div class="container-xl">
        <div class="row">
            <div class="<?= $mainClass; ?>">
                <div class="section-title">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="title"><?= esc($category->name); ?></h3>
                        <?= loadView('partials/_block_subcategories', ['category' => $category, 'subCategories' => $subCategories]); ?>
                    </div>
                </div>
                <div class="section-content">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tabCategoryAll<?= esc($category->id); ?>" role="tabpanel">
                            <div class="row">
                                <?php $categoryPosts = getPostsByCategoryId($category->id, $baseCategories, $baseLatestCategoryPosts);
                                $i = 0;
                                if (!empty($categoryPosts)):
                                    foreach ($categoryPosts as $item):
                                        if ($i < $limit):?>
                                            <div class="<?= $subClass; ?>">
                                                <?= loadView("post/_post_item_mid", ['postItem' => $item, 'showLabel' => false]); ?>
                                            </div>
                                        <?php endif;
                                        $i++;
                                    endforeach;
                                endif; ?>
                            </div>
                        </div>
                        <?php if (!empty($subCategories)):
                            foreach ($subCategories as $subCategory): ?>
                                <div class="tab-pane fade" id="tabCategory<?= esc($subCategory->id); ?>" role="tabpanel">
                                    <div class="row">
                                        <?php $categoryPosts = getPostsByCategoryId($subCategory->id, $baseCategories, $baseLatestCategoryPosts);
                                        $i = 0;
                                        if (!empty($categoryPosts)):
                                            foreach ($categoryPosts as $item):
                                                if ($i < $limit):?>
                                                    <div class="<?= $subClass; ?>">
                                                        <?= loadView("post/_post_item_mid", ['postItem' => $item, 'showLabel' => false]); ?>
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
            <?php if ($categoryWidgets->hasWidgets):
                echo loadView('partials/_sidebar_category', ['objectWidgets' => $categoryWidgets]);
            endif; ?>
        </div>
    </div>
</div>