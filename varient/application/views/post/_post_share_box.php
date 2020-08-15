<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<ul class="share-box">
    <li class="share-li-lg">
        <a href="javascript:void(0)"
           onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo generate_post_url($post); ?>', 'Share This Post', 'width=640,height=450');return false"
           class="social-btn-lg facebook">
            <i class="icon-facebook"></i>
            <span><?php echo trans("facebook"); ?></span>
        </a>
    </li>
    <li class="share-li-lg">
        <a href="javascript:void(0)"
           onclick="window.open('https://twitter.com/share?url=<?php echo generate_post_url($post); ?>&amp;text=<?php echo urlencode($post->title); ?>', 'Share This Post', 'width=640,height=450');return false"
           class="social-btn-lg twitter">
            <i class="icon-twitter"></i>
            <span><?php echo trans("twitter"); ?></span>
        </a>
    </li>
    <li class="share-li-sm">
        <a href="javascript:void(0)"
           onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo generate_post_url($post); ?>', 'Share This Post', 'width=640,height=450');return false"
           class="social-btn-sm facebook">
            <i class="icon-facebook"></i>
        </a>
    </li>
    <li class="share-li-sm">
        <a href="javascript:void(0)"
           onclick="window.open('https://twitter.com/share?url=<?php echo generate_post_url($post); ?>&amp;text=<?php echo urlencode($post->title); ?>', 'Share This Post', 'width=640,height=450');return false"
           class="social-btn-sm twitter">
            <i class="icon-twitter"></i>
        </a>
    </li>
    <li>
        <a href="javascript:void(0)"
           onclick="window.open('http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo generate_post_url($post); ?>', 'Share This Post', 'width=640,height=450');return false"
           class="social-btn-sm linkedin">
            <i class="icon-linkedin"></i>
        </a>
    </li>
    <li class="li-whatsapp">
        <a href="https://api.whatsapp.com/send?text=<?php echo urlencode($post->title); ?> - <?php echo generate_post_url($post); ?>"
           class="social-btn-sm whatsapp"
           target="_blank">
            <i class="icon-whatsapp"></i>
        </a>
    </li>
    <li>
        <a href="javascript:void(0)"
           onclick="window.open('http://pinterest.com/pin/create/button/?url=<?php echo generate_post_url($post); ?>&amp;media=<?php echo base_url() . html_escape($post->image_default); ?>', 'Share This Post', 'width=640,height=450');return false"
           class="social-btn-sm pinterest">
            <i class="icon-pinterest"></i>
        </a>
    </li>
    <li>
        <a href="javascript:void(0)"
           onclick="window.open('http://www.tumblr.com/share/link?url=<?php echo generate_post_url($post); ?>&amp;title=<?php echo urlencode($post->title); ?>', 'Share This Post', 'width=640,height=450');return false"
           class="social-btn-sm tumblr">
            <i class="icon-tumblr"></i>
        </a>
    </li>
    <li>
        <a href="javascript:void(0)" id="print_post" class="social-btn-sm btn-print">
            <i class="icon-print"></i>
        </a>
    </li>

    <!--Add to Reading List-->
    <?php if ($this->auth_check) : ?>

        <?php if ($is_reading_list == false) : ?>
            <li>
                <a href="javascript:void(0)" class="social-btn-sm add-reading-list" data-toggle-tool="tooltip" data-placement="top" title="<?php echo trans("add_reading_list"); ?>"
                   onclick="add_delete_from_reading_list('<?php echo $post->id; ?>');">
                    <i class="icon-star"></i>
                </a>
            </li>
        <?php else: ?>
            <li>
                <a href="javascript:void(0)" class="social-btn-sm remove-reading-list" data-toggle-tool="tooltip" data-placement="top" title="<?php echo trans("delete_reading_list"); ?>"
                   onclick="add_delete_from_reading_list('<?php echo $post->id; ?>');">
                    <i class="icon-star"></i>
                </a>
            </li>
        <?php endif; ?>

    <?php else: ?>
        <?php if ($this->general_settings->registration_system == 1): ?>
            <li>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-login" data-toggle-tool="tooltip" data-placement="top" title="<?php echo html_escape(trans("add_reading_list")); ?>"
                   class="social-btn-sm add-reading-list">
                    <i class="icon-star"></i>
                </a>
            </li>
        <?php endif; ?>
    <?php endif; ?>

</ul>



