<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
    <div class="box-header">
        <div class="left">
            <h3 class="box-title"><?php echo trans('subscribers'); ?></h3>
        </div>
    </div><!-- /.box-header -->

    <div class="box-body">
        <?php $this->load->view('admin/includes/_messages'); ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped dataTable" id="cs_datatable" role="grid"
                           aria-describedby="example1_info">
                        <thead>
                        <tr role="row">
                            <th width="20"><?php echo trans('id'); ?></th>
                            <th><?php echo trans('email'); ?></th>
                            <th><?php echo trans('send_email'); ?></th>
                            <th><?php echo trans('date_added'); ?></th>
                            <th class="max-width-120"><?php echo trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($subscribers as $item): ?>
                            <tr>
                                <td><?php echo html_escape($item->id); ?></td>
                                <td><?php echo html_escape($item->email); ?></td>
                                <td>
                                    <a href="<?php echo admin_url(); ?>send-email-subscriber/<?php echo $item->id; ?>" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-envelope"></i>&nbsp;&nbsp;&nbsp;<?php echo trans('send_email'); ?></a>
                                </td>
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
                                                <a href="javascript:void(0)" onclick="delete_item('admin_controller/delete_newsletter_post','<?php echo $item->id; ?>','<?php echo trans("confirm_email"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>