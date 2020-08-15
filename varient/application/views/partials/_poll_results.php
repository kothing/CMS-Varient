<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="result">
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
        <?php endif; ?>

        <?php
        endif;
    endfor; ?>
    <p>
        <a onclick="view_poll_options('<?php echo $poll->id; ?>');" class="a-view-results m-0"><?php echo trans("view_options"); ?></a>
    </p>
</div>