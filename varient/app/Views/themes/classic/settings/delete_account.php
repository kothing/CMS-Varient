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
                        <form action="<?= base_url('delete-account-post'); ?>" method="post" enctype="multipart/form-data" id="form_validate" class="validate_terms">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="back_url" value="<?= currentFullURL(); ?>">
                            <div class="form-group">
                                <label><?= trans("password"); ?></label>
                                <input type="password" name="password" class="form-control form-input" value="<?= old("password"); ?>" placeholder="<?= trans("password"); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="custom-checkbox">
                                    <input type="checkbox" name="confirm" class="checkbox_terms_conditions" required>
                                    <span class="checkbox-icon"><i class="icon-check"></i></span>
                                    <?= trans("delete_account_confirm"); ?></a>
                                </label>
                            </div>
                            <button type="submit" class="btn btn-md btn-custom"><?= trans("delete_account") ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>