<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-sm-12">
        <!-- form start -->
        <?php echo form_open_multipart('post_controller/add_post_post'); ?>
        <input type="hidden" name="post_type" value="video">
        <div class="row">
            <div class="col-sm-12 form-header">
                <h1 class="form-title"><?php echo trans('add_video'); ?></h1>
                <a href="<?php echo admin_url(); ?>posts?lang_id=<?php echo $this->general_settings->site_lang; ?>" class="btn btn-success btn-add-new pull-right">
                    <i class="fa fa-bars"></i>
                    <?php echo trans('posts'); ?>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-post">
                    <div class="form-post-left">
                        <?php $this->load->view("admin/post/_form_add_post_left"); ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <?php $this->load->view("admin/post/_text_editor"); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-post-right">
                        <div class="row">
                            <div class="col-sm-12">
                                <?php $this->load->view('admin/post/_upload_video_box'); ?>
                            </div>
                            <div class="col-sm-12">
                                <?php $this->load->view('admin/post/_upload_video_thumbnails_box'); ?>
                            </div>
                            <div class="col-sm-12">
                                <?php $this->load->view('admin/post/_upload_file_box'); ?>
                            </div>
                            <div class="col-sm-12">
                                <?php $this->load->view('admin/post/_categories_box'); ?>
                            </div>
                            <div class="col-sm-12">
                                <?php $this->load->view('admin/post/_publish_box', ['post_type' => 'video']); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?><!-- form end -->
    </div>
</div>

<?php $this->load->view('admin/file-manager/_load_file_manager', ['load_images' => true, 'load_files' => true, 'load_videos' => true, 'load_audios' => false]); ?>
