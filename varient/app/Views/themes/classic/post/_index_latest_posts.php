<?php $i = 1;
if (!empty($latestPosts)):
    foreach ($latestPosts as $post):
        if ($i <= $limitLoadMorePosts):
            echo loadView("post/_post_item_horizontal", ['post' => $post, 'showLabel' => true]);
        endif;
        $i++;
    endforeach;
endif; ?>
<span id="limit_load_more_posts" class="hidden"><?= $limitLoadMorePosts; ?></span>