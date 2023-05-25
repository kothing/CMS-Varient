<section class="section section-page">
    <div class="container-xl">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                    <li class="breadcrumb-item active"><?= trans("reset_password"); ?></li>
                </ol>
            </nav>
            <div class="col-12">
                <div class="display-flex align-items-center justify-content-center">
                    <div class="section-account">
                        <div class="title">
                            <h1 class="page-title"><?= trans("reset_password"); ?></h1>
                        </div>
                        <?php if (empty($passResetCompleted)): ?>
                            <p class="display-block text-center text-muted mb-2"><?= trans("enter_new_password"); ?></p>
                        <?php endif; ?>
                        <?= loadView('partials/_messages'); ?>
                        <form action="<?= base_url('reset-password-post'); ?>" method="post" class="needs-validation">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="sys_lang_id" value="<?= $activeLang->id; ?>">
                            <?php if (!empty($user)): ?>
                                <input type="hidden" name="token" value="<?= esc($user->token); ?>">
                            <?php endif;
                            if (!empty($passResetCompleted)): ?>
                                <div class="mt-3">
                                    <a href="<?= langBaseUrl(); ?>" class="btn btn-custom btn-account"><?= trans("btn_goto_home"); ?></a>
                                </div>
                            <?php else: ?>
                                <div class="mb-3">
                                    <input type="password" name="password" class="form-control form-input" value="<?= old("password"); ?>" placeholder="<?= trans("new_password"); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <input type="password" name="password_confirm" class="form-control form-input" value="<?= old("password_confirm"); ?>" placeholder="<?= trans("confirm_password"); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-custom btn-account"><?= trans("btn_submit"); ?></button>
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>