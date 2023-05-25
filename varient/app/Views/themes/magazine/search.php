<section class="section section-page">
    <div class="container-xl">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                    <li class="breadcrumb-item active"><?= trans("search"); ?></li>
                </ol>
            </nav>
            <h1 class="page-title"><?= trans("search"); ?>:&nbsp;<span class="search-text"><?= esc($q); ?></span></h1>
            <div class="col-sm-12 col-md-12 col-lg-8">
                <div class="d-flex flex-row-reverse align-items-center mb-3">
                    <form action="<?= generateURL('search'); ?>" method="get" id="form_search_in_content">
                        <input type="hidden" name="q" value="<?= esc($q); ?>">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="sc" value="1" id="checkboxSearch" onclick="document.getElementById('form_search_in_content').submit();" <?= !empty($searchInContent) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="checkboxSearch">
                                <?= trans("search_in_post_content"); ?>
                            </label>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <?php $i = 0;
                    if (!empty($posts)):
                        foreach ($posts as $item):
                            if ($i == 2):
                                echo loadView('partials/_ad_spaces', ['adSpace' => 'posts_top', 'class' => 'mb-4']);
                            endif; ?>
                            <div class="col-sm-12 col-md-6">
                                <?= loadView("post/_post_item", ['postItem' => $item, 'showLabel' => false]); ?>
                            </div>
                            <?php $i++;
                        endforeach;
                    else:?>
                        <p class="text-center text-muted">
                            <?= trans("search_noresult"); ?>
                        </p>
                    <?php endif;
                    echo loadView('partials/_ad_spaces', ['adSpace' => 'posts_bottom', 'class' => '']); ?>
                    <div class="col-12 mt-5">
                        <?= view('common/_pagination'); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-4">
                <?= loadView('partials/_sidebar'); ?>
            </div>
        </div>
    </div>
</section>