<section class="section section-page">
    <div class="container-xl">
        <div class="row">
            <?php if ($page->breadcrumb_active == 1): ?>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                        <li class="breadcrumb-item active"><?= esc($page->title); ?></li>
                    </ol>
                </nav>
            <?php endif;
            if ($page->title_active) : ?>
                <h1 class="page-title"><?= esc($page->title); ?></h1>
            <?php endif;
            if ($page->right_column_active == 1): ?>
            <div class="col-sm-12 col-md-12 col-lg-8">
                <?php endif; ?>
                <div class="page-content font-text page-text">
                    <?= $page->page_content; ?>
                </div>
                <?php if ($page->right_column_active == 1): ?>
            </div>
        <?php endif;
        if ($page->right_column_active == 1): ?>
            <div class="col-sm-12 col-md-12 col-lg-4">
                <?= loadView('partials/_sidebar'); ?>
            </div>
        <?php endif; ?>
        </div>
    </div>
</section>