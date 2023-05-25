<h1 class="title-index"><?= esc($homeTitle); ?></h1>
<?php if ($generalSettings->show_featured_section == 1):
    echo loadView('post/_featured_posts', $featuredPosts);
endif; ?>
<div id="wrapper" class="index-wrapper m-t-0">
    <div class="container">
        <div class="row">
            <?php if ($generalSettings->show_newsticker == 1 && countItems($breakingNews) > 0): ?>
                <div class="col-sm-12 news-ticker-cnt">
                    <div class="row m-0">
                        <div class="left"><span class="news-ticker-title font-second"><?= trans("breaking_news"); ?></span></div>
                        <div class="right">
                            <div class="news-ticker">
                                <ul class="newsticker">
                                    <?php foreach ($breakingNews as $item): ?>
                                        <li><a href="<?= generatePostURL($item); ?>"<?php postURLNewTab($item); ?>><?= esc($item->title); ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="news-ticker-btn-cnt">
                            <a href="javascript:void(0)" id="btn_newsticker_prev" class="bnt-news-ticker news-prev"><span class="icon-arrow-left"></span></a>
                            <a href="javascript:void(0)" id="btn_newsticker_next" class="bnt-news-ticker news-next"><span class="icon-arrow-right"></span></a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="col-sm-12 news-ticker-sep"></div>
            <?php endif; ?>
            <div class="col-sm-12 col-xs-12 bn-header-mobile">
                <div class="row">
                    <?= loadView('partials/_ad_spaces', ['adSpace' => 'header', 'class' => 'bn-header-mb']); ?>
                </div>
            </div>
            <div id="content" class="col-sm-8 col-xs-12">
                <?php $x = 0;
                if (!empty($baseCategories)):
                    foreach ($baseCategories as $category):
                        if ($category->show_at_homepage == 1 && $category->lang_id == $activeLang->id):
                            if ($category->block_type == "block-1") {
                                echo loadView('partials/_category_block_type_1', ['category' => $category]);
                            }
                            if ($category->block_type == "block-2") {
                                echo loadView('partials/_category_block_type_2', ['category' => $category]);
                            }
                            if ($category->block_type == "block-3") {
                                echo loadView('partials/_category_block_type_3', ['category' => $category]);
                            }
                            if ($category->block_type == "block-4") {
                                echo loadView('partials/_category_block_type_4', ['category' => $category]);
                            }
                            if ($category->block_type == "block-5") {
                                echo loadView('partials/_category_block_type_5', ['category' => $category]);
                            }
                            if ($x == 0) {
                                echo loadView('partials/_ad_spaces', ['adSpace' => 'index_top', 'class' => 'bn-p-b']);
                            }
                            $x++;
                        endif;
                    endforeach;
                endif;
                echo loadView('partials/_ad_spaces', ['adSpace' => 'index_bottom', 'class' => 'bn-p-b']);
                if ($generalSettings->show_latest_posts == 1):
                    if (!empty($latestPosts) && countItems($latestPosts) > 0): ?>
                        <div class="col-sm-12 col-xs-12">
                            <div class="row">
                                <section class="section">
                                    <div class="section-head">
                                        <h4 class="title"><a href="<?= generateURL('posts'); ?>"><?= trans("latest_posts"); ?></a></h4>
                                        <a href="<?= generateURL('posts'); ?>" class="a-view-all"><?= trans("view_all_posts"); ?>&nbsp;&nbsp;&nbsp;<i class="icon-arrow-right" aria-hidden="true"></i></a>
                                    </div>
                                    <div class="section-content">
                                        <div class="row latest-articles">
                                            <div id="last_posts_content">
                                                <?= loadView('post/_index_latest_posts', ['limitLoadMorePosts' => $limitLoadMorePosts]); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="load_posts_spinner" class="col-sm-12 col-xs-12 load-more-spinner">
                                        <div class="row">
                                            <div class="spinner">
                                                <div class="bounce1"></div>
                                                <div class="bounce2"></div>
                                                <div class="bounce3"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if (countItems($latestPosts) > $limitLoadMorePosts): ?>
                                        <div class="col-sm-12 col-xs-12">
                                            <div class="row">
                                                <button class="btn-load-more" onclick="loadMorePosts();"><?= trans("load_more"); ?></button>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </section>
                            </div>
                        </div>
                    <?php endif;
                endif; ?>
            </div>
            <div id="sidebar" class="col-sm-4 col-xs-12">
                <?= loadView('partials/_sidebar'); ?>
            </div>
        </div>
    </div>
</div>