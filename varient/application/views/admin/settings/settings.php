<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-md-12">

        <!-- form start -->
        <?php echo form_open_multipart('admin_controller/settings_post'); ?>

        <div class="form-group">
            <label><?php echo trans("settings_language"); ?></label>
            <select name="lang_id" class="form-control max-400" onchange="window.location.href = '<?php echo admin_url(); ?>'+'settings?lang='+this.value;">
                <?php foreach ($this->languages as $language): ?>
                    <option value="<?php echo $language->id; ?>" <?php echo ($selected_lang == $language->id) ? 'selected' : ''; ?>><?php echo $language->name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Custom Tabs -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><?php echo trans('general_settings'); ?></a></li>
                <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false"><?php echo trans('contact_settings'); ?></a></li>
                <li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false"><?php echo trans('social_media_settings'); ?></a></li>
                <li class=""><a href="#tab_5" data-toggle="tab" aria-expanded="false"><?php echo trans('facebook_comments'); ?></a></li>
                <li class=""><a href="#tab_6" data-toggle="tab" aria-expanded="false"><?php echo trans('cookies_warning'); ?></a></li>
                <li class=""><a href="#tab_7" data-toggle="tab" aria-expanded="false"><?php echo trans('custom_css_codes'); ?></a></li>
                <li class=""><a href="#tab_8" data-toggle="tab" aria-expanded="false"><?php echo trans('custom_javascript_codes'); ?></a></li>
                <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
            </ul>
            <div class="tab-content settings-tab-content">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata("mes_settings"))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>

                <div class="tab-pane active" id="tab_1">
                    <div class="form-group">
                        <label class="control-label"><?php echo trans('timezone'); ?></label>
                        <input type="text" class="form-control" name="timezone" placeholder="<?php echo trans('timezone'); ?>"
                               value="<?php echo html_escape($this->general_settings->timezone); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                        <a href="http://php.net/manual/en/timezones.php" target="_blank">Timeszones</a>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo trans('app_name'); ?></label>
                        <input type="text" class="form-control" name="application_name" placeholder="<?php echo trans('app_name'); ?>"
                               value="<?php echo html_escape($settings->application_name); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo trans('footer_about_section'); ?></label>
                        <textarea class="form-control text-area" name="about_footer" placeholder="<?php echo trans('footer_about_section'); ?>"
                                  style="min-height: 140px;" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>><?php echo html_escape($settings->about_footer); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo trans('optional_url_name'); ?></label>
                        <input type="text" class="form-control" name="optional_url_button_name"
                               placeholder="<?php echo trans('optional_url_name'); ?>"
                               value="<?php echo html_escape($settings->optional_url_button_name); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo trans('copyright'); ?></label>
                        <input type="text" class="form-control" name="copyright"
                               placeholder="<?php echo trans('copyright'); ?>"
                               value="<?php echo html_escape($settings->copyright); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>

                </div><!-- /.tab-pane -->

                <div class="tab-pane" id="tab_3">
                    <div class="form-group">
                        <label class="control-label"><?php echo trans('address'); ?></label>
                        <input type="text" class="form-control" name="contact_address"
                               placeholder="<?php echo trans('address'); ?>" value="<?php echo html_escape($settings->contact_address); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo trans('email'); ?></label>
                        <input type="text" class="form-control" name="contact_email"
                               placeholder="<?php echo trans('email'); ?>" value="<?php echo html_escape($settings->contact_email); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo trans('phone'); ?></label>
                        <input type="text" class="form-control" name="contact_phone"
                               placeholder="<?php echo trans('phone'); ?>" value="<?php echo html_escape($settings->contact_phone); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo trans('contact_text'); ?></label>
                        <textarea class="tinyMCE form-control" name="contact_text"><?php echo $settings->contact_text; ?></textarea>
                    </div>


                </div><!-- /.tab-pane -->

                <div class="tab-pane" id="tab_4">
                    <div class="form-group">
                        <label class="control-label">Facebook <?php echo trans('url'); ?></label>
                        <input type="text" class="form-control" name="facebook_url"
                               placeholder="Facebook <?php echo trans('url'); ?>" value="<?php echo html_escape($settings->facebook_url); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Twitter <?php echo trans('url'); ?></label>
                        <input type="text" class="form-control"
                               name="twitter_url" placeholder="Twitter <?php echo trans('url'); ?>"
                               value="<?php echo html_escape($settings->twitter_url); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Instagram <?php echo trans('url'); ?></label>
                        <input type="text" class="form-control" name="instagram_url" placeholder="Instagram <?php echo trans('url'); ?>"
                               value="<?php echo html_escape($settings->instagram_url); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Pinterest <?php echo trans('url'); ?></label>
                        <input type="text" class="form-control" name="pinterest_url" placeholder="Pinterest <?php echo trans('url'); ?>"
                               value="<?php echo html_escape($settings->pinterest_url); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>

                    <div class="form-group">
                        <label class="control-label">LinkedIn <?php echo trans('url'); ?></label>
                        <input type="text" class="form-control" name="linkedin_url" placeholder="LinkedIn <?php echo trans('url'); ?>"
                               value="<?php echo html_escape($settings->linkedin_url); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>

                    <div class="form-group">
                        <label class="control-label">VK <?php echo trans('url'); ?></label>
                        <input type="text" class="form-control" name="vk_url"
                               placeholder="VK <?php echo trans('url'); ?>" value="<?php echo html_escape($settings->vk_url); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Telegram <?php echo trans('url'); ?></label>
                        <input type="text" class="form-control" name="telegram_url"
                               placeholder="Telegram <?php echo trans('url'); ?>" value="<?php echo html_escape($settings->telegram_url); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Youtube <?php echo trans('url'); ?></label>
                        <input type="text" class="form-control" name="youtube_url"
                               placeholder="Youtube <?php echo trans('url'); ?>" value="<?php echo html_escape($settings->youtube_url); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>
                </div>

                <div class="tab-pane" id="tab_5">

                    <div class="form-group">
                        <label class="control-label"><?php echo trans('facebook_comments_code'); ?></label>
                        <textarea class="form-control text-area" name="facebook_comment" placeholder="<?php echo trans('facebook_comments_code'); ?>"
                                  style="min-height: 140px;" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>><?php echo $this->general_settings->facebook_comment; ?></textarea>
                    </div>

                </div>

                <div class="tab-pane" id="tab_6">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12 col-option">
                                <label><?php echo trans('show_cookies_warning'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="cookies_warning" value="1" id="cookies_warning_1"
                                       class="square-purple" <?php echo ($settings->cookies_warning == 1) ? 'checked' : ''; ?>>
                                <label for="cookies_warning_1" class="option-label"><?php echo trans('yes'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="cookies_warning" value="0" id="cookies_warning_2"
                                       class="square-purple" <?php echo ($settings->cookies_warning != 1) ? 'checked' : ''; ?>>
                                <label for="cookies_warning_2" class="option-label"><?php echo trans('no'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?php echo trans('cookies_warning_text'); ?></label>
                        <textarea class="form-control tinyMCE" name="cookies_warning_text"><?php echo $settings->cookies_warning_text; ?></textarea>
                    </div>
                </div><!-- /.tab-pane -->

                <div class="tab-pane" id="tab_7">

                    <div class="form-group">
                        <label class="control-label"><?php echo trans('custom_css_codes'); ?></label>&nbsp;<small class="small-title-inline">(<?php echo trans("custom_css_codes_exp"); ?>)</small>
                        <textarea class="form-control text-area" name="custom_css_codes" placeholder="<?php echo trans('custom_css_codes'); ?>"
                                  style="min-height: 200px;" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>><?php echo $this->general_settings->custom_css_codes; ?></textarea>
                    </div>
                    E.g. <?php echo html_escape("<style> body {background-color: #00a65a;} </style>"); ?>
                </div><!-- /.tab-pane -->

                <div class="tab-pane" id="tab_8">

                    <div class="form-group">
                        <label class="control-label"><?php echo trans('custom_javascript_codes'); ?></label>&nbsp;<small class="small-title-inline">(<?php echo trans("custom_javascript_codes_exp"); ?>)</small>
                        <textarea class="form-control text-area" name="custom_javascript_codes" placeholder="<?php echo trans('custom_javascript_codes'); ?>"
                                  style="min-height: 200px;" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>><?php echo $this->general_settings->custom_javascript_codes; ?></textarea>
                    </div>
                    E.g. <?php echo html_escape("<script> alert('Hello!'); </script>"); ?>
                </div><!-- /.tab-pane -->
            </div><!-- /.tab-content -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
        </div><!-- nav-tabs-custom -->

        <?php echo form_close(); ?>
    </div><!-- /.col -->
</div>

<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('google_recaptcha'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('admin_controller/recaptcha_settings_post'); ?>
            <div class="box-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata("mes_recaptcha"))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('site_key'); ?></label>
                    <input type="text" class="form-control" name="recaptcha_site_key" placeholder="<?php echo trans('site_key'); ?>"
                           value="<?php echo $this->general_settings->recaptcha_site_key; ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('secret_key'); ?></label>
                    <input type="text" class="form-control" name="recaptcha_secret_key" placeholder="<?php echo trans('secret_key'); ?>"
                           value="<?php echo $this->general_settings->recaptcha_secret_key; ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('language'); ?></label>
                    <input type="text" class="form-control" name="recaptcha_lang" placeholder="<?php echo trans('language'); ?>"
                           value="<?php echo $this->general_settings->recaptcha_lang; ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    <a href="https://developers.google.com/recaptcha/docs/language" target="_blank">https://developers.google.com/recaptcha/docs/language</a>
                </div>

                <!-- /.box-body -->
                <div class="box-footer" style="padding-left: 0; padding-right: 0;">
                    <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
                </div>
                <!-- /.box-footer -->

                <?php echo form_close(); ?><!-- form end -->
            </div>
            <!-- /.box -->
        </div>
    </div>

    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans('maintenance_mode'); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('admin_controller/maintenance_mode_post'); ?>
            <div class="box-body">
                <!-- include message block -->
                <?php if (!empty($this->session->flashdata("mes_maintenance"))):
                    $this->load->view('admin/includes/_messages');
                endif; ?>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('title'); ?></label>
                    <input type="text" class="form-control" name="maintenance_mode_title" placeholder="<?php echo trans('title'); ?>"
                           value="<?php echo $this->general_settings->maintenance_mode_title; ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('description'); ?></label>
                    <textarea class="form-control text-area" name="maintenance_mode_description"
                              placeholder="<?php echo trans('description'); ?>"
                              style="min-height: 100px;" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>><?php echo html_escape($this->general_settings->maintenance_mode_description); ?></textarea>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                            <label><?php echo trans('status'); ?></label>
                        </div>
                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="maintenance_mode_status" value="1" id="maintenance_mode_status_1" class="square-purple" <?php echo ($this->general_settings->maintenance_mode_status == 1) ? 'checked' : ''; ?>>
                            <label for="maintenance_mode_status_1" class="option-label"><?php echo trans('enable'); ?></label>
                        </div>
                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="maintenance_mode_status" value="0" id="maintenance_mode_status_2" class="square-purple" <?php echo ($this->general_settings->maintenance_mode_status != 1) ? 'checked' : ''; ?>>
                            <label for="maintenance_mode_status_2" class="option-label"><?php echo trans('disable'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label><?php echo trans('image'); ?></label>: assets/img/maintenance_bg.jpg
                </div>
            </div>

            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->
            <!-- /.box -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
    </div>
</div>

<style>
    .tox-tinymce {
        height: 340px !important;
    }
</style>