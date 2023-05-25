<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= $title; ?></h3>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" role="grid">
                        <thead>
                        <tr role="row">
                            <th width="20"><?= trans('role'); ?></th>
                            <th><?= trans('permissions'); ?></th>
                            <th><?= trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($roles)):
                            foreach ($roles as $role): ?>
                                <tr>
                                    <td><strong style="font-weight: 600;"><?= $role->role_name; ?></strong></td>
                                    <td style="height: 50px;">
                                        <?php if ($role->role == "admin"): ?>
                                            <label class="label label-success"><?= trans("all_permissions") ?></label>
                                        <?php else:
                                            if ($role->admin_panel == 1): ?>
                                                <label class="label label-success"><?= trans("admin_panel") ?></label>
                                            <?php endif;
                                            if ($role->add_post == 1): ?>
                                                <label class="label label-success"><?= trans("add_post") ?></label>
                                            <?php endif;
                                            if ($role->manage_all_posts == 1): ?>
                                                <label class="label label-success"><?= trans("manage_all_posts") ?></label>
                                            <?php endif;
                                            if ($role->navigation == 1): ?>
                                                <label class="label label-success"><?= trans("navigation") ?></label>
                                            <?php endif;
                                            if ($role->pages == 1): ?>
                                                <label class="label label-success"><?= trans("pages") ?></label>
                                            <?php endif;
                                            if ($role->rss_feeds == 1): ?>
                                                <label class="label label-success"><?= trans("rss_feeds") ?></label>
                                            <?php endif;
                                            if ($role->categories == 1): ?>
                                                <label class="label label-success"><?= trans("categories") ?></label>
                                            <?php endif;
                                            if ($role->widgets == 1): ?>
                                                <label class="label label-success"><?= trans("widgets") ?></label>
                                            <?php endif;
                                            if ($role->polls == 1): ?>
                                                <label class="label label-success"><?= trans("polls") ?></label>
                                            <?php endif;
                                            if ($role->gallery == 1): ?>
                                                <label class="label label-success"><?= trans("gallery") ?></label>
                                            <?php endif;
                                            if ($role->comments_contact == 1): ?>
                                                <label class="label label-success"><?= trans("comments") ?>, <?= trans("contact_messages") ?></label>
                                            <?php endif;
                                            if ($role->newsletter == 1): ?>
                                                <label class="label label-success"><?= trans("newsletter") ?></label>
                                            <?php endif;
                                            if ($role->ad_spaces == 1): ?>
                                                <label class="label label-success"><?= trans("ad_spaces") ?></label>
                                            <?php endif;
                                            if ($role->users == 1): ?>
                                                <label class="label label-success"><?= trans("users") ?></label>
                                            <?php endif;
                                            if ($role->seo_tools == 1): ?>
                                                <label class="label label-success"><?= trans("seo_tools") ?></label>
                                            <?php endif;
                                            if ($role->settings == 1): ?>
                                                <label class="label label-success"><?= trans("settings") ?></label>
                                            <?php endif;
                                        endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($role->role != "admin"): ?>
                                            <a href="<?= adminUrl('edit-role/' . $role->id); ?>" class="btn btn-success"><i class="fa fa-edit"></i>&nbsp;&nbsp;<?= trans("edit"); ?></a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach;
                        endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    td label {
        float: left;
        margin-right: 10px;
        margin-bottom: 10px !important;
        padding: .3em .7em .4em !important;
    }
</style>