<?php $authModel = new \App\Models\AuthModel(); ?>
<div class="row table-filter-container">
    <div class="col-sm-12">
        <form action="<?= adminUrl('users'); ?>" method="get">
            <div class="item-table-filter" style="width: 80px; min-width: 80px;">
                <label><?= trans("show"); ?></label>
                <select name="show" class="form-control">
                    <option value="15" <?= inputGet('show', true) == '15' ? 'selected' : ''; ?>>15</option>
                    <option value="30" <?= inputGet('show', true) == '30' ? 'selected' : ''; ?>>30</option>
                    <option value="60" <?= inputGet('show', true) == '60' ? 'selected' : ''; ?>>60</option>
                    <option value="100" <?= inputGet('show', true) == '100' ? 'selected' : ''; ?>>100</option>
                </select>
            </div>

            <div class="item-table-filter">
                <label><?= trans("status"); ?></label>
                <select name="status" class="form-control">
                    <option value=""><?= trans("all"); ?></option>
                    <option value="1" <?= inputGet('status', true) == 1 ? 'selected' : ''; ?>><?= trans("active"); ?></option>
                    <option value="0" <?= inputGet('status', true) != null && inputGet('status', true) != 1 ? 'selected' : ''; ?>><?= trans("banned"); ?></option>
                </select>
            </div>

            <div class="item-table-filter">
                <label><?= trans("role"); ?></label>
                <select name="role" class="form-control">
                    <option value=""><?= trans("all"); ?></option>
                    <option value="moderator" <?= inputGet('role', true) == 'moderator' ? 'selected' : ''; ?>><?= @esc($authModel->getRoleByKey('moderator')->role_name); ?></option>
                    <option value="author" <?= inputGet('role', true) == 'author' ? 'selected' : ''; ?>><?= @esc($authModel->getRoleByKey('author')->role_name); ?></option>
                    <option value="user" <?= inputGet('role', true) == 'user' ? 'selected' : ''; ?>><?= @esc($authModel->getRoleByKey('user')->role_name); ?></option>
                </select>
            </div>

            <div class="item-table-filter">
                <label><?= trans("email_status"); ?></label>
                <select name="email_status" class="form-control">
                    <option value=""><?= trans("all"); ?></option>
                    <option value="1" <?= inputGet('email_status', true) == 1 ? 'selected' : ''; ?>><?= trans("confirmed"); ?></option>
                    <option value="0" <?= inputGet('email_status', true) != null && inputGet('email_status', true) != 1 ? 'selected' : ''; ?>><?= trans("unconfirmed"); ?></option>
                </select>
            </div>

            <div class="item-table-filter">
                <label><?= trans("reward_system"); ?></label>
                <select name="reward_system" class="form-control">
                    <option value=""><?= trans("all"); ?></option>
                    <option value="1" <?= inputGet('reward_system', true) == 1 ? 'selected' : ''; ?>><?= trans("active"); ?></option>
                    <option value="0" <?= inputGet('reward_system', true) != null && inputGet('reward_system', true) != 1 ? 'selected' : ''; ?>><?= trans("inactive"); ?></option>
                </select>
            </div>

            <div class="item-table-filter item-table-filter-long">
                <label><?= trans("search"); ?></label>
                <input name="q" class="form-control" placeholder="<?= trans("search") ?>" type="search" value="<?= esc(inputGet('q', true)); ?>">
            </div>

            <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
                <label style="display: block">&nbsp;</label>
                <button type="submit" class="btn bg-purple"><?= trans("filter"); ?></button>
            </div>
        </form>
    </div>
</div>