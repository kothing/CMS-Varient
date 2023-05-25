<?php if (checkUserPermission('manage_all_posts')): ?>
    <div class="box">
        <div class="box-header with-border">
            <div class="left">
                <h3 class="box-title"><?= trans('post_owner'); ?></h3>
            </div>
        </div>
        <div class="box-body">
            <div class="form-group m-0">
                <label><?= trans("post_owner"); ?></label>
                <select name="user_id" class="form-control">
                    <?php if (!empty($users)):
                        foreach ($users as $user): ?>
                            <option value="<?= $user->id; ?>" <?= $post->user_id == $user->id ? 'selected' : ''; ?>><?= $user->username; ?>&nbsp;(<?= $user->role; ?>)</option>
                        <?php endforeach;
                    endif; ?>
                </select>
            </div>
        </div>
    </div>
<?php else: ?>
    <input type="hidden" name="user_id" value="<?= $post->user_id; ?>">
<?php endif; ?>