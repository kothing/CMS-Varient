<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?php echo trans('users'); ?></h3>
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
                    <table class="table table-bordered table-striped dataTable" id="cs_datatable" role="grid"
                           aria-describedby="example1_info">
                        <thead>
                        <tr role="row">
                            <th width="20"><?php echo trans('id'); ?></th>
                            <th><?php echo trans('avatar'); ?></th>
                            <th><?php echo trans('username'); ?></th>
                            <th><?php echo trans('email'); ?></th>
                            <th><?php echo trans('role'); ?></th>
                            <th><?php echo trans('status'); ?></th>
                            <th><?php echo trans('date'); ?></th>
                            <th class="max-width-120"><?php echo trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo html_escape($user->id); ?></td>
                                <td>
                                    <img src="<?php echo get_user_avatar($user); ?>" alt="user" class="img-responsive" style="height: 50px;">
                                </td>
                                <td><?php echo html_escape($user->username); ?></td>
                                <td>
                                    <?php echo html_escape($user->email);
                                    if ($user->email_status == 1): ?>
                                        <small class="text-success">(<?php echo trans("confirmed"); ?>)</small>
                                    <?php else: ?>
                                        <small class="text-danger">(<?php echo trans("unconfirmed"); ?>)</small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php $role = $this->auth_model->get_role_by_key($user->role);
                                    if (!empty($role)):
                                        if ($user->role == "moderator"):?>
                                            <label class="label bg-olive"><?php echo $role->role_name; ?></label>
                                        <?php elseif ($user->role == "author"): ?>
                                            <label class="label label-warning"><?php echo $role->role_name; ?></label>
                                        <?php elseif ($user->role == "user"): ?>
                                            <label class="label label-default"><?php echo $role->role_name; ?></label>
                                        <?php endif;
                                    endif; ?>
                                </td>
                                <td>
                                    <?php if ($user->status == 1): ?>
                                        <label class="label label-success"><?php echo trans('active'); ?></label>
                                    <?php else: ?>
                                        <label class="label label-danger"><?php echo trans('banned'); ?></label>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo formatted_date($user->created_at); ?></td>
                                <td>
                                    <!-- form post options -->
                                    <?php echo form_open('admin_controller/user_options_post'); ?>
                                    <input type="hidden" name="id" value="<?php echo html_escape($user->id); ?>">

                                    <div class="dropdown">
                                        <button class="btn bg-purple dropdown-toggle btn-select-option"
                                                type="button"
                                                data-toggle="dropdown"><?php echo trans('select_an_option'); ?>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu options-dropdown">
                                            <?php if (user()->role == 'admin'): ?>
                                                <li>
                                                    <button type="button" class="btn-list-button" data-toggle="modal" data-target="#myModal"
                                                            onclick="$('#modal_user_id').val('<?php echo html_escape($user->id); ?>');">
                                                        <i class="fa fa-user option-icon"></i><?php echo trans('change_user_role'); ?>
                                                    </button>
                                                </li>
                                            <?php endif; ?>
                                            <li>
                                                <?php if ($user->email_status != 1): ?>
                                                    <a href="javascript:void(0)" onclick="confirm_user_email(<?php echo $user->id; ?>);"><i class="fa fa-check option-icon"></i><?php echo trans('confirm_user_email'); ?></a>
                                                <?php endif; ?>
                                            </li>
                                            <?php if ($user->status == "1"): ?>
                                                <li>
                                                    <a href="javascript:void(0)" onclick="ban_user('<?php echo $user->id; ?>','<?php echo trans("confirm_ban"); ?>', 'ban');"><i class="fa fa-stop-circle option-icon"></i><?php echo trans('ban_user'); ?></a>
                                                </li>
                                            <?php else: ?>
                                                <li>
                                                    <a href="javascript:void(0)" onclick="ban_user('<?php echo $user->id; ?>', '<?php echo trans("confirm_remove_ban"); ?>', 'remove_ban');"><i class="fa fa-stop-circle option-icon"></i><?php echo trans('remove_ban'); ?></a>
                                                </li>
                                            <?php endif; ?>
                                            <li>
                                                <a href="<?php echo admin_url(); ?>edit-user/<?php echo html_escape($user->id); ?>"><i class="fa fa-edit option-icon"></i><?php echo trans('edit'); ?></a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" onclick="delete_item('admin_controller/delete_user_post','<?php echo $user->id; ?>','<?php echo trans("confirm_user"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
                                            </li>
                                        </ul>
                                    </div>

                                    <?php echo form_close(); ?><!-- form end -->
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


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo trans('change_user_role'); ?></h4>
            </div>
            <?php echo form_open('admin_controller/change_user_role_post'); ?>
            <div class="modal-body">
                <div class="form-group">
                    <div class="row">

                        <input type="hidden" name="user_id" id="modal_user_id" value="">

                        <div class="col-sm-3">
                            <input type="radio" name="role" value="admin" id="role_admin" class="square-purple" required>&nbsp;&nbsp;
                            <?php $role = $this->auth_model->get_role_by_key('admin'); ?>
                            <label for="role_admin" class="option-label cursor-pointer"><?php echo !empty($role) ? $role->role_name : ''; ?></label>
                        </div>
                        <div class="col-sm-3">
                            <input type="radio" name="role" value="moderator" id="role_moderator" class="square-purple" required>&nbsp;&nbsp;
                            <?php $role = $this->auth_model->get_role_by_key('moderator'); ?>
                            <label for="role_moderator" class="option-label cursor-pointer"><?php echo !empty($role) ? $role->role_name : ''; ?></label>
                        </div>
                        <div class="col-sm-3">
                            <input type="radio" name="role" value="author" id="role_editor" class="square-purple" required>&nbsp;&nbsp;
                            <?php $role = $this->auth_model->get_role_by_key('author'); ?>
                            <label for="role_editor" class="option-label cursor-pointer"><?php echo !empty($role) ? $role->role_name : ''; ?></label>
                        </div>
                        <div class="col-sm-3">
                            <input type="radio" name="role" value="user" id="role_user" class="square-purple" required>&nbsp;&nbsp;
                            <?php $role = $this->auth_model->get_role_by_key('user'); ?>
                            <label for="role_user" class="option-label cursor-pointer"><?php echo !empty($role) ? $role->role_name : ''; ?></label>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success"><?php echo trans('save'); ?></button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo trans('close'); ?></button>
            </div>

            <?php echo form_close(); ?><!-- form end -->
        </div>

    </div>
</div>