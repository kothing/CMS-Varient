<section id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                    <li class="breadcrumb-item active"><?= trans("reset_password"); ?></li>
                </ol>
            </div>
            <div class="col-sm-12 page-login">
                <div class="row">
                    <div class="col-sm-6 col-xs-12 login-box-cnt center-box">
                        <div class="login-box">
                            <h1 class="auth-title font-1"><?= trans("reset_password"); ?></h1>
                            <p class="p-auth-modal"><?= trans("enter_new_password"); ?></p>
                            <form action="<?= base_url('reset-password-post'); ?>" method="post" id="form_validate">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="sys_lang_id" value="<?= $activeLang->id; ?>">
                                <?= loadView('partials/_messages'); ?>
                                <?php if (!empty($user)): ?>
                                    <input type="hidden" name="token" value="<?= esc($user->token); ?>">
                                <?php endif;
                                if (!empty($passResetCompleted)): ?>
                                    <div class="form-group m-t-30">
                                        <a href="<?= langBaseUrl(); ?>" class="btn btn-md btn-custom btn-block"><?= trans("btn_goto_home"); ?></a>
                                    </div>
                                <?php else: ?>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control form-input" value="<?= old("password"); ?>" placeholder="<?= trans("new_password"); ?>" required>
                                    </div>
                                    <div class="form-group m-b-30">
                                        <input type="password" name="password_confirm" class="form-control form-input" value="<?= old("password_confirm"); ?>" placeholder="<?= trans("confirm_password"); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-md btn-custom btn-block"><?= trans("btn_submit"); ?></button>
                                    </div>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>