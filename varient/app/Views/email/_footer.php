<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="margin-top: 10px;">
    <tr>
        <td class="content-block" style="text-align: center;width: 100%;">
            <?php if (!empty($baseSettings->facebook_url)) : ?>
                <a href="<?= esc($baseSettings->facebook_url); ?>" target="_blank" style="color: transparent;margin-right: 5px;">
                    <img src="<?= base_url('assets/img/social-icons/facebook.png'); ?>" alt="" style="width: 28px; height: 28px;"/>
                </a>
            <?php endif;
            if (!empty($baseSettings->twitter_url)) : ?>
                <a href="<?= esc($baseSettings->twitter_url); ?>" target="_blank" style="color: transparent;margin-right: 5px;">
                    <img src="<?= base_url('assets/img/social-icons/twitter.png'); ?>" alt="" style="width: 28px; height: 28px;"/>
                </a>
            <?php endif;
            if (!empty($baseSettings->pinterest_url)) : ?>
                <a href="<?= esc($baseSettings->pinterest_url); ?>" target="_blank" style="color: transparent;margin-right: 5px;">
                    <img src="<?= base_url('assets/img/social-icons/pinterest.png'); ?>" alt="" style="width: 28px; height: 28px;"/>
                </a>
            <?php endif;
            if (!empty($baseSettings->instagram_url)) : ?>
                <a href="<?= esc($baseSettings->instagram_url); ?>" target="_blank" style="color: transparent;margin-right: 5px;">
                    <img src="<?= base_url('assets/img/social-icons/instagram.png'); ?>" alt="" style="width: 28px; height: 28px;"/>
                </a>
            <?php endif;
            if (!empty($baseSettings->linkedin_url)) : ?>
                <a href="<?= esc($baseSettings->linkedin_url); ?>" target="_blank" style="color: transparent;margin-right: 5px;">
                    <img src="<?= base_url('assets/img/social-icons/linkedin.png'); ?>" alt="" style="width: 28px; height: 28px;"/>
                </a>
            <?php endif;
            if (!empty($baseSettings->vk_url)) : ?>
                <a href="<?= esc($baseSettings->vk_url); ?>" target="_blank" style="color: transparent;margin-right: 5px;">
                    <img src="<?= base_url('assets/img/social-icons/vk.png'); ?>" alt="" style="width: 28px; height: 28px;"/>
                </a>
            <?php endif;
            if (!empty($baseSettings->youtube_url)) : ?>
                <a href="<?= esc($baseSettings->youtube_url); ?>" target="_blank" style="color: transparent;margin-right: 5px;">
                    <img src="<?= base_url('assets/img/social-icons/youtube.png'); ?>" alt="" style="width: 28px; height: 28px;"/>
                </a>
            <?php endif; ?>
        </td>
    </tr>
</table>
<div class="footer">
    <table role="presentation" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td class="content-block powered-by">
                <span class="apple-link"><?= esc($baseSettings->contact_address); ?></span><br>
                <?= esc($baseSettings->copyright); ?>
            </td>
        </tr>
        <?php if (!empty($subscriber) && !empty($showUnsubscribeLink)): ?>
            <tr>
                <td class="content-block">
                    <?= trans("dont_want_receive_emails"); ?> <a href="<?= base_url(); ?>/unsubscribe?token=<?= $subscriber->token; ?>"><?= trans("unsubscribe"); ?></a>
                </td>
            </tr>
        <?php endif; ?>
    </table>
</div>
</div>
</td>
<td>&nbsp;</td>
</tr>
</table>
<style>
    .wrapper table tr td img {
        height: auto !important;
    }
</style>
</body>
</html>