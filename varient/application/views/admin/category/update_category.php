<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-lg-5 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo trans("update_category"); ?></h3>
            </div>
            <!-- /.box-header -->

            <!-- form start -->
            <?php echo form_open('category_controller/update_category_post'); ?>

            <input type="hidden" name="id" value="<?php echo html_escape($category->id); ?>">
            <input type="hidden" name="parent_id" value="0">
            <input type="hidden" name="redirect_url" value="<?php echo html_escape($this->input->get('redirect_url')); ?>">

            <div class="box-body">

                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>

                <div class="form-group">
                    <label><?php echo trans("language"); ?></label>
                    <select name="lang_id" class="form-control">
                        <?php foreach ($this->languages as $language): ?>
                            <option value="<?php echo $language->id; ?>" <?php echo ($category->lang_id == $language->id) ? 'selected' : ''; ?>><?php echo $language->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label><?php echo trans("category_name"); ?></label>
                    <input type="text" class="form-control" name="name" placeholder="<?php echo trans("category_name"); ?>"
                           value="<?php echo html_escape($category->name); ?>" maxlength="200" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans("slug"); ?>
                        <small>(<?php echo trans("slug_exp"); ?>)</small>
                    </label>
                    <input type="text" class="form-control" name="name_slug" placeholder="<?php echo trans("slug"); ?>"
                           value="<?php echo html_escape($category->name_slug); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('description'); ?> (<?php echo trans('meta_tag'); ?>)</label>
                    <input type="text" class="form-control" name="description"
                           placeholder="<?php echo trans('description'); ?> (<?php echo trans('meta_tag'); ?>)" value="<?php echo html_escape($category->description); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('keywords'); ?> (<?php echo trans('meta_tag'); ?>)</label>
                    <input type="text" class="form-control" name="keywords"
                           placeholder="<?php echo trans('keywords'); ?> (<?php echo trans('meta_tag'); ?>)" value="<?php echo html_escape($category->keywords); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                </div>

                <!-- Color Picker -->
                <div class="form-group">
                    <label><?php echo trans('color'); ?></label>
                    <div class="input-group my-colorpicker">
                        <input type="text" class="form-control" name="color" maxlength="200" value="<?php echo html_escape($category->color); ?>" placeholder="<?php echo trans('color'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>
                               required>
                        <div class="input-group-addon">
                            <i></i>
                        </div>
                    </div><!-- /.input group -->
                </div><!-- /.form group -->

                <div class="form-group">
                    <label><?php echo trans('order'); ?></label>
                    <input type="number" class="form-control" name="category_order" placeholder="<?php echo trans('order'); ?>"
                           value="<?php echo html_escape($category->category_order); ?>" min="1" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-5 col-xs-12">
                            <label><?php echo trans('show_on_menu'); ?></label>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="rb_show_on_menu_1" name="show_on_menu" value="1" class="square-purple" <?php echo ($category->show_on_menu == '1') ? 'checked' : ''; ?>>
                            <label for="rb_show_on_menu_1" class="cursor-pointer"><?php echo trans('yes'); ?></label>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="rb_show_on_menu_2" name="show_on_menu" value="0" class="square-purple" <?php echo ($category->show_on_menu != '1') ? 'checked' : ''; ?>>
                            <label for="rb_show_on_menu_2" class="cursor-pointer"><?php echo trans('no'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-5 col-xs-12">
                            <label><?php echo trans('show_at_homepage'); ?></label>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="rb_show_at_homepage_1" name="show_at_homepage" value="1" class="square-purple" <?php echo ($category->show_at_homepage == '1') ? 'checked' : ''; ?>>
                            <label for="rb_show_at_homepage_1" class="cursor-pointer"><?php echo trans('yes'); ?></label>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12 col-option">
                            <input type="radio" id="rb_show_at_homepage_2" name="show_at_homepage" value="0" class="square-purple" <?php echo ($category->show_at_homepage != '1') ? 'checked' : ''; ?>>
                            <label for="rb_show_at_homepage_2" class="cursor-pointer"><?php echo trans('no'); ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label><?php echo trans('category_block_style'); ?></label>

                    <div class="row m-b-15 m-t-15">
                        <div class="category-block-box">
                            <div class="col-sm-12 text-center m-b-15">
                                <input type="radio" name="block_type" value="block-1" class="square-purple" <?php echo ($category->block_type == 'block-1') ? 'checked' : ''; ?>>
                            </div>
                            <img src="<?php echo base_url(); ?>assets/admin/img/block-1.png" alt="" class="img-responsive cat-block-img">
                        </div>
                        <div class="category-block-box">
                            <div class="col-sm-12 text-center m-b-15">
                                <input type="radio" name="block_type" value="block-2" class="square-purple" <?php echo ($category->block_type == 'block-2') ? 'checked' : ''; ?>>
                            </div>
                            <img src="<?php echo base_url(); ?>assets/admin/img/block-2.png" alt="" class="img-responsive cat-block-img">
                        </div>

                        <div class="category-block-box">
                            <div class="col-sm-12 text-center m-b-15">
                                <input type="radio" name="block_type" value="block-3" class="square-purple" <?php echo ($category->block_type == 'block-3') ? 'checked' : ''; ?>>
                            </div>
                            <img src="<?php echo base_url(); ?>assets/admin/img/block-3.png" alt="" class="img-responsive cat-block-img">
                        </div>
                        <div class="category-block-box">
                            <div class="col-sm-12 text-center m-b-15">
                                <input type="radio" name="block_type" value="block-4" class="square-purple" <?php echo ($category->block_type == 'block-4') ? 'checked' : ''; ?>>
                            </div>
                            <img src="<?php echo base_url(); ?>assets/admin/img/block-4.png" alt="" class="img-responsive cat-block-img">
                        </div>
                        <div class="category-block-box">
                            <div class="col-sm-12 text-center m-b-15">
                                <input type="radio" name="block_type" value="block-5" class="square-purple" <?php echo ($category->block_type == 'block-5') ? 'checked' : ''; ?>>
                            </div>
                            <img src="<?php echo base_url(); ?>assets/admin/img/block-5.png" alt="" class="img-responsive cat-block-img">
                        </div>
                    </div>

                </div>


            </div>


            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?> </button>
            </div>
            <!-- /.box-footer -->
            <?php echo form_close(); ?><!-- form end -->
        </div>
        <!-- /.box -->
    </div>

</div>
