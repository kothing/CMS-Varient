<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-8 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans("update_category"); ?></h3>
            </div>
            <form action="<?= base_url('CategoryController/editCategoryPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" value="<?= esc($category->id); ?>">
                <input type="hidden" name="parent_id" value="0">
                <input type="hidden" name="back_url" value="<?= currentFullURL(); ?>">
                <input type="hidden" name="type" value="<?= $category->parent_id == 0 ? 'parent' : 'sub'; ?>">
                <div class="box-body">
                    <div class="form-group">
                        <label><?= trans("language"); ?></label>
                        <select name="lang_id" class="form-control" onchange="showWidgets(this.value);">
                            <?php foreach ($activeLanguages as $language): ?>
                                <option value="<?= $language->id; ?>" <?= $category->lang_id == $language->id ? 'selected' : ''; ?>><?= $language->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><?= trans("category_name"); ?></label>
                        <input type="text" class="form-control" name="name" placeholder="<?= trans("category_name"); ?>" value="<?= esc($category->name); ?>" maxlength="200" required>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans("slug"); ?>
                            <small>(<?= trans("slug_exp"); ?>)</small>
                        </label>
                        <input type="text" class="form-control" name="name_slug" placeholder="<?= trans("slug"); ?>" value="<?= esc($category->name_slug); ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('description'); ?> (<?= trans('meta_tag'); ?>)</label>
                        <input type="text" class="form-control" name="description" placeholder="<?= trans('description'); ?> (<?= trans('meta_tag'); ?>)" value="<?= esc($category->description); ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('keywords'); ?> (<?= trans('meta_tag'); ?>)</label>
                        <input type="text" class="form-control" name="keywords" placeholder="<?= trans('keywords'); ?> (<?= trans('meta_tag'); ?>)" value="<?= esc($category->keywords); ?>">
                    </div>
                    <?php if ($category->parent_id == 0): ?>
                        <div class="form-group">
                            <label><?= trans('color'); ?></label>
                            <div class="input-group my-colorpicker">
                                <input type="text" class="form-control" name="color" maxlength="200" value="<?= esc($category->color); ?>" placeholder="<?= trans('color'); ?>" required>
                                <div class="input-group-addon"><i></i></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><?= trans('order'); ?></label>
                            <input type="number" class="form-control" name="category_order" placeholder="<?= trans('order'); ?>" value="<?= esc($category->category_order); ?>" min="1" required>
                        </div>
                    <?php else: ?>
                        <div class="form-group">
                            <label><?= trans('parent_category'); ?></label>
                            <select id="categories" class="form-control" name="parent_id" required>
                                <option value=""><?= trans('select'); ?></option>
                                <?php if (!empty($parentCategories)):
                                    foreach ($parentCategories as $item): ?>
                                        <option value="<?= $item->id; ?>" <?= $category->parent_id == $item->id ? 'selected' : ''; ?>><?= $item->name; ?></option>
                                    <?php endforeach;
                                endif; ?>
                            </select>
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-5 col-xs-12">
                                <label><?= trans('show_on_menu'); ?></label>
                            </div>
                            <div class="col-md-3 col-sm-4 col-xs-12 col-option">
                                <input type="radio" id="rb_show_on_menu_1" name="show_on_menu" value="1" class="square-purple" <?= $category->show_on_menu == '1' ? 'checked' : ''; ?>>
                                <label for="rb_show_on_menu_1" class="cursor-pointer"><?= trans('yes'); ?></label>
                            </div>
                            <div class="col-md-3 col-sm-4 col-xs-12 col-option">
                                <input type="radio" id="rb_show_on_menu_2" name="show_on_menu" value="0" class="square-purple" <?= $category->show_on_menu != '1' ? 'checked' : ''; ?>>
                                <label for="rb_show_on_menu_2" class="cursor-pointer"><?= trans('no'); ?></label>
                            </div>
                        </div>
                    </div>

                    <?php if ($category->parent_id == 0): ?>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-5 col-xs-12">
                                    <label><?= trans('show_at_homepage'); ?></label>
                                </div>
                                <div class="col-md-3 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" id="rb_show_at_homepage_1" name="show_at_homepage" value="1" class="square-purple" <?= $category->show_at_homepage == '1' ? 'checked' : ''; ?>>
                                    <label for="rb_show_at_homepage_1" class="cursor-pointer"><?= trans('yes'); ?></label>
                                </div>
                                <div class="col-md-3 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" id="rb_show_at_homepage_2" name="show_at_homepage" value="0" class="square-purple" <?= $category->show_at_homepage != '1' ? 'checked' : ''; ?>>
                                    <label for="rb_show_at_homepage_2" class="cursor-pointer"><?= trans('no'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><?= trans('category_block_style'); ?></label>
                            <?php if ($activeTheme->theme == 'classic'): ?>
                                <div class="row m-b-15 m-t-15">
                                    <div class="category-block-box">
                                        <div class="col-sm-12 text-center m-b-15">
                                            <input type="radio" name="block_type" value="block-1" class="square-purple" <?= $category->block_type == 'block-1' || empty($category->block_type) ? 'checked' : ''; ?>>
                                        </div>
                                        <img src="<?= base_url('assets/admin/img/block-1.png'); ?>" alt="" class="img-responsive cat-block-img">
                                    </div>
                                    <div class="category-block-box">
                                        <div class="col-sm-12 text-center m-b-15">
                                            <input type="radio" name="block_type" value="block-2" class="square-purple" <?= $category->block_type == 'block-2' ? 'checked' : ''; ?>>
                                        </div>
                                        <img src="<?= base_url('assets/admin/img/block-2.png'); ?>" alt="" class="img-responsive cat-block-img">
                                    </div>

                                    <div class="category-block-box">
                                        <div class="col-sm-12 text-center m-b-15">
                                            <input type="radio" name="block_type" value="block-3" class="square-purple" <?= $category->block_type == 'block-3' ? 'checked' : ''; ?>>
                                        </div>
                                        <img src="<?= base_url('assets/admin/img/block-3.png'); ?>" alt="" class="img-responsive cat-block-img">
                                    </div>
                                    <div class="category-block-box">
                                        <div class="col-sm-12 text-center m-b-15">
                                            <input type="radio" name="block_type" value="block-4" class="square-purple" <?= $category->block_type == 'block-4' ? 'checked' : ''; ?>>
                                        </div>
                                        <img src="<?= base_url('assets/admin/img/block-4.png'); ?>" alt="" class="img-responsive cat-block-img">
                                    </div>
                                    <div class="category-block-box">
                                        <div class="col-sm-12 text-center m-b-15">
                                            <input type="radio" name="block_type" value="block-5" class="square-purple" <?= $category->block_type == 'block-5' ? 'checked' : ''; ?>>
                                        </div>
                                        <img src="<?= base_url('assets/admin/img/block-5.png'); ?>" alt="" class="img-responsive cat-block-img">
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="row m-b-15 m-t-15">
                                    <div class="category-block-box">
                                        <div class="col-sm-12 text-center m-b-15">
                                            <input type="radio" name="block_type" value="block-1" class="square-purple" <?= $category->block_type == 'block-1' || empty($category->block_type) ? 'checked' : ''; ?>>
                                        </div>
                                        <img src="<?= base_url('assets/admin/img/magazine/block-1.jpg'); ?>" alt="" class="img-responsive cat-block-img">
                                    </div>
                                    <div class="category-block-box">
                                        <div class="col-sm-12 text-center m-b-15">
                                            <input type="radio" name="block_type" value="block-2" class="square-purple" <?= $category->block_type == 'block-2' ? 'checked' : ''; ?>>
                                        </div>
                                        <img src="<?= base_url('assets/admin/img/magazine/block-2.jpg'); ?>" alt="" class="img-responsive cat-block-img">
                                    </div>
                                    <div class="category-block-box">
                                        <div class="col-sm-12 text-center m-b-15">
                                            <input type="radio" name="block_type" value="block-3" class="square-purple" <?= $category->block_type == 'block-3' ? 'checked' : ''; ?>>
                                        </div>
                                        <img src="<?= base_url('assets/admin/img/magazine/block-3.jpg'); ?>" alt="" class="img-responsive cat-block-img">
                                    </div>
                                    <div class="category-block-box">
                                        <div class="col-sm-12 text-center m-b-15">
                                            <input type="radio" name="block_type" value="block-4" class="square-purple" <?= $category->block_type == 'block-4' ? 'checked' : ''; ?>>
                                        </div>
                                        <img src="<?= base_url('assets/admin/img/magazine/block-4.jpg'); ?>" alt="" class="img-responsive cat-block-img">
                                    </div>
                                    <div class="category-block-box">
                                        <div class="col-sm-12 text-center m-b-15">
                                            <input type="radio" name="block_type" value="block-5" class="square-purple" <?= $category->block_type == 'block-5' ? 'checked' : ''; ?>>
                                        </div>
                                        <p style="margin-bottom: 2px; text-align: center; font-weight: 700; font-size: 12px;"><?= trans("slider"); ?></p>
                                        <img src="<?= base_url('assets/admin/img/magazine/block-5.jpg'); ?>" alt="" class="img-responsive cat-block-img">
                                    </div>
                                    <div class="category-block-box">
                                        <div class="col-sm-12 text-center m-b-15">
                                            <input type="radio" name="block_type" value="block-6" class="square-purple" <?= $category->block_type == 'block-6' ? 'checked' : ''; ?>>
                                        </div>
                                        <img src="<?= base_url('assets/admin/img/magazine/block-6.jpg'); ?>" alt="" class="img-responsive cat-block-img">
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?> </button>
                </div>
            </form>
        </div>
    </div>
</div>