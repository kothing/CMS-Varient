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
                    <li class="breadcrumb-item active"><?php echo trans("forgot_password"); ?></li>
                </ol>
            </div>

            <div class="col-sm-12 page-login">
                <div class="row">
                    <div class="col-sm-6 col-xs-12 login-box-cnt center-box">
                        <div class="login-box">
                            <h1 class="auth-title font-1"><?php echo trans("forgot_password"); ?></h1>
                            <p class="p-auth-modal"><?php echo trans("enter_email_address"); ?></p>

                            <!-- form start -->
                            <?php echo form_open("forgot-password-post", ['id' => 'form_validate']); ?>

                            <!-- include message block -->
                            <?php $this->load->view('partials/_messages'); ?>

                            <div class="form-group">
                                <input type="email" name="email" class="form-control form-input"
                                       placeholder="<?php echo trans("placeholder_email"); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 m-t-15">
                                    <button type="submit" class="btn btn-md btn-custom btn-block">
                                        <?php echo trans("reset_password"); ?>
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

