<?php if (!empty($postUser)): ?>
    <div class="col-sm-12 col-xs-12">
        <div class="row">
            <div class="about-author">
                <div class="about-author-left">
                    <a href="<?= generateProfileURL($postUser->slug); ?>" class="author-link">
                        <img src="<?= getUserAvatar($postUser->avatar); ?>" alt="" class="img-responsive img-author">
                    </a>
                </div>
                <div class="about-author-right">
                    <div class="about-author-row">
                        <p><strong><a href="<?= generateProfileURL($postUser->slug); ?>" class="author-link"> <?= esc($postUser->username); ?> </a></strong></p>
                    </div>
                    <div class="about-author-row">
                        <?= esc($postUser->about_me);
                        $socialLinks = getSocialLinksArray($postUser, true);
                        if (!empty($socialLinks)):?>
                            <div class="profile-buttons">
                                <ul>
                                    <?php foreach ($socialLinks as $socialLink): ?>
                                        <li><a class="<?= esc($socialLink['key']); ?>" href="<?= $socialLink['url']; ?>" target="_blank"><i class="icon-<?= esc($socialLink['key']); ?>"></i></a></li>
                                    <?php endforeach;
                                    if ($postUser->show_rss_feeds): ?>
                                        <li><a href="<?= langBaseUrl('rss/author/' . $postUser->slug); ?>"><i class="icon-rss"></i></a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>