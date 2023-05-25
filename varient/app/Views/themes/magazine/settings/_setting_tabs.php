<div class="profile-list-group">
    <ul class="list-group">
        <li class="list-group-item <?= $activeTab == 'update_profile' ? 'active' : ''; ?>">
            <a href="<?= generateURL('settings'); ?>"><?= trans("update_profile"); ?></a>
        </li>
        <li class="list-group-item <?= $activeTab == 'social_accounts' ? 'active' : ''; ?>">
            <a href="<?= generateURL('settings', 'social_accounts'); ?>"><?= trans("social_accounts"); ?></a>
        </li>
        <li class="list-group-item <?= $activeTab == 'preferences' ? 'active' : ''; ?>">
            <a href="<?= generateURL('settings', 'preferences'); ?>"><?= trans("preferences"); ?></a>
        </li>
        <li class="list-group-item <?= $activeTab == 'change_password' ? 'active' : ''; ?>">
            <a href="<?= generateURL('settings', 'change_password'); ?>"><?= trans("change_password"); ?></a>
        </li>
        <li class="list-group-item <?= $activeTab == 'delete_account' ? 'active' : ''; ?>">
            <a href="<?= generateURL('settings', 'delete_account'); ?>"><?= trans("delete_account"); ?></a>
        </li>
    </ul>
</div>