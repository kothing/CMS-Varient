<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= langBaseUrl(); ?>"><?= trans("home"); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= trans("payouts"); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="profile-page-top">
                    <?= loadView('profile/_profile_user_info', ['user' => user()]); ?>
                </div>
            </div>
        </div>
        <div class="profile-page">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3">
                    <?= loadView('earnings/_tabs'); ?>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-9">
                    <div class="table-responsive table-payouts">
                        <table class="table table-striped">
                            <thead>
                            <tr role="row">
                                <th><?= trans('amount'); ?></th>
                                <th><?= trans('payout_method'); ?></th>
                                <th><?= trans('date'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($payouts)):
                                foreach ($payouts as $item): ?>
                                    <tr>
                                        <td><?= priceFormatted($item->amount); ?></td>
                                        <td><?= trans($item->payout_method); ?></td>
                                        <td><?= formatDateFront($item->created_at); ?></td>
                                    </tr>
                                <?php endforeach;
                            endif; ?>
                            </tbody>
                        </table>
                        <?php if (empty($payouts)): ?>
                            <p class="text-center text-muted"><?= trans("no_records_found"); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-12 col-xs-12">
                        <?= view('common/_pagination'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>