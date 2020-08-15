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

                        <?php echo form_open_multipart("visual-settings-post"); ?>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label><?php echo trans('dark_mode'); ?></label>
                                </div>
                                <div class="col-md-4 col-sm-4 col-option">
                                    <label class="custom-checkbox custom-radio">
                                        <input type="radio" name="site_mode" value="dark" <?php echo ($this->dark_mode == 1) ? 'checked' : ''; ?> required>
                                        <span class="checkbox-icon"><i class="icon-check"></i></span>
                                        <span><?php echo trans("enable"); ?></span>
                                    </label>
                                </div>
                                <div class="col-md-4 col-sm-4 col-option">
                                    <label class="custom-checkbox custom-radio">
                                        <input type="radio" name="site_mode" value="light" <?php echo ($this->dark_mode == 0) ? 'checked' : ''; ?> required>
                                        <span class="checkbox-icon"><i class="icon-check"></i></span>
                                        <span><?php echo trans("disable"); ?></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><?php echo trans("site_color"); ?></label>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="visual-color-box" data-color="default" style="background-color: #1abc9c;"><?php echo ($this->site_color === "default") ? '<i class="icon-check"></i>' : ""; ?></div>
                                    <div class="visual-color-box" data-color="violet" style="background-color: #6770B7;"><?php echo ($this->site_color === "violet") ? '<i class="icon-check"></i>' : ""; ?></div>
                                    <div class="visual-color-box" data-color="blue" style="background-color: #1da7da;"><?php echo ($this->site_color === "blue") ? '<i class="icon-check"></i>' : ""; ?></div>
                                    <div class="visual-color-box" data-color="bondi" style="background-color: #0494b1;"><?php echo ($this->site_color === "bondi") ? '<i class="icon-check"></i>' : ""; ?></div>
                                    <div class="visual-color-box" data-color="amaranth" style="background-color: #e91e63;"><?php echo ($this->site_color === "amaranth") ? '<i class="icon-check"></i>' : ""; ?></div>
                                    <div class="visual-color-box" data-color="red" style="background-color: #e74c3c;"><?php echo ($this->site_color === "red") ? '<i class="icon-check"></i>' : ""; ?></div>
                                    <div class="visual-color-box" data-color="orange" style="background-color: #f86923;"><?php echo ($this->site_color === "orange") ? '<i class="icon-check"></i>' : ""; ?></div>
                                    <div class="visual-color-box" data-color="yellow" style="background-color: #f2d438;"><?php echo ($this->site_color === "yellow") ? '<i class="icon-check"></i>' : ""; ?></div>
                                    <div class="visual-color-box" data-color="bluewood" style="background-color: #34495e;"><?php echo ($this->site_color === "bluewood") ? '<i class="icon-check"></i>' : ""; ?></div>
                                    <div class="visual-color-box" data-color="cascade" style="background-color: #95a5a6;"><?php echo ($this->site_color === "cascade") ? '<i class="icon-check"></i>' : ""; ?></div>
                                    <input type="hidden" name="site_color" id="input_user_site_color" value="<?php echo html_escape($this->site_color); ?>">
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

