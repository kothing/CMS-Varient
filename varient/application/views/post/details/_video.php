<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<link href="<?php echo base_url(); ?>assets/vendor/plyr/plyr.css" rel="stylesheet"/>
<?php
$video_image = base_url() . $post->image_big;
if (!empty($post->image_url)):
    $video_image = $post->image_url;
endif;
?>
<div class="show-on-page-load">
    <?php if (!empty($post->video_path)): ?>
        <div class="video-player">
            <video id="player" playsinline controls>
                <source src="<?php echo base_url() . $post->video_path; ?>" type="video/mp4">
                <source src="<?php echo base_url() . $post->video_path; ?>" type="video/webm">
            </video>
        </div>
    <?php elseif (strpos($post->video_url, 'www.facebook.com') !== false): ?>
        <div class="post-image post-video">
            <!-- Load Facebook SDK for JavaScript -->
            <div id="fb-root"></div>
            <script async defer src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.2"></script>
            <div class="fb-video"
                 data-href="<?php echo $post->video_url; ?>"
                 data-allowfullscreen="true"
                 data-autoplay="false"
                 data-show-captions="true"></div>
        </div>
    <?php elseif (!empty($post->video_embed_code)): ?>
        <div class="post-image post-video">
            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="<?php echo $post->video_embed_code; ?>" allowfullscreen></iframe>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Plyr JS-->
<script src="<?php echo base_url(); ?>assets/vendor/plyr/plyr.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/plyr/plyr.polyfilled.min.js"></script>
<script>
    const player = new Plyr('#player');
    $(document).ajaxStop(function () {
        const player = new Plyr('#player');
    });
</script>
