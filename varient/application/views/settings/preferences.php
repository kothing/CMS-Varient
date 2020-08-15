<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo generate_url('settings'); ?>"><?php echo trans("settings"); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $title; ?></li>
                    </ol>
                </nav>
                <h1 class="page-title"><?php echo trans("settings"); ?></h1>
            </div>
        </div>

        <div class="row">

            <div class="col-sm-12 col-md-3">
                <div class="row-custom">
                    <!-- load profile nav -->
                    <?php $this->load->view("settings/_setting_tabs"); ?>
                </div>
            </div>

            <div class="col-sm-12 col-md-9">
                <div class="row-custom">
                    <div class="profile-tab-content">
                        <!-- include message block -->
                        <?php $this->load->view('partials/_messages'); ?>

                        <?php echo form_open_multipart("preferences-post"); ?>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label><?php echo trans('show_email_on_profile'); ?></label>
                                </div>
                                <div class="col-md-4 col-sm-4 col-option">
                                    <label class="custom-checkbox custom-radio">
                                        <input type="radio" name="show_email_on_profile" value="1" <?php echo ($user->show_email_on_profile == 1) ? 'checked' : ''; ?> required>
                                        <span class="checkbox-icon"><i class="icon-check"></i></span>
                                        <span><?php echo trans("yes"); ?></span>
                                    </label>
                                </div>
                                <div class="col-md-4 col-sm-4 col-option">
                                    <label class="custom-checkbox custom-radio">
                                        <input type="radio" name="show_email_on_profile" value="0" <?php echo ($user->show_email_on_profile == 0) ? 'checked' : ''; ?> required>
                                        <span class="checkbox-icon"><i class="icon-check"></i></span>
                                        <span><?php echo trans("no"); ?></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label><?php echo trans('rss_feeds'); ?></label>
                                </div>
                                <div class="col-md-4 col-sm-4 col-option">
                                    <label class="custom-checkbox custom-radio">
                                        <input type="radio" name="show_rss_feeds" value="1" <?php echo ($user->show_rss_feeds == 1) ? 'checked' : ''; ?> required>
                                        <span class="checkbox-icon"><i class="icon-check"></i></span>
                                        <span><?php echo trans("enable"); ?></span>
                                    </label>
                                </div>
                                <div class="col-md-4 col-sm-4 col-option">
                                    <label class="custom-checkbox custom-radio">
                                        <input type="radio" name="show_rss_feeds" value="0" <?php echo ($user->show_rss_feeds == 0) ? 'checked' : ''; ?> required>
                                        <span class="checkbox-icon"><i class="icon-check"></i></span>
                                        <span><?php echo trans("disable"); ?></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" name="submit" value="update" class="btn btn-md btn-custom"><?php echo trans("save_changes") ?></button>
                        <?php echo form_close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Wrapper End-->

