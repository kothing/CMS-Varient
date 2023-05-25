<?php $category = getCategory($categoryId, $baseCategories);
if (!empty($category)):
$categoryPosts = getPostsByCategoryId($categoryId, $baseCategories, $baseLatestCategoryPosts); ?>
<li class="dropdown megamenu-fw mega-li-<?= $category->id; ?> <?= uri_string() == esc($category->name_slug) ? 'active' : ''; ?>">
<a href="<?= generateCategoryURL($category); ?>" class="dropdown-toggle disabled" data-toggle="dropdown" role="button" aria-expanded="false"><?= esc($category->name); ?><span class="caret"></span></a>
<?php if (!empty($categoryPosts)): ?>
<ul class="dropdown-menu megamenu-content dropdown-top" role="menu" data-mega-ul="<?= $category->id; ?>">
<li>
<div class="col-sm-12">
<div class="row">
<div class="sub-menu-right single-sub-menu">
<div class="row row-menu-right">
<?php $count = 0;
foreach ($categoryPosts as $post):
if ($count < 5): ?>
<div class="col-sm-3 menu-post-item">
<?php if (checkPostImg($post)): ?>
<div class="post-item-image">
<a href="<?= generatePostURL($post); ?>"<?php postURLNewTab($post); ?>><?= loadView("post/_post_image", ["postItem" => $post, "type" => "medium"]); ?></a>
</div>
<?php endif; ?>
<h3 class="title">
<a href="<?= generatePostURL($post); ?>"<?php postURLNewTab($post); ?>><?= esc(characterLimiter($post->title, 45, '...')); ?></a>
</h3>
<p class="post-meta"><?= loadView("post/_post_meta", ["post" => $post]); ?></p>
</div>
<?php endif;
$count++;
endforeach; ?>
</div>
</div>
</div>
</div>
</li>
</ul>
<?php endif; ?>
</li>
<?php endif; ?>