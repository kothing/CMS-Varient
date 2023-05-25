<?php if (!empty($galleryPostItem)):
    if ($galleryPostNumRows > 0): ?>
        <div class="gallery-post-item">
            <?php if (!empty($galleryPostItem->image)):
                $imgBaseURL = getBaseURLByStorage($galleryPostItem->storage); ?>
                <div class="post-image">
                    <div class="post-image-inner">
                        <img src="<?= $imgBaseURL . $galleryPostItem->image_large; ?>" alt="<?= esc($galleryPostItem->title); ?>" class="img-fluid" width="856" height="570"/>
                    </div>
                    <figcaption class="img-description"><?= esc($galleryPostItem->image_description); ?></figcaption>
                    <div class="post-item-count">
                        <?= esc($pageNumber); ?>&nbsp;/&nbsp;<?= esc($galleryPostNumRows); ?>
                    </div>
                </div>
            <?php endif; ?>
            <h2 class="title-post-item">
                <?php if ($post->show_item_numbers):
                    echo esc($pageNumber) . ". " . esc($galleryPostItem->title);
                else:
                    echo esc($galleryPostItem->title);
                endif; ?>
            </h2>
            <div class="post-text">
                <?= $galleryPostItem->content; ?>
            </div>
            <div class="d-flex justify-content-between mb-5 mt-5">
                <div class="item">
                    <?php if ($pageNumber != 1): ?>
                        <a href="<?= generatePostURL($post); ?>/<?= $pageNumber - 1; ?>" class="btn btn-md btn-custom"><i class="icon-arrow-left"></i>&nbsp;&nbsp;<?= trans("previous"); ?></a>
                    <?php endif; ?>
                </div>
                <div class="item">
                    <?php if ($pageNumber < $galleryPostNumRows): ?>
                        <a href="<?= generatePostURL($post); ?>/<?= $pageNumber + 1; ?>" class="btn btn-md btn-custom"><?= trans("next"); ?>&nbsp;&nbsp;<i class="icon-arrow-right"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif;
endif; ?>