<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="row">
    <form action="<?= base_url('AdminController/emailSettingsPost'); ?>" method="post">
        <?= csrf_field(); ?>
        <div class="col-lg-6 col-md-12" style="min-height: 600px;">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= trans('email_settings'); ?></h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label"><?= trans('mail_service'); ?></label>
                        <select name="mail_service" class="form-control" onchange="window.location.href = '<?= adminUrl(); ?>/email-settings?service='+this.value+'&protocol=<?= esc($protocol); ?>';">
                            <option value="swift" <?= $service == "swift" ? "selected" : ""; ?>>Swift Mailer</option>
                            <option value="php" <?= $service == "php" ? "selected" : ""; ?>>PHP Mailer</option>
                            <option value="mailjet" <?= $service == "mailjet" ? "selected" : ""; ?>>Mailjet</option>
                        </select>
                    </div>
                    <?php if ($service == 'mailjet'): ?>
                        <div class="form-group">
                            <label class="control-label"><?= trans('api_key'); ?></label>
                            <input type="text" class="form-control" name="mailjet_api_key" placeholder="<?= trans('api_key'); ?>" value="<?= esc($generalSettings->mailjet_api_key); ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?= trans('secret_key'); ?></label>
                            <input type="text" class="form-control" name="mailjet_secret_key" placeholder="<?= trans('secret_key'); ?>" value="<?= esc($generalSettings->mailjet_secret_key); ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?= trans('mailjet_email_address'); ?>&nbsp;(<small><?= trans("mailjet_email_address_exp"); ?></small>)</label>
                            <input type="text" class="form-control" name="mailjet_email_address" placeholder="<?= trans('mailjet_email_address'); ?>" value="<?= esc($generalSettings->mailjet_email_address); ?>">
                        </div>
                        <input type="hidden" name="mail_protocol" value="<?= esc($generalSettings->mail_protocol); ?>">
                        <input type="hidden" name="mail_encryption" value="<?= esc($generalSettings->mail_encryption); ?>">
                        <input type="hidden" name="mail_host" value="<?= esc($generalSettings->mail_host); ?>">
                        <input type="hidden" name="mail_port" value="<?= esc($generalSettings->mail_port); ?>">
                        <input type="hidden" name="mail_username" value="<?= esc($generalSettings->mail_username); ?>">
                        <input type="hidden" name="mail_password" value="<?= esc($generalSettings->mail_password); ?>">
                        <input type="hidden" name="mail_reply_to" value="<?= esc($generalSettings->mail_reply_to); ?>">
                    <?php else: ?>
                        <input type="hidden" name="mailjet_api_key" value="<?= esc($generalSettings->mailjet_api_key); ?>">
                        <input type="hidden" name="mailjet_secret_key" value="<?= esc($generalSettings->mailjet_secret_key); ?>">
                        <input type="hidden" name="mailjet_email_address" value="<?= esc($generalSettings->mailjet_email_address); ?>">
                        <div class="form-group">
                            <label class="control-label"><?= trans('mail_protocol'); ?></label>
                            <select name="mail_protocol" class="form-control" onchange="window.location.href = '<?= adminUrl(); ?>/email-settings?service=<?= esc($service); ?>&protocol='+this.value;">
                                <option value="smtp" <?= $protocol == 'smtp' ? "selected" : ""; ?>><?= trans('smtp'); ?></option>
                                <option value="mail" <?= $protocol == 'mail' ? "selected" : ""; ?>><?= trans('mail'); ?></option>
                            </select>
                        </div>
                        <?php if ($protocol == 'smtp'): ?>
                            <div class="form-group">
                                <label class="control-label"><?= trans('encryption'); ?></label>
                                <select name="mail_encryption" class="form-control">
                                    <option value="tls" <?= $generalSettings->mail_encryption == "tls" ? "selected" : ""; ?>>TLS</option>
                                    <option value="ssl" <?= $generalSettings->mail_encryption == "ssl" ? "selected" : ""; ?>>SSL</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?= trans('mail_host'); ?></label>
                                <input type="text" class="form-control" name="mail_host" placeholder="<?= trans('mail_host'); ?>" value="<?= esc($generalSettings->mail_host); ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?= trans('mail_port'); ?></label>
                                <input type="text" class="form-control" name="mail_port" placeholder="<?= trans('mail_port'); ?>" value="<?= esc($generalSettings->mail_port); ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?= trans('mail_username'); ?></label>
                                <input type="text" class="form-control" name="mail_username" placeholder="<?= trans('mail_username'); ?>" value="<?= esc($generalSettings->mail_username); ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?= trans('mail_password'); ?></label>
                                <input type="password" class="form-control" name="mail_password" placeholder="<?= trans('mail_password'); ?>" value="<?= esc($generalSettings->mail_password); ?>">
                            </div>
                        <?php else: ?>
                            <input type="hidden" name="mail_encryption" value="<?= esc($generalSettings->mail_encryption); ?>">
                            <input type="hidden" name="mail_host" value="<?= esc($generalSettings->mail_host); ?>">
                            <input type="hidden" name="mail_port" value="<?= esc($generalSettings->mail_port); ?>">
                            <input type="hidden" name="mail_username" value="<?= esc($generalSettings->mail_username); ?>">
                            <input type="hidden" name="mail_password" value="<?= esc($generalSettings->mail_password); ?>">
                        <?php endif;
                    endif; ?>
                    <div class="form-group">
                        <label class="control-label"><?= trans('mail_title'); ?></label>
                        <input type="text" class="form-control" name="mail_title" placeholder="<?= trans('mail_title'); ?>" value="<?= esc($generalSettings->mail_title); ?>">
                    </div>
                    <?php if ($service != 'mailjet'): ?>
                        <div class="form-group">
                            <label class="control-label"><?= trans('reply_to'); ?></label>
                            <input type="email" class="form-control" name="mail_reply_to" placeholder="<?= trans('reply_to'); ?>" value="<?= esc($generalSettings->mail_reply_to); ?>">
                        </div>
                    <?php endif; ?>
                </div>
                <div class="box-footer">
                    <button type="submit" name="submit" value="email" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                </div>
            </div>
        </div>
    </form>

    <form action="<?= base_url('AdminController/emailVerificationSettingsPost'); ?>" method="post">
        <?= csrf_field(); ?>
        <div class="col-lg-6 col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= trans('email_verification'); ?></h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <label><?= trans('email_verification'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="email_verification" value="1" id="email_verification_1" class="square-purple" <?= $generalSettings->email_verification == 1 ? 'checked' : ''; ?>>
                                <label for="email_verification_1" class="option-label"><?= trans('enable'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="email_verification" value="0" id="email_verification_2" class="square-purple" <?= $generalSettings->email_verification != 1 ? 'checked' : ''; ?>>
                                <label for="email_verification_2" class="option-label"><?= trans('disable'); ?></label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" name="submit" value="verification" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                </div>
            </div>
        </div>
    </form>

    <form action="<?= base_url('AdminController/contactEmailSettingsPost'); ?>" method="post">
        <?= csrf_field(); ?>
        <div class="col-lg-6 col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= trans('contact_messages'); ?></h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <label><?= trans('send_contact_to_mail'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="mail_contact_status" value="1" id="mail_contact_status_1" class="square-purple" <?= $generalSettings->mail_contact_status == 1 ? 'checked' : ''; ?>>
                                <label for="mail_contact_status_1" class="option-label"><?= trans('yes'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="mail_contact_status" value="0" id="mail_contact_status_2" class="square-purple" <?= $generalSettings->mail_contact_status != 1 ? 'checked' : ''; ?>>
                                <label for="mail_contact_status_2" class="option-label"><?= trans('no'); ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('email'); ?> (<?= trans("contact_messages_will_send"); ?>)</label>
                        <input type="email" class="form-control" name="mail_contact" placeholder="<?= trans('email'); ?>" value="<?= esc($generalSettings->mail_contact); ?>">
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" name="submit" value="contact" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                </div>
            </div>
        </div>
    </form>

    <form action="<?= base_url('AdminController/sendTestEmailPost'); ?>" method="post">
        <?= csrf_field(); ?>
        <div class="col-lg-6 col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= trans('send_test_email'); ?></h3>
                    <small class="small-title"><?= trans('send_test_email_exp'); ?></small>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label"><?= trans('email'); ?></label>
                        <input type="text" class="form-control" name="email" placeholder="<?= trans('email'); ?>" required>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" name="submit" value="contact" class="btn btn-primary pull-right"><?= trans('send_email'); ?></button>
                </div>
            </div>
        </div>
    </form>
</div>
<style>
    h4 {
        color: #0d6aad;
        font-weight: 600;
        margin-bottom: 15px;
        margin-top: 30px;
    }
</style>