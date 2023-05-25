<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans('update_image'); ?></h3>
            </div>
            <form action="<?= base_url('GalleryController/editImagePost'); ?>" enctype="multipart/form-data" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <input type="hidden" name="id" value="<?= $image->id; ?>">
                    <input type="hidden" name="path_big" value="<?= esc($image->path_big); ?>">
                    <input type="hidden" name="path_small" value="<?= esc($image->path_small); ?>">
                    <div class="form-group">
                        <label><?= trans("language"); ?></label>
                        <select name="lang_id" class="form-control" onchange="getAlbumsByLang(this.value);">
                            <?php foreach ($activeLanguages as $language): ?>
                                <option value="<?= $language->id; ?>" <?= $image->lang_id == $language->id ? 'selected' : ''; ?>><?= esc($language->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><?= trans("album"); ?></label>
                        <select name="album_id" id="albums" class="form-control" required onchange="getCategoriesByAlbum(this.value);">
                            <option value=""><?= trans('select'); ?></option>
                            <?php if (!empty($albums)):
                                foreach ($albums as $album): ?>
                                    <option value="<?= $album->id; ?>" <?= $image->album_id == $album->id ? 'selected' : ''; ?>><?= esc($album->name); ?></option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('category'); ?></label>
                        <select id="categories" name="category_id" class="form-control">
                            <option value=""><?= trans('select'); ?></option>
                            <?php if (!empty($categories)):
                                foreach ($categories as $item):
                                    if ($item->id == $image->category_id): ?>
                                        <option value="<?= $item->id; ?>" selected><?= esc($item->name); ?></option>
                                    <?php else: ?>
                                        <option value="<?= $item->id; ?>"><?= esc($item->name); ?></option>
                                    <?php endif;
                                endforeach;
                            endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('title'); ?></label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="<?= trans('title'); ?>" value="<?= esc($image->title); ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('image'); ?> </label>
                        <div class="row">
                            <div class="col-sm-4">
                                <?php $imgBaseURL = getBaseURLByStorage($image->storage); ?>
                                <img src="<?= $imgBaseURL . esc($image->path_small); ?>" alt="" class="thumbnail img-responsive" style="max-width: 300px; max-height: 300px;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <a class='btn btn-success btn-sm btn-file-upload'>
                                    <?= trans('select_image'); ?>
                                    <input type="file" id="Multifileupload" name="file" size="40" accept=".png, .jpg, .jpeg, .gif" style="cursor: pointer;">
                                </a>
                            </div>
                        </div>
                        <div id="MultidvPreview"></div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>