<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans('widgets'); ?></h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl('add-widget'); ?>" class="btn btn-success btn-add-new"><i class="fa fa-plus"></i><?= trans('add_widget'); ?></a>
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
                                    <th><?= trans('where_to_display'); ?></th>
                                    <th><?= trans('order_1'); ?></th>
                                    <th><?= trans('type'); ?></th>
                                    <th><?= trans('visibility'); ?></th>
                                    <th><?= trans('date_added'); ?></th>
                                    <th><?= trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($widgets)):
                                    foreach ($widgets as $item): ?>
                                        <tr>
                                            <td><?= esc($item->id); ?></td>
                                            <td class="break-word"><?= esc($item->title); ?></td>
                                            <td>
                                                <?php $lang = getLanguage($item->lang_id);
                                                if (!empty($lang)) {
                                                    echo esc($lang->name);
                                                } ?>
                                            </td>
                                            <td>
                                                <?php if (empty($item->display_category_id)):
                                                    $translation = getTransByLabel('latest_posts', $item->lang_id);
                                                    if (!empty($translation)) {
                                                        echo $translation->translation;
                                                    } else {
                                                        echo trans('latest_posts');
                                                    }
                                                else:
                                                    $category = getCategoryById($item->display_category_id);
                                                    if (!empty($category)):
                                                        echo esc($category->name) . '&nbsp;(<small class="text-muted">' . trans("category") . '</small>)';
                                                    endif;
                                                endif; ?>
                                            </td>
                                            <td><?= esc($item->widget_order); ?></td>
                                            <td>
                                                <?php if ($item->is_custom == 1): ?>
                                                    <label class="label bg-teal"><?= trans('custom'); ?></label>
                                                <?php else: ?>
                                                    <label class="label label-default"><?= trans('default'); ?></label>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($item->visibility == 1): ?>
                                                    <label class="label label-success"><i class="fa fa-eye"></i></label>
                                                <?php else: ?>
                                                    <label class="label label-danger"><i class="fa fa-eye"></i></label>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= formatDate($item->created_at); ?></td>
                                            <td style="width: 180px;">
                                                <div class="dropdown">
                                                    <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_an_option'); ?>
                                                        <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu options-dropdown">
                                                        <li>
                                                            <a href="<?= adminUrl('edit-widget/' . $item->id); ?>"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0)" onclick="deleteItem('AdminController/deleteWidgetPost','<?= $item->id; ?>','<?= clrQuotes(trans("confirm_widget")); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a>
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