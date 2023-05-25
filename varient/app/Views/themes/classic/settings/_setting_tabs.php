<div class="profile-tabs">
    <ul class="nav">
        <li class="nav-item <?= $activeTab == 'update_profile' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= generateURL('settings'); ?>">
                <span><?= trans("update_profile"); ?></span>
            </a>
        </li>
        <li class="nav-item <?= $activeTab == 'social_accounts' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= generateURL('settings', 'social_accounts'); ?>">
                <span><?= trans("social_accounts"); ?></span>
            </a>
        </li>
        <li class="nav-item <?= $activeTab == 'preferences' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= generateURL('settings', 'preferences'); ?>">
                <span><?= trans("preferences"); ?></span>
            </a>
        </li>
        <li class="nav-item <?= $activeTab == 'change_password' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= generateURL('settings', 'change_password'); ?>">
                <span><?= trans("change_password"); ?></span>
            </a>
        </li>
        <li class="nav-item <?= $activeTab == 'delete_account' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= generateURL('settings', 'delete_account'); ?>">
                <span><?= trans("delete_account"); ?></span>
            </a>
        </li>
    </ul>
</div>