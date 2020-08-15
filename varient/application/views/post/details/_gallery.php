<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if (!empty($gallery_post_item)):
    if ($gallery_post_total_item_count > 0): ?>
        <div class="gallery-post-item">
            <?php if (!empty($gallery_post_item->image)): ?>
                <div class="post-image">
                    <div class="post-image-inner">
                        <a class="image-popup-single lightbox" href="<?php echo base_url() . $gallery_post_item->image_large; ?>" data-effect="mfp-zoom-out" title="<?php echo html_escape($gallery_post_item->image_description); ?>">
                            <img src="<?php echo base_url() . $gallery_post_item->image; ?>" alt="<?php echo html_escape($gallery_post_item->title); ?>" class="img-responsive"/>
                        </a>
                    </div>
                    <figcaption class="img-description"><?php echo html_escape($gallery_post_item->image_description); ?></figcaption>
                    <div class="post-item-count">
                        <?php echo $gallery_post_item_order; ?>&nbsp;/&nbsp;<?php echo $gallery_post_total_item_count; ?>
                    </div>
                </div>
            <?php endif; ?>
            <h2 class="title-post-item">
                <?php if ($post->show_item_numbers):
                    echo $gallery_post_item_order . ". " . html_escape($gallery_post_item->title);
                else:
                    echo html_escape($gallery_post_item->title);
                endif; ?>
            </h2>
            <div class="post-text">
                <?php echo $gallery_post_item->content; ?>
            </div>
            <div class="gallery-post-buttons">
                <?php if ($gallery_post_item_order != 1): ?>
                    <a href="<?php echo generate_post_url($post); ?>/<?php echo($gallery_post_item_order - 1); ?>" class="btn btn-custom btn-md pull-left"><i class="icon-arrow-left"></i> <?php echo trans("previous"); ?></a>
                <?php endif; ?>
                <?php if ($gallery_post_item_order < $gallery_post_total_item_count): ?>
                    <a href="<?php echo generate_post_url($post); ?>/<?php echo($gallery_post_item_order + 1); ?>" class="btn btn-custom btn-md pull-right"><?php echo trans("next"); ?>&nbsp;<i class="icon-arrow-right"></i></a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif;
endif; ?>

