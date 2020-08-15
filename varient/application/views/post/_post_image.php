<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php if (!empty($post_item) && !empty($type)): ?>

    <?php if ($post_item->post_type == 'video'): ?>
        <span class="media-icon"><i class="icon-play-circle"></i><em></em></span>
    <?php endif;
    if ($post_item->post_type == 'audio'): ?>
        <span class="media-icon"><i class="icon-music-circle"></i><em></em></span>
    <?php endif; ?>

    <?php if ($type == 'featured_slider'): ?>
        <img src="<?php echo base_url() . IMG_PATH_BG_SL; ?>" alt="bg" class="img-responsive img-bg"/>
        <div class="img-container">
            <img src="<?php echo base_url() . IMG_PATH_BG_SL; ?>" data-lazy="<?php echo get_post_image($post_item, "slider"); ?>" alt="<?php echo html_escape($post_item->title); ?>" class="img-cover"/>
        </div>
    <?php elseif ($type == 'random_slider'): ?>
        <img src="<?php echo base_url() . IMG_PATH_BG_MD; ?>" alt="bg" class="img-responsive img-bg"/>
        <div class="img-container">
            <img src="<?php echo base_url() . IMG_PATH_BG_MD; ?>" data-lazy="<?php echo get_post_image($post_item, "slider"); ?>" alt="<?php echo html_escape($post_item->title); ?>" class="img-cover"/>
        </div>
    <?php else: ?>
        <?php if ($type == 'featured') {
            $img_bg = base_url() . IMG_PATH_BG_SL;
            $image_size = "slider";
        } elseif ($type == 'big') {
            $img_bg = base_url() . IMG_PATH_BG_LG;
            $image_size = "big";
        } elseif ($type == 'small') {
            $img_bg = base_url() . IMG_PATH_BG_SM;
            $image_size = "small";
        } else {
            $img_bg = base_url() . IMG_PATH_BG_MD;
            $image_size = "mid";
        } ?>
        <?php if (!empty($post_item->image_url) || $post_item->image_mime == 'gif'): ?>
            <img src="<?php echo $img_bg; ?>" alt="bg" class="img-responsive img-bg"/>
            <div class="img-container">
                <img src="<?php echo $img_bg; ?>" data-src="<?php echo get_post_image($post_item, $image_size); ?>" alt="<?php echo html_escape($post_item->title); ?>" class="lazyload img-cover"/>
            </div>
        <?php else: ?>
            <img src="<?php echo $img_bg; ?>" data-src="<?php echo get_post_image($post_item, $image_size); ?>" alt="<?php echo html_escape($post_item->title); ?>" class="lazyload img-responsive img-post"/>
        <?php endif; ?>
    <?php endif; ?>


<?php endif; ?>

