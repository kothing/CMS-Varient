<?php $menuLimit = $generalSettings->menu_limit;
$itemsMegaMenu = array(); ?>
<div class="navbar navbar-expand-md nav-main">
<nav class="container-xl">
<a href="<?= langBaseUrl(); ?>" class="navbar-brand p-0">
<img src="<?= $darkMode == 1 ? getLogoFooter() : getLogo(); ?>" alt="logo" class="logo" width="180" height="52">
</a>
<div class="collapse navbar-collapse">
<ul class="navbar-nav navbar-left display-flex align-items-center">
<?php if ($generalSettings->show_home_link == 1): ?>
<li class="nav-item">
<a href="<?= langBaseUrl(); ?>" class="nav-link"><?= trans("home"); ?></a>
</li>
<?php endif;
$totalItem = 0;
$i = 1;
if (!empty($baseMenuLinks)):
foreach ($baseMenuLinks as $item):
if ($item->item_visibility == 1 && $item->item_location == "main" && $item->item_parent_id == '0'):
if ($i < $menuLimit):
$subLinks = getSubMenuLinks($baseMenuLinks, $item->item_id, $item->item_type);
if ($item->item_type == "category"):
$category = getCategory($item->item_id, $baseCategories);
if (!empty($category)): ?>
<li class="nav-item nav-item-category nav-item-category-<?= $category->id; ?>" data-category-id="<?= $category->id; ?>">
<a href="<?= generateCategoryURL($category); ?>" class="nav-link" data-toggle="dropdown" role="button" aria-expanded="false"><?= esc($category->name); ?><i class="icon-arrow-down"></i></a>
</li>
<?php if (!empty($subLinks)) {
array_push($itemsMegaMenu, ['category' => $category, 'type' => 'multi']);
} else {
array_push($itemsMegaMenu, ['category' => $category, 'type' => 'single']);
}
endif;
else:
if (!empty($subLinks)): ?>
<li class="nav-item dropdown">
<a class="nav-link" href="<?= generateMenuItemURL($item, $baseCategories); ?>"><?= esc($item->item_name); ?><i class="icon-arrow-down"></i></a>
<ul class="dropdown-menu nav-dropdown-menu">
<?php foreach ($subLinks as $subItem):
if ($subItem->item_visibility == 1): ?>
<li><a href="<?= generateMenuItemURL($subItem, $baseCategories); ?>" class="dropdown-item"><?= esc($subItem->item_name); ?></a></li>
<?php endif;
endforeach; ?>
</ul>
</li>
<?php else: ?>
<li class="nav-item <?= uri_string() == $item->item_slug ? 'active' : ''; ?>"><a href="<?= generateMenuItemURL($item, $baseCategories); ?>" class="nav-link"><?= esc($item->item_name); ?></a></li>
<?php endif;
endif;
$i++;
endif;
$totalItem++;
endif;
endforeach;
endif;
if ($totalItem >= $menuLimit): ?>
<li class="nav-item dropdown">
<a class="nav-link" href="#"><?= trans("more"); ?><i class="icon-arrow-down"></i></a>
<ul class="dropdown-menu nav-dropdown-menu">
<?php $i = 1;
if (!empty($baseMenuLinks)):
foreach ($baseMenuLinks as $item):
if ($item->item_visibility == 1 && $item->item_location == "main" && $item->item_parent_id == "0"):
if ($i >= $menuLimit):
$subLinks = getSubMenuLinks($baseMenuLinks, $item->item_id, $item->item_type);
if (!empty($subLinks)): ?>
<li>
<a href="<?= generateMenuItemURL($item, $baseCategories); ?>" class="dropdown-item display-flex align-items-center"><?= esc($item->item_name); ?><i class="icon-arrow-down"></i></a>
<ul class="dropdown-menu dropdown-sub">
<?php foreach ($subLinks as $subItem):
if ($subItem->item_visibility == 1): ?>
<li><a href="<?= generateMenuItemURL($subItem, $baseCategories); ?>" class="dropdown-item"><?= esc($subItem->item_name); ?></a></li>
<?php endif;
endforeach; ?>
</ul>
</li>
<?php else: ?>
<li><a href="<?= generateMenuItemURL($item, $baseCategories); ?>" class="dropdown-item"><?= esc($item->item_name); ?></a></li>
<?php endif;
endif;
$i++;
endif;
endforeach;
endif; ?>
</ul>
</li>
<?php endif; ?>
</ul>
<hr class="d-md-none text-white-50">
<ul class="navbar-nav navbar-right flex-row flex-wrap align-items-center ms-md-auto">
<li class="nav-item col-6 col-lg-auto position-relative">
<button type="button" class="btn-link nav-link py-2 px-0 px-lg-2 search-icon display-flex align-items-center" aria-label="search">
<svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
<circle cx="11" cy="11" r="8"></circle>
<line x1="21" y1="21" x2="16.65" y2="16.65"></line>
</svg>
</button>
<div class="search-form">
<form action="<?= generateURL('search'); ?>" method="get" id="search_validate">
<input type="text" name="q" maxlength="300" pattern=".*\S+.*" class="form-control form-input" placeholder="<?= trans("placeholder_search"); ?>" <?= $rtl == true ? 'dir="rtl"' : ''; ?> required>
<button class="btn btn-custom" aria-label="search">
<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
<circle cx="11" cy="11" r="8"></circle>
<line x1="21" y1="21" x2="16.65" y2="16.65"></line>
</svg>
</button>
</form>
</div>
</li>
</ul>
</div>
</nav>
</div>

<div class="container-xl">
<div class="mega-menu-container">
<?php if (!empty($itemsMegaMenu)):
foreach ($itemsMegaMenu as $itemMegaMenu):
if (!empty($itemMegaMenu['category'])):
$category = $itemMegaMenu['category'];
$categoryPosts = getPostsByCategoryId($category->id, $baseCategories, $baseLatestCategoryPosts); ?>
<div class="mega-menu mega-menu-<?= $category->id; ?> shadow-sm" data-category-id="<?= $category->id; ?>">
<div class="container-fluid">
<div class="row">
<?php $postLimit = 5;
$subCategories = getSubcategories($category->id, $baseCategories);
if (!empty($subCategories)):
$postLimit = 4; ?>
<div class="col-3 menu-left">
<a href="<?= generateCategoryURL($category); ?>" data-category-filter="all" class="link-sub-category link-sub-category-all active"><?= trans("all"); ?></a>
<?php foreach ($subCategories as $subCategory):
if ($subCategory->show_on_menu == 1):?>
<a href="<?= generateCategoryURL($subCategory); ?>" data-category-filter="<?= esc($subCategory->id); ?>" class="link-sub-category"><?= esc($subCategory->name); ?></a>
<?php endif;
endforeach; ?>
</div>
<?php endif; ?>
<div class="col-12 menu-right<?= $postLimit == 5 ? ' width100' : ''; ?>">
<div class="menu-category-items filter-all active">
<div class="container-fluid">
<div class="row">
<?php $i = 0;
if (!empty($categoryPosts)):
foreach ($categoryPosts as $item):
if ($i < $postLimit): ?>
<div class="col-sm-2 menu-post-item<?= $postLimit == 5 ? ' width20' : ' width25'; ?>">
<?php if (checkPostImg($item)): ?>
<div class="image">
<a href="<?= generatePostURL($item); ?>"<?php postURLNewTab($item); ?>>
<img src="<?= IMG_BASE64_1x1; ?>" data-src="<?= getPostImage($item, 'mid'); ?>" alt="<?= esc($item->title); ?>" class="img-fluid lazyload" width="232" height="140"/>
<?php getMediaIcon($item, 'media-icon-sm'); ?>
</a>
</div>
<?php endif; ?>
<h3 class="title"><a href="<?= generatePostURL($item); ?>"<?php postURLNewTab($item); ?>><?= esc(characterLimiter($item->title, 45, '...')); ?></a></h3>
<p class="small-post-meta"><?= loadView('post/_post_meta', ['postItem' => $item]); ?></p>
</div>
<?php endif;
$i++;
endforeach;
endif; ?>
</div>
</div>
</div>
<?php if (!empty($subCategories)):
foreach ($subCategories as $subCategory):
if ($subCategory->show_on_menu == 1):?>
<div class="menu-category-items filter-<?= $subCategory->id; ?>">
<div class="container-fluid">
<div class="row">
<?php $categoryPosts = getPostsByCategoryId($subCategory->id, $baseCategories, $baseLatestCategoryPosts);
if (!empty($categoryPosts)):
$i = 0;
foreach ($categoryPosts as $item): ?>
<?php if ($i < $postLimit): ?>
<div class="col-sm-2 menu-post-item<?= $postLimit == 5 ? ' width20' : ' width25'; ?>">
<?php if (checkPostImg($item)): ?>
<div class="image">
<a href="<?= generatePostURL($item); ?>"<?php postURLNewTab($item); ?>>
<img src="<?= IMG_BASE64_1x1; ?>" data-src="<?= getPostImage($item, 'mid'); ?>" alt="<?= esc($item->title); ?>" class="img-fluid lazyload" width="232" height="140"/>
<?php getMediaIcon($item, 'media-icon-sm'); ?>
</a>
</div>
<?php endif; ?>
<h3 class="title"><a href="<?= generatePostURL($item); ?>"<?php postURLNewTab($item); ?>><?= esc(characterLimiter($item->title, 45, '...')); ?></a></h3>
<p class="small-post-meta"><?= loadView('post/_post_meta', ['postItem' => $item]); ?></p>
</div>
<?php endif;
$i++;
endforeach;
endif; ?>
</div>
</div>
</div>
<?php endif;
endforeach;
endif; ?>
</div>
</div>
</div>
</div>
<?php endif;
endforeach;
endif; ?>
</div>
</div>