<?php if (!empty($galleryPostItem)):
    if ($galleryPostNumRows > 0): ?>
        <div class="gallery-post-item">
            <?php if (!empty($galleryPostItem->image)):
                $imgBaseURL = getBaseURLByStorage($galleryPostItem->storage); ?>
                <div class="post-image">
                    <div class="post-image-inner">
                        <a class="image-popup-single lightbox" href="<?= $imgBaseURL . $galleryPostItem->image_large; ?>" data-effect="mfp-zoom-out" title="<?= esc($galleryPostItem->image_description); ?>">
                            <img src="<?= $imgBaseURL . $galleryPostItem->image; ?>" alt="<?= esc($galleryPostItem->title); ?>" class="img-responsive"/>
                        </a>
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
            <div class="gallery-post-buttons">
                <?php if ($pageNumber != 1): ?>
                    <a href="<?= generatePostURL($post); ?>/<?= $pageNumber - 1; ?>" class="btn btn-custom btn-md pull-left"><i class="icon-arrow-left"></i> <?= trans("previous"); ?></a>
                <?php endif;
                if ($pageNumber < $galleryPostNumRows): ?>
                    <a href="<?= generatePostURL($post); ?>/<?= $pageNumber + 1; ?>" class="btn btn-custom btn-md pull-right"><?= trans("next"); ?>&nbsp;<i class="icon-arrow-right"></i></a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif;
endif; ?>