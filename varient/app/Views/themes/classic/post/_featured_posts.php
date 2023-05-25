<div class="col-sm-12 section-featured">
    <div class="row">
        <div class="container">
            <div id="featured">
                <div class="featured-left">
                    <?php if (!empty($sliderPosts)): ?>
                        <div class="slider-container" <?= $rtl == true ? 'dir="rtl"' : ''; ?>>
                            <div class="featured-slider" id="featured-slider">
                                <?php $count = 0;
                                foreach ($sliderPosts as $post):
                                    if ($count < 20):?>
                                        <div class="featured-slider-item">
                                            <a href="<?= generateCategoryURLById($post->category_id, $baseCategories); ?>">
                                                <span class="category-label" style="background-color: <?= esc($post->category_color); ?>"><?= esc($post->category_name); ?></span>
                                            </a>
                                            <a href="<?= generatePostURL($post); ?>" class="img-link"<?php postURLNewTab($post); ?>>
                                                <?= loadView("post/_post_image", ['postItem' => $post, 'type' => 'featured_slider']); ?>
                                            </a>
                                            <div class="caption">
                                                <h2 class="title">
                                                    <?= esc(characterLimiter($post->title, 120, '...')); ?>
                                                </h2>
                                                <p class="post-meta">
                                                    <?= loadView("post/_post_meta", ["post" => $post]); ?>
                                                </p>
                                            </div>
                                        </div>
                                    <?php endif;
                                    $count++;
                                endforeach; ?>
                            </div>
                            <div id="featured-slider-nav" class="featured-slider-nav">
                                <button class="prev">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                                    </svg>
                                </button>
                                <button class="next">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    <?php else: ?>
                        <img src="<?= IMG_BASE64_600x460; ?>" alt="bg" class="img-responsive img-bg noselect img-no-slider" style="pointer-events: none"/>
                    <?php endif; ?>
                </div>
                <div class="featured-right">
                    <div class="featured-boxes-top">
                        <?php $count = 1;
                        if (!empty($featuredPosts)):
                            foreach ($featuredPosts as $item):
                                if ($count <= 2): ?>
                                    <div class="featured-box box-<?= $count; ?>">
                                        <div class="box-inner">
                                            <a href="<?= generateCategoryURLById($item->category_id, $baseCategories); ?>"><span class="category-label" style="background-color: <?= esc($item->category_color); ?>"><?= esc($item->category_name); ?></span></a>
                                            <a href="<?= generatePostURL($item); ?>"<?php postURLNewTab($item); ?>>
                                                <?= loadView("post/_post_image", ["postItem" => $item, "type" => "featured"]); ?>
                                                <div class="overlay"></div>
                                            </a>
                                            <div class="caption">
                                                <h3 class="title"><?= esc(characterLimiter($item->title, 50, '...')); ?></h3>
                                                <p class="post-meta"><?= loadView("post/_post_meta", ["post" => $item]); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif;
                                $count++;
                            endforeach;
                        endif; ?>
                    </div>
                    <div class="featured-boxes-bottom">
                        <?php $count = 1;
                        if (!empty($featuredPosts)):
                            foreach ($featuredPosts as $item):
                                if ($count > 2 && $count <= 4): ?>
                                    <div class="featured-box box-<?= $count; ?>">
                                        <div class="box-inner">
                                            <a href="<?= generateCategoryURLById($item->category_id, $baseCategories); ?>"><span class="category-label" style="background-color: <?= esc($item->category_color); ?>"><?= esc($item->category_name); ?></span></a>
                                            <a href="<?= generatePostURL($item); ?>"<?php postURLNewTab($item); ?>>
                                                <?= loadView("post/_post_image", ["postItem" => $item, "type" => "featured"]); ?>
                                                <div class="overlay"></div>
                                            </a>
                                            <div class="caption">
                                                <h3 class="title"><?= esc(characterLimiter($item->title, 50, '...')); ?></h3>
                                                <p class="post-meta"><?= loadView("post/_post_meta", ["post" => $item]); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif;
                                $count++;
                            endforeach;
                        endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>