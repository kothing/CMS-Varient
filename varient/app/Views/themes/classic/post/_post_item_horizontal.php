<div class="col-sm-12 col-xs-12">
    <div class="row">
        <div class="post-item-horizontal<?= checkPostImg($post, 'class'); ?>">
            <?php if (isset($showLabel)): ?>
                <a href="<?= generateCategoryURLById($post->category_id, $baseCategories); ?>"><span class="category-label category-label-horizontal" style="background-color: <?= esc($post->category_color); ?>"><?= esc($post->category_name); ?></span></a>
            <?php endif;
            if (checkPostImg($post)): ?>
                <div class="col-sm-5 col-xs-12 item-image">
                    <div class="post-item-image">
                        <a href="<?= generatePostURL($post); ?>"<?php postURLNewTab($post); ?>><?= loadView("post/_post_image", ["postItem" => $post, "type" => "medium"]); ?></a>
                    </div>
                </div>
            <?php endif; ?>
            <div class="col-sm-7 col-xs-12 item-content">
                <h3 class="title"><a href="<?= generatePostURL($post); ?>"<?php postURLNewTab($post); ?>><?= esc(characterLimiter($post->title, 55, '...')); ?></a></h3>
                <p class="small-post-meta">
                    <?= loadView("post/_post_meta", ["post" => $post]); ?>
                </p>
                <p class="description"><?= esc(characterLimiter($post->summary, 130, '...')); ?></p>
            </div>
        </div>
    </div>
</div>