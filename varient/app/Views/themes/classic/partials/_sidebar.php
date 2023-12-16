<?= loadView('partials/_ad_spaces', ['adSpace' => 'sidebar_1', 'class' => '']);
if (!empty($baseWidgets)):
    foreach ($baseWidgets as $widget):
        if ($widget->visibility == 1):
            if ($widget->type == 'follow-us'):
                $socialLinks = getSocialLinksArray();
                if (!empty($socialLinks)):?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="sidebar-widget">
                                <div class="widget-head"><h4 class="title"><?= esc($widget->title); ?></h4></div>
                                <div class="widget-body">
                                    <ul class="widget-follow">
                                        <?php foreach ($socialLinks as $socialLink): ?>
                                            <li><a class="<?= esc($socialLink['key']); ?>" href="<?= $socialLink['url']; ?>" target="_blank"><i class="icon-<?= esc($socialLink['key']); ?>"></i><span><?= esc($socialLink['name']); ?></span></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif;
            endif;
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