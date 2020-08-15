<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-5 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("update_language"); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('language_controller/update_language_post'); ?>

            <input type="hidden" name="id" value="<?php echo html_escape($language->id); ?>">

            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>

                <div class="form-group">
                    <label><?php echo trans("language_name"); ?></label>
                    <input type="text" class="form-control" name="name" placeholder="<?php echo trans("language_name"); ?>"
                           value="<?php echo $language->name; ?>" maxlength="200" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                    <small>(Ex: English)</small>
                </div>

                <?php if ($language->short_form == "en"): ?>
                    <div class="form-group">
                        <label class="control-label"><?php echo trans("short_form"); ?> </label>
                        <input type="text" class="form-control" name="short_form" placeholder="<?php echo trans("short_form"); ?>"
                               value="<?php echo $language->short_form; ?>" maxlength="200" readonly <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                        <small>(Ex: en)</small>
                    </div>
                <?php else: ?>
                    <div class="form-group">
                        <label class="control-label"><?php echo trans("short_form"); ?> </label>
                        <input type="text" class="form-control" name="short_form" placeholder="<?php echo trans("short_form"); ?>"
                               value="<?php echo $language->short_form; ?>" maxlength="200" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                        <small>(Ex: en)</small>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label class="control-label"><?php echo trans("language_code"); ?> </label>
                    <input type="text" class="form-control" name="language_code" placeholder="<?php echo trans("language_code"); ?>"
                           value="<?php echo $language->language_code; ?>" maxlength="200" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                    <small>(Ex: en_us)</small>
                </div>

                <div class="form-group">
                    <label><?php echo trans('order_1'); ?></label>
                    <input type="number" class="form-control" name="language_order" placeholder="<?php echo trans('order_1'); ?>"
                           value="<?php echo $language->language_order; ?>" min="1" max="3000" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <label><?php echo trans('text_direction'); ?></label>
                        </div>
                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="rb_type_1" name="text_direction" value="ltr" class="square-purple" <?php echo ($language->text_direction == "ltr") ? 'checked' : ''; ?>>
                            <label for="rb_type_1" class="cursor-pointer"><?php echo trans("left_to_right"); ?></label>
                        </div>
                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="rb_type_2" name="text_direction" value="rtl" class="square-purple" <?php echo ($language->text_direction == "rtl") ? 'checked' : ''; ?>>
                            <label for="rb_type_2" class="cursor-pointer"><?php echo trans("right_to_left"); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3 col-xs-12">
                            <label><?php echo trans('status'); ?></label>
                        </div>
                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="status" value="1" id="status1" class="square-purple" <?php echo ($language->status == "1") ? 'checked' : ''; ?>>
                            <label for="status1" class="option-label"><?php echo trans('active'); ?></label>
                        </div>
                        <div class="col-sm-4 col-xs-12 col-option">
                            <input type="radio" name="status" value="0" id="status2" class="square-purple" <?php echo ($language->status != "1") ? 'checked' : ''; ?>>
                            <label for="status2" class="option-label"><?php echo trans('inactive'); ?></label>
                        </div>
                    </div>
                </div>


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
