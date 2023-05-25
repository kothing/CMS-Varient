<section class="section section-page page-gallery">
    <div class="container-xl">
        <div class="row">
            <?php if ($page->breadcrumb_active == 1): ?>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                        <li class="breadcrumb-item active"><?= esc($page->title); ?></li>
                    </ol>
                </nav>
            <?php endif;
            if ($page->title_active) : ?>
                <h1 class="page-title"><?= esc($page->title); ?></h1>
            <?php endif; ?>
            <div class="page-content font-text page-text">
                <div class="row-masonry">
                    <div id="masonry" class="gallery">
                        <div class="grid">
                            <?php if (!empty($galleryAlbums)):
                                foreach ($galleryAlbums as $item):
                                    $cover = getGalleryCoverImage($item->id); ?>
                                    <div class="col-12 col-sm-6 col-md-4 gallery-item">
                                        <div class="item-inner gallery-image-cover">
                                            <a href="<?= generateURL('gallery_album') . '/' . $item->id; ?>">
                                                <?php if (!empty($cover)):
                                                    $imgBaseURL = getBaseURLByStorage($cover->storage); ?>
                                                    <img src="<?= $imgBaseURL . esc($cover->path_small); ?>" alt="<?= esc($item->name); ?>" class="img-responsive"/>
                                                <?php else: ?>
                                                    <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="<?= esc($item->name); ?>" class="img-responsive img-gallery-empty"/>
                                                <?php endif; ?>
                                                <div class="caption">
                                                    <span class="album-name"><?= esc(characterLimiter($item->name, 100, '...')); ?></span>
                                                </div>
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
</section>