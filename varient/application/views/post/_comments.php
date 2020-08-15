<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<input type="hidden" value="<?php echo $comment_limit; ?>" id="post_comment_limit">
<div class="row">
    <div class="col-sm-12">
        <div class="comments">
            <?php if ($comment_count > 0): ?>
                <div class="row-custom comment-total">
                    <label class="label-comment"><?php echo trans("comments"); ?> (<?php echo $comment_count; ?>)</label>
                </div>
            <?php endif; ?>
            <ul class="comment-list">
                <?php
                if (!empty($comments)):
                    foreach ($comments as $comment):?>
                        <li>
                            <div class="left">
                                <img src="<?php echo get_user_avatar_by_id($comment->user_id); ?>" alt="<?php echo html_escape($comment->name); ?>">
                            </div>
                            <div class="right">
                                <div class="row-custom">
                                    <span class="username"><?php echo html_escape($comment->name); ?></span>
                                </div>
                                <div class="row-custom comment">
                                    <?php echo html_escape($comment->comment); ?>
                                </div>
                                <div class="row-custom">
                                    <div class="comment-meta">
                                        <span class="date"><?php echo time_ago($comment->created_at); ?></span>
                                        <a href="javascript:void(0)" class="btn-reply" onclick="show_comment_box('<?php echo $comment->id; ?>');"><i class="icon-reply"></i><?php echo trans('btn_reply'); ?></a>
                                        <a href="javascript:void(0)" class="icon-like btn-comment-like" onclick="like_comment('<?php echo $comment->id; ?>');"></a>
                                        <strong id="lbl_comment_like_count_<?php echo $comment->id; ?>" class="comment-like-count"><?php echo $comment->like_count; ?></strong>
                                        <a href="javascript:void(0)" class="icon-dislike btn-comment-dislike" onclick="dislike_comment('<?php echo $comment->id; ?>');"></a>
                                        <?php if ($this->auth_check):

                                            if ($comment->user_id == $this->auth_user->id || $this->auth_user->role == "admin"): ?>
                                                <a href="javascript:void(0)" class="btn-delete-comment" onclick="delete_comment('<?php echo $comment->id; ?>','<?php echo $post->id; ?>','<?php echo trans("message_comment_delete"); ?>');">&nbsp;<i class="icon-trash"></i>&nbsp;<?php echo trans("btn_delete"); ?></a>
                                            <?php endif;
                                        endif; ?>
                                    </div>
                                </div>


                                <div id="sub_comment_form_<?php echo $comment->id; ?>" class="row-custom row-sub-comment visible-sub-comment"></div>
                                <div class="row-custom row-sub-comment">
                                    <!-- include subcomments -->
                                    <?php $this->load->view('post/_subcomments', ['parent_comment' => $comment]); ?>
                                </div>

                            </div>
                        </li>
                    <?php endforeach;
                endif; ?>
            </ul>
        </div>
    </div>

    <?php if ($comment_count > $comment_limit): ?>
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
            <button type="button" class="btn-load-more" onclick="load_more_comment('<?php echo $post->id; ?>');">
                <?php echo trans("load_more_comments"); ?>
            </button>
        </div>
    <?php endif; ?>
</div>
