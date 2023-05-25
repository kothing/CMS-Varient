<section class="section section-page">
    <div class="container-xl">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                    <li class="breadcrumb-item active"><?= trans("rss_feeds"); ?></li>
                </ol>
            </nav>
            <h1 class="page-title"><?= trans("rss_feeds"); ?></h1>
            <div class="page-content font-text page-text">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <a href="<?= langBaseUrl('rss/latest-posts'); ?>" target="_blank"><i class="icon-rss"></i>&nbsp;&nbsp;<?= trans("latest_posts"); ?></a>
                    </div>
                    <div class="col-sm-12 col-md-9">
                        <p><?= langBaseUrl('rss/latest-posts'); ?></p>
                    </div>
                </div>
                <?php if (!empty($baseCategories)):
                    foreach ($baseCategories as $category):
                        if ($category->lang_id == $activeLang->id && $category->parent_id == 0): ?>
                            <div class="row">
                                <div class="col-sm-12 col-md-3">
                                    <a href="<?= langBaseUrl('rss/category/' . esc($category->name_slug)); ?>" target="_blank"><i class="icon-rss"></i>&nbsp;&nbsp;<?= esc($category->name); ?></a>
                                </div>
                                <div class="col-sm-12 col-md-9">
                                    <p><a href="<?= langBaseUrl('rss/category/' . esc($category->name_slug)); ?>" target="_blank"><?= langBaseUrl('rss/category/' . esc($category->name_slug)); ?></a></p>
                                </div>
                            </div>
                            <?php $subCategories = getSubcategories($category->id, $baseCategories);
                            if (!empty($subCategories)):
                                foreach ($subCategories as $subCategory):?>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-3">
                                            <a href="<?= langBaseUrl('rss/category/' . esc($subCategory->name_slug)); ?>" target="_blank"><i class="icon-rss"></i>&nbsp;&nbsp;<?= esc($subCategory->name); ?></a>
                                        </div>
                                        <div class="col-sm-12 col-md-9">
                                            <p><a href="<?= langBaseUrl('rss/category/' . esc($subCategory->name_slug)); ?>" target="_blank"><?= langBaseUrl('rss/category/' . esc($subCategory->name_slug)); ?></a></p>
                                        </div>
                                    </div>
                                <?php endforeach;
                            endif;
                        endif;
                    endforeach;
                endif; ?>
            </div>
        </div>
    </div>
</section>