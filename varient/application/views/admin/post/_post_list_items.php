<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12">
        <label class="control-label control-label-content"><?php echo html_escape($title); ?></label>
        <div id="list_items_container" class="panel-group post-list-items post-list-items-sort">
            <input type="hidden" name="content" value="">
            <?php if (!empty($post_list_items)):
                $count = 1;
                foreach ($post_list_items as $post_list_item):
                    $this->load->view("admin/post/_post_list_item", ['post_list_item' => $post_list_item, 'item_number' => $count]);
                    $count++;
                endforeach;
            else:
                $this->load->view("admin/post/_post_list_item");
            endif; ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 text-center">
        <?php if (!empty($post)): ?>
            <button type="button" id="btn_add_post_list_item_database" data-post-id="<?php echo $post->id; ?>" class="btn btn-md btn-success btn-add-post-item"><i class="fa fa-plus"></i><?php echo trans("add_new_item"); ?></button>
        <?php else: ?>
            <button type="button" id="btn_append_post_list_item" class="btn btn-md btn-success btn-add-post-item"><i class="fa fa-plus"></i><?php echo trans("add_new_item"); ?></button>
        <?php endif; ?>
    </div>
</div>