<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-5 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans('update_category'); ?></h3>
            </div>
            <form action="<?= base_url('GalleryController/editCategoryPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" value="<?= esc($category->id); ?>">
                <div class="box-body">
                    <div class="form-group">
                        <label><?= trans("language"); ?></label>
                        <select name="lang_id" class="form-control" onchange="getAlbumsByLang(this.value);">
                            <?php foreach ($activeLanguages as $language): ?>
                                <option value="<?= $language->id; ?>" <?= $category->lang_id == $language->id ? 'selected' : ''; ?>><?= $language->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><?= trans("album"); ?></label>
                        <select name="album_id" id="albums" class="form-control" required>
                            <option value=""><?= trans('select'); ?></option>
                            <?php if (!empty($albums)):
                                foreach ($albums as $album): ?>
                                    <option value="<?= $album->id; ?>" <?= $category->album_id == $album->id ? 'selected' : ''; ?>><?= $album->name; ?></option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><?= trans('category_name'); ?></label>
                        <input type="text" class="form-control" name="name" placeholder="<?= trans('category_name'); ?>" value="<?= esc($category->name); ?>" maxlength="200" required>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>