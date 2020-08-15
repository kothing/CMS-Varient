<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-sm-12 form-header">
        <a href="<?php echo admin_url(); ?>posts?lang_id=<?php echo $this->general_settings->site_lang; ?>"
           class="btn btn-success btn-add-new pull-right">
            <i class="fa fa-bars"></i>
            <?php echo trans('posts'); ?>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 form-header">
        <h1 class="form-title form-title-post-format"><?php echo trans('choose_post_format'); ?></h1>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 post-format-container">
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