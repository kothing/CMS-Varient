<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans('polls'); ?></h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl('add-poll'); ?>" class="btn btn-success btn-add-new"><i class="fa fa-plus"></i><?= trans('add_poll'); ?></a>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped dataTable" id="cs_datatable_lang" role="grid" aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th width="20"><?= trans('id'); ?></th>
                                    <th><?= trans('question'); ?></th>
                                    <th><?= trans('language'); ?></th>
                                    <th><?= trans('vote_permission'); ?></th>
                                    <th><?= trans('status'); ?></th>
                                    <th><?= trans('date_added'); ?></th>
                                    <th class="max-width-120"><?= trans('options'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($polls)):
                                    foreach ($polls as $item): ?>
                                        <tr>
                                            <td><?= esc($item->id); ?></td>
                                            <td class="break-word"><?= esc($item->question); ?>&nbsp;&nbsp;&nbsp;
                                                <button class="btn btn-info btn-xs" data-toggle="modal" data-target="#pollModal<?= esc($item->id); ?>"><?= trans('view_results'); ?></button>
                                            </td>
                                            <td>
                                                <?php $lang = getLanguage($item->lang_id);
                                                if (!empty($lang)) {
                                                    echo esc($lang->name);
                                                } ?>
                                            </td>
                                            <td>
                                                <?php if ($item->vote_permission == "all") {
                                                    trans('all_users_can_vote');
                                                } else {
                                                    trans('registered_users_can_vote');
                                                } ?>
                                            </td>
                                            <td>
                                                <?php if ($item->status == 1): ?>
                                                    <label class="label label-success"><?= trans('active'); ?></label>
                                                <?php else: ?>
                                                    <label class="label label-danger"><?= trans('inactive'); ?></label>
                                                <?php endif; ?>
                                            </td>

                                            <td><?= formatDate($item->created_at); ?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_an_option'); ?>
                                                        <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu options-dropdown">
                                                        <li>
                                                            <a href="<?= adminUrl('edit-poll/' . esc($item->id)); ?>"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0)" onclick="deleteItem('AdminController/deletePollPost','<?= $item->id; ?>','<?= clrQuotes(trans("confirm_poll")); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($polls)):
    foreach ($polls as $poll): ?>
        <div id="pollModal<?= $poll->id; ?>" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><?= esc($poll->question); ?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="poll">
                            <div class="result">
                                <?php $totalVote = calculateTotalVotePollOption($poll); ?>
                                <p class="total-vote text-center"><strong><?= trans('total_vote'); ?> <?= $totalVote; ?></strong></p>
                                <?php for ($i = 1; $i <= 10; $i++):
                                    $option = "option" . $i;
                                    $paramVoteCount = "option" . $i . "_vote_count";
                                    $percent = 0;
                                    if (!empty($poll->$option)):
                                        $option_vote = $poll->$paramVoteCount;
                                        if ($totalVote > 0) {
                                            $percent = round(($option_vote * 100) / $totalVote, 1);
                                        } ?>
                                        <span><?= esc($poll->$option); ?></span>
                                        <?php if ($percent == 0): ?>
                                        <div class="progress">
                                            <span><?= $percent; ?>&nbsp;%</span>
                                            <div class="progress-bar progress-bar-0" role="progressbar" aria-valuenow="<?= $totalVote; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?= $percent; ?>%"></div>
                                        </div>
                                    <?php else: ?>
                                        <div class="progress">
                                            <span><?= $percent; ?>&nbsp;%</span>
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?= $totalVote; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?= $percent; ?>%"></div>
                                        </div>
                                    <?php endif;
                                    endif;
                                endfor; ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?= trans('close'); ?></button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach;
endif; ?>