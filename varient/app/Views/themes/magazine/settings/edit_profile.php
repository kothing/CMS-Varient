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
                        <form action="<?= base_url('edit-profile-post'); ?>" method="post" enctype="multipart/form-data" class="needs-validation">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="back_url" value="<?= currentFullURL(); ?>">
                            <div id="edit_profile_cover" class="edit-profile-cover edit-cover-no-image">
                                <div class="edit-avatar">
                                    <a class="btn btn-md btn-custom btn-file-upload">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                            <path d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z"/>
                                        </svg>
                                        <input type="file" name="file" size="40" accept=".png, .jpg, .jpeg, .gif" data-img-id="img_preview_avatar" onchange="showImagePreview(this);">
                                    </a>
                                    <img src="<?= getUserAvatar(user()->avatar); ?>" alt="<?= esc(user()->username); ?>" id="img_preview_avatar" class="img-thumbnail" width="180" height="180">
                                </div>
                                <a class="btn btn-md btn-custom btn-file-upload btn-edit-cover">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-camera-fill" viewBox="0 0 16 16">
                                        <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                        <path d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z"/>
                                    </svg>
                                    <input type="file" name="image_cover" size="40" accept=".png, .jpg, .jpeg, .gif" data-img-id="edit_profile_cover" onchange="showImagePreview(this, true);">
                                </a>
                            </div>
                            <?php if (!empty(user()->cover_image)): ?><style>#edit_profile_cover {background-image: url('<?= base_url((user()->cover_image)); ?>');}</style><?php endif; ?>
                            <p class="mb-5"><small class="text-muted">*<?= trans("warning_edit_profile_image"); ?></small></p>
                            <div class="mb-3">
                                <label class="form-label"><?= trans("email"); ?></label>
                                <?php if ($generalSettings->email_verification == 1):
                                    if (user()->email_status == 1): ?>
                                        &nbsp;<small class="text-success">(<?= trans("confirmed"); ?>)</small>
                                    <?php else: ?>
                                        &nbsp;<small class="text-danger">(<?= trans("unconfirmed"); ?>)</small>
                                        <button type="submit" name="submit" value="resend_activation_email" class="btn btn-sm btn-default display-inline-block mb-2"><?= trans("resend_activation_email"); ?></button>
                                    <?php endif;
                                endif; ?>
                                <input type="email" name="email" class="form-control form-input" value="<?= esc(user()->email); ?>" placeholder="<?= trans("email"); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><?= trans("username"); ?></label>
                                <input type="text" name="username" class="form-control form-input" value="<?= esc(user()->username); ?>" placeholder="<?= trans("username"); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><?= trans("slug"); ?></label>
                                <input type="text" name="slug" class="form-control form-input" value="<?= esc(user()->slug); ?>" placeholder="<?= trans("slug"); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><?= trans("about_me"); ?></label>
                                <textarea name="about_me" class="form-control form-textarea" placeholder="<?= trans("about_me"); ?>"><?= esc(user()->about_me); ?></textarea>
                            </div>
                            <button type="submit" name="submit" value="update" class="btn btn-md btn-custom"><?= trans("save_changes") ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>