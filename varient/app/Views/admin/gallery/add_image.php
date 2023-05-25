<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans("add_image"); ?></h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl('gallery-images'); ?>" class="btn btn-success btn-add-new"><i class="fa fa-bars"></i><?= trans("images"); ?></a>
                </div>
            </div>
            <form action="<?= base_url('GalleryController/addImagePost'); ?>" enctype="multipart/form-data" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label><?= trans("language"); ?></label>
                        <select name="lang_id" class="form-control" onchange="getAlbumsByLang(this.value);">
                            <?php foreach ($activeLanguages as $language): ?>
                                <option value="<?= $language->id; ?>" <?= $activeLang->id == $language->id ? 'selected' : ''; ?>><?= esc($language->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><?= trans("album"); ?></label>
                        <select name="album_id" id="albums" class="form-control" required onchange="getCategoriesByAlbum(this.value);">
                            <option value=""><?= trans('select'); ?></option>
                            <?php if (!empty($albums)):
                                foreach ($albums as $album): ?>
                                    <option value="<?= $album->id; ?>"><?= esc($album->name); ?></option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('category'); ?></label>
                        <select id="categories" name="category_id" class="form-control">
                            <option value=""><?= trans('select'); ?></option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('title'); ?></label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="<?= trans('title'); ?>" value="<?= old('title'); ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('image'); ?></label>
                        <div class="col-sm-12">
                            <div class="row">
                                <a class='btn btn-success btn-sm btn-file-upload'>
                                    <?= trans('select_image'); ?>
                                    <input type="file" id="Multifileupload" name="files[]" size="40" accept=".png, .jpg, .jpeg, .gif" multiple="multiple" required>
                                </a>
                                <span>(<?= trans("select_multiple_images"); ?>)</span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div id="MultidvPreview">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('add_image'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>