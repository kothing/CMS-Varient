<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= $title; ?></h3>
        </div>
        <div class="right">
            <a href="<?= $topButtonURL; ?>" class="btn btn-success btn-add-new">
                <i class="fa fa-bars"></i>
                <?= $topButtonText; ?>
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr role="row">
                            <th width="20" class="table-no-sort" style="text-align: center !important;"><input type="checkbox" class="checkbox-table" id="checkAll"></th>
                            <th width="20"><?= trans('id'); ?></th>
                            <th><?= trans('user'); ?></th>
                            <th><?= trans('comment'); ?></th>
                            <th style="min-width: 20%"><?= trans('post'); ?></th>
                            <th style="min-width: 10%"><?= trans('ip_address'); ?></th>
                            <th style="min-width: 10%"><?= trans('date'); ?></th>
                            <th><?= trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($comments)):
                            foreach ($comments as $item): ?>
                                <tr>
                                    <td style="text-align: center !important;"><input type="checkbox" name="checkbox-table" class="checkbox-table" value="<?= $item->id; ?>"></td>
                                    <td><?= esc($item->id); ?></td>
                                    <td><?= esc($item->name); ?><br><?= esc($item->email); ?></td>
                                    <td class="break-word"><?= esc($item->comment); ?></td>
                                    <td>
                                        <?php $baseURL = generateBaseURLByLangId($item->post_lang_id); ?>
                                        <a href="<?= $baseURL . $item->post_slug; ?>" target="_blank"><?= esc($item->post_title); ?></a>
                                    </td>
                                    <td><?= esc($item->ip_address); ?></td>
                                    <td class="nowrap"><?= formatDate($item->created_at); ?></td>
                                    <td class="td-select-option">
                                        <form action="<?= base_url('AdminController/approveCommentPost'); ?>" method="post">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" name="id" value="<?= $item->id; ?>">
                                            <div class="dropdown">
                                                <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_an_option'); ?>
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu options-dropdown">
                                                    <?php if ($item->status != 1): ?>
                                                        <li>
                                                            <button type="submit"><i class="fa fa-check option-icon"></i><?= trans("approve"); ?></button>
                                                        </li>
                                                    <?php endif; ?>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="deleteItem('AdminController/deleteCommentPost','<?= $item->id; ?>','<?= clrQuotes(trans("confirm_comment")); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach;
                        endif; ?>
                        </tbody>
                    </table>
                    <?php if (empty($comments)): ?>
                        <p class="text-center">
                            <?= trans("no_records_found"); ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-sm-12 text-right">
                <div class="pull-left">
                    <button class="btn btn-sm btn-danger btn-table-delete" onclick="deleteSelectedComments('<?= clrQuotes(trans("confirm_comments")); ?>');"><i class="fa fa-trash"></i>&nbsp;<?= trans('delete'); ?></button>
                    <?php if ($showApproveButton == true): ?>
                        <button class="btn btn-sm btn-success btn-table-delete" onclick="approveSelectedComments();"><i class="fa fa-check"></i>&nbsp;<?= trans('approve'); ?></button>
                    <?php endif; ?>
                </div>
                <div class="pull-right">
                    <?= view('common/_pagination'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("input:checkbox").prop("checked", false);
    });
</script>