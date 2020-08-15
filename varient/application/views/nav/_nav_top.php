<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="top-bar">
    <div class="container">
        <div class="col-sm-12">
            <div class="row">
                <ul class="top-menu top-menu-left">
                    <!--Print top menu pages-->
                    <?php if (!empty($this->menu_links)):
                        foreach ($this->menu_links as $item): ?>
                            <?php if ($item->item_visibility == 1 && $item->item_location == "top"): ?>
                                <li><a href="<?php echo generate_menu_item_url($item); ?>"><?php echo html_escape($item->item_name); ?></a></li>
                            <?php endif;
                        endforeach;
                    endif; ?>
                </ul>
                <ul class="top-menu top-menu-right">
                    <?php if (check_user_permission('add_post')): ?>
                        <li>
                            <a href="#" data-toggle="modal" data-target="#modal_add_post"><?php echo trans("add_post"); ?></a>
                        </li>
                    <?php endif; ?>
                    <!--Check auth-->
                    <?php if ($this->auth_check): ?>
                        <li class="dropdown profile-dropdown">
                            <a class="dropdown-toggle a-profile" data-toggle="dropdown" href="#" aria-expanded="false">
                                <img src="<?php echo get_user_avatar($this->auth_user); ?>" alt="<?php echo html_escape($this->auth_user->username); ?>">
                                <?php echo html_escape($this->auth_user->username); ?> <span class="icon-arrow-down"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if (check_user_permission('admin_panel')): ?>
                                    <li>
                                        <a href="<?php echo admin_url(); ?>">
                                            <i class="icon-dashboard"></i>
                                            <?php echo trans("admin_panel"); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <li>
                                    <a href="<?php echo generate_profile_url($this->auth_user->slug); ?>">
                                        <i class="icon-user"></i>
                                        <?php echo trans("profile"); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo generate_url('reading_list'); ?>">
                                        <i class="icon-star-o"></i>
                                        <?php echo trans("reading_list"); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo generate_url('settings'); ?>">
                                        <i class="icon-settings"></i>
                                        <?php echo trans("settings"); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo generate_url('logout'); ?>" class="logout">
                                        <i class="icon-logout-thin"></i>
                                        <?php echo trans("logout"); ?>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <?php if ($this->general_settings->registration_system == 1): ?>
                            <li class="top-li-auth">
                                <a href="#" data-toggle="modal" data-target="#modal-login" class="btn_open_login_modal"><?php echo trans("login"); ?></a>
                                <span>/</span>
                                <a href="<?php echo generate_url('register'); ?>"><?php echo trans("register"); ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if ($this->general_settings->multilingual_system == 1 && count($this->languages) > 1): ?>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                <i class="icon-language"></i>&nbsp;
                                <?php echo html_escape($this->selected_lang->name); ?> <span class="icon-arrow-down"></span>
                            </a>
                            <ul class="dropdown-menu lang-dropdown">
                                <?php
                                foreach ($this->languages as $language):
                                    $lang_url = base_url() . $language->short_form . "/";
                                    if ($language->id == $this->general_settings->site_lang) {
                                        $lang_url = base_url();
                                    } ?>
                                    <li>
                                        <a href="<?php echo $lang_url; ?>" class="<?php echo ($language->id == $this->selected_lang->id) ? 'selected' : ''; ?> ">
                                            <?php echo $language->name; ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div><!--/.container-->
</div><!--/.top-bar-->
