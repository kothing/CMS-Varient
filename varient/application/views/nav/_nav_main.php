<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $menu_limit = $this->general_settings->menu_limit; ?>
<nav class="navbar navbar-default main-menu megamenu">
    <div class="container">
        <div class="collapse navbar-collapse">
            <div class="row">
                <ul class="nav navbar-nav">
                    <?php if ($this->general_settings->show_home_link == 1): ?>
                        <li class="<?php echo (uri_string() == 'index' || uri_string() == "") ? 'active' : ''; ?>">
                            <a href="<?php echo lang_base_url(); ?>">
                                <?php echo trans("home"); ?>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php
                    $total_item = 0;
                    $i = 1;
                    if (!empty($this->menu_links)):
                        foreach ($this->menu_links as $item):
                            if ($item->item_visibility == 1 && $item->item_location == "main" && $item->item_parent_id == "0"):
                                if ($i < $menu_limit):
                                    $sub_links = get_sub_menu_links($this->menu_links, $item->item_id, $item->item_type);
                                    if ($item->item_type == "category") {
                                        if (!empty($sub_links)) {
                                            $this->load->view('nav/_megamenu_multicategory', ['category_id' => $item->item_id]);
                                        } else {
                                            $this->load->view('nav/_megamenu_singlecategory', ['category_id' => $item->item_id]);
                                        }
                                    } else {
                                        if (!empty($sub_links)): ?>
                                            <li class="dropdown <?php echo (uri_string() == $item->item_slug) ? 'active' : ''; ?>">
                                                <a class="dropdown-toggle disabled no-after" data-toggle="dropdown" href="<?php echo generate_menu_item_url($item); ?>">
                                                    <?php echo html_escape($item->item_name); ?>
                                                    <span class="caret"></span>
                                                </a>
                                                <ul class="dropdown-menu dropdown-more dropdown-top">
                                                    <?php foreach ($sub_links as $sub_item): ?>
                                                        <?php if ($sub_item->item_visibility == 1): ?>
                                                            <li>
                                                                <a role="menuitem" href="<?php echo generate_menu_item_url($sub_item); ?>">
                                                                    <?php echo html_escape($sub_item->item_name); ?>
                                                                </a>
                                                            </li>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </li>
                                        <?php else: ?>
                                            <li class="<?php echo (uri_string() == $item->item_slug) ? 'active' : ''; ?>">
                                                <a href="<?php echo generate_menu_item_url($item); ?>">
                                                    <?php echo html_escape($item->item_name); ?>
                                                </a>
                                            </li>
                                        <?php endif;
                                    }
                                    $i++;
                                endif;
                                $total_item++;
                            endif;
                        endforeach;
                    endif; ?>

                    <?php if ($total_item >= $menu_limit): ?>
                        <li class="dropdown relative">
                            <a class="dropdown-toggle dropdown-more-icon" data-toggle="dropdown" href="#">
                                <i class="icon-ellipsis-h"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-more dropdown-top">
                                <?php $i = 1;
                                if (!empty($this->menu_links)):
                                    foreach ($this->menu_links as $item):
                                        if ($item->item_visibility == 1 && $item->item_location == "main" && $item->item_parent_id == "0"):
                                            if ($i >= $menu_limit):
                                                $sub_links = get_sub_menu_links($this->menu_links, $item->item_id, $item->item_type);
                                                if (!empty($sub_links)): ?>
                                                    <li class="dropdown-more-item">
                                                        <a class="dropdown-toggle disabled" data-toggle="dropdown" href="<?php echo generate_menu_item_url($item); ?>">
                                                            <?php echo html_escape($item->item_name); ?> <span class="icon-arrow-right"></span>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-sub">
                                                            <?php foreach ($sub_links as $sub_item): ?>
                                                                <?php if ($sub_item->item_visibility == 1): ?>
                                                                    <li>
                                                                        <a role="menuitem" href="<?php echo generate_menu_item_url($sub_item); ?>">
                                                                            <?php echo html_escape($sub_item->item_name); ?>
                                                                        </a>
                                                                    </li>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </li>
                                                <?php else: ?>
                                                    <li>
                                                        <a href="<?php echo generate_menu_item_url($item); ?>">
                                                            <?php echo html_escape($item->item_name); ?>
                                                        </a>
                                                    </li>
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
                            <?php echo form_open(generate_url('search'), ['method' => 'get', 'id' => 'search_validate']); ?>
                            <input type="text" name="q" maxlength="300" pattern=".*\S+.*" class="form-control form-input" placeholder="<?php echo trans("placeholder_search"); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                            <button class="btn btn-default"><i class="icon-search"></i></button>
                            <?php echo form_close(); ?>
                        </div>
                    </li>
                </ul>
            </div>
        </div><!-- /.navbar-collapse -->
    </div>
</nav>