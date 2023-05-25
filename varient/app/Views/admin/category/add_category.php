<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-8 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <?php if ($type == 'parent'): ?>
                    <div class="left">
                        <h3 class="box-title"><?= trans("add_category"); ?></h3>
                    </div>
                    <div class="right">
                        <a href="<?= adminUrl('categories'); ?>" class="btn btn-success btn-add-new"><i class="fa fa-bars"></i><?= trans("categories"); ?></a>
                    </div>
                <?php else: ?>
                    <div class="left">
                        <h3 class="box-title"><?= trans("add_subcategory"); ?></h3>
                    </div>
                    <div class="right">
                        <a href="<?= adminUrl('subcategories'); ?>" class="btn btn-success btn-add-new"><i class="fa fa-bars"></i><?= trans("subcategories"); ?></a>
                    </div>
                <?php endif; ?>
            </div>
            <form action="<?= base_url('CategoryController/addCategoryPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="parent_id" value="0">
                <input type="hidden" name="type" value="<?= esc(inputGet('type', true)); ?>">
                <div class="box-body">
                    <div class="form-group">
                        <label><?= trans("language"); ?></label>
                        <select name="lang_id" class="form-control" onchange="getParentCategoriesByLang(this.value); showWidgets(this.value);">
                            <?php foreach ($activeLanguages as $language): ?>
                                <option value="<?= $language->id; ?>" <?= $activeLang->id == $language->id ? 'selected' : ''; ?>><?= $language->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><?= trans("category_name"); ?></label>
                        <input type="text" class="form-control" name="name" placeholder="<?= trans("category_name"); ?>" value="<?= old('name'); ?>" maxlength="200" required>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans("slug"); ?>
                            <small>(<?= trans("slug_exp"); ?>)</small>
                        </label>
                        <input type="text" class="form-control" name="name_slug" placeholder="<?= trans("slug"); ?>" value="<?= old('name_slug'); ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('description'); ?> (<?= trans('meta_tag'); ?>)</label>
                        <input type="text" class="form-control" name="description" placeholder="<?= trans('description'); ?> (<?= trans('meta_tag'); ?>)" value="<?= old('description'); ?>">
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('keywords'); ?> (<?= trans('meta_tag'); ?>)</label>
                        <input type="text" class="form-control" name="keywords" placeholder="<?= trans('keywords'); ?> (<?= trans('meta_tag'); ?>)" value="<?= old('keywords'); ?>">
                    </div>
                    <?php if ($type == 'parent'): ?>
                        <div class="form-group">
                            <label><?= trans('color'); ?></label>
                            <div class="input-group my-colorpicker">
                                <input type="text" class="form-control" name="color" maxlength="200" placeholder="<?= trans('color'); ?>" required>
                                <div class="input-group-addon"><i></i></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><?= trans('order'); ?></label>
                            <input type="number" class="form-control" name="category_order" placeholder="<?= trans('order'); ?>" value="1" min="1" required>
                        </div>
                    <?php endif;
                    if ($type == 'sub'): ?>
                        <div class="form-group">
                            <label><?= trans('parent_category'); ?></label>
                            <select id="categories" class="form-control" name="parent_id" required>
                                <option value=""><?= trans('select'); ?></option>
                                <?php if (!empty($parentCategories)):
                                    foreach ($parentCategories as $item): ?>
                                        <option value="<?= $item->id; ?>"><?= $item->name; ?></option>
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
                                <input type="radio" id="rb_show_on_menu_1" name="show_on_menu" value="1" class="square-purple" checked>
                                <label for="rb_show_on_menu_1" class="cursor-pointer"><?= trans('yes'); ?></label>
                            </div>
                            <div class="col-md-3 col-sm-4 col-xs-12 col-option">
                                <input type="radio" id="rb_show_on_menu_2" name="show_on_menu" value="0" class="square-purple">
                                <label for="rb_show_on_menu_2" class="cursor-pointer"><?= trans('no'); ?></label>
                            </div>
                        </div>
                    </div>
                    <?php if ($type == 'parent'): ?>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-5 col-xs-12">
                                    <label><?= trans('show_at_homepage'); ?></label>
                                </div>
                                <div class="col-md-3 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" id="rb_show_at_homepage_1" name="show_at_homepage" value="1" class="square-purple" checked>
                                    <label for="rb_show_at_homepage_1" class="cursor-pointer"><?= trans('yes'); ?></label>
                                </div>
                                <div class="col-md-3 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" id="rb_show_at_homepage_2" name="show_at_homepage" value="0" class="square-purple">
                                    <label for="rb_show_at_homepage_2" class="cursor-pointer"><?= trans('no'); ?></label>
                                </div>
                            </div>
                        </div>
                        <?php if ($activeTheme->theme == 'classic'): ?>
                            <div class="form-group">
                                <label><?= trans('category_block_style'); ?></label>
                                <div class="row m-b-15 m-t-15">
                                    <div class="category-block-box">
                                        <div class="col-sm-12 text-center m-b-15">
                                            <input type="radio" name="block_type" value="block-1" class="square-purple" checked>
                                        </div>
                                        <img src="<?= base_url('assets/admin/img/block-1.png'); ?>" alt="" class="img-responsive cat-block-img">
                                    </div>
                                    <div class="category-block-box">
                                        <div class="col-sm-12 text-center m-b-15">
                                            <input type="radio" name="block_type" value="block-2" class="square-purple">
                                        </div>
                                        <img src="<?= base_url('assets/admin/img/block-2.png'); ?>" alt="" class="img-responsive cat-block-img">
                                    </div>

                                    <div class="category-block-box">
                                        <div class="col-sm-12 text-center m-b-15">
                                            <input type="radio" name="block_type" value="block-3" class="square-purple">
                                        </div>
                                        <img src="<?= base_url('assets/admin/img/block-3.png'); ?>" alt="" class="img-responsive cat-block-img">
                                    </div>
                                    <div class="category-block-box">
                                        <div class="col-sm-12 text-center m-b-15">
                                            <input type="radio" name="block_type" value="block-4" class="square-purple">
                                        </div>
                                        <img src="<?= base_url('assets/admin/img/block-4.png'); ?>" alt="" class="img-responsive cat-block-img">
                                    </div>
                                    <div class="category-block-box">
                                        <div class="col-sm-12 text-center m-b-15">
                                            <input type="radio" name="block_type" value="block-5" class="square-purple">
                                        </div>
                                        <img src="<?= base_url('assets/admin/img/block-5.png'); ?>" alt="" class="img-responsive cat-block-img">
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="row m-b-15 m-t-15">
                                <div class="category-block-box">
                                    <div class="col-sm-12 text-center m-b-15">
                                        <input type="radio" name="block_type" value="block-1" class="square-purple" checked>
                                    </div>
                                    <img src="<?= base_url('assets/admin/img/magazine/block-1.jpg'); ?>" alt="" class="img-responsive cat-block-img">
                                </div>
                                <div class="category-block-box">
                                    <div class="col-sm-12 text-center m-b-15">
                                        <input type="radio" name="block_type" value="block-2" class="square-purple">
                                    </div>
                                    <img src="<?= base_url('assets/admin/img/magazine/block-2.jpg'); ?>" alt="" class="img-responsive cat-block-img">
                                </div>
                                <div class="category-block-box">
                                    <div class="col-sm-12 text-center m-b-15">
                                        <input type="radio" name="block_type" value="block-3" class="square-purple">
                                    </div>
                                    <img src="<?= base_url('assets/admin/img/magazine/block-3.jpg'); ?>" alt="" class="img-responsive cat-block-img">
                                </div>
                                <div class="category-block-box">
                                    <div class="col-sm-12 text-center m-b-15">
                                        <input type="radio" name="block_type" value="block-4" class="square-purple">
                                    </div>
                                    <img src="<?= base_url('assets/admin/img/magazine/block-4.jpg'); ?>" alt="" class="img-responsive cat-block-img">
                                </div>
                                <div class="category-block-box">
                                    <div class="col-sm-12 text-center m-b-15">
                                        <input type="radio" name="block_type" value="block-5" class="square-purple">
                                    </div>
                                    <p style="margin-bottom: 2px; text-align: center; font-weight: 700; font-size: 12px;"><?= trans("slider"); ?></p>
                                    <img src="<?= base_url('assets/admin/img/magazine/block-5.jpg'); ?>" alt="" class="img-responsive cat-block-img">
                                </div>
                                <div class="category-block-box">
                                    <div class="col-sm-12 text-center m-b-15">
                                        <input type="radio" name="block_type" value="block-6" class="square-purple">
                                    </div>
                                    <img src="<?= base_url('assets/admin/img/magazine/block-6.jpg'); ?>" alt="" class="img-responsive cat-block-img">
                                </div>
                            </div>
                        <?php endif;
                    endif; ?>
                </div>
                <div class="box-footer">
                    <?php if ($type == 'parent'): ?>
                        <button type="submit" class="btn btn-primary pull-right"><?= trans('add_category'); ?></button>
                    <?php else: ?>
                        <button type="submit" class="btn btn-primary pull-right"><?= trans('add_subcategory'); ?></button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>