<?= loadView('partials/_ad_spaces', ['adSpace' => 'sidebar_1', 'class' => '']);
if (!empty($baseWidgets)):
    foreach ($baseWidgets as $widget):
        if ($widget->visibility == 1):
            if ($widget->type == 'follow-us'): ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="sidebar-widget">
                            <div class="widget-head"><h4 class="title"><?= esc($widget->title); ?></h4></div>
                            <div class="widget-body">
                                <ul class="widget-follow">
                                    <?php if (!empty($baseSettings->facebook_url)) : ?>
                                        <li><a class="facebook" href="<?= esc($baseSettings->facebook_url); ?>" target="_blank"><i class="icon-facebook"></i><span>Facebook</span></a></li>
                                    <?php endif;
                                    if (!empty($baseSettings->twitter_url)) : ?>
                                        <li><a class="twitter" href="<?= esc($baseSettings->twitter_url); ?>" target="_blank"><i class="icon-twitter"></i><span>Twitter</span></a></li>
                                    <?php endif;
                                    if (!empty($baseSettings->instagram_url)) : ?>
                                        <li><a class="instagram" href="<?= esc($baseSettings->instagram_url); ?>" target="_blank"><i class="icon-instagram"></i><span>Instagram</span></a></li>
                                    <?php endif;
                                    if (!empty($baseSettings->pinterest_url)) : ?>
                                        <li><a class="pinterest" href="<?= esc($baseSettings->pinterest_url); ?>" target="_blank"><i class="icon-pinterest"></i><span>Pinterest</span></a></li>
                                    <?php endif;
                                    if (!empty($baseSettings->linkedin_url)) : ?>
                                        <li><a class="linkedin" href="<?= esc($baseSettings->linkedin_url); ?>" target="_blank"><i class="icon-linkedin"></i><span>Linkedin</span></a></li>
                                    <?php endif;
                                    if (!empty($baseSettings->vk_url)) : ?>
                                        <li><a class="vk" href="<?= esc($baseSettings->vk_url); ?>" target="_blank"><i class="icon-vk"></i><span>VK</span></a></li>
                                    <?php endif;
                                    if (!empty($baseSettings->telegram_url)) : ?>
                                        <li><a class="telegram" href="<?= esc($baseSettings->telegram_url); ?>" target="_blank"><i class="icon-telegram"></i><span>Telegram</span></a></li>
                                    <?php endif;
                                    if (!empty($baseSettings->youtube_url)) : ?>
                                        <li><a class="youtube" href="<?= esc($baseSettings->youtube_url); ?>" target="_blank"><i class="icon-youtube"></i><span>Youtube</span></a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif;
            if ($widget->type == 'popular-posts'):?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="sidebar-widget widget-popular-posts">
                            <div class="widget-head"><h4 class="title"><?= esc($widget->title); ?></h4></div>
                            <div class="widget-body">
                                <ul class="popular-posts">
                                    <?php $popularPosts = getPopularPosts($activeLang->id, $baseLatestCategoryPosts);
                                    if (!empty($popularPosts)):
                                        foreach ($popularPosts as $post): ?>
                                            <li>
                                                <?= loadView("post/_post_item_small", ["post" => $post]); ?>
                                            </li>
                                        <?php endforeach;
                                    endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif;
            if ($widget->type == 'recommended-posts'): ?>
                <div class="row">
                    <div class="col-sm-12">
                        <?= loadView('partials/_recommended_posts', ['widget' => $widget]); ?>
                    </div>
                </div>
            <?php endif;
            if ($widget->type == 'tags'): ?>
                <div class="row">
                    <div class="col-sm-12">
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
                    </div>
                </div>
            <?php endif;
            if ($widget->type == 'poll'): ?>
                <div class="row">
                    <div class="col-sm-12">
                        <?= view('common/_polls', ['widget' => $widget]); ?>
                    </div>
                </div>
            <?php endif;
            if ($widget->type == 'custom'): ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="sidebar-widget">
                            <div class="widget-head">
                                <h4 class="title"><?= esc($widget->title); ?></h4>
                            </div>
                            <div class="widget-body">
                                <?= $widget->content; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif;
        endif;
    endforeach;
endif;
echo loadView('partials/_ad_spaces', ['adSpace' => 'sidebar_2', 'class' => '']); ?>