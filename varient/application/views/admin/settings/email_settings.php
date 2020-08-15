<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
    <!-- form start -->
    <?php echo form_open('admin_controller/email_settings_post'); ?>
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('email_settings'); ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <!-- include message block -->
                <?php
                $message = $this->session->flashdata('message_type');
                if (!empty($message) && $message == "email") {
                    $this->load->view('admin/includes/_messages');
                }
                ?>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('mail_library'); ?></label>
                    <select name="mail_library" class="form-control" onchange="window.location.href = '<?php echo admin_url(); ?>email-settings?library='+this.value;">
                        <option value="swift" <?php echo ($library == "swift") ? "selected" : ""; ?>>Swift Mailer</option>
                        <option value="php" <?php echo ($library == "php") ? "selected" : ""; ?>>PHP Mailer</option>
                        <option value="codeigniter" <?php echo ($library == "codeigniter") ? "selected" : ""; ?>>CodeIgniter Mail</option>
                    </select>
                </div>
                <?php if ($library == 'codeigniter'): ?>
                    <div class="form-group">
                        <label class="control-label"><?php echo trans('mail_protocol'); ?></label>
                        <select name="mail_protocol" class="form-control">
                            <option value="smtp" <?php echo ($this->general_settings->mail_protocol == "smtp") ? "selected" : ""; ?>><?php echo trans('smtp'); ?></option>
                            <option value="mail" <?php echo ($this->general_settings->mail_protocol == "mail") ? "selected" : ""; ?>><?php echo trans('mail'); ?></option>
                        </select>
                    </div>
                <?php else: ?>
                    <input type="hidden" name="mail_protocol" value="smtp">
                <?php endif; ?>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('mail_title'); ?></label>
                    <input type="text" class="form-control" name="mail_title"
                           placeholder="<?php echo trans('mail_title'); ?>" value="<?php echo html_escape($this->general_settings->mail_title); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('mail_host'); ?></label>
                    <input type="text" class="form-control" name="mail_host"
                           placeholder="<?php echo trans('mail_host'); ?>" value="<?php echo html_escape($this->general_settings->mail_host); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('mail_port'); ?></label>
                    <input type="text" class="form-control" name="mail_port"
                           placeholder="<?php echo trans('mail_port'); ?>" value="<?php echo html_escape($this->general_settings->mail_port); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('mail_username'); ?></label>
                    <input type="text" class="form-control" name="mail_username"
                           placeholder="<?php echo trans('mail_username'); ?>" value="<?php echo html_escape($this->general_settings->mail_username); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('mail_password'); ?></label>
                    <input type="password" class="form-control" name="mail_password"
                           placeholder="<?php echo trans('mail_password'); ?>" value="<?php echo html_escape($this->general_settings->mail_password); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('email_template'); ?></label>
                    <div class="row m-b-15 m-t-15">
                        <div class="category-block-box" style="width: 320px; height: 320px;margin-left: 15px;">
                            <div class="col-sm-12 text-center m-b-15">
                                <input type="radio" name="block_type" value="block-1" class="square-purple" checked>
                            </div>
                            <img src="<?php echo base_url(); ?>assets/admin/img/email-template-1.png" alt="" class="img-responsive">
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" name="submit" value="email" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->

        </div>

        <div class="callout" style="margin-top: 30px;background-color: #fff; border-color:#00c0ef;max-width: 600px;">
            <h4><?php echo trans('gmail_smtp'); ?></h4>
            <p><?php echo trans("gmail_warning"); ?></p>
        </div>

    </div>
    <?php echo form_close(); ?><!-- form end -->

    <?php echo form_open('admin_controller/email_verification_settings_post'); ?>
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('email_verification'); ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <!-- include message block -->
                <?php
                if (!empty($message) && $message == "verification") {
                    $this->load->view('admin/includes/_messages');
                } ?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label><?php echo trans('email_verification'); ?></label>
                        </div>
                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="email_verification" value="1" id="email_verification_1" class="square-purple" <?php echo ($this->general_settings->email_verification == '1') ? 'checked' : ''; ?>>
                            <label for="email_verification_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="email_verification" value="0" id="email_verification_2" class="square-purple" <?php echo ($this->general_settings->email_verification == '0') ? 'checked' : ''; ?>>
                            <label for="email_verification_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" name="submit" value="verification" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?><!-- form end -->

    <?php echo form_open('admin_controller/contact_email_settings_post'); ?>
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('contact_messages'); ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <!-- include message block -->
                <?php
                if (!empty($message) && $message == "contact") {
                    $this->load->view('admin/includes/_messages');
                } ?>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label><?php echo trans('send_contact_to_mail'); ?></label>
                        </div>
                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="mail_contact_status" value="1" id="mail_contact_status_1" class="square-purple" <?php echo ($this->general_settings->mail_contact_status == '1') ? 'checked' : ''; ?>>
                            <label for="mail_contact_status_1" class="option-label"><?php echo trans('yes'); ?></label>
                        </div>
                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="mail_contact_status" value="0" id="mail_contact_status_2" class="square-purple" <?php echo ($this->general_settings->mail_contact_status == '0') ? 'checked' : ''; ?>>
                            <label for="mail_contact_status_2" class="option-label"><?php echo trans('no'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('email'); ?> (<?php echo trans("contact_messages_will_send"); ?>)</label>
                    <input type="text" class="form-control" name="mail_contact"
                           placeholder="<?php echo trans('email'); ?>" value="<?php echo html_escape($this->general_settings->mail_contact); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" name="submit" value="contact" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?><!-- form end -->

    <?php echo form_open('admin_controller/send_test_email_post'); ?>
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('send_test_email'); ?></h3>
                <small class="small-title"><?php echo trans('send_test_email_exp'); ?></small>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <!-- include message block -->
                <?php
                if (!empty($message) && $message == "send_email") {
                    $this->load->view('admin/includes/_messages');
                } ?>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('placeholder_email'); ?></label>
                    <input type="text" class="form-control" name="email" placeholder="<?php echo trans('placeholder_email'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" name="submit" value="contact" class="btn btn-primary pull-right"><?php echo trans('send_email'); ?></button>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?><!-- form end -->
</div>


<style>
    h4 {
        color: #0d6aad;
        font-weight: 600;
        margin-bottom: 15px;
        margin-top: 30px;
    }
</style>