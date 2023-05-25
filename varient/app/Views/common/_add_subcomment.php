<?php if (authCheck()): ?>
    <div class="sub-comment-form-registered">
        <div class="row">
            <div class="col-sm-12">
                <form id="add_subcomment_registered_<?= $parentComment->post_id; ?>">
                    <div class="form-group">
                        <textarea name="comment" class="form-control form-input form-textarea form-comment-text" maxlength="4999" placeholder="<?= trans("comment"); ?>"></textarea>
                    </div>
                    <input type="hidden" name="parent_id" value="<?= $parentComment->id; ?>">
                    <input type="hidden" name="post_id" value="<?= $parentComment->post_id; ?>">
                    <input type="hidden" name="limit" value="<?= $commentLimit; ?>">
                    <button type="button" class="btn btn-sm btn-custom btn-subcomment-registered" data-comment-id="<?= $parentComment->post_id; ?>"><?= trans("post_comment"); ?></button>
                </form>
                <div id="message-subcomment-result-<?= $parentComment->post_id; ?>"></div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="sub-comment-form">
        <div class="row">
            <div class="col-sm-12">
                <form id="add_subcomment_<?= $parentComment->post_id; ?>">
                    <div class="form-row">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label><?= trans("name"); ?></label>
                                <input type="text" name="name" class="form-control form-input form-comment-name" maxlength="40" placeholder="<?= trans("name"); ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label><?= trans("email"); ?></label>
                                <input type="email" name="email" class="form-control form-input form-comment-email" maxlength="100" placeholder="<?= trans("email"); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label><?= trans("comment"); ?></label>
                        <textarea name="comment" class="form-control form-input form-textarea form-comment-text" maxlength="4999" placeholder="<?= trans("comment"); ?>"></textarea>
                    </div>
                    <div class="form-group">
                        <?php reCaptcha('generate', $generalSettings); ?>
                    </div>
                    <input type="hidden" name="limit" value="<?= $commentLimit; ?>">
                    <input type="hidden" name="parent_id" value="<?= $parentComment->id; ?>">
                    <input type="hidden" name="post_id" value="<?= $parentComment->post_id; ?>">
                    <button type="button" class="btn btn-sm btn-custom btn-subcomment" data-comment-id="<?= $parentComment->post_id; ?>"><?= trans("post_comment"); ?></button>
                </form>
                <div id="message-subcomment-result-<?= $parentComment->post_id; ?>"></div>
            </div>
        </div>
    </div>
<?php endif; ?>