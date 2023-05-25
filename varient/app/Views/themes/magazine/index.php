<?php if ($generalSettings->show_newsticker == 1 && countItems($breakingNews) > 0): ?>
    <section class="section section-newsticker">
        <div class="container-xl">
            <div class="row">
                <div class="d-flex newsticker-container">
                    <div class="newsticker-title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lightning-fill" viewBox="0 0 16 16">
                            <path d="M5.52.359A.5.5 0 0 1 6 0h4a.5.5 0 0 1 .474.658L8.694 6H12.5a.5.5 0 0 1 .395.807l-7 9a.5.5 0 0 1-.873-.454L6.823 9.5H3.5a.5.5 0 0 1-.48-.641l2.5-8.5z"/>
                        </svg>
                        <span><?= trans("breaking_news"); ?></span>
                    </div>
                    <ul class="newsticker">
                        <?php foreach ($breakingNews as $item): ?>
                            <li><a href="<?= generatePostURL($item); ?>"<?php postURLNewTab($item); ?>><?= esc($item->title); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="ms-auto">
                        <div id="nav_newsticker" class="nav-sm-buttons">
                            <button class="prev" aria-label="prev"><i class="icon-arrow-left"></i></button>
                            <button class="next" aria-label="next"><i class="icon-arrow-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif;
if ($generalSettings->show_featured_section == 1):
    if ($activeTheme->theme == 'news'):
        echo view('themes/news/partials/_main_slider');
    else:
        echo loadView('partials/_main_slider');
    endif;
endif;
$catSliderIds = array();
$i = 0;
if (!empty($baseCategories)):
    foreach ($baseCategories as $category):
        if ($category->show_at_homepage == 1 && $category->lang_id == $activeLang->id):
            if ($category->block_type == 'block-1') {
                echo loadView('partials/_category_block_type_1', ['category' => $category]);
            }
            if ($category->block_type == 'block-2') {
                echo loadView('partials/_category_block_type_2', ['category' => $category]);
            }
            if ($category->block_type == 'block-3') {
                echo loadView('partials/_category_block_type_3', ['category' => $category]);
            }
            if ($category->block_type == 'block-4') {
                echo loadView('partials/_category_block_type_4', ['category' => $category]);
            }
            if ($category->block_type == 'block-5') {
                echo loadView('partials/_category_block_type_5', ['category' => $category]);
                array_push($catSliderIds, $category->id);
            }
            if ($category->block_type == 'block-6') {
                echo loadView('partials/_category_block_type_6', ['category' => $category]);
            }
            if ($i == 0) {
                echo loadView('partials/_ad_spaces', ['adSpace' => 'index_top', 'class' => 'mb-4']);
            }
            $i++;
        endif;
    endforeach;
endif;
if (!empty($catSliderIds)):?>
    <script>VrConfig.categorySliderIds = <?= json_encode($catSliderIds); ?>;</script>
<?php endif;
echo loadView('partials/_ad_spaces', ['adSpace' => 'index_bottom', 'class' => 'mb-4']);
echo loadView('post/_latest_posts', ['latestPosts' => $latestPosts]); ?>