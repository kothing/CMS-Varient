<section class="section section-page">
    <div class="container-xl">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                    <li class="breadcrumb-item active"><?= trans("register"); ?></li>
                </ol>
            </nav>
            <div class="col-12">
                <div class="display-flex align-items-center justify-content-center">
                    <div class="section-account">
                        <div class="title">
                            <h1 class="page-title"><?= trans("register"); ?></h1>
                        </div>
                        <div class="social-login">
                            <?= view("common/_social_login", ['orText' => trans("or_register_with_email")]); ?>
                        </div>
                        <?= loadView('partials/_messages'); ?>
                        <form action="<?= base_url('register-post'); ?>" method="post" class="needs-validation">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="sys_lang_id" value="<?= $activeLang->id; ?>">
                            <div class="mb-2">
                                <input type="text" name="username" class="form-control form-input input-account" placeholder="<?= trans("username"); ?>" value="<?= old("username"); ?>" required autocomplete="off">
                            </div>
                            <div class="mb-2">
                                <input type="email" name="email" class="form-control form-input input-account" placeholder="<?= trans("email"); ?>" value="<?= old("email"); ?>" required>
                            </div>
                            <div class="mb-2">
                                <input type="password" name="password" class="form-control form-input input-account" placeholder="<?= trans("password"); ?>" value="<?= old("password"); ?>" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="confirm_password" class="form-control form-input input-account" placeholder="<?= trans("confirm_password"); ?>" value="<?= old("confirm_password"); ?>" required>
                            </div>
                            <div class="<?= isRecaptchaEnabled($generalSettings) ? 'mb-3' : 'mb-4'; ?> form-check">
                                <input type="checkbox" class="form-check-input" name="terms_conditions" value="1" id="checkboxContactTerms" required>
                                <label class="form-check-label" for="checkboxContactTerms">
                                    <?= trans("terms_conditions_exp"); ?>&nbsp;<a href="<?= getPageLinkByDefaultName('terms_conditions', $activeLang->id); ?>" class="font-weight-600" target="_blank"><strong><?= trans("terms_conditions"); ?></strong></a>
                                </label>
                            </div>
                            <?php if (isRecaptchaEnabled($generalSettings)): ?>
                                <div class="mb-4 display-flex justify-content-center">
                                    <?php reCaptcha('generate', $generalSettings); ?>
                                </div>
                            <?php endif; ?>
                            <div class="row">
                                <div class="col-sm-12 m-t-15">
                                    <button type="submit" class="btn btn-custom btn-account"><?= trans("register"); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>