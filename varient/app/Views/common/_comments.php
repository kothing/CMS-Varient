<input type="hidden" value="<?= $commentLimit; ?>" id="post_comment_limit">
<div class="row">
    <div class="col-sm-12">
        <div class="comments">
            <?php if ($commentCount > 0): ?>
                <div class="row-custom comment-total">
                    <label class="label-comment"><?= trans("comments"); ?> (<?= $commentCount; ?>)</label>
                </div>
            <?php endif; ?>
            <ul class="comment-list">
                <?php if (!empty($comments)):
                    foreach ($comments as $comment):?>
                        <li>
                            <div class="left">
                                <?php if (!empty($comment->user_slug)): ?>
                                    <a href="<?= generateProfileURL($comment->user_slug); ?>"><img src="<?= getUserAvatar($comment->user_avatar); ?>" alt="<?= esc($comment->name); ?>"></a>
                                <?php else: ?>
                                    <img src="<?= getUserAvatar($comment->user_avatar); ?>" alt="<?= esc($comment->name); ?>">
                                <?php endif; ?>
                            </div>
                            <div class="right">
                                <div class="row-custom">
                                    <?php if (!empty($comment->user_slug)): ?>
                                        <a href="<?= generateProfileURL($comment->user_slug); ?>" class="username"><?= esc($comment->name); ?></a>
                                    <?php else: ?>
                                        <span class="username"><?= esc($comment->name); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="row-custom comment">
                                    <?= esc($comment->comment); ?>
                                </div>
                                <div class="row-custom">
                                    <div class="d-flex justify-content-start align-items-center comment-meta">
                                        <div class="item item-date">
                                            <?= timeAgo($comment->created_at); ?>
                                        </div>
                                        <div class="item item-reply">
                                            <a href="javascript:void(0)" class="btn-reply" data-parent="<?= $comment->id; ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 512 512">
                                                    <path d="M8.309 189.836L184.313 37.851C199.719 24.546 224 35.347 224 56.015v80.053c160.629 1.839 288 34.032 288 186.258 0 61.441-39.581 122.309-83.333 154.132-13.653 9.931-33.111-2.533-28.077-18.631 45.344-145.012-21.507-183.51-176.59-185.742V360c0 20.7-24.3 31.453-39.687 18.164l-176.004-152c-11.071-9.562-11.086-26.753 0-36.328z"/>
                                                </svg>

                                                <?= trans('btn_reply'); ?>
                                            </a>
                                        </div>
                                        <div class="item item-like">
                                            <a href="javascript:void(0)" class="btn-comment-like<?= isCommentVoted($comment->id) ? ' comment-liked' : ''; ?><?= checkCommentOwner($comment) ? ' comment-own' : ''; ?>" data-comment-id="<?= $comment->id; ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-hand-thumbs-up-fill" viewBox="0 0 16 16">
                                                    <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"/>
                                                </svg>
                                                <?= trans("like"); ?>&nbsp;(<span id="lbl_comment_like_count_<?= $comment->id; ?>"><?= $comment->like_count; ?></span>)</a>
                                        </div>
                                        <?php if (authCheck()):
                                            if ($comment->user_id == user()->id || user()->role == 'admin'): ?>
                                                <div class="item item-delete">
                                                    <a href="javascript:void(0)" class="btn-delete-comment" onclick="deleteComment('<?= $comment->id; ?>','<?= $post->id; ?>','<?= clrQuotes(trans("confirm_comment")); ?>');">&nbsp;<i class="icon-trash"></i>&nbsp;<?= trans("delete"); ?></a>
                                                </div>
                                            <?php endif;
                                        endif; ?>
                                    </div>
                                </div>
                                <div id="sub_comment_form_<?= $comment->id; ?>" class="row-custom row-sub-comment visible-sub-comment"></div>
                                <div class="row-custom row-sub-comment">
                                    <?= view('common/_subcomments', ['parentComment' => $comment]); ?>
                                </div>
                            </div>
                        </li>
                    <?php endforeach;
                endif; ?>
            </ul>
        </div>
    </div>
    <?php if ($commentCount > $commentLimit):
        if ($activeTheme->theme != 'classic'): ?>
            <div class="row-custom">
                <div class="d-flex justify-content-center mt-5">
                    <button class="btn btn-custom btn-lg btn-load-more" onclick="loadMoreComments('<?= $post->id; ?>');">
                        <?= trans("load_more_comments"); ?>
                        <svg width="16" height="16" viewBox="0 0 1792 1792" fill="#ffffff" class="m-l-5" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1664 256v448q0 26-19 45t-45 19h-448q-42 0-59-40-17-39 14-69l138-138q-148-137-349-137-104 0-198.5 40.5t-163.5 109.5-109.5 163.5-40.5 198.5 40.5 198.5 109.5 163.5 163.5 109.5 198.5 40.5q119 0 225-52t179-147q7-10 23-12 15 0 25 9l137 138q9 8 9.5 20.5t-7.5 22.5q-109 132-264 204.5t-327 72.5q-156 0-298-61t-245-164-164-245-61-298 61-298 164-245 245-164 298-61q147 0 284.5 55.5t244.5 156.5l130-129q29-31 70-14 39 17 39 59z"/>
                        </svg>
                        <span class="spinner-border spinner-border-sm spinner-load-more m-l-5" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        <?php else: ?>
            <div id="load_comment_spinner" class="col-sm-12 load-more-spinner">
                <div class="row">
                    <div class="spinner">
                        <div class="bounce1"></div>
                        <div class="bounce2"></div>
                        <div class="bounce3"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <button type="button" class="btn-load-more" onclick="loadMoreComments('<?= $post->id; ?>');">
                    <?= trans("load_more_comments"); ?>
                </button>
            </div>
        <?php endif;
    endif; ?>
</div>