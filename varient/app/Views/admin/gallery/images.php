<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= trans("images"); ?></h3>
        </div>
        <div class="right">
            <a href="<?= adminUrl('gallery-add-image'); ?>" class="btn btn-success btn-add-new"><i class="fa fa-plus"></i><?= trans("add_image"); ?></a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <?= view('admin/gallery/_filter'); ?>
                        <thead>
                        <tr role="row">
                            <th width="20"><?= trans('id'); ?></th>
                            <th><?= trans('image'); ?></th>
                            <th><?= trans('title'); ?></th>
                            <th><?= trans('language'); ?></th>
                            <th><?= trans('album'); ?></th>
                            <th><?= trans('category'); ?></th>
                            <th><?= trans('date'); ?></th>
                            <th><?= trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($images)):
                            foreach ($images as $item):
                                $imgBaseURL = getBaseURLByStorage($item->storage); ?>
                                <tr>
                                    <td><?= esc($item->id); ?></td>
                                    <td>
                                        <div style="position: relative; height: 105px; overflow: hidden">
                                            <img src="<?= $imgBaseURL . esc($item->path_small); ?>" alt="" class="img-responsive" style="max-width: 140px; max-height: 105px;">
                                            <?php if ($item->is_album_cover): ?>
                                                <label class="label label-success" style="position: absolute;left: 0;top: 0;"><?= trans("album_cover"); ?></label>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td><?= esc($item->title); ?></td>
                                    <td>
                                        <?php $lang = getLanguage($item->lang_id);
                                        if (!empty($lang)) {
                                            echo esc($lang->name);
                                        } ?>
                                    </td>
                                    <td>
                                        <?php $album = getGalleryAlbum($item->album_id);
                                        if (!empty($album)) {
                                            echo esc($album->name);
                                        } ?>
                                    </td>
                                    <td>
                                        <?php $category = getGalleryCategory($item->category_id);
                                        if (!empty($category)) {
                                            echo esc($category->name);
                                        } ?>
                                    </td>
                                    <td class="nowrap"><?= formatDate($item->created_at); ?></td>
                                    <td class="td-select-option">
                                        <div class="dropdown">
                                            <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_an_option'); ?>&nbsp;&nbsp;<span class="caret"></span></button>
                                            <ul class="dropdown-menu options-dropdown">
                                                <?php if ($item->is_album_cover == 0): ?>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="setAsAlbumCover('<?= $item->id; ?>');"><i class="fa fa-check option-icon"></i><?= trans('set_as_album_cover'); ?></a>
                                                    </li>
                                                <?php endif; ?>
                                                <li>
                                                    <a href="<?= adminUrl('edit-gallery-image/' . $item->id); ?>"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" onclick="deleteItem('GalleryController/deleteImagePost','<?= $item->id; ?>','<?= clrQuotes(trans("confirm_image")); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a>
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
            <div class="col-sm-12 text-right">
                <?= view('common/_pagination'); ?>
            </div>
        </div>
    </div>
</div>