<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= trans('pageviews'); ?>&nbsp;(<?= trans("this_month"); ?>)</h3>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" role="grid">
                        <?= view('admin/reward/_filter', ['url' => adminUrl('reward-system/pageviews')]); ?>
                        <thead>
                        <tr role="row">
                            <th><?= trans("post"); ?></th>
                            <th><?= trans("author"); ?></th>
                            <th><?= trans("ip_address"); ?></th>
                            <th><?= trans("user_agent"); ?></th>
                            <th><?= trans("earnings"); ?></th>
                            <th><?= trans("date"); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($pageviews)):
                            foreach ($pageviews as $item): ?>
                                <tr>
                                    <td><?= $item->post_id; ?></td>
                                    <td>
                                        <a href="<?= generateProfileURL($item->author_slug); ?>" target="_blank" class="table-user-link"><strong><?= esc($item->author_username); ?></strong></a>
                                    </td>
                                    <td><?= esc($item->ip_address); ?></td>
                                    <td><?= esc($item->user_agent); ?></td>
                                    <td><?= priceFormatted($item->reward_amount, getRewardPriceDecimal()); ?></td>
                                    <td><?= $item->created_at; ?></td>
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