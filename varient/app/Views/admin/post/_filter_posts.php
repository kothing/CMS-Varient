<?php $categoryModel = new \App\Models\CategoryModel(); ?>
<div class="row table-filter-container">
    <div class="col-sm-12">
        <form action="<?= $formAction; ?>" method="get">
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
                <label><?= trans("post_type"); ?></label>
                <select name="post_type" class="form-control">
                    <option value=""><?= trans("all"); ?></option>
                    <option value="article" <?= inputGet('post_type', true) == 'article' ? 'selected' : ''; ?>><?= trans("article"); ?></option>
                    <option value="gallery" <?= inputGet('post_type', true) == 'gallery' ? 'selected' : ''; ?>><?= trans("gallery"); ?></option>
                    <option value="sorted_list" <?= inputGet('post_type', true) == 'sorted_list' ? 'selected' : ''; ?>><?= trans("sorted_list"); ?></option>
                    <option value="trivia_quiz" <?= inputGet('post_type', true) == 'trivia_quiz' ? 'selected' : ''; ?>><?= trans("trivia_quiz"); ?></option>
                    <option value="personality_quiz" <?= inputGet('post_type', true) == 'personality_quiz' ? 'selected' : ''; ?>><?= trans("personality_quiz"); ?></option>
                    <option value="video" <?= inputGet('post_type', true) == 'video' ? 'selected' : ''; ?>><?= trans("video"); ?></option>
                    <option value="audio" <?= inputGet('post_type', true) == 'audio' ? 'selected' : ''; ?>><?= trans("audio"); ?></option>
                </select>
            </div>
            <?php if (checkUserPermission('manage_all_posts')): ?>
                <div class="item-table-filter">
                    <label><?= trans("user"); ?></label>
                    <select name="user" class="form-control">
                        <option value=""><?= trans("all"); ?></option>
                        <?php if (!empty($authors)):
                            foreach ($authors as $author): ?>
                                <option value="<?= $author->id; ?>"
                                    <?= inputGet('user', true) == $author->id ? 'selected' : ''; ?>>
                                    <?= esc($author->username); ?>
                                </option>
                            <?php endforeach;
                        endif; ?>
                    </select>
                </div>
            <?php endif; ?>
            <div class="item-table-filter">
                <label><?= trans('category'); ?></label>
                <select id="categories" name="category" class="form-control" onchange="getSubCategories(this.value);">
                    <option value=""><?= trans("all"); ?></option>
                    <?php $langId = inputGet('lang_id');
                    if (!empty($langId)) {
                        $categories = $categoryModel->getParentCategoriesByLang($langId);
                    } else {
                        $categories = $categoryModel->getParentCategories();
                    }
                    if (!empty($categories)):
                        foreach ($categories as $item): ?>
                            <option value="<?= $item->id; ?>" <?= inputGet('category', true) == $item->id ? 'selected' : ''; ?>>
                                <?= esc($item->name); ?>
                            </option>
                        <?php endforeach;
                    endif; ?>
                </select>
            </div>
            <div class="item-table-filter">
                <div class="form-group">
                    <label class="control-label"><?= trans('subcategory'); ?></label>
                    <select id="subcategories" name="subcategory" class="form-control">
                        <option value=""><?= trans("all"); ?></option>
                        <?php if (!empty(inputGet('category'))):
                            $subCategories = $categoryModel->getSubCategoriesByParentId(cleanNumber(inputGet('category')));
                            if (!empty($subCategories)):
                                foreach ($subCategories as $item): ?>
                                    <option value="<?= $item->id; ?>" <?= inputGet('subcategory', true) == $item->id ? 'selected' : ''; ?>><?= esc($item->name); ?></option>
                                <?php endforeach;
                            endif;
                        endif; ?>
                    </select>
                </div>
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