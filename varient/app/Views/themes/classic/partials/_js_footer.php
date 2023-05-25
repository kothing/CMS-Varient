<?php if (!empty($jsPage) && $jsPage == 'gallery'): ?>
    <script src="<?= base_url('assets/vendor/masonry-filter/imagesloaded.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/masonry-filter/masonry-3.1.4.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/masonry-filter/masonry.filter.js'); ?>"></script>
    <script>
        var start_from_left = true;
        if (rtl == true) {
            start_from_left = false;
        }
        $(document).ready(function (t) {
            t(".image-popup").magnificPopup({
                type: "image", titleSrc: function (t) {
                    return t.el.attr("title") + "<small></small>"
                }, image: {verticalFit: !0}, gallery: {enabled: !0, navigateByImgClick: !0, preload: [0, 1]}, removalDelay: 100, fixedContentPos: !0
            })
        }), $(document).ready(function () {
            $(document).on("click touchstart", ".filters .btn", function () {
                $(".filters .btn").removeClass("active"), $(this).addClass("active")
            }), $(function () {
                var i = $("#masonry");
                i.imagesLoaded(function () {
                    i.masonry({gutterWidth: 0, isAnimated: !0, itemSelector: ".gallery-item", isOriginLeft: start_from_left})
                }), $(".filters .btn").click(function (t) {
                    t.preventDefault();
                    var e = $(this).attr("data-filter");
                    i.masonryFilter({
                        filter: function () {
                            return !e || $(this).attr("data-filter") == e
                        }
                    })
                })
            })
        });
    </script>
<?php endif;
if (!empty($post) && ($post->post_type == 'trivia_quiz' || $post->post_type == 'personality_quiz')): ?>
    <script src="<?= base_url('assets/vendor/quiz/quiz-2.0.min.js'); ?>"></script>
    <script>
        $(document).ready(function () {
            getQuizAnswers('<?= $post->id; ?>');
            getQuizResults('<?= $post->id; ?>');
        });
    </script>
<?php endif;
if (!empty($post) && $post->post_type == "video"): ?>
    <script src="<?= base_url('assets/vendor/plyr/plyr.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/plyr/plyr.polyfilled.min.js'); ?>"></script>
    <script>
        const player = new Plyr('#player');
        $(document).ajaxStop(function () {
            const player = new Plyr('#player');
        });
    </script>
<?php endif;
if (checkNewsletterModal()):?>
<script>$(window).on('load', function () {$('#modal_newsletter').modal('show');});</script>
<?php endif; ?>


