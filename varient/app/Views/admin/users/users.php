<?php $authModel = new \App\Models\AuthModel(); ?>
<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= trans("users"); ?></h3>
        </div>
        <div class="right">
            <a href="<?= adminUrl('add-user'); ?>" class="btn btn-success btn-add-new">
                <i class="fa fa-plus"></i>
                <?= trans("add_user"); ?>
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <?= view('admin/users/_filter'); ?>
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr role="row">
                            <th width="20"><?= trans('id'); ?></th>
                            <th><?= trans('user'); ?></th>
                            <th><?= trans('email'); ?></th>
                            <th><?= trans('role'); ?></th>
                            <th><?= trans('status'); ?></th>
                            <th><?= trans('date'); ?></th>
                            <th><?= trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($users)):
                            foreach ($users as $user): ?>
                                <tr>
                                    <td><?= $user->id; ?></td>
                                    <td class="td-user">
                                        <a href="<?= generateProfileURL($user->slug); ?>" target="_blank" class="table-link">
                                            <img src="<?= getUserAvatar($user->avatar); ?>" alt="" class="img-responsive">
                                            <strong><?= esc($user->username); ?></strong>
                                        </a>
                                        <?php if ($user->reward_system_enabled == 1): ?>
                                            <p><label class="label bg-primary"><?= trans('reward_system'); ?></label></p>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?= esc($user->email);
                                        if ($user->email_status == 1): ?>
                                            <small class="text-success">(<?= trans("confirmed"); ?>)</small>
                                        <?php else: ?>
                                            <small class="text-danger">(<?= trans("unconfirmed"); ?>)</small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php $role = $authModel->getRoleByKey($user->role);
                                        if (!empty($role)):
                                            if ($user->role == 'moderator'):?>
                                                <label class="label bg-olive"><?= esc($role->role_name); ?></label>
                                            <?php elseif ($user->role == 'author'): ?>
                                                <label class="label label-warning"><?= esc($role->role_name); ?></label>
                                            <?php elseif ($user->role == 'user'): ?>
                                                <label class="label label-default"><?= esc($role->role_name); ?></label>
                                            <?php endif;
                                        endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($user->status == 1): ?>
                                            <label class="label label-success"><?= trans('active'); ?></label>
                                        <?php else: ?>
                                            <label class="label label-danger"><?= trans('banned'); ?></label>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= formatDate($user->created_at); ?></td>
                                    <td class="td-select-option">
                                        <form action="<?= base_url('AdminController/userOptionsPost'); ?>" method="post">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" name="id" value="<?= $user->id; ?>">
                                            <div class="dropdown">
                                                <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_an_option'); ?>
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu options-dropdown">
                                                    <?php if (user()->role == 'admin'): ?>
                                                        <li>
                                                            <button type="button" class="btn-list-button" data-toggle="modal" data-target="#myModal" onclick="$('#modal_user_id').val('<?= $user->id; ?>');">
                                                                <i class="fa fa-user option-icon"></i><?= trans('change_user_role'); ?>
                                                            </button>
                                                        </li>
                                                    <?php endif;
                                                    if ($user->reward_system_enabled == 1): ?>
                                                        <li>
                                                            <button type="submit" name="submit" value="reward_system" class="btn-list-button"><i class="fa fa-money option-icon"></i><?= trans('disable_reward_system'); ?></button>
                                                        </li>
                                                    <?php else: ?>
                                                        <li>
                                                            <button type="submit" name="submit" value="reward_system" class="btn-list-button"><i class="fa fa-money option-icon"></i><?= trans('enable_reward_system'); ?></button>
                                                        </li>
                                                    <?php endif;
                                                    if ($user->email_status != 1): ?>
                                                        <li>
                                                            <button type="submit" name="submit" value="confirm_email" class="btn-list-button"><i class="fa fa-check option-icon"></i><?= trans('confirm_user_email'); ?></button>
                                                        </li>
                                                    <?php endif;
                                                    if ($user->status == "1"): ?>
                                                        <li>
                                                            <button type="submit" name="submit" value="ban_user" class="btn-list-button"><i class="fa fa-stop-circle option-icon"></i><?= trans('ban_user'); ?></button>
                                                        </li>
                                                    <?php else: ?>
                                                        <li>
                                                            <button type="submit" name="submit" value="ban_user" class="btn-list-button"><i class="fa fa-stop-circle option-icon"></i><?= trans('remove_ban'); ?></button>
                                                        </li>
                                                    <?php endif; ?>
                                                    <li>
                                                        <a href="<?= adminUrl('edit-user/' . $user->id); ?>"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="deleteItem('AdminController/deleteUserPost','<?= $user->id; ?>','<?= clrQuotes(trans("confirm_user")); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach;
                        endif; ?>
                        </tbody>
                    </table>
                    <?php if (empty($users)): ?>
                        <p class="text-center text-muted"><?= trans("no_records_found"); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-sm-12 text-right">
                <?= view('common/_pagination'); ?>
            </div>
        </div>
    </div>
</div>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?= trans('change_user_role'); ?></h4>
            </div>
            <form action="<?= base_url('AdminController/changeUserRolePost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <input type="hidden" name="user_id" id="modal_user_id" value="">
                            <div class="col-sm-3">
                                <input type="radio" name="role" value="admin" id="role_admin" class="square-purple" required>&nbsp;&nbsp;
                                <?php $role = $authModel->getRoleByKey('admin'); ?>
                                <label for="role_admin" class="option-label cursor-pointer"><?= !empty($role) ? esc($role->role_name) : ''; ?></label>
                            </div>
                            <div class="col-sm-3">
                                <input type="radio" name="role" value="moderator" id="role_moderator" class="square-purple" required>&nbsp;&nbsp;
                                <?php $role = $authModel->getRoleByKey('moderator'); ?>
                                <label for="role_moderator" class="option-label cursor-pointer"><?= !empty($role) ? esc($role->role_name) : ''; ?></label>
                            </div>
                            <div class="col-sm-3">
                                <input type="radio" name="role" value="author" id="role_editor" class="square-purple" required>&nbsp;&nbsp;
                                <?php $role = $authModel->getRoleByKey('author'); ?>
                                <label for="role_editor" class="option-label cursor-pointer"><?= !empty($role) ? esc($role->role_name) : ''; ?></label>
                            </div>
                            <div class="col-sm-3">
                                <input type="radio" name="role" value="user" id="role_user" class="square-purple" required>&nbsp;&nbsp;
                                <?php $role = $authModel->getRoleByKey('user'); ?>
                                <label for="role_user" class="option-label cursor-pointer"><?= !empty($role) ? esc($role->role_name) : ''; ?></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><?= trans('save'); ?></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= trans('close'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>