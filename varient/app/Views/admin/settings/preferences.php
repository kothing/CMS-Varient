<?php $tab = inputGet('tab');
if ($tab != "general" && $tab != "homepage" && $tab != "posts" && $tab != "post_formats") {
    $tab = "general";
} ?>
<div class="row" style="margin-bottom: 15px;">
    <div class="col-sm-12">
        <h3 style="font-size: 18px; font-weight: 600;margin-top: 10px;"><?= trans('preferences'); ?></h3>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <form action="<?= base_url('AdminController/preferencesPost'); ?>" method="post">
            <?= csrf_field(); ?>
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="<?= $tab == "general" ? 'active' : ''; ?>"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><?= trans('general'); ?></a></li>
                    <li class="<?= $tab == "homepage" ? 'active' : ''; ?>"><a href="#tab_2" data-toggle="tab" aria-expanded="false"><?= trans('homepage'); ?></a></li>
                    <li class="<?= $tab == "posts" ? 'active' : ''; ?>"><a href="#tab_3" data-toggle="tab" aria-expanded="false"><?= trans('posts'); ?></a></li>
                    <li class="<?= $tab == "post_formats" ? 'active' : ''; ?>"><a href="#tab_4" data-toggle="tab" aria-expanded="false"><?= trans('post_formats'); ?></a></li>
                </ul>
                <div class="tab-content settings-tab-content">
                    <div class="tab-pane <?= empty($tab) || $tab == "general" ? 'active' : ''; ?>" id="tab_1">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?= trans('multilingual_system'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                    <input type="radio" name="multilingual_system" value="1" id="multilingual_system_1" class="square-purple" <?= $generalSettings->multilingual_system == 1 ? 'checked' : ''; ?>>
                                    <label for="multilingual_system_1" class="option-label"><?= trans('enable'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-7 col-xs-12 col-option">
                                    <input type="radio" name="multilingual_system" value="0" id="multilingual_system_2" class="square-purple" <?= $generalSettings->multilingual_system != 1 ? 'checked' : ''; ?>>
                                    <label for="multilingual_system_2" class="option-label"><?= trans('disable'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?= trans('registration_system'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                    <input type="radio" name="registration_system" value="1" id="registration_system_1" class="square-purple" <?= $generalSettings->registration_system == 1 ? 'checked' : ''; ?>>
                                    <label for="registration_system_1" class="option-label"><?= trans('enable'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-7 col-xs-12 col-option">
                                    <input type="radio" name="registration_system" value="0" id="registration_system_2" class="square-purple" <?= $generalSettings->registration_system != 1 ? 'checked' : ''; ?>>
                                    <label for="registration_system_2" class="option-label"><?= trans('disable'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?= trans('rss'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                    <input type="radio" id="show_rss_1" name="show_rss" value="1" class="square-purple" <?= $generalSettings->show_rss == "1" ? 'checked' : ''; ?>>
                                    <label for="show_rss_1" class="cursor-pointer"><?= trans('enable'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-7 col-xs-12 col-option">
                                    <input type="radio" id="show_rss_2" name="show_rss" value="0" class="square-purple" <?= $generalSettings->show_rss != "1" ? 'checked' : ''; ?>>
                                    <label for="show_rss_2" class="cursor-pointer"><?= trans('disable'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?= trans('rss_content'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                    <input type="radio" id="rss_content_1" name="rss_content_type" value="summary" class="square-purple" <?= $generalSettings->rss_content_type == 'summary' ? 'checked' : ''; ?>>
                                    <label for="rss_content_1" class="cursor-pointer"><?= trans('distribute_only_post_summary'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-7 col-xs-12 col-option">
                                    <input type="radio" id="rss_content_2" name="rss_content_type" value="content" class="square-purple" <?= $generalSettings->rss_content_type == 'content' ? 'checked' : ''; ?>>
                                    <label for="rss_content_2" class="cursor-pointer"><?= trans('distribute_post_content'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?= trans('file_manager'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                    <input type="radio" id="file_manager_show_files_1" name="file_manager_show_files" value="1" class="square-purple" <?= $generalSettings->file_manager_show_files == "1" ? 'checked' : ''; ?>>
                                    <label for="file_manager_show_files_1" class="cursor-pointer"><?= trans('show_all_files'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-7 col-xs-12 col-option">
                                    <input type="radio" id="file_manager_show_files_2" name="file_manager_show_files" value="0" class="square-purple" <?= $generalSettings->file_manager_show_files != "1" ? 'checked' : ''; ?>>
                                    <label for="file_manager_show_files_2" class="cursor-pointer"><?= trans('show_only_own_files'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?= trans('audio_download_button'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                    <input type="radio" id="audio_download_button_1" name="audio_download_button" value="1" class="square-purple" <?= $generalSettings->audio_download_button == "1" ? 'checked' : ''; ?>>
                                    <label for="audio_download_button_1" class="cursor-pointer"><?= trans('enable'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-7 col-xs-12 col-option">
                                    <input type="radio" id="audio_download_button_2" name="audio_download_button" value="0" class="square-purple" <?= $generalSettings->audio_download_button != "1" ? 'checked' : ''; ?>>
                                    <label for="audio_download_button_2" class="cursor-pointer"><?= trans('disable'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?= trans('show_user_email_profile'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                    <input type="radio" id="show_user_email_on_profile_1" name="show_user_email_on_profile" value="1" class="square-purple" <?= $generalSettings->show_user_email_on_profile == "1" ? 'checked' : ''; ?>>
                                    <label for="show_user_email_on_profile_1" class="cursor-pointer"><?= trans('yes'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-7 col-xs-12 col-option">
                                    <input type="radio" id="show_user_email_on_profile_2" name="show_user_email_on_profile" value="0" class="square-purple" <?= $generalSettings->show_user_email_on_profile != "1" ? 'checked' : ''; ?>>
                                    <label for="show_user_email_on_profile_2" class="cursor-pointer"><?= trans('no'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label>Progressive Web App (PWA)</label>
                                </div>
                                <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                    <input type="radio" id="pwa_status_1" name="pwa_status" value="1" class="square-purple" <?= $generalSettings->pwa_status == "1" ? 'checked' : ''; ?>>
                                    <label for="pwa_status_1" class="cursor-pointer"><?= trans('enable'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-7 col-xs-12 col-option">
                                    <input type="radio" id="pwa_status_2" name="pwa_status" value="0" class="square-purple" <?= $generalSettings->pwa_status != "1" ? 'checked' : ''; ?>>
                                    <label for="pwa_status_2" class="cursor-pointer"><?= trans('disable'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="alert alert-info alert-large m-t-10">
                                        <strong><?= trans("warning"); ?>!</strong>&nbsp;&nbsp;<?= trans("pwa_warning"); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-right" style="margin-top: 60px;">
                            <button type="submit" name="submit" value="general" class="btn btn-primary"><?= trans('save_changes'); ?></button>
                        </div>
                    </div>

                    <div class="tab-pane <?= $tab == "homepage" ? 'active' : ''; ?>" id="tab_2">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?= trans('show_featured_section'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                    <input type="radio" name="show_featured_section" value="1" id="show_featured_section_1" class="square-purple" <?= $generalSettings->show_featured_section == 1 ? 'checked' : ''; ?>>
                                    <label for="show_featured_section_1" class="option-label"><?= trans('yes'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-7 col-xs-12 col-option">
                                    <input type="radio" name="show_featured_section" value="0" id="show_featured_section_2" class="square-purple" <?= $generalSettings->show_featured_section != 1 ? 'checked' : ''; ?>>
                                    <label for="show_featured_section_2" class="option-label"><?= trans('no'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?= trans('show_latest_posts_homepage'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                    <input type="radio" name="show_latest_posts" value="1" id="show_latest_posts_1" class="square-purple" <?= $generalSettings->show_latest_posts == 1 ? 'checked' : ''; ?>>
                                    <label for="show_latest_posts_1" class="option-label"><?= trans('yes'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-7 col-xs-12 col-option">
                                    <input type="radio" name="show_latest_posts" value="0" id="show_latest_posts_2" class="square-purple" <?= $generalSettings->show_latest_posts != 1 ? 'checked' : ''; ?>>
                                    <label for="show_latest_posts_2" class="option-label"><?= trans('no'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?= trans('show_news_ticker'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                    <input type="radio" id="show_newsticker_1" name="show_newsticker" value="1" class="square-purple" <?= $generalSettings->show_newsticker == "1" ? 'checked' : ''; ?>>
                                    <label for="show_newsticker_1" class="cursor-pointer"><?= trans('yes'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-7 col-xs-12 col-option">
                                    <input type="radio" id="show_newsticker_2" name="show_newsticker" value="0" class="square-purple" <?= $generalSettings->show_newsticker == "0" || $generalSettings->show_newsticker == null ? 'checked' : ''; ?>>
                                    <label for="show_newsticker_2" class="cursor-pointer"><?= trans('no'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?= trans('show_latest_posts_on_slider'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                    <input type="radio" id="show_latest_posts_on_slider_1" name="show_latest_posts_on_slider" value="1" class="square-purple" <?= $generalSettings->show_latest_posts_on_slider == 1 ? 'checked' : ''; ?>>
                                    <label for="show_latest_posts_on_slider_1" class="cursor-pointer"><?= trans('yes'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-7 col-xs-12 col-option">
                                    <input type="radio" id="show_latest_posts_on_slider_2" name="show_latest_posts_on_slider" value="0" class="square-purple" <?= $generalSettings->show_latest_posts_on_slider != 1 ? 'checked' : ''; ?>>
                                    <label for="show_latest_posts_on_slider_2" class="cursor-pointer"><?= trans('no'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?= trans('show_latest_posts_on_featured'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                    <input type="radio" id="show_latest_posts_on_featured_1" name="show_latest_posts_on_featured" value="1" class="square-purple" <?= $generalSettings->show_latest_posts_on_featured == 1 ? 'checked' : ''; ?>>
                                    <label for="show_latest_posts_on_featured_1" class="cursor-pointer"><?= trans('yes'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-7 col-xs-12 col-option">
                                    <input type="radio" id="show_latest_posts_on_featured_2" name="show_latest_posts_on_featured" value="0" class="square-purple" <?= $generalSettings->show_latest_posts_on_featured != 1 ? 'checked' : ''; ?>>
                                    <label for="show_latest_posts_on_featured_2" class="cursor-pointer"><?= trans('no'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?= trans('sort_slider_posts'); ?></label>
                                </div>
                                <?php if ($generalSettings->show_latest_posts_on_slider != 1): ?>
                                    <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                        <input type="radio" id="sort_slider_posts_1" name="sort_slider_posts" value="by_slider_order" class="square-purple" <?= $generalSettings->sort_slider_posts == "by_slider_order" ? 'checked' : ''; ?>>
                                        <label for="sort_slider_posts_1" class="cursor-pointer"><?= trans('by_slider_order'); ?></label>
                                    </div>
                                    <div class="col-sm-6 col-md-7 col-xs-12 col-option">
                                        <input type="radio" id="sort_slider_posts_2" name="sort_slider_posts" value="by_date" class="square-purple" <?= $generalSettings->sort_slider_posts == "by_date" ? 'checked' : ''; ?>>
                                        <label for="sort_slider_posts_2" class="cursor-pointer"><?= trans('by_date'); ?></label>
                                    </div>
                                <?php else: ?>
                                    <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                        <input type="radio" id="sort_slider_posts_2" name="sort_slider_posts" value="by_date" class="square-purple" checked>
                                        <label for="sort_slider_posts_2" class="cursor-pointer"><?= trans('by_date'); ?></label>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?= trans('sort_featured_posts'); ?></label>
                                </div>
                                <?php if ($generalSettings->show_latest_posts_on_featured != 1): ?>
                                    <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                        <input type="radio" id="sort_featured_posts_1" name="sort_featured_posts" value="by_featured_order" class="square-purple" <?= $generalSettings->sort_featured_posts == "by_featured_order" ? 'checked' : ''; ?>>
                                        <label for="sort_featured_posts_1" class="cursor-pointer"><?= trans('by_featured_order'); ?></label>
                                    </div>
                                    <div class="col-sm-6 col-md-7 col-xs-12 col-option">
                                        <input type="radio" id="sort_featured_posts_2" name="sort_featured_posts" value="by_date" class="square-purple" <?= $generalSettings->sort_featured_posts == "by_date" ? 'checked' : ''; ?>>
                                        <label for="sort_featured_posts_2" class="cursor-pointer"><?= trans('by_date'); ?></label>
                                    </div>
                                <?php else: ?>
                                    <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                        <input type="radio" id="sort_featured_posts_2" name="sort_featured_posts" value="by_date" class="square-purple" checked>
                                        <label for="sort_featured_posts_2" class="cursor-pointer"><?= trans('by_date'); ?></label>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group text-right" style="margin-top: 60px;">
                            <button type="submit" name="submit" value="homepage" class="btn btn-primary"><?= trans('save_changes'); ?></button>
                        </div>
                    </div>

                    <div class="tab-pane <?= $tab == "posts" ? 'active' : ''; ?>" id="tab_3">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?= trans('post_url_structure'); ?>&nbsp;<small class="text-muted">(<?= trans('post_url_structure_exp'); ?>)</small></label>
                                </div>
                                <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                    <input type="radio" name="post_url_structure" value="slug" id="post_url_structure_1" class="square-purple" <?= $generalSettings->post_url_structure == 'slug' ? 'checked' : ''; ?>>
                                    <label for="post_url_structure_1" class="option-label"><?= trans('post_url_structure_slug'); ?>&nbsp;(domain.com/slug)</label>
                                </div>
                                <div class="col-sm-6 col-md-7 col-xs-12 col-option">
                                    <input type="radio" name="post_url_structure" value="id" id="post_url_structure_2" class="square-purple" <?= $generalSettings->post_url_structure == 'id' ? 'checked' : ''; ?>>
                                    <label for="post_url_structure_2" class="option-label"><?= trans('post_url_structur_id'); ?>&nbsp;(domain.com/id)</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?= trans('comment_system'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                    <input type="radio" name="comment_system" value="1" id="comment_system_1" class="square-purple" <?= $generalSettings->comment_system == 1 ? 'checked' : ''; ?>>
                                    <label for="comment_system_1" class="option-label"><?= trans('enable'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-7 col-xs-12 col-option">
                                    <input type="radio" name="comment_system" value="0" id="comment_system_2" class="square-purple" <?= $generalSettings->comment_system != 1 ? 'checked' : ''; ?>>
                                    <label for="comment_system_2" class="option-label"><?= trans('disable'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?= trans('comment_approval_system'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                    <input type="radio" name="comment_approval_system" value="1" id="comment_approval_system_1" class="square-purple" <?= $generalSettings->comment_approval_system == 1 ? 'checked' : ''; ?>>
                                    <label for="comment_approval_system_1" class="option-label"><?= trans('enable'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-7 col-xs-12 col-option">
                                    <input type="radio" name="comment_approval_system" value="0" id="comment_approval_system_2" class="square-purple" <?= $generalSettings->comment_approval_system != 1 ? 'checked' : ''; ?>>
                                    <label for="comment_approval_system_2" class="option-label"><?= trans('disable'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?= trans('emoji_reactions'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                    <input type="radio" id="emoji_reactions_1" name="emoji_reactions" value="1" class="square-purple" <?= $generalSettings->emoji_reactions == "1" ? 'checked' : ''; ?>>
                                    <label for="emoji_reactions_1" class="cursor-pointer"><?= trans('enable'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-7 col-xs-12 col-option">
                                    <input type="radio" id="emoji_reactions_2" name="emoji_reactions" value="0" class="square-purple" <?= $generalSettings->emoji_reactions != "1" ? 'checked' : ''; ?>>
                                    <label for="emoji_reactions_2" class="cursor-pointer"><?= trans('disable'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?= trans('show_post_author'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                    <input type="radio" name="show_post_author" value="1" id="show_post_author_1" class="square-purple" <?= $generalSettings->show_post_author == 1 ? 'checked' : ''; ?>>
                                    <label for="show_post_author_1" class="option-label"><?= trans('yes'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-7 col-xs-12 col-option">
                                    <input type="radio" name="show_post_author" value="0" id="show_post_author_2" class="square-purple" <?= $generalSettings->show_post_author != 1 ? 'checked' : ''; ?>>
                                    <label for="show_post_author_2" class="option-label"><?= trans('no'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?= trans('show_post_dates'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                    <input type="radio" name="show_post_date" value="1" id="show_post_date_1" class="square-purple" <?= $generalSettings->show_post_date == 1 ? 'checked' : ''; ?>>
                                    <label for="show_post_date_1" class="option-label"><?= trans('yes'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-7 col-xs-12 col-option">
                                    <input type="radio" name="show_post_date" value="0" id="show_post_date_2" class="square-purple" <?= $generalSettings->show_post_date != 1 ? 'checked' : ''; ?>>
                                    <label for="show_post_date_2" class="option-label"><?= trans('no'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?= trans('show_post_view_counts'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                    <input type="radio" id="show_hits_1" name="show_hits" value="1" class="square-purple" <?= $generalSettings->show_hits == "1" ? 'checked' : ''; ?>>
                                    <label for="show_hits_1" class="cursor-pointer"><?= trans('yes'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-7 col-xs-12 col-option">
                                    <input type="radio" id="show_hits_2" name="show_hits" value="0" class="square-purple" <?= $generalSettings->show_hits != "1" ? 'checked' : ''; ?>>
                                    <label for="show_hits_2" class="cursor-pointer"><?= trans('no'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?= trans('approve_added_user_posts'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                    <input type="radio" id="approve_added_user_posts_1" name="approve_added_user_posts" value="1" class="square-purple" <?= $generalSettings->approve_added_user_posts == "1" ? 'checked' : ''; ?>>
                                    <label for="approve_added_user_posts_1" class="cursor-pointer"><?= trans('yes'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-7 col-xs-12 col-option">
                                    <input type="radio" id="approve_added_user_posts_2" name="approve_added_user_posts" value="0" class="square-purple" <?= $generalSettings->approve_added_user_posts != "1" ? 'checked' : ''; ?>>
                                    <label for="approve_added_user_posts_2" class="cursor-pointer"><?= trans('no'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?= trans('approve_updated_user_posts'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                    <input type="radio" id="approve_updated_user_posts_1" name="approve_updated_user_posts" value="1" class="square-purple" <?= $generalSettings->approve_updated_user_posts == "1" ? 'checked' : ''; ?>>
                                    <label for="approve_updated_user_posts_1" class="cursor-pointer"><?= trans('yes'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-7 col-xs-12 col-option">
                                    <input type="radio" id="approve_updated_user_posts_2" name="approve_updated_user_posts" value="0" class="square-purple" <?= $generalSettings->approve_updated_user_posts != "1" ? 'checked' : ''; ?>>
                                    <label for="approve_updated_user_posts_2" class="cursor-pointer"><?= trans('no'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?= trans('redirect_rss_posts_to_original'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                    <input type="radio" id="redirect_rss_posts_to_original_1" name="redirect_rss_posts_to_original" value="1" class="square-purple" <?= $generalSettings->redirect_rss_posts_to_original == "1" ? 'checked' : ''; ?>>
                                    <label for="redirect_rss_posts_to_original_1" class="cursor-pointer"><?= trans('yes'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-7 col-xs-12 col-option">
                                    <input type="radio" id="redirect_rss_posts_to_original_2" name="redirect_rss_posts_to_original" value="0" class="square-purple" <?= $generalSettings->redirect_rss_posts_to_original != "1" ? 'checked' : ''; ?>>
                                    <label for="redirect_rss_posts_to_original_2" class="cursor-pointer"><?= trans('no'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label class="control-label"><?= trans('pagination_number_posts'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                    <input type="number" class="form-control" name="pagination_per_page" value="<?= $generalSettings->pagination_per_page; ?>" min="1" max="3000" required style="max-width: 450px;">
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-right" style="margin-top: 60px;">
                            <button type="submit" name="submit" value="posts" class="btn btn-primary"><?= trans('save_changes'); ?></button>
                        </div>
                    </div>

                    <div class="tab-pane <?= $tab == "post_formats" ? 'active' : ''; ?>" id="tab_4">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?= trans('article'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                    <input type="radio" name="post_format_article" value="1" id="post_format_article_1" class="square-purple" <?= $generalSettings->post_format_article == 1 ? 'checked' : ''; ?>>
                                    <label for="post_format_article_1" class="option-label"><?= trans('enable'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-7 col-xs-12 col-option">
                                    <input type="radio" name="post_format_article" value="0" id="post_format_article_2" class="square-purple" <?= $generalSettings->post_format_article != 1 ? 'checked' : ''; ?>>
                                    <label for="post_format_article_2" class="option-label"><?= trans('disable'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?= trans('gallery'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                    <input type="radio" name="post_format_gallery" value="1" id="post_format_gallery_1" class="square-purple" <?= $generalSettings->post_format_gallery == 1 ? 'checked' : ''; ?>>
                                    <label for="post_format_gallery_1" class="option-label"><?= trans('enable'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-7 col-xs-12 col-option">
                                    <input type="radio" name="post_format_gallery" value="0" id="post_format_gallery_2" class="square-purple" <?= $generalSettings->post_format_gallery != 1 ? 'checked' : ''; ?>>
                                    <label for="post_format_gallery_2" class="option-label"><?= trans('disable'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?= trans('sorted_list'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                    <input type="radio" name="post_format_sorted_list" value="1" id="post_format_sorted_list_1" class="square-purple" <?= $generalSettings->post_format_sorted_list == 1 ? 'checked' : ''; ?>>
                                    <label for="post_format_sorted_list_1" class="option-label"><?= trans('enable'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-7 col-xs-12 col-option">
                                    <input type="radio" name="post_format_sorted_list" value="0" id="post_format_sorted_list_2" class="square-purple" <?= $generalSettings->post_format_sorted_list != 1 ? 'checked' : ''; ?>>
                                    <label for="post_format_sorted_list_2" class="option-label"><?= trans('disable'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?= trans('video'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                    <input type="radio" name="post_format_video" value="1" id="post_format_video_1" class="square-purple" <?= $generalSettings->post_format_video == 1 ? 'checked' : ''; ?>>
                                    <label for="post_format_video_1" class="option-label"><?= trans('enable'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-7 col-xs-12 col-option">
                                    <input type="radio" name="post_format_video" value="0" id="post_format_video_2" class="square-purple" <?= $generalSettings->post_format_video != 1 ? 'checked' : ''; ?>>
                                    <label for="post_format_video_2" class="option-label"><?= trans('disable'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?= trans('audio'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                    <input type="radio" name="post_format_audio" value="1" id="post_format_audio_1" class="square-purple" <?= $generalSettings->post_format_audio == 1 ? 'checked' : ''; ?>>
                                    <label for="post_format_audio_1" class="option-label"><?= trans('enable'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-7 col-xs-12 col-option">
                                    <input type="radio" name="post_format_audio" value="0" id="post_format_audio_2" class="square-purple" <?= $generalSettings->post_format_audio != 1 ? 'checked' : ''; ?>>
                                    <label for="post_format_audio_2" class="option-label"><?= trans('disable'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?= trans('trivia_quiz'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                    <input type="radio" name="post_format_trivia_quiz" value="1" id="post_format_trivia_quiz_1" class="square-purple" <?= $generalSettings->post_format_trivia_quiz == 1 ? 'checked' : ''; ?>>
                                    <label for="post_format_trivia_quiz_1" class="option-label"><?= trans('enable'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-7 col-xs-12 col-option">
                                    <input type="radio" name="post_format_trivia_quiz" value="0" id="post_format_trivia_quiz_2" class="square-purple" <?= $generalSettings->post_format_trivia_quiz != 1 ? 'checked' : ''; ?>>
                                    <label for="post_format_trivia_quiz_2" class="option-label"><?= trans('disable'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label><?= trans('personality_quiz'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-5 col-xs-12 col-option">
                                    <input type="radio" name="post_format_personality_quiz" value="1" id="post_format_personality_quiz_1" class="square-purple" <?= $generalSettings->post_format_personality_quiz == 1 ? 'checked' : ''; ?>>
                                    <label for="post_format_personality_quiz_1" class="option-label"><?= trans('enable'); ?></label>
                                </div>
                                <div class="col-sm-6 col-md-7 col-xs-12 col-option">
                                    <input type="radio" name="post_format_personality_quiz" value="0" id="post_format_personality_quiz_2" class="square-purple" <?= $generalSettings->post_format_personality_quiz != 1 ? 'checked' : ''; ?>>
                                    <label for="post_format_personality_quiz_2" class="option-label"><?= trans('disable'); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-right" style="margin-top: 60px;">
                            <button type="submit" name="submit" value="post_formats" class="btn btn-primary"><?= trans('save_changes'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= trans('auto_post_deletion'); ?></h3>
                    </div>
                    <form action="<?= base_url('AdminController/preferencesPost'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="box-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12 col-xs-12">
                                        <label><?= trans('status'); ?></label>
                                    </div>
                                    <div class="col-sm-6 col-xs-12 col-option">
                                        <input type="radio" name="auto_post_deletion" value="1" id="auto_post_deletion_1" class="square-purple" <?= $generalSettings->auto_post_deletion == 1 ? 'checked' : ''; ?>>
                                        <label for="auto_post_deletion_1" class="option-label"><?= trans('enable'); ?></label>
                                    </div>
                                    <div class="col-sm-6 col-xs-12 col-option">
                                        <input type="radio" name="auto_post_deletion" value="0" id="auto_post_deletion_2" class="square-purple" <?= $generalSettings->auto_post_deletion != 1 ? 'checked' : ''; ?>>
                                        <label for="auto_post_deletion_2" class="option-label"><?= trans('disable'); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><?= trans('number_of_days'); ?>&nbsp;<small>(E.g. <?= trans("number_of_days_exp") ?>)</small></label>
                                <input type="number" class="form-control" name="auto_post_deletion_days" value="<?= $generalSettings->auto_post_deletion_days; ?>" min="1" max="99999999" required style="max-width: 600px;">
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12 col-xs-12">
                                        <label><?= trans('posts'); ?></label>
                                    </div>
                                    <div class="col-sm-6 col-xs-12 col-option">
                                        <input type="radio" name="auto_post_deletion_delete_all" value="1" id="auto_post_deletion_delete_all_1" class="square-purple" <?= $generalSettings->auto_post_deletion_delete_all == 1 ? 'checked' : ''; ?>>
                                        <label for="auto_post_deletion_delete_all_1" class="option-label"><?= trans('delete_all_posts'); ?></label>
                                    </div>
                                    <div class="col-sm-6 col-xs-12 col-option">
                                        <input type="radio" name="auto_post_deletion_delete_all" value="0" id="auto_post_deletion_delete_all_2" class="square-purple" <?= $generalSettings->auto_post_deletion_delete_all != 1 ? 'checked' : ''; ?>>
                                        <label for="auto_post_deletion_delete_all_2" class="option-label"><?= trans('delete_only_rss_posts'); ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" name="submit" value="post_deletion" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-sm-12 col-md-12 col-lg-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= trans('allowed_file_extensions'); ?>&nbsp;(<?= trans("file_manager") ?>)</h3>
                    </div>
                    <form action="<?= base_url('AdminController/allowedFileExtensionsPost'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="box-body">
                            <div class="form-group">
                                <label class="control-label"><?= trans("file_extensions"); ?></label>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input id="input_allowed_file_extensions" type="text" name="allowed_file_extensions" value="<?= strReplace('"', '', $generalSettings->allowed_file_extensions); ?>" class="form-control tags"/>
                                        <small>(<?= trans('type_extension'); ?>&nbsp;E.g. zip, jpg, doc, pdf..)</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" name="submit" value="post_deletion" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>