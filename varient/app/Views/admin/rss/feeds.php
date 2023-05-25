<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= trans('rss_feeds'); ?></h3>
        </div>
        <div class="right">
            <a href="<?= adminUrl('import-feed'); ?>" class="btn btn-success btn-add-new">
                <i class="fa fa-plus"></i>
                <?= trans('import_rss_feed'); ?>
            </a>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" role="grid">
                        <div class="row table-filter-container">
                            <div class="col-sm-12">
                                <form action="<?= adminUrl('feeds'); ?>" method="get">
                                    <div class="item-table-filter" style="width: 80px; min-width: 80px;">
                                        <label><?= trans("show"); ?></label>
                                        <select name="show" class="form-control">
                                            <option value="15" <?= inputGet('show', true) == '15' ? 'selected' : ''; ?>>15</option>
                                            <option value="30" <?= inputGet('show', true) == '30' ? 'selected' : ''; ?>>30</option>
                                            <option value="60" <?= inputGet('show', true) == '60' ? 'selected' : ''; ?>>60</option>
                                            <option value="100" <?= inputGet('show', true) == '100' ? 'selected' : ''; ?>>100</option>
                                        </select>
                                    </div>
                                    <div class="item-table-filter">
                                        <label><?= trans("language"); ?></label>
                                        <select name="lang_id" class="form-control" onchange="getParentCategoriesByLang(this.value);">
                                            <option value=""><?= trans("all"); ?></option>
                                            <?php foreach ($activeLanguages as $language): ?>
                                                <option value="<?= $language->id; ?>" <?= inputGet('lang_id') == $language->id ? 'selected' : ''; ?>><?= esc($language->name); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="item-table-filter">
                                        <label><?= trans("search"); ?></label>
                                        <input name="q" class="form-control" placeholder="<?= trans("search") ?>" type="search" value="<?= esc(inputGet('q', true)); ?>">
                                    </div>
                                    <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
                                        <label style="display: block">&nbsp;</label>
                                        <button type="submit" class="btn bg-purple"><?= trans("filter"); ?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <thead>
                        <tr role="row">
                            <th width="20"><?= trans('id'); ?></th>
                            <th><?= trans('feed_name'); ?></th>
                            <th><?= trans('feed_url'); ?></th>
                            <th><?= trans('language'); ?></th>
                            <th><?= trans('category'); ?></th>
                            <th><?= trans('posts'); ?></th>
                            <th><?= trans('author'); ?></th>
                            <th><?= trans('auto_update'); ?></th>
                            <th></th>
                            <th><?= trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($feeds)):
                            foreach ($feeds as $item):
                                $language = getLanguage($item->lang_id); ?>
                                <tr>
                                    <td><?= esc($item->id); ?></td>
                                    <td><?= esc($item->feed_name); ?></td>
                                    <td style="white-space: pre-wrap;word-break: break-all;"><?= esc($item->feed_url); ?></td>
                                    <td>
                                        <?php if (!empty($language)) {
                                            echo esc($language->name);
                                        } ?>
                                    </td>
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
                                    <td><?= $item->num_posts; ?></td>
                                    <td>
                                        <?php $author = getUserById($item->user_id);
                                        if (!empty($author)): ?>
                                            <a href="<?= generateProfileURL($author->slug); ?>" target="_blank" class="table-user-link">
                                                <strong><?= esc($author->username); ?></strong>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($item->auto_update == 1): ?>
                                            <label class="label bg-olive"><?= trans('yes'); ?></label>
                                        <?php else: ?>
                                            <label class="label label-default"><?= trans('no'); ?></label>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <form action="<?= base_url('RssController/checkFeedPosts'); ?>" method="post">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" name="id" value="<?= $item->id; ?>">
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fa fa-refresh "></i>&nbsp;&nbsp;<?= trans("update"); ?>
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_an_option'); ?>
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu options-dropdown">
                                                <li>
                                                    <a href="<?= adminUrl('edit-feed/' . $item->id); ?>"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" onclick="deleteItem('RssController/deleteFeedPost','<?= $item->id; ?>','<?= clrQuotes(trans("confirm_rss")); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach;
                        endif; ?>
                        </tbody>
                    </table>
                    <?php if (empty($feeds)): ?>
                        <p class="text-center"><?= trans("no_records_found"); ?></p>
                    <?php endif; ?>
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="pull-right">
                                <?= view('common/_pagination'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="alert alert-danger alert-large" style="max-width: 1000px;">
    <strong><?= trans("warning"); ?>!</strong>&nbsp;&nbsp;<?= trans("msg_rss_warning"); ?>
</div>