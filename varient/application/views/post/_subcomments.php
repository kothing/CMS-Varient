<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $subcomments = get_subcomments($parent_comment->id); ?>
<?php if (!empty($subcomments)): ?>
    <div class="col-12">
        <div class="comments">
            <ul class="comment-list">
                <?php foreach ($subcomments as $subcomment): ?>
                    <li>
                        <div class="left">
                            <img src="<?php echo get_user_avatar_by_id($subcomment->user_id); ?>" alt="<?php echo html_escape($subcomment->name); ?>">
                        </div>
                        <div class="right">
                            <div class="row-custom">
                                <span class="username"><?php echo html_escape($subcomment->name); ?></span>
                            </div>
                            <div class="row-custom comment">
                                <?php echo html_escape($subcomment->comment); ?>
                            </div>
                            <div class="row-custom">
                                <div class="comment-meta">
                                    <span class="date"><?php echo time_ago($subcomment->created_at); ?></span>
                                    <a href="javascript:void(0)" class="icon-like btn-comment-like" onclick="like_comment('<?php echo $subcomment->id; ?>');"></a>
                                    <strong id="lbl_comment_like_count_<?php echo $subcomment->id; ?>" class="comment-like-count"><?php echo $subcomment->like_count; ?></strong>
                                    <a href="javascript:void(0)" class="icon-dislike btn-comment-dislike" onclick="dislike_comment('<?php echo $subcomment->id; ?>');"></a>
                                    <?php if ($this->auth_check):
                                        if ($subcomment->user_id == $this->auth_user->id || $this->auth_user->role == "admin"): ?>
                                            <a href="javascript:void(0)" class="btn-delete-comment" onclick="delete_comment('<?php echo $subcomment->id; ?>','<?php echo $post->id; ?>','<?php echo trans("message_comment_delete"); ?>');">&nbsp;<i class="icon-trash"></i>&nbsp;<?php echo trans("btn_delete"); ?></a>
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
<?php endif; ?>
