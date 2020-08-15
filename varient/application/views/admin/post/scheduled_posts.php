<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?php echo $title; ?></h3>
        </div>
        <div class="right">
            <a href="<?php echo admin_url(); ?>post-format" class="btn btn-success btn-add-new pull-right">
                <i class="fa fa-plus"></i>
                <?php echo trans('add_post'); ?>
            </a>
        </div>
    </div><!-- /.box-header -->

    <div class="box-body">
        <div class="row">
            <!-- include message block -->
            <div class="col-sm-12">
                <?php $this->load->view('admin/includes/_messages'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" role="grid">
                        <?php $this->load->view('admin/includes/_filter_posts'); ?>
                        <thead>
                        <tr role="row">
                            <?php if (check_user_permission('manage_all_posts')): ?>
                                <th width="20"><input type="checkbox" class="checkbox-table" id="checkAll"></th>
                            <?php endif; ?>
                            <th width="20"><?php echo trans('id'); ?></th>
                            <th><?php echo trans('post'); ?></th>
                            <th><?php echo trans('post_type'); ?></th>
                            <th><?php echo trans('category'); ?></th>
                            <th><?php echo trans('author'); ?></th>
                            <th><?php echo trans('days_remaining'); ?></th>
                            <th><?php echo trans('date_added'); ?></th>
                            <th style="min-width: 180px;"><?php echo trans('options'); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($posts as $item): ?>
                            <tr>
                                <?php if (check_user_permission('manage_all_posts')): ?>
                                    <td><input type="checkbox" name="checkbox-table" class="checkbox-table" value="<?php echo $item->id; ?>"></td>
                                <?php endif; ?>
                                <td><?php echo html_escape($item->id); ?></td>
                                <td>
                                    <div class="td-post-item">
                                        <div class="post-image">
                                            <div class="image">
                                                <img src="<?php echo IMG_BASE64_1x1; ?>" data-src="<?php echo get_post_image($item, "small"); ?>" alt="" class="lazyload img-responsive"/>
                                            </div>
                                        </div>
                                        <div class="post-title">
                                            <?php echo html_escape($item->title); ?>
                                            <div class="preview">
                                                <a href="<?php echo base_url() . "preview/" . $item->title_slug; ?>" class="btn btn-sm btn-warning" target="_blank">
                                                    <i class="fa fa-eye"></i><?php echo trans("preview"); ?>
                                                </a>
                                                <?php if ($item->is_slider): ?>
                                                    <label class="label bg-red label-table"><?php echo trans('slider'); ?></label>
                                                <?php endif; ?>

                                                <?php if ($item->is_featured): ?>
                                                    <label class="label bg-olive label-table"><?php echo trans('featured'); ?></label>
                                                <?php endif; ?>

                                                <?php if ($item->is_recommended): ?>
                                                    <label class="label bg-aqua label-table"><?php echo trans('recommended'); ?></label>
                                                <?php endif; ?>

                                                <?php if ($item->is_breaking): ?>
                                                    <label class="label bg-teal label-table"><?php echo trans('breaking'); ?></label>
                                                <?php endif; ?>

                                                <?php if ($item->need_auth): ?>
                                                    <label class="label label-warning label-table"><?php echo trans('only_registered'); ?></label>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="td-post-type">
                                    <?php echo trans($item->post_type); ?>
                                </td>
                                <td>
                                    <?php $categories = get_parent_category_tree($item->category_id, $this->categories);
                                    if (!empty($categories)):
                                        foreach ($categories as $category):
                                            if (!empty($category)): ?>
                                                <label class="category-label m-r-5 label-table" style="background-color: <?php echo html_escape($category->color); ?>!important;">
                                                    <?php echo html_escape($category->name); ?>
                                                </label>
                                            <?php endif;
                                        endforeach;
                                    endif; ?>
                                </td>
                                <td>
                                    <?php $author = get_user($item->user_id);
                                    if (!empty($author)): ?>
                                        <a href="<?php echo generate_profile_url($author->slug); ?>" target="_blank" class="table-user-link">
                                            <strong><?php echo html_escape($author->username); ?></strong>
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?php echo date_difference(date('Y-m-d'), $item->created_at); ?></strong>
                                </td>
                                <td><?php echo formatted_date($item->created_at); ?></td>
                                <td>
                                    <!-- form post options -->
                                    <?php echo form_open('post_controller/post_options_post'); ?>
                                    <input type="hidden" name="id" value="<?php echo html_escape($item->id); ?>">

                                    <div class="dropdown">
                                        <button class="btn bg-purple dropdown-toggle btn-select-option"
                                                type="button"
                                                data-toggle="dropdown"><?php echo trans('select_an_option'); ?>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu options-dropdown">
                                            <?php if (check_user_permission('manage_all_posts')): ?>
                                                <li>
                                                    <button type="submit" name="option" value="publish" class="btn-list-button">
                                                        <i class="fa fa-check option-icon"></i><?php echo trans('publish'); ?>
                                                    </button>
                                                </li>
                                            <?php endif; ?>
                                            <li>
                                                <a href="<?php echo admin_url(); ?>update-post/<?php echo html_escape($item->id); ?>"><i class="fa fa-edit option-icon"></i><?php echo trans('edit'); ?></a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" onclick="delete_item('post_controller/delete_post','<?php echo $item->id; ?>','<?php echo trans("confirm_post"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
                                            </li>
                                        </ul>
                                    </div>

                                    <?php echo form_close(); ?><!-- form end -->
                                </td>
                            </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>
                    <?php if (empty($posts)): ?>
                        <p class="text-center">
                            <?php echo trans("no_records_found"); ?>
                        </p>
                    <?php endif; ?>
                    <div class="col-sm-12 table-ft">
                        <div class="row">
                            <div class="pull-right">
                                <?php echo $this->pagination->create_links(); ?>
                            </div>
                            <?php if (count($posts) > 0): ?>
                                <div class="pull-left bulk-options">
                                    <button class="btn btn-sm btn-danger btn-table-delete" onclick="delete_selected_posts('<?php echo trans("confirm_posts"); ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></button>
                                    <button class="btn btn-sm btn-default btn-table-delete" onclick="post_bulk_options('publish_scheduled');"><i class="fa fa-check option-icon"></i><?php echo trans('publish'); ?></button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
</div>

<div class="callout" style="margin-top: 30px;background-color: #fff; border-color:#00c0ef;max-width: 600px;">
    <h4>Cron Job</h4>

    <p><strong>http://domain.com/cron/check-scheduled-posts</strong></p>
    <small><?php echo trans('msg_cron_scheduled'); ?></small>
</div>