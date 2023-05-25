<div class="post-item-mid<?= checkPostImg($post, 'class'); ?>">
    <?php if (checkPostImg($post)): ?>
        <div class="post-item-image">
            <a href="<?= generatePostURL($post); ?>"<?php postURLNewTab($post); ?>>
                <?= loadView("post/_post_image", ["postItem" => $post, "type" => "medium"]); ?>
            </a>
        </div>
    <?php endif; ?>
    <h3 class="title"><a href="<?= generatePostURL($post); ?>"<?php postURLNewTab($post); ?>><?= esc(characterLimiter($post->title, 55, '...')); ?></a></h3>
    <p class="post-meta">
        <?= loadView("post/_post_meta", ["post" => $post]); ?>
    </p>
</div>