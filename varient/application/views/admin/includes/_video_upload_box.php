<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-md-12">

        <!-- form start -->
        <?php echo form_open_multipart('admin/settings_post'); ?>

        <!-- Custom Tabs -->
        <div class="nav-tabs-custom video-upload-tab">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><?php echo trans('upload_video'); ?>
                        <small>&nbsp;(mp4,webm)</small>
                    </a></li>
                <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false"><?php echo trans('get_video_from_url'); ?></a></li>
            </ul>
            <div class="tab-content settings-tab-content">

                <div class="tab-pane active" id="tab_1">

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <a class='btn btn-sm bg-purple' data-toggle="modal" data-target="#video_file_manager">
                                    <?php echo trans('select_file'); ?>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div id="post_selected_video" class="col-sm-12">

                            </div>
                        </div>
                    </div>

                </div>

                <div class="tab-pane" id="tab_2">



                </div>


            </div><!-- /.tab-content -->


        </div><!-- nav-tabs-custom -->

        <?php echo form_close(); ?>
    </div><!-- /.col -->
</div>
