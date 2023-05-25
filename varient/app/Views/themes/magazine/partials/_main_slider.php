<section class="section section-featured">
    <div class="container-xl">
        <div class="row">
            <div class="col-md-12 col-lg-6 col-featured-left">
                <div class="main-slider-container">
                    <div class="main-slider" id="main-slider">
                        <?php $count = 0;
                        foreach ($sliderPosts as $item):
                            if ($count < 20):?>
                                <div class="main-slider-item">
                                    <a href="<?= generatePostURL($item); ?>" class="img-link"<?php postURLNewTab($item); ?> aria-label="post">
                                        <img src="<?= IMG_BASE64_1x1; ?>" data-lazy="<?= getPostImage($item, 'slider'); ?>" alt="<?= esc($item->title); ?>" class="img-cover" width="687" height="526"/>
                                        <?php getMediaIcon($item, 'media-icon-lg'); ?>
                                    </a>
                                    <div class="caption">
                                        <a href="<?= generateCategoryURLById($item->category_id, $baseCategories); ?>">
                                            <span class="badge badge-category" style="background-color: <?= esc($item->category_color); ?>"><?= esc($item->category_name); ?></span>
                                        </a>
                                        <?php if ($count < 2): ?>
                                            <h2 class="title"><?= esc(characterLimiter($item->title, 120, '...')); ?></h2>
                                        <?php else: ?>
                                            <h3 class="title"><?= esc(characterLimiter($item->title, 120, '...')); ?></h3>
                                        <?php endif; ?>
                                        <p class="post-meta">
                                            <?= loadView('post/_post_meta', ['postItem' => $item]); ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endif;
                            $count++;
                        endforeach; ?>
                    </div>
                    <div id="main-slider-nav" class="main-slider-nav">
                        <button class="prev" aria-label="prev">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 404.258 404.258">
                                <polygon points="289.927,18 265.927,0 114.331,202.129 265.927,404.258 289.927,386.258 151.831,202.129 "/>
                            </svg>
                        </button>
                        <button class="next" aria-label="next">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 404.258 404.258">
                                <polygon points="138.331,0 114.331,18 252.427,202.129 114.331,386.258 138.331,404.258 289.927,202.129 "/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6 col-featured-right">
                <div class="row gx-1 gy-1">
                    <?php if (!empty($featuredPosts)):
                        $item = null;
                        if (!empty($featuredPosts[0])) {
                            $item = $featuredPosts[0];
                        }
                        if (!empty($item)): ?>
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="item item-large">
                                    <a href="<?= generatePostURL($item); ?>" class="img-link"<?php postURLNewTab($item); ?> aria-label="post">
                                        <img src="<?= IMG_BASE64_1x1; ?>" data-src="<?= getPostImage($item, 'big'); ?>" alt="<?= esc($item->title); ?>" class="img-fluid lazyload" width="605" height="280"/>
                                        <?php getMediaIcon($item, 'media-icon'); ?>
                                    </a>
                                    <div class="caption">
                                        <a href="<?= generateCategoryURLById($item->category_id, $baseCategories); ?>">
                                            <span class="badge badge-category" style="background-color: <?= esc($item->category_color); ?>"><?= esc($item->category_name); ?></span>
                                        </a>
                                        <h3 class="title">
                                            <a href="<?= generatePostURL($item); ?>" class="img-link"<?php postURLNewTab($item); ?>>
                                                <?= esc(characterLimiter($item->title, 90, '...')); ?>
                                            </a>
                                        </h3>
                                        <p class="post-meta">
                                            <?= loadView("post/_post_meta", ['postItem' => $item]); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endif;
                        $i = 0;
                        foreach ($featuredPosts as $item):
                            if ($i > 0 && $i < 3):?>
                                <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="item item-small">
                                        <a href="<?= generatePostURL($item); ?>" class="img-link"<?php postURLNewTab($item); ?> aria-label="post">
                                            <img src="<?= IMG_BASE64_1x1; ?>" data-src="<?= getPostImage($item, 'slider'); ?>" alt="<?= esc($item->title); ?>" class="img-fluid lazyload" width="300" height="242"/>
                                            <?php getMediaIcon($item, 'media-icon'); ?>
                                        </a>
                                        <div class="caption">
                                            <a href="<?= generateCategoryURLById($item->category_id, $baseCategories); ?>">
                                                <span class="badge badge-category" style="background-color: <?= esc($item->category_color); ?>"><?= esc($item->category_name); ?></span>
                                            </a>
                                            <h3 class="title">
                                                <a href="<?= generatePostURL($item); ?>" class="img-link"<?php postURLNewTab($item); ?>>
                                                    <?= esc(characterLimiter($item->title, 54, '...')); ?>
                                                </a>
                                            </h3>
                                            <p class="post-meta">
                                                <?= loadView("post/_post_meta", ['postItem' => $item]); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif;
                            $i++;
                        endforeach;
                    endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>