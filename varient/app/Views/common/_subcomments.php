<?php if (!empty($parentComment)):
    $subComments = getSubComments($parentComment->id);
    if (!empty($subComments)): ?>
        <div class="col-12">
            <div class="comments">
                <ul class="comment-list">
                    <?php foreach ($subComments as $subComment): ?>
                        <li>
                            <div class="left">
                                <?php if (!empty($subComment->user_slug)): ?>
                                    <a href="<?= generateProfileURL($subComment->user_slug); ?>"><img src="<?= getUserAvatar($subComment->user_avatar); ?>" alt="<?= esc($subComment->name); ?>"></a>
                                <?php else: ?>
                                    <img src="<?= getUserAvatar($subComment->user_avatar); ?>" alt="<?= esc($subComment->name); ?>">
                                <?php endif; ?>
                            </div>
                            <div class="right">
                                <div class="row-custom">
                                    <?php if (!empty($subComment->user_slug)): ?>
                                        <a href="<?= generateProfileURL($subComment->user_slug); ?>" class="username"><?= esc($subComment->name); ?></a>
                                    <?php else: ?>
                                        <span class="username"><?= esc($subComment->name); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="row-custom comment">
                                    <?= esc($subComment->comment); ?>
                                </div>
                                <div class="row-custom">
                                    <div class="d-flex justify-content-start align-items-center comment-meta">
                                        <div class="item item-date">
                                            <?= timeAgo($subComment->created_at); ?>
                                        </div>
                                        <div class="item item-like">
                                            <a href="javascript:void(0)" class="btn-comment-like<?= isCommentVoted($subComment->id) ? ' comment-liked' : ''; ?><?= checkCommentOwner($subComment) ? ' comment-own' : ''; ?>" data-comment-id="<?= $subComment->id; ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-hand-thumbs-up-fill" viewBox="0 0 16 16">
                                                    <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"/>
                                                </svg>
                                                <?= trans("like"); ?>&nbsp;(<span id="lbl_comment_like_count_<?= $subComment->id; ?>"><?= $subComment->like_count; ?></span>)</a>
                                        </div>
                                        <?php if (authCheck()):
                                            if ($subComment->user_id == user()->id || user()->role == 'admin'): ?>
                                                <div class="item item-delete">
                                                    <a href="javascript:void(0)" class="btn-delete-comment" onclick="deleteComment('<?= $subComment->id; ?>','<?= $post->id; ?>','<?= clrQuotes(trans("confirm_comment")); ?>');">&nbsp;<i class="icon-trash"></i>&nbsp;<?= trans("delete"); ?></a>
                                                </div>
                                            <?php endif;
                                        endif; ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif;
endif; ?>