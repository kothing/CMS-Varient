<?php $postURL = urlencode(generatePostURL($post));
$postTitle = urlencode($post->title); ?>
<ul class="share-box">
    <li class="share-li-lg">
        <a href="javascript:void(0)" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?= $postURL; ?>', 'Share This Post', 'width=640,height=450');return false" class="social-btn-lg facebook">
            <i class="icon-facebook"></i>
            <span><?= trans("facebook"); ?></span>
        </a>
    </li>
    <li class="share-li-lg">
        <a href="javascript:void(0)" onclick="window.open('https://twitter.com/share?url=<?= $postURL; ?>&amp;text=<?= $postTitle; ?>', 'Share This Post', 'width=640,height=450');return false" class="social-btn-lg twitter">
            <i class="icon-twitter"></i>
            <span><?= trans("twitter"); ?></span>
        </a>
    </li>
    <li class="share-li-sm">
        <a href="javascript:void(0)" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?= $postURL; ?>', 'Share This Post', 'width=640,height=450');return false" class="social-btn-sm facebook">
            <i class="icon-facebook"></i>
        </a>
    </li>
    <li class="share-li-sm">
        <a href="javascript:void(0)" onclick="window.open('https://twitter.com/share?url=<?= $postURL; ?>&amp;text=<?= $postTitle; ?>', 'Share This Post', 'width=640,height=450');return false" class="social-btn-sm twitter">
            <i class="icon-twitter"></i>
        </a>
    </li>
    <li>
        <a href="javascript:void(0)" onclick="window.open('http://www.linkedin.com/shareArticle?mini=true&amp;url=<?= $postURL; ?>', 'Share This Post', 'width=640,height=450');return false" class="social-btn-sm linkedin">
            <i class="icon-linkedin"></i>
        </a>
    </li>
    <li class="li-whatsapp">
        <a href="https://api.whatsapp.com/send?text=<?= $postTitle; ?> - <?= $postURL; ?>" class="social-btn-sm whatsapp" target="_blank">
            <i class="icon-whatsapp"></i>
        </a>
    </li>
    <li>
        <a href="javascript:void(0)" onclick="window.open('http://pinterest.com/pin/create/button/?url=<?= $postURL; ?>&amp;media=<?= base_url($post->image_default); ?>', 'Share This Post', 'width=640,height=450');return false" class="social-btn-sm pinterest">
            <i class="icon-pinterest"></i>
        </a>
    </li>
    <li>
        <a href="javascript:void(0)" onclick="window.open('http://www.tumblr.com/share/link?url=<?= $postURL; ?>&amp;title=<?= $postTitle; ?>', 'Share This Post', 'width=640,height=450');return false" class="social-btn-sm tumblr">
            <i class="icon-tumblr"></i>
        </a>
    </li>
    <li>
        <a href="javascript:void(0)" id="print_post" class="social-btn-sm btn-print">
            <i class="icon-print"></i>
        </a>
    </li>
    <?php if (authCheck()) :
        if (isPostInReadingList($post->id) == false) : ?>
            <li>
                <a href="javascript:void(0)" class="social-btn-sm add-reading-list" data-toggle-tool="tooltip" data-placement="top" title="<?= trans("add_reading_list"); ?>" onclick="addRemoveReadingListItem('<?= $post->id; ?>');">
                    <i class="icon-star"></i>
                </a>
            </li>
        <?php else: ?>
            <li>
                <a href="javascript:void(0)" class="social-btn-sm remove-reading-list" data-toggle-tool="tooltip" data-placement="top" title="<?= trans("delete_reading_list"); ?>" onclick="addRemoveReadingListItem('<?= $post->id; ?>');">
                    <i class="icon-star"></i>
                </a>
            </li>
        <?php endif;
    else:
        if ($generalSettings->registration_system == 1): ?>
            <li>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-login" data-toggle-tool="tooltip" data-placement="top" title="<?= trans("add_reading_list"); ?>" class="social-btn-sm add-reading-list">
                    <i class="icon-star"></i>
                </a>
            </li>
        <?php endif;
    endif; ?>
</ul>