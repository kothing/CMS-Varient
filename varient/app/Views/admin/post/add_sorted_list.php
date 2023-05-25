<div class="row">
    <div class="col-sm-12">
        <form action="<?= base_url('PostController/addPostPost'); ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <input type="hidden" name="post_type" value="sorted_list">
            <div class="row">
                <div class="col-sm-12 form-header">
                    <h1 class="form-title"><?= trans('add_sorted_list'); ?></h1>
                    <a href="<?= adminUrl('posts'); ?>" class="btn btn-success btn-add-new pull-right">
                        <i class="fa fa-bars"></i>
                        <?= trans('posts'); ?>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <?= view('admin/includes/_messages'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-post">
                        <div class="form-post-left">
                            <div class="row">
                                <div class="col-sm-12">
                                    <?= view("admin/post/_form_add_post_left"); ?>
                                </div>
                            </div>
                            <?= view("admin/post/_post_list_items", ['title' => trans('sorted_list_items')]); ?>
                        </div>
                        <div class="form-post-right">
                            <div class="row">
                                <div class="col-sm-12">
                                    <?= view('admin/post/_upload_image_box'); ?>
                                </div>
                                <div class="col-sm-12">
                                    <?= view('admin/post/_categories_box'); ?>
                                </div>
                                <div class="col-sm-12">
                                    <?= view('admin/post/_publish_box', ['postType' => 'sorted_list']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?= view('admin/file-manager/_load_file_manager', ['loadImages' => true, 'loadFiles' => false, 'loadVideos' => false, 'loadAudios' => false]); ?>