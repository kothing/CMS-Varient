<div class="row">
    <div class="col-sm-12 title-section">
        <h3><?= trans('reward_system'); ?></h3>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans('settings'); ?></h3>
            </div>
            <form action="<?= base_url('RewardController/updateSettingsPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <label><?= trans('status'); ?></label>
                            </div>
                            <div class="col-sm-6 col-xs-12 col-option">
                                <input type="radio" name="reward_system_status" value="1" id="reward_system_status_1" class="square-purple" <?= $generalSettings->reward_system_status == 1 ? 'checked' : ''; ?>>
                                <label for="reward_system_status_1" class="option-label"><?= trans('enable'); ?></label>
                            </div>
                            <div class="col-sm-6 col-xs-12 col-option">
                                <input type="radio" name="reward_system_status" value="0" id="reward_system_status_2" class="square-purple" <?= $generalSettings->reward_system_status != 1 ? 'checked' : ''; ?>>
                                <label for="reward_system_status_2" class="option-label"><?= trans('disable'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= trans('reward_amount'); ?></label>
                        <div class="input-group">
                            <div class="input-group-addon"><b><?= $generalSettings->currency_symbol; ?></b></div>
                            <input type="text" class="form-control price-input" name="reward_amount" value="<?= $generalSettings->reward_amount; ?>" placeholder="E.g. 1.5" required>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                </div>
            </form>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans('payout_methods'); ?></h3>
            </div>
            <form action="<?= base_url('RewardController/updatePayoutPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <label><?= trans("paypal"); ?></label>
                            </div>
                            <div class="col-sm-6 col-xs-12 col-option">
                                <input type="radio" name="payout_paypal_status" value="1" id="payout_paypal_status_1" class="square-purple" <?= $generalSettings->payout_paypal_status == 1 ? 'checked' : ''; ?>>
                                <label for="payout_paypal_status_1" class="option-label"><?= trans('enable'); ?></label>
                            </div>
                            <div class="col-sm-6 col-xs-12 col-option">
                                <input type="radio" name="payout_paypal_status" value="0" id="payout_paypal_status_2" class="square-purple" <?= $generalSettings->payout_paypal_status != 1 ? 'checked' : ''; ?>>
                                <label for="payout_paypal_status_2" class="option-label"><?= trans('disable'); ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <label><?= trans("iban"); ?></label>
                            </div>
                            <div class="col-sm-6 col-xs-12 col-option">
                                <input type="radio" name="payout_iban_status" value="1" id="payout_iban_status_1" class="square-purple" <?= $generalSettings->payout_iban_status == 1 ? 'checked' : ''; ?>>
                                <label for="payout_iban_status_1" class="option-label"><?= trans('enable'); ?></label>
                            </div>
                            <div class="col-sm-6 col-xs-12 col-option">
                                <input type="radio" name="payout_iban_status" value="0" id="payout_iban_status_2" class="square-purple" <?= $generalSettings->payout_iban_status != 1 ? 'checked' : ''; ?>>
                                <label for="payout_iban_status_2" class="option-label"><?= trans('disable'); ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <label><?= trans("swift"); ?></label>
                            </div>
                            <div class="col-sm-6 col-xs-12 col-option">
                                <input type="radio" name="payout_swift_status" value="1" id="payout_swift_status_1" class="square-purple" <?= $generalSettings->payout_swift_status == 1 ? 'checked' : ''; ?>>
                                <label for="payout_swift_status_1" class="option-label"><?= trans('enable'); ?></label>
                            </div>
                            <div class="col-sm-6 col-xs-12 col-option">
                                <input type="radio" name="payout_swift_status" value="0" id="payout_swift_status_2" class="square-purple" <?= $generalSettings->payout_swift_status != 1 ? 'checked' : ''; ?>>
                                <label for="payout_swift_status_2" class="option-label"><?= trans('disable'); ?></label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans('currency'); ?></h3>
            </div>
            <form action="<?= base_url('RewardController/updateCurrencyPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label"><?= trans('currency_name'); ?></label>
                        <input type="text" class="form-control" name="currency_name" value="<?= $generalSettings->currency_name; ?>" placeholder="E.g. US Dollar" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= trans('currency_symbol'); ?></label>
                        <input type="text" class="form-control" name="currency_symbol" value="<?= esc($generalSettings->currency_symbol); ?>" placeholder="E.g. $, USD or <?= esc('&#36;') ?>" required>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12 m-b-5">
                                <label><?= trans('currency_format'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="currency_format" value="us" id="currency_format_1" class="square-purple" <?= $generalSettings->currency_format == 'us' ? 'checked' : ''; ?>>
                                <label for="currency_format_1" class="option-label">1<strong>,</strong>234<strong>,</strong>567<strong>.</strong>89</label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="currency_format" value="european" id="currency_format_2" class="square-purple" <?= $generalSettings->currency_format == 'european' ? 'checked' : ''; ?>>
                                <label for="currency_format_2" class="option-label">1<strong>.</strong>234<strong>.</strong>567<strong>,</strong>89</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12 m-b-5">
                                <label><?= trans('currency_symbol_format'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="currency_symbol_format" value="left" id="currency_symbol_format_1" class="square-purple" <?= $generalSettings->currency_symbol_format == 'left' ? 'checked' : ''; ?>>
                                <label for="currency_symbol_format_1" class="option-label">$100 (<?= trans("left"); ?>)</label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="currency_symbol_format" value="right" id="currency_symbol_format_2" class="square-purple" <?= $generalSettings->currency_symbol_format == 'right' ? 'checked' : ''; ?>>
                                <label for="currency_symbol_format_2" class="option-label">100$ (<?= trans("right"); ?>)</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>