<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!--Widget: Our Picks-->
<div class="sidebar-widget">
    <div class="widget-head">
        <h4 class="title"><?php echo html_escape($widget->title); ?></h4>
    </div>
    <div class="widget-body">

        <?php foreach ($this->polls as $poll): ?>
            <?php if ($poll->status == 1): ?>

                <?php if ($poll->vote_permission == "all"): ?>
                    <div id="poll_<?php echo $poll->id; ?>" class="poll">

                        <div class="question">
                            <form data-form-id="<?php echo $poll->id; ?>" class="poll-form" method="post">
                                <input type="hidden" name="poll_id" value="<?php echo $poll->id; ?>">
                                <input type="hidden" name="vote_permission" value="<?php echo $poll->vote_permission; ?>">
                                <h5 class="title"><?php echo html_escape($poll->question); ?></h5>
                                <?php
                                for ($i = 1; $i <= 10; $i++):
                                    $option = "option" . $i;

                                    if (!empty($poll->$option)): ?>
                                        <p class="option">
                                            <label class="custom-checkbox custom-radio">
                                                <input type="radio" name="option" id="option<?php echo $poll->id; ?>-<?php echo $i; ?>" value="<?php echo $option; ?>">
                                                <span class="checkbox-icon"><i class="icon-check"></i></span>
                                                <span class="label-poll-option"><?php echo html_escape($poll->$option); ?></span>
                                            </label>
                                        </p>
                                    <?php
                                    endif;
                                endfor; ?>

                                <p class="button-cnt">
                                    <button type="submit" class="btn btn-sm btn-custom"><?php echo trans("vote"); ?></button>
                                    <a onclick="view_poll_results('<?php echo $poll->id; ?>');" class="a-view-results"><?php echo trans("view_results"); ?></a>
                                </p>
                                <div id="poll-required-message-<?php echo $poll->id; ?>" class="poll-error-message">
                                    <?php echo trans("please_select_option"); ?>
                                </div>
                                <div id="poll-error-message-<?php echo $poll->id; ?>" class="poll-error-message">
                                    <?php echo trans("voted_message"); ?>
                                </div>
                            </form>
                        </div>

                        <div class="result" id="poll-results-<?php echo $poll->id; ?>">
                            <h5 class="title"><?php echo html_escape($poll->question); ?></h5>

                            <?php $total_vote = calculate_total_vote_poll_option($poll); ?>

                            <p class="total-vote"><?php echo trans("total_vote"); ?>&nbsp;<?php echo $total_vote; ?></p>

                            <?php for ($i = 1; $i <= 10; $i++):
                                $option = "option" . $i;
                                $param_vote_count = "option" . $i . "_vote_count";
                                $percent = 0;
                                if (!empty($poll->$option)):
                                    $option_vote = $poll->$param_vote_count;
                                    if ($total_vote > 0) {
                                        $percent = round(($option_vote * 100) / $total_vote, 1);
                                    } ?>

                                    <span class="m-b-10 display-block"><?php echo html_escape($poll->$option); ?></span>

                                    <?php if ($percent == 0): ?>
                                    <div class="progress">
                                        <span><?php echo $percent; ?>&nbsp;%</span>
                                        <div class="progress-bar progress-bar-0" role="progressbar" aria-valuenow="<?php echo $total_vote; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $percent; ?>%"></div>
                                    </div>
                                <?php else: ?>
                                    <div class="progress">
                                        <span><?php echo $percent; ?>&nbsp;%</span>
                                        <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $total_vote; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $percent; ?>%"></div>
                                    </div>
                                <?php endif;
                                endif;
                            endfor; ?>
                            <p>
                                <a onclick="view_poll_options('<?php echo $poll->id; ?>');" class="a-view-results m-0"><?php echo trans("view_options"); ?></a>
                            </p>
                        </div>

                    </div>
                <?php else: ?>
                    <div id="poll_<?php echo $poll->id; ?>" class="poll">

                        <div class="question">
                            <form data-form-id="<?php echo $poll->id; ?>" class="poll-form" method="post">
                                <input type="hidden" name="poll_id" value="<?php echo $poll->id; ?>">
                                <input type="hidden" name="vote_permission" value="<?php echo $poll->vote_permission; ?>">
                                <h5 class="title"><?php echo html_escape($poll->question); ?></h5>
                                <?php
                                for ($i = 1; $i <= 10; $i++):
                                    $option = "option" . $i;

                                    if (!empty($poll->$option)): ?>
                                        <p class="option">
                                            <label class="custom-checkbox custom-radio">
                                                <input type="radio" name="option" id="option<?php echo $poll->id; ?>-<?php echo $i; ?>" value="<?php echo $option; ?>">
                                                <span class="checkbox-icon"><i class="icon-check"></i></span>
                                                <span class="label-poll-option"><?php echo html_escape($poll->$option); ?></span>
                                            </label>
                                        </p>
                                    <?php
                                    endif;
                                endfor; ?>

                                <?php if ($this->auth_check): ?>
                                    <p class="button-cnt">
                                        <button type="submit" class="btn btn-sm btn-custom"><?php echo trans("vote"); ?></button>
                                        <a onclick="view_poll_results('<?php echo $poll->id; ?>');" class="a-view-results"><?php echo trans("view_results"); ?></a>
                                    </p>
                                <?php else: ?>
                                    <p class="button-cnt">
                                        <button type="button" class="btn btn-sm btn-custom" data-toggle="modal" data-target="#modal-login"><?php echo trans("vote"); ?></button>
                                        <a href="#" class="a-view-results" data-toggle="modal" data-target="#modal-login"><?php echo trans("view_results"); ?></a>
                                    </p>
                                <?php endif; ?>
                                <div id="poll-required-message-<?php echo $poll->id; ?>" class="poll-error-message">
                                    <?php echo trans("please_select_option"); ?>
                                </div>
                                <div id="poll-error-message-<?php echo $poll->id; ?>" class="poll-error-message">
                                    <?php echo trans("voted_message"); ?>
                                </div>
                            </form>

                        </div>

                        <div class="result" id="poll-results-<?php echo $poll->id; ?>">
                            <h5 class="title"><?php echo html_escape($poll->question); ?></h5>

                            <?php $total_vote = calculate_total_vote_poll_option($poll); ?>

                            <p class="total-vote"><?php echo trans("total_vote"); ?>&nbsp;<?php echo $total_vote; ?></p>

                            <?php for ($i = 1; $i <= 10; $i++):
                                $option = "option" . $i;
                                $param_vote_count = "option" . $i . "_vote_count";
                                $percent = 0;
                                if (!empty($poll->$option)):
                                    $option_vote = $poll->$param_vote_count;
                                    if ($total_vote > 0) {
                                        $percent = round(($option_vote * 100) / $total_vote, 1);
                                    } ?>
                                    <span class="m-b-10 display-block"><?php echo html_escape($poll->$option); ?></span>
                                    <?php if ($percent == 0): ?>
                                    <div class="progress">
                                        <span><?php echo $percent; ?>&nbsp;%</span>
                                        <div class="progress-bar progress-bar-0" role="progressbar" aria-valuenow="<?php echo $total_vote; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $percent; ?>%"></div>
                                    </div>
                                <?php else: ?>
                                    <div class="progress">
                                        <span><?php echo $percent; ?>&nbsp;%</span>
                                        <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $total_vote; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $percent; ?>%"></div>
                                    </div>
                                <?php endif;
                                endif;
                            endfor; ?>
                            <p>
                                <a onclick="view_poll_options('<?php echo $poll->id; ?>');" class="a-view-results m-0"><?php echo trans("view_options"); ?></a>
                            </p>
                        </div>
                    </div>
                <?php endif; ?>

            <?php endif; ?>
        <?php endforeach; ?>

    </div>
</div>