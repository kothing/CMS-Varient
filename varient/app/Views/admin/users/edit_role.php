<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans("edit_role"); ?></h3>
            </div>
            <form action="<?= base_url('AdminController/editRolePost'); ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" value="<?= $role->id; ?>">
                <div class="box-body">
                    <div class="form-group">
                        <label><?= trans("role_name"); ?></label>
                        <input type="text" class="form-control" name="role_name" placeholder="<?= trans("role_name"); ?>" value="<?= esc($role->role_name); ?>" maxlength="200" required>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-1 col-sm-2 col-xs-2">
                                <input type="checkbox" name="admin_panel" value="1" id="role_admin_panel" class="square-purple" <?= $role->admin_panel == 1 ? 'checked' : ''; ?>>
                            </div>
                            <div class="col-md-11 col-sm-10 col-xs-10">
                                <label for="role_admin_panel" class="control-label cursor-pointer"><?= trans('admin_panel'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-1 col-sm-2 col-xs-2">
                                <input type="checkbox" name="add_post" value="1" id="role_add_post" class="square-purple" <?= $role->add_post == 1 ? 'checked' : ''; ?>>
                            </div>
                            <div class="col-md-11 col-sm-10 col-xs-10">
                                <label for="role_add_post" class="control-label cursor-pointer"><?= trans('add_post'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-1 col-sm-2 col-xs-2">
                                <input type="checkbox" name="manage_all_posts" value="1" id="role_manage_all_posts" class="square-purple" <?= $role->manage_all_posts == 1 ? 'checked' : ''; ?>>
                            </div>
                            <div class="col-md-11 col-sm-10 col-xs-10">
                                <label for="role_manage_all_posts" class="control-label cursor-pointer"><?= trans('manage_all_posts'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-1 col-sm-2 col-xs-2">
                                <input type="checkbox" name="navigation" value="1" id="role_navigation" class="square-purple" <?= $role->navigation == 1 ? 'checked' : ''; ?>>
                            </div>
                            <div class="col-md-11 col-sm-10 col-xs-10">
                                <label for="role_navigation" class="control-label cursor-pointer"><?= trans('navigation'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-1 col-sm-2 col-xs-2">
                                <input type="checkbox" name="pages" value="1" id="role_pages" class="square-purple" <?= $role->pages == 1 ? 'checked' : ''; ?>>
                            </div>
                            <div class="col-md-11 col-sm-10 col-xs-10">
                                <label for="role_pages" class="control-label cursor-pointer"><?= trans('pages'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-1 col-sm-2 col-xs-2">
                                <input type="checkbox" name="rss_feeds" value="1" id="role_rss_feeds" class="square-purple" <?= $role->rss_feeds == 1 ? 'checked' : ''; ?>>
                            </div>
                            <div class="col-md-11 col-sm-10 col-xs-10">
                                <label for="role_rss_feeds" class="control-label cursor-pointer"><?= trans('rss_feeds'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-1 col-sm-2 col-xs-2">
                                <input type="checkbox" name="categories" value="1" id="role_categories" class="square-purple" <?= $role->categories == 1 ? 'checked' : ''; ?>>
                            </div>
                            <div class="col-md-11 col-sm-10 col-xs-10">
                                <label for="role_categories" class="control-label cursor-pointer"><?= trans('categories'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-1 col-sm-2 col-xs-2">
                                <input type="checkbox" name="widgets" value="1" id="role_widgets" class="square-purple" <?= $role->widgets == 1 ? 'checked' : ''; ?>>
                            </div>
                            <div class="col-md-11 col-sm-10 col-xs-10">
                                <label for="role_widgets" class="control-label cursor-pointer"><?= trans('widgets'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-1 col-sm-2 col-xs-2">
                                <input type="checkbox" name="polls" value="1" id="role_polls" class="square-purple" <?= $role->polls == 1 ? 'checked' : ''; ?>>
                            </div>
                            <div class="col-md-11 col-sm-10 col-xs-10">
                                <label for="role_polls" class="control-label cursor-pointer"><?= trans('polls'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-1 col-sm-2 col-xs-2">
                                <input type="checkbox" name="gallery" value="1" id="role_gallery" class="square-purple" <?= $role->gallery == 1 ? 'checked' : ''; ?>>
                            </div>
                            <div class="col-md-11 col-sm-10 col-xs-10">
                                <label for="role_gallery" class="control-label cursor-pointer"><?= trans('gallery'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-1 col-sm-2 col-xs-2">
                                <input type="checkbox" name="comments_contact" value="1" id="role_comments_contact" class="square-purple" <?= $role->comments_contact == 1 ? 'checked' : ''; ?>>
                            </div>
                            <div class="col-md-11 col-sm-10 col-xs-10">
                                <label for="role_comments_contact" class="control-label cursor-pointer"><?= trans("comments") ?>, <?= trans("contact_messages") ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-1 col-sm-2 col-xs-2">
                                <input type="checkbox" name="newsletter" value="1" id="role_newsletter" class="square-purple" <?= $role->newsletter == 1 ? 'checked' : ''; ?>>
                            </div>
                            <div class="col-md-11 col-sm-10 col-xs-10">
                                <label for="role_newsletter" class="control-label cursor-pointer"><?= trans("newsletter") ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-1 col-sm-2 col-xs-2">
                                <input type="checkbox" name="ad_spaces" value="1" id="role_ad_spaces" class="square-purple" <?= $role->ad_spaces == 1 ? 'checked' : ''; ?>>
                            </div>
                            <div class="col-md-11 col-sm-10 col-xs-10">
                                <label for="role_ad_spaces" class="control-label cursor-pointer"><?= trans("ad_spaces") ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-1 col-sm-2 col-xs-2">
                                <input type="checkbox" name="users" value="1" id="role_users" class="square-purple" <?= $role->users == 1 ? 'checked' : ''; ?>>
                            </div>
                            <div class="col-md-11 col-sm-10 col-xs-10">
                                <label for="role_users" class="control-label cursor-pointer"><?= trans("users") ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-1 col-sm-2 col-xs-2">
                                <input type="checkbox" name="seo_tools" value="1" id="role_seo_tools" class="square-purple" <?= $role->seo_tools == 1 ? 'checked' : ''; ?>>
                            </div>
                            <div class="col-md-11 col-sm-10 col-xs-10">
                                <label for="role_seo_tools" class="control-label cursor-pointer"><?= trans("seo_tools") ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-1 col-sm-2 col-xs-2">
                                <input type="checkbox" name="settings" value="1" id="role_settings" class="square-purple" <?= $role->settings == 1 ? 'checked' : ''; ?>>
                            </div>
                            <div class="col-md-11 col-sm-10 col-xs-10">
                                <label for="role_settings" class="control-label cursor-pointer"><?= trans("settings") ?></label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?> </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .form-group .col-sm-2 {
        max-width: 40px;
        padding-right: 0 !important;
    }
</style>
