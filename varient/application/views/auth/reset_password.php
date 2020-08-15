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
                    <li class="breadcrumb-item active"><?php echo trans("reset_password"); ?></li>
                </ol>
            </div>

            <div class="col-sm-12 page-login">
                <div class="row">
                    <div class="col-sm-6 col-xs-12 login-box-cnt center-box">
                        <div class="login-box">
                            <h1 class="auth-title font-1"><?php echo trans("reset_password"); ?></h1>

                            <p class="p-auth-modal"><?php echo trans("enter_new_password"); ?></p>
                            <?php echo form_open('reset-password-post', ['id' => 'form_validate']); ?>

                            <!-- include message block -->
                            <?php $this->load->view('partials/_messages'); ?>
                            <?php if (!empty($user)): ?>
                                <input type="hidden" name="id" value="<?php echo $user->id; ?>">
                            <?php endif; ?>
                            <?php if (!empty($success)): ?>
                                <div class="form-group m-t-30">
                                    <a href="<?php echo lang_base_url(); ?>" class="btn btn-md btn-custom btn-block"><?php echo trans("btn_goto_home"); ?></a>
                                </div>
                            <?php else: ?>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-input" value="<?php echo old("password"); ?>" placeholder="<?php echo trans("new_password"); ?>" required>
                                </div>
                                <div class="form-group m-b-30">
                                    <input type="password" name="password_confirm" class="form-control form-input" value="<?php echo old("password_confirm"); ?>" placeholder="<?php echo trans("form_confirm_password"); ?>" required>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-md btn-custom btn-block"><?php echo trans("btn_submit"); ?></button>
                                </div>
                            <?php endif; ?>
                            <?php echo form_close(); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.Section: wrapper -->

