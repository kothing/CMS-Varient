<script src="<?= base_url('assets/admin/plugins/sortable/Sortable.min.js'); ?>"></script>
<div class="row" style="margin-bottom: 20px;">
    <div class="col-lg-6 col-md-6 col-sm-12">
        <label><?= trans("language"); ?></label>
        <select name="lang_id" class="form-control max-400" onchange="window.location.href = '<?= adminUrl(); ?>'+'/navigation?lang='+this.value;">
            <?php foreach ($activeLanguages as $language): ?>
                <option value="<?= $language->id; ?>" <?= $selectedLang == $language->id ? 'selected' : ''; ?>><?= $language->name; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans("navigation"); ?></h3><br>
                <small><?= trans("navigation_exp"); ?></small>
            </div>
            <div class="box-body">
                <div id="accordion" data-parent-id="0" data-item-type="none" class="panel-group nested-sortable navigation-editable main-nav-item-container">
                    <div class="panel panel-default nav-item" style="pointer-events: none">
                        <?php if ($generalSettings->show_home_link == 1): ?>
                            <a href="javascript:void(0)" class="btn btn-sm btn-danger btn-nav-edit btn-show-hide-home"><?= trans("hide"); ?></a>
                        <?php else: ?>
                            <a href="javascript:void(0)" class="btn btn-sm btn-success btn-nav-edit btn-show-hide-home"><?= trans("show"); ?></a>
                        <?php endif; ?>
                        <div class="panel-heading"><h4 class="panel-title"><span><?= trans("home"); ?></span></h4></div>
                    </div>
                    <?php if (!empty($menuLinks)):
                        foreach ($menuLinks as $menuItem):
                            if ($menuItem->item_location == 'main' && $menuItem->item_parent_id == 0):
                                $subLinks = getSubMenuLinks($menuLinks, $menuItem->item_id, $menuItem->item_type); ?>
                                <div id="nav_item_<?= $menuItem->item_type . '_' . $menuItem->item_id; ?>" class="panel panel-default nav-item" data-item-id="<?= $menuItem->item_id; ?>" data-item-type="<?= $menuItem->item_type; ?>" data-have-subs-items="<?= !empty($subLinks) ? '1' : '0'; ?>">
                                    <a href="<?= getAdminNavItemEditLink($menuItem); ?>" class="btn btn-sm btn-secondary btn-nav-edit"><i class="fa fa-edit"></i></a>
                                    <a href="javascript:void(0)" onclick="<?= getAdminNavItemDeleteFunction($menuItem); ?>" class="btn btn-sm btn-danger btn-nav-edit btn-nav-delete"><i class="fa fa-trash"></i></a>
                                    <div class="panel-heading" data-toggle="collapse" href="#collapse_<?= $menuItem->item_type; ?>_<?= $menuItem->item_id; ?>">
                                        <h4 class="panel-title">
                                            <i class="fa fa-plus"></i>
                                            <span><?= $menuItem->item_name; ?><em>(<?= getAdminNavItemType($menuItem); ?>)</em></span>
                                        </h4>
                                    </div>
                                    <div id="collapse_<?= $menuItem->item_type; ?>_<?= $menuItem->item_id; ?>" class="panel-collapse collapse">
                                        <div class="panel-body nested-sortable panel-body-sublinks" data-parent-id="<?= $menuItem->item_id; ?>" data-item-type="<?= $menuItem->item_type; ?>">
                                            <?php if (!empty($subLinks)):
                                                foreach ($subLinks as $subLink): ?>
                                                    <div id="nav_item_<?= $subLink->item_type . '_' . $subLink->item_id; ?>" class="list-group-item nav-item" data-item-id="<?= $subLink->item_id; ?>" data-item-type="<?= $subLink->item_type; ?>">
                                                        <?= $subLink->item_name; ?>
                                                        <a href="<?= getAdminNavItemEditLink($subLink); ?>" class="btn btn-sm btn-secondary btn-nav-edit"><i class="fa fa-edit"></i></a>
                                                        <a href="javascript:void(0)" onclick="<?= getAdminNavItemDeleteFunction($subLink); ?>" class="btn btn-sm btn-danger btn-nav-edit btn-nav-delete"><i class="fa fa-trash"></i></a>
                                                    </div>
                                                <?php endforeach;
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
        <div class="alert alert-danger alert-large">
            <strong><?= trans("warning"); ?>!</strong>&nbsp;&nbsp;<?= trans("nav_drag_warning"); ?>
        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= trans("add_link"); ?></h3>
                    </div>
                    <form action="<?= base_url('AdminController/addMenuLinkPost'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="lang_id" value="<?= $selectedLang; ?>">
                        <div class="box-body">
                            <div class="form-group">
                                <label><?= trans("title"); ?></label>
                                <input type="text" class="form-control" name="title" placeholder="<?= trans("title"); ?>" value="<?= old('title'); ?>" maxlength="200" required>
                            </div>
                            <div class="form-group">
                                <label><?= trans("link"); ?></label>
                                <input type="text" class="form-control" name="link" placeholder="<?= trans("link"); ?>" value="<?= old('link'); ?>">
                            </div>
                            <div class="form-group">
                                <label><?= trans('order'); ?></label>
                                <input type="number" class="form-control" name="page_order" placeholder="<?= trans('order'); ?>" value="1" min="1">
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?= trans('parent_link'); ?></label>
                                <select id="parent_links" name="parent_id" class="form-control">
                                    <option value="0"><?= trans('none'); ?></option>
                                    <?php if (!empty($menuLinks)):
                                        foreach ($menuLinks as $item):
                                            if ($item->item_type != "category" && $item->item_location == "main" && $item->item_parent_id == "0"): ?>
                                                <option value="<?= $item->item_id; ?>"><?= $item->item_name; ?></option>
                                            <?php endif;
                                        endforeach;
                                    endif; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4 col-xs-12">
                                        <label><?= trans('show_on_menu'); ?></label>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-xs-12 col-option">
                                        <input type="radio" id="rb_show_on_menu_1" name="visibility" value="1" class="square-purple" checked>
                                        <label for="rb_show_on_menu_1" class="cursor-pointer"><?= trans('yes'); ?></label>
                                    </div>
                                    <div class="col-md-3 col-sm-4 col-xs-12 col-option">
                                        <input type="radio" id="rb_show_on_menu_2" name="visibility" value="0" class="square-purple">
                                        <label for="rb_show_on_menu_2" class="cursor-pointer"><?= trans('no'); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right"><?= trans('add_link'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= trans("menu_limit"); ?></h3>
                    </div>
                    <form action="<?= base_url('AdminController/menuLimitPost'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="box-body">
                            <div class="form-group">
                                <label><?= trans('menu_limit'); ?>(<?= trans("number_of_links_in_menu"); ?>)</label>
                                <input type="number" class="form-control" name="menu_limit" placeholder="<?= trans('menu_limit'); ?>" value="<?= $generalSettings->menu_limit; ?>" min="1" max="100" required>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                        </div>
                    </form>
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
                        text: '<?= trans("invalid"); ?>',
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
                    addCsrf(data);
                    $.ajax({
                        type: "POST",
                        url: VrConfig.baseURL + "/AdminController/sortMenuItems",
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
            $(this).text("<?= trans("show"); ?>");
        } else {
            $(this).removeClass('btn-success');
            $(this).addClass('btn-danger');
            $(this).text("<?= trans("hide"); ?>");
        }
        var data = {};
        addCsrf(data);
        $.ajax({
            type: "POST",
            url: VrConfig.baseURL + "/AdminController/hideShowHomeLink",
            data: data,
            success: function (response) {
            }
        });
    });
</script>


