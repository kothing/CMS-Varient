<?php $socialLinks = getSocialLinksArray();
if (!empty($socialLinks)):
    foreach ($socialLinks as $socialLink): ?>
        <li><a class="<?= esc($socialLink['key']); ?>" href="<?= $socialLink['url']; ?>" target="_blank" aria-label="<?= esc($socialLink['key']); ?>"><i class="icon-<?= esc($socialLink['key']); ?>"></i></a></li>
    <?php endforeach;
endif;
if (!empty($generalSettings->show_rss) && $rssHide == false) : ?>
    <li><a class="rss" href="<?= generateURL('rss_feeds'); ?>" aria-label="rss"><i class="icon-rss"></i></a></li>
<?php endif; ?>