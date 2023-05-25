<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a>
                    </li>
                    <?php $categories = getParentCategoryTree($post->category_id, $baseCategories);
                    if (!empty($categories)):
                        foreach ($categories as $item): ?>
                            <li class="breadcrumb-item active"><a href="<?= generateCategoryURL($item); ?>"><?= esc($item->name); ?></a></li>
                        <?php endforeach;
                    endif; ?>
                    <li class="breadcrumb-item active"> <?= esc(characterLimiter($post->title, 160, '...')); ?></li>
                </ol>
            </div>
            <div id="content" class="<?php echo ($post->show_right_column == 1) ? 'col-sm-8' : 'col-sm-12'; ?> col-xs-12">
                <div class="post-content">
                    <p class="m-0">
                        <a href="<?= generateCategoryURLById($post->category_id, $baseCategories); ?>">
                            <label class="category-label" style="background-color: <?= esc($post->category_color); ?>">
                                <?= esc($post->category_name); ?>
                            </label>
                        </a>
                        <?php if (authCheck() && user()->id == $post->user_id): ?>
                            <a href="<?= adminUrl('edit-post/' . $post->id); ?>" class="pull-right btn btn-xs btn-info btn-edit-post"><i class="icon-edit"></i><?= trans("edit"); ?></a>
                        <?php endif; ?>
                    </p>
                    <h1 class="title"><?= esc($post->title); ?></h1>
                    <?php if (!empty($post->summary)): ?>
                        <div class="post-summary">
                            <h2>
                                <?= esc($post->summary); ?>
                            </h2>
                        </div>
                    <?php endif; ?>
                    <div class="post-meta">
                        <?php if ($generalSettings->show_post_author == 1): ?>
                            <span class="post-author-meta sp-left">
                                <a href="<?= generateProfileURL($postUser->slug); ?>" class="m-r-0">
                                    <img src="<?= getUserAvatar($postUser->avatar); ?>" alt="<?= esc($postUser->username); ?>">
                                    <?= esc($postUser->username); ?>
                                </a>
                            </span>
                        <?php endif; ?>
                        <div class="post-details-meta-date">
                            <?php if ($generalSettings->show_post_date == 1): ?>
                                <span class="sp-left"><?= formatDateFront($post->created_at); ?>&nbsp;-&nbsp;<?= formatHour($post->created_at); ?></span>
                                <?php if (!empty($post->updated_at)): ?>
                                    <span class="sp-left sp-post-update-date"><?= trans("updated"); ?>:&nbsp;<?= formatDateFront($post->updated_at); ?>&nbsp;-&nbsp;<?= formatHour($post->updated_at); ?></span>
                                <?php endif;
                            endif; ?>
                        </div>
                        <div class="post-comment-pageviews">
                            <?php if ($generalSettings->comment_system == 1): ?>
                                <span class="comment"><i class="icon-comment"></i><?= esc($post->comment_count); ?></span>
                            <?php endif;
                            if ($generalSettings->show_hits): ?>
                                <span><i class="icon-eye"></i><?= esc($post->pageviews); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="post-share">
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
                        <div class="post-text">
                            <?= loadView('post/_post_content'); ?>
                        </div>
                    <?php endif;
                    if (!empty($post->optional_url)) : ?>
                        <div class="optional-url-cnt">
                            <a href="<?= esc($post->optional_url); ?>" class="btn btn-md btn-custom" target="_blank" rel="nofollow">
                                <?= esc($baseSettings->optional_url_button_name); ?>&nbsp;&nbsp;&nbsp;<i class="icon-long-arrow-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    <?php endif;
                    if (!empty($feed) && !empty($post->show_post_url)) : ?>
                        <div class="optional-url-cnt">
                            <a href="<?= $post->post_url; ?>" class="btn btn-md btn-custom" target="_blank" rel="nofollow">
                                <?= esc($feed->read_more_button_text); ?>&nbsp;&nbsp;&nbsp;<i class="icon-long-arrow-right" aria-hidden="true"></i>
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
                                        <button type="submit" name="file_type" value="file"><i class="icon-file"></i><?= esc($file->file_name); ?></button>
                                    </div>
                                </form>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <div class="post-tags">
                        <?php if (!empty($postTags)): ?>
                            <h2 class="tags-title"><?= trans("post_tags"); ?></h2>
                            <ul class="tag-list">
                                <?php foreach ($postTags as $tag) : ?>
                                    <li><a href="<?= generateTagURL($tag->tag_slug); ?>"><?= esc($tag->tag); ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-sm-12 post-next-prev">
                    <div class="row">
                        <div class="col-sm-6 col-xs-12 left">
                            <?php if (!empty($previousPost)): ?>
                                <p>
                                    <a href="<?= generatePostURL($previousPost); ?>"><span><i class="icon-angle-left" aria-hidden="true"></i><?= trans("previous_article"); ?></span></a>
                                </p>
                                <h3 class="title">
                                    <a href="<?= generatePostURL($previousPost); ?>"><?= esc(characterLimiter($previousPost->title, 80, '...')); ?></a>
                                </h3>
                            <?php endif; ?>
                        </div>
                        <div class="col-sm-6 col-xs-12 right">
                            <?php if (!empty($nextPost)): ?>
                                <p>
                                    <a href="<?= generatePostURL($nextPost); ?>"><span><?= trans("next_article"); ?><i class="icon-angle-right" aria-hidden="true"></i></span></a>
                                </p>
                                <h3 class="title">
                                    <a href="<?= generatePostURL($nextPost); ?>"><?= esc(characterLimiter($nextPost->title, 80, '...')); ?></a>
                                </h3>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php if ($generalSettings->emoji_reactions == 1): ?>
                    <div class="col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="reactions noselect">
                                <h4 class="title-reactions"><?= trans("whats_your_reaction"); ?></h4>
                                <div id="reactions_result">
                                    <?= view('common/_emoji_reactions', ['reactions' => $reactions]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif;
                echo loadView('partials/_ad_spaces', ['adSpace' => 'post_bottom', 'class' => 'bn-p-b']);
                if ($generalSettings->show_post_author == 1):
                    echo loadView('post/_post_about_author', ['postUser' => $postUser]);
                endif; ?>
                <section class="section section-related-posts">
                    <div class="section-head">
                        <h4 class="title"><?= trans("related_posts"); ?></h4>
                    </div>
                    <div class="section-content">
                        <div class="row">
                            <?php $i = 0;
                            foreach ($relatedPosts as $item):
                                if ($i > 0 && $i % 3 == 0): ?>
                                    <div class="col-sm-12"></div>
                                <?php endif; ?>
                                <div class="col-sm-4 col-xs-12">
                                    <?= loadView("post/_post_item_mid", ['post' => $item]); ?>
                                </div>
                                <?php $i++;
                            endforeach; ?>
                        </div>
                    </div>
                </section>
                <?php if ($generalSettings->comment_system == 1 || $generalSettings->facebook_comment_active == 1): ?>
                    <section id="comments" class="section">
                        <div class="col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="comment-section">
                                    <?php if ($generalSettings->comment_system == 1 || $generalSettings->facebook_comment_active == 1): ?>
                                        <ul class="nav nav-tabs">
                                            <?php if ($generalSettings->comment_system == 1): ?>
                                                <li class="active"><a data-toggle="tab" href="#site_comments"><?= trans("comments"); ?></a></li>
                                            <?php endif; ?>
                                            <?php if ($generalSettings->facebook_comment_active == 1): ?>
                                                <li class="<?= $generalSettings->comment_system != 1 ? 'active' : ''; ?>"><a data-toggle="tab" href="#facebook_comments"><?= trans("facebook_comments"); ?></a></li>
                                            <?php endif; ?>
                                        </ul>
                                        <div class="tab-content">
                                            <?php if ($generalSettings->comment_system == 1): ?>
                                                <div id="site_comments" class="tab-pane fade in active">
                                                    <?= view('common/_add_comment', ['post' => $post, 'commentCount' => $post->comment_count]); ?>
                                                    <div id="comment-result">
                                                        <?= view('common/_comments', ['post' => $post, 'commentCount' => $post->comment_count]); ?>
                                                    </div>
                                                </div>
                                            <?php endif;
                                            if ($generalSettings->facebook_comment_active == 1): ?>
                                                <div id="facebook_comments" class="tab-pane fade <?= $generalSettings->comment_system != 1 ? 'in active' : ''; ?>">
                                                    <div id="div_fb_comments" class="fb-comments" data-href="<?= currentFullURL(); ?>" data-width="100%" data-numposts="5" data-colorscheme="<?= $darkMode == 1 ? 'dark' : 'light'; ?>"></div>
                                                    <script>document.getElementById("div_fb_comments").setAttribute("data-href", window.location.href);</script>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </section>
                <?php endif; ?>
            </div>
            <?php if ($post->show_right_column == 1): ?>
                <div id="sidebar" class="col-sm-4 col-xs-12">
                    <?= loadView('partials/_sidebar'); ?>
                </div>
            <?php else: ?>
            <style>.post-item-mid .post-item-image {height: 224px;}</style>
            <?php endif; ?>
        </div>
    </div>
</div>
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