<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?php echo trans('post_details'); ?></h3>
        </div>
    </div><!-- /.box-header -->

    <div class="box-body">
        <!-- include message block -->
        <?php $this->load->view('admin/includes/_messages'); ?>

        <?php if (!empty($this->session->userdata('msg_error'))): ?>
            <div class="m-b-15">
                <div class="alert alert-danger alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4>
                        <i class="icon fa fa-times"></i>
                        <?php echo $this->session->userdata('msg_error');
                        $this->session->unset_userdata('msg_error'); ?>
                    </h4>
                </div>
            </div>
        <?php endif; ?>

        <!--print custom success message-->
        <?php if (!empty($this->session->userdata('msg_success'))): ?>
            <div class="m-b-15">
                <div class="alert alert-success alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4>
                        <i class="icon fa fa-check"></i>
                        <?php echo $this->session->userdata('msg_success');
                        $this->session->unset_userdata('msg_success') ?>
                    </h4>
                </div>
            </div>
        <?php endif; ?>

        <input type="hidden" name="id" value="<?php echo html_escape($post->id); ?>">
        <input type="hidden" name="referrer" class="form-control" value="<?php echo $this->agent->referrer(); ?>">

        <div class="form-group">
            <label class="control-label"><?php echo trans('title'); ?></label>
            <input type="text" class="form-control" name="title" placeholder="<?php echo trans('title'); ?>"
                   value="<?php echo html_escape($post->title); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
        </div>

        <div class="form-group">
            <label class="control-label"><?php echo trans('slug'); ?>
                <small>(<?php echo trans('slug_exp'); ?>)</small>
            </label>
            <input type="text" class="form-control" name="title_slug" placeholder="<?php echo trans('slug'); ?>"
                   value="<?php echo html_escape($post->title_slug); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
        </div>

        <div class="form-group">
            <label class="control-label"><?php echo trans('summary'); ?> & <?php echo trans("description"); ?> (<?php echo trans('meta_tag'); ?>)</label>
            <textarea class="form-control text-area" name="summary"
                      placeholder="<?php echo trans('summary'); ?> & <?php echo trans("description"); ?> (<?php echo trans('meta_tag'); ?>)" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>><?php echo html_escape($post->summary); ?></textarea>
        </div>

        <div class="form-group">
            <label class="control-label"><?php echo trans('keywords'); ?> (<?php echo trans('meta_tag'); ?>)</label>
            <input type="text" class="form-control" name="keywords"
                   placeholder="<?php echo trans('keywords'); ?> (<?php echo trans('meta_tag'); ?>)" value="<?php echo html_escape($post->keywords); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
        </div>

        <?php if (check_user_permission('manage_all_posts')): ?>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-4 col-xs-12 col-lang">
                        <label><?php echo trans('visibility'); ?></label>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                        <input type="radio" id="rb_visibility_1" name="visibility" value="1" class="square-purple" <?php echo ($post->visibility == 1) ? 'checked' : ''; ?>>&nbsp;&nbsp;
                        <label for="rb_visibility_1" class="cursor-pointer"><?php echo trans('show'); ?></label>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                        <input type="radio" id="rb_visibility_2" name="visibility" value="0" class="square-purple" <?php echo ($post->visibility == 0) ? 'checked' : ''; ?>>&nbsp;&nbsp;
                        <label for="rb_visibility_2" class="cursor-pointer"><?php echo trans('hide'); ?></label>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <?php if ($this->general_settings->approve_updated_user_posts == 1): ?>
                <input type="hidden" name="visibility" value="0">
            <?php else: ?>
                <input type="hidden" name="visibility" value="1">
            <?php endif; ?>
        <?php endif; ?>


        <div class="form-group">
            <div class="row">
                <div class="col-sm-4 col-xs-12">
                    <label><?php echo trans('show_right_column'); ?></label>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                    <input type="radio" name="show_right_column" value="1" id="right_column_enabled"
                           class="square-purple" <?php echo ($post->show_right_column == 1) ? 'checked' : ''; ?>>
                    <label for="right_column_enabled" class="option-label"><?php echo trans('yes'); ?></label>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                    <input type="radio" name="show_right_column" value="0" id="right_column_disabled"
                           class="square-purple" <?php echo ($post->show_right_column == 0) ? 'checked' : ''; ?>>
                    <label for="right_column_disabled" class="option-label"><?php echo trans('no'); ?></label>
                </div>
            </div>
        </div>

        <?php if (check_user_permission('manage_all_posts')): ?>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <label class="control-label"><?php echo trans('add_featured'); ?></label>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <input type="checkbox" name="is_featured" value="1" class="square-purple" <?php echo ($post->is_featured == 1) ? 'checked' : ''; ?>>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <input type="hidden" name="is_featured" value="<?php echo $post->is_featured; ?>">
        <?php endif; ?>


        <?php if (check_user_permission('manage_all_posts')): ?>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <label class="control-label"><?php echo trans('add_breaking'); ?></label>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <input type="checkbox" name="is_breaking" value="1" class="square-purple" <?php echo ($post->is_breaking == 1) ? 'checked' : ''; ?>>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <input type="hidden" name="is_breaking" value="<?php echo $post->is_breaking; ?>">
        <?php endif; ?>

        <?php if (check_user_permission('manage_all_posts')): ?>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <label class="control-label"><?php echo trans('add_slider'); ?></label>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <input type="checkbox" name="is_slider" value="1" class="square-purple" <?php echo ($post->is_slider == 1) ? 'checked' : ''; ?>>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <input type="hidden" name="is_slider" value="<?php echo $post->is_slider; ?>">
        <?php endif; ?>


        <?php if (check_user_permission('manage_all_posts')): ?>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <label class="control-label"><?php echo trans('add_recommended'); ?></label>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <input type="checkbox" name="is_recommended" value="1" class="square-purple" <?php echo ($post->is_recommended == 1) ? 'checked' : ''; ?>>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <input type="hidden" name="is_recommended" value="<?php echo $post->is_recommended; ?>">
        <?php endif; ?>

        <div class="form-group">
            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <label class="control-label"><?php echo trans('show_only_registered'); ?></label>
                </div>
                <div class="col-md-8 col-sm-12">
                    <input type="checkbox" name="need_auth" value="1" class="square-purple" <?php echo ($post->need_auth == 1) ? 'checked' : ''; ?>>
                </div>
            </div>
        </div>
        <?php if ($post->post_type == 'sorted_list' || $post->post_type == 'gallery'): ?>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <label class="control-label"><?php echo trans('show_item_numbers'); ?></label>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <input type="checkbox" name="show_item_numbers" value="1" class="square-purple" <?php echo ($post->show_item_numbers == 1) ? 'checked' : ''; ?>>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="form-group">
            <label class="control-label"><?php echo trans('tags'); ?></label>
            <input id="tags_1" type="text" name="tags" class="form-control tags" value="<?php echo html_escape($tags); ?>"/>
            <small>(<?php echo trans('type_tag'); ?>)</small>
        </div>
        <div class="form-group row-optional-url">
            <label class="control-label"><?php echo trans('optional_url'); ?></label>
            <input type="text" class="form-control" name="optional_url" placeholder="<?php echo trans('optional_url'); ?>" value="<?php echo html_escape($post->optional_url); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
        </div>
    </div>
</div>

<script>
    var post_type = "<?php echo $post->post_type; ?>";
    var text_select_a_result = "<?php echo trans("select_a_result"); ?>";
    var text_result = "<?php echo trans("result"); ?>";
</script>