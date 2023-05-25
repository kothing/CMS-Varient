<section id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                    <li class="breadcrumb-item active"><?= trans("forgot_password"); ?></li>
                </ol>
            </div>
            <div class="col-sm-12 page-login">
                <div class="row">
                    <div class="col-sm-6 col-xs-12 login-box-cnt center-box">
                        <div class="login-box">
                            <h1 class="auth-title font-1"><?= trans("forgot_password"); ?></h1>
                            <p class="p-auth-modal"><?= trans("enter_email_address"); ?></p>
                            <form action="<?= base_url('forgot-password-post'); ?>" method="post" id="form_validate">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="sys_lang_id" value="<?= $activeLang->id; ?>">
                                <?= loadView('partials/_messages'); ?>
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control form-input" placeholder="<?= trans("email"); ?>" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-md btn-custom btn-block"><?= trans("reset_password"); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>