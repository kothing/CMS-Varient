<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans('seo_tools'); ?></h3>
            </div>
            <form action="<?= base_url('AdminController/seoToolsPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label><?= trans("settings_language"); ?></label>
                        <select name="lang_id" class="form-control max-400" onchange="window.location.href = '<?= adminUrl(); ?>'+'/seo-tools?lang='+this.value;">
                            <?php foreach ($activeLanguages as $language): ?>
                                <option value="<?= $language->id; ?>" <?= $selectedLangId == $language->id ? 'selected' : ''; ?>><?= $language->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('site_title'); ?></label>
                        <input type="text" class="form-control" name="site_title" placeholder="<?= trans('site_title'); ?>" value="<?= esc($baseSettings->site_title); ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('home_title'); ?></label>
                        <input type="text" class="form-control" name="home_title" placeholder="<?= trans('home_title'); ?>" value="<?= esc($baseSettings->home_title); ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('site_description'); ?></label>
                        <input type="text" class="form-control" name="site_description" placeholder="<?= trans('site_description'); ?>" value="<?= esc($baseSettings->site_description); ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('keywords'); ?></label>
                        <textarea class="form-control text-area" name="keywords" placeholder="<?= trans('keywords'); ?>" style="min-height: 70px;"><?= esc($baseSettings->keywords); ?></textarea>
                    </div>

                    <div class="box-footer" style="padding-left: 0; padding-right: 0;">
                        <button type="submit" name="submit" value="settings" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                    </div>
                </div>
            </form>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans('google_analytics'); ?></h3>
            </div>
            <form action="<?= base_url('AdminController/seoToolsPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label"><?= trans('google_analytics_code'); ?></label>
                        <textarea class="form-control text-area" name="google_analytics" placeholder="<?= trans('google_analytics_code'); ?>" style="min-height: 100px;"><?= $generalSettings->google_analytics; ?></textarea>
                    </div>
                    <div class="box-footer" style="padding-left: 0; padding-right: 0;">
                        <button type="submit" name="submit" value="google_analytics" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans('sitemap'); ?></h3>
            </div>
            <form action="<?= base_url('AdminController/generateSitemapPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label class="label-sitemap"><?= trans('frequency'); ?></label>
                        <small class="small-sitemap"> (<?= trans('frequency_exp'); ?>)</small>
                        <select name="frequency" class="form-control">
                            <option value="none" <?= $generalSettings->sitemap_frequency == 'none' ? 'selected' : ''; ?>><?= trans('none'); ?></option>
                            <option value="always" <?= $generalSettings->sitemap_frequency == 'always' ? 'selected' : ''; ?>><?= trans('always'); ?></option>
                            <option value="hourly" <?= $generalSettings->sitemap_frequency == 'hourly' ? 'selected' : ''; ?>><?= trans('hourly'); ?></option>
                            <option value="daily" <?= $generalSettings->sitemap_frequency == 'daily' ? 'selected' : ''; ?>><?= trans('daily'); ?></option>
                            <option value="weekly" <?= $generalSettings->sitemap_frequency == 'weekly' ? 'selected' : ''; ?>><?= trans('weekly'); ?></option>
                            <option value="monthly" <?= $generalSettings->sitemap_frequency == 'monthly' ? 'selected' : ''; ?>><?= trans('monthly'); ?></option>
                            <option value="yearly" <?= $generalSettings->sitemap_frequency == 'yearly' ? 'selected' : ''; ?>><?= trans('yearly'); ?></option>
                            <option value="never" <?= $generalSettings->sitemap_frequency == 'never' ? 'selected' : ''; ?>><?= trans('never'); ?></option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="label-sitemap"><?= trans('last_modification'); ?></label>
                        <small class="small-sitemap"> (<?= trans('last_modification_exp'); ?>)</small>
                        <p>
                            <input type="radio" name="last_modification" id="last_modification_1" value="none" class="square-purple" <?= $generalSettings->sitemap_last_modification == 'none' ? 'checked' : ''; ?>>
                            <label for="last_modification_1" class="cursor-pointer">&nbsp;<?= trans('none'); ?></label>
                        </p>
                        <p>
                            <input type="radio" name="last_modification" id="last_modification_2" value="server_response" class="square-purple" <?= $generalSettings->sitemap_last_modification == 'server_response' ? 'checked' : ''; ?>>
                            <label for="last_modification_2" class="cursor-pointer">&nbsp;<?= trans('server_response'); ?></label>
                        </p>
                    </div>

                    <div class="form-group">
                        <label class="label-sitemap"><?= trans('priority'); ?></label>
                        <small class="small-sitemap"> (<?= trans('priority_exp'); ?>)</small>
                        <p>
                            <input type="radio" name="priority" id="priority_1" value="none" class="square-purple" <?= $generalSettings->sitemap_priority == 'none' ? 'checked' : ''; ?>>
                            <label for="priority_1" class="cursor-pointer">&nbsp;<?= trans('none'); ?></label>
                        </p>
                        <p>
                            <input type="radio" name="priority" id="priority_2" value="automatically" class="square-purple" <?= $generalSettings->sitemap_priority == 'automatically' ? 'checked' : ''; ?>>
                            <label for="priority_2" class="cursor-pointer">&nbsp;<?= trans('priority_none'); ?></label>
                        </p>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('generate_sitemap'); ?></button>
                </div>
            </form>

            <?php $files = glob(FCPATH . '*.xml');
            if (!empty($files)): ?>
                <div style="padding: 20px">
                    <h3 style="font-size: 18px; font-weight: 500;"><?= trans("generated_sitemaps") ?></h3>
                    <hr>
                    <?php foreach ($files as $file):
                        if (strpos(basename($file), 'sitemap') !== false):?>
                            <div style="font-size: 16px; font-weight: 600;margin-bottom: 10px;">
                                <a href="<?= base_url(basename($file)); ?>"><?= basename($file); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                <form action="<?= base_url('download-file'); ?>" method="post" style="display: inline-block">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="file_name" value="<?= basename($file); ?>">
                                    <button type="submit" name="file_type" value="sitemap" class="btn btn-xs btn-success"><i class="fa fa-cloud-download"></i></button>
                                </form>
                                <form action="<?= base_url('AdminController/deleteSitemapPost'); ?>" method="post" style="display: inline-block">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="file_name" value="<?= basename($file); ?>">
                                    <button type="submit" name="file_type" value="sitemap" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></button>
                                </form>
                            </div>
                        <?php endif;
                    endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="alert alert-info alert-large m-t-10">
            <strong><?= trans("warning"); ?>!</strong>&nbsp;&nbsp;<?= trans("sitemap_generate_exp"); ?>
        </div>
        <div class="callout" style="margin-top: 30px;background-color: #fff; border-color:#00c0ef;max-width: 600px;">
            <h4>Cron Job</h4>
            <p><strong><?= base_url(); ?>/cron/update-sitemap</strong></p>
            <small><?= trans('msg_cron_sitemap'); ?></small>
        </div>
    </div>
</div>