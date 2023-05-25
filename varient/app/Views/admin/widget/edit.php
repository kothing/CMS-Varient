<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-8 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans('update_widget'); ?></h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl('widgets'); ?>" class="btn btn-success btn-add-new"><i class="fa fa-bars"></i><?= trans('widgets'); ?></a>
                </div>
            </div>
            <form action="<?= base_url('AdminController/editWidgetPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" value="<?= esc($widget->id); ?>">
                <input type="hidden" name="type" value="<?= esc($widget->type); ?>">
                <input type="hidden" name="back_url" value="<?= currentFullURL(); ?>">

                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label"><?= trans('title'); ?></label>
                        <input type="text" class="form-control" name="title" placeholder="<?= trans('title'); ?>" value="<?= esc($widget->title); ?>">
                    </div>

                    <div class="form-group">
                        <label><?= trans("language"); ?></label>
                        <select name="lang_id" class="form-control max-600" onchange="showCatsByLang(this.value);">
                            <?php $latestPostsTrans = array();
                            foreach ($activeLanguages as $language):
                                $trans = getTransByLabel('latest_posts', $language->id);
                                if (!empty($trans)) {
                                    $latestPostsTrans[$language->id] = $trans->translation;
                                } else {
                                    $latestPostsTrans[$language->id] = trans('latest_posts');
                                } ?>
                                <option value="<?= $language->id; ?>" <?= $widget->lang_id == $language->id ? 'selected' : ''; ?>><?= $language->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('order_1'); ?></label>
                        <input type="number" class="form-control max-600" name="widget_order" min="1" max="3000" placeholder="<?= trans('order_1'); ?>" value="<?= $widget->widget_order; ?>" required>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label><?= trans('visibility'); ?></label>
                            </div>
                            <div class="col-xs-12 col-sm-3 col-option">
                                <input type="radio" id="rb_visibility_1" name="visibility" value="1" class="square-purple" <?= $widget->visibility == 1 ? 'checked' : ''; ?>>
                                <label for="rb_visibility_1" class="cursor-pointer"><?= trans('show'); ?></label>
                            </div>
                            <div class="col-xs-12 col-sm-3 col-option">
                                <input type="radio" id="rb_visibility_2" name="visibility" value="0" class="square-purple" <?= $widget->visibility == 0 ? 'checked' : ''; ?>>
                                <label for="rb_visibility_2" class="cursor-pointer"><?= trans('hide'); ?></label>
                            </div>
                        </div>
                    </div>

                    <?php if ($activeTheme->theme != 'classic'): ?>
                        <div class="form-group">
                            <label class="m-b-10"><?= trans('where_to_display'); ?></label>
                            <div class="row">
                                <div class="col-sm-12 m-b-5">
                                    <input type="radio" id="radio_category_latest_posts" name="display_category_id" value="latest_posts" class="square-purple" <?= empty($widget->display_category_id) ? 'checked' : ''; ?> required>
                                    <label id="label_latest_posts" for="radio_category_latest_posts" class="cursor-pointer" style="font-weight: 400 !important; margin-left: 5px;"><?= !empty($latestPostsTrans[$widget->lang_id]) ? $latestPostsTrans[$widget->lang_id] : trans('latest_posts'); ?></label>
                                </div>
                                <?php if (!empty($categories)):
                                    foreach ($categories as $category):
                                        if ($category->block_type == 'block-2' || $category->block_type == 'block-3' || $category->block_type == 'block-4'):?>
                                            <div class="col-sm-12 m-b-5 category-row category-lang-<?= $category->lang_id; ?><?= $widget->lang_id != $category->lang_id ? ' hide' : ''; ?>" required>
                                                <input type="radio" id="radio_category_<?= $category->id; ?>" name="display_category_id" value="<?= $category->id; ?>" class="square-purple" <?= $widget->display_category_id == $category->id ? 'checked' : ''; ?>>
                                                <label for="radio_category_<?= $category->id; ?>" class="cursor-pointer" style="font-weight: 400 !important; margin-left: 5px;"><?= esc($category->name); ?>&nbsp;(<small><?= trans("category"); ?></small>)</label>
                                            </div>
                                        <?php endif;
                                    endforeach;
                                endif; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <input type="hidden" name="display_category_id" value="<?= $widget->display_category_id; ?>">
                    <?php endif; ?>

                    <?php if ($widget->is_custom == 1): ?>
                        <div class="form-group">
                            <div id="main_editor">
                                <label><?= trans('content'); ?></label>
                                <div class="row">
                                    <div class="col-sm-12 editor-buttons">
                                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#file_manager_image" data-image-type="editor"><i class="fa fa-image"></i>&nbsp;&nbsp;&nbsp;<?= trans("add_image"); ?></button>
                                    </div>
                                </div>
                                <textarea class="tinyMCE form-control" name="content"><?= $widget->content; ?></textarea>
                            </div>
                        </div>
                    <?php else: ?>
                        <input type="hidden" value="" name="content">
                    <?php endif; ?>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var arrayTrans = JSON.parse('<?= json_encode($latestPostsTrans); ?>');

    function showCatsByLang(langId) {
        $('.category-row').addClass('hide');
        $('.category-lang-' + langId).removeClass('hide');
        $('#label_latest_posts').html(arrayTrans[langId]);
        $('input[name="display_category_id"]').iCheck('uncheck');
    }
</script>

<?= view('admin/file-manager/_load_file_manager', ['loadImages' => true, 'loadFiles' => false, 'loadVideos' => false, 'loadAudios' => false]); ?>