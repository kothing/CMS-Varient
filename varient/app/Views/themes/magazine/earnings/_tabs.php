<div class="profile-list-group">
    <ul class="list-group">
        <li class="list-group-item <?= $activeTab == 'earnings' ? 'active' : ''; ?>">
            <a href="<?= generateURL('earnings'); ?>"><span><?= trans("earnings"); ?></span></a>
        </li>
        <li class="list-group-item <?= $activeTab == 'payouts' ? 'active' : ''; ?>">
            <a href="<?= generateURL('payouts'); ?>"><span><?= trans("payouts"); ?></span></a>
        </li>
        <li class="list-group-item <?= $activeTab == 'setPayoutAccount' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= generateURL("set_payout_account") . '?payout=paypal'; ?>"><span><?= trans("set_payout_account"); ?></span></a>
        </li>
    </ul>
</div>