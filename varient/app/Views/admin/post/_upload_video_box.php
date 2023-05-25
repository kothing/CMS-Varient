<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom video-upload-tab">
            <ul class="nav nav-tabs">
                <li class="<?= !empty($post->video_embed_code) || empty($post) ? 'active' : ''; ?>"><a href="#tab_1" data-toggle="tab" aria-expanded="false"><?= trans('get_video_from_url'); ?></a></li>
                <li class="<?= empty($post->video_embed_code) && !empty($post) ? 'active' : ''; ?>"><a href="#tab_2" data-toggle="tab" aria-expanded="true"><?= trans('upload_video'); ?></a></li>
            </ul>
            <div class="tab-content settings-tab-content">
                <?php if (!empty($post)): ?>
                    <div class="tab-pane <?= !empty($post->video_embed_code) ? 'active' : ''; ?>" id="tab_1">
                        <div class="form-group">
                            <label class="control-label"><?= trans('video_url'); ?>
                                <small>(Youtube, Vimeo, Dailymotion, Facebook)</small>
                            </label>
                            <input type="text" class="form-control" name="video_url" id="video_url" value="<?= $post->video_url; ?>" placeholder="<?= trans('video_url'); ?>">
                            <a href="javascript:void(0)" class="btn btn-sm btn-info pull-right btn-get-embed" onclick="getVideoFromURL();"><?= trans('get_video'); ?></a>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><?= trans('video_embed_code'); ?></label>
                            <textarea class="form-control text-embed" name="video_embed_code" id="video_embed_code" placeholder="<?= trans('video_embed_code'); ?>"><?= $post->video_embed_code; ?></textarea>
                        </div>
                        <?php if (!empty($post->video_embed_code)): ?>
                            <iframe src="<?= $post->video_embed_code; ?>" id="video_embed_preview" frameborder="0" allow="encrypted-media" allowfullscreen class="video-embed-preview" style="display: block"></iframe>
                        <?php else: ?>
                            <iframe src="" id="video_embed_preview" frameborder="0" allow="encrypted-media" allowfullscreen class="video-embed-preview"></iframe>
                        <?php endif; ?>
                    </div>
                    <div class="tab-pane <?= empty($post->video_embed_code) ? 'active' : ''; ?>" id="tab_2">
                        <div class="row">
                            <div class="col-sm-12">
                                <a class='btn btn-sm bg-purple' data-toggle="modal" data-target="#file_manager_video">
                                    <?= trans('select_video'); ?>
                                </a>
                                <?php if (!empty($post->video_path)): ?>
                                    <a class='btn btn-sm btn-danger btn-delete-post-video' onclick="deletePostVideo('<?= $post->id; ?>');">
                                        <?= trans('delete'); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row">
                            <div id="post_selected_video" class="col-sm-12">
                                <?php if (!empty($post->video_path)):
                                    $videoBaseURL = getBaseURLByStorage($post->video_storage); ?>
                                    <input type="hidden" name="video_path" value="<?= $post->video_path; ?>">
                                    <input type="hidden" name="video_storage" value="<?= $post->video_storage; ?>">
                                    <video controls class="video-preview">
                                        <source src="<?= $videoBaseURL . $post->video_path; ?>" type="video/mp4">
                                        <source src="<?= $videoBaseURL . $post->video_path; ?>" type="video/ogg">
                                        Your browser does not support the video tag.
                                    </video>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="tab-pane active" id="tab_1">
                        <div class="form-group">
                            <label class="control-label"><?= trans('video_url'); ?>
                                <small>(Youtube, Vimeo, Dailymotion, Facebook)</small>
                            </label>
                            <input type="text" class="form-control" name="video_url" id="video_url" placeholder="<?= trans('video_url'); ?>">
                            <a href="javascript:void(0)" class="btn btn-sm btn-info pull-right btn-get-embed" onclick="getVideoFromURL();"><?= trans('get_video'); ?></a>
                        </div>
                        <div class="form-group">
                            <label class="control-label video-embed-lbl"><?= trans('video_embed_code'); ?></label>
                            <textarea class="form-control text-embed" name="video_embed_code" id="video_embed_code" placeholder="<?= trans('video_embed_code'); ?>"><?= old('video_embed_code'); ?></textarea>
                        </div>
                        <iframe src="" id="video_embed_preview" frameborder="0" allow="encrypted-media" allowfullscreen class="video-embed-preview"></iframe>
                    </div>
                    <div class="tab-pane" id="tab_2">
                        <div class="row">
                            <div class="col-sm-12">
                                <a class='btn btn-sm bg-purple' data-toggle="modal" data-target="#file_manager_video">
                                    <?= trans('select_video'); ?>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div id="post_selected_video" class="col-sm-12"></div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>