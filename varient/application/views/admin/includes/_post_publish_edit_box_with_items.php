<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?php echo trans('publish'); ?></h3>
        </div>
    </div><!-- /.box-header -->

    <div class="box-body">

        <div class="form-group">
            <div class="row">
                <div class="col-md-5 col-sm-12 col-xs-12">
                    <label class="control-label"><?php echo trans('scheduled_post'); ?></label>
                </div>
                <div class="col-md-7 col-sm-12 col-xs-12 text-right">
                    <input type="checkbox" name="scheduled_post" value="1" id="cb_scheduled" class="square-purple" <?php echo ($post->is_scheduled == 1) ? 'checked' : ''; ?>>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-md-5 col-sm-12 col-xs-12 col-lang">
                    <label><?php echo trans('date_publish'); ?></label>
                </div>
                <div class="col-md-7 col-sm-12 col-xs-12 col-lang">
                    <div class='input-group date' id='datetimepicker'>
                        <input type='text' class="form-control" name="date_published" placeholder="<?php echo trans("date_publish"); ?>" value="<?php echo $post->created_at; ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>/>
                        <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" name="publish" value="0" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
            <a href="<?php echo admin_url(); ?>gallery-post-items/<?php echo $post->id; ?>" class="btn btn-warning pull-right m-r-5"><i class="fa fa-list"></i>&nbsp;&nbsp;<?php echo trans("edit_gallery_items"); ?></a>
        </div>
    </div>
</div>
