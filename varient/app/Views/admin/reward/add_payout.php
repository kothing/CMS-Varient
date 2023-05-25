<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans('add_payout'); ?></h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl('reward-system/earnings'); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-bars"></i>
                        <?= trans('earnings'); ?>
                    </a>
                    <a href="<?= adminUrl('reward-system/payouts'); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-bars"></i>
                        <?= trans('payouts'); ?>
                    </a>
                </div>
            </div>
            <form action="<?= base_url('RewardController/addPayoutPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label><?= trans("user"); ?></label>
                        <select name="user_id" class="form-control">
                            <option value=""><?= trans('select'); ?></option>
                            <?php if (!empty($users)):
                                foreach ($users as $user): ?>
                                    <option value="<?= $user->id; ?>"><?= "Id: " . $user->id . " - " . $user->username; ?>&nbsp;(<?= trans("balance") . ": " . priceFormatted($user->balance); ?>)</option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><?= trans("payout_method"); ?></label>
                        <select name="payout_method" class="form-control">
                            <option value=""><?= trans('select'); ?></option>
                            <option value="paypal"><?= trans("paypal"); ?></option>
                            <option value="iban"><?= trans("iban"); ?></option>
                            <option value="swift"><?= trans("swift"); ?></option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('amount'); ?></label>
                        <div class="input-group">
                            <div class="input-group-addon"><b><?= $generalSettings->currency_symbol; ?></b></div>
                            <input type="text" class="form-control price-input" name="amount" placeholder="E.g. 1.5" required>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('add_payout'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>