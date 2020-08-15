<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php if (check_user_permission('manage_all_posts')): ?>
    <div class="box">
        <div class="box-header with-border">
            <div class="left">
                <h3 class="box-title"><?php echo trans('post_owner'); ?></h3>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body">
            <div class="form-group m-0">
                <label><?php echo trans("post_owner"); ?></label>
                <select name="user_id" class="form-control">
                    <?php foreach ($users as $user): ?>
                        <option value="<?php echo $user->id; ?>" <?php echo ($post->user_id == $user->id) ? 'selected' : ''; ?>><?php echo $user->username; ?>&nbsp;(<?php echo $user->role; ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
<?php else: ?>
    <input type="hidden" name="user_id" value="<?php echo $post->user_id; ?>">
<?php endif; ?>