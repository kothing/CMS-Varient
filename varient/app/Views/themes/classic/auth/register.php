<section id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                    <li class="breadcrumb-item active"><?= trans("register"); ?></li>
                </ol>
            </div>
            <div class="col-sm-12 page-login">
                <div class="row">
                    <div class="col-sm-6 col-xs-12 login-box-cnt center-box">
                        <div class="login-box">
                            <h1 class="auth-title font-1"><?= trans("register"); ?></h1>
                            <div class="social-login">
                                <?= view("common/_social_login", ['orText' => trans("or_register_with_email")]); ?>
                            </div>

                            <?= loadView('partials/_messages'); ?>
                            <form action="<?= base_url('register-post'); ?>" method="post" id="form_validate" class="validate_terms">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="sys_lang_id" value="<?= $activeLang->id; ?>">
                                <div class="form-group">
                                    <input type="text" name="username" class="form-control form-input" placeholder="<?= trans("username"); ?>" value="<?= old("username"); ?>" required>
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control form-input" placeholder="<?= trans("email"); ?>" value="<?= old("email"); ?>" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-input" placeholder="<?= trans("password"); ?>" value="<?= old("password"); ?>" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="confirm_password" class="form-control form-input" placeholder="<?= trans("confirm_password"); ?>" value="<?= old("confirm_password"); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label class="custom-checkbox">
                                        <input type="checkbox" name="terms_conditions" value="1" class="checkbox_terms_conditions" required>
                                        <span class="checkbox-icon"><i class="icon-check"></i></span>
                                        <?= trans("terms_conditions_exp"); ?>&nbsp;<a href="<?= getPageLinkByDefaultName('terms_conditions', $activeLang->id); ?>" class="link-terms" target="_blank"><strong><?= trans("terms_conditions"); ?></strong></a>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <?php reCaptcha('generate', $generalSettings); ?>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 m-t-15">
                                        <button type="submit" class="btn btn-md btn-custom btn-block margin-top-15"><?= trans("register"); ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>