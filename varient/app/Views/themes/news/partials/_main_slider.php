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
                                        <img src="<?= IMG_PATH_BG_MD; ?>" data-lazy="<?= getPostImage($item, 'slider'); ?>" alt="<?= esc($item->title); ?>" class="img-cover" width="600" height="460"/>
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
                <div class="row">
                    <?php $i = 0;
                    if (!empty($featuredPosts)):
                        foreach ($featuredPosts as $item):
                            if ($i < 2):?>
                                <div class="col-12 <?= $i == 0 ? ' col-first' : ''; ?>">
                                    <div class="item">
                                        <a href="<?= generatePostURL($item); ?>" class="img-link"<?php postURLNewTab($item); ?> aria-label="post">
                                            <div class="img-item lazyload" data-bg="<?= getPostImage($item, 'slider'); ?>"></div>
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
            <div class="col-md-12 col-lg-3 top-headlines">
                <div class="row">
                    <div class="col-12">
                        <h3 class="top-headlines-title"><?= trans("top_headlines"); ?></h3>
                    </div>
                    <div class="col-12">
                        <div class="items">
                            <?php $i = 0;
                            if (!empty($featuredPosts)):
                                foreach ($featuredPosts as $item):
                                    if ($i > 1): ?>
                                        <div class="item <?= $i == 2 ? ' item-first' : ''; ?>">
                                            <h3 class="title">
                                                <a href="<?= generatePostURL($item); ?>" <?php postURLNewTab($item); ?>>
                                                    <?= esc(characterLimiter($item->title, 80, '...')); ?>
                                                </a>
                                            </h3>
                                            <a href="<?= generateCategoryURLById($item->category_id, $baseCategories); ?>">
                                                <span class="category"><?= esc($item->category_name); ?></span>
                                            </a>
                                            <?php if ($generalSettings->show_post_date == 1): ?>
                                                <span class="date"><?= formatDateFront($item->created_at); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif;
                                    $i++;
                                endforeach;
                            endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>