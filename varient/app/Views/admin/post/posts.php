<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= $title; ?></h3>
        </div>
        <div class="right">
            <a href="<?= adminUrl('post-format'); ?>" class="btn btn-success btn-add-new pull-right">
                <i class="fa fa-plus"></i>
                <?= trans('add_post'); ?>
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" role="grid">
                        <?= view('admin/post/_filter_posts'); ?>
                        <thead>
                        <tr role="row">
                            <?php if (checkUserPermission('manage_all_posts')): ?>
                                <th width="20"><input type="checkbox" class="checkbox-table" id="checkAll"></th>
                            <?php endif; ?>
                            <th width="20"><?= trans('id'); ?></th>
                            <th><?= trans('post'); ?></th>
                            <th><?= trans('language'); ?></th>
                            <th><?= trans('post_type'); ?></th>
                            <th><?= trans('category'); ?></th>
                            <th><?= trans('author'); ?></th>
                            <?php if ($listType == 'slider_posts'): ?>
                                <th><?= trans('slider_order'); ?></th>
                            <?php endif;
                            if ($listType == 'featured_posts'): ?>
                                <th><?= trans('featured_order'); ?></th>
                            <?php endif; ?>
                            <th><?= trans('pageviews'); ?></th>
                            <th><?= trans('date_added'); ?></th>
                            <th><?= trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($posts)):
                            foreach ($posts as $item):
                                $language = getLanguage($item->lang_id); ?>
                                <tr>
                                    <?php if (checkUserPermission('manage_all_posts')): ?>
                                        <td><input type="checkbox" name="checkbox-table" class="checkbox-table" value="<?= $item->id; ?>"></td>
                                    <?php endif; ?>
                                    <td><?= esc($item->id); ?></td>
                                    <td>
                                        <div class="td-post-item">
                                            <div class="post-image">
                                                <a href="<?= generatePostURL($item, generateBaseURLByLang($language)); ?>" target="_blank">
                                                    <div class="image">
                                                        <img src="<?= IMG_BASE64_1x1; ?>" data-src="<?= getPostImage($item, "small"); ?>" alt="" class="lazyload img-responsive"/>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="post-title">
                                                <a href="<?= generatePostURL($item, generateBaseURLByLang($language)); ?>" target="_blank">
                                                    <?= esc($item->title); ?>
                                                </a>
                                                <div class="preview">
                                                    <?php if ($item->is_slider): ?>
                                                        <label class="label bg-red label-table"><?= trans('slider'); ?></label>
                                                    <?php endif;
                                                    if ($item->is_featured): ?>
                                                        <label class="label bg-olive label-table"><?= trans('featured'); ?></label>
                                                    <?php endif;
                                                    if ($item->is_recommended): ?>
                                                        <label class="label bg-aqua label-table"><?= trans('recommended'); ?></label>
                                                    <?php endif;
                                                    if ($item->is_breaking): ?>
                                                        <label class="label bg-teal label-table"><?= trans('breaking'); ?></label>
                                                    <?php endif;
                                                    if ($item->need_auth): ?>
                                                        <label class="label label-warning label-table"><?= trans('only_registered'); ?></label>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td> <?= !empty($language) ? esc($language->name) : ''; ?></td>
                                    <td class="td-post-type"><?= trans($item->post_type); ?></td>
                                    <td>
                                        <?php $categories = getParentCategoryTree($item->category_id, $baseCategories);
                                        if (!empty($categories)):
                                            foreach ($categories as $category):
                                                if (!empty($category)): ?>
                                                    <label class="category-label m-r-5 label-table" style="background-color: <?= esc($category->color); ?>!important;">
                                                        <?= esc($category->name); ?>
                                                    </label>
                                                <?php endif;
                                            endforeach;
                                        endif; ?>
                                    </td>
                                    <td>
                                        <?php $author = getUserById($item->user_id);
                                        if (!empty($author)): ?>
                                            <a href="<?= generateProfileURL($author->slug); ?>" target="_blank" class="table-user-link">
                                                <strong><?= esc($author->username); ?></strong>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    <?php if ($listType == "slider_posts"): ?>
                                        <td style="max-width: 150px;">
                                            <input type="number" class="form-control input-slider-post-order" data-id="<?= $item->id; ?>" value="<?= esc($item->slider_order); ?>">
                                        </td>
                                    <?php endif;
                                    if ($listType == "featured_posts"): ?>
                                        <td style="max-width: 150px;">
                                            <input type="number" class="form-control input-featured-post-order" data-id="<?= $item->id; ?>" value="<?= esc($item->featured_order); ?>">
                                        </td>
                                    <?php endif; ?>
                                    <td><?= $item->pageviews; ?></td>
                                    <td><?= $item->created_at; ?></td>
                                    <td style="width: 180px;">
                                        <form action="<?= base_url('PostController/postOptionsPost'); ?>" method="post">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" name="id" value="<?= $item->id; ?>">
                                            <input type="hidden" name="back_url" value="<?= currentFullURL(); ?>">
                                            <div class="dropdown">
                                                <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_an_option'); ?>
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu options-dropdown">
                                                    <li>
                                                        <a href="<?= adminUrl('edit-post/' . $item->id); ?>"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a>
                                                    </li>
                                                    <?php if (checkUserPermission('manage_all_posts')):
                                                        if ($item->is_slider == 1): ?>
                                                            <li>
                                                                <button type="submit" name="option" value="add_remove_slider" class="btn-list-button">
                                                                    <i class="fa fa-times option-icon"></i><?= trans('remove_slider'); ?>
                                                                </button>
                                                            </li>
                                                        <?php else: ?>
                                                            <li>
                                                                <button type="submit" name="option" value="add_remove_slider" class="btn-list-button">
                                                                    <i class="fa fa-plus option-icon"></i><?= trans('add_slider'); ?>
                                                                </button>
                                                            </li>
                                                        <?php endif;
                                                        if ($item->is_featured == 1): ?>
                                                            <li>
                                                                <button type="submit" name="option" value="add_remove_featured" class="btn-list-button">
                                                                    <i class="fa fa-times option-icon"></i><?= trans('remove_featured'); ?>
                                                                </button>
                                                            </li>
                                                        <?php else: ?>
                                                            <li>
                                                                <button type="submit" name="option" value="add_remove_featured" class="btn-list-button">
                                                                    <i class="fa fa-plus option-icon"></i><?= trans('add_featured'); ?>
                                                                </button>
                                                            </li>
                                                        <?php endif;
                                                        if ($item->is_breaking == 1): ?>
                                                            <li>
                                                                <button type="submit" name="option" value="add_remove_breaking" class="btn-list-button">
                                                                    <i class="fa fa-times option-icon"></i><?= trans('remove_breaking'); ?>
                                                                </button>
                                                            </li>
                                                        <?php else: ?>
                                                            <li>
                                                                <button type="submit" name="option" value="add_remove_breaking" class="btn-list-button">
                                                                    <i class="fa fa-plus option-icon"></i><?= trans('add_breaking'); ?>
                                                                </button>
                                                            </li>
                                                        <?php endif;
                                                        if ($item->is_recommended == 1): ?>
                                                            <li>
                                                                <button type="submit" name="option" value="add_remove_recommended" class="btn-list-button">
                                                                    <i class="fa fa-times option-icon"></i><?= trans('remove_recommended'); ?>
                                                                </button>
                                                            </li>
                                                        <?php else: ?>
                                                            <li>
                                                                <button type="submit" name="option" value="add_remove_recommended" class="btn-list-button">
                                                                    <i class="fa fa-plus option-icon"></i><?= trans('add_recommended'); ?>
                                                                </button>
                                                            </li>
                                                        <?php endif;
                                                    endif; ?>
                                                    <li>
                                                        <a href="javascript:void(0)" onclick="deleteItem('PostController/deletePost','<?= $item->id; ?>','<?= clrQuotes(trans("confirm_post")); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach;
                        endif; ?>
                        </tbody>
                    </table>
                    <?php if (empty($posts)): ?>
                        <p class="text-center"><?= trans("no_records_found"); ?></p>
                    <?php endif; ?>
                    <div class="col-sm-12 table-ft">
                        <div class="row">
                            <div class="pull-right">
                                <?= view('common/_pagination'); ?>
                            </div>
                            <?php if (!empty($posts) && countItems($posts) > 0): ?>
                                <div class="pull-left bulk-options">
                                    <button class="btn btn-sm btn-danger btn-table-delete" onclick="deleteSelectePosts('<?= clrQuotes(trans("confirm_posts")); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></button>
                                    <?php if ($listType != 'slider_posts'): ?>
                                        <button class="btn btn-sm btn-default btn-table-delete" onclick="postBulkOptions('add_slider');"><i class="fa fa-plus option-icon"></i><?= trans('add_slider'); ?></button>
                                    <?php endif;
                                    if ($listType != 'featured_posts'): ?>
                                        <button class="btn btn-sm btn-default btn-table-delete" onclick="postBulkOptions('add_featured');"><i class="fa fa-plus option-icon"></i><?= trans('add_featured'); ?></button>
                                    <?php endif;
                                    if ($listType != 'breaking_news'): ?>
                                        <button class="btn btn-sm btn-default btn-table-delete" onclick="postBulkOptions('add_breaking');"><i class="fa fa-plus option-icon"></i><?= trans('add_breaking'); ?></button>
                                    <?php endif;
                                    if ($listType != 'recommended_posts'): ?>
                                        <button class="btn btn-sm btn-default btn-table-delete" onclick="postBulkOptions('add_recommended');"><i class="fa fa-plus option-icon"></i><?= trans('add_recommended'); ?></button>
                                    <?php endif; ?>
                                    <button class="btn btn-sm btn-default btn-table-delete" onclick="postBulkOptions('remove_slider');"><i class="fa fa-minus option-icon"></i><?= trans('remove_slider'); ?></button>
                                    <button class="btn btn-sm btn-default btn-table-delete" onclick="postBulkOptions('remove_featured');"><i class="fa fa-minus option-icon"></i><?= trans('remove_featured'); ?></button>
                                    <button class="btn btn-sm btn-default btn-table-delete" onclick="postBulkOptions('remove_breaking');"><i class="fa fa-minus option-icon"></i><?= trans('remove_breaking'); ?></button>
                                    <button class="btn btn-sm btn-default btn-table-delete" onclick="postBulkOptions('remove_recommended');"><i class="fa fa-minus option-icon"></i><?= trans('remove_recommended'); ?></button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>