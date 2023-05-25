<?php if (!empty($widgetKey)):
    $widget = getWidget($baseWidgets, $widgetKey);
    if (!empty($widget) && $widget->visibility == 1):
        if ($widget->type == 'follow-us'): ?>
            <div class="sidebar-widget">
                <div class="widget-head"><h4 class="title"><?= esc($widget->title); ?></h4></div>
                <div class="widget-body">
                    <div class="row gx-3 widget-follow">
                        <?php if (!empty($baseSettings->facebook_url)) : ?>
                            <div class="col-sm-3 col-md-6 item"><a class="color-facebook" href="<?= esc($baseSettings->facebook_url); ?>" target="_blank"><i class="icon-facebook"></i><span>Facebook</span></a></div>
                        <?php endif;
                        if (!empty($baseSettings->twitter_url)) : ?>
                            <div class="col-sm-3 col-md-6 item"><a class="color-twitter" href="<?= esc($baseSettings->twitter_url); ?>" target="_blank"><i class="icon-twitter"></i><span>Twitter</span></a></div>
                        <?php endif;
                        if (!empty($baseSettings->instagram_url)) : ?>
                            <div class="col-sm-3 col-md-6 item"><a class="color-instagram" href="<?= esc($baseSettings->instagram_url); ?>" target="_blank"><i class="icon-instagram"></i><span>Instagram</span></a></div>
                        <?php endif;
                        if (!empty($baseSettings->pinterest_url)) : ?>
                            <div class="col-sm-3 col-md-6 item"><a class="color-pinterest" href="<?= esc($baseSettings->pinterest_url); ?>" target="_blank"><i class="icon-pinterest"></i><span>Pinterest</span></a></div>
                        <?php endif;
                        if (!empty($baseSettings->linkedin_url)) : ?>
                            <div class="col-sm-3 col-md-6 item"><a class="color-linkedin" href="<?= esc($baseSettings->linkedin_url); ?>" target="_blank"><i class="icon-linkedin"></i><span>Linkedin</span></a></div>
                        <?php endif;
                        if (!empty($baseSettings->vk_url)) : ?>
                            <div class="col-sm-3 col-md-6 item"><a class="color-vk" href="<?= esc($baseSettings->vk_url); ?>" target="_blank"><i class="icon-vk"></i><span>VK</span></a></div>
                        <?php endif;
                        if (!empty($baseSettings->telegram_url)) : ?>
                            <div class="col-sm-3 col-md-6 item"><a class="color-telegram" href="<?= esc($baseSettings->telegram_url); ?>" target="_blank"><i class="icon-telegram"></i><span>Telegram</span></a></div>
                        <?php endif;
                        if (!empty($baseSettings->youtube_url)) : ?>
                            <div class="col-sm-3 col-md-6 item"><a class="color-youtube" href="<?= esc($baseSettings->youtube_url); ?>" target="_blank"><i class="icon-youtube"></i><span>Youtube</span></a></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php elseif ($widget->type == 'popular-posts'): ?>
            <div class="sidebar-widget">
                <div class="widget-head"><h4 class="title"><?= esc($widget->title); ?></h4></div>
                <div class="widget-body">
                    <div class="row">
                        <?php $popularPosts = getPopularPosts($activeLang->id, $baseLatestCategoryPosts);
                        if (!empty($popularPosts)):
                            foreach ($popularPosts as $item): ?>
                                <div class="col-12">
                                    <?= loadView('post/_post_item_small', ['postItem' => $item, 'showLabel' => false]); ?>
                                </div>
                            <?php endforeach;
                        endif; ?>
                    </div>
                </div>
            </div>
        <?php elseif ($widget->type == 'recommended-posts'): ?>
            <div class="sidebar-widget">
                <div class="widget-head"><h4 class="title"><?= esc($widget->title); ?></h4></div>
                <div class="widget-body">
                    <div class="row">
                        <?php $recommendedPosts = getRecommendedPosts();
                        if (!empty($recommendedPosts)):
                            foreach ($recommendedPosts as $item): ?>
                                <div class="col-12">
                                    <?= loadView('post/_post_item_small', ['postItem' => $item, 'showLabel' => false]); ?>
                                </div>
                            <?php endforeach;
                        endif; ?>
                    </div>
                </div>
            </div>
        <?php elseif ($widget->type == 'tags'): ?>
            <div class="sidebar-widget">
                <div class="widget-head"><h4 class="title"><?= esc($widget->title); ?></h4></div>
                <div class="widget-body">
                    <ul class="tag-list">
                        <?php $tags = getPopularTags();
                        if (!empty($tags)):
                            foreach ($tags as $item): ?>
                                <li><a href="<?= generateTagURL($item->tag_slug); ?>"><?= esc($item->tag); ?></a></li>
                            <?php endforeach;
                        endif; ?>
                    </ul>
                </div>
            </div>
        <?php elseif ($widget->type == 'poll'):
            echo view('common/_polls', ['widget' => $widget, 'isBs5' => 1]);
        elseif ($widget->type == 'custom'):?>
            <div class="sidebar-widget">
                <div class="widget-head"><h4 class="title"><?= esc($widget->title); ?></h4></div>
                <div class="widget-body">
                    <?= $widget->content; ?>
                </div>
            </div>
        <?php endif;
    endif;
endif; ?>