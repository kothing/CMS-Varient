<div class="row">
    <div class="col-sm-12">
        <label class="control-label control-label-content"><?= esc($title); ?></label>
        <div id="list_items_container" class="panel-group post-list-items post-list-items-sort">
            <input type="hidden" name="content" value="">
            <?php if (!empty($postListItems)):
                $count = 1;
                foreach ($postListItems as $postListItem):
                    echo view("admin/post/_post_list_item", ['postListItem' => $postListItem, 'itemNumber' => $count]);
                    $count++;
                endforeach;
            else:
                echo view("admin/post/_post_list_item");
            endif; ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 text-center">
        <?php if (!empty($post)): ?>
            <button type="button" id="btn_add_post_list_item_database" data-post-id="<?= $post->id; ?>" class="btn btn-md btn-success btn-add-post-item"><i class="fa fa-plus"></i><?= trans("add_new_item"); ?></button>
        <?php else: ?>
            <button type="button" id="btn_append_post_list_item" class="btn btn-md btn-success btn-add-post-item"><i class="fa fa-plus"></i><?= trans("add_new_item"); ?></button>
        <?php endif; ?>
    </div>
</div>