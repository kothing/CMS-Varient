<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("add_user"); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open_multipart('admin_controller/add_user_post'); ?>

            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>

                <div class="form-group">
                    <label><?php echo trans("username"); ?></label>
                    <input type="text" name="username" class="form-control auth-form-input" placeholder="<?php echo trans("username"); ?>" value="<?php echo old("username"); ?>" required>
                </div>
                <div class="form-group">
                    <label><?php echo trans("email"); ?></label>
                    <input type="email" name="email" class="form-control auth-form-input" placeholder="<?php echo trans("email"); ?>" value="<?php echo old("email"); ?>" required>
                </div>
                <div class="form-group">
                    <label><?php echo trans("form_password"); ?></label>
                    <input type="password" name="password" class="form-control auth-form-input" placeholder="<?php echo trans("form_password"); ?>" value="<?php echo old("password"); ?>" required>
                </div>
                <div class="form-group">
                    <label><?php echo trans("role"); ?></label>
                    <select name="role" class="form-control">
                        <?php foreach ($roles as $role): ?>
                            <option value="<?php echo $role->role; ?>"><?php echo $role->role_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('add_user'); ?></button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
        <!-- /.box -->
    </div>
</div>
