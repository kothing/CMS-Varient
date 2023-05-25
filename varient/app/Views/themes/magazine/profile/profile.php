<section class="section section-page section-profile">
    <div class="container-fluid">
        <div class="row">
            <div class="profile-header">
                <div class="profile-cover-image"></div>
                <div class="profile-info-container">
                    <div class="container-xl">
                        <div class="tbl-container profile-info">
                            <div class="tbl-cell cell-left">
                                <div class="profile-image">
                                    <img src="<?= getUserAvatar($user->avatar); ?>" alt="<?= esc($user->username); ?>" class="img-fluid" width="152" height="152">
                                </div>
                            </div>
                            <div class="tbl-cell profile-username">
                                <h1 class="username"><?= esc($user->username); ?></h1>
                                <div class="profile-last-seen<?= isUserOnline($user->last_seen) ? ' online' : ''; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="icon-circle" viewBox="0 0 16 16">
                                        <circle cx="8" cy="8" r="8"/>
                                    </svg>
                                    <?= trans("last_seen"); ?>&nbsp;<?= timeAgo($user->last_seen); ?>
                                </div>
                                <?php if (authCheck()):
                                    if (user()->id != $user->id): ?>
                                        <form action="<?= base_url('follow-user-post'); ?>" method="post">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" name="profile_id" value="<?= $user->id; ?>">
                                            <input type="hidden" name="back_url" value="<?= currentFullURL(); ?>">
                                            <?php if (isUserFollows($user->id, user()->id)): ?>
                                                <button type="submit" class="btn btn-lg btn-custom btn-follow">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-dash-fill" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M11 7.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5z"/>
                                                        <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                                    </svg>
                                                    <span><?= trans("unfollow"); ?></span>
                                                </button>
                                            <?php else: ?>
                                                <button type="submit" class="btn btn-lg btn-custom btn-follow">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                                                        <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                                        <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                                                    </svg>
                                                    <span><?= trans("follow"); ?></span>
                                                </button>
                                            <?php endif; ?>
                                        </form>
                                    <?php endif;
                                else: ?>
                                    <button type="submit" class="btn btn-lg btn-custom btn-follow" data-toggle="modal" data-target="#modal-login">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                                            <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                            <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                                        </svg>
                                        <span><?= trans("follow"); ?></span>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-xl container-profile">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-4 pt-2">
                <div class="sticky-lg-top">
                    <div class="row">
                        <div class="col-12">
                            <div class="profile-details">
                                <p class="description"><?= esc($user->about_me); ?></p>
                                <div class="d-flex flex-row mb-4 contact-details">
                                    <div class="item text-muted"><?= trans("member_since"); ?>&nbsp;<?= formatDateFront($user->created_at); ?></div>
                                    <?php if ($generalSettings->show_user_email_on_profile == 1 && $user->show_email_on_profile == 1): ?>
                                        <div class="item text-muted profile-email">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                                <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/>
                                            </svg>
                                            &nbsp;<?= esc($user->email); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="d-flex flex-row mb-4">
                                    <ul class="profile-social-links">
                                        <?php if (!empty($user->facebook_url)): ?>
                                            <li><a href="<?= esc($user->facebook_url); ?>" target="_blank"><i class="icon-facebook"></i></a></li>
                                        <?php endif;
                                        if (!empty($user->twitter_url)): ?>
                                            <li><a href="<?= esc($user->twitter_url); ?>" target="_blank"><i class="icon-twitter"></i></a></li>
                                        <?php endif;
                                        if (!empty($user->instagram_url)): ?>
                                            <li><a href="<?= esc($user->instagram_url); ?>" target="_blank"><i class="icon-instagram"></i></a></li>
                                        <?php endif;
                                        if (!empty($user->pinterest_url)): ?>
                                            <li><a href="<?= esc($user->pinterest_url); ?>" target="_blank"><i class="icon-pinterest"></i></a></li>
                                        <?php endif;
                                        if (!empty($user->linkedin_url)): ?>
                                            <li><a href="<?= esc($user->linkedin_url); ?>" target="_blank"><i class="icon-linkedin"></i></a></li>
                                        <?php endif;
                                        if (!empty($user->vk_url)): ?>
                                            <li><a href="<?= esc($user->vk_url); ?>" target="_blank"><i class="icon-vk"></i></a></li>
                                        <?php endif;
                                        if (!empty($user->telegram_url)): ?>
                                            <li><a href="<?= esc($user->telegram_url); ?>" target="_blank"><i class="icon-telegram"></i></a></li>
                                        <?php endif;
                                        if (!empty($user->youtube_url)): ?>
                                            <li><a href="<?= esc($user->youtube_url); ?>" target="_blank"><i class="icon-youtube"></i></a></li>
                                        <?php endif;
                                        if ($user->show_rss_feeds): ?>
                                            <li><a href="<?= langBaseUrl('rss/author/' . $user->slug); ?>"><i class="icon-rss"></i></a></li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="sidebar-widget">
                                <div class="widget-head"><h4 class="title"><?= trans('following'); ?>&nbsp;(<?= countItems($following); ?>)</h4></div>
                                <div class="widget-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <?php if (!empty($following)):
                                                foreach ($following as $item):?>
                                                    <div class="img-follower">
                                                        <a href="<?= generateProfileURL($item->slug); ?>">
                                                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACwAAAAAAQABAAACAkQBADs=" data-src="<?= getUserAvatar($item->avatar); ?>" alt="<?= esc($item->username); ?>" class="img-fluid lazyload" width="48" height="48" onerror="this.src='<?= base_url('assets/img/user.png'); ?>'">
                                                        </a>
                                                    </div>
                                                <?php endforeach;
                                            endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-4">
                            <div class="sidebar-widget">
                                <div class="widget-head"><h4 class="title"><?= trans('followers'); ?>&nbsp;(<?= countItems($followers); ?>)</h4></div>
                                <div class="widget-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <?php if (!empty($followers)):
                                                foreach ($followers as $item):?>
                                                    <div class="img-follower">
                                                        <a href="<?= generateProfileURL($item->slug); ?>">
                                                            <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACwAAAAAAQABAAACAkQBADs=" data-src="<?= getUserAvatar($item->avatar); ?>" alt="<?= esc($item->username); ?>" class="img-fluid lazyload" width="48" height="48" onerror="this.src='<?= base_url('assets/img/user.png'); ?>'">
                                                        </a>
                                                    </div>
                                                <?php endforeach;
                                            endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-8 pt-2">
                <div class="row">
                    <?php $i = 0;
                    if (!empty($posts)):
                        foreach ($posts as $item):
                            if ($i == 2):
                                echo loadView('partials/_ad_spaces', ['adSpace' => 'posts_top', 'class' => 'mb-4']);
                            endif; ?>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <?= loadView("post/_post_item", ['postItem' => $item, 'showLabel' => false]); ?>
                            </div>
                            <?php $i++;
                        endforeach;
                    endif;
                    echo loadView('partials/_ad_spaces', ['adSpace' => 'posts_bottom', 'class' => 'mb-3']); ?>
                    <div class="col-12 mt-3">
                        <?= view('common/_pagination'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php if (!empty($user->cover_image)): ?>
    <style>.container-bn-header {display: none !important;}  .profile-cover-image {background-image: url('<?= base_url(($user->cover_image)); ?>');}  .profile-header .profile-info-container {background-color: transparent;background-image: linear-gradient(to bottom, transparent, rgba(0, 0, 0, 0.7) 100%);background-image: -webkit-linear-gradient(to bottom, transparent, rgba(0, 0, 0, 0.7) 100%);background-image: -moz-linear-gradient(to bottom, transparent, rgb(0, 0, 0, 0.7) 100%);background-image: -owg-linear-gradient(to bottom, transparent, rgba(0, 0, 0, 0.7) 100%);background-image: -o-linear-gradient(to bottom, transparent, rgba(0, 0, 0, 0.7) 100%);}</style>
<?php else: ?>
    <style>.container-bn-header {display: none !important;}  .profile-header {height: 160px;}  .profile-header .profile-info .profile-username .username {color: #222;}  .profile-header .profile-last-seen {color: #6c757d;}</style>
<?php endif; ?>