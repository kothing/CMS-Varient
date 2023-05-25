<section class="section section-page">
    <div class="container-xl">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                    <?php $categories = getParentCategoryTree($category->id, $baseCategories);
                    $i = 0;
                    if (!empty($categories)):
                        foreach ($categories as $item):
                            if ($i == 0 && count($categories) > 1): ?>
                                <li class="breadcrumb-item active"><a href="<?= generateCategoryURL($item); ?>"><?= esc($item->name); ?></a></li>
                            <?php else: ?>
                                <li class="breadcrumb-item"><span><?= esc($item->name); ?></span></li>
                            <?php endif;
                            $i++;
                        endforeach;
                    endif; ?>
                </ol>
            </nav>
            <h1 class="page-title"><?= esc($category->name); ?></h1>
            <div class="col-sm-12 col-md-12 col-lg-8">
                <div class="row">
                    <?php $i = 0;
                    if (!empty($posts)):
                        foreach ($posts as $item):
                            if ($i == 2):
                                echo loadView('partials/_ad_spaces', ['adSpace' => 'posts_top', 'class' => 'mb-4']);
                            endif; ?>
                            <div class="col-sm-12 col-md-6">
                                <?= loadView("post/_post_item", ['postItem' => $item, 'showLabel' => false]); ?>
                            </div>
                            <?php $i++;
                        endforeach;
                    endif;
                    echo loadView('partials/_ad_spaces', ['adSpace' => 'posts_bottom', 'class' => '']);?>
                    <div class="col-12 mt-5">
                        <?= view('common/_pagination'); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-4">
                <?= loadView('partials/_sidebar'); ?>
            </div>
        </div>
    </div>
</section>