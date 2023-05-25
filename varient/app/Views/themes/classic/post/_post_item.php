<div class="post-item<?= checkPostImg($post, 'class'); ?>">
    <?php if (isset($showLabel)): ?>
        <a href="<?= generateCategoryURLById($post->category_id, $baseCategories); ?>"><span class="category-label" style="background-color: <?= esc($post->category_color); ?>"><?= esc($post->category_name); ?></span></a>
    <?php endif; ?>
    <?php if (checkPostImg($post)): ?>
        <div class="post-item-image">
            <a href="<?= generatePostURL($post); ?>"<?php postURLNewTab($post); ?>><?= loadView("post/_post_image", ["postItem" => $post, "type" => "medium"]); ?></a>
        </div>
    <?php endif; ?>
    <h3 class="title"><a href="<?= generatePostURL($post); ?>"<?php postURLNewTab($this, $post); ?>><?= esc(characterLimiter($post->title, 55, '...')); ?></a></h3>
    <p class="post-meta"><?= loadView("post/_post_meta", ["post" => $post]); ?></p>
    <p class="description"><?= esc(characterLimiter($post->summary, 80, '...')); ?></p>
</div>