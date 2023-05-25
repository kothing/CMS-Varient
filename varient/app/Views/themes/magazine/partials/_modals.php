<?php if (!authCheck() && $generalSettings->registration_system == 1): ?>
    <div class="modal fade" id="modalLogin" tabindex="-1" aria-labelledby="loginModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-login">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?= trans("login"); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?= view("common/_social_login", ['orText' => trans("or_register_with_email")]); ?>
                    <div id="result-login"></div>
                    <form id="form-login">
                        <div class="mb-2">
                            <input type="email" name="email" class="form-control form-input input-account" placeholder="<?= trans("email"); ?>" value="<?= old('email'); ?>" required>
                        </div>
                        <div class="mb-2">
                            <input type="password" name="password" class="form-control form-input input-account" placeholder="<?= trans("password"); ?>" value="<?= old('password'); ?>" required>
                        </div>
                        <div class="mb-4 text-end">
                            <a href="<?= generateURL('forgot_password'); ?>" class="link-forget"><?= trans("forgot_password"); ?>?</a>
                        </div>
                        <div class="form-group m-t-15 m-b-0">
                            <button type="submit" class="btn btn-account btn-custom"><?= trans("login"); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif;
if (authCheck()): ?>
    <div id="modalAddPost" class="modal fade modal-add-post" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?= trans("choose_post_format"); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row align-items-center justify-content-center">
                        <?php $formatCount = 0;
                        if ($generalSettings->post_format_article == 1):
                            $formatCount += 1; ?>
                            <div class="col-12 col-sm-4 col-add-post">
                                <a href="<?= adminUrl('add-post?type=article'); ?>">
                                    <div class="item">
                                        <div class="item-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="<?= $activeTheme->theme_color; ?>" class="bi bi-file-earmark-text" viewBox="0 0 16 16">
                                                <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"/>
                                                <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                                            </svg>
                                        </div>
                                        <h5 class="title"><?= trans("article"); ?></h5>
                                        <p class="desc"><?= trans("article_post_exp"); ?></p>
                                    </div>
                                </a>
                            </div>
                        <?php endif;
                        if ($generalSettings->post_format_gallery == 1):
                            $formatCount += 1; ?>
                            <div class="col-12 col-sm-4 col-add-post">
                                <a href="<?= adminUrl('add-post?type=gallery'); ?>">
                                    <div class="item">
                                        <div class="item-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="<?= $activeTheme->theme_color; ?>" class="bi bi-images" viewBox="0 0 16 16">
                                                <path d="M4.502 9a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
                                                <path d="M14.002 13a2 2 0 0 1-2 2h-10a2 2 0 0 1-2-2V5A2 2 0 0 1 2 3a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v8a2 2 0 0 1-1.998 2zM14 2H4a1 1 0 0 0-1 1h9.002a2 2 0 0 1 2 2v7A1 1 0 0 0 15 11V3a1 1 0 0 0-1-1zM2.002 4a1 1 0 0 0-1 1v8l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71a.5.5 0 0 1 .577-.094l1.777 1.947V5a1 1 0 0 0-1-1h-10z"/>
                                            </svg>
                                        </div>
                                        <h5 class="title"><?= trans("gallery"); ?></h5>
                                        <p class="desc"><?= trans("gallery_post_exp"); ?></p>
                                    </div>
                                </a>
                            </div>
                        <?php endif;
                        if ($generalSettings->post_format_sorted_list == 1):
                            $formatCount += 1; ?>
                            <div class="col-12 col-sm-4 col-add-post">
                                <a href="<?= adminUrl('add-post?type=sorted_list'); ?>">
                                    <div class="item">
                                        <div class="item-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="<?= $activeTheme->theme_color; ?>" class="bi bi-list-ol" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5z"/>
                                                <path d="M1.713 11.865v-.474H2c.217 0 .363-.137.363-.317 0-.185-.158-.31-.361-.31-.223 0-.367.152-.373.31h-.59c.016-.467.373-.787.986-.787.588-.002.954.291.957.703a.595.595 0 0 1-.492.594v.033a.615.615 0 0 1 .569.631c.003.533-.502.8-1.051.8-.656 0-1-.37-1.008-.794h.582c.008.178.186.306.422.309.254 0 .424-.145.422-.35-.002-.195-.155-.348-.414-.348h-.3zm-.004-4.699h-.604v-.035c0-.408.295-.844.958-.844.583 0 .96.326.96.756 0 .389-.257.617-.476.848l-.537.572v.03h1.054V9H1.143v-.395l.957-.99c.138-.142.293-.304.293-.508 0-.18-.147-.32-.342-.32a.33.33 0 0 0-.342.338v.041zM2.564 5h-.635V2.924h-.031l-.598.42v-.567l.629-.443h.635V5z"/>
                                            </svg>
                                        </div>
                                        <h5 class="title"><?= trans("sorted_list"); ?></h5>
                                        <p class="desc"><?= trans("sorted_list_exp"); ?></p>
                                    </div>
                                </a>
                            </div>
                        <?php endif;
                        if ($generalSettings->post_format_trivia_quiz == 1):
                            $formatCount += 1; ?>
                            <div class="col-12 col-sm-4 col-add-post">
                                <a href="<?= adminUrl('add-post?type=trivia_quiz'); ?>">
                                    <div class="item">
                                        <div class="item-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="<?= $activeTheme->theme_color; ?>" class="bi bi-ui-checks-grid" viewBox="0 0 16 16">
                                                <path d="M2 10h3a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1zm9-9h3a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-3a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zm0 9a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1h-3zm0-10a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h3a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2h-3zM2 9a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h3a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H2zm7 2a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-3a2 2 0 0 1-2-2v-3zM0 2a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm5.354.854a.5.5 0 1 0-.708-.708L3 3.793l-.646-.647a.5.5 0 1 0-.708.708l1 1a.5.5 0 0 0 .708 0l2-2z"/>
                                            </svg>
                                        </div>
                                        <h5 class="title"><?= trans("trivia_quiz"); ?></h5>
                                        <p class="desc"><?= trans("trivia_quiz_exp"); ?></p>
                                    </div>
                                </a>
                            </div>
                        <?php endif;
                        if ($generalSettings->post_format_personality_quiz == 1):
                            $formatCount += 1; ?>
                            <div class="col-12 col-sm-4 col-add-post">
                                <a href="<?= adminUrl('add-post?type=personality_quiz'); ?>">
                                    <div class="item">
                                        <div class="item-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="<?= $activeTheme->theme_color; ?>" class="bi bi-ui-checks" viewBox="0 0 16 16">
                                                <path d="M7 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zM2 1a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2zm0 8a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2H2zm.854-3.646a.5.5 0 0 1-.708 0l-1-1a.5.5 0 1 1 .708-.708l.646.647 1.646-1.647a.5.5 0 1 1 .708.708l-2 2zm0 8a.5.5 0 0 1-.708 0l-1-1a.5.5 0 0 1 .708-.708l.646.647 1.646-1.647a.5.5 0 0 1 .708.708l-2 2zM7 10.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zm0-5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 8a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                                            </svg>
                                        </div>
                                        <h5 class="title"><?= trans("personality_quiz"); ?></h5>
                                        <p class="desc"><?= trans("personality_quiz_exp"); ?></p>
                                    </div>
                                </a>
                            </div>
                        <?php endif;
                        if ($generalSettings->post_format_video == 1):
                            $formatCount += 1; ?>
                            <div class="col-12 col-sm-4 col-add-post">
                                <a href="<?= adminUrl('add-post?type=video'); ?>">
                                    <div class="item">
                                        <div class="item-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="<?= $activeTheme->theme_color; ?>" class="bi bi-play-circle" viewBox="0 0 16 16">
                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                <path d="M6.271 5.055a.5.5 0 0 1 .52.038l3.5 2.5a.5.5 0 0 1 0 .814l-3.5 2.5A.5.5 0 0 1 6 10.5v-5a.5.5 0 0 1 .271-.445z"/>
                                            </svg>
                                        </div>
                                        <h5 class="title"><?= trans("video"); ?></h5>
                                        <p class="desc"><?= trans("video_post_exp"); ?></p>
                                    </div>
                                </a>
                            </div>
                        <?php endif;
                        if ($generalSettings->post_format_audio == 1): ?>
                            <div class="col-12 col-sm-4 <?= $formatCount == 6 ? 'col-sm-offset-4 ' : ''; ?>col-add-post">
                                <a href="<?= adminUrl('add-post?type=audio'); ?>">
                                    <div class="item">
                                        <div class="item-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="<?= $activeTheme->theme_color; ?>" class="bi bi-music-note-beamed" viewBox="0 0 16 16">
                                                <path d="M6 13c0 1.105-1.12 2-2.5 2S1 14.105 1 13c0-1.104 1.12-2 2.5-2s2.5.896 2.5 2zm9-2c0 1.105-1.12 2-2.5 2s-2.5-.895-2.5-2 1.12-2 2.5-2 2.5.895 2.5 2z"/>
                                                <path fill-rule="evenodd" d="M14 11V2h1v9h-1zM6 3v10H5V3h1z"/>
                                                <path d="M5 2.905a1 1 0 0 1 .9-.995l8-.8a1 1 0 0 1 1.1.995V3L5 4V2.905z"/>
                                            </svg>
                                        </div>
                                        <h5 class="title"><?= trans("audio"); ?></h5>
                                        <p class="desc"><?= trans("audio_post_exp"); ?></p>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<div id="modalNewsletter" class="modal fade modal-newsletter" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <h5 class="modal-title"><?= trans("join_newsletter"); ?></h5>
                <p class="modal-desc"><?= trans("newsletter_desc"); ?></p>
                <form id="form_newsletter_modal" class="form-newsletter needs-validation" data-form-type="modal">
                    <div class="mb-3">
                        <div class="modal-newsletter-inputs">
                            <input type="email" name="email" class="form-control form-input newsletter-input" placeholder="<?= trans('email') ?>" required>
                            <button type="submit" id="btn_modal_newsletter" class="btn"><?= trans("subscribe"); ?></button>
                        </div>
                    </div>
                    <input type="text" name="url">
                    <div id="modal_newsletter_response" class="text-center modal-newsletter-response">
                        <div class="form-group text-center m-b-0 text-close">
                            <button type="button" class="text-close" data-dismiss="modal"><?= trans("no_thanks"); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>