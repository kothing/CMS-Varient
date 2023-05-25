<section class="section section-page page-gallery">
    <div class="container-xl">
        <div class="row">
            <?php if ($page->breadcrumb_active == 1): ?>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?= langBaseUrl($page->slug); ?>"><?= esc($page->title); ?></a></li>
                        <li class="breadcrumb-item active"><?= esc($album->name); ?></li>
                    </ol>
                </nav>
            <?php endif;
            if ($page->title_active) : ?>
                <h1 class="page-title"><?= esc($page->title); ?></h1>
            <?php endif; ?>
            <div class="page-content font-text page-text">
                <div class="row">
                    <div class="col-sm-12 text-center"><h2 class="gallery-category-title"><?= esc($album->name); ?></h2></div>
                </div>
                <?php if (!empty($galleryCategories)): ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="filters text-center">
                                <label data-filter="" class="btn btn-primary active"><input type="radio" name="options"> <?= trans("all"); ?></label>
                                <?php foreach ($galleryCategories as $category): ?>
                                    <label data-filter="category_<?= $category->id; ?>" class="btn btn-primary">
                                        <input type="radio" name="options"> <?= esc($category->name); ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="row-masonry">
                    <div id="masonry" class="gallery">
                        <?php if (!empty($galleryImages)):
                            foreach ($galleryImages as $item):
                                $imgBaseURL = getBaseURLByStorage($item->storage); ?>
                                <div data-filter="category_<?= $item->category_id; ?>" class="col-12 col-sm-6 col-md-3 gallery-item">
                                    <div class="item-inner">
                                        <a href="<?= $imgBaseURL . $item->path_big; ?>" class="glightbox" data-glightbox="title: <?= esc($item->title); ?>;">
                                            <img src="<?= $imgBaseURL . esc($item->path_small); ?>" alt="<?= esc($item->title); ?>" class="img-responsive"/>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach;
                        endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>