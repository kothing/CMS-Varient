<?php $sessVoteCount = 0;
$varSess = getSession('reaction_total_votes_' . $reactions->post_id);
if (empty($varSess)) {
    $varSess = helperGetCookie('reaction_total_votes_' . $reactions->post_id);
}
if (!empty($varSess)) {
    $sessVoteCount = intval($varSess);
}
$isVoted = false;
if (!empty(isReactionVoted($reactions->post_id, $reaction))) {
    $isVoted = true;
}
if (!empty($resultArray) && $resultArray['reaction'] == $reaction) {
    if ($resultArray['operation'] == 'increase') {
        $isVoted = true;
    }
    if ($resultArray['operation'] == 'decrease') {
        $isVoted = false;
    }
}
if ($sessVoteCount < 3): ?>
    <div class="col-reaction col-reaction-like" onclick="addReaction('<?= $reactions->post_id; ?>', '<?= $reaction; ?>');">
        <div class="col-sm-12">
            <div class="row">
                <div class="icon-cnt">
                    <img src="<?= base_url('assets/img/reactions/' . $reaction . '.png'); ?>" alt="<?= $reaction; ?>" class="img-reaction">
                    <label class="label reaction-num-votes"><?= $reactionVote; ?></label>
                </div>
            </div>
            <div class="row">
                <p class="text-center">
                    <label class="label label-reaction <?= $isVoted == true ? 'label-reaction-voted' : ''; ?>"><?= trans($reaction); ?></label>
                </p>
            </div>
        </div>
    </div>
<?php else:
    if ($isVoted == true): ?>
        <div class="col-reaction col-reaction-like" onclick="addReaction('<?= $reactions->post_id; ?>', '<?= $reaction; ?>');">
            <div class="col-sm-12">
                <div class="row">
                    <div class="icon-cnt">
                        <img src="<?= base_url('assets/img/reactions/' . $reaction . '.png'); ?>" alt="<?= $reaction; ?>" class="img-reaction">
                        <label class="label reaction-num-votes"><?= $reactionVote; ?></label>
                    </div>
                </div>
                <div class="row">
                    <p class="text-center">
                        <label class="label label-reaction label-reaction-voted"><?= trans($reaction); ?></label>
                    </p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="col-reaction col-reaction-like col-disable-voting">
            <div class="col-sm-12">
                <div class="row">
                    <div class="icon-cnt">
                        <img src="<?= base_url('assets/img/reactions/' . $reaction . '.png'); ?>" alt="<?= $reaction; ?>" class="img-reaction">
                        <label class="label reaction-num-votes"><?= $reactionVote; ?></label>
                    </div>
                </div>
                <div class="row">
                    <p class="text-center">
                        <label class="label label-reaction"><?= trans($reaction); ?></label>
                    </p>
                </div>
            </div>
        </div>
    <?php endif;
endif; ?>