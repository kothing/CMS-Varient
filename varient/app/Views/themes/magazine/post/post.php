<section class="section section-page">
    <div class="container-xl">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                    <?php $categories = getParentCategoryTree($post->category_id, $baseCategories);
                    if (!empty($categories)):
                        foreach ($categories as $item):
                            if (!empty($item)):?>
                                <li class="breadcrumb-item"><a href="<?= generateCategoryURL($item); ?>"><?= esc($item->name); ?></a></li>
                            <?php endif;
                        endforeach;
                    endif; ?>
                    <li class="breadcrumb-item active"> <?= esc(characterLimiter($post->title, 160, '...')); ?></li>
                </ol>
            </nav>
            <div class="col-md-12 col-lg-8">
                <div class="post-content">
                    <div class="d-flex justify-content-center align-items-center mb-3">
                        <div class="bd-highlight">
                            <a href="<?= generateCategoryURLById($post->category_id, $baseCategories); ?>">
                                <span class="badge badge-category" style="background-color: <?= esc($post->category_color); ?>"><?= esc($post->category_name); ?></span>
                            </a>
                        </div>
                        <div class="bd-highlight ms-auto">
                            <?php if (authCheck() && user()->id == $post->user_id): ?>
                                <a href="<?= adminUrl('edit-post/' . $post->id); ?>" class="btn btn-sm btn-warning btn-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                    </svg>
                                    <?= trans("edit"); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <h1 class="post-title"><?= esc($post->title); ?></h1>
                    <?php if (!empty($post->summary)): ?>
                        <h2 class="post-summary">
                            <?= esc($post->summary); ?>
                        </h2>
                    <?php endif; ?>
                    <div class="d-flex align-items-center post-details-meta mb-4">
                        <?php if ($generalSettings->show_post_author == 1): ?>
                            <div class="item-meta item-meta-author">
                                <a href="<?= generateProfileURL($postUser->slug); ?>"><img src="<?= getUserAvatar($postUser->avatar); ?>" alt="<?= esc($postUser->username); ?>" width="32" height="32"><span><?= esc($postUser->username); ?></span></a>
                            </div>
                        <?php endif;
                        if ($generalSettings->show_post_date == 1): ?>
                            <div class="item-meta item-meta-date">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                                    <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                                </svg>
                                <span><?= formatDateFront($post->created_at); ?>&nbsp;-&nbsp;<?= formatHour($post->created_at); ?></span>
                            </div>
                            <?php if (!empty($post->updated_at)): ?>
                                <div class="item-meta item-meta-date">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                    </svg>
                                    <span><?= formatDateFront($post->updated_at); ?>&nbsp;-&nbsp;<?= formatHour($post->updated_at); ?></span>
                                </div>
                            <?php endif;
                        endif; ?>
                        <div class="ms-auto item-meta item-meta-comment">
                            <?php if ($generalSettings->comment_system == 1): ?>
                                <span><i class="icon-comment"></i>&nbsp;<?= esc($post->comment_count); ?></span>
                            <?php endif;
                            if ($generalSettings->show_hits): ?>
                                <span> <i class="icon-eye"></i>&nbsp;<?= esc($post->pageviews); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="d-flex post-share-buttons mb-4">
                        <?= loadView('post/_post_share'); ?>
                    </div>
                    <?php if ($post->post_type == 'video'):
                        echo loadView('post/details/_video', ['post' => $post]);
                    elseif ($post->post_type == 'audio'):
                        echo loadView('post/details/_audio', ['post' => $post]);
                    elseif ($post->post_type == 'gallery'):
                        echo loadView('post/details/_gallery', ['post' => $post]);
                    elseif ($post->post_type == 'sorted_list'):
                        echo loadView('post/details/_sorted_list', ['post' => $post]);
                    elseif ($post->post_type == 'trivia_quiz' || $post->post_type == 'personality_quiz'):
                        echo loadView('post/details/_quiz', ['post' => $post]);
                    else:
                        echo loadView('post/details/_article', ['post' => $post]);
                    endif;
                    echo loadView('partials/_ad_spaces', ['adSpace' => 'post_top', 'class' => '']);
                    if (!empty($post->content)):?>
                        <div class="post-text mt-4">
                            <?= loadView('post/_post_content'); ?>
                        </div>
                    <?php endif;
                    if (!empty($post->optional_url)) : ?>
                        <div class="d-flex flex-row-reverse mt-4">
                            <a href="<?= esc($post->optional_url); ?>" class="btn btn-md btn-custom btn-icon" target="_blank" rel="nofollow">
                                <?= esc($baseSettings->optional_url_button_name); ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="m-l-5" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                </svg>
                            </a>
                        </div>
                    <?php endif;
                    if (!empty($feed) && !empty($post->show_post_url)) : ?>
                        <div class="d-flex flex-row-reverse mt-4">
                            <a href="<?= $post->post_url; ?>" class="btn btn-md btn-custom" target="_blank" rel="nofollow">
                                <?= esc($feed->read_more_button_text); ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="m-l-5" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                </svg>
                            </a>
                        </div>
                    <?php endif;
                    $files = getPostFiles($post->id);
                    if (!empty($files)):?>
                        <div class="post-files">
                            <h2 class="title"><?= trans("files"); ?></h2>
                            <?php foreach ($files as $file): ?>
                                <form action="<?= base_url('download-file'); ?>" method="post">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="id" value="<?= $file->id; ?>">
                                    <div class="file">
                                        <button type="submit" name="file_type" value="file">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-fill" viewBox="0 0 16 16">
                                                <path d="M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm5.5 1.5v2a1 1 0 0 0 1 1h2l-3-3z"/>
                                            </svg>
                                            <?= esc($file->file_name); ?>
                                        </button>
                                    </div>
                                </form>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <div class="d-flex flex-row post-tags align-items-center mt-5">
                        <h2 class="title"><?= trans("post_tags"); ?></h2>
                        <ul class="d-flex flex-row">
                            <?php foreach ($postTags as $tag) : ?>
                                <li><a href="<?= generateTagURL($tag->tag_slug); ?>"><?= esc($tag->tag); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="post-next-prev mt-5">
                        <div class="row">
                            <div class="col-sm-6 col-xs-12 left">
                                <?php if (!empty($previousPost)): ?>
                                    <div class="head-title text-end">
                                        <a href="<?= generatePostURL($previousPost); ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                                            </svg>
                                            <?= trans("previous_article"); ?>
                                        </a>
                                    </div>
                                    <h3 class="title text-end">
                                        <a href="<?= generatePostURL($previousPost); ?>"><?= esc(characterLimiter($previousPost->title, 80, '...')); ?></a>
                                    </h3>
                                <?php endif; ?>
                            </div>
                            <div class="col-sm-6 col-xs-12 right">
                                <?php if (!empty($nextPost)): ?>
                                    <div class="head-title text-start">
                                        <a href="<?= generatePostURL($nextPost); ?>">
                                            <?= trans("next_article"); ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                            </svg>
                                        </a>
                                    </div>
                                    <h3 class="title text-start">
                                        <a href="<?= generatePostURL($nextPost); ?>"><?= esc(characterLimiter($nextPost->title, 80, '...')); ?></a>
                                    </h3>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php if ($generalSettings->emoji_reactions == 1): ?>
                        <div class="row">
                            <div class="col-sm-12 col-xs-12 reactions noselect">
                                <h4 class="title-reactions"><?= trans("whats_your_reaction"); ?></h4>
                                <div id="reactions_result">
                                    <?= view('common/_emoji_reactions', ['reactions' => $reactions]); ?>
                                </div>
                            </div>
                        </div>
                    <?php endif;
                    if (!empty($postUser) && $generalSettings->show_post_author == 1): ?>
                        <div class="d-flex about-author">
                            <div class="flex-shrink-0">
                                <a href="<?= generateProfileURL($postUser->slug); ?>" class="author-link">
                                    <img src="<?= getUserAvatar($postUser->avatar); ?>" alt="<?= esc($postUser->username); ?>" class="img-fluid img-author" width="110" height="110">
                                </a>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <strong class="username"><a href="<?= generateProfileURL($postUser->slug); ?>"> <?= esc($postUser->username); ?> </a></strong>
                                <?= esc($postUser->about_me); ?>
                                <div class="social">
                                    <ul class="profile-social-links">
                                        <?php if (!empty($postUser->facebook_url)): ?>
                                            <li><a href="<?= esc($postUser->facebook_url); ?>" target="_blank"><i class="icon-facebook"></i></a></li>
                                        <?php endif;
                                        if (!empty($postUser->twitter_url)): ?>
                                            <li><a href="<?= esc($postUser->twitter_url); ?>" target="_blank"><i class="icon-twitter"></i></a></li>
                                        <?php endif;
                                        if (!empty($postUser->instagram_url)): ?>
                                            <li><a href="<?= esc($postUser->instagram_url); ?>" target="_blank"><i class="icon-instagram"></i></a></li>
                                        <?php endif;
                                        if (!empty($postUser->pinterest_url)): ?>
                                            <li><a href="<?= esc($postUser->pinterest_url); ?>" target="_blank"><i class="icon-pinterest"></i></a></li>
                                        <?php endif;
                                        if (!empty($postUser->linkedin_url)): ?>
                                            <li><a href="<?= esc($postUser->linkedin_url); ?>" target="_blank"><i class="icon-linkedin"></i></a></li>
                                        <?php endif;
                                        if (!empty($postUser->vk_url)): ?>
                                            <li><a href="<?= esc($postUser->vk_url); ?>" target="_blank"><i class="icon-vk"></i></a></li>
                                        <?php endif;
                                        if (!empty($postUser->telegram_url)): ?>
                                            <li><a href="<?= esc($postUser->telegram_url); ?>" target="_blank"><i class="icon-telegram"></i></a></li>
                                        <?php endif;
                                        if (!empty($postUser->youtube_url)): ?>
                                            <li><a href="<?= esc($postUser->youtube_url); ?>" target="_blank"><i class="icon-youtube"></i></a></li>
                                        <?php endif;
                                        if ($postUser->show_rss_feeds): ?>
                                            <li><a href="<?= langBaseUrl('rss/author/' . $postUser->slug); ?>"><i class="icon-rss"></i></a></li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endif;
                    echo loadView('partials/_ad_spaces', ['adSpace' => 'post_bottom', 'class' => '']); ?>
                    <section class="section section-related-posts mt-5">
                        <div class="row">
                            <div class="col-12">
                                <div class="section-title">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h3 class="title"><?= trans("related_posts"); ?></h3>
                                    </div>
                                </div>
                                <div class="section-content">
                                    <div class="row">
                                        <?php $i = 0;
                                        if (!empty($relatedPosts)):
                                            foreach ($relatedPosts as $item):
                                                if ($i < 3):?>
                                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                                        <div class="post-item<?= checkPostImg($item, 'class'); ?>">
                                                            <?php if (checkPostImg($item)): ?>
                                                                <div class="image ratio">
                                                                    <a href="<?= generatePostURL($item); ?>"<?php postURLNewTab($item); ?>>
                                                                        <img src="<?= IMG_BASE64_450x280; ?>" data-src="<?= getPostImage($item, 'mid'); ?>" alt="<?= esc($item->title); ?>" class="img-fluid lazyload" width="269" height="160"/>
                                                                        <?php getMediaIcon($item, 'media-icon'); ?>
                                                                    </a>
                                                                </div>
                                                            <?php endif; ?>
                                                            <h3 class="title fsize-16"><a href="<?= generatePostURL($item); ?>"<?php postURLNewTab($this, $item); ?>><?= esc(characterLimiter($item->title, 55, '...')); ?></a></h3>
                                                            <p class="small-post-meta"><?= loadView('post/_post_meta', ['postItem' => $item]); ?></p>
                                                        </div>
                                                    </div>
                                                <?php endif;
                                                $i++;
                                            endforeach;
                                        endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <?php if ($generalSettings->comment_system == 1 || $generalSettings->facebook_comment_active == 1): ?>
                        <section class="section section-comments mt-5">
                            <div class="row">
                                <div class="col-12">
                                    <div class="nav nav-tabs" id="navTabsComment" role="tablist">
                                        <?php if ($generalSettings->comment_system == 1): ?>
                                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#navComments" type="button" role="tab"><?= trans("comments"); ?></button>
                                        <?php endif;
                                        if ($generalSettings->facebook_comment_active == 1): ?>
                                            <button class="nav-link <?= $generalSettings->comment_system != 1 ? 'active' : ''; ?>" data-bs-toggle="tab" data-bs-target="#navFacebookComments" type="button" role="tab"><?= trans("facebook_comments"); ?></button>
                                        <?php endif; ?>
                                    </div>
                                    <div class="tab-content" id="navTabsComment">
                                        <?php if ($generalSettings->comment_system == 1): ?>
                                            <div class="tab-pane fade show active" id="navComments" role="tabpanel" aria-labelledby="nav-home-tab">
                                                <?= view('common/_add_comment', ['post' => $post, 'commentCount' => $post->comment_count]); ?>
                                                <div id="comment-result">
                                                    <?= view('common/_comments', ['post' => $post, 'commentCount' => $post->comment_count, 'isBs5' => true]); ?>
                                                </div>
                                            </div>
                                        <?php endif;
                                        if ($generalSettings->facebook_comment_active == 1): ?>
                                            <div class="tab-pane <?= $generalSettings->comment_system != 1 ? 'active' : 'fade'; ?>" id="navFacebookComments" role="tabpanel" aria-labelledby="nav-profile-tab">
                                                <div id="div_fb_comments" class="fb-comments" data-href="<?= currentFullURL(); ?>" data-width="100%" data-numposts="5" data-colorscheme="<?= $darkMode == 1 ? 'dark' : 'light'; ?>"></div>
                                                <script>document.getElementById("div_fb_comments").setAttribute("data-href", window.location.href);</script>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </section>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <?= loadView('partials/_sidebar'); ?>
            </div>
        </div>
    </div>
</section>
<?php if ($generalSettings->facebook_comment_active) {
    echo $generalSettings->facebook_comment;
}
if (!empty($post->feed_id)): ?>
    <style>
        .post-text img {
            display: none !important;
        }

        .post-content .post-summary {
            display: none;
        }
    </style>
<?php endif; ?>