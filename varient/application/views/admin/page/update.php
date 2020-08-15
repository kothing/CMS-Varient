<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo trans('update_page'); ?></h3>
                </div>
                <!-- /.box-header -->

                <!-- form start -->
                <?php echo form_open('page_controller/update_page_post'); ?>

                <input type="hidden" name="id" value="<?php echo html_escape($page->id); ?>">
                <input type="hidden" name="redirect_url" value="<?php echo html_escape($this->input->get('redirect_url')); ?>">

                <div class="box-body">
                    <!-- include message block -->
                    <?php $this->load->view('admin/includes/_messages'); ?>

                    <div class="form-group">
                        <label class="control-label"><?php echo trans('title'); ?></label>
                        <input type="text" class="form-control" name="title" placeholder="<?php echo trans('title'); ?>"
                               value="<?php echo html_escape($page->title); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?> required>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo trans("slug"); ?>
                            <small>(<?php echo trans("slug_exp"); ?>)</small>
                        </label>
                        <input type="text" class="form-control" name="slug" placeholder="<?php echo trans("slug"); ?>" value="<?php echo html_escape($page->slug); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo trans("description"); ?> (<?php echo trans('meta_tag'); ?>)</label>
                        <input type="text" class="form-control" name="description"
                               placeholder="<?php echo trans("description"); ?> (<?php echo trans('meta_tag'); ?>)"
                               value="<?php echo html_escape($page->description); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo trans('keywords'); ?> (<?php echo trans('meta_tag'); ?>)</label>
                        <input type="text" class="form-control" name="keywords"
                               placeholder="<?php echo trans('keywords'); ?> (<?php echo trans('meta_tag'); ?>)" value="<?php echo html_escape($page->keywords); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>

                    <div class="form-group">
                        <label><?php echo trans("language"); ?></label>
                        <select name="lang_id" class="form-control" onchange="get_menu_links_by_lang(this.value);" style="max-width: 600px;">
                            <?php foreach ($this->languages as $language): ?>
                                <option value="<?php echo $language->id; ?>" <?php echo ($page->lang_id == $language->id) ? 'selected' : ''; ?>><?php echo $language->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <?php if ($page->location == "main"): ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo trans('parent_link'); ?></label>
                            <select id="parent_links" name="parent_id" class="form-control" style="max-width: 600px;">
                                <option value="0"><?php echo trans('none'); ?></option>
                                <?php foreach ($menu_links as $item):
                                    if ($item->item_type != "category" && $item->item_location == "main" && $item->item_parent_id == "0" && $item->item_id != $page->id):
                                        if ($item->item_id == $page->parent_id): ?>
                                            <option value="<?php echo $item->item_id; ?>" selected><?php echo $item->item_name; ?></option>
                                        <?php else: ?>
                                            <option value="<?php echo $item->item_id; ?>"><?php echo $item->item_name; ?></option>
                                        <?php endif;
                                    endif;
                                endforeach; ?>
                            </select>
                        </div>
                    <?php else: ?>
                        <input type="hidden" name="parent_id" value="<?php echo html_escape($page->parent_id); ?>">
                    <?php endif; ?>

                    <?php if ($page->location != "none"): ?>
                        <div class="form-group">
                            <label><?php echo trans('order'); ?></label>
                            <input type="number" class="form-control" name="page_order" placeholder="<?php echo trans('order'); ?>" value="<?php echo $page->page_order; ?>" min="1" max="3000" style="width: 300px;max-width: 100%;" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                        </div>
                    <?php else: ?>
                        <input type="hidden" name="page_order" value="<?php echo $page->page_order; ?>">
                    <?php endif; ?>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12">
                                <label><?php echo trans('location'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="location" value="top" id="menu_top"
                                       class="square-purple" <?php echo ($page->location == "top") ? 'checked' : ''; ?>>
                                <label for="menu_top" class="option-label"><?php echo trans('top_menu'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="location" value="main" id="manu_main"
                                       class="square-purple" <?php echo ($page->location == "main") ? 'checked' : ''; ?>>
                                <label for="manu_main" class="option-label"><?php echo trans('main_menu'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="location" value="footer" id="menu_footer"
                                       class="square-purple" <?php echo ($page->location == "footer") ? 'checked' : ''; ?>>
                                <label for="menu_footer" class="option-label"><?php echo trans('footer'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="location" value="none" id="menu_none"
                                       class="square-purple" <?php echo ($page->location == "none") ? 'checked' : ''; ?>>
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
                                       class="square-purple" <?php echo ($page->visibility == 1) ? 'checked' : ''; ?>>
                                <label for="page_enabled" class="option-label"><?php echo trans('show'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="visibility" value="0" id="page_disabled"
                                       class="square-purple" <?php echo ($page->visibility == 0) ? 'checked' : ''; ?>>
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
                                       class="square-purple" <?php echo ($page->need_auth == 1) ? 'checked' : ''; ?>>
                                <label for="need_auth_enabled" class="option-label"><?php echo trans('yes'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="need_auth" value="0" id="need_auth_disabled"
                                       class="square-purple" <?php echo ($page->need_auth == 0) ? 'checked' : ''; ?>>
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
                                       class="square-purple" <?php echo ($page->title_active == 1) ? 'checked' : ''; ?>>
                                <label for="title_enabled" class="option-label"><?php echo trans('yes'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="title_active" value="0" id="title_disabled"
                                       class="square-purple" <?php echo ($page->title_active == 0) ? 'checked' : ''; ?>>
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
                                       class="square-purple" <?php echo ($page->breadcrumb_active == 1) ? 'checked' : ''; ?>>
                                <label for="breadcrumb_enabled" class="option-label"><?php echo trans('yes'); ?></label>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="breadcrumb_active" value="0" id="breadcrumb_disabled"
                                       class="square-purple" <?php echo ($page->breadcrumb_active == 0) ? 'checked' : ''; ?>>
                                <label for="breadcrumb_disabled" class="option-label"><?php echo trans('no'); ?></label>
                            </div>
                        </div>
                    </div>

                    <?php if ($page->slug != "contact" && $page->slug != "gallery"): ?>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-3 col-xs-12">
                                    <label><?php echo trans('show_right_column'); ?></label>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" name="right_column_active" value="1" id="right_column_enabled"
                                           class="square-purple" <?php echo ($page->right_column_active == 1) ? 'checked' : ''; ?>>
                                    <label for="right_column_enabled" class="option-label"><?php echo trans('yes'); ?></label>
                                </div>
                                <div class="col-md-2 col-sm-4 col-xs-12 col-option">
                                    <input type="radio" name="right_column_active" value="0" id="right_column_disabled"
                                           class="square-purple" <?php echo ($page->right_column_active == 0) ? 'checked' : ''; ?>>
                                    <label for="right_column_disabled" class="option-label"><?php echo trans('no'); ?></label>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <input type="hidden" name="right_column_active"
                               value="<?php echo html_escape($page->right_column_active); ?>">
                    <?php endif; ?>

                    <?php if ($page->page_default_name != "contact" && $page->page_default_name != "gallery"): ?>
                        <div class="form-group">
                            <div id="main_editor">
                                <label><?php echo trans('content'); ?></label>
                                <div class="row">
                                    <div class="col-sm-12 editor-buttons">
                                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#file_manager_image" data-image-type="editor"><i class="fa fa-image"></i>&nbsp;&nbsp;&nbsp;<?php echo trans("add_image"); ?></button>
                                        <button type="button" class="btn btn-sm bg-purple btn_tinymce_add_media" data-editor-id="main_editor"><i class="fa fa-file"></i>&nbsp;&nbsp;&nbsp;<?php echo trans("add_media"); ?></button>
                                    </div>
                                </div>
                                <textarea class="tinyMCE form-control" name="page_content"><?php echo $page->page_content; ?></textarea>
                            </div>
                        </div>
                    <?php else: ?>
                        <input type="hidden" name="page_content" content="">
                    <?php endif; ?>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
                </div>
                <!-- /.box-footer -->

                <?php echo form_close(); ?><!-- form end -->
            </div>
            <!-- /.box -->
        </div>
    </div>

<?php $this->load->view('admin/file-manager/_load_file_manager', ['load_images' => true, 'load_files' => false, 'load_videos' => false, 'load_audios' => false]); ?>