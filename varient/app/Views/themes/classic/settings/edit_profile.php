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
                    <?= loadView('settings/_setting_tabs'); ?>
                </div>
            </div>
            <div class="col-sm-12 col-md-9">
                <div class="row-custom">
                    <div class="profile-tab-content">
                        <?= loadView('partials/_messages'); ?>
                        <form action="<?= base_url('edit-profile-post'); ?>" method="post" enctype="multipart/form-data" id="form_validate">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="back_url" value="<?= currentFullURL(); ?>">
                            <div class="form-group">
                                <p><img src="<?= getUserAvatar(user()->avatar); ?>" alt="<?= esc(user()->username); ?>" class="form-avatar"></p>
                                <p>
                                    <a class='btn btn-md btn-success btn-file-upload btn-profile-file-upload'>
                                        <?= trans('select_image'); ?>
                                        <input type="file" name="file" size="40" accept=".png, .jpg, .jpeg, .gif" onchange="$('#upload-file-info').html($(this).val().replace(/.*[\/\\]/, ''));">
                                    </a>
                                    <span class='badge badge-info badge-profile-file-upload' id="upload-file-info"></span>
                                </p>
                            </div>
                            <div class="form-group m-t-30">
                                <label><?= trans("email"); ?></label>
                                <?php if ($generalSettings->email_verification == 1):
                                    if (user()->email_status == 1): ?>
                                        &nbsp;<small class="text-success">(<?= trans("confirmed"); ?>)</small>
                                    <?php else: ?>
                                        &nbsp;<small class="text-danger">(<?= trans("unconfirmed"); ?>)</small>
                                        <button type="submit" name="submit" value="resend_activation_email" class="btn btn-secondary btn-xs float-left"><?= trans("resend_activation_email"); ?></button>
                                    <?php endif;
                                endif; ?>
                                <input type="email" name="email" class="form-control form-input" value="<?= esc(user()->email); ?>" placeholder="<?= trans("email"); ?>" required>
                            </div>
                            <div class="form-group">
                                <label><?= trans("username"); ?></label>
                                <input type="text" name="username" class="form-control form-input" value="<?= esc(user()->username); ?>" placeholder="<?= trans("username"); ?>" required>
                            </div>
                            <div class="form-group">
                                <label><?= trans("slug"); ?></label>
                                <input type="text" name="slug" class="form-control form-input" value="<?= esc(user()->slug); ?>" placeholder="<?= trans("slug"); ?>" required>
                            </div>
                            <div class="form-group">
                                <label><?= trans("about_me"); ?></label>
                                <textarea name="about_me" class="form-control form-textarea" placeholder="<?= trans("about_me"); ?>"><?= esc(user()->about_me); ?></textarea>
                            </div>
                            <button type="submit" name="submit" value="update" class="btn btn-md btn-custom"><?= trans("save_changes") ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>