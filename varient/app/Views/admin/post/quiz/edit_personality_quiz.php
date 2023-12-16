<div class="row">
    <div class="col-sm-12">
        <form action="<?= base_url('PostController/editPostPost'); ?>" method="post" enctype="multipart/form-data" onkeypress="return event.keyCode != 13;">
            <?= csrf_field(); ?>
            <input type="hidden" name="post_type" value="personality_quiz">
            <div class="row">
                <div class="col-sm-12 form-header">
                    <h1 class="form-title"><?= $title; ?></h1>
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
                                    <?= view("admin/post/_form_edit_post_left"); ?>
                                </div>
                            </div>
                            <?= view("admin/post/quiz/_results", ['post' => $post, 'postType' => $post->post_type]); ?>
                            <?= view("admin/post/quiz/_questions", ['post' => $post, 'postType' => $post->post_type]); ?>
                        </div>
                        <div class="form-post-right">
                            <div class="row">
                                <div class="col-sm-12">
                                    <?= view('admin/post/_upload_image_box'); ?>
                                </div>
                                <div class="col-sm-12">
                                    <?= view('admin/post/_post_owner_box'); ?>
                                </div>
                                <div class="col-sm-12">
                                    <?= view('admin/post/_categories_box'); ?>
                                </div>
                                <div class="col-sm-12">
                                    <?= view('admin/post/_publish_box', ['post_type' => 'personality_quiz']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?= view('admin/file-manager/_load_file_manager', ['loadImages' => true, 'loadQuizImages' => true, 'loadFiles' => false, 'loadVideos' => false, 'loadAudios' => false]); ?>