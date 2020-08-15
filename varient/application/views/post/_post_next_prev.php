<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-sm-12 post-next-prev">
    <div class="row">
        <div class="col-sm-6 col-xs-12 left">
            <?php if (!empty($previous_post)): ?>
                <p>
                    <span><i class="icon-angle-left" aria-hidden="true"></i><?php echo trans("previous_article"); ?></span>
                </p>
                <h3 class="title">
                    <a href="<?php echo generate_post_url($previous_post); ?>">
                        <?php echo html_escape(character_limiter($previous_post->title, 80, '...')); ?>
                    </a>
                </h3>
            <?php endif; ?>
        </div>
        <div class="col-sm-6 col-xs-12 right">
            <?php if (!empty($next_post)): ?>
                <p>
                    <span><?php echo trans("next_article"); ?><i class="icon-angle-right" aria-hidden="true"></i></span>
                </p>
                <h3 class="title">
                    <a href="<?php echo generate_post_url($next_post); ?>">
                        <?php echo html_escape(character_limiter($next_post->title, 80, '...')); ?>
                    </a>
                </h3>
            <?php endif; ?>
        </div>
    </div>
</div>

