<?php if ($generalSettings->show_latest_posts == 1):
    if (!empty($latestPosts) && countItems($latestPosts) > 0):
        $widgets = getCategoryWidgets(0, $baseWidgets, $adSpaces, $activeLang->id); ?>
        <section class="section">
            <div class="container-xl">
                <div class="row">
                    <div class="col-sm-12 col-md-12<?= $widgets->hasWidgets ? ' col-lg-8' : ''; ?>">
                        <div class="latest-posts">
                            <div class="section-title">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="title"><?= trans("latest_posts"); ?></h3>
                                    <a href="<?= generateURL('posts'); ?>" class="view-all font-title"><?= trans("view_all_posts"); ?><i class="icon-arrow-right"></i></a>
                                </div>
                            </div>
                            <div class="section-content">
                                <div id="last_posts_content" class="row">
                                    <?= loadView('post/_latest_posts_load', ['limitLoadMorePosts' => $limitLoadMorePosts, 'hasWidgets' => $widgets->hasWidgets]); ?>
                                </div>
                                <?php if (countItems($latestPosts) > $limitLoadMorePosts): ?>
                                    <div class="d-flex justify-content-center mt-4">
                                        <button class="btn btn-custom btn-lg btn-load-more" onclick="loadMorePosts();">
                                            <?= trans("load_more"); ?>
                                            <svg width="16" height="16" viewBox="0 0 1792 1792" fill="#ffffff" class="m-l-5" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1664 256v448q0 26-19 45t-45 19h-448q-42 0-59-40-17-39 14-69l138-138q-148-137-349-137-104 0-198.5 40.5t-163.5 109.5-109.5 163.5-40.5 198.5 40.5 198.5 109.5 163.5 163.5 109.5 198.5 40.5q119 0 225-52t179-147q7-10 23-12 15 0 25 9l137 138q9 8 9.5 20.5t-7.5 22.5q-109 132-264 204.5t-327 72.5q-156 0-298-61t-245-164-164-245-61-298 61-298 164-245 245-164 298-61q147 0 284.5 55.5t244.5 156.5l130-129q29-31 70-14 39 17 39 59z"/>
                                            </svg>
                                            <span class="spinner-border spinner-border-sm spinner-load-more m-l-5" role="status" aria-hidden="true"></span>
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php if ($widgets->hasWidgets):
                        echo loadView('partials/_sidebar_category', ['objectWidgets' => $widgets]);
                    endif; ?>
                </div>
            </div>
        </section>
    <?php endif;
endif; ?>