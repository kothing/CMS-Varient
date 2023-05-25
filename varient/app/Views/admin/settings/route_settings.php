<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-8">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans("route_settings");; ?></h3>
                </div>
            </div>
            <form action="<?= base_url('AdminController/routeSettingsPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="admin_readonly" value="admin" readonly>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="admin" value="<?= $routes->admin; ?>" maxlength="100" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="profile_readonly" value="profile" readonly>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="profile" value="<?= $routes->profile; ?>" maxlength="100" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="tag_readonly" value="tag" readonly>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="tag" value="<?= $routes->tag; ?>" maxlength="100" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="reading_list_readonly" value="reading-list" readonly>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="reading_list" value="<?= $routes->reading_list; ?>" maxlength="100" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="settings_readonly" value="settings" readonly>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="settings" value="<?= $routes->settings; ?>" maxlength="100" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="social_accounts_readonly" value="social-accounts" readonly>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="social_accounts" value="<?= $routes->social_accounts; ?>" maxlength="100" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="preferences_readonly" value="preferences" readonly>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="preferences" value="<?= $routes->preferences; ?>" maxlength="100" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="change_password_readonly" value="change-password" readonly>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="change_password" value="<?= $routes->change_password; ?>" maxlength="100" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="forgot_password_readonly" value="forgot-password" readonly>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="forgot_password" value="<?= $routes->forgot_password; ?>" maxlength="100" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="reset_password_readonly" value="reset-password" readonly>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="reset_password" value="<?= $routes->reset_password; ?>" maxlength="100" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="delete_account_readonly" value="delete-account" readonly>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="delete_account" value="<?= $routes->delete_account; ?>" maxlength="100" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="register_readonly" value="register" readonly>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="register" value="<?= $routes->register; ?>" maxlength="100" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="posts_readonly" value="posts" readonly>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="posts" value="<?= $routes->posts; ?>" maxlength="100" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="search_readonly" value="search" readonly>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="search" value="<?= $routes->search; ?>" maxlength="100" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="rss_feeds_readonly" value="rss-feeds" readonly>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="rss_feeds" value="<?= $routes->rss_feeds; ?>" maxlength="100" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="gallery_album_readonly" value="gallery_album" readonly>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="gallery_album" value="<?= $routes->gallery_album; ?>" maxlength="100" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="earnings_readonly" value="earnings" readonly>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="earnings" value="<?= $routes->earnings; ?>" maxlength="100" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="payouts_readonly" value="payouts" readonly>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="payouts" value="<?= $routes->payouts; ?>" maxlength="100" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="set_payout_account_readonly" value="set-payout-account" readonly>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="set_payout_account" value="<?= $routes->set_payout_account; ?>" maxlength="100" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="logout_readonly" value="logout" readonly>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="logout" value="<?= $routes->logout; ?>" maxlength="100" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                </div>
            </form>
        </div>
        <div class="alert alert-danger alert-large">
            <strong><?= trans("warning"); ?>!</strong>&nbsp;&nbsp;<?= trans("route_settings_warning"); ?>
        </div>
    </div>
</div>


