<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo trans('update_widget'); ?></h3>
                </div>
                <!-- /.box-header -->

                <!-- form start -->
                <?php echo form_open('widget_controller/update_widget_post');?>

                <input type="hidden" name="id" value="<?php echo html_escape($widget->id); ?>">
                <input type="hidden" name="is_custom" value="<?php echo html_escape($widget->is_custom); ?>">
                <input type="hidden" name="type" value="<?php echo html_escape($widget->type); ?>">

                <div class="box-body">
                    <!-- include message block -->
                    <?php $this->load->view('admin/includes/_messages'); ?>

                    <div class="form-group">
                        <label class="control-label"><?php echo trans('title'); ?></label>
                        <input type="text" class="form-control" name="title" placeholder="<?php echo trans('title'); ?>" value="<?php echo html_escape($widget->title); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>
                    <div class="form-group">
                        <label><?php echo trans("language"); ?></label>
                        <select name="lang_id" class="form-control max-600">
                            <?php foreach ($this->languages as $language): ?>
                                <option value="<?php echo $language->id; ?>" <?php echo ($widget->lang_id == $language->id) ? 'selected' : ''; ?>><?php echo $language->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?php echo trans('order_1'); ?></label>
                        <input type="number" class="form-control max-600" name="widget_order" min="1" max="3000" placeholder="<?php echo trans('order_1'); ?>" value="<?php echo html_escape($widget->widget_order); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12">
                                <label><?php echo trans('visibility'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" id="rb_visibility_1" name="visibility" value="1" class="square-purple" <?php echo ($widget->visibility == 1) ? 'checked' : ''; ?>>
                                <label for="rb_visibility_1" class="cursor-pointer"><?php echo trans('show'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" id="rb_visibility_2" name="visibility" value="0" class="square-purple" <?php echo ($widget->visibility == 0) ? 'checked' : ''; ?>>
                                <label for="rb_visibility_2" class="cursor-pointer"><?php echo trans('hide'); ?></label>
                            </div>
                        </div>
                    </div>

                    <?php if ($widget->is_custom == 1): ?>
                        <div class="form-group">
                            <div id="main_editor">
                                <label><?php echo trans('content'); ?></label>
                                <div class="row">
                                    <div class="col-sm-12 editor-buttons">
                                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#file_manager_image" data-image-type="editor"><i class="fa fa-image"></i>&nbsp;&nbsp;&nbsp;<?php echo trans("add_image"); ?></button>
                                        <button type="button" class="btn btn-sm bg-purple btn_tinymce_add_media" data-editor-id="main_editor"><i class="fa fa-file"></i>&nbsp;&nbsp;&nbsp;<?php echo trans("add_media"); ?></button>
                                    </div>
                                </div>
                                <textarea class="tinyMCE form-control" name="content"><?php echo $widget->content; ?></textarea>
                            </div>
                        </div>
                    <?php else: ?>
                        <input type="hidden" value="" name="content">
                    <?php endif; ?>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
                </div>
                <!-- /.box-footer -->
                <?php echo form_close(); ?><!-- form end -->
            </div>
            <!-- /.box -->
        </div>
    </div>

<?php $this->load->view('admin/file-manager/_load_file_manager', ['load_images' => true, 'load_files' => false, 'load_videos' => false, 'load_audios' => false]); ?>