<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-7 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans('cache_system'); ?></h3>
            </div>
            <form action="<?= base_url('AdminController/cacheSystemPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-5 col-xs-12">
                                <label><?= trans('cache_system'); ?></label>
                            </div>
                            <div class="col-md-3 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="cache_system" value="1" id="cache_system_1" class="square-purple" <?= $generalSettings->cache_system == 1 ? 'checked' : ''; ?>>
                                <label for="cache_system_1" class="option-label"><?= trans('enable'); ?></label>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="cache_system" value="0" id="cache_system_2" class="square-purple" <?= $generalSettings->cache_system != 1 ? 'checked' : ''; ?>>
                                <label for="cache_system_2" class="option-label"><?= trans('disable'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-5 col-xs-12">
                                <label><?= trans('refresh_cache_database_changes'); ?></label>
                            </div>
                            <div class="col-md-3 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="refresh_cache_database_changes" value="1" id="refresh_cache_database_changes_1" class="square-purple" <?= $generalSettings->refresh_cache_database_changes == 1 ? 'checked' : ''; ?>>
                                <label for="refresh_cache_database_changes_1" class="option-label"><?= trans('yes'); ?></label>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="refresh_cache_database_changes" value="0" id="refresh_cache_database_changes_2" class="square-purple" <?= $generalSettings->refresh_cache_database_changes != 1 ? 'checked' : ''; ?>>
                                <label for="refresh_cache_database_changes_2" class="option-label"><?= trans('no'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= trans('cache_refresh_time'); ?></label>&nbsp;
                        <small>(<?= trans("cache_refresh_time_exp"); ?>)</small>
                        <input type="number" class="form-control" name="cache_refresh_time" placeholder="<?= trans('cache_refresh_time'); ?>" value="<?= ($generalSettings->cache_refresh_time / 60); ?>">
                    </div>

                    <div class="box-footer" style="padding-left: 0; padding-right: 0;">
                        <button type="submit" name="action" value="save" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                        <button type="submit" name="action" value="reset" class="btn btn-warning pull-right m-r-10"><?= trans('reset_cache'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>