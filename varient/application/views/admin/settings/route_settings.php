<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12 col-lg-8">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?php echo trans("route_settings");; ?></h3>
                </div>
            </div><!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open_multipart('admin_controller/route_settings_post'); ?>
            <div class="box-body">
                <div class="row">
                    <!-- include message block -->
                    <div class="col-sm-12">
                        <?php $this->load->view('admin/includes/_messages'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="admin_readonly" value="admin" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> readonly>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="admin" value="<?php echo $this->routes->admin; ?>" maxlength="100" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="profile_readonly" value="profile" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> readonly>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="profile" value="<?php echo $this->routes->profile; ?>" maxlength="100" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="tag_readonly" value="tag" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> readonly>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="tag" value="<?php echo $this->routes->tag; ?>" maxlength="100" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="reading_list_readonly" value="reading-list" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> readonly>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="reading_list" value="<?php echo $this->routes->reading_list; ?>" maxlength="100" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="settings_readonly" value="settings" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> readonly>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="settings" value="<?php echo $this->routes->settings; ?>" maxlength="100" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="social_accounts_readonly" value="social-accounts" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> readonly>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="social_accounts" value="<?php echo $this->routes->social_accounts; ?>" maxlength="100" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="preferences_readonly" value="preferences" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> readonly>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="preferences" value="<?php echo $this->routes->preferences; ?>" maxlength="100" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="visual_settings_readonly" value="visual_settings" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> readonly>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="visual_settings" value="<?php echo $this->routes->visual_settings; ?>" maxlength="100" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="change_password_readonly" value="change-password" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> readonly>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="change_password" value="<?php echo $this->routes->change_password; ?>" maxlength="100" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="forgot_password_readonly" value="forgot-password" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> readonly>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="forgot_password" value="<?php echo $this->routes->forgot_password; ?>" maxlength="100" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="reset_password_readonly" value="reset-password" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> readonly>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="reset_password" value="<?php echo $this->routes->reset_password; ?>" maxlength="100" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="register_readonly" value="register" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> readonly>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="register" value="<?php echo $this->routes->register; ?>" maxlength="100" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="posts_readonly" value="posts" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> readonly>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="posts" value="<?php echo $this->routes->posts; ?>" maxlength="100" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="search_readonly" value="search" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> readonly>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="search" value="<?php echo $this->routes->search; ?>" maxlength="100" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="rss_feeds_readonly" value="rss-feeds" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> readonly>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="rss_feeds" value="<?php echo $this->routes->rss_feeds; ?>" maxlength="100" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="gallery_album_readonly" value="gallery_album" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> readonly>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="gallery_album" value="<?php echo $this->routes->gallery_album; ?>" maxlength="100" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="logout_readonly" value="logout" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> readonly>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="logout" value="<?php echo $this->routes->logout; ?>" maxlength="100" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                        </div>
                    </div>
                </div>
            </div><!-- /.box-body -->

            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
        <div class="alert alert-danger alert-large">
            <strong><?php echo trans("warning"); ?>!</strong>&nbsp;&nbsp;<?php echo trans("route_settings_warning"); ?>
        </div>
    </div>
</div>


