<section class="section section-page">
    <div class="container-xl">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                    <li class="breadcrumb-item"><a href="<?= generateURL('settings'); ?>"><?= trans("settings"); ?></a></li>
                    <li class="breadcrumb-item active"><?= esc($title); ?></li>
                </ol>
            </nav>
            <h1 class="page-title"><?= esc($title); ?></h1>
            <div class="page-content">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <?= loadView('settings/_setting_tabs'); ?>
                    </div>
                    <div class="col-sm-12 col-md-9">
                        <?= loadView('partials/_messages'); ?>
                        <form action="<?= base_url('preferences-post'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="back_url" value="<?= currentFullURL(); ?>">
                            <?php if ($generalSettings->show_user_email_on_profile == 1): ?>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-label"><?= trans('show_email_on_profile'); ?></label>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-check">
                                                <input type="radio" name="show_email_on_profile" id="formRadios1" class="form-check-input" value="1" <?= user()->show_email_on_profile == 1 ? 'checked' : ''; ?> required>
                                                <label class="form-check-label" for="formRadios1"><?= trans("yes"); ?></label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-check">
                                                <input type="radio" name="show_email_on_profile" id="formRadios2" class="form-check-input" value="0" <?= user()->show_email_on_profile != 1 ? 'checked' : ''; ?> required>
                                                <label class="form-check-label" for="formRadios2"><?= trans("no"); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-12">
                                        <label class="form-label"><?= trans('rss_feeds'); ?></label>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-check">
                                            <input type="radio" name="show_rss_feeds" id="formRadios3" class="form-check-input" value="1" <?= user()->show_rss_feeds == 1 ? 'checked' : ''; ?> required>
                                            <label class="form-check-label" for="formRadios3"><?= trans("yes"); ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-4">
                                        <div class="form-check">
                                            <input type="radio" name="show_rss_feeds" id="formRadios4" class="form-check-input" value="0" <?= user()->show_rss_feeds != 1 ? 'checked' : ''; ?> required>
                                            <label class="form-check-label" for="formRadios4"><?= trans("no"); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-md btn-custom"><?= trans("save_changes") ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>