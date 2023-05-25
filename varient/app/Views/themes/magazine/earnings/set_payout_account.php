<section class="section section-page">
    <div class="container-xl">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                    <li class="breadcrumb-item active"><?= trans("set_payout_account"); ?></li>
                </ol>
            </nav>
            <h1 class="page-title"><?= trans("set_payout_account"); ?></h1>
            <div class="page-content">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <?= loadView('earnings/_tabs'); ?>
                    </div>
                    <div class="col-sm-12 col-md-9">
                        <?php $showAllTabs = false; ?>
                        <ul class="nav nav-pills nav-payout-accounts display-flex justify-content-center">
                            <?php if ($generalSettings->payout_paypal_status): $showAllTabs = true; ?>
                                <li class="<?= $selectedPayout == 'paypal' ? 'active' : ''; ?>">
                                    <a class="nav-link-paypal" href="<?= generateURL("set_payout_account") . '?payout=paypal'; ?>"><?= trans("paypal"); ?></a>
                                </li>
                            <?php endif;
                            if ($generalSettings->payout_iban_status): $showAllTabs = true; ?>
                                <li class="<?= $selectedPayout == 'iban' ? 'active' : ''; ?>">
                                    <a class="nav-link-bank" href="<?= generateURL("set_payout_account") . '?payout=iban'; ?>"><?= trans("iban"); ?></a>
                                </li>
                            <?php endif;
                            if ($generalSettings->payout_swift_status): $showAllTabs = true; ?>
                                <li class="<?= $selectedPayout == 'swift' ? 'active' : ''; ?>">
                                    <a class="nav-link-swift" href="<?= generateURL("set_payout_account") . '?payout=swift'; ?>"><?= trans("swift"); ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                        <?php if ($showAllTabs): ?>
                            <div class="tab-content">
                                <div class="tab-pane <?= $selectedPayout == 'paypal' ? 'active' : 'fade'; ?>" id="tab_paypal">
                                    <?php if ($selectedPayout == 'paypal'):
                                        echo loadView('partials/_messages');
                                    endif; ?>
                                    <form action="<?= base_url('set-paypal-payout-account-post'); ?>" method="post" class="needs-validation">
                                        <?= csrf_field(); ?>
                                        <input type="hidden" name="back_url" value="<?= currentFullURL(); ?>">
                                        <div class="mb-3">
                                            <label class="form-label"><?= trans("paypal_email_address"); ?>*</label>
                                            <input type="email" name="payout_paypal_email" class="form-control form-input" value="<?= esc($userPayout->payout_paypal_email); ?>" required>
                                        </div>
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" name="default_payout_account" id="checkbox1" class="form-check-input" value="paypal" <?= $userPayout->default_payout_account == 'paypal' ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="checkbox1"><?= trans("set_default_payment_account"); ?></label>
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-md btn-custom"><?= trans("save_changes"); ?></button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane <?= $selectedPayout == 'iban' ? 'active' : 'fade'; ?>" id="tab_iban">
                                    <?php if ($selectedPayout == 'iban'):
                                        echo loadView('partials/_messages');
                                    endif; ?>
                                    <form action="<?= base_url('set-iban-payout-account-post'); ?>" method="post" class="needs-validation">
                                        <?= csrf_field(); ?>
                                        <input type="hidden" name="back_url" value="<?= currentFullURL(); ?>">
                                        <div class="mb-3">
                                            <label class="form-label"><?= trans("full_name"); ?>*</label>
                                            <input type="text" name="iban_full_name" class="form-control form-input" value="<?= esc($userPayout->iban_full_name); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-12 col-md-6 m-b-sm-15">
                                                    <label class="form-label"><?= trans("country"); ?>*</label>
                                                    <input type="text" name="iban_country" class="form-control form-input" value="<?= esc($userPayout->iban_country); ?>" required>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label"><?= trans("bank_name"); ?>*</label>
                                                    <input type="text" name="iban_bank_name" class="form-control form-input" value="<?= esc($userPayout->iban_bank_name); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label"><?= trans("iban_long"); ?>(<?= trans("iban"); ?>)*</label>
                                            <input type="text" name="iban_number" class="form-control form-input" value="<?= esc($userPayout->iban_number); ?>" required>
                                        </div>
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" name="default_payout_account" id="checkbox2" class="form-check-input" value="iban" <?= $userPayout->default_payout_account == 'iban' ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="checkbox2"><?= trans("set_default_payment_account"); ?></label>
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-md btn-custom"><?= trans("save_changes"); ?></button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane <?= $selectedPayout == 'swift' ? 'active' : 'fade'; ?>" id="tab_swift">
                                    <?php if ($selectedPayout == 'swift'):
                                        echo loadView('partials/_messages');
                                    endif; ?>
                                    <form action="<?= base_url('set-swift-payout-account-post'); ?>" method="post" class="needs-validation">
                                        <?= csrf_field(); ?>
                                        <input type="hidden" name="back_url" value="<?= currentFullURL(); ?>">
                                        <div class="mb-3">
                                            <label class="form-label"><?= trans("full_name"); ?>*</label>
                                            <input type="text" name="swift_full_name" class="form-control form-input" value="<?= esc($userPayout->swift_full_name); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-12 col-md-6 m-b-sm-15">
                                                    <label class="form-label"><?= trans("country"); ?>*</label>
                                                    <input type="text" name="swift_country" class="form-control form-input" value="<?= esc($userPayout->swift_country); ?>" required>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label"><?= trans("state"); ?>*</label>
                                                    <input type="text" name="swift_state" class="form-control form-input" value="<?= esc($userPayout->swift_state); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-12 col-md-6 m-b-sm-15">
                                                    <label class="form-label"><?= trans("city"); ?>*</label>
                                                    <input type="text" name="swift_city" class="form-control form-input" value="<?= esc($userPayout->swift_city); ?>" required>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label"><?= trans("postcode"); ?>*</label>
                                                    <input type="text" name="swift_postcode" class="form-control form-input" value="<?= esc($userPayout->swift_postcode); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label"><?= trans("address"); ?>*</label>
                                            <input type="text" name="swift_address" class="form-control form-input" value="<?= esc($userPayout->swift_address); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-12 col-md-6 m-b-sm-15">
                                                    <label class="form-label"><?= trans("bank_account_holder_name"); ?>*</label>
                                                    <input type="text" name="swift_bank_account_holder_name" class="form-control form-input" value="<?= esc($userPayout->swift_bank_account_holder_name); ?>" required>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label"><?= trans("bank_name"); ?>*</label>
                                                    <input type="text" name="swift_bank_name" class="form-control form-input" value="<?= esc($userPayout->swift_bank_name); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-12 col-md-6 m-b-sm-15">
                                                    <label class="form-label"><?= trans("bank_branch_country"); ?>*</label>
                                                    <input type="text" name="swift_bank_branch_country" class="form-control form-input" value="<?= esc($userPayout->swift_bank_branch_country); ?>" required>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label"><?= trans("bank_branch_city"); ?>*</label>
                                                    <input type="text" name="swift_bank_branch_city" class="form-control form-input" value="<?= esc($userPayout->swift_bank_branch_city); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label"><?= trans("swift_iban"); ?>*</label>
                                            <input type="text" name="swift_iban" class="form-control form-input" value="<?= esc($userPayout->swift_iban); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label"><?= trans("swift_code"); ?>*</label>
                                            <input type="text" name="swift_code" class="form-control form-input" value="<?= esc($userPayout->swift_code); ?>" required>
                                        </div>
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" name="default_payout_account" id="checkbox3" class="form-check-input" value="swift" <?= $userPayout->default_payout_account == 'swift' ? 'checked' : ''; ?>>
                                            <label class="form-check-label" for="checkbox3"><?= trans("set_default_payment_account"); ?></label>
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-md btn-custom"><?= trans("save_changes"); ?></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php endif; ?>
                        <p class="warning-set-payout">**<?= trans("warning_default_payout_account"); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>