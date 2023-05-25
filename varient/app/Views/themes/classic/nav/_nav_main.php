<?php $menuLimit = $generalSettings->menu_limit; ?>
<nav class="navbar navbar-default main-menu megamenu">
<div class="container">
<div class="collapse navbar-collapse">
<div class="row">
<ul class="nav navbar-nav">
<?php if ($generalSettings->show_home_link == 1): ?>
<li class="<?= uri_string() == 'index' || uri_string() == '' || uri_string() == '/' ? 'active' : ''; ?>"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
<?php endif;
$totalItem = 0;
$i = 1;
if (!empty($baseMenuLinks)):
foreach ($baseMenuLinks as $item):
if ($item->item_visibility == 1 && $item->item_location == "main" && $item->item_parent_id == '0'):
if ($i < $menuLimit):
$subLinks = getSubMenuLinks($baseMenuLinks, $item->item_id, $item->item_type);
if ($item->item_type == "category"):
if (!empty($subLinks)) {
echo loadView('nav/_megamenu_multicategory', ['categoryId' => $item->item_id]);
} else {
echo loadView('nav/_megamenu_singlecategory', ['categoryId' => $item->item_id]);
}
else:
if (!empty($subLinks)): ?>
<li class="dropdown <?= uri_string() == $item->item_slug ? 'active' : ''; ?>">
<a class="dropdown-toggle disabled no-after" data-toggle="dropdown" href="<?= generateMenuItemURL($item, $baseCategories); ?>"><?= esc($item->item_name); ?><span class="caret"></span></a>
<ul class="dropdown-menu dropdown-more dropdown-top">
<?php foreach ($subLinks as $subItem):
if ($subItem->item_visibility == 1): ?>
<li><a role="menuitem" href="<?= generateMenuItemURL($subItem, $baseCategories); ?>"><?= esc($subItem->item_name); ?></a></li>
<?php endif;
endforeach; ?>
</ul>
</li>
<?php else: ?>
<li class="<?= uri_string() == $item->item_slug ? 'active' : ''; ?>"><a href="<?= generateMenuItemURL($item, $baseCategories); ?>"><?= esc($item->item_name); ?></a></li>
<?php endif;
endif;
$i++;
endif;
$totalItem++;
endif;
endforeach;
endif;
if ($totalItem >= $menuLimit): ?>
<li class="dropdown relative">
<a class="dropdown-toggle dropdown-more-icon" data-toggle="dropdown" href="#"><i class="icon-ellipsis-h"></i></a>
<ul class="dropdown-menu dropdown-more dropdown-top">
<?php $i = 1;
if (!empty($baseMenuLinks)):
foreach ($baseMenuLinks as $item):
if ($item->item_visibility == 1 && $item->item_location == "main" && $item->item_parent_id == "0"):
if ($i >= $menuLimit):
$subLinks = getSubMenuLinks($baseMenuLinks, $item->item_id, $item->item_type);
if (!empty($subLinks)): ?>
<li class="dropdown-more-item">
<a class="dropdown-toggle disabled" data-toggle="dropdown" href="<?= generateMenuItemURL($item, $baseCategories); ?>"><?= esc($item->item_name); ?> <span class="icon-arrow-right"></span></a>
<ul class="dropdown-menu dropdown-sub">
<?php foreach ($subLinks as $subItem):
if ($subItem->item_visibility == 1): ?>
<li><a role="menuitem" href="<?= generateMenuItemURL($subItem, $baseCategories); ?>"><?= esc($subItem->item_name); ?></a></li>
<?php endif;
endforeach; ?>
</ul>
</li>
<?php else: ?>
<li><a href="<?= generateMenuItemURL($item, $baseCategories); ?>"><?= esc($item->item_name); ?></a></li>
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
<ul class="nav navbar-nav navbar-right">
<li class="li-search">
<a class="search-icon"><i class="icon-search"></i></a>
<div class="search-form">
<form action="<?= generateURL('search'); ?>" method="get" id="search_validate">
<input type="text" name="q" maxlength="300" pattern=".*\S+.*" class="form-control form-input" placeholder="<?= trans("placeholder_search"); ?>" <?= $rtl == true ? 'dir="rtl"' : ''; ?> required>
<button class="btn btn-default"><i class="icon-search"></i></button>
</form>
</div>
</li>
</ul>
</div>
</div>
</div>
</nav>