<?php $i = 1;
if (!empty($latestPosts)):
    foreach ($latestPosts as $item):
        if ($i <= $limitLoadMorePosts):?>
            <div class="col-sm-12<?= $hasWidgets ? ' col-md-6' : ' col-md-4'; ?>">
                <?= loadView("post/_post_item", ['postItem' => $item, 'showLabel' => true]); ?>
            </div>
        <?php endif;
        $i++;
    endforeach;
endif; ?>
<span id="limit_load_more_posts" class="visually-hidden"><?= $limitLoadMorePosts; ?></span>