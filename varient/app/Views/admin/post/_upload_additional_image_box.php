<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= trans('additional_images'); ?>
                <small class="small-title"><?= trans("more_main_images"); ?></small>
            </h3>
        </div>
    </div>
    <div class="box-body">
        <div class="form-group m-0">
            <div class="row">
                <div class="col-sm-12">
                    <a class='btn btn-sm bg-purple' data-toggle="modal" data-target="#file_manager_image" data-image-type="additional">
                        <?= trans('select_image'); ?>
                    </a>
                </div>
            </div>
        </div>
        <div class="form-group m-0">
            <div class="row">
                <div class="col-sm-12">
                    <?php if (!empty($post)): ?>
                        <div class="additional-image-list">
                            <?php $additionalmages = getPostAdditionalImages($post->id); ?>
                            <?php if (!empty($additionalmages)): ?>
                                <?php foreach ($additionalmages as $image):
                                    $imgBaseURL = getBaseURLByStorage($image->storage); ?>
                                    <div class="additional-item additional-item-<?= $image->id; ?>">
                                        <img class="img-additional" src="<?= $imgBaseURL . $image->image_default; ?>" alt="">
                                        <a class="btn btn-danger btn-sm btn-delete-additional-image-database" data-value="<?= $image->id; ?>">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="additional-image-list"></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>