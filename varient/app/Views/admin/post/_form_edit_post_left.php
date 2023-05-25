<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= trans('post_details'); ?></h3>
        </div>
    </div>
    <div class="box-body">
        <input type="hidden" name="id" value="<?= esc($post->id); ?>">
        <input type="hidden" name="back_url" class="form-control" value="<?= esc(inputGet('back_url')); ?>">

        <div class="form-group">
            <label class="control-label"><?= trans('title'); ?></label>
            <input type="text" class="form-control" name="title" placeholder="<?= trans('title'); ?>" value="<?= esc($post->title); ?>" required>
        </div>

        <div class="form-group">
            <label class="control-label"><?= trans('slug'); ?>
                <small>(<?= trans('slug_exp'); ?>)</small>
            </label>
            <input type="text" class="form-control" name="title_slug" placeholder="<?= trans('slug'); ?>" value="<?= esc($post->title_slug); ?>">
        </div>

        <div class="form-group">
            <label class="control-label"><?= trans('summary'); ?> & <?= trans("description"); ?> (<?= trans('meta_tag'); ?>)</label>
            <textarea class="form-control text-area" name="summary" placeholder="<?= trans('summary'); ?> & <?= trans("description"); ?> (<?= trans('meta_tag'); ?>)"><?= esc($post->summary); ?></textarea>
        </div>

        <div class="form-group">
            <label class="control-label"><?= trans('keywords'); ?> (<?= trans('meta_tag'); ?>)</label>
            <input type="text" class="form-control" name="keywords" placeholder="<?= trans('keywords'); ?> (<?= trans('meta_tag'); ?>)" value="<?= esc($post->keywords); ?>">
        </div>

        <?php if (checkUserPermission('manage_all_posts')): ?>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-4 col-xs-12 col-lang">
                        <label><?= trans('visibility'); ?></label>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                        <input type="radio" id="rb_visibility_1" name="visibility" value="1" class="square-purple" <?= $post->visibility == 1 ? 'checked' : ''; ?>>&nbsp;&nbsp;
                        <label for="rb_visibility_1" class="cursor-pointer"><?= trans('show'); ?></label>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-12 col-lang">
                        <input type="radio" id="rb_visibility_2" name="visibility" value="0" class="square-purple" <?= $post->visibility == 0 ? 'checked' : ''; ?>>&nbsp;&nbsp;
                        <label for="rb_visibility_2" class="cursor-pointer"><?= trans('hide'); ?></label>
                    </div>
                </div>
            </div>
        <?php else:
            if ($generalSettings->approve_updated_user_posts == 1): ?>
                <input type="hidden" name="visibility" value="0">
            <?php else: ?>
                <input type="hidden" name="visibility" value="1">
            <?php endif;
        endif; ?>

        <?php if ($activeTheme->theme == 'classic'): ?>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-4 col-xs-12">
                        <label><?= trans('show_right_column'); ?></label>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                        <input type="radio" name="show_right_column" value="1" id="right_column_enabled" class="square-purple" <?= $post->show_right_column == 1 ? 'checked' : ''; ?>>
                        <label for="right_column_enabled" class="option-label"><?= trans('yes'); ?></label>
                    </div>
                    <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                        <input type="radio" name="show_right_column" value="0" id="right_column_disabled" class="square-purple" <?= $post->show_right_column == 0 ? 'checked' : ''; ?>>
                        <label for="right_column_disabled" class="option-label"><?= trans('no'); ?></label>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <input type="hidden" name="show_right_column" value="<?= $post->show_right_column; ?>">
        <?php endif; ?>

        <?php if (checkUserPermission('manage_all_posts')): ?>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <label class="control-label"><?= trans('add_featured'); ?></label>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <input type="checkbox" name="is_featured" value="1" class="square-purple" <?= $post->is_featured == 1 ? 'checked' : ''; ?>>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <input type="hidden" name="is_featured" value="<?= $post->is_featured; ?>">
        <?php endif;
        if (checkUserPermission('manage_all_posts')): ?>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <label class="control-label"><?= trans('add_breaking'); ?></label>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <input type="checkbox" name="is_breaking" value="1" class="square-purple" <?= $post->is_breaking == 1 ? 'checked' : ''; ?>>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <input type="hidden" name="is_breaking" value="<?= $post->is_breaking; ?>">
        <?php endif;
        if (checkUserPermission('manage_all_posts')): ?>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <label class="control-label"><?= trans('add_slider'); ?></label>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <input type="checkbox" name="is_slider" value="1" class="square-purple" <?= $post->is_slider == 1 ? 'checked' : ''; ?>>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <input type="hidden" name="is_slider" value="<?= $post->is_slider; ?>">
        <?php endif;
        if (checkUserPermission('manage_all_posts')): ?>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <label class="control-label"><?= trans('add_recommended'); ?></label>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <input type="checkbox" name="is_recommended" value="1" class="square-purple" <?= $post->is_recommended == 1 ? 'checked' : ''; ?>>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <input type="hidden" name="is_recommended" value="<?= $post->is_recommended; ?>">
        <?php endif; ?>

        <div class="form-group">
            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <label class="control-label"><?= trans('show_only_registered'); ?></label>
                </div>
                <div class="col-md-8 col-sm-12">
                    <input type="checkbox" name="need_auth" value="1" class="square-purple" <?= $post->need_auth == 1 ? 'checked' : ''; ?>>
                </div>
            </div>
        </div>

        <?php if ($post->post_type == 'sorted_list' || $post->post_type == 'gallery'): ?>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <label class="control-label"><?= trans('show_item_numbers'); ?></label>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <input type="checkbox" name="show_item_numbers" value="1" class="square-purple" <?= $post->show_item_numbers == 1 ? 'checked' : ''; ?>>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="form-group">
            <label class="control-label"><?= trans('tags'); ?></label>
            <input id="tags_1" type="text" name="tags" class="form-control tags" value="<?= esc($tags); ?>"/>
            <small>(<?= trans('type_tag'); ?>)</small>
        </div>

        <div class="form-group row-optional-url">
            <label class="control-label"><?= trans('optional_url'); ?></label>
            <input type="text" class="form-control" name="optional_url" placeholder="<?= trans('optional_url'); ?>" value="<?= esc($post->optional_url); ?>">
        </div>
    </div>
</div>

<script>
    var postType = "<?= $post->post_type; ?>";
    var textSelectResult = "<?= trans("select_a_result"); ?>";
</script>