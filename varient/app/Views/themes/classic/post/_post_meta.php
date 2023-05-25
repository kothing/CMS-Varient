<?php if ($generalSettings->show_post_author == 1): ?>
    <a href="<?= generateProfileURL($post->author_slug); ?>"><?= esc($post->author_username); ?></a>
<?php endif;
if ($generalSettings->show_post_date == 1): ?>
    <span><?= formatDateFront($post->created_at); ?></span>
<?php endif;
if ($generalSettings->comment_system == 1): ?>
    <span><i class="icon-comment"></i><?= $post->comment_count; ?></span>
<?php endif;
if ($generalSettings->show_hits): ?>
    <span class="m-r-0"><i class="icon-eye"></i><?= isset($post->pageviews_count) ? $post->pageviews_count : $post->pageviews; ?></span>
<?php endif; ?>