<?php $categoryWidgets = getCategoryWidgets($category->id, $baseWidgets, $adSpaces, $activeLang->id);
$subCategories = getSubcategories($category->id, $baseCategories); ?>
<div class="section section-category">
    <div class="container-xl">
        <div class="row">
            <div class="col-sm-12 col-md-12<?= $categoryWidgets->hasWidgets ? ' col-lg-8' : ''; ?>">
                <div class="section-title">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="title"><?= esc($category->name); ?></h3>
                        <?= loadView('partials/_block_subcategories', ['category' => $category, 'subCategories' => $subCategories]); ?>
                    </div>
                </div>
                <div class="section-content section-block-2">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tabCategoryAll<?= esc($category->id); ?>" role="tabpanel">
                            <div class="row">
                                <?php $categoryPosts = getPostsByCategoryId($category->id, $baseCategories, $baseLatestCategoryPosts);
                                $i = 0;
                                $end = $categoryWidgets->hasWidgets ? 1 : 2;
                                if (!empty($categoryPosts)):
                                    foreach ($categoryPosts as $item):
                                        if ($i <= $end):?>
                                            <div class="col-sm-12 col-md-6<?= $categoryWidgets->hasWidgets ? ' col-lg-6' : ' col-lg-4'; ?>">
                                                <?= loadView("post/_post_item", ['postItem' => $item, 'showLabel' => false]); ?>
                                            </div>
                                        <?php endif;
                                        $i++;
                                    endforeach;
                                endif; ?>
                            </div>
                            <div class="row">
                                <?php $i = 0;
                                $start = $categoryWidgets->hasWidgets ? 1 : 2;
                                $end = $categoryWidgets->hasWidgets ? 7 : 11;
                                if (!empty($categoryPosts)):
                                    foreach ($categoryPosts as $item):
                                        if ($i > $start && $i <= $end):?>
                                            <div class="col-sm-12 col-md-6<?= $categoryWidgets->hasWidgets ? ' col-lg-6' : ' col-lg-4'; ?>">
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
                                        $end = $categoryWidgets->hasWidgets ? 1 : 2;
                                        if (!empty($categoryPosts)):
                                            foreach ($categoryPosts as $item):
                                                if ($i <= $end):?>
                                                    <div class="col-sm-12 col-md-6<?= $categoryWidgets->hasWidgets ? ' col-lg-6' : ' col-lg-4'; ?>">
                                                        <?= loadView("post/_post_item", ['postItem' => $item, 'showLabel' => false]); ?>
                                                    </div>
                                                <?php endif;
                                                $i++;
                                            endforeach;
                                        endif; ?>
                                    </div>
                                    <div class="row">
                                        <?php $i = 0;
                                        $start = $categoryWidgets->hasWidgets ? 1 : 2;
                                        $end = $categoryWidgets->hasWidgets ? 7 : 11;
                                        if (!empty($categoryPosts)):
                                            foreach ($categoryPosts as $item):
                                                if ($i > $start && $i <= $end):?>
                                                    <div class="col-sm-12 col-md-6<?= $categoryWidgets->hasWidgets ? ' col-lg-6' : ' col-lg-4'; ?>">
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
            <?php if ($categoryWidgets->hasWidgets):
                echo loadView('partials/_sidebar_category', ['objectWidgets' => $categoryWidgets]);
            endif; ?>
        </div>
    </div>
</div>