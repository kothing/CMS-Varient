<?php if (!empty($postItem) && !empty($type)):
    if ($postItem->post_type == 'video'): ?>
        <span class="media-icon"><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 160 160" fill="#ffffff"><path d="M80,10c39,0,70,31,70,70s-31,70-70,70s-70-31-70-70S41,10,80,10z M80,0C36,0,0,36,0,80s36,80,80,80s80-36,80-80S124,0,80,0L80,0z"/><path d="M60,40v80l60-40L60,40z"/></svg></span>
    <?php endif;
    if ($postItem->post_type == 'audio'): ?>
        <span class="media-icon"><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 160 160" fill="#ffffff"><path class="st0" d="M80,10c39,0,70,31,70,70s-31,70-70,70s-70-31-70-70S41,10,80,10z M80,0C36,0,0,36,0,80s36,80,80,80s80-36,80-80S124,0,80,0L80,0z"/><path d="M62.6,94.9c-2.5-1.7-5.8-2.8-9.4-2.8c-8,0-14.4,5.1-14.4,11.5c0,6.3,6.5,11.5,14.4,11.5s14.4-5.1,14.4-11.5v-35l36.7-5.8v26.5c-2.5-1.5-5.6-2.5-9-2.5c-8,0-14.4,5.1-14.4,11.5c0,6.3,6.5,11.5,14.4,11.5c8,0,14.4-5.1,14.4-11.5c0-0.4,0-0.9-0.1-1.3h0.1V40.2l-47.2,9.5V94.9z"/></svg></span>
    <?php endif;
    if ($type == 'featured_slider'): ?>
        <img src="<?= IMG_BASE64_600x460; ?>" alt="bg" class="img-responsive img-bg" width="600" height="460"/>
        <div class="img-container">
            <img src="<?= IMG_BASE64_600x460; ?>" data-lazy="<?= getPostImage($postItem, 'slider'); ?>" alt="<?= esc($postItem->title); ?>" class="img-cover" width="600" height="460"/>
        </div>
    <?php elseif ($type == 'random_slider'): ?>
        <img src="<?= IMG_BASE64_360x215; ?>" alt="bg" class="img-responsive img-bg" width="360" height="215"/>
        <div class="img-container">
            <img src="<?= IMG_BASE64_360x215; ?>" data-lazy="<?= getPostImage($postItem, "mid"); ?>" alt="<?= esc($postItem->title); ?>" class="img-cover" width="360" height="215"/>
        </div>
    <?php else:
        if ($type == 'featured') {
            $imgBg = IMG_BASE64_283x217;
            $image_size = "slider";
            $imgSz = ' width="283" height="217"';
        } elseif ($type == 'big') {
            $imgBg = base_url(IMG_PATH_BG_LG);
            $image_size = "big";
            $imgSz = ' width="750" height="422"';
        } elseif ($type == 'small') {
            $imgBg = IMG_BASE64_1x1;
            $image_size = "small";
            $imgSz = ' width="1" height="1"';
        } else {
            $imgBg = base_url(IMG_PATH_BG_MD);
            $image_size = "mid";
            $imgSz = ' width="1" height="1"';
        } ?>
        <?php if (!empty($postItem->image_url) || $postItem->image_mime == 'gif' || $type == 'featured'): ?>
        <img src="<?= $imgBg; ?>" alt="bg" class="img-responsive img-bg"<?= !empty($imgSz) ? $imgSz : ''; ?>/>
        <div class="img-container">
            <img src="<?= $imgBg; ?>" data-src="<?= getPostImage($postItem, $image_size); ?>" alt="<?= esc($postItem->title); ?>" class="lazyload img-cover"<?= !empty($imgSz) ? $imgSz : ''; ?>/>
        </div>
    <?php else: ?>
        <img src="<?= $imgBg; ?>" data-src="<?= getPostImage($postItem, $image_size); ?>" alt="<?= esc($postItem->title); ?>" class="lazyload img-responsive img-post"<?= !empty($imgSz) ? $imgSz : ''; ?>/>
    <?php endif;
    endif;
endif; ?>

