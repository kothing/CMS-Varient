<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= trans("profile"); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="profile-page-top">
                    <?= loadView("profile/_profile_user_info"); ?>
                </div>
            </div>
        </div>
        <div class="profile-page">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3">
                    <div class="widget-followers">
                        <div class="widget-head">
                            <h3 class="title"><?= trans("following"); ?>&nbsp;(<?= countItems($following); ?>)</h3>
                        </div>
                        <div class="widget-body">
                            <div class="widget-content custom-scrollbar">
                                <div class="row row-followers">
                                    <?php if (!empty($following)):
                                        foreach ($following as $item):?>
                                            <div class="col-sm-2 col-xs-2 col-followers">
                                                <div class="img-follower">
                                                    <a href="<?= generateProfileURL($item->slug); ?>">
                                                        <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACwAAAAAAQABAAACAkQBADs=" data-src="<?= getUserAvatar($item->avatar); ?>" alt="<?= esc($item->username); ?>" class="img-responsive lazyload" onerror="this.src='<?= base_url('assets/img/user.png'); ?>'">
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endforeach;
                                    endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="widget-followers">
                        <div class="widget-head">
                            <h3 class="title"><?= trans("followers"); ?>&nbsp;(<?= countItems($followers); ?>)</h3>
                        </div>
                        <div class="widget-body">
                            <div class="widget-content custom-scrollbar-followers">
                                <div class="row row-followers">
                                    <?php if (!empty($followers)):
                                        foreach ($followers as $item):?>
                                            <div class="col-sm-2 col-xs-2 col-followers">
                                                <div class="img-follower">
                                                    <a href="<?= generateProfileURL($item->slug); ?>">
                                                        <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACwAAAAAAQABAAACAkQBADs=" data-src="<?= getUserAvatar($item->avatar); ?>" alt="<?= esc($item->username); ?>" class="img-responsive lazyload" onerror="this.src='<?= base_url('assets/img/user.png'); ?>'">
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endforeach;
                                    endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-9">
                    <div class="row">
                        <?php $count = 0;
                        foreach ($posts as $post):
                            if ($count != 0 && $count % 2 == 0): ?>
                                <div class="col-sm-12"></div>
                            <?php endif; ?>
                            <div class="col-sm-6 col-xs-12">
                                <?= loadView("post/_post_item", ["post" => $post, 'showLabel' => true]); ?>
                            </div>
                            <?php if ($count == 1):
                            echo loadView('partials/_ad_spaces', ['adSpace' => 'profile_top', 'class' => 'p-b-30']);
                        endif;
                            $count++;
                        endforeach;
                        if ($count == 0): ?>
                            <p class="text-center text-muted">
                                <?= trans("no_records_found"); ?>
                            </p>
                        <?php endif;
                        echo loadView('partials/_ad_spaces', ['adSpace' => 'profile_bottom', 'class' => '']); ?>
                        <div class="col-sm-12 col-xs-12">
                            <?= view('common/_pagination'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>