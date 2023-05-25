<?php $category = getCategory($categoryId, $baseCategories);
if (!empty($category)):
$categoryPosts = getPostsByCategoryId($categoryId, $baseCategories, $baseLatestCategoryPosts); ?>
<li class="dropdown megamenu-fw mega-li-<?= $category->id; ?> <?= uri_string() == esc($category->name_slug) ? 'active' : ''; ?>">
<a href="<?= generateCategoryURL($category); ?>" class="dropdown-toggle disabled" data-toggle="dropdown" role="button" aria-expanded="false"><?= esc($category->name); ?> <span class="caret"></span></a>
<?php if (!empty($categoryPosts) && countItems($categoryPosts) > 0): ?>
<ul class="dropdown-menu megamenu-content dropdown-top" role="menu" aria-expanded="true" data-mega-ul="<?= $category->id; ?>">
<li>
<div class="sub-menu-left">
<ul class="nav-sub-categories">
<li data-category-filter="all" class="li-sub-category active"><a href="<?= generateCategoryURL($category); ?>"><?= trans("all"); ?></a></li>
<?php $subCategories = getSubcategories($category->id, $baseCategories);
if (!empty($subCategories)):
foreach ($subCategories as $subCategory):
if ($subCategory->show_on_menu == 1):?>
<li data-category-filter="<?= esc($subCategory->name_slug); ?>-<?= esc($subCategory->id); ?>" class="li-sub-category"><a href="<?= generateCategoryURL($subCategory); ?>"><?= esc($subCategory->name); ?></a></li>
<?php endif;
endforeach;
endif; ?>
</ul>
</div>
<div class="sub-menu-right">
<div class="sub-menu-inner filter-all active">
<div class="row row-menu-right">
<?php $i = 0;
if (!empty($categoryPosts)):
foreach ($categoryPosts as $post):
if ($i < 4): ?>
<div class="col-sm-3 menu-post-item">
<?php if (checkPostImg($post)): ?>
<div class="post-item-image">
<a href="<?= generatePostURL($post); ?>"<?php postURLNewTab($post); ?>><?= loadView("post/_post_image", ["postItem" => $post, "type" => "medium"]); ?></a>
</div>
<?php endif; ?>
<h3 class="title"><a href="<?= generatePostURL($post); ?>"<?php postURLNewTab($post); ?>><?= esc(characterLimiter($post->title, 45, '...')); ?></a></h3>
<p class="post-meta"><?= loadView("post/_post_meta", ["post" => $post]); ?></p>
</div>
<?php endif;
$i++;
endforeach;
endif; ?>
</div>
</div>
<?php if (!empty($subCategories)):
foreach ($subCategories as $subCategory):
if ($subCategory->show_on_menu == 1):?>
<div class="sub-menu-inner filter-<?= esc($subCategory->name_slug); ?>-<?= $subCategory->id; ?>">
<div class="row row-menu-right">
<?php $categoryPosts = getPostsByCategoryId($subCategory->id, $baseCategories, $baseLatestCategoryPosts);
if (!empty($categoryPosts)):
$i = 0;
foreach ($categoryPosts as $post): ?>
<?php if ($i < 4): ?>
<div class="col-sm-3 menu-post-item">
<?php if (checkPostImg($post)): ?>
<div class="post-item-image post-item-image-mn">
<a href="<?= generatePostURL($post); ?>"<?php postURLNewTab($post); ?>><?= loadView("post/_post_image", ["postItem" => $post, "type" => "medium"]); ?></a>
</div>
<?php endif; ?>
<h3 class="title"><a href="<?= generatePostURL($post); ?>"<?php postURLNewTab($post); ?>><?= esc(characterLimiter($post->title, 45, '...')); ?></a></h3>
<p class="post-meta"><?= loadView("post/_post_meta", ["post" => $post]); ?></p>
</div>
<?php endif;
$i++;
endforeach;
endif; ?>
</div>
</div>
<?php endif;
endforeach;
endif; ?>
</div>
</li>
</ul>
<?php endif; ?>
</li>
<?php endif; ?>