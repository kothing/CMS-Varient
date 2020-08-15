<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <nav class="nav-breadcrumb" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo lang_base_url(); ?>"><?php echo trans("home"); ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo trans("profile"); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="profile-page-top">
                    <!-- load profile details -->
                    <?php $this->load->view("profile/_profile_user_info"); ?>
                </div>
            </div>
        </div>

        <div class="profile-page">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3">
                    <div class="widget-followers">
                        <div class="widget-head">
                            <h3 class="title"><?php echo trans("following"); ?>&nbsp;(<?php echo count($following); ?>)</h3>
                        </div>
                        <div class="widget-body">
                            <div class="widget-content custom-scrollbar">
                                <div class="row row-followers">
                                    <?php if (!empty($following)):
                                        foreach ($following as $item):?>
                                            <div class="col-sm-2 col-xs-2 col-followers">
                                                <div class="img-follower">
                                                    <a href="<?php echo generate_profile_url($item->slug); ?>">
                                                        <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACwAAAAAAQABAAACAkQBADs=" data-src="<?php echo get_user_avatar($item); ?>" alt="<?php echo html_escape($item->username); ?>" class="img-responsive lazyload">
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endforeach;
                                    endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="widget-followers">
                        <div class="widget-head">
                            <h3 class="title"><?php echo trans("followers"); ?>&nbsp;(<?php echo count($followers); ?>)</h3>
                        </div>
                        <div class="widget-body">
                            <div class="widget-content custom-scrollbar-followers">
                                <div class="row row-followers">
                                    <?php if (!empty($followers)):
                                        foreach ($followers as $item):?>
                                            <div class="col-sm-2 col-xs-2 col-followers">
                                                <div class="img-follower">
                                                    <a href="<?php echo generate_profile_url($item->slug); ?>">
                                                        <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACwAAAAAAQABAAACAkQBADs=" data-src="<?php echo get_user_avatar($item); ?>" alt="<?php echo html_escape($item->username); ?>" class="img-responsive lazyload">
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endforeach;
                                    endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-9">

                    <div class="row">
                        <?php $count = 0; ?>
                        <?php foreach ($posts as $post): ?>

                            <?php if ($count != 0 && $count % 2 == 0): ?>
                                <div class="col-sm-12"></div>
                            <?php endif; ?>

                            <!--include post item-->
                            <?php $this->load->view("post/_post_item_list", ["post" => $post, "show_label" => true]); ?>

                            <?php if ($count == 1): ?>
                                <!--Include banner-->
                                <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "reading_list_top", "class" => "p-b-30"]); ?>
                            <?php endif; ?>

                            <?php $count++; ?>
                        <?php endforeach; ?>

                        <?php if ($count == 0): ?>
                            <p class="text-center">
                                <?php echo trans("no_records_found"); ?>
                            </p>
                        <?php endif; ?>

                        <?php $this->load->view("partials/_ad_spaces", ["ad_space" => "reading_list_bottom", "class" => ""]); ?>

                        <!-- Pagination -->
                        <div class="col-sm-12 col-xs-12">
                            <?php echo $this->pagination->create_links(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Wrapper End-->


