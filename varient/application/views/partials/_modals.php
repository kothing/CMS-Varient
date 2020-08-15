<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if (!$this->auth_check && $this->general_settings->registration_system == 1): ?>
    <div class="modal fade auth-modal" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div id="menu-login" class="tab-pane fade in active">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><i class="icon-close" aria-hidden="true"></i></button>
                        <h4 class="modal-title font-1"><?php echo trans("login"); ?></h4>
                    </div>

                    <div class="modal-body">
                        <div class="auth-box">
                            <?php if (!empty($this->general_settings->facebook_app_id)): ?>
                                <a href="<?php echo base_url(); ?>connect-with-facebook" class="btn btn-social btn-social-modal btn-social-facebook">
                                    <i class="icon-facebook"></i>&nbsp;<?php echo trans("connect_with_facebook"); ?>
                                </a>
                            <?php endif; ?>
                            <?php if (!empty($this->general_settings->google_client_id)): ?>
                                <a href="<?php echo base_url(); ?>connect-with-google" class="btn btn-social btn-social-modal btn-social-google">
                                    <i class="icon-google"></i>&nbsp;<?php echo trans("connect_with_google"); ?>
                                </a>
                            <?php endif; ?>
                            <?php if (!empty($this->general_settings->vk_app_id)): ?>
                                <a href="<?php echo base_url(); ?>connect-with-vk" class="btn btn-social btn-social-modal btn-social-vk">
                                    <i class="icon-vk"></i>&nbsp;<?php echo trans("connect_with_vk"); ?>
                                </a>
                            <?php endif; ?>
                            <?php if (!empty($this->general_settings->facebook_app_id) || !empty($this->general_settings->google_client_id) || !empty($this->general_settings->vk_app_id)): ?>
                                <p class="p-auth-modal-or">
                                    <span><?php echo trans("or_login_with_email"); ?></span>
                                </p>
                            <?php endif; ?>

                            <!-- include message block -->
                            <div id="result-login"></div>

                            <!-- form start -->
                            <form id="form-login">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control auth-form-input" placeholder="<?php echo trans("placeholder_email"); ?>" value="<?php echo old('email'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control auth-form-input" placeholder="<?php echo trans("placeholder_password"); ?>" value="<?php echo old('password'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                                </div>
                                <div class="form-group">
                                    <label class="custom-checkbox">
                                        <input type="checkbox" name="remember_me" class="checkbox_terms_conditions" value="1">
                                        <span class="checkbox-icon"><i class="icon-check"></i></span>
                                        <?php echo trans("remember_me"); ?>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-md btn-custom btn-block"><?php echo trans("login"); ?></button>
                                </div>
                                <div class="form-group text-center m-b-0">
                                    <a href="<?php echo generate_url('forgot_password'); ?>" class="link-forget">
                                        <?php echo trans("forgot_password"); ?>?
                                    </a>
                                </div>
                            </form><!-- form end -->

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php endif; ?>

<?php if ($this->auth_check): ?>
    <div id="modal_add_post" class="modal fade add-post-modal" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><i class="icon-close" aria-hidden="true"></i></button>
                    <h4 class="modal-title"><?php echo trans("choose_post_format"); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <?php $format_count = 0;
                        if ($this->general_settings->post_format_article == 1):
                            $format_count += 1; ?>
                            <div class="col-xs-12 col-sm-4 col-add-post">
                                <a href="<?php echo admin_url(); ?>add-post?type=article">
                                    <div class="item">
                                        <div class="item-icon">
                                            <i class="icon-article"></i>
                                        </div>
                                        <h5 class="title"><?php echo trans("article"); ?></h5>
                                        <p class="desc"><?php echo trans("article_post_exp"); ?></p>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>
                        <?php if ($this->general_settings->post_format_gallery == 1):
                            $format_count += 1; ?>
                            <div class="col-xs-12 col-sm-4 col-add-post">
                                <a href="<?php echo admin_url(); ?>add-post?type=gallery">
                                    <div class="item">
                                        <div class="item-icon">
                                            <i class="icon-gallery"></i>
                                        </div>
                                        <h5 class="title"><?php echo trans("gallery"); ?></h5>
                                        <p class="desc"><?php echo trans("gallery_post_exp"); ?></p>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>
                        <?php if ($this->general_settings->post_format_sorted_list == 1):
                            $format_count += 1; ?>
                            <div class="col-xs-12 col-sm-4 col-add-post">
                                <a href="<?php echo admin_url(); ?>add-post?type=sorted_list">
                                    <div class="item">
                                        <div class="item-icon">
                                            <i class="icon-list"></i>
                                        </div>
                                        <h5 class="title"><?php echo trans("sorted_list"); ?></h5>
                                        <p class="desc"><?php echo trans("sorted_list_exp"); ?></p>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>
                        <?php if ($this->general_settings->post_format_trivia_quiz == 1):
                            $format_count += 1; ?>
                            <div class="col-xs-12 col-sm-4 col-add-post">
                                <a href="<?php echo admin_url(); ?>add-post?type=trivia_quiz">
                                    <div class="item">
                                        <div class="item-icon">
                                            <i class="icon-trivia-quiz"></i>
                                        </div>
                                        <h5 class="title"><?php echo trans("trivia_quiz"); ?></h5>
                                        <p class="desc"><?php echo trans("trivia_quiz_exp"); ?></p>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>
                        <?php if ($this->general_settings->post_format_personality_quiz == 1):
                            $format_count += 1; ?>
                            <div class="col-xs-12 col-sm-4 col-add-post">
                                <a href="<?php echo admin_url(); ?>add-post?type=personality_quiz">
                                    <div class="item">
                                        <div class="item-icon">
                                            <i class="icon-personality-quiz"></i>
                                        </div>
                                        <h5 class="title"><?php echo trans("personality_quiz"); ?></h5>
                                        <p class="desc"><?php echo trans("personality_quiz_exp"); ?></p>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>
                        <?php if ($this->general_settings->post_format_video == 1):
                            $format_count += 1; ?>
                            <div class="col-xs-12 col-sm-4 col-add-post">
                                <a href="<?php echo admin_url(); ?>add-post?type=video">
                                    <div class="item">
                                        <div class="item-icon">
                                            <i class="icon-video"></i>
                                        </div>
                                        <h5 class="title"><?php echo trans("video"); ?></h5>
                                        <p class="desc"><?php echo trans("video_post_exp"); ?></p>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>
                        <?php if ($this->general_settings->post_format_audio == 1): ?>
                            <div class="col-xs-12 col-sm-4 <?php echo ($format_count == 6) ? 'col-sm-offset-4 ' : ''; ?>col-add-post">
                                <a href="<?php echo admin_url(); ?>add-post?type=audio">
                                    <div class="item">
                                        <div class="item-icon">
                                            <i class="icon-music"></i>
                                        </div>
                                        <h5 class="title"><?php echo trans("audio"); ?></h5>
                                        <p class="desc"><?php echo trans("audio_post_exp"); ?></p>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
