<div id="wrapper">
    <div class="container m-b-30">
        <div class="row">
            <?php if ($page->breadcrumb_active == 1): ?>
                <div class="col-sm-12 page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                        <li class="breadcrumb-item active"><?= esc($page->title); ?></li>
                    </ol>
                </div>
            <?php else: ?>
                <div class="col-sm-12 page-breadcrumb"></div>
            <?php endif; ?>
            <div id="content" class="col-sm-12 m-b-30">
                <div class="row">
                    <?php if ($page->title_active == 1): ?>
                        <div class="col-sm-12"><h1 class="page-title"><?= esc($page->title); ?></h1></div>
                    <?php endif; ?>
                    <div class="col-sm-12">
                        <div class="page-contact">
                            <div class="row row-contact-text">
                                <div class="col-sm-12 font-text">
                                    <?= $baseSettings->contact_text; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 font-text">
                                    <h2 class="contact-leave-message"><?= trans("leave_message"); ?></h2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <?= loadView('partials/_messages'); ?>
                                    <form action="<?= base_url('contact-post'); ?>" method="post" id="form_validate" class="validate_terms">
                                        <?= csrf_field(); ?>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-input" name="name" placeholder="<?= trans("name"); ?>" maxlength="199" minlength="1" pattern=".*\S+.*" value="<?= old('name'); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control form-input" name="email" maxlength="199" placeholder="<?= trans("email"); ?>" value="<?= old('email'); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control form-input form-textarea" name="message" placeholder="<?= trans("message"); ?>" maxlength="4970" minlength="5" required><?= old('message'); ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="custom-checkbox">
                                                <input type="checkbox" class="checkbox_terms_conditions" required>
                                                <span class="checkbox-icon"><i class="icon-check"></i></span>
                                                <?= trans("terms_conditions_exp"); ?>&nbsp;<a href="<?= getPageLinkByDefaultName('terms_conditions', $activeLang->id); ?>" class="link-terms" target="_blank"><strong><?= trans("terms_conditions"); ?></strong></a>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <?php reCaptcha('generate', $generalSettings); ?>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-md btn-custom pull-right"><?= trans("btn_submit"); ?></button>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-sm-6 col-xs-12 contact-right">
                                    <?php if ($baseSettings->contact_phone): ?>
                                        <div class="contact-item">
                                            <div class="col-sm-2 col-xs-2 contact-icon">
                                                <i class="icon-phone" aria-hidden="true"></i>
                                            </div>
                                            <div class="col-sm-10 col-xs-10 contact-info">
                                                <?= esc($baseSettings->contact_phone); ?>
                                            </div>
                                        </div>
                                    <?php endif;
                                    if ($baseSettings->contact_email): ?>
                                        <div class="contact-item">
                                            <div class="col-sm-2 col-xs-2 contact-icon">
                                                <i class="icon-envelope" aria-hidden="true"></i>
                                            </div>
                                            <div class="col-sm-10 col-xs-10 contact-info">
                                                <?= esc($baseSettings->contact_email); ?>
                                            </div>
                                        </div>
                                    <?php endif;
                                    if ($baseSettings->contact_address): ?>
                                        <div class="contact-item">
                                            <div class="col-sm-2 col-xs-2 contact-icon">
                                                <i class="icon-map-marker" aria-hidden="true"></i>
                                            </div>
                                            <div class="col-sm-10 col-xs-10 contact-info">
                                                <?= esc($baseSettings->contact_address); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="col-sm-12 contact-social">
                                        <ul>
                                            <?= view('common/_social_media_links', ['rssHide' => true]); ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if (!empty($baseSettings->contact_address)): ?>
        <div class="container-fluid">
            <div class="row">
                <div class="contact-map-container">
                    <iframe id="contact_iframe" src="https://maps.google.com/maps?width=100%&height=600&hl=en&q=<?= $baseSettings->contact_address; ?>&ie=UTF8&t=&z=8&iwloc=B&output=embed&disableDefaultUI=true" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<style>
    #footer {
        margin-top: 0;
    }
</style>
<script>
    var iframe = document.getElementById("contact_iframe");
    if (iframe) {
        iframe.src = iframe.src;
        iframe.src = iframe.src;
    }
</script>