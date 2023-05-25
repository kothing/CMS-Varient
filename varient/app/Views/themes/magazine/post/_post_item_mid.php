<div class="post-item<?= checkPostImg($postItem, 'class'); ?> post-item-mid">
    <?php if (!empty($showLabel)): ?>
        <a href="<?= generateCategoryURLById($postItem->category_id, $baseCategories); ?>">
            <span class="badge badge-category" style="background-color: <?= esc($postItem->category_color); ?>"><?= esc($postItem->category_name); ?></span>
        </a>
    <?php endif;
    if (checkPostImg($postItem)): ?>
        <div class="image ratio">
            <a href="<?= generatePostURL($postItem); ?>"<?php postURLNewTab($postItem); ?>>
                <img src="<?= IMG_BASE64_450x280; ?>" data-src="<?= getPostImage($postItem, 'mid'); ?>" alt="<?= esc($postItem->title); ?>" class="img-fluid lazyload" width="306" height="182"/>
                <?php getMediaIcon($postItem, 'media-icon'); ?>
            </a>
        </div>
    <?php endif; ?>
    <h3 class="title"><a href="<?= generatePostURL($postItem); ?>"<?php postURLNewTab($this, $postItem); ?>><?= esc(characterLimiter($postItem->title, 55, '...')); ?></a></h3>
    <p class="small-post-meta"><?= loadView('post/_post_meta', ['postItem' => $postItem]); ?></p>
</div>