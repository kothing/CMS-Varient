<div class="row-custom">
    <div class="profile-details">
        <div class="left">
            <img src="<?= getUserAvatar($user->avatar); ?>" alt="<?= esc($user->username); ?>" class="img-profile">
        </div>
        <div class="right">
            <div class="row-custom">
                <h1 class="username"><?= esc($user->username); ?></h1>
            </div>
            <div class="row-custom">
                <p class="p-last-seen">
                    <span class="last-seen <?= isUserOnline($user->last_seen) ? 'last-seen-online' : ''; ?>"> <i class="icon-circle"></i> <?= trans("last_seen"); ?>&nbsp;<?= timeAgo($user->last_seen); ?></span>
                </p>
            </div>
            <div class="row-custom">
                <p class="description"><?= esc($user->about_me); ?></p>
            </div>
            <div class="row-custom user-contact">
                <span class="info"><?= trans("member_since"); ?>&nbsp;<?= formatDateFront($user->created_at); ?></span>
                <?php if ($generalSettings->show_user_email_on_profile == 1 && $user->show_email_on_profile == 1): ?>
                    <span class="info"><i class="icon-envelope"></i><?= esc($user->email); ?></span>
                <?php endif; ?>
            </div>
            <div class="row-custom profile-buttons">
                <?php if (authCheck()):
                    if (user()->id != $user->id): ?>
                        <form action="<?= base_url('follow-user-post'); ?>" method="post" class="form-inline">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="profile_id" value="<?= $user->id; ?>">
                            <input type="hidden" name="back_url" value="<?= currentFullURL(); ?>">
                            <?php if (isUserFollows($user->id, user()->id)): ?>
                                <button type="submit" class="btn btn-md btn-custom btn-follow"><i class="icon-user-plus"></i><?= trans("unfollow"); ?></button>
                            <?php else: ?>
                                <button type="submit" class="btn btn-md btn-custom btn-follow"><i class="icon-user-plus"></i><?= trans("follow"); ?></button>
                            <?php endif; ?>
                        </form>
                    <?php endif;
                else: ?>
                    <button class="btn btn-md btn-custom btn-follow" data-toggle="modal" data-target="#modalLogin"><i class="icon-user-plus"></i><?= trans("follow"); ?></button>
                <?php endif; ?>
                <div class="social">
                    <ul>
                        <?php $socialLinks = getSocialLinksArray($user, true);
                        if (!empty($socialLinks)):
                            foreach ($socialLinks as $socialLink): ?>
                                <li><a class="<?= esc($socialLink['key']); ?>" href="<?= $socialLink['url']; ?>" target="_blank"><i class="icon-<?= esc($socialLink['key']); ?>"></i></a></li>
                            <?php endforeach;
                        endif;
                        if ($user->show_rss_feeds): ?>
                            <li><a href="<?= langBaseUrl('rss/author/' . $user->slug); ?>"><i class="icon-rss"></i></a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>