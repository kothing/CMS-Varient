<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Start Footer Section -->
<footer id="footer">
    <div class="container">
        <div class="row footer-widgets">

            <!-- footer widget about-->
            <div class="col-sm-4 col-xs-12">
                <div class="footer-widget f-widget-about">
                    <div class="col-sm-12">
                        <div class="row">
                            <p class="footer-logo">
                                <img src="<?php echo get_logo_footer($this->visual_settings); ?>" alt="logo" class="logo">
                            </p>
                            <p>
                                <?php echo html_escape($this->settings->about_footer); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div><!-- /.col-sm-4 -->

            <!-- footer widget random posts-->
            <div class="col-sm-4 col-xs-12">
                <!--Include footer random posts partial-->
                <?php $this->load->view('partials/_footer_random_posts'); ?>
            </div><!-- /.col-sm-4 -->


            <!-- footer widget follow us-->
            <div class="col-sm-4 col-xs-12">
                <div class="col-sm-12 footer-widget f-widget-follow">
                    <div class="row">
                        <h4 class="title"><?php echo trans("footer_follow"); ?></h4>
                        <ul>
                            <!--Include social media links-->
                            <?php $this->load->view('partials/_social_media_links', ['rss_hide' => false]); ?>
                        </ul>
                    </div>
                </div>
                <?php if ($this->general_settings->newsletter == 1): ?>
                    <!-- newsletter -->
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="widget-newsletter">
                                <p><?php echo html_escape(trans("footer_newsletter")); ?></p>
                                <?php echo form_open('add-to-newsletter'); ?>
                                <div class="newsletter">
                                    <div class="left">
                                        <input type="email" name="email" id="newsletter_email_footer" maxlength="199" placeholder="<?php echo trans("placeholder_email"); ?>" required <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                                    </div>
                                    <div class="right">
                                        <button type="submit" id="btn_subscribe_footer" class="newsletter-button"><?php echo trans("subscribe"); ?></button>
                                    </div>
                                </div>
                                <p id="newsletter">
                                    <?php
                                    if ($this->session->flashdata('news_error')):
                                        echo '<span class="text-danger">' . $this->session->flashdata('news_error') . '</span>';
                                    endif;

                                    if ($this->session->flashdata('news_success')):
                                        echo '<span class="text-success">' . $this->session->flashdata('news_success') . '</span>';
                                    endif;
                                    ?>
                                </p>

                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>


                <?php endif; ?>
            </div>
            <!-- .col-md-3 -->
        </div>
        <!-- .row -->

        <!-- Copyright -->
        <div class="footer-bottom">
            <div class="row">
                <div class="col-md-12">
                    <div class="footer-bottom-left">
                        <p><?php echo html_escape($this->settings->copyright); ?></p>
                    </div>

                    <div class="footer-bottom-right">
                        <ul class="nav-footer">
                            <?php if (!empty($this->menu_links)):
                                foreach ($this->menu_links as $item):
                                    if ($item->item_visibility == 1 && $item->item_location == "footer"):?>
                                        <li>
                                            <a href="<?php echo generate_menu_item_url($item); ?>"><?php echo html_escape($item->item_name); ?> </a>
                                        </li>
                                    <?php endif;
                                endforeach;
                            endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- .row -->
        </div>
    </div>
</footer>
<!-- Scroll Up Link -->
<a href="#" class="scrollup"><i class="icon-arrow-up"></i></a>

<!-- End Footer Section -->
<?php if (!isset($_COOKIE["vr_cookies"]) && $this->settings->cookies_warning): ?>
    <div class="cookies-warning">
        <div class="text"><?php echo $this->settings->cookies_warning_text; ?></div>
        <a href="javascript:void(0)" onclick="hide_cookies_warning();" class="icon-cl"> <i class="icon-close"></i></a>
    </div>
<?php endif; ?>
<script>
    var base_url = '<?php echo base_url(); ?>';var fb_app_id = '<?php echo $this->general_settings->facebook_app_id; ?>';var csfr_token_name = '<?php echo $this->security->get_csrf_token_name(); ?>';var csfr_cookie_name = '<?php echo $this->config->item('csrf_cookie_name'); ?>';var lang_folder = '<?php echo $this->selected_lang->folder_name; ?>';var is_recaptcha_enabled = false;var sweetalert_ok = '<?php echo trans("ok"); ?>';var sweetalert_cancel = '<?php echo trans("cancel"); ?>';<?php if ($this->recaptcha_status == true): ?>is_recaptcha_enabled = true;<?php endif; ?>
</script>
<!-- Plugins-->
<script src="<?php echo base_url(); ?>assets/js/plugins-1.7.js"></script>
<script>
    $(document).ready(function(){$("#featured-slider").slick({autoplay:true,autoplaySpeed:4900,slidesToShow:1,slidesToScroll:1,infinite:true,speed:200,rtl:rtl,swipeToSlide:true,cssEase:"linear",lazyLoad:"progressive",prevArrow:$("#featured-slider-nav .prev"),nextArrow:$("#featured-slider-nav .next"),});$("#random-slider").slick({autoplay:true,autoplaySpeed:4900,slidesToShow:1,slidesToScroll:1,infinite:true,speed:200,rtl:rtl,lazyLoad:"progressive",prevArrow:$("#random-slider-nav .prev"),nextArrow:$("#random-slider-nav .next"),});$("#post-detail-slider").slick({autoplay:false,autoplaySpeed:4900,slidesToShow:1,slidesToScroll:1,infinite:false,speed:200,rtl:rtl,adaptiveHeight:true,lazyLoad:"progressive",prevArrow:$("#post-detail-slider-nav .prev"),nextArrow:$("#post-detail-slider-nav .next"),});$(".main-menu .dropdown").hover(function(){$(".li-sub-category").removeClass("active");$(".sub-menu-inner").removeClass("active");$(".sub-menu-right .filter-all").addClass("active")},function(){});$(".main-menu .navbar-nav .dropdown-menu").hover(function(){var b=$(this).attr("data-mega-ul");if(b!=undefined){$(".main-menu .navbar-nav .dropdown").removeClass("active");$(".mega-li-"+b).addClass("active")}},function(){$(".main-menu .navbar-nav .dropdown").removeClass("active")});$(".li-sub-category").hover(function(){var b=$(this).attr("data-category-filter");$(".li-sub-category").removeClass("active");$(this).addClass("active");$(".sub-menu-right .sub-menu-inner").removeClass("active");$(".sub-menu-right .filter-"+b).addClass("active")},function(){});$(".news-ticker ul li").delay(500).fadeIn(500);$(".news-ticker").easyTicker({direction:"up",easing:"swing",speed:"fast",interval:4000,height:"30",visible:0,mousePause:1,controls:{up:".news-next",down:".news-prev",}});$(window).scroll(function(){if($(this).scrollTop()>100){$(".scrollup").fadeIn()}else{$(".scrollup").fadeOut()}});$(".scrollup").click(function(){$("html, body").animate({scrollTop:0},700);return false});$("form").submit(function(){$("input[name='"+csfr_token_name+"']").val($.cookie(csfr_cookie_name))});$(document).ready(function(){$('[data-toggle-tool="tooltip"]').tooltip()})});$("#form_validate").validate();$("#search_validate").validate();$(document).on("click",".btn-open-mobile-nav",function(){if($("#navMobile").hasClass("nav-mobile-open")){$("#navMobile").removeClass("nav-mobile-open");$("#overlay_bg").hide()}else{$("#navMobile").addClass("nav-mobile-open");$("#overlay_bg").show()}});$(document).on("click","#overlay_bg",function(){$("#navMobile").removeClass("nav-mobile-open");$("#overlay_bg").hide()});$(".close-menu-click").click(function(){$("#navMobile").removeClass("nav-mobile-open");$("#overlay_bg").hide()});$(window).on("load",function(){$(".show-on-page-load").css("visibility","visible")});$(document).ready(function(){$("iframe").attr("allowfullscreen","")});var custom_scrollbar=$(".custom-scrollbar");if(custom_scrollbar.length){var ps=new PerfectScrollbar(".custom-scrollbar",{wheelPropagation:true,suppressScrollX:true})}var custom_scrollbar=$(".custom-scrollbar-followers");if(custom_scrollbar.length){var ps=new PerfectScrollbar(".custom-scrollbar-followers",{wheelPropagation:true,suppressScrollX:true})}$(".search-icon").click(function(){if($(".search-form").hasClass("open")){$(".search-form").removeClass("open");$(".search-icon i").removeClass("icon-times");$(".search-icon i").addClass("icon-search")}else{$(".search-form").addClass("open");$(".search-icon i").removeClass("icon-search");$(".search-icon i").addClass("icon-times")}});$(document).ready(function(){$("#form-login").submit(function(a){a.preventDefault();var b=$(this);var c=b.serializeArray();c.push({name:csfr_token_name,value:$.cookie(csfr_cookie_name)});$.ajax({url:base_url+"auth_controller/login_post",type:"post",data:c,success:function(e){var d=JSON.parse(e);if(d.result==1){location.reload()}else{if(d.result==0){document.getElementById("result-login").innerHTML=d.error_message}}}})})});function make_reaction(c,d,b){var a={post_id:c,reaction:d,lang:b};a[csfr_token_name]=$.cookie(csfr_cookie_name);$.ajax({method:"POST",url:base_url+"home_controller/save_reaction",data:a}).done(function(e){document.getElementById("reactions_result").innerHTML=e})}$(document).ready(function(){$("#make_comment_registered").submit(function(b){b.preventDefault();var c=$(this).serializeArray();var a={};var d=true;$(c).each(function(f,e){if($.trim(e.value).length<1){$("#make_comment_registered [name='"+e.name+"']").addClass("is-invalid");d=false}else{$("#make_comment_registered [name='"+e.name+"']").removeClass("is-invalid");a[e.name]=e.value}});a.limit=$("#post_comment_limit").val();a.lang_folder=lang_folder;a[csfr_token_name]=$.cookie(csfr_cookie_name);if(d==true){$.ajax({type:"POST",url:base_url+"home_controller/add_comment_post",data:a,success:function(f){var e=JSON.parse(f);if(e.type=="message"){document.getElementById("message-comment-result").innerHTML=e.message}else{document.getElementById("comment-result").innerHTML=e.message}$("#make_comment_registered")[0].reset()}})}});$("#make_comment").submit(function(b){b.preventDefault();var c=$(this).serializeArray();var a={};var d=true;$(c).each(function(f,e){if($.trim(e.value).length<1){$("#make_comment [name='"+e.name+"']").addClass("is-invalid");d=false}else{$("#make_comment [name='"+e.name+"']").removeClass("is-invalid");a[e.name]=e.value}});a.limit=$("#post_comment_limit").val();a.lang_folder=lang_folder;a[csfr_token_name]=$.cookie(csfr_cookie_name);if(is_recaptcha_enabled==true){if(typeof a["g-recaptcha-response"]==="undefined"){$(".g-recaptcha").addClass("is-recaptcha-invalid");d=false}else{$(".g-recaptcha").removeClass("is-recaptcha-invalid")}}if(d==true){$(".g-recaptcha").removeClass("is-recaptcha-invalid");$.ajax({type:"POST",url:base_url+"home_controller/add_comment_post",data:a,success:function(f){var e=JSON.parse(f);if(e.type=="message"){document.getElementById("message-comment-result").innerHTML=e.message}else{document.getElementById("comment-result").innerHTML=e.message}if(is_recaptcha_enabled==true){grecaptcha.reset()}$("#make_comment")[0].reset()}})}})});$(document).on("click",".btn-subcomment-registered",function(){var a=$(this).attr("data-comment-id");var b={};b.lang_folder=lang_folder;b[csfr_token_name]=$.cookie(csfr_cookie_name);$("#make_subcomment_registered_"+a).ajaxSubmit({beforeSubmit:function(){var d=$("#make_subcomment_registered_"+a).serializeArray();var c=$.trim(d[0].value);if(c.length<1){$(".form-comment-text").addClass("is-invalid");return false}else{$(".form-comment-text").removeClass("is-invalid")}},type:"POST",url:base_url+"home_controller/add_comment_post",data:b,success:function(d){var c=JSON.parse(d);if(c.type=="message"){document.getElementById("message-subcomment-result-"+a).innerHTML=c.message}else{document.getElementById("comment-result").innerHTML=c.message}$(".visible-sub-comment form").empty()}})});$(document).on("click",".btn-subcomment",function(){var a=$(this).attr("data-comment-id");var b={};b.lang_folder=lang_folder;b[csfr_token_name]=$.cookie(csfr_cookie_name);b.limit=$("#post_comment_limit").val();var c="#make_subcomment_"+a;$(c).ajaxSubmit({beforeSubmit:function(){var d=$("#make_subcomment_"+a).serializeArray();var e=true;$(d).each(function(g,f){if($.trim(f.value).length<1){$(c+" [name='"+f.name+"']").addClass("is-invalid");e=false}else{$(c+" [name='"+f.name+"']").removeClass("is-invalid");b[f.name]=f.value}});if(is_recaptcha_enabled==true){if(typeof b["g-recaptcha-response"]==="undefined"){$(c+" .g-recaptcha").addClass("is-recaptcha-invalid");e=false}else{$(c+" .g-recaptcha").removeClass("is-recaptcha-invalid")}}if(e==false){return false}},type:"POST",url:base_url+"home_controller/add_comment_post",data:b,success:function(e){if(is_recaptcha_enabled==true){grecaptcha.reset()}var d=JSON.parse(e);if(d.type=="message"){document.getElementById("message-subcomment-result-"+a).innerHTML=d.message}else{document.getElementById("comment-result").innerHTML=d.message}$(".visible-sub-comment form").empty()}})});function load_more_comment(c){var b=parseInt($("#post_comment_limit").val());var a={post_id:c,limit:b};a.lang_folder=lang_folder;a[csfr_token_name]=$.cookie(csfr_cookie_name);$("#load_comment_spinner").show();$.ajax({type:"POST",url:base_url+"home_controller/load_more_comment",data:a,success:function(d){setTimeout(function(){$("#load_comment_spinner").hide();var e=JSON.parse(d);if(e.result==1){document.getElementById("comment-result").innerHTML=e.html_content}},1000)}})}function delete_comment(a,c,b){swal({text:b,icon:"warning",buttons:[sweetalert_cancel,sweetalert_ok],dangerMode:true,}).then(function(f){if(f){var e=parseInt($("#post_comment_limit").val());var d={id:a,post_id:c,limit:e};d.lang_folder=lang_folder;d[csfr_token_name]=$.cookie(csfr_cookie_name);$.ajax({type:"POST",url:base_url+"home_controller/delete_comment_post",data:d,success:function(h){var g=JSON.parse(h);if(g.result==1){document.getElementById("comment-result").innerHTML=g.html_content}}})}})}function show_comment_box(a){if($("#sub_comment_form_"+a).html().length>0){$("#sub_comment_form_"+a).empty()}else{$(".visible-sub-comment").empty();var c=parseInt($("#post_comment_limit").val());var b={comment_id:a,limit:c};b.lang_folder=lang_folder;b[csfr_token_name]=$.cookie(csfr_cookie_name);$.ajax({type:"POST",url:base_url+"home_controller/load_subcomment_box",data:b,success:function(d){$("#sub_comment_form_"+a).append(d)}})}}function like_comment(b){var c=parseInt($("#post_comment_limit").val());var a={id:b,limit:c};a[csfr_token_name]=$.cookie(csfr_cookie_name);$.ajax({type:"POST",url:base_url+"home_controller/like_comment_post",data:a,success:function(e){var d=JSON.parse(e);if(d.result==1){document.getElementById("lbl_comment_like_count_"+b).innerHTML=d.like_count}}})}function dislike_comment(b){var c=parseInt($("#post_comment_limit").val());var a={id:b,limit:c};a[csfr_token_name]=$.cookie(csfr_cookie_name);$.ajax({type:"POST",url:base_url+"home_controller/dislike_comment_post",data:a,success:function(e){var d=JSON.parse(e);if(d.result==1){document.getElementById("lbl_comment_like_count_"+b).innerHTML=d.like_count}}})}function view_poll_results(b){$("#poll_"+b+" .question").hide();$("#poll_"+b+" .result").show()}function view_poll_options(b){$("#poll_"+b+" .result").hide();$("#poll_"+b+" .question").show()}$(document).ready(function(){var b;$(".poll-form").submit(function(h){h.preventDefault();if(b){b.abort()}var a=$(this);var g=a.find("input, select, button, textarea");var j=a.serializeArray();j.push({name:csfr_token_name,value:$.cookie(csfr_cookie_name)});var i=$(this).attr("data-form-id");b=$.ajax({url:base_url+"home_controller/add_vote",type:"post",data:j,});b.done(function(c){g.prop("disabled",false);if(c=="required"){$("#poll-required-message-"+i).show();$("#poll-error-message-"+i).hide()}else{if(c=="voted"){$("#poll-required-message-"+i).hide();$("#poll-error-message-"+i).show()}else{document.getElementById("poll-results-"+i).innerHTML=c;$("#poll_"+i+" .result").show();$("#poll_"+i+" .question").hide()}}})})});function add_delete_from_reading_list(b){$(".tooltip").hide();var a={post_id:b,};a[csfr_token_name]=$.cookie(csfr_cookie_name);$.ajax({type:"POST",url:base_url+"ajax_controller/add_delete_reading_list_post",data:a,success:function(c){location.reload()}})}function load_more_posts(){$(".btn-load-more").prop("disabled",true);$("#load_posts_spinner").show();var c=parseInt($("#load_more_posts_last_id").val());var b=parseInt($("#load_more_posts_lang_id").val());var a={load_more_posts_last_id:c,load_more_posts_lang_id:b};a[csfr_token_name]=$.cookie(csfr_cookie_name);$.ajax({type:"POST",url:base_url+"home_controller/load_more_posts",data:a,success:function(e){var d=JSON.parse(e);if(d.result==1){setTimeout(function(){$("#last_posts_content").append(d.html_content);$("#load_more_posts_last_id").val(d.last_id);$("#load_posts_spinner").hide();$(".btn-load-more").prop("disabled",false);if(d.hide_button){$(".btn-load-more").hide()}},300)}else{setTimeout(function(){$("#load_more_posts_last_id").val(d.last_id);$("#load_posts_spinner").hide();$(".btn-load-more").hide()},300)}}})}function load_more_comments(f){var e=parseInt($("#vr_comment_limit").val());var d={post_id:f,limit:e,};d[csfr_token_name]=$.cookie(csfr_cookie_name);$("#load_comments_spinner").show();$.ajax({method:"POST",url:base_url+"home_controller/load_more_comments",data:d}).done(function(a){setTimeout(function(){$("#load_comments_spinner").hide();$("#vr_comment_limit").val(e+5);document.getElementById("comment-result").innerHTML=a},500)})}$(document).on("click",".widget-popular-posts .btn-nav-tab",function(){$(".widget-popular-posts .loader-popular-posts").show();var b=$(this).attr("data-date-type");var c=$(this).attr("data-lang-id");var a={date_type:b,lang_id:c};a[csfr_token_name]=$.cookie(csfr_cookie_name);$.ajax({type:"POST",url:base_url+"ajax_controller/get_popular_posts",data:a,success:function(e){var d=JSON.parse(e);if(d.result==1){setTimeout(function(){document.getElementById("tab_popular_posts_response").innerHTML=d.html_content;$(".widget-popular-posts .loader-popular-posts").hide()},500)}$(".widget-popular-posts .loader-popular-posts").hide()}})});$(document).on("click",".visual-color-box",function(){var a=$(this).attr("data-color");$(".visual-color-box").empty();$(this).html('<i class="icon-check"></i>');$("#input_user_site_color").val(a)});function hide_cookies_warning(){$(".cookies-warning").hide();var a={};a[csfr_token_name]=$.cookie(csfr_cookie_name);$.ajax({type:"POST",url:base_url+"home_controller/cookies_warning",data:a,success:function(b){}})}$("#print_post").on("click",function(){$(".post-content .title, .post-content .post-meta, .post-content .post-image, .post-content .post-text").printThis({importCSS:true,})});$(document).ajaxStop(function(){function d(a){$("#poll_"+a+" .question").hide();$("#poll_"+a+" .result").show()}function c(a){$("#poll_"+a+" .result").hide();$("#poll_"+a+" .question").show()}});$(document).ready(function(){$(".validate_terms").submit(function(a){if(!$(".checkbox_terms_conditions").is(":checked")){a.preventDefault();$(".custom-checkbox .checkbox-icon").addClass("is-invalid")}else{$(".custom-checkbox .checkbox-icon").removeClass("is-invalid")}})});$(document).ready(function(){$(".post-content .post-text table").each(function(){table=$(this);tableRow=table.find("tr");table.find("td").each(function(){tdIndex=$(this).index();if($(tableRow).find("th").eq(tdIndex).attr("data-label")){thText=$(tableRow).find("th").eq(tdIndex).data("label")}else{thText=$(tableRow).find("th").eq(tdIndex).text()}$(this).attr("data-label",thText)})})});$(document).ready(function(){$(".gallery-post-buttons a").css("opacity","1")});$(document).ready(function(b){b(".image-popup-single").magnificPopup({type:"image",titleSrc:function(a){return a.el.attr("title")+"<small></small>"},image:{verticalFit:true,},gallery:{enabled:false,navigateByImgClick:true,preload:[0,1]},removalDelay:100,fixedContentPos:true,})});$(document).on("click","#btn_subscribe_footer",function(){var a=$("#newsletter_email_footer").val();$("#newsletter_email_modal").val(a);$("#modal_newsletter").modal("show")});
</script>
<?php $hours = date_difference_in_hours(date('Y-m-d H:i:s'), $this->general_settings->last_popular_post_update);
if (empty($this->general_settings->last_popular_post_update) || $hours > 6):?>
    <script>var data_popular = {};data_popular[csfr_token_name] = $.cookie(csfr_cookie_name);$.ajax({type: "POST", url: base_url + "delete-old-pageviews", data: data_popular});</script>
<?php endif; ?>
<?php echo $this->general_settings->google_analytics; ?>
<?php echo $this->general_settings->adsense_activation_code; ?>
<?php echo $this->general_settings->custom_javascript_codes; ?>
</body>
</html>