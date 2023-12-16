<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="margin-top: 10px;">
    <tr>
        <td class="content-block" style="text-align: center;width: 100%;">
            <?php $socialLinks = getSocialLinksArray();
            if (!empty($socialLinks)):
                foreach ($socialLinks as $socialLink): ?>
                    <a href="<?= $socialLink['url']; ?>" target="_blank" style="color: transparent;margin-right: 2px;">
                        <img src="<?= base_url('assets/img/icons-social/'.esc($socialLink['key']).'.png'); ?>" alt="" style="width: 32px; height: 32px;"/>
                    </a>
                <?php endforeach;
            endif; ?>
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