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

        <div class="form-group">
            <label class="control-label"><?php echo trans('title'); ?></label>
            <input type="text" id="wr_input_post_title" class="form-control" name="title" placeholder="<?php echo trans('title'); ?>"
                   value="<?php echo old('title'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
        </div>

        <div class="form-group">
            <label class="control-label"><?php echo trans('slug'); ?>
                <small>(<?php echo trans('slug_exp'); ?>)</small>
            </label>
            <input type="text" class="form-control" name="title_slug" placeholder="<?php echo trans('slug'); ?>"
                   value="<?php echo old('title_slug'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
        </div>

        <div class="form-group">
            <label class="control-label"><?php echo trans('summary'); ?> & <?php echo trans("description"); ?> (<?php echo trans('meta_tag'); ?>)</label>
            <textarea class="form-control text-area"
                      name="summary" placeholder="<?php echo trans('summary'); ?> & <?php echo trans("description"); ?> (<?php echo trans('meta_tag'); ?>)" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>><?php echo old('summary'); ?></textarea>
        </div>

        <div class="form-group">
            <label class="control-label"><?php echo trans('keywords'); ?> (<?php echo trans('meta_tag'); ?>)</label>
            <input type="text" class="form-control" name="keywords"
                   placeholder="<?php echo trans('keywords'); ?> (<?php echo trans('meta_tag'); ?>)" value="<?php echo old('keywords'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
        </div>

        <?php if (check_user_permission('manage_all_posts')): ?>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-4 col-xs-12">
                        <label><?php echo trans('visibility'); ?></label>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                        <input type="radio" id="rb_visibility_1" name="visibility" value="1" class="square-purple" checked>
                        <label for="rb_visibility_1" class="cursor-pointer"><?php echo trans('show'); ?></label>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                        <input type="radio" id="rb_visibility_2" name="visibility" value="0" class="square-purple">
                        <label for="rb_visibility_2" class="cursor-pointer"><?php echo trans('hide'); ?></label>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <?php if ($this->general_settings->approve_added_user_posts == 1): ?>
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
                    <input type="radio" name="show_right_column" value="1" id="right_column_enabled" class="square-purple" checked>
                    <label for="right_column_enabled" class="option-label"><?php echo trans('yes'); ?></label>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                    <input type="radio" name="show_right_column" value="0" id="right_column_disabled" class="square-purple">
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
                        <input type="checkbox" name="is_featured" value="1" class="square-purple" <?php echo (old('is_featured') == 1) ? 'checked' : ''; ?>>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <input type="hidden" name="is_featured" value="0">
        <?php endif; ?>


        <?php if (check_user_permission('manage_all_posts')): ?>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <label class="control-label"><?php echo trans('add_breaking'); ?></label>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <input type="checkbox" name="is_breaking" value="1" class="square-purple" <?php echo (old('is_breaking') == 1) ? 'checked' : ''; ?>>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <input type="hidden" name="is_breaking" value="0">
        <?php endif; ?>


        <?php if (check_user_permission('manage_all_posts')): ?>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <label class="control-label"><?php echo trans('add_slider'); ?></label>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <input type="checkbox" name="is_slider" value="1" class="square-purple" <?php echo (old('is_slider') == 1) ? 'checked' : ''; ?>>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <input type="hidden" name="is_slider" value="0">
        <?php endif; ?>

        <?php if (check_user_permission('manage_all_posts')): ?>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <label class="control-label"><?php echo trans('add_recommended'); ?></label>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <input type="checkbox" name="is_recommended" value="1" class="square-purple" <?php echo (old('is_recommended') == 1) ? 'checked' : ''; ?>>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <input type="hidden" name="is_recommended" value="0">
        <?php endif; ?>

        <div class="form-group">
            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <label class="control-label"><?php echo trans('show_only_registered'); ?></label>
                </div>
                <div class="col-md-8 col-sm-12">
                    <input type="checkbox" name="need_auth" value="1" class="square-purple" <?php echo (old('need_auth') == 1) ? 'checked' : ''; ?>>
                </div>
            </div>
        </div>

        <?php if (check_user_permission('manage_all_posts')): ?>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <label class="control-label"><?php echo trans('send_post_to_subscribes'); ?></label>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <input type="checkbox" name="send_post_to_subscribes" value="1" class="square-purple">
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($post_type == 'gallery' || $post_type == 'sorted_list'): ?>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <label class="control-label"><?php echo trans('show_item_numbers'); ?></label>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <input type="checkbox" name="show_item_numbers" value="1" class="square-purple" checked>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="form-group">
            <div class="row">
                <div class="col-sm-12">
                    <label class="control-label"><?php echo trans('tags'); ?></label>
                    <input id="tags_1" type="text" name="tags" class="form-control tags"/>
                    <small>(<?php echo trans('type_tag'); ?>)</small>
                </div>
            </div>
        </div>

        <div class="form-group row-optional-url">
            <div class="row">
                <div class="col-sm-12">
                    <label class="control-label"><?php echo trans('optional_url'); ?></label>
                    <input type="text" class="form-control"
                           name="optional_url" placeholder="<?php echo trans('optional_url'); ?>"
                           value="<?php echo old('optional_url'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var post_type = "<?php echo $post_type; ?>";
    var text_select_a_result = "<?php echo trans("select_a_result"); ?>";
    var text_result = "<?php echo trans("result"); ?>";
    //warn before close the page
    var allow_submit_form = false;
    window.onbeforeunload = function () {
        if ($('#wr_input_post_title').val().trim().length > 0) {
            if (allow_submit_form == false) {
                return '<?php echo trans("msg_beforeunload"); ?>';
            }
        }
    };
</script>