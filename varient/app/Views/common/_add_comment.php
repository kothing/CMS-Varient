<?php if (authCheck()): ?>
    <form id="add_comment_registered">
        <input type="hidden" name="parent_id" value="0">
        <input type="hidden" name="post_id" value="<?= $post->id; ?>">
        <div class="form-group">
            <textarea name="comment" class="form-control form-input form-textarea" placeholder="<?= trans("leave_your_comment"); ?>"></textarea>
        </div>
        <button type="submit" class="btn btn-md btn-custom"><?= trans("post_comment"); ?></button>
    </form>
<?php else: ?>
    <form id="add_comment">
        <input type="hidden" name="parent_id" value="0">
        <input type="hidden" name="post_id" value="<?= $post->id; ?>">
        <div class="form-row">
            <div class="row">
                <div class="form-group col-md-6">
                    <label><?= trans("name"); ?></label>
                    <input type="text" name="name" class="form-control form-input" maxlength="40" placeholder="<?= trans("name"); ?>">
                </div>
                <div class="form-group col-md-6">
                    <label><?= trans("email"); ?></label>
                    <input type="email" name="email" class="form-control form-input" maxlength="100" placeholder="<?= trans("email"); ?>">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label><?= trans("comment"); ?></label>
            <textarea name="comment" class="form-control form-input form-textarea" maxlength="4999" placeholder="<?= trans("leave_your_comment"); ?>"></textarea>
        </div>
        <div class="form-group">
            <?php reCaptcha('generate', $generalSettings); ?>
        </div>
        <button type="submit" class="btn btn-md btn-custom"><?= trans("post_comment"); ?></button>
    </form>
<?php endif; ?>
<div id="message-comment-result" class="message-comment-result"></div>
