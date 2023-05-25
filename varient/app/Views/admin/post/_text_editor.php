<label class="control-label control-label-content"><?= trans('content'); ?></label>
<div id="main_editor">
    <div class="row">
        <div class="col-sm-12 editor-buttons">
            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#file_manager_image" data-image-type="editor"><i class="fa fa-image"></i>&nbsp;&nbsp;&nbsp;<?= trans("add_image"); ?></button>
        </div>
    </div>
    <?php if (!empty($post)): ?>
        <textarea class="tinyMCE form-control" name="content"><?= $post->content; ?></textarea>
    <?php else: ?>
        <textarea class="tinyMCE form-control" name="content"><?= old('content'); ?></textarea>
    <?php endif; ?>
</div>