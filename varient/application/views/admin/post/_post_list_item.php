<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php if (empty($new_item_order)):
    $new_item_order = 1;
endif; ?>
<?php if (!empty($post_list_item)): ?>
    <div id="panel_list_item_<?php echo $post_list_item->id; ?>" class="panel panel-default panel-list-item" data-list-item-id="<?php echo $post_list_item->id; ?>">
        <div class="panel-heading">
            <h4 class="panel-title" data-toggle="collapse" data-target="#collapse_<?php echo $post_list_item->id; ?>">
                #<span id="list_item_order_<?php echo $post_list_item->id; ?>"><?php echo $post_list_item->item_order; ?></span>&nbsp;&nbsp;<span id="list_item_title_<?php echo $post_list_item->id; ?>"><?php echo html_escape($post_list_item->title); ?></span>
            </h4>
            <div class="btn-group btn-group-post-list-option" role="group">
                <input type="number" name="list_item_order_<?php echo $post_list_item->id; ?>" class="input_list_item_order" data-list-item-id="<?php echo $post_list_item->id; ?>" value="<?php echo $post_list_item->item_order; ?>" placeholder="<?php echo trans("order_1"); ?>">
                <button type="button" class="btn btn-default" onclick="delete_post_list_item_database('<?php echo $post_list_item->id; ?>','<?php echo $post_list_item->item_post_type; ?>','<?php echo trans("confirm_item"); ?>');"><i class="fa fa-trash"></i></button>
            </div>
        </div>
        <div id="collapse_<?php echo $post_list_item->id; ?>" class="panel-collapse collapse <?php echo (empty($post_list_item->title)) ? 'in' : ''; ?>">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label"><?php echo trans("title"); ?></label>
                            <input type="text" class="form-control input-post-list-item-title" data-title-id="list_item_title_<?php echo $post_list_item->id; ?>" name="list_item_title_<?php echo $post_list_item->id ?>" placeholder="<?php echo trans("title"); ?>" value="<?php echo html_escape($post_list_item->title); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="list-item-description">
                            <div class="left">
                                <label class="control-label"><?php echo trans("image"); ?></label>
                                <div id="post_list_item_image_container_<?php echo $post_list_item->id; ?>" class="m-b-5">
                                    <div class="list-item-image-container">
                                        <?php if (!empty($post_list_item->image)): ?>
                                            <input type="hidden" name="list_item_image_<?php echo $post_list_item->id; ?>" value="<?php echo $post_list_item->image; ?>">
                                            <input type="hidden" name="list_item_image_large_<?php echo $post_list_item->id; ?>" value="<?php echo $post_list_item->image_large; ?>">
                                            <img src="<?php echo base_url() . $post_list_item->image; ?>" alt="">
                                            <a class="btn btn-danger btn-sm btn-delete-selected-file-image btn-delete-selected-list-item-image" data-image-type="list_item" data-list-item-id="<?php echo $post_list_item->id; ?>" data-is-update="1">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        <?php else: ?>
                                            <input type="hidden" name="list_item_image_<?php echo $post_list_item->id; ?>" value="<?php echo $post_list_item->image; ?>">
                                            <input type="hidden" name="list_item_image_large_<?php echo $post_list_item->id; ?>" value="<?php echo $post_list_item->image_large; ?>">
                                            <a class='btn-select-image' data-toggle="modal" data-target="#file_manager_image" data-image-type="list_item" data-list-item-id="<?php echo $post_list_item->id; ?>" data-is-update="1">
                                                <div class="btn-select-image-inner">
                                                    <i class="icon-images"></i>
                                                    <button class="btn"><?php echo trans("select_image"); ?></button>
                                                </div>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="list_item_image_description_<?php echo $post_list_item->id; ?>" value="<?php echo html_escape($post_list_item->image_description); ?>" placeholder="<?php echo trans("image_description"); ?>" maxlength="300" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                                </div>
                            </div>
                            <div class="right">
                                <label class="control-label"><?php echo trans("content"); ?></label>
                                <div class="row">
                                    <div class="col-sm-12 editor-buttons">
                                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#file_manager_image" data-image-type="list_item_editor" data-editor-id="<?php echo $post_list_item->id; ?>"><i class="fa fa-image"></i>&nbsp;&nbsp;&nbsp;<?php echo trans("add_image"); ?></button>
                                    </div>
                                </div>
                                <textarea id="editor_<?php echo $post_list_item->id; ?>" class="tinyMCEQuiz form-control" name="list_item_content_<?php echo $post_list_item->id; ?>"><?php echo $post_list_item->content; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <?php $unique_id = uniqid(); ?>
    <div id="panel_list_item_<?php echo $unique_id; ?>" class="panel panel-default panel-list-item" data-list-item-id="<?php echo $unique_id; ?>">
        <div class="panel-heading">
            <h4 class="panel-title" data-toggle="collapse" data-target="#collapse_<?php echo $unique_id; ?>">
                #<span id="list_item_order_<?php echo $unique_id; ?>"><?php echo $new_item_order; ?></span>&nbsp;&nbsp;<span id="list_item_title_<?php echo $unique_id; ?>"></span>
            </h4>
            <div class="btn-group btn-group-post-list-option" role="group">
                <input type="number" name="list_item_order[]" class="input_list_item_order" data-list-item-id="<?php echo $unique_id; ?>" value="<?php echo $new_item_order; ?>" placeholder="<?php echo trans("order_1"); ?>">
                <button type="button" class="btn btn-default" onclick="delete_post_list_item('<?php echo $unique_id; ?>','<?php echo trans("confirm_item"); ?>');"><i class="fa fa-trash"></i></button>
            </div>
        </div>
        <div id="collapse_<?php echo $unique_id; ?>" class="panel-collapse collapse in">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label"><?php echo trans("title"); ?></label>
                            <input type="text" class="form-control input-post-list-item-title" data-title-id="list_item_title_<?php echo $unique_id; ?>" name="list_item_title[]" placeholder="<?php echo trans("title"); ?>" value="" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="list-item-description">
                            <div class="left">
                                <label class="control-label"><?php echo trans("image"); ?></label>
                                <div id="post_list_item_image_container_<?php echo $unique_id; ?>" class="m-b-5">
                                    <div class="list-item-image-container">
                                        <input type="hidden" name="list_item_image[]" value="">
                                        <input type="hidden" name="list_item_image_large[]" value="">
                                        <a class='btn-select-image' data-toggle="modal" data-target="#file_manager_image" data-image-type="list_item" data-list-item-id="<?php echo $unique_id; ?>" data-is-update="0">
                                            <div class="btn-select-image-inner">
                                                <i class="icon-images"></i>
                                                <button class="btn"><?php echo trans("select_image"); ?></button>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="list_item_image_description[]" placeholder="<?php echo trans("image_description"); ?>" maxlength="300" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                                </div>
                            </div>
                            <div class="right">
                                <label class="control-label"><?php echo trans("content"); ?></label>
                                <div class="row">
                                    <div class="col-sm-12 editor-buttons">
                                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#file_manager_image" data-image-type="list_item_editor" data-editor-id="<?php echo $unique_id; ?>"><i class="fa fa-image"></i>&nbsp;&nbsp;&nbsp;<?php echo trans("add_image"); ?></button>
                                    </div>
                                </div>
                                <textarea id="editor_<?php echo $unique_id; ?>" class="tinyMCEQuiz form-control" name="list_item_content[]"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>


