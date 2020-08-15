<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="navMobile" class="nav-mobile">
    <div class="nav-mobile-inner">
        <div class="row">
            <div class="col-sm-12 mobile-nav-buttons">
                <?php if ($this->auth_check) :
                    if (check_user_permission('add_post')): ?>
                        <button class="btn btn-custom btn-mobile-nav btn-mobile-nav-add close-menu-click" data-toggle="modal" data-target="#modal_add_post"><i class="icon-copy"></i><?php echo trans("add_post"); ?></button>
                    <?php endif; ?>
                <?php else:
                    if ($this->general_settings->registration_system == 1): ?>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-login" class="btn btn-custom btn-mobile-nav close-menu-click btn_open_login_modal m-r-5"><i class="icon-login"></i><?php echo trans("login"); ?></a>
                        <a href="<?php echo generate_url('register'); ?>" class="btn btn-custom btn-mobile-nav"><i class="icon-user-plus-o"></i><?php echo trans("register"); ?></a>
                    <?php endif;
                endif; ?>
            </div>
        </div>

        <?php if ($this->auth_check) : ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="dropdown profile-dropdown nav-item">
                        <a href="#" class="dropdown-toggle image-profile-drop nav-link" data-toggle="dropdown" aria-expanded="false">
                            <img src="<?php echo get_user_avatar($this->auth_user); ?>" alt="<?php echo html_escape($this->auth_user->username); ?>">
                            <?php echo html_escape($this->auth_user->username); ?> <span class="icon-arrow-down"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <?php if (check_user_permission('admin_panel')): ?>
                                <li>
                                    <a href="<?php echo admin_url(); ?>"><i class="icon-dashboard"></i>&nbsp;<?php echo trans("admin_panel"); ?></a>
                                </li>
                            <?php endif; ?>
                            <li>
                                <a href="<?php echo generate_profile_url($this->auth_user->slug); ?>"><i class="icon-user"></i>&nbsp;<?php echo trans("profile"); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo generate_url('reading_list'); ?>"><i class="icon-star-o"></i>&nbsp;<?php echo trans("reading_list"); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo generate_url('settings'); ?>"><i class="icon-settings"></i>&nbsp;<?php echo trans("settings"); ?></a>
                            </li>
                            <li>
                                <a href="<?php echo generate_url('logout'); ?>"><i class="icon-logout-thin"></i>&nbsp;<?php echo trans("logout"); ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-sm-12">
                <ul class="nav navbar-nav">
                    <?php if ($this->general_settings->show_home_link == 1): ?>
                        <li class="nav-item">
                            <a href="<?php echo lang_base_url(); ?>" class="nav-link">
                                <?php echo trans("home"); ?>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (!empty($this->menu_links)):
                        foreach ($this->menu_links as $item):
                            if ($item->item_visibility == 1 && ($item->item_location == "top" || $item->item_location == "main") && $item->item_parent_id == "0"):
                                $sub_links = get_sub_menu_links($this->menu_links, $item->item_id, $item->item_type);
                                if (!empty($sub_links)): ?>
                                    <li class="nav-item dropdown">
                                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
                                            <?php echo html_escape($item->item_name) ?>
                                            <i class="icon-arrow-down"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <?php if ($item->item_type == "category"): ?>
                                                <li class="nav-item">
                                                    <a href="<?php echo generate_menu_item_url($item); ?>" class="nav-link"><?php echo trans("all"); ?></a>
                                                </li>
                                            <?php endif; ?>
                                            <?php foreach ($sub_links as $sub):
                                                if ($sub->item_visibility == 1):?>
                                                    <li class="nav-item">
                                                        <a href="<?php echo generate_menu_item_url($sub); ?>" class="nav-link">
                                                            <?php echo html_escape($sub->item_name) ?>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>
                                    </li>
                                <?php else: ?>
                                    <li class="nav-item">
                                        <a href="<?php echo generate_menu_item_url($item); ?>" class="nav-link">
                                            <?php echo html_escape($item->item_name) ?>
                                        </a>
                                    </li>
                                <?php endif;
                            endif;
                        endforeach;
                    endif; ?>

                    <?php if ($this->general_settings->multilingual_system == 1 && count($this->languages) > 1): ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <?php echo trans("language"); ?>
                            </a>
                            <ul class="mobile-language-options">
                                <?php foreach ($this->languages as $language):
                                    $lang_url = base_url() . $language->short_form . "/";
                                    if ($language->id == $this->general_settings->site_lang) {
                                        $lang_url = base_url();
                                    } ?>
                                    <li>
                                        <a href="<?php echo $lang_url; ?>" class="<?php echo ($language->id == $this->selected_lang->id) ? 'selected' : ''; ?> ">
                                            <?php echo html_escape($language->name); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="nav-mobile-footer">
        <ul class="mobile-menu-social">
            <!--Include social media links-->
            <?php $this->load->view('partials/_social_media_links', ['rss_hide' => false]); ?>
        </ul>
    </div>
</div>