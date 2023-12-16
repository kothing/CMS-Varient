<div class="tbl-container post-item-small<?= checkPostImg($postItem, 'class'); ?>">
    <?php if (checkPostImg($postItem)): ?>
        <div class="tbl-cell left">
            <?php if (checkPostImg($postItem)): ?>
                <div class="image">
                    <a href="<?= generatePostURL($postItem); ?>"<?php postURLNewTab($postItem); ?>>
                        <img src="<?= IMG_BASE64_1x1; ?>" data-src="<?= getPostImage($postItem, 'small'); ?>" alt="<?= esc($postItem->title); ?>" class="img-fluid lazyload" width="130" height="91"/>
                        <?php getMediaIcon($postItem, 'media-icon'); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <div class="tbl-cell right">
        <h3 class="title"><a href="<?= generatePostURL($postItem); ?>"<?php postURLNewTab($postItem); ?>><?= esc(characterLimiter($postItem->title, 50, '...')); ?></a></h3>
        <p class="small-post-meta"><?= loadView('post/_post_meta', ['postItem' => $postItem]); ?></p>
    </div>
</div>