<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= trans('contact_messages'); ?></h3>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped dataTable" id="cs_datatable" role="grid" aria-describedby="example1_info">
                        <thead>
                        <tr role="row">
                            <th width="20" class="table-no-sort" style="text-align: center !important;"><input type="checkbox" class="checkbox-table" id="checkAll"></th>
                            <th width="20"><?= trans('id'); ?></th>
                            <th><?= trans('name'); ?></th>
                            <th><?= trans('email'); ?></th>
                            <th><?= trans('message'); ?></th>
                            <th><?= trans('date'); ?></th>
                            <th class="max-width-120"><?= trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($messages)):
                            foreach ($messages as $item): ?>
                                <tr>
                                    <td style="text-align: center !important;"><input type="checkbox" name="checkbox-table" class="checkbox-table" value="<?= $item->id; ?>"></td>
                                    <td><?= esc($item->id); ?></td>
                                    <td><?= esc($item->name); ?></td>
                                    <td><?= esc($item->email); ?></td>
                                    <td class="break-word"><?= esc($item->message); ?></td>
                                    <td><?= formatDate($item->created_at); ?></td>
                                    <td class="td-select-option">
                                        <div class="dropdown">
                                            <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_an_option'); ?>
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu options-dropdown">
                                                <li>
                                                    <a href="javascript:void(0)" onclick="deleteItem('AdminController/deleteContactMessagePost','<?= $item->id; ?>','<?= clrQuotes(trans("confirm_message")); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a>
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
                <div class="col-sm-12">
                    <div class="row">
                        <div class="pull-left">
                            <button class="btn btn-sm btn-danger btn-table-delete" onclick="deleteSelectedContactMessages('<?= clrQuotes(trans("confirm_messages")); ?>');"><i class="fa fa-trash"></i>&nbsp;<?= trans('delete'); ?></button>
                        </div>
                    </div>
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