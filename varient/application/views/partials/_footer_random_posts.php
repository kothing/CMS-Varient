<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!--Partial: Footer Random Posts-->
<div class="footer-widget f-widget-random">
    <div class="col-sm-12">
        <div class="row">
            <h4 class="title"><?php echo html_escape(trans("footer_random_posts")); ?></h4>
            <div class="title-line"></div>
            <ul class="f-random-list">
                <!--List random posts-->
                <?php if (!empty($this->random_posts)):
                    $i = 0;
                    foreach (array_reverse($this->random_posts) as $item):
                        if ($i < 3):?>
                            <li class="<?php echo check_post_img($item, 'class'); ?>">
                                <?php if (check_post_img($item)): ?>
                                    <div class="list-left">
                                        <a href="<?php echo generate_post_url($item); ?>">
                                            <?php $this->load->view("post/_post_image", ["post_item" => $item, "type" => "small"]); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <div class="list-right">
                                    <h5 class="title">
                                        <a href="<?php echo generate_post_url($item); ?>">
                                            <?php echo html_escape(character_limiter($item->title, 55, '...')); ?>
                                        </a>
                                    </h5>
                                </div>
                            </li>
                        <?php endif;
                        $i++;
                    endforeach;
                endif; ?>
            </ul>
        </div>
    </div>
</div>
