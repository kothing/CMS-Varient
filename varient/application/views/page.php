<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Section: wrapper -->
<div id="wrapper">
    <div class="container">
        <div class="row">

            <!--Check breadcrumb active-->
            <?php if ($page->breadcrumb_active == 1): ?>
                <div class="col-sm-12 page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo lang_base_url(); ?>"><?php echo trans("breadcrumb_home"); ?></a>
                        </li>

                        <li class="breadcrumb-item active"><?php echo html_escape($page->title); ?></li>
                    </ol>
                </div>
            <?php else: ?>
                <div class="col-sm-12 page-breadcrumb"></div>
            <?php endif; ?>

            <div id="content" class="<?php echo ($page->right_column_active == 1) ? 'col-sm-8' : 'col-sm-12'; ?>">

                <div class="row">
                    <!--Check page title active-->
                    <?php if ($page->title_active == 1): ?>
                        <div class="col-sm-12">
                            <h1 class="page-title"><?php echo html_escape($page->title); ?></h1>
                        </div>
                    <?php endif; ?>

                    <div class="col-sm-12">
                        <div class="page-content font-text">
                            <?php echo $page->page_content; ?>
                        </div>
                    </div>
                </div>
            </div>


            <!--Check right column active-->
            <?php if ($page->right_column_active == 1): ?>
                <div id="sidebar" class="col-sm-4">
                    <!--include sidebar -->
                    <?php $this->load->view('partials/_sidebar'); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- /.Section: wrapper -->

<script>
    $(function () {
        $('.page-content iframe').wrap('<div class="embed-responsive embed-responsive-16by9"></div>');
        $('.page-content iframe').addClass('embed-responsive-item');
    });
</script>
