<div class="result">
    <h5 class="title"><?= esc($poll->question); ?></h5>
    <?php $totalVote = calculateTotalVotePollOption($poll); ?>
    <p class="total-vote"><?= trans("total_vote"); ?>&nbsp;<?= $totalVote; ?></p>
    <?php for ($i = 1; $i <= 10; $i++):
        $option = "option" . $i;
        $paramVoteCount = "option" . $i . "_vote_count";
        $percent = 0;
        if (!empty($poll->$option)):
            $optionVote = $poll->$paramVoteCount;
            if ($totalVote > 0):
                $percent = round(($optionVote * 100) / $totalVote, 1);
            endif; ?>
            <span class="m-b-10 display-block"><?= esc($poll->$option); ?></span>
            <?php if ($percent == 0): ?>
            <div class="progress">
                <span><?= $percent; ?>&nbsp;%</span>
                <div class="progress-bar progress-bar-0" role="progressbar" aria-valuenow="<?= $totalVote; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?= $percent; ?>%"></div>
            </div>
        <?php else: ?>
            <div class="progress">
                <span><?= $percent; ?>&nbsp;%</span>
                <div class="progress-bar" role="progressbar" aria-valuenow="<?= $totalVote; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?= $percent; ?>%"></div>
            </div>
        <?php endif;
        endif;
    endfor; ?>
    <p><a onclick="viewPollOptions('<?= $poll->id; ?>');" class="a-view-results m-0"><?= trans("view_options"); ?></a></p>
</div>