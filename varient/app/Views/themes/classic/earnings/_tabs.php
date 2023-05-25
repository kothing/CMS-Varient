<div class="profile-tabs">
    <ul class="nav">
        <li class="nav-item <?= $activeTab == 'earnings' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= generateURL('earnings'); ?>">
                <span><?= trans("earnings"); ?></span>
            </a>
        </li>
        <li class="nav-item <?= $activeTab == 'payouts' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= generateURL('payouts'); ?>">
                <span><?= trans("payouts"); ?></span>
            </a>
        </li>
        <li class="nav-item <?= $activeTab == 'setPayoutAccount' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= generateURL("set_payout_account") . '?payout=paypal'; ?>">
                <span><?= trans("set_payout_account"); ?></span>
            </a>
        </li>
    </ul>
</div>