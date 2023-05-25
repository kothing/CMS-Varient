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
                        <form action="<?= base_url('change-password-post'); ?>" method="post" class="needs-validation">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="back_url" value="<?= currentFullURL(); ?>">
                            <?php if (!empty(user()->password)): ?>
                                <div class="mb-3">
                                    <label class="form-label"><?= trans("old_password"); ?></label>
                                    <input type="password" name="old_password" class="form-control form-input" value="<?= old("old_password"); ?>" placeholder="<?= trans("old_password"); ?>" required>
                                </div>
                            <?php endif; ?>
                            <div class="mb-3">
                                <label class="form-label"><?= trans("password"); ?></label>
                                <input type="password" name="password" class="form-control form-input" value="<?= old("password"); ?>" placeholder="<?= trans("password"); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><?= trans("confirm_password"); ?></label>
                                <input type="password" name="password_confirm" class="form-control form-input" value="<?= old("password_confirm"); ?>" placeholder="<?= trans("confirm_password"); ?>" required>
                            </div>
                            <button type="submit" class="btn btn-md btn-custom"><?= trans("change_password") ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>