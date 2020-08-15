<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<label class="control-label control-label-content"><?php echo trans('content'); ?></label>
<div id="main_editor">
    <div class="row">
        <div class="col-sm-12 editor-buttons">
            <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#file_manager_image" data-image-type="editor"><i class="fa fa-image"></i>&nbsp;&nbsp;&nbsp;<?php echo trans("add_image"); ?></button>
            <button type="button" class="btn btn-sm bg-purple btn_tinymce_add_media" data-editor-id="main_editor"><i class="fa fa-file"></i>&nbsp;&nbsp;&nbsp;<?php echo trans("add_media"); ?></button>
        </div>
    </div>
    <?php if (!empty($post)): ?>
        <textarea class="tinyMCE form-control" name="content"><?php echo $post->content; ?></textarea>
    <?php else: ?>
        <textarea class="tinyMCE form-control" name="content"><?php echo old('content'); ?></textarea>
    <?php endif; ?>
</div>