<?php if (checkUserPermission('admin_panel')): ?>
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box admin-small-box bg-success">
                <div class="inner">
                    <h3 class="increase-count"><?= $postsCount; ?></h3>
                    <a href="<?= adminURL('posts'); ?>">
                        <p><?= trans("posts"); ?></p>
                    </a>
                </div>
                <div class="icon">
                    <a href="<?= adminURL('posts'); ?>"><i class="fa fa-file"></i></a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box admin-small-box bg-danger">
                <div class="inner">
                    <h3 class="increase-count"><?= $pendingPostsCount; ?></h3>
                    <a href="<?= adminURL('pending-posts'); ?>">
                        <p><?= trans("pending_posts"); ?></p>
                    </a>
                </div>
                <div class="icon">
                    <a href="<?= adminURL('pending-posts'); ?>"><i class="fa fa-low-vision"></i></a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box admin-small-box bg-purple">
                <div class="inner">
                    <h3 class="increase-count"><?= $draftsCount; ?></h3>
                    <a href="<?= adminURL('drafts'); ?>">
                        <p><?= trans("drafts"); ?></p>
                    </a>
                </div>
                <div class="icon">
                    <a href="<?= adminURL('drafts'); ?>"><i class="fa fa-file-text-o"></i></a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box admin-small-box bg-warning">
                <div class="inner">
                    <h3 class="increase-count"><?= $scheduledPostsCount; ?></h3>
                    <a href="<?= adminURL('scheduled-posts'); ?>">
                        <p><?= trans("scheduled_posts"); ?></p>
                    </a>
                </div>
                <div class="icon">
                    <a href="<?= adminURL('scheduled-posts'); ?>"><i class="fa fa-clock-o"></i></a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

    <div class="row">
        <div class="col-sm-12 no-padding">
            <?php if (checkUserPermission('comments_contact')):
                if ($generalSettings->comment_approval_system != 1): ?>
                    <div class="col-lg-6 col-sm-12 col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title"><?= trans("comments"); ?></h3>
                                <br>
                                <small><?= trans("recently_added_comments"); ?></small>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <div class="box-body index-table">
                                <div class="table-responsive">
                                    <table class="table no-margin">
                                        <thead>
                                        <tr>
                                            <th><?= trans("id"); ?></th>
                                            <th><?= trans("name"); ?></th>
                                            <th style="width: 60%"><?= trans("comment"); ?></th>
                                            <th style="min-width: 13%"><?= trans("date"); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (!empty($latestComments)):
                                            foreach ($latestComments as $item): ?>
                                                <tr>
                                                    <td><?= esc($item->id); ?> </td>
                                                    <td><?= esc($item->name); ?></td>
                                                    <td style="width: 60%" class="break-word"><?= esc($item->comment); ?></td>
                                                    <td class="nowrap"><?= formatDate($item->created_at); ?></td>
                                                </tr>
                                            <?php endforeach;
                                        endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="box-footer clearfix">
                                <a href="<?= adminURL('comments'); ?>" class="btn btn-sm btn-default btn-flat pull-right"><?= trans("view_all"); ?></a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="col-lg-6 col-sm-12 col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title"><?= trans("pending_comments"); ?></h3>
                                <br>
                                <small><?= trans("recently_added_unapproved_comments"); ?></small>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <div class="box-body index-table">
                                <div class="table-responsive">
                                    <table class="table no-margin">
                                        <thead>
                                        <tr>
                                            <th><?= trans("id"); ?></th>
                                            <th><?= trans("name"); ?></th>
                                            <th style="width: 60%"><?= trans("comment"); ?></th>
                                            <th style="min-width: 13%"><?= trans("date"); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (!empty($latestPendingComments)):
                                            foreach ($latestPendingComments as $item): ?>
                                                <tr>
                                                    <td><?= esc($item->id); ?> </td>
                                                    <td><?= esc($item->name); ?></td>
                                                    <td style="width: 60%" class="break-word"><?= esc($item->comment); ?></td>
                                                    <td class="nowrap"><?= formatDate($item->created_at); ?></td>
                                                </tr>
                                            <?php endforeach;
                                        endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="box-footer clearfix">
                                <a href="<?= adminURL('pending-comments'); ?>" class="btn btn-sm btn-default btn-flat pull-right"><?= trans("view_all"); ?></a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="col-lg-6 col-sm-12 col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?= trans("last_contact_messages"); ?></h3>
                            <br>
                            <small><?= trans("recently_added_contact_messages"); ?></small>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body index-table">
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                    <tr>
                                        <th><?= trans("id"); ?></th>
                                        <th><?= trans("name"); ?></th>
                                        <th style="width: 60%"><?= trans("message"); ?></th>
                                        <th style="min-width: 13%"><?= trans("date"); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($latestContactMessages)):
                                        foreach ($latestContactMessages as $item): ?>
                                            <tr>
                                                <td><?= esc($item->id); ?></td>
                                                <td><?= esc($item->name); ?></td>
                                                <td style="width: 60%" class="break-word"><?= esc($item->message); ?></td>
                                                <td style="min-width: 16%" class="nowrap"><?= formatDate($item->created_at); ?></td>
                                            </tr>
                                        <?php endforeach;
                                    endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="box-footer clearfix">
                            <a href="<?= adminURL('contact-messages'); ?>" class="btn btn-sm btn-default btn-flat pull-right"><?= trans("view_all"); ?></a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php if (checkUserPermission('users')): ?>
    <div class="row">
        <div class="no-padding margin-bottom-20">
            <div class="col-lg-6 col-sm-12 col-xs-12">
                <div class="box box-primary box-sm">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= trans("latest_users"); ?></h3>
                        <br>
                        <small><?= trans("recently_registered_users"); ?></small>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <ul class="users-list clearfix">
                            <?php if (!empty($latestUsers)):
                                foreach ($latestUsers as $item) : ?>
                                    <li>
                                        <a href="<?= generateProfileURL($item->slug); ?>">
                                            <img src="<?= getUserAvatar($item->avatar); ?>" alt="user" class="img-responsive">
                                        </a>
                                        <a href="<?= generateProfileURL($item->slug); ?>" class="users-list-name"><?= esc($item->username); ?></a>
                                        <span class="users-list-date"><?= timeAgo($item->created_at); ?></span>
                                    </li>
                                <?php endforeach;
                            endif; ?>
                        </ul>
                    </div>
                    <div class="box-footer text-center">
                        <a href="<?= adminURL('users'); ?>" class="btn btn-sm btn-default btn-flat pull-right"><?= trans("view_all"); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>