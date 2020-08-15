<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?php echo $title; ?></h3>
        </div>
    </div><!-- /.box-header -->

    <div class="box-body">
        <div class="row">
            <!-- include message block -->
            <div class="col-sm-12">
                <?php $this->load->view('admin/includes/_messages'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" role="grid">
                        <thead>
                        <tr role="row">
                            <th width="20"><?php echo trans('role'); ?></th>
                            <th><?php echo trans('permissions'); ?></th>
                            <th style="width: 180px;"><?php echo trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($roles as $role): ?>
                            <tr>
                                <td><strong style="font-weight: 600;"><?php echo $role->role_name; ?></strong></td>
                                <td style="height: 50px;">
                                    <?php if ($role->role == "admin"): ?>
                                        <label class="label label-default"><?php echo trans("all_permissions") ?></label>
                                    <?php else: ?>
                                        <?php if ($role->admin_panel == 1): ?>
                                            <label class="label label-default"><?php echo trans("admin_panel") ?></label>
                                        <?php endif; ?>
                                        <?php if ($role->add_post == 1): ?>
                                            <label class="label label-default"><?php echo trans("add_post") ?></label>
                                        <?php endif; ?>
                                        <?php if ($role->manage_all_posts == 1): ?>
                                            <label class="label label-default"><?php echo trans("manage_all_posts") ?></label>
                                        <?php endif; ?>
                                        <?php if ($role->navigation == 1): ?>
                                            <label class="label label-default"><?php echo trans("navigation") ?></label>
                                        <?php endif; ?>
                                        <?php if ($role->pages == 1): ?>
                                            <label class="label label-default"><?php echo trans("pages") ?></label>
                                        <?php endif; ?>
                                        <?php if ($role->rss_feeds == 1): ?>
                                            <label class="label label-default"><?php echo trans("rss_feeds") ?></label>
                                        <?php endif; ?>
                                        <?php if ($role->categories == 1): ?>
                                            <label class="label label-default"><?php echo trans("categories") ?></label>
                                        <?php endif; ?>
                                        <?php if ($role->widgets == 1): ?>
                                            <label class="label label-default"><?php echo trans("widgets") ?></label>
                                        <?php endif; ?>
                                        <?php if ($role->polls == 1): ?>
                                            <label class="label label-default"><?php echo trans("polls") ?></label>
                                        <?php endif; ?>
                                        <?php if ($role->gallery == 1): ?>
                                            <label class="label label-default"><?php echo trans("gallery") ?></label>
                                        <?php endif; ?>
                                        <?php if ($role->comments_contact == 1): ?>
                                            <label class="label label-default"><?php echo trans("comments") ?>, <?php echo trans("contact_messages") ?></label>
                                        <?php endif; ?>
                                        <?php if ($role->newsletter == 1): ?>
                                            <label class="label label-default"><?php echo trans("newsletter") ?></label>
                                        <?php endif; ?>
                                        <?php if ($role->ad_spaces == 1): ?>
                                            <label class="label label-default"><?php echo trans("ad_spaces") ?></label>
                                        <?php endif; ?>
                                        <?php if ($role->users == 1): ?>
                                            <label class="label label-default"><?php echo trans("users") ?></label>
                                        <?php endif; ?>
                                        <?php if ($role->seo_tools == 1): ?>
                                            <label class="label label-default"><?php echo trans("seo_tools") ?></label>
                                        <?php endif; ?>
                                        <?php if ($role->settings == 1): ?>
                                            <label class="label label-default"><?php echo trans("settings") ?></label>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($role->role != "admin"): ?>
                                        <a href="<?php echo admin_url(); ?>edit-role/<?php echo $role->id; ?>" class="btn btn-success"><i class="fa fa-edit"></i>&nbsp;&nbsp;<?php echo trans("edit"); ?></a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>

<style>
    td label {
        float: left;
        margin-right: 10px;
        margin-bottom: 10px !important;
        padding: .3em .7em .4em !important;
    }
</style>