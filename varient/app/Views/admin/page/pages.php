<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= trans("pages"); ?></h3>
        </div>
        <div class="right">
            <a href="<?= adminUrl('add-page'); ?>" class="btn btn-success btn-add-new"><i class="fa fa-plus"></i><?= trans("add_page"); ?></a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped dataTable" id="cs_datatable_lang" role="grid" aria-describedby="example1_info">
                        <thead>
                        <tr role="row">
                            <th width="20"><?= trans('id'); ?></th>
                            <th><?= trans('title'); ?></th>
                            <th><?= trans('language'); ?></th>
                            <th><?= trans('location'); ?></th>
                            <th><?= trans('visibility'); ?></th>
                            <th><?= trans('page_type'); ?></th>
                            <th><?= trans('date_added'); ?></th>
                            <th class="max-width-120"><?= trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($pages)):
                            foreach ($pages as $item): ?>
                                <?php if ($item->page_type != "link"): ?>
                                    <tr>
                                        <td><?= esc($item->id); ?></td>
                                        <td><?= esc($item->title); ?></td>
                                        <td>
                                            <?php if ($item->slug == "posts" || $item->slug == "register" || $item->slug == "login" || $item->slug == "login" || $item->slug == "reset-password" || $item->slug == "change-password" || $item->slug == "profile-update" || $item->slug == "rss-feeds" || $item->slug == "reading-list") {
                                                echo trans("shared");
                                            } else {
                                                $lang = getLanguage($item->lang_id);
                                                if (!empty($lang)) {
                                                    echo esc($lang->name);
                                                }
                                            } ?>
                                        </td>
                                        <td>
                                            <?php if (esc($item->location) == "top") {
                                                echo trans('top_menu');
                                            } elseif (esc($item->location) == "main") {
                                                echo trans('main_menu');
                                            } elseif (esc($item->location) == "footer") {
                                                echo trans('footer');
                                            } else {
                                                echo "-";
                                            } ?>
                                        </td>
                                        <td>
                                            <?php if ($item->visibility == 1): ?>
                                                <label class="label label-success"><i class="fa fa-eye"></i></label>
                                            <?php else: ?>
                                                <label class="label label-danger"><i class="fa fa-eye"></i></label>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($item->is_custom == 1): ?>
                                                <label class="label bg-teal"><?= trans('custom'); ?></label>
                                            <?php else: ?>
                                                <label class="label label-default"><?= trans('default'); ?></label>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= formatDate($item->created_at); ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_an_option'); ?>
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu options-dropdown">
                                                    <li>
                                                        <a href="<?= adminUrl('edit-page/' . esc($item->id)); ?>"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick='deleteItem("AdminController/deletePagePost","<?= $item->id; ?>","<?= trans("confirm_page"); ?>");'><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach;
                        endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>