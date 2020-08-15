<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?php echo trans('contact_messages'); ?></h3>
        </div>
    </div><!-- /.box-header -->

    <!-- include message block -->
    <div class="col-sm-12">
        <?php $this->load->view('admin/includes/_messages'); ?>
    </div>

    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped dataTable" id="cs_datatable" role="grid"
                           aria-describedby="example1_info">
                        <thead>
                        <tr role="row">
                            <th width="20" class="table-no-sort" style="text-align: center !important;"><input type="checkbox" class="checkbox-table" id="checkAll"></th>
                            <th width="20"><?php echo trans('id'); ?></th>
                            <th><?php echo trans('name'); ?></th>
                            <th><?php echo trans('email'); ?></th>
                            <th><?php echo trans('message'); ?></th>
                            <th><?php echo trans('date'); ?></th>
                            <th class="max-width-120"><?php echo trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($messages as $item): ?>
                            <tr>
                                <td style="text-align: center !important;"><input type="checkbox" name="checkbox-table" class="checkbox-table" value="<?php echo $item->id; ?>"></td>
                                <td><?php echo html_escape($item->id); ?></td>
                                <td><?php echo html_escape($item->name); ?></td>
                                <td><?php echo html_escape($item->email); ?></td>
                                <td class="break-word"><?php echo html_escape($item->message); ?></td>
                                <td><?php echo formatted_date($item->created_at); ?></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn bg-purple dropdown-toggle btn-select-option"
                                                type="button"
                                                data-toggle="dropdown"><?php echo trans('select_an_option'); ?>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu options-dropdown">
                                            <li>
                                                <a href="javascript:void(0)" onclick="delete_item('admin_controller/delete_contact_message_post','<?php echo $item->id; ?>','<?php echo trans("confirm_message"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>

                <div class="col-sm-12">
                    <div class="row">
                        <div class="pull-left">
                            <button class="btn btn-sm btn-danger btn-table-delete" onclick="delete_selected_contact_messages('<?php echo trans("confirm_messages"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div><!-- /.box-body -->
</div>
