<div class="row">
    <div class="col-sm-12 title-section">
        <h3><?= trans('newsletter'); ?></h3>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans('users'); ?></h3>
            </div>
            <form action="<?= adminUrl('newsletter-send-email'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="tableFixHead">
                        <table class="table table-users">
                            <thead>
                            <tr>
                                <th width="20"><input type="checkbox" id="check_all_users"></th>
                                <th><?= trans("id"); ?></th>
                                <th><?= trans("username"); ?></th>
                                <th><?= trans("email"); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($users)):
                                foreach ($users as $item): ?>
                                    <tr>
                                        <td><input type="checkbox" name="email[]" value="<?= $item->email; ?>"></td>
                                        <td><?= $item->id; ?></td>
                                        <td><?= esc($item->username); ?></td>
                                        <td><?= $item->email; ?></td>
                                    </tr>
                                <?php endforeach;
                            endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" name="submit" value="users" class="btn btn-lg btn-block btn-info"><?= trans("send_email"); ?>&nbsp;&nbsp;<i class="fa fa-send"></i></button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-6 col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans('subscribers'); ?></h3>
            </div>
            <form action="<?= adminUrl('newsletter-send-email'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <?php if (empty($subscribers)): ?>
                        <p class="text-muted"><?= trans("no_records_found"); ?></p>
                    <?php else: ?>
                        <div class="tableFixHead">
                            <table class="table table-subscribers">
                                <thead>
                                <tr>
                                    <th width="20"><input type="checkbox" id="check_all_subscribers"></th>
                                    <th><?= trans("email"); ?></th>
                                    <th><?= trans("options"); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($subscribers)):
                                    foreach ($subscribers as $item): ?>
                                        <tr>
                                            <td><input type="checkbox" name="email[]" value="<?= $item->email; ?>"></td>
                                            <td><?= $item->email; ?></td>
                                            <td><a href="javascript:void(0)" onclick="deleteItem('AdminController/deleteSubscriberPost','<?= $item->id; ?>','<?= clrQuotes(trans("confirm_item")); ?>');" class="text-danger"><i class="fa fa-trash"></i>&nbsp;&nbsp;<?= trans('delete'); ?></a></td>
                                        </tr>
                                    <?php endforeach;
                                endif; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="box-footer">
                    <button type="submit" name="submit" value="subscribers" class="btn btn-lg btn-block btn-info"><?= trans("send_email"); ?>&nbsp;&nbsp;<i class="fa fa-send"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans('settings'); ?></h3>
            </div>
            <form action="<?= base_url('AdminController/newsletterSettingsPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <label><?= trans('status'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="newsletter_status" value="1" id="newsletter_status_1" class="square-purple" <?= $generalSettings->newsletter_status == '1' ? 'checked' : ''; ?>>
                                <label for="newsletter_status_1" class="option-label"><?= trans('enable'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="newsletter_status" value="0" id="newsletter_status_2" class="square-purple" <?= $generalSettings->newsletter_status == '0' ? 'checked' : ''; ?>>
                                <label for="newsletter_status_2" class="option-label"><?= trans('disable'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <label><?= trans('newsletter_popup'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="newsletter_popup" value="1" id="newsletter_popup_1" class="square-purple" <?= $generalSettings->newsletter_popup == '1' ? 'checked' : ''; ?>>
                                <label for="newsletter_popup_1" class="option-label"><?= trans('enable'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="newsletter_popup" value="0" id="newsletter_popup_2" class="square-purple" <?= $generalSettings->newsletter_popup == '0' ? 'checked' : ''; ?>>
                                <label for="newsletter_popup_2" class="option-label"><?= trans('disable'); ?></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer text-right">
                    <button type="submit" name="submit" value="general" class="btn btn-primary"><?= trans('save_changes'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("#check_all_users").click(function () {
        $('.table-users input:checkbox').not(this).prop('checked', this.checked);
    });
    $("#check_all_subscribers").click(function () {
        $('.table-subscribers input:checkbox').not(this).prop('checked', this.checked);
    });
</script>
<style>
    .tableFixHead {
        overflow: auto;
        max-height: 600px !important;
    }

    .tableFixHead thead th {
        position: sticky;
        top: 0;
        z-index: 1;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        padding: 8px 16px;
    }

    th {
        background: #fff !important;
    }
</style>