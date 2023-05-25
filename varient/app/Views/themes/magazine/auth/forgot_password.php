<section class="section section-page">
    <div class="container-xl">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                    <li class="breadcrumb-item active"><?= trans("forgot_password"); ?></li>
                </ol>
            </nav>
            <div class="col-12">
                <div class="display-flex align-items-center justify-content-center">
                    <div class="section-account">
                        <div class="title">
                            <h1 class="page-title"><?= trans("forgot_password"); ?></h1>
                        </div>
                        <p class="display-block text-center text-muted mb-2"><?= trans("enter_email_address"); ?></p>
                        <?= loadView('partials/_messages'); ?>
                        <form action="<?= base_url('forgot-password-post'); ?>" method="post" class="needs-validation">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="sys_lang_id" value="<?= $activeLang->id; ?>">
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control form-input input-account" placeholder="<?= trans("email"); ?>" required>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-custom btn-account"><?= trans("reset_password"); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>