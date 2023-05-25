<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-10">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans('import_rss_feed'); ?></h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl('feeds'); ?>" class="btn btn-success btn-add-new">
                        <i class="fa fa-bars"></i>
                        <?= trans('rss_feeds'); ?>
                    </a>
                </div>
            </div>
            <form action="<?= base_url('RssController/importFeedPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label><?= trans("feed_name"); ?></label>
                        <input type="text" class="form-control" name="feed_name" placeholder="<?= trans("feed_name"); ?>" value="<?= old('feed_name'); ?>" maxlength="400" required>
                    </div>

                    <div class="form-group">
                        <label><?= trans("feed_url"); ?></label>
                        <input type="text" class="form-control" name="feed_url" placeholder="<?= trans("feed_url"); ?>" value="<?= old('feed_url'); ?>" required>
                    </div>

                    <div class="form-group">
                        <label><?= trans("number_of_posts_import"); ?></label>
                        <input type="number" class="form-control max-500" name="post_limit" placeholder="<?= trans("number_of_posts_import"); ?>" value="<?= old('post_limit'); ?>" min="1" max="500" required>
                    </div>

                    <div class="form-group">
                        <label><?= trans("language"); ?></label>
                        <select name="lang_id" class="form-control max-500" onchange="getParentCategoriesByLang(this.value);">
                            <?php foreach ($activeLanguages as $language): ?>
                                <option value="<?= $language->id; ?>" <?= $activeLang->id == $language->id ? 'selected' : ''; ?>><?= esc($language->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('category'); ?></label>
                        <select id="categories" name="category_id" class="form-control max-500" onchange="getSubCategories(this.value);" required>
                            <option value=""><?= trans('select_category'); ?></option>
                            <?php if (!empty($parentCategories)):
                                foreach ($parentCategories as $item): ?>
                                    <option value="<?= esc($item->id); ?>" <?= $item->id == old('category_id') ? 'selected' : ''; ?>><?= esc($item->name); ?></option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label"><?= trans('subcategory'); ?></label>
                        <select id="subcategories" name="subcategory_id" class="form-control max-500">
                            <option value="0"><?= trans('select_category'); ?></option>
                        </select>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <label><?= trans('images'); ?></label>
                            </div>
                            <div class="col-sm-12 col-xs-12 col-option">
                                <input type="radio" name="image_saving_method" value="url" id="show_images_from_original_source" class="square-purple" checked>
                                <label for="show_images_from_original_source" class="option-label"><?= trans('show_images_from_original_source'); ?></label>
                            </div>
                            <div class="col-sm-12 col-xs-12 col-option">
                                <input type="radio" name="image_saving_method" value="download" id="download_images" class="square-purple">
                                <label for="download_images" class="option-label"><?= trans('download_images_my_server'); ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label><?= trans('auto_update'); ?></label>
                            </div>
                            <div class="col-md-5 col-sm-12 col-option">
                                <input type="radio" name="auto_update" value="1" id="auto_update_enabled" class="square-purple" checked>
                                <label for="auto_update_enabled" class="option-label"><?= trans('yes'); ?></label>
                            </div>
                            <div class="col-md-5 col-sm-12 col-option">
                                <input type="radio" name="auto_update" value="0" id="auto_update_disabled" class="square-purple">
                                <label for="auto_update_disabled" class="option-label"><?= trans('no'); ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label><?= trans('generate_keywords_from_title'); ?></label>
                            </div>
                            <div class="col-md-5 col-sm-12 col-option">
                                <input type="radio" name="generate_keywords_from_title" value="1" id="generate_keywords_from_title_1" class="square-purple" checked>
                                <label for="generate_keywords_from_title_1" class="option-label"><?= trans('yes'); ?></label>
                            </div>
                            <div class="col-md-5 col-sm-12 col-option">
                                <input type="radio" name="generate_keywords_from_title" value="0" id="generate_keywords_from_title_2" class="square-purple">
                                <label for="generate_keywords_from_title_2" class="option-label"><?= trans('no'); ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label><?= trans('show_read_more_button'); ?></label>
                            </div>
                            <div class="col-md-5 col-sm-12 col-option">
                                <input type="radio" name="read_more_button" value="1" id="read_more_button_enabled" class="square-purple" checked>
                                <label for="read_more_button_enabled" class="option-label"><?= trans('yes'); ?></label>
                            </div>
                            <div class="col-md-5 col-sm-12 col-option">
                                <input type="radio" name="read_more_button" value="0" id="read_more_button_disabled" class="square-purple">
                                <label for="read_more_button_disabled" class="option-label"><?= trans('no'); ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label><?= trans('add_posts_as_draft'); ?></label>
                            </div>
                            <div class="col-md-5 col-sm-12 col-option">
                                <input type="radio" name="add_posts_as_draft" value="1" id="add_posts_as_draft_1" class="square-purple">
                                <label for="add_posts_as_draft_1" class="option-label"><?= trans('yes'); ?></label>
                            </div>
                            <div class="col-md-5 col-sm-12 col-option">
                                <input type="radio" name="add_posts_as_draft" value="0" id="add_posts_as_draft_2" class="square-purple" checked>
                                <label for="add_posts_as_draft_2" class="option-label"><?= trans('no'); ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?= trans("read_more_button_text"); ?></label>
                        <input type="text" class="form-control max-500" name="read_more_button_text" placeholder="<?= trans("read_more_button_text"); ?>" value="Read More">
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('import_rss_feed'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>