<div class="row">
    <div class="col-sm-12 title-section">
        <h3 style="font-size: 22px; font-weight: bold"><?= trans('themes'); ?></h3>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group" style="margin-bottom: 15px;">
            <div class="switch-container">
                <label class="title"><?= trans("dark_mode"); ?></label>
                <div class="toggle">
                    <label class="toggle-control">
                        <input type="checkbox" id="checkboxSiteMode" <?= $generalSettings->theme_mode == 'dark' ? 'checked' : ''; ?>>
                        <span class="control"></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <form action="<?= base_url('AdminController/setThemePost'); ?>" method="post">
            <?= csrf_field(); ?>
            <div class="row-layout-items">
                <?php if (!empty($themes)):
                    foreach ($themes as $theme): ?>
                        <div class="layout-item <?= $theme->is_active == 1 ? 'active' : ''; ?>">
                            <button type="submit" name="theme_id" value="<?= $theme->id; ?>" class="btn btn-block">
                                <div class="image">
                                    <img src="<?= base_url('assets/img/themes/' . $theme->theme . '.jpg'); ?>" alt="" class="img-responsive">
                                </div>
                                <p><?= esc($theme->theme_name); ?></p>
                            </button>
                        </div>
                    <?php endforeach;
                endif; ?>
            </div>
        </form>
    </div>
</div>

<div class="row" style="margin-top: 60px;">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans('theme_settings'); ?></h3>
            </div>
            <form action="<?= base_url('AdminController/setThemeSettingsPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" value="<?= $activeTheme->id; ?>">
                <div class="box-body">
                    <div class="form-group">
                        <label><?= trans('site_color'); ?></label>
                        <div class="input-group my-colorpicker">
                            <input type="text" class="form-control" name="theme_color" maxlength="200" placeholder="<?= trans('color_code'); ?>" value="<?= esc($activeTheme->theme_color); ?>" required>
                            <div class="input-group-addon"><i></i></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label><?= trans('block_color'); ?></label>
                        <div class="input-group my-colorpicker">
                            <input type="text" class="form-control" name="block_color" maxlength="200" placeholder="<?= trans('color_code'); ?>" value="<?= esc($activeTheme->block_color); ?>" required>
                            <div class="input-group-addon"><i></i></div>
                        </div>
                    </div>
                    <?php if ($activeTheme->theme != 'classic'): ?>
                        <div class="form-group">
                            <label><?= trans('mega_menu_color'); ?></label>
                            <div class="input-group my-colorpicker">
                                <input type="text" class="form-control" name="mega_menu_color" maxlength="200" placeholder="<?= trans('color_code'); ?>" value="<?= esc($activeTheme->mega_menu_color); ?>" required>
                                <div class="input-group-addon"><i></i></div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<style>.row-layout-items .layout-item:last-child{margin-right: 0;}</style>
<script>
    $(document).on('change', '#checkboxSiteMode', function () {
        var themeMode = 'light';
        if ($(this).is(':checked')) {
            themeMode = 'dark';
        }
        var data = {
            'theme_mode': themeMode
        };
        addCsrf(data);
        $.ajax({
            type: 'POST',
            url: VrConfig.baseURL + '/AjaxController/setThemeModePost',
            data: data,
            success: function (response) {
            }
        });
    });
</script>