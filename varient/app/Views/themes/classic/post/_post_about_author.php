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
                        <?= esc($postUser->about_me); ?>
                        <div class="profile-buttons">
                            <ul>
                                <?php if (!empty($postUser->facebook_url)) : ?>
                                    <li><a class="facebook" href="<?= esc($postUser->facebook_url); ?>" target="_blank"><i class="icon-facebook"></i></a></li>
                                <?php endif;
                                if (!empty($postUser->twitter_url)) : ?>
                                    <li><a class="twitter" href="<?= esc($postUser->twitter_url); ?>" target="_blank"><i class="icon-twitter"></i></a></li>
                                <?php endif;
                                if (!empty($postUser->pinterest_url)) : ?>
                                    <li><a class="pinterest" href="<?= esc($postUser->pinterest_url); ?>" target="_blank"><i class="icon-pinterest"></i></a></li>
                                <?php endif;
                                if (!empty($postUser->instagram_url)) : ?>
                                    <li><a class="instagram" href="<?= esc($postUser->instagram_url); ?>" target="_blank"><i class="icon-instagram"></i></a></li>
                                <?php endif;
                                if (!empty($postUser->linkedin_url)) : ?>
                                    <li><a class="linkedin" href="<?= esc($postUser->linkedin_url); ?>" target="_blank"><i class="icon-linkedin"></i></a></li>
                                <?php endif;
                                if (!empty($postUser->vk_url)) : ?>
                                    <li><a class="vk" href="<?= esc($postUser->vk_url); ?>" target="_blank"><i class="icon-vk"></i></a></li>
                                <?php endif;
                                if (!empty($postUser->youtube_url)) : ?>
                                    <li><a class="youtube" href="<?= esc($postUser->youtube_url); ?>" target="_blank"><i class="icon-youtube"></i></a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>