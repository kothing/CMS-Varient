<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$item_count = 1;
if (!empty($sorted_list_items)):
    foreach ($sorted_list_items as $list_item): ?>
        <div class="ordered-list-item">
            <h3 class="title-post-item">
                <?php if ($post->show_item_numbers) {
                    echo $item_count . ". " . html_escape($list_item->title);
                } else {
                    echo html_escape($list_item->title);
                } ?>
            </h3>
            <?php if (!empty($list_item->image)): ?>
                <div class="post-image">
                    <div class="post-image-inner">
                        <a class="image-popup-single lightbox" href="<?php echo base_url() . $list_item->image_large; ?>" data-effect="mfp-zoom-out" title="<?php echo html_escape($list_item->image_description); ?>">
                            <img src="<?php echo base_url() . $list_item->image; ?>" alt="<?php echo html_escape($list_item->title); ?>" class="img-responsive"/>
                        </a>
                        <figcaption class="img-description"><?php echo html_escape($list_item->image_description); ?></figcaption>
                    </div>
                </div>
            <?php endif; ?>
            <div class="post-text">
                <?php echo $list_item->content; ?>
            </div>
        </div>
        <?php
        $item_count++;
    endforeach;
endif; ?>

