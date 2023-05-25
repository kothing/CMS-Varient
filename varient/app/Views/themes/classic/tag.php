<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                    <li class="breadcrumb-item active"><?= esc($tag->tag); ?></li>
                </ol>
            </div>
            <div id="content" class="col-sm-8">
                <div class="row">
                    <div class="col-sm-12">
                        <h1 class="page-title"><span> <?= trans("tag"); ?>:</span>&nbsp;<strong><?= esc($tag->tag); ?></strong></h1>
                    </div>
                    <?php $count = 0;
                    foreach ($posts as $post):
                        if ($count != 0 && $count % 2 == 0): ?>
                            <div class="col-sm-12"></div>
                        <?php endif; ?>
                        <div class="col-sm-6 col-xs-12">
                            <?= loadView("post/_post_item", ["post" => $post, 'showLabel' => true]); ?>
                        </div>
                        <?php if ($count == 1):
                        echo loadView('partials/_ad_spaces', ['adSpace' => 'posts_top', 'class' => 'p-b-30']);
                    endif;
                        $count++;
                    endforeach;
                    echo loadView('partials/_ad_spaces', ['adSpace' => 'posts_bottom', 'class' => '']); ?>
                    <div class="col-sm-12 col-xs-12">
                        <?= view('common/_pagination'); ?>
                    </div>
                </div>
            </div>
            <div id="sidebar" class="col-sm-4">
                <?= loadView('partials/_sidebar'); ?>
            </div>
        </div>
    </div>
</div>