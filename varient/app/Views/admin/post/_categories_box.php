<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= trans('category'); ?></h3>
        </div>
    </div>
    <div class="box-body">
        <?php if (!empty($post)): ?>
            <div class="form-group">
                <label><?= trans("language"); ?></label>
                <select name="lang_id" class="form-control" onchange="getParentCategoriesByLang(this.value);">
                    <?php foreach ($activeLanguages as $language): ?>
                        <option value="<?= $language->id; ?>" <?= $post->lang_id == $language->id ? 'selected' : ''; ?>><?= $language->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label class="control-label"><?= trans('category'); ?></label>
                <select id="categories" name="category_id" class="form-control" autocomplete="off" onchange="getSubCategories(this.value);" required>
                    <option value=""><?= trans('select_category'); ?></option>
                    <?php if (!empty($categories)):
                        foreach ($categories as $item): ?>
                            <option value="<?= $item->id; ?>" <?= $item->id == $parentCategoryId ? 'selected' : ''; ?>><?= esc($item->name); ?></option>
                        <?php endforeach;
                    endif; ?>
                </select>
            </div>
            <div class="form-group m-0">
                <label class="control-label"><?= trans('subcategory'); ?></label>
                <select id="subcategories" name="subcategory_id" class="form-control" autocomplete="off">
                    <option value="0"><?= trans('select_category'); ?></option>
                    <?php if (!empty($subCategories)):
                        foreach ($subCategories as $item): ?>
                            <option value="<?= esc($item->id); ?>" <?= $item->id == $subCategoryId ? 'selected' : ''; ?>><?= esc($item->name); ?></option>
                        <?php endforeach;
                    endif; ?>
                </select>
            </div>
        <?php else: ?>
            <div class="form-group">
                <label><?= trans("language"); ?></label>
                <select name="lang_id" class="form-control" onchange="getParentCategoriesByLang(this.value);" autocomplete="off">
                    <?php foreach ($activeLanguages as $language): ?>
                        <option value="<?= $language->id; ?>" <?= $activeLang->id == $language->id ? 'selected' : ''; ?>><?= $language->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label class="control-label"><?= trans('category'); ?></label>
                <select id="categories" name="category_id" class="form-control" autocomplete="off" onchange="getSubCategories(this.value);" required>
                    <option value=""><?= trans('select_category'); ?></option>
                    <?php if (!empty($parentCategories)):
                        foreach ($parentCategories as $item):
                            if ($item->id == old('category_id')): ?>
                                <option value="<?= $item->id; ?>" selected><?= esc($item->name); ?></option>
                            <?php else: ?>
                                <option value="<?= $item->id; ?>"><?= esc($item->name); ?></option>
                            <?php endif;
                        endforeach;
                    endif; ?>
                </select>
            </div>
            <div class="form-group m-0">
                <label class="control-label"><?= trans('subcategory'); ?></label>
                <select id="subcategories" name="subcategory_id" class="form-control" autocomplete="off">
                    <option value="0"><?= trans('select_category'); ?></option>
                </select>
            </div>
        <?php endif; ?>
    </div>
</div>