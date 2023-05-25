<?php $rewardModel = new \App\Models\RewardModel(); ?>
<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= trans('earnings'); ?></h3>
        </div>
        <div class="right">
            <a href="<?= adminUrl('reward-system/add-payout'); ?>" class="btn btn-success btn-add-new">
                <i class="fa fa-plus"></i>
                <?= trans('add_payout'); ?>
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" role="grid">
                        <?= view('admin/reward/_filter', ['url' => adminUrl('reward-system/earnings')]); ?>
                        <thead>
                        <tr role="row">
                            <th><?= trans('user_id'); ?></th>
                            <th><?= trans('username'); ?></th>
                            <th><?= trans('email'); ?></th>
                            <th><?= trans('total_pageviews'); ?></th>
                            <th><?= trans('balance'); ?></th>
                            <th><?= trans('payout_method'); ?></th>
                            <th><?= trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($earnings)):
                            foreach ($earnings as $item): ?>
                                <tr>
                                    <td><?= $item->id; ?></td>
                                    <td><?= esc($item->username); ?></td>
                                    <td><?= esc($item->email); ?></td>
                                    <td><?= esc($item->total_pageviews); ?></td>
                                    <td><?= priceFormatted($item->balance); ?></td>
                                    <td>
                                        <p class="m-0">
                                            <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#accountDetailsModel_<?= $item->id; ?>"><?= trans("payout_method"); ?></button>
                                        </p>
                                    </td>
                                    <td class="td-select-option">
                                        <div class="dropdown">
                                            <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_an_option'); ?>
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu options-dropdown">
                                                <li>
                                                    <a href="<?= adminUrl('edit-user/' . $item->id); ?>"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach;
                        endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-sm-12 text-right">
                <?= view('common/_pagination'); ?>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($earnings)) :
    foreach ($earnings as $item):
        $payout = $rewardModel->getUserPayoutAccount($item->id);
        if (!empty($payout)): ?>
            <div id="accountDetailsModel_<?= $item->id; ?>" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><?= trans($payout->default_payout_account); ?></h4>
                        </div>
                        <div class="modal-body">
                            <?php if ($payout->default_payout_account == "paypal"): ?>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <?= trans("user"); ?>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong>&nbsp;<?= esc($item->username); ?></strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <?= trans("paypal_email_address"); ?>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong>&nbsp;<?= $payout->payout_paypal_email; ?></strong>
                                    </div>
                                </div>
                            <?php elseif ($payout->default_payout_account == "iban"): ?>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <?= trans("user"); ?>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong>&nbsp;<?= esc($item->username); ?></strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <?= trans("full_name"); ?>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong>&nbsp;<?= esc($payout->iban_full_name); ?></strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <?= trans("country"); ?>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong>&nbsp;<?= esc($payout->iban_country); ?></strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <?= trans("bank_name"); ?>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong>&nbsp;<?= esc($payout->iban_bank_name); ?></strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <?= trans("iban"); ?>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong>&nbsp;<?= esc($payout->iban_number); ?></strong>
                                    </div>
                                </div>
                            <?php elseif ($payout->default_payout_account == "swift"): ?>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <?= trans("user"); ?>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong>&nbsp;<?= esc($item->username); ?></strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <?= trans("full_name"); ?>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong>&nbsp;<?= esc($payout->swift_full_name); ?></strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <?= trans("address"); ?>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong>&nbsp;<?= esc($payout->swift_address); ?></strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <?= trans("state"); ?>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong>&nbsp;<?= esc($payout->swift_state); ?></strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <?= trans("city"); ?>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong>&nbsp;<?= esc($payout->swift_city); ?></strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <?= trans("postcode"); ?>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong>&nbsp;<?= esc($payout->swift_postcode); ?></strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <?= trans("country"); ?>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong>&nbsp;<?= esc($payout->swift_country); ?></strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <?= trans("bank_account_holder_name"); ?>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong>&nbsp;<?= esc($payout->swift_bank_account_holder_name); ?></strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <?= trans("iban"); ?>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong>&nbsp;<?= esc($payout->swift_iban); ?></strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <?= trans("swift_code"); ?>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong>&nbsp;<?= esc($payout->swift_code); ?></strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <?= trans("bank_name"); ?>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong>&nbsp;<?= esc($payout->swift_bank_name); ?></strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <?= trans("bank_branch_city"); ?>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong>&nbsp;<?= esc($payout->swift_bank_branch_city); ?></strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <?= trans("bank_branch_country"); ?>
                                    </div>
                                    <div class="col-sm-8">
                                        <strong>&nbsp;<?= esc($payout->swift_bank_branch_country); ?></strong>
                                    </div>
                                </div>
                            <?php endif;
                            if ($payout->default_payout_account != 'paypal' && $payout->default_payout_account != 'iban' && $payout->default_payout_account != 'swift'): ?>
                                <p class="text-center text-muted"><?= trans("no_records_found"); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?= trans('close'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif;
    endforeach;
endif; ?>

<style>
    .modal .row {min-height: 26px;}
</style>
