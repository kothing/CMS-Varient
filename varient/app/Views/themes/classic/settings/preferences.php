<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?= generateURL('settings'); ?>"><?= trans("settings"); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= esc($title); ?></li>
                    </ol>
                </nav>
                <h1 class="page-title"><?= trans("settings"); ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-3">
                <div class="row-custom">
                    <?= loadView("settings/_setting_tabs"); ?>
                </div>
            </div>
            <div class="col-sm-12 col-md-9">
                <div class="row-custom">
                    <div class="profile-tab-content">
                        <?= loadView('partials/_messages'); ?>
                        <form action="<?= base_url('preferences-post'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="back_url" value="<?= currentFullURL(); ?>">
                            <?php if ($generalSettings->show_user_email_on_profile == 1): ?>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label><?= trans('show_email_on_profile'); ?></label>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-option">
                                            <label class="custom-checkbox custom-radio">
                                                <input type="radio" name="show_email_on_profile" value="1" <?= user()->show_email_on_profile == 1 ? 'checked' : ''; ?> required>
                                                <span class="checkbox-icon"><i class="icon-check"></i></span>
                                                <span><?= trans("yes"); ?></span>
                                            </label>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-option">
                                            <label class="custom-checkbox custom-radio">
                                                <input type="radio" name="show_email_on_profile" value="0" <?= user()->show_email_on_profile == 0 ? 'checked' : ''; ?> required>
                                                <span class="checkbox-icon"><i class="icon-check"></i></span>
                                                <span><?= trans("no"); ?></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label><?= trans('rss_feeds'); ?></label>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-option">
                                        <label class="custom-checkbox custom-radio">
                                            <input type="radio" name="show_rss_feeds" value="1" <?= user()->show_rss_feeds == 1 ? 'checked' : ''; ?> required>
                                            <span class="checkbox-icon"><i class="icon-check"></i></span>
                                            <span><?= trans("enable"); ?></span>
                                        </label>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-option">
                                        <label class="custom-checkbox custom-radio">
                                            <input type="radio" name="show_rss_feeds" value="0" <?= user()->show_rss_feeds == 0 ? 'checked' : ''; ?> required>
                                            <span class="checkbox-icon"><i class="icon-check"></i></span>
                                            <span><?= trans("disable"); ?></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="submit" value="update" class="btn btn-md btn-custom"><?= trans("save_changes") ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>