<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!--Check list type-->
<?php if ($this->visual_settings->post_list_style == "vertical"): ?>
    <!--Post row item-->
    <div class="col-sm-6 col-xs-12">
        <?php $this->load->view("post/_post_item"); ?>
    </div>
<?php else: ?>
    <?php $this->load->view("post/_post_item_horizontal"); ?>
<?php endif; ?>


