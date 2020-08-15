<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="post-image">
    <div class="post-image-inner">
        <?php if (count($post_images) > 0) : ?>
            <div class="show-on-page-load">
                <div id="post-detail-slider" class="post-detail-slider">
                    <div class="post-detail-slider-item">
                        <img src="<?php echo base_url() . html_escape($post->image_default); ?>" class="img-responsive center-image" alt="<?php echo html_escape($post->title); ?>"/>
                        <figcaption class="img-description"><?php echo html_escape($post->image_description); ?></figcaption>
                    </div>
                    <!--List  random slider posts-->
                    <?php foreach ($post_images as $image): ?>
                        <!-- slider item -->
                        <div class="post-detail-slider-item">
                            <img src="<?php echo base_url() . html_escape($image->image_default); ?>" class="img-responsive center-image" alt="<?php echo html_escape($post->title); ?>"/>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div id="post-detail-slider-nav" class="slider-nav post-detail-slider-nav">
                    <button class="prev"><i class="icon-arrow-left"></i></button>
                    <button class="next"><i class="icon-arrow-right"></i></button>
                </div>
            </div>
        <?php else:
            if (!empty($post->image_default) || !empty($post->image_url)):?>
                <img src="<?php echo get_post_image($post, "default"); ?>" class="img-responsive center-image" alt="<?php echo html_escape($post->title); ?>"/>
                <?php if (!empty($post->image_description)): ?>
                    <figcaption class="img-description"><?php echo html_escape($post->image_description); ?></figcaption>
                <?php endif; ?>
            <?php endif;
        endif; ?>
    </div>
</div>