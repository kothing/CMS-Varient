<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script src="<?php echo base_url(); ?>assets/admin/plugins/sortable/Sortable.min.js"></script>

<div class="row" style="margin-bottom: 20px;">
    <div class="col-lg-6 col-md-6 col-sm-12">
        <label><?php echo trans("language"); ?></label>
        <select name="lang_id" class="form-control max-400" onchange="window.location.href = '<?php echo admin_url(); ?>'+'navigation?lang='+this.value;">
            <?php foreach ($this->languages as $language): ?>
                <option value="<?php echo $language->id; ?>" <?php echo ($selected_lang == $language->id) ? 'selected' : ''; ?>><?php echo $language->name; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("navigation"); ?></h3><br>
                <small><?php echo trans("navigation_exp"); ?></small>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('category_controller/add_category_post'); ?>

            <input type="hidden" name="parent_id" value="0">
            <div class="box-body">
                <?php $this->load->view('admin/includes/_messages'); ?>
                <div id="accordion" data-parent-id="0" data-item-type="none" class="panel-group nested-sortable navigation-editable main-nav-item-container">
                    <div class="panel panel-default nav-item" style="pointer-events: none">
                        <?php if ($this->general_settings->show_home_link == 1): ?>
                            <a href="javascript:void(0)" class="btn btn-sm btn-danger btn-nav-edit btn-show-hide-home"><?php echo trans("hide"); ?></a>
                        <?php else: ?>
                            <a href="javascript:void(0)" class="btn btn-sm btn-success btn-nav-edit btn-show-hide-home"><?php echo trans("show"); ?></a>
                        <?php endif; ?>
                        <div class="panel-heading"><h4 class="panel-title"><span><?php echo trans("home"); ?></span></h4></div>
                    </div>
                    <?php foreach ($menu_links as $menu_item):
                        if ($menu_item->item_location == "main" && $menu_item->item_parent_id == 0):
                            $sub_links = get_sub_menu_links($menu_links, $menu_item->item_id, $menu_item->item_type); ?>
                            <div id="nav_item_<?php echo $menu_item->item_type . '_' . $menu_item->item_id; ?>" class="panel panel-default nav-item" data-item-id="<?php echo $menu_item->item_id; ?>" data-item-type="<?php echo $menu_item->item_type; ?>" data-have-subs-items="<?php echo (!empty($sub_links)) ? '1' : '0'; ?>">
                                <a href="<?php echo get_navigation_item_edit_link($menu_item); ?>" class="btn btn-sm btn-secondary btn-nav-edit"><i class="fa fa-edit"></i></a>
                                <a href="javascript:void(0)" onclick="<?php echo get_navigation_item_delete_function($menu_item); ?>" class="btn btn-sm btn-danger btn-nav-edit btn-nav-delete"><i class="fa fa-trash"></i></a>
                                <div class="panel-heading" data-toggle="collapse" href="#collapse_<?php echo $menu_item->item_type; ?>_<?php echo $menu_item->item_id; ?>">
                                    <h4 class="panel-title">
                                        <i class="fa fa-plus"></i>
                                        <span><?php echo $menu_item->item_name; ?><em>(<?php echo get_navigation_item_type($menu_item); ?>)</em></span>
                                    </h4>
                                </div>
                                <div id="collapse_<?php echo $menu_item->item_type; ?>_<?php echo $menu_item->item_id; ?>" class="panel-collapse collapse">
                                    <div class="panel-body nested-sortable panel-body-sublinks" data-parent-id="<?php echo $menu_item->item_id; ?>" data-item-type="<?php echo $menu_item->item_type; ?>">
                                        <?php foreach ($sub_links as $sub_link): ?>
                                            <div id="nav_item_<?php echo $sub_link->item_type . '_' . $sub_link->item_id; ?>" class="list-group-item nav-item" data-item-id="<?php echo $sub_link->item_id; ?>" data-item-type="<?php echo $sub_link->item_type; ?>">
                                                <?php echo $sub_link->item_name; ?>
                                                <a href="<?php echo get_navigation_item_edit_link($sub_link); ?>" class="btn btn-sm btn-secondary btn-nav-edit"><i class="fa fa-edit"></i></a>
                                                <a href="javascript:void(0)" onclick="<?php echo get_navigation_item_delete_function($sub_link); ?>" class="btn btn-sm btn-danger btn-nav-edit btn-nav-delete"><i class="fa fa-trash"></i></a>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif;
                    endforeach; ?>
                </div>
            </div>
            <?php echo form_close(); ?><!-- form end -->
        </div>
        <div class="alert alert-danger alert-large">
            <strong><?php echo trans("warning"); ?>!</strong>&nbsp;&nbsp;<?php echo trans("nav_drag_warning"); ?>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo trans("add_link"); ?></h3>
                    </div>
                    <!-- /.box-header -->

                    <!-- form start -->
                    <?php echo form_open('admin_controller/add_menu_link_post'); ?>
                    <input type="hidden" name="lang_id" value="<?php echo $selected_lang; ?>">
                    <div class="box-body">
                        <!-- include message block -->
                        <?php if (empty($this->session->flashdata("mes_menu_limit"))):
                            $this->load->view('admin/includes/_messages_form');
                        endif; ?>
                        <div class="form-group">
                            <label><?php echo trans("title"); ?></label>
                            <input type="text" class="form-control" name="title" placeholder="<?php echo trans("title"); ?>" value="<?php echo old('title'); ?>" maxlength="200" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                        </div>
                        <div class="form-group">
                            <label><?php echo trans("link"); ?></label>
                            <input type="text" class="form-control" name="link" placeholder="<?php echo trans("link"); ?>" value="<?php echo old('link'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                        </div>
                        <div class="form-group">
                            <label><?php echo trans('order'); ?></label>
                            <input type="number" class="form-control" name="page_order" placeholder="<?php echo trans('order'); ?>" value="1" min="1" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo trans('parent_link'); ?></label>
                            <select id="parent_links" name="parent_id" class="form-control">
                                <option value="0"><?php echo trans('none'); ?></option>
                                <?php foreach ($menu_links as $item):
                                    if ($item->item_type != "category" && $item->item_location == "main" && $item->item_parent_id == "0"): ?>
                                        <option value="<?php echo $item->item_id; ?>"><?php echo $item->item_name; ?></option>
                                    <?php endif;
                                endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4 col-xs-12">
                                    <label><?php echo trans('show_on_menu'); ?></label>
                                </div>
                                <div class="col-md-3 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" id="rb_show_on_menu_1" name="visibility" value="1" class="square-purple" checked>
                                    <label for="rb_show_on_menu_1" class="cursor-pointer"><?php echo trans('yes'); ?></label>
                                </div>
                                <div class="col-md-3 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" id="rb_show_on_menu_2" name="visibility" value="0" class="square-purple">
                                    <label for="rb_show_on_menu_2" class="cursor-pointer"><?php echo trans('no'); ?></label>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary pull-right"><?php echo trans('add_link'); ?></button>
                    </div>
                    <!-- /.box-footer -->
                    <?php echo form_close(); ?><!-- form end -->
                </div>
            </div>
            <div class="col-sm-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo trans("menu_limit"); ?></h3>
                    </div>
                    <!-- /.box-header -->


                    <!-- form start -->
                    <?php echo form_open('admin_controller/menu_limit_post'); ?>

                    <div class="box-body">
                        <!-- include message block -->
                        <?php if (!empty($this->session->flashdata("mes_menu_limit"))):
                            $this->load->view('admin/includes/_messages_form');
                        endif; ?>
                        <div class="form-group">
                            <label><?php echo trans('menu_limit'); ?>(<?php echo trans("number_of_links_in_menu"); ?>)</label>
                            <input type="number" class="form-control" name="menu_limit"
                                   placeholder="<?php echo trans('menu_limit'); ?>"
                                   value="<?php echo $this->general_settings->menu_limit; ?>" min="1"
                                   max="100" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit"
                                class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
                    </div>
                    <!-- /.box-footer -->
                    <?php echo form_close(); ?><!-- form end -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var moved_item_id = null;
    var nestedSortables = [].slice.call(document.querySelectorAll('.nested-sortable'));

    // Loop through each nested sortable element
    for (var i = 0; i < nestedSortables.length; i++) {
        new Sortable(nestedSortables[i], {
            group: 'nested',
            animation: 100,
            fallbackOnBody: true,
            swapThreshold: 0.65,
            onEnd: function (event) {
                var parent_id = event.to.getAttribute('data-parent-id');
                var parent_type = event.to.getAttribute('data-item-type');
                var new_order = event.newIndex;
                var item_id = event.item.getAttribute('data-item-id');
                var item_type = event.item.getAttribute('data-item-type');
                var is_item_has_sub_items = event.item.getAttribute('data-have-subs-items');
                if ((parent_type != 'none' && item_type != parent_type) || (is_item_has_sub_items == 1 && parent_type != 'none')) {
                    swal({
                        text: '<?php echo trans("invalid"); ?>',
                        icon: "warning",
                        dangerMode: true,
                    }).then(function (willDelete) {
                        location.reload();
                    });
                } else {
                    var menu_items = [];
                    var order = 1;
                    $(".main-nav-item-container > .nav-item").each(function () {
                        var item_id = $(this).attr("data-item-id");
                        var menu_item = {
                            "parent_id": 0,
                            "new_order": order,
                            "item_id": item_id,
                            "item_type": $(this).attr("data-item-type")
                        };
                        menu_items.push(menu_item);
                        order++;

                        //sub items
                        var div_id = $(this).attr("id");
                        var order_sub_item = 1;
                        $("#" + div_id + " .nav-item").each(function () {
                            var menu_item = {
                                "parent_id": item_id,
                                "new_order": order_sub_item,
                                "item_id": $(this).attr("data-item-id"),
                                "item_type": $(this).attr("data-item-type")
                            };
                            menu_items.push(menu_item);
                            order_sub_item++;
                        });
                    });
                    var data = {
                        'json_menu_items': JSON.stringify(menu_items)
                    };
                    data[csfr_token_name] = $.cookie(csfr_cookie_name);
                    $.ajax({
                        type: "POST",
                        url: base_url + "admin_controller/sort_menu_items",
                        data: data,
                        success: function (response) {
                        }
                    });

                }
            },
        });
    }
    $(document).on('click', '.navigation-editable .panel-heading', function () {
        if ($(this).find('i').hasClass('fa-plus')) {
            $(this).find('i').removeClass('fa-plus');
            $(this).find('i').addClass('fa-minus');
        } else {
            $(this).find('i').removeClass('fa-minus');
            $(this).find('i').addClass('fa-plus');
        }
    });
    $(document).on('click', '.btn-show-hide-home', function () {
        if ($(this).hasClass('btn-danger')) {
            $(this).removeClass('btn-danger');
            $(this).addClass('btn-success');
            $(this).text("<?php echo trans("show"); ?>");
        } else {
            $(this).removeClass('btn-success');
            $(this).addClass('btn-danger');
            $(this).text("<?php echo trans("hide"); ?>");
        }
        var data = {};
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: "POST",
            url: base_url + "admin_controller/hide_show_home_link",
            data: data,
            success: function (response) {
            }
        });
    });
</script>


