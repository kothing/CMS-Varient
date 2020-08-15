<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!--Widget: Custom-->
<div class="sidebar-widget">
    <div class="widget-head">
        <h4 class="title"><?php echo html_escape($widget->title); ?></h4>
    </div>
    <div class="widget-body">
        <?php echo $widget->content; ?>
    </div>
</div>

