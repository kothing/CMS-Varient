<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Section: wrapper -->
<section id="wrapper">
    <div class="container">
        <div class="row">

            <!-- breadcrumb -->
            <div class="col-sm-12 page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?php echo lang_base_url(); ?>"><?php echo trans("breadcrumb_home"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo trans("register"); ?></li>
                </ol>
            </div>

            <div class="col-sm-12 page-login">
                <div class="row">
                    <div class="col-sm-6 col-xs-12 login-box-cnt center-box">
                        <div class="login-box">
                            <h1 class="auth-title font-1"><?php echo trans("register"); ?></h1>
                            <?php if (!empty($this->general_settings->facebook_app_id)): ?>
                                <a href="<?php echo base_url(); ?>connect-with-facebook" class="btn btn-social btn-social-facebook">
                                    <i class="icon-facebook"></i>&nbsp;<?php echo trans("connect_with_facebook"); ?>
                                </a>
                            <?php endif; ?>
                            <?php if (!empty($this->general_settings->google_client_id)): ?>
                                <a href="<?php echo base_url(); ?>connect-with-google" class="btn btn-social btn-social-google">
                                    <i class="icon-google"></i>&nbsp;<?php echo trans("connect_with_google"); ?>
                                </a>
                            <?php endif; ?>
                            <?php if (!empty($this->general_settings->vk_app_id)): ?>
                                <a href="<?php echo base_url(); ?>connect-with-vk" class="btn btn-social btn-social-vk">
                                    <i class="icon-vk"></i>&nbsp;<?php echo trans("connect_with_vk"); ?>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($this->general_settings->facebook_app_id) || !empty($this->general_settings->google_client_id) || !empty($this->general_settings->vk_app_id)): ?>
                                <p class="p-auth-modal-or">
                                    <span><?php echo trans("or_register_with_email"); ?></span>
                                </p>
                            <?php endif; ?>

                            <!-- form start -->
                            <?php echo form_open("register-post", ['id' => 'form_validate', 'class' => 'validate_terms']); ?>

                            <!-- include message block -->
                            <?php $this->load->view('partials/_messages'); ?>

                            <div class="form-group">
                                <input type="text" name="username" class="form-control form-input"
                                       placeholder="<?php echo trans("placeholder_username"); ?>"
                                       value="<?php echo old("username"); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                            </div>

                            <div class="form-group">
                                <input type="email" name="email" class="form-control form-input"
                                       placeholder="<?php echo trans("placeholder_email"); ?>"
                                       value="<?php echo old("email"); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                            </div>

                            <div class="form-group">
                                <input type="password" name="password" class="form-control form-input"
                                       placeholder="<?php echo trans("placeholder_password"); ?>"
                                       value="<?php echo old("password"); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                            </div>
                            <div class="form-group">
                                <input type="password" name="confirm_password" class="form-control form-input"
                                       placeholder="<?php echo trans("placeholder_confirm_password"); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                            </div>
                            <div class="form-group">
                                <label class="custom-checkbox">
                                    <input type="checkbox" class="checkbox_terms_conditions" required>
                                    <span class="checkbox-icon"><i class="icon-check"></i></span>
                                    <?php echo trans("terms_conditions_exp"); ?>&nbsp;<a href="<?php echo get_page_link_by_default_name('terms_conditions', $this->selected_lang->id); ?>" class="link-terms" target="_blank"><strong><?php echo trans("terms_conditions"); ?></strong></a>
                                </label>
                            </div>
                            <?php if ($this->recaptcha_status): ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="recaptcha-cnt">
                                            <?php generate_recaptcha(); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="row">
                                <div class="col-sm-12 m-t-15">
                                    <button type="submit" class="btn btn-md btn-custom btn-block margin-top-15">
                                        <?php echo trans("register"); ?>
                                    </button>
                                </div>
                            </div>
                            <?php echo form_close(); ?><!-- form end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.Section: wrapper -->
