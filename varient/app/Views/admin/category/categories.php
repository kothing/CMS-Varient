<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans("categories"); ?></h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl('add-category'); ?>?type=parent" class="btn btn-success btn-add-new"><i class="fa fa-plus"></i><?= trans("add_category"); ?></a>
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
                                    <th><?= trans('category_name'); ?></th>
                                    <th><?= trans('language'); ?></th>
                                    <th><?= trans('order_1'); ?></th>
                                    <th><?= trans('color'); ?></th>
                                    <th class="max-width-120"><?= trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($categories)):
                                    foreach ($categories as $item): ?>
                                        <tr>
                                            <td><?= esc($item->id); ?></td>
                                            <td><?= esc($item->name); ?></td>
                                            <td>
                                                <?php $lang = getLanguage($item->lang_id);
                                                if (!empty($lang)) {
                                                    echo esc($lang->name);
                                                } ?>
                                            </td>
                                            <td><?= esc($item->category_order); ?></td>
                                            <td>
                                                <div style="width: 60px; height: 30px; background-color:<?= esc($item->color); ?> ;"></div>
                                            </td>
                                            <td class="td-select-option">
                                                <div class="dropdown">
                                                    <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_an_option'); ?>
                                                        <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu options-dropdown">
                                                        <li>
                                                            <a href="<?= adminUrl('edit-category/' . $item->id); ?>"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0)" onclick="deleteItem('CategoryController/deleteCategoryPost','<?= $item->id; ?>','<?= clrQuotes(trans("confirm_category")); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>