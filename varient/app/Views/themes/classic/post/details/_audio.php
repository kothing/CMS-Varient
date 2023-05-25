<link href="<?= base_url('assets/vendor/audio-player/css/amplitude.min.css'); ?>" rel="stylesheet"/>
<?php $audios = getPostAudios($post->id); ?>
<div class="show-on-page-load">
    <div class="post-player">
        <?php if (countItems($audios) > 0): ?>
            <div class="col-sm-12" id="amplitude-player">
                <div class="row">
                    <div class="columns" id="amplitude-left">
                        <div class="amplitude-inner-left">
                            <?php $imgURL = getPostImage($post, 'slider'); ?>
                            <img src="<?= $imgURL; ?>" alt="<?= esc($post->title); ?>" width="263" height="201.63"/>
                        </div>
                        <div class="amplitude-inner-right">
                            <div id="player-left-bottom">
                                <div id="meta-container">
                                    <span amplitude-song-info="name" amplitude-main-song-info="true" class="song-name"></span>
                                    <div class="song-artist-album">
                                        <span amplitude-song-info="artist" amplitude-main-song-info="true"></span>
                                    </div>
                                </div>
                                <div id="time-container">
								<span class="current-time">
									<span class="amplitude-current-minutes" amplitude-main-current-minutes="true"></span>:<span class="amplitude-current-seconds" amplitude-main-current-seconds="true"></span>
								</span>
                                    <input type="range" class="amplitude-song-slider" amplitude-main-song-slider="true" step=".1"/>
                                    <span class="duration">
									<span class="amplitude-duration-minutes" amplitude-main-duration-minutes="true"></span>:<span class="amplitude-duration-seconds" amplitude-main-duration-seconds="true"></span>
								</span>
                                </div>
                                <div id="control-container">
                                    <div id="repeat-container">
                                        <div id="repeat" class="amplitude-repeat amplitude-repeat-off"></div>
                                    </div>
                                    <div id="shuffle-container">
                                        <div class="amplitude-shuffle amplitude-shuffle-off" id="shuffle"></div>
                                    </div>
                                    <div id="central-control-container">
                                        <div id="central-controls">
                                            <div class="amplitude-prev" id="previous"></div>
                                            <div class="amplitude-play-pause" amplitude-main-play-pause="true" id="play-pause"></div>
                                            <div class="amplitude-next" id="next"></div>
                                        </div>
                                    </div>
                                    <div id="volume-container">
                                        <div class="volume-controls">
                                            <div class="amplitude-mute amplitude-not-muted"></div>
                                            <input class="amplitude-volume-slider" type="range">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="amplitude-right" style="<?= countItems($audios) > 5 ? 'overflow-y: auto !important' : ''; ?>">
                                <?php $index = 0;
                                foreach ($audios as $audio): ?>
                                    <div class="list-row">
                                        <div class="list-left">
                                            <div class="song amplitude-song-container amplitude-play-pause" amplitude-song-index="<?= $index; ?>">
                                                <div class="song-now-playing-icon-container">
                                                    <div class="play-button-container"></div>
                                                    <img class="now-playing" src="<?= base_url('assets/vendor/audio-player/img/now-playing.svg'); ?>"/>
                                                </div>
                                                <div class="song-meta-data">
                                                    <span class="song-title"><?= esc($audio->audio_name); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-right">
                                            <div class="download-link-cnt">
                                                <?php if ($generalSettings->audio_download_button == 1 && $audio->download_button == 1): ?>
                                                    <form action="<?= base_url('download-file'); ?>" method="post">
                                                        <?= csrf_field(); ?>
                                                        <input type="hidden" name="id" value="<?= $audio->id; ?>">
                                                        <button type="submit" name="file_type" value="audio" class="download-link">
                                                            <i class="icon-download"></i>&nbsp;<?= trans('download'); ?>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $index++;
                                endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="<?= base_url('assets/vendor/audio-player/js/amplitude.min.js'); ?>"></script>
<script type="text/javascript">
    Amplitude.init({
        "songs": [
            <?php foreach ($audios as $audio):
            $audioBaseURL = getBaseURLByStorage($audio->storage); ?>
            {
                'name': "<?= clrQuotes(esc($audio->audio_name)); ?>",
                'artist': "",
                'url': "<?= $audioBaseURL . esc($audio->audio_path);  ?>",
                'cover_art_url': "<?= $imgURL;  ?>",
            },
            <?php endforeach; ?>
        ]
    });
</script>




