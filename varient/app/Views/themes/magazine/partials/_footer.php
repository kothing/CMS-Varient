<?= view('common/_json_ld'); ?>
    <footer id="footer">
        <div class="footer-inner">
            <div class="container-xl">
                <div class="row justify-content-between">
                    <div class="col-sm-12 col-md-6 col-lg-4 footer-widget footer-widget-about">
                        <div class="footer-logo">
                            <img src="<?= getLogoFooter(); ?>" alt="logo" class="logo" width="240" height="90">
                        </div>
                        <div class="footer-about">
                            <?= esc($baseSettings->about_footer); ?>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-4 footer-widget">
                        <h4 class="widget-title"><?= trans("most_viewed_posts"); ?></h4>
                        <div class="footer-posts">
                            <?php $mostViewedPosts = getMostViewedPosts(3);
                            if (!empty($mostViewedPosts)):
                                foreach ($mostViewedPosts as $item): ?>
                                    <?= loadView('post/_post_item_small', ['postItem' => $item, 'showLabel' => false]); ?>
                                <?php endforeach;
                            endif; ?>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-4 footer-widget">
                        <h4 class="widget-title"><?= trans("newsletter"); ?></h4>
                        <div class="newsletter">
                            <p class="description"><?= trans("newsletter_desc"); ?></p>
                            <form id="form_newsletter_footer" class="form-newsletter">
                                <div class="newsletter-inputs">
                                    <input type="email" name="email" class="form-control form-input newsletter-input" maxlength="199" placeholder="<?= trans("email"); ?>">
                                    <button type="submit" name="submit" value="form" class="btn btn-custom newsletter-button"><?= trans("subscribe"); ?></button>
                                </div>
                                <input type="text" name="url">
                                <div id="form_newsletter_response"></div>
                            </form>
                        </div>
                        <div class="footer-social-links">
                            <ul>
                                <?= view('common/_social_media_links', ['rssHide' => false]); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container-xl">
                <div class="row align-items-center">
                    <div class="col-sm-12 col-md-6">
                        <div class="copyright text-start">
                            <?= esc($baseSettings->copyright); ?>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="nav-footer text-end">
                            <ul>
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
<?php if ($baseSettings->cookies_warning && empty(helperGetCookie('cookies_warning'))): ?>
    <div class="cookies-warning">
        <div class="text"><?= $baseSettings->cookies_warning_text; ?></div>
        <button type="button" onclick="closeCookiesWarning();" class="btn-link icon-cl" aria-label="close">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
            </svg>
        </button>
    </div>
<?php endif; ?>
    <script src="<?= base_url($assetsPath . '/js/jquery-3.6.1.min.js'); ?> "></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?> "></script>
    <script src="<?= base_url($assetsPath . '/js/plugins.js'); ?> "></script>
    <script src="<?= base_url($assetsPath . '/js/main.min.js'); ?> "></script>
<?= loadView('partials/_js_footer'); ?>
    <script>$("form[method='post']").append("<input type='hidden' name='sys_lang_id' value='<?= $activeLang->id; ?>'>");</script>
<?php if ($generalSettings->pwa_status == 1): ?>
    <script>if ('serviceWorker' in navigator) {window.addEventListener('load', function () {navigator.serviceWorker.register('<?= base_url('pwa-sw.js');?>').then(function (registration) {}, function (err) {console.log('ServiceWorker registration failed: ', err);}).catch(function (err) {console.log(err);});});} else {console.log('service worker is not supported');}</script>
<?php endif; ?>
<?= $generalSettings->adsense_activation_code; ?>
<?= $generalSettings->google_analytics; ?>
<?= $generalSettings->custom_footer_codes; ?>
    </body>
    </html>
<?php if (!empty($isPage404)): exit(); endif; ?>