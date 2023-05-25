<div id="main">
    <div class="container">
        <div class="row">
            <?php if ($page->breadcrumb_active == 1): ?>
                <div class="col-sm-12 page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= esc(trans("home")); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?= langBaseUrl($page->slug); ?>"><?= esc($page->title); ?></a></li>
                        <li class="breadcrumb-item active"><?= esc($album->name); ?></li>
                    </ol>
                </div>
            <?php else: ?>
                <div class="col-sm-12 page-breadcrumb"></div>
            <?php endif; ?>
            <div class="col-sm-12">
                <div class="content page-about page-gallery">
                    <?php if ($page->title_active == 1): ?>
                        <div class="row">
                            <div class="col-sm-12"><h1 class="page-title"><?= esc($page->title); ?></h1></div>
                        </div>
                    <?php endif; ?>
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
                    <div class="row row-masonry">
                        <div id="masonry" class="gallery">
                            <?php if (!empty($galleryImages)):
                                foreach ($galleryImages as $item):
                                    $imgBaseURL = getBaseURLByStorage($item->storage); ?>
                                    <div data-filter="category_<?= $item->category_id; ?>" class="col-lg-4 col-md-4 col-sm-6 col-xs-12 gallery-item">
                                        <div class="item-inner">
                                            <a class="image-popup lightbox" href="<?= $imgBaseURL . $item->path_big; ?>" data-effect="mfp-zoom-out" title="<?= esc($item->title); ?>">
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
    </div>
</div>