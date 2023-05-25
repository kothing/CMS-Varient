<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                        <li class="breadcrumb-item"><a href="<?= generateURL('settings'); ?>"><?= trans("settings"); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= esc($title); ?></li>
                    </ol>
                </nav>
                <h1 class="page-title"><?= trans("settings"); ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-3">
                <div class="row-custom">
                    <?= loadView("settings/_setting_tabs"); ?>
                </div>
            </div>
            <div class="col-sm-12 col-md-9">
                <div class="row-custom">
                    <div class="profile-tab-content">
                        <?= loadView('partials/_messages'); ?>
                        <form action="<?= base_url('social-accounts-post'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="back_url" value="<?= currentFullURL(); ?>">
                            <div class="form-group">
                                <label class="control-label">Facebook <?= trans('url'); ?></label>
                                <input type="text" class="form-control form-input" name="facebook_url" placeholder="Facebook <?= trans('url'); ?>" value="<?= esc(user()->facebook_url); ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Twitter <?= trans('url'); ?></label>
                                <input type="text" class="form-control form-input" name="twitter_url" placeholder="Twitter <?= trans('url'); ?>" value="<?= esc(user()->twitter_url); ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Instagram <?= trans('url'); ?></label>
                                <input type="text" class="form-control form-input" name="instagram_url" placeholder="Instagram <?= trans('url'); ?>" value="<?= esc(user()->instagram_url); ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Pinterest <?= trans('url'); ?></label>
                                <input type="text" class="form-control form-input" name="pinterest_url" placeholder="Pinterest <?= trans('url'); ?>" value="<?= esc(user()->pinterest_url); ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Linkedin <?= trans('url'); ?></label>
                                <input type="text" class="form-control form-input" name="linkedin_url" placeholder="Linkedin <?= trans('url'); ?>" value="<?= esc(user()->linkedin_url); ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label">VK <?= trans('url'); ?></label>
                                <input type="text" class="form-control form-input" name="vk_url" placeholder="VK <?= trans('url'); ?>" value="<?= esc(user()->vk_url); ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Telegram <?= trans('url'); ?></label>
                                <input type="text" class="form-control form-input" name="telegram_url" placeholder="Telegram <?= trans('url'); ?>" value="<?= esc(user()->telegram_url); ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Youtube <?= trans('url'); ?></label>
                                <input type="text" class="form-control form-input" name="youtube_url" placeholder="Youtube <?= trans('url'); ?>" value="<?= esc(user()->youtube_url); ?>">
                            </div>
                            <button type="submit" class="btn btn-md btn-custom"><?= trans("save_changes") ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>