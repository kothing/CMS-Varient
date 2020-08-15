<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <div class="left">
                        <h3 class="box-title"><?php echo trans('add_page'); ?></h3>
                    </div>
                    <div class="right">
                        <a href="<?php echo admin_url(); ?>pages" class="btn btn-success btn-add-new">
                            <i class="fa fa-bars"></i>
                            <?php echo trans('pages'); ?>
                        </a>
                    </div>
                </div><!-- /.box-header -->

                <!-- form start -->
                <?php echo form_open('page_controller/add_page_post'); ?>
                <div class="box-body">
                    <!-- include message block -->
                    <?php $this->load->view('admin/includes/_messages'); ?>

                    <div class="form-group">
                        <label class="control-label"><?php echo trans('title'); ?></label>
                        <input type="text" class="form-control" name="title" placeholder="<?php echo trans('title'); ?>"
                               value="<?php echo old('title'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo trans("slug"); ?>
                            <small>(<?php echo trans("slug_exp"); ?>)</small>
                        </label>
                        <input type="text" class="form-control" name="slug" placeholder="<?php echo trans("slug"); ?>"
                               value="<?php echo old('slug'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo trans("description"); ?> (<?php echo trans('meta_tag'); ?>)</label>
                        <input type="text" class="form-control" name="description"
                               placeholder="<?php echo trans("description"); ?> (<?php echo trans('meta_tag'); ?>)" value="<?php echo old('description'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo trans('keywords'); ?> (<?php echo trans('meta_tag'); ?>)</label>
                        <input type="text" class="form-control" name="keywords"
                               placeholder="<?php echo trans('keywords'); ?> (<?php echo trans('meta_tag'); ?>)" value="<?php echo old('keywords'); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>

                    <div class="form-group">
                        <label><?php echo trans("language"); ?></label>
                        <select name="lang_id" class="form-control" onchange="get_menu_links_by_lang(this.value);" style="max-width: 600px;">
                            <?php foreach ($this->languages as $language): ?>
                                <option value="<?php echo $language->id; ?>" <?php echo ($this->selected_lang->id == $language->id) ? 'selected' : ''; ?>><?php echo $language->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo trans('parent_link'); ?></label>
                        <select id="parent_links" name="parent_id" class="form-control" style="max-width: 600px;">
                            <option value="0"><?php echo trans('none'); ?></option>
                            <?php foreach ($menu_links as $item):
                                if ($item->item_type != "category" && $item->item_location == "main" && $item->item_parent_id == "0"): ?>
                                    <option value="<?php echo $item->item_id; ?>"><?php echo $item->item_name; ?></option>
                                <?php endif;
                            endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><?php echo trans('order'); ?></label>
                        <input type="number" class="form-control" name="page_order" placeholder="<?php echo trans('order'); ?>" value="1" min="1" max="3000" style="width: 300px;max-width: 100%;" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12">
                                <label><?php echo trans('location'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="location" value="top" id="menu_top"
                                       class="square-purple" <?php echo (old("location") == "top" || old("location") == "") ? 'checked' : ''; ?>>
                                <label for="menu_top" class="option-label"><?php echo trans('top_menu'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="location" value="main" id="manu_main"
                                       class="square-purple" <?php echo (old("location") == "main") ? 'checked' : ''; ?>>
                                <label for="manu_main" class="option-label"><?php echo trans('main_menu'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="location" value="footer" id="menu_footer"
                                       class="square-purple" <?php echo (old("location") == "footer") ? 'checked' : ''; ?>>
                                <label for="menu_footer" class="option-label"><?php echo trans('footer'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="location" value="none" id="menu_none"
                                       class="square-purple" <?php echo (old("location") == "none") ? 'checked' : ''; ?>>
                                <label for="menu_none" class="option-label"><?php echo trans('dont_add_menu'); ?></label>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12">
                                <label><?php echo trans('visibility'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="visibility" value="1" id="page_enabled"
                                       class="square-purple" <?php echo (old("visibility") == 1 || old("visibility") == "") ? 'checked' : ''; ?>>
                                <label for="page_enabled" class="option-label"><?php echo trans('show'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="visibility" value="0" id="page_disabled"
                                       class="square-purple" <?php echo (old("visibility") == 0 && old("visibility") != "") ? 'checked' : ''; ?>>
                                <label for="page_disabled" class="option-label"><?php echo trans('hide'); ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12">
                                <label><?php echo trans('show_only_registered'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="need_auth" value="1" id="need_auth_enabled"
                                       class="square-purple" <?php echo (old("need_auth") == 1) ? 'checked' : ''; ?>>
                                <label for="need_auth_enabled" class="option-label"><?php echo trans('yes'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="need_auth" value="0" id="need_auth_disabled"
                                       class="square-purple" <?php echo (old("need_auth") == 0 || old("need_auth") == "") ? 'checked' : ''; ?>>
                                <label for="need_auth_disabled" class="option-label"><?php echo trans('no'); ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12">
                                <label><?php echo trans('show_title'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="title_active" value="1" id="title_enabled"
                                       class="square-purple" <?php echo (old("title_active") == 1 || old("title_active") == "") ? 'checked' : ''; ?>>
                                <label for="title_enabled" class="option-label"><?php echo trans('yes'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="title_active" value="0" id="title_disabled"
                                       class="square-purple" <?php echo (old("title_active") == 0 && old("title_active") != "") ? 'checked' : ''; ?>>
                                <label for="title_disabled" class="option-label"><?php echo trans('no'); ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12">
                                <label><?php echo trans('show_breadcrumb'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="breadcrumb_active" value="1" id="breadcrumb_enabled"
                                       class="square-purple" <?php echo (old("breadcrumb_active") == 1 || old("breadcrumb_active") == "") ? 'checked' : ''; ?>>
                                <label for="breadcrumb_enabled" class="option-label"><?php echo trans('yes'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="breadcrumb_active" value="0" id="breadcrumb_disabled"
                                       class="square-purple" <?php echo (old("breadcrumb_active") == 0 && old("breadcrumb_active") != "") ? 'checked' : ''; ?>>
                                <label for="breadcrumb_disabled" class="option-label"><?php echo trans('no'); ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12">
                                <label><?php echo trans('show_right_column'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="right_column_active" value="1" id="right_column_enabled"
                                       class="square-purple" <?php echo (old("right_column_active") == 1 || old("right_column_active") == "") ? 'checked' : ''; ?>>
                                <label for="right_column_enabled" class="option-label"><?php echo trans('yes'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="right_column_active" value="0" id="right_column_disabled"
                                       class="square-purple" <?php echo (old("right_column_active") == 0 && old("right_column_active") != "") ? 'checked' : ''; ?>>
                                <label for="right_column_disabled" class="option-label"><?php echo trans('no'); ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="main_editor">
                            <label><?php echo trans('content'); ?></label>
                            <div class="row">
                                <div class="col-sm-12 editor-buttons">
                                    <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#file_manager_image" data-image-type="editor"><i class="fa fa-image"></i>&nbsp;&nbsp;&nbsp;<?php echo trans("add_image"); ?></button>
                                    <button type="button" class="btn btn-sm bg-purple btn_tinymce_add_media" data-editor-id="main_editor"><i class="fa fa-file"></i>&nbsp;&nbsp;&nbsp;<?php echo trans("add_media"); ?></button>
                                </div>
                            </div>
                            <textarea class="tinyMCE form-control" name="page_content"><?php echo old('page_content'); ?></textarea>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?php echo trans('add_page'); ?></button>
                </div>
                <!-- /.box-footer -->

                <?php echo form_close(); ?><!-- form end -->
            </div>
            <!-- /.box -->
        </div>
    </div>

<?php $this->load->view('admin/file-manager/_load_file_manager', ['load_images' => true, 'load_files' => false, 'load_videos' => false, 'load_audios' => false]); ?>