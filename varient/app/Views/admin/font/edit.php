<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-5 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans("update_font"); ?></h3>
            </div>
            <form action="<?= base_url('AdminController/editFontPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" value="<?= $font->id; ?>">
                <div class="box-body">
                    <div class="form-group">
                        <label><?= trans("name"); ?></label>
                        <input type="text" class="form-control" name="font_name" value="<?= esc($font->font_name); ?>" placeholder="<?= trans("name"); ?>" maxlength="200" required>
                        <small>(E.g: Open Sans)</small>
                    </div>
                    <?php if ($font->has_local_file): ?>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label><?= trans('font_source'); ?></label>
                                </div>
                                <div class="col-sm-4 col-xs-12 col-option">
                                    <input type="radio" id="font_source_1" name="font_source" value="google" class="square-purple" <?= $font->font_source == 'google' ? 'checked' : ''; ?>>
                                    <label for="font_source_1" class="cursor-pointer">Google</label>
                                </div>
                                <div class="col-sm-4 col-xs-12 col-option">
                                    <input type="radio" id="font_source_2" name="font_source" value="local" class="square-purple" <?= $font->font_source != 'google' ? 'checked' : ''; ?>>
                                    <label for="font_source_2" class="cursor-pointer"><?= trans('local'); ?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif;
                    if ($font->font_source == 'google'):
                        if ($font->is_default != 1): ?>
                            <div class="form-group">
                                <label class="control-label"><?= trans("url"); ?> </label>
                                <textarea name="font_url" class="form-control" placeholder="<?= trans("url"); ?>" required><?= esc($font->font_url); ?></textarea>
                                <small>(E.g: <?= esc('<link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">'); ?>)</small>
                            </div>
                        <?php else: ?>
                            <input type="hidden" name="font_url" value="">
                        <?php endif; ?>
                        <div class="form-group">
                            <label class="control-label"><?= trans("font_family"); ?> </label>
                            <input type="text" class="form-control" name="font_family" value="<?= esc($font->font_family); ?>" placeholder="<?= trans("font_family"); ?>" maxlength="500" required>
                            <small>(E.g: font-family: "Open Sans", Helvetica, sans-serif)</small>
                        </div>
                    <?php else: ?>
                        <input type="hidden" name="font_url" value="<?= esc($font->font_url); ?>">
                        <input type="hidden" name="font_family" value="<?= esc($font->font_family); ?>">
                    <?php endif; ?>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans("save_changes"); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>