<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Section: wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?php echo lang_base_url(); ?>"><?php echo trans("breadcrumb_home"); ?></a>
                    </li>
                    <li class="breadcrumb-item active"><?php echo trans("rss_feeds"); ?></li>
                </ol>
            </div>

            <div id="content" class="col-sm-12">
                <div class="row">
                    <div class="col-sm-12">
                        <h1 class="page-title"><?php echo trans("rss_feeds"); ?></h1>
                    </div>

                    <div class="col-sm-12">
                        <div class="page-content font-text">

                            <div class="rss-item">
                                <div class="left">
                                    <a href="<?php echo lang_base_url(); ?>rss/latest-posts" target="_blank"><i class="icon-rss"></i>&nbsp;&nbsp;<?php echo trans("latest_posts"); ?></a>
                                </div>
                                <div class="right">
                                    <p><?php echo lang_base_url() . "rss/latest-posts"; ?></p>
                                </div>
                            </div>

                            <?php foreach ($this->categories as $category):
                                if ($category->lang_id == $this->selected_lang->id && $category->parent_id == 0): ?>
                                    <div class="rss-item">
                                        <div class="left">
                                            <a href="<?php echo lang_base_url(); ?>rss/category/<?php echo html_escape($category->name_slug); ?>" target="_blank"><i class="icon-rss"></i>&nbsp;&nbsp;<?php echo html_escape($category->name); ?></a>
                                        </div>
                                        <div class="right">
                                            <p><?php echo lang_base_url(); ?>rss/category/<?php echo html_escape($category->name_slug); ?></p>
                                        </div>
                                    </div>
                                    <?php $subcategories = get_subcategories($category->id, $this->categories);
                                    if (!empty($subcategories)):
                                        foreach ($subcategories as $subcategory):?>
                                            <div class="rss-item">
                                                <div class="left">
                                                    <a href="<?php echo lang_base_url(); ?>rss/category/<?php echo html_escape($subcategory->name_slug); ?>" target="_blank"><i class="icon-rss"></i>&nbsp;&nbsp;<?php echo html_escape($subcategory->name); ?></a>
                                                </div>
                                                <div class="right">
                                                    <p><?php echo lang_base_url(); ?>rss/category/<?php echo html_escape($subcategory->name_slug); ?></p>
                                                </div>
                                            </div>
                                        <?php endforeach;
                                    endif;
                                endif;
                            endforeach; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


</div>
<!-- /.Section: wrapper -->