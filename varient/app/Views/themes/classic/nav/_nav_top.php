<div class="top-bar">
<div class="container">
<div class="col-sm-12">
<div class="row">
<ul class="top-menu top-menu-left">
<?php if (!empty($baseMenuLinks)):
foreach ($baseMenuLinks as $item):
if ($item->item_visibility == 1 && $item->item_location == "top"): ?>
<li><a href="<?= generateMenuItemURL($item, $baseCategories); ?>"><?= esc($item->item_name); ?></a></li>
<?php endif;
endforeach;
endif; ?>
</ul>
<ul class="top-menu top-menu-right">
<?php if (checkUserPermission('add_post')): ?>
<li><a href="#" data-toggle="modal" data-target="#modal_add_post"><?= trans("add_post"); ?></a></li>
<?php endif;
if (authCheck()): ?>
<li class="dropdown profile-dropdown">
<a class="dropdown-toggle a-profile" data-toggle="dropdown" href="#" aria-expanded="false">
<img src="<?= getUserAvatar(user()->avatar); ?>" alt="<?= esc(user()->username); ?>">
<?= esc(user()->username); ?>
<span class="icon-arrow-down"></span>
</a>
<ul class="dropdown-menu">
<?php if (checkUserPermission('admin_panel')): ?>
<li><a href="<?= adminUrl(); ?>"><i class="icon-dashboard"></i><?= user()->role == "admin" || user()->role == "moderator" ? trans("admin_panel") : trans("dashboard"); ?></a></li>
<?php endif; ?>
<li><a href="<?= generateProfileURL(user()->slug); ?>"><i class="icon-user"></i><?= trans("profile"); ?></a></li>
<?php if (user()->reward_system_enabled == 1): ?>
<li><a href="<?= generateURL('earnings'); ?>"><i class="icon-coin-bag"></i><?= trans("earnings"); ?>(<strong class="lbl-earnings"><?= priceFormatted(user()->balance); ?></strong>)</a></li>
<?php endif; ?>
<li><a href="<?= generateURL('reading_list'); ?>"><i class="icon-star-o"></i><?= trans("reading_list"); ?></a></li>
<li><a href="<?= generateURL('settings'); ?>"><i class="icon-settings"></i><?= trans("settings"); ?></a></li>
<li><a href="<?= generateURL('logout'); ?>" class="logout"><i class="icon-logout-thin"></i><?= trans("logout"); ?></a></li>
</ul>
</li>
<?php else:
if ($generalSettings->registration_system == 1): ?>
<li class="top-li-auth"><a href="#" data-toggle="modal" data-target="#modal-login" class="btn_open_login_modal"><?= trans("login"); ?></a><span>&nbsp;/&nbsp;</span><a href="<?= generateURL('register'); ?>"><?= trans("register"); ?></a></li>
<?php endif; ?>
<?php endif; ?>
<?php if ($generalSettings->multilingual_system == 1 && countItems($activeLanguages) > 1): ?>
<li class="dropdown">
<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
<i class="icon-language"></i>&nbsp;
<?= esc($activeLang->name); ?>
<i class="icon-arrow-down"></i>
</a>
<ul class="dropdown-menu lang-dropdown">
<?php foreach ($activeLanguages as $language):
$langURL = base_url($language->short_form);
if ($language->id == $generalSettings->site_lang):
$langURL = base_url();
endif; ?>
<li><a href="<?= $langURL; ?>" class="<?= $language->id == $activeLang->id ? 'selected' : ''; ?>"><?= $language->name; ?></a></li>
<?php endforeach; ?>
</ul>
</li>
<?php endif; ?>
<li class="li-dark-mode-sw">
<form action="<?= base_url('switch-dark-mode'); ?>" method="post">
<?= csrf_field(); ?>
<input type="hidden" name="back_url" value="<?= currentFullURL(); ?>">
<?php if ($darkMode == true): ?>
<button type="submit" name="theme_mode" value="light" class="btn-switch-mode">
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sun-fill" viewBox="0 0 16 16">
<path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z"/>
</svg>
</button>
<?php else: ?>
<button type="submit" name="theme_mode" value="dark" class="btn-switch-mode">
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-moon-fill dark-mode-icon" viewBox="0 0 16 16">
<path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z"/>
</svg>
</button>
<?php endif; ?>
</form>
</li>
</ul>
</div>
</div>
</div>
</div>
