<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-5 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans('add_category'); ?></h3>
            </div>
            <form action="<?= base_url('GalleryController/addCategoryPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label><?= trans("language"); ?></label>
                        <select name="lang_id" class="form-control" onchange="getAlbumsByLang(this.value);">
                            <?php foreach ($activeLanguages as $language): ?>
                                <option value="<?= $language->id; ?>" <?= $activeLang->id == $language->id ? 'selected' : ''; ?>><?= $language->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><?= trans("album"); ?></label>
                        <select name="album_id" id="albums" class="form-control" required>
                            <option value=""><?= trans('select'); ?></option>
                            <?php if (!empty($albums)):
                                foreach ($albums as $album): ?>
                                    <option value="<?= $album->id; ?>"><?= $album->name; ?></option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><?= trans('category_name'); ?></label>
                        <input type="text" class="form-control" name="name" placeholder="<?= trans('category_name'); ?>" value="<?= old('name'); ?>" maxlength="200" required>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('add_category'); ?></button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-7 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="pull-left">
                    <h3 class="box-title"><?= trans('gallery_categories'); ?></h3>
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
                                    <th><?= trans('album'); ?></th>
                                    <th><?= trans('language'); ?></th>
                                    <th><?= trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($categories)):
                                    foreach ($categories as $item): ?>
                                        <tr>
                                            <td><?= esc($item->id); ?></td>
                                            <td><?= esc($item->name); ?></td>
                                            <td>
                                                <?php $album = getGalleryAlbum($item->album_id);
                                                if (!empty($album)) {
                                                    echo esc($album->name);
                                                } ?>
                                            </td>
                                            <td>
                                                <?php $lang = getLanguage($item->lang_id);
                                                if (!empty($lang)) {
                                                    echo esc($lang->name);
                                                } ?>
                                            </td>
                                            <td class="td-select-option">
                                                <div class="dropdown">
                                                    <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_an_option'); ?>
                                                        <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu options-dropdown">
                                                        <li>
                                                            <a href="<?= adminUrl('edit-gallery-category/' . $item->id); ?>"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0)" onclick="deleteItem('GalleryController/deleteCategoryPost','<?= $item->id; ?>','<?= clrQuotes(trans("confirm_category")); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a>
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