<?= view('common/_json_ld'); ?>
<footer id="footer">
    <div class="container">
        <div class="row footer-widgets">
            <div class="col-sm-4 col-xs-12">
                <div class="footer-widget f-widget-about">
                    <div class="col-sm-12">
                        <div class="row">
                            <p class="footer-logo"><img src="<?= getLogoFooter(); ?>" alt="logo" class="logo" width="240" height="90"></p>
                            <p><?= esc($baseSettings->about_footer); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-xs-12">
                <div class="footer-widget f-widget-random">
                    <div class="col-sm-12">
                        <div class="row">
                            <h4 class="title"><?= trans("most_viewed_posts"); ?></h4>
                            <div class="title-line"></div>
                            <ul class="f-random-list">
                                <?php $mostViewedPosts = getMostViewedPosts(3);
                                if (!empty($mostViewedPosts)):
                                    foreach ($mostViewedPosts as $item): ?>
                                        <li class="<?= checkPostImg($item, 'class'); ?>">
                                            <?php if (checkPostImg($item)): ?>
                                                <div class="list-left">
                                                    <a href="<?= generatePostURL($item); ?>"<?php postURLNewTab($item); ?>>
                                                        <?= loadView('post/_post_image', ['postItem' => $item, 'type' => 'small']); ?>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                            <div class="list-right">
                                                <h5 class="title">
                                                    <a href="<?= generatePostURL($item); ?>"<?php postURLNewTab($item); ?>>
                                                        <?= esc(characterLimiter($item->title, 55, '...')); ?>
                                                    </a>
                                                </h5>
                                            </div>
                                        </li>
                                    <?php endforeach;
                                endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-xs-12">
                <div class="col-sm-12 footer-widget f-widget-follow">
                    <div class="row">
                        <h4 class="title"><?= trans("footer_follow"); ?></h4>
                        <ul>
                            <?= view('common/_social_media_links', ['rssHide' => false]); ?>
                        </ul>
                    </div>
                </div>
                <?php if ($generalSettings->newsletter_status == 1): ?>
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="widget-newsletter">
                                <p><?= trans("join_newsletter"); ?></p>
                                <form id="form_newsletter_footer" class="form-newsletter">
                                    <div class="newsletter">
                                        <input type="email" name="email" class="newsletter-input" maxlength="199" placeholder="<?= trans("email"); ?>">
                                        <button type="submit" name="submit" value="form" class="newsletter-button"><?= trans("subscribe"); ?></button>
                                    </div>
                                    <input type="text" name="url">
                                    <div id="form_newsletter_response"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="row">
                <div class="col-md-12">
                    <div class="footer-bottom-left">
                        <p><?= esc($baseSettings->copyright); ?></p>
                    </div>
                    <div class="footer-bottom-right">
                        <ul class="nav-footer">
                            <?php if (!empty($baseMenuLinks)):
                                foreach ($baseMenuLinks as $item):
                                    if ($item->item_visibility == 1 && $item->item_location == "footer"):?>
                                        <li><a href="<?= generateMenuItemURL($item, $baseCategories); ?>"><?= esc($item->item_name); ?> </a></li>
                                    <?php endif;
                                endforeach;
                            endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<a href="#" class="scrollup"><i class="icon-arrow-up"></i></a>

<script src="<?= base_url($assetsPath. '/js/jquery-1.12.4.min.js'); ?>"></script>
<script src="<?= base_url($assetsPath. '/js/plugins-2.1.js'); ?>"></script>
<?php if ($baseSettings->cookies_warning && empty(helperGetCookie('cookies_warning'))): ?>
    <div class="cookies-warning">
        <div class="text"><?= $baseSettings->cookies_warning_text; ?></div>
        <a href="javascript:void(0)" onclick="closeCookiesWarning();" class="icon-cl"> <i class="icon-close"></i></a>
    </div>
<?php endif; ?>
<script>$("form[method='post']").append("<input type='hidden' name='sys_lang_id' value='<?= $activeLang->id; ?>'>");</script>
<script src="<?= base_url($assetsPath. '/js/script-2.1.min.js'); ?>"></script>
<?= loadView('partials/_js_footer'); ?>
<?php if ($generalSettings->pwa_status == 1): ?>
<script>if ('serviceWorker' in navigator) {window.addEventListener('load', function () {navigator.serviceWorker.register('<?= base_url('pwa-sw.js');?>').then(function (registration) {}, function (err) {console.log('ServiceWorker registration failed: ', err);}).catch(function (err) {console.log(err);});});} else {console.log('service worker is not supported');}</script>
<?php endif; ?>
<?= $generalSettings->adsense_activation_code; ?>
<?= $generalSettings->google_analytics; ?>
<?= $generalSettings->custom_footer_codes; ?>
</body>
</html>
<?php if(!empty($isPage404)): exit(); endif; ?>