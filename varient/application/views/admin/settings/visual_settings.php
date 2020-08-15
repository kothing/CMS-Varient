<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12 col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?php echo trans('visual_settings'); ?></h3>
                </div>
            </div><!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open_multipart('admin_controller/visual_settings_post'); ?>

            <div class="box-body">

                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>

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
                <div class="form-group">
                    <label><?php echo trans('block_color'); ?></label>
                    <div class="input-group my-colorpicker" style="max-width: 500px;">
                        <input type="text" class="form-control" name="site_block_color" maxlength="200" placeholder="<?php echo trans('select_color'); ?>" value="<?php echo $visual_settings->site_block_color; ?>" required>
                        <div class="input-group-addon">
                            <i></i>
                        </div>
                    </div><!-- /.input group -->
                </div>
                <div class="form-group">
                    <label><?php echo trans('post_list_style'); ?></label>

                    <div class="row m-b-15">
                        <div class="col-sm-2">
                            <div class="col-sm-12 m-b-15">
                                <input type="radio" name="post_list_style" value="vertical" class="square-purple" <?php echo ($visual_settings->post_list_style == "vertical") ? 'checked' : ''; ?> >
                            </div>
                            <img src="<?php echo base_url(); ?>assets/admin/img/post_vertical.jpg" alt="" class="img-responsive" style="width: 100px;">
                        </div>
                        <div class="col-sm-3">
                            <div class="col-sm-12 m-b-15">
                                <input type="radio" name="post_list_style" value="horizontal" class="square-purple" <?php echo ($visual_settings->post_list_style == "horizontal") ? 'checked' : ''; ?>>
                            </div>
                            <img src="<?php echo base_url(); ?>assets/admin/img/post_horizontal.jpg" alt="" class="img-responsive" style="height: 68px;">
                        </div>
                    </div>

                </div>


                <div class="form-group">
                    <label class="control-label"><?php echo trans('logo'); ?></label>
                    <div style="margin-bottom: 10px;">
                        <img src="<?php echo get_logo($visual_settings); ?>" alt="logo" style="max-width: 250px; max-height: 250px;">
                    </div>
                    <div class="display-block">
                        <a class='btn btn-success btn-sm btn-file-upload'>
                            <?php echo trans('change_logo'); ?>
                            <input type="file" name="logo" size="40" accept=".png, .jpg, .jpeg, .gif, .svg" onchange="$('#upload-file-info1').html($(this).val().replace(/.*[\/\\]/, ''));">
                        </a>
                        (.png, .jpg, .jpeg, .gif, .svg)
                    </div>
                    <span class='label label-info' id="upload-file-info1"></span>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('logo_footer'); ?></label>
                    <div style="margin-bottom: 10px;">
                        <img src="<?php echo get_logo_footer($visual_settings); ?>" alt="logo" style="max-width: 250px; max-height: 250px;">
                    </div>
                    <div class="display-block">
                        <a class='btn btn-success btn-sm btn-file-upload'>
                            <?php echo trans('change_logo'); ?>
                            <input type="file" name="logo_footer" size="40" accept=".png, .jpg, .jpeg, .gif, .svg" onchange="$('#upload-file-info2').html($(this).val().replace(/.*[\/\\]/, ''));">
                        </a>
                        (.png, .jpg, .jpeg, .gif, .svg)
                    </div>
                    <span class='label label-info' id="upload-file-info2"></span>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('logo_email'); ?></label>
                    <div style="margin-bottom: 10px;">
                        <img src="<?php echo get_logo_email($visual_settings); ?>" alt="logo" style="max-width: 200px; max-height: 200px;">
                    </div>
                    <div class="display-block">
                        <a class='btn btn-success btn-sm btn-file-upload'>
                            <?php echo trans('change_logo'); ?>
                            <input type="file" name="logo_email" size="40" accept=".png, .jpg, .jpeg" onchange="$('#upload-file-info3').html($(this).val().replace(/.*[\/\\]/, ''));">
                        </a>
                        (.png, .jpg, .jpeg)
                    </div>
                    <span class='label label-info' id="upload-file-info3"></span>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('favicon'); ?> (16x16px)</label>
                    <div style="margin-bottom: 10px;">
                        <img src="<?php echo get_favicon($visual_settings); ?>" alt="favicon" style="max-width: 100px; max-height: 100px;">
                    </div>
                    <div class="display-block">
                        <a class='btn btn-success btn-sm btn-file-upload'>
                            <?php echo trans('change_favicon'); ?>
                            <input type="file" name="favicon" size="40" accept=".png" onchange="$('#upload-file-info4').html($(this).val().replace(/.*[\/\\]/, ''));">
                        </a>
                        (.png)
                    </div>
                    <span class='label label-info' id="upload-file-info4"></span>
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

<script>
    //select site color
    $(document).on('click', '.visual-color-box', function () {
        var date_color = $(this).attr('data-color');
        $('.visual-color-box').empty();
        $(this).html('<i class="icon-check"></i>');
        $('#input_user_site_color').val(date_color);
    });
</script>