<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row table-filter-container">
    <div class="col-sm-12">
        <?php echo form_open($form_action, ['method' => 'GET']); ?>

        <div class="item-table-filter" style="width: 80px; min-width: 80px;">
            <label><?php echo trans("show"); ?></label>
            <select name="show" class="form-control">
                <option value="15" <?php echo ($this->input->get('show', true) == '15') ? 'selected' : ''; ?>>15</option>
                <option value="30" <?php echo ($this->input->get('show', true) == '30') ? 'selected' : ''; ?>>30</option>
                <option value="60" <?php echo ($this->input->get('show', true) == '60') ? 'selected' : ''; ?>>60</option>
                <option value="100" <?php echo ($this->input->get('show', true) == '100') ? 'selected' : ''; ?>>100</option>
            </select>
        </div>

        <div class="item-table-filter">
            <label><?php echo trans("language"); ?></label>
            <select name="lang_id" class="form-control" onchange="get_parent_categories_by_lang(this.value);">
                <option value=""><?php echo trans("all"); ?></option>
                <?php foreach ($this->languages as $language): ?>
                    <option value="<?php echo $language->id; ?>" <?php echo ($this->input->get('lang_id', true) == $language->id) ? 'selected' : ''; ?>><?php echo html_escape($language->name); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="item-table-filter">
            <label><?php echo trans("post_type"); ?></label>
            <select name="post_type" class="form-control">
                <option value=""><?php echo trans("all"); ?></option>
                <option value="article" <?php echo ($this->input->get('post_type', true) == 'article') ? 'selected' : ''; ?>><?php echo trans("article"); ?></option>
                <option value="gallery" <?php echo ($this->input->get('post_type', true) == 'gallery') ? 'selected' : ''; ?>><?php echo trans("gallery"); ?></option>
                <option value="sorted_list" <?php echo ($this->input->get('post_type', true) == 'sorted_list') ? 'selected' : ''; ?>><?php echo trans("sorted_list"); ?></option>
                <option value="trivia_quiz" <?php echo ($this->input->get('post_type', true) == 'trivia_quiz') ? 'selected' : ''; ?>><?php echo trans("trivia_quiz"); ?></option>
                <option value="personality_quiz" <?php echo ($this->input->get('post_type', true) == 'personality_quiz') ? 'selected' : ''; ?>><?php echo trans("personality_quiz"); ?></option>
                <option value="video" <?php echo ($this->input->get('post_type', true) == 'video') ? 'selected' : ''; ?>><?php echo trans("video"); ?></option>
                <option value="audio" <?php echo ($this->input->get('post_type', true) == 'audio') ? 'selected' : ''; ?>><?php echo trans("audio"); ?></option>
            </select>
        </div>

        <?php if (check_user_permission('manage_all_posts')): ?>
            <div class="item-table-filter">
                <label><?php echo trans("user"); ?></label>
                <select name="user" class="form-control">
                    <option value=""><?php echo trans("all"); ?></option>
                    <?php foreach ($authors as $author): ?>
                        <option value="<?php echo $author->id; ?>"
                            <?php echo ($this->input->get('user', true) == $author->id) ? 'selected' : ''; ?>>
                            <?php echo html_escape($author->username); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>

        <div class="item-table-filter">
            <label><?php echo trans('category'); ?></label>
            <select id="categories" name="category" class="form-control" onchange="get_sub_categories(this.value);">
                <option value=""><?php echo trans("all"); ?></option>
                <?php if (!empty($this->input->get('lang_id', true))) {
                    $categories = $this->category_model->get_parent_categories_by_lang($this->input->get('lang_id', true));
                } else {
                    $categories = $this->category_model->get_parent_categories();
                } ?>
                <?php foreach ($categories as $item): ?>
                    <option value="<?php echo $item->id; ?>" <?php echo ($this->input->get('category', true) == $item->id) ? 'selected' : ''; ?>>
                        <?php echo html_escape($item->name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="item-table-filter">
            <div class="form-group">
                <label class="control-label"><?php echo trans('subcategory'); ?></label>
                <select id="subcategories" name="subcategory" class="form-control">
                    <option value=""><?php echo trans("all"); ?></option>
                    <?php
                    if (!empty($this->input->get('category', true))):
                        $subcategories = get_subcategories($this->input->get('category', true), $this->categories);
                        if (!empty($subcategories)) {
                            foreach ($subcategories as $item): ?>
                                <option value="<?php echo $item->id; ?>" <?php echo ($this->input->get('subcategory', true) == $item->id) ? 'selected' : ''; ?>><?php echo $item->name; ?></option>
                            <?php endforeach;
                        }
                    endif;
                    ?>
                </select>
            </div>
        </div>

        <div class="item-table-filter">
            <label><?php echo trans("search"); ?></label>
            <input name="q" class="form-control" placeholder="<?php echo trans("search") ?>" type="search" value="<?php echo html_escape($this->input->get('q', true)); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
        </div>

        <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
            <label style="display: block">&nbsp;</label>
            <button type="submit" class="btn bg-purple"><?php echo trans("filter"); ?></button>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>