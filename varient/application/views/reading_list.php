<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Section: wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?php echo lang_base_url(); ?>"><?php echo trans("breadcrumb_home"); ?></a>
                    </li>

                    <li class="breadcrumb-item active"><?php echo trans("reading_list"); ?></li>
                </ol>
            </div>

            <div id="content" class="col-sm-8">

                <div class="row">
                    <div class="col-sm-12">
                        <h1 class="page-title"><?php echo trans("reading_list"); ?></h1>
                    </div>

                    <?php $count = 0; ?>
                    <?php foreach ($posts as $post):
                        $post_base_url = get_base_url_by_language_id($post->lang_id); ?>

                        <?php if ($count != 0 && $count % 2 == 0): ?>
                        <div class="col-sm-12"></div>
                    <?php endif; ?>

                        <?php if ($this->visual_settings->post_list_style == "vertical"): ?>
                        <!--Post row item-->
                        <div class="col-sm-6 col-xs-12">
                            <div class="post-item<?php echo check_post_img($post, 'class'); ?>">
                                <?php if (check_post_img($post)): ?>
                                    <div class="post-item-image">
                                        <a href="<?php echo $post_base_url . $post->title_slug; ?>">
                                            <?php $this->load->view("post/_post_image", ["post_item" => $post, "type" => "medium"]); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <h3 class="title">
                                    <a href="<?php echo $post_base_url . $post->title_slug; ?>">
                                        <?php echo html_escape(character_limiter($post->title, 55, '...')); ?>
                                    </a>
                                </h3>
                                <p class="post-meta">
                                    <?php $this->load->view("post/_post_meta", ["post" => $post]); ?>
                                </p>
                                <p class="description">
                                    <?php echo html_escape(character_limiter($post->summary, 80, '...')); ?>
                                </p>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="post-item-horizontal<?php echo check_post_img($post, 'class'); ?>">
                                    <?php if (check_post_img($post)): ?>
                                        <div class="col-sm-5 col-xs-12 item-image">
                                            <div class="post-item-image">
                                                <a href="<?php echo $post_base_url . $post->title_slug; ?>">
                                                    <?php $this->load->view("post/_post_image", ["post_item" => $post, "type" => "medium"]); ?>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="col-sm-7 col-xs-12 item-content">
                                        <h3 class="title">
                                            <a href="<?php echo $post_base_url . $post->title_slug; ?>">
                                                <?php echo html_escape(character_limiter($post->title, 55, '...')); ?>
                                            </a>
                                        </h3>
                                        <p class="small-post-meta">
                                            <?php $this->load->view("post/_post_meta", ["post" => $post]); ?>
                                        </p>
                                        <p class="description">
                                            <?php echo html_escape(character_limiter($post->summary, 130, '...')); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                        <?php if ($count == 1): ?>
                        <!--Include banner-->
                        <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "reading_list_top", "class" => "p-b-30"]); ?>
                    <?php endif; ?>

                        <?php $count++; ?>
                    <?php endforeach; ?>


                    <?php if ($count == 0): ?>
                        <p class="text-center">
                            <?php echo trans("text_list_empty"); ?>
                        </p>
                    <?php endif; ?>

                    <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "reading_list_bottom", "class" => ""]); ?>

                    <!-- Pagination -->
                    <div class="col-sm-12 col-xs-12">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
                </div>

            </div>

            <div id="sidebar" class="col-sm-4">
                <!--include sidebar -->
                <?php $this->load->view('partials/_sidebar'); ?>
            </div>

        </div>
    </div>


</div>
<!-- /.Section: wrapper -->