<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$i = 1;
$last_id = 1;
foreach ($latest_posts as $post):
    if ($i == 1) {
        $this->last_visible_post_id = $post->id;
    }
    if ($i > $skip && $i <= $visible_posts_count):
        $this->load->view("post/_post_item_horizontal", ["post" => $post, "show_label" => true]);
        $last_id = $post->id;
    endif;
    $i++;
endforeach; ?>

<input type="hidden" id="load_more_posts_last_id" value="<?php echo $last_id; ?>">

