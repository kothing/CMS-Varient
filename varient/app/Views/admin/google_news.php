<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-7 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans('google_news'); ?></h3>
            </div>
            <form action="<?= base_url('AdminController/googleNewsPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-5 col-xs-12">
                                <label><?= trans('status'); ?></label>
                            </div>
                            <div class="col-md-3 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="google_news" value="1" id="google_news_1" class="square-purple" <?= $generalSettings->google_news == 1 ? 'checked' : ''; ?>>
                                <label for="google_news_1" class="option-label"><?= trans('enable'); ?></label>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="google_news" value="0" id="google_news_2" class="square-purple" <?= $generalSettings->google_news != 1 ? 'checked' : ''; ?>>
                                <label for="google_news_2" class="option-label"><?= trans('disable'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer" style="padding-left: 0; padding-right: 0;">
                        <button type="submit" name="action" value="save" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans('generate_feed_url'); ?></h3>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label><?= trans("language"); ?></label>
                    <select name="lang_id" class="form-control" onchange="getParentCategoriesByLang(this.value);">
                        <option value=""><?= trans('all'); ?></option>
                        <?php foreach ($activeLanguages as $language): ?>
                            <option value="<?= $language->id; ?>"><?= $language->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label"><?= trans('category'); ?></label>
                    <select id="categories" name="category_id" class="form-control" autocomplete="off" onchange="getSubCategories(this.value);" required>
                        <option value=""><?= trans('all'); ?></option>
                        <?php if (!empty($categories)):
                            foreach ($categories as $item): ?>
                                <option value="<?= $item->id; ?>" <?= $item->id == $parentCategoryId ? 'selected' : ''; ?>><?= esc($item->name); ?></option>
                            <?php endforeach;
                        endif; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label"><?= trans('subcategory'); ?></label>
                    <select id="subcategories" name="subcategory_id" class="form-control" autocomplete="off">
                        <option value=""><?= trans('all'); ?></option>
                        <?php if (!empty($subCategories)):
                            foreach ($subCategories as $item): ?>
                                <option value="<?= esc($item->id); ?>" <?= $item->id == $subCategoryId ? 'selected' : ''; ?>><?= esc($item->name); ?></option>
                            <?php endforeach;
                        endif; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label><?= trans("author"); ?></label>
                    <select name="author" class="form-control">
                        <option value=""><?= trans('all'); ?></option>
                        <?php if (!empty($users)):
                            foreach ($users as $user): ?>
                                <option value="<?= $user->id; ?>"><?= $user->username; ?>&nbsp;(<?= $user->role; ?>)</option>
                            <?php endforeach;
                        endif; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label><?= trans('limit'); ?></label>
                    <input type="number" class="form-control" name="limit" placeholder="<?= trans('limit'); ?>" value="1000">
                </div>
                <div class="form-group">
                    <textarea id="urlTextarea" class="form-control" style="display: none"></textarea>
                </div>
                <div class="box-footer" style="padding-left: 0; padding-right: 0;">
                    <button type="submit" name="action" value="save" id="btnGenerateFeedUrl" class="btn btn-primary pull-right"><?= trans('generate_feed_url'); ?></button>
                </div>
            </div>
        </div>

        <div class="alert alert-success alert-large">
            <strong><?= trans("warning"); ?>!</strong>&nbsp;&nbsp;<?= trans("google_news_cache_exp"); ?>
        </div>

        <div class="alert alert-danger alert-large">
            <strong><?= trans("warning"); ?>!</strong>&nbsp;&nbsp;<?= trans("google_news_exp"); ?>
        </div>

    </div>
</div>

<script>
    $(document).on('click', '#btnGenerateFeedUrl', function () {
        var langId = $('select[name="lang_id"]').val();
        var categoryId = $('select[name="category_id"]').val();
        var subCategoryId = $('select[name="subcategory_id"]').val();
        var author = $('select[name="author"]').val();
        var limit = $('input[name="limit"]').val();
        var url = VrConfig.baseURL + '/gnews/feed';
        var numParams = 0;
        if (langId) {
            url += '?lang=' + langId;
            numParams += 1;
        }
        if (categoryId) {
            if (subCategoryId) {
                categoryId = subCategoryId;
            }
            url += (numParams == 0 ? '?' : '&') + 'category=' + categoryId;
            numParams += 1;
        }
        if (author) {
            url += (numParams == 0 ? '?' : '&') + 'author=' + author;
            numParams += 1;
        }
        if (limit) {
            url += (numParams == 0 ? '?' : '&') + 'limit=' + limit;
        }
        $('#urlTextarea').val(url);
        $('#urlTextarea').show();
    });
</script>