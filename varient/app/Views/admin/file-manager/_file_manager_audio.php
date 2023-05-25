<div id="file_manager_audio" class="modal fade modal-file-manager" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?= trans('audios'); ?></h4>
                <div class="file-manager-search">
                    <input type="text" id="input_search_audio" class="form-control" placeholder="<?= trans("search"); ?>">
                </div>
            </div>
            <div class="modal-body">
                <div class="file-manager">
                    <div class="file-manager-left">
                        <div class="file-manager-sidebar">
                            <div class="dm-uploader-container m-b-10">
                                <div id="drag-and-drop-zone-audio" class="dm-uploader text-center">
                                    <p class="file-manager-file-types">
                                        <span>MP3</span>
                                        <span>WAV</span>
                                    </p>
                                    <p class="dm-upload-icon">
                                        <i class="fa fa-cloud-upload"></i>
                                    </p>
                                    <p class="dm-upload-text"><?= trans("drag_drop_files_here"); ?></p>
                                    <p class="text-center">
                                        <button class="btn btn-default btn-browse-files"><?= trans('browse_files'); ?></button>
                                    </p>
                                    <a class='btn btn-md dm-btn-select-files'>
                                        <input type="file" name="file" size="40" multiple="multiple">
                                    </a>
                                    <ul class="dm-uploaded-files dm-uploaded-files-no-preview" id="files-audio"></ul>
                                    <button type="button" id="btn_reset_upload_audio" class="btn btn-reset-upload"><?= trans("reset"); ?></button>
                                </div>
                            </div>
                            <div class="col-sm-12 m-b-10">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <label><?= trans('download_button'); ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <input type="radio" id="rb_download_button_1" name="audio_download_button" value="1" class="square-purple" checked>&nbsp;&nbsp;
                                            <label for="rb_download_button_1" class="cursor-pointer"><?= trans('show'); ?></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <input type="radio" id="rb_download_button_2" name="audio_download_button" value="0" class="square-purple">&nbsp;&nbsp;
                                            <label for="rb_download_button_2" class="cursor-pointer"><?= trans('hide'); ?></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="file-manager-right">
                        <div class="file-manager-content">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div id="audio_upload_response">
                                        <?php foreach ($audios as $audio):
                                            if (!empty($audio)): ?>
                                                <div class="col-file-manager" id="audio_col_id_<?= $audio->id; ?>">
                                                    <div class="file-box" data-audio-id="<?= $audio->id; ?>" data-audio-name="<?= esc($audio->audio_name); ?>">
                                                        <div class="image-container icon-container">
                                                            <div class="file-icon file-icon-lg" data-type="<?= @pathinfo($audio->audio_path, PATHINFO_EXTENSION); ?>"></div>
                                                        </div>
                                                        <span class="file-name"><?= esc($audio->audio_name); ?></span>
                                                    </div>
                                                </div>
                                            <?php endif;
                                        endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="selected_audio_id">
                    <input type="hidden" id="selected_audio_name">
                </div>
            </div>
            <div class="modal-footer">
                <div class="file-manager-footer">
                    <button type="button" id="btn_audio_delete" class="btn btn-danger pull-left btn-file-delete"><i class="fa fa-trash"></i>&nbsp;&nbsp;<?= trans('delete'); ?></button>
                    <button type="button" id="btn_audio_select" class="btn bg-olive btn-file-select"><i class="fa fa-check"></i>&nbsp;&nbsp;<?= trans('select_audio'); ?></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= trans('close'); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/html" id="files-template-audio">
    <li class="media">
        <img class="preview-img" src="<?= base_url('assets/admin/plugins/file-manager/file.png'); ?>" alt="">
        <div class="media-body">
            <div class="progress">
                <div class="dm-progress-waiting"><?= trans("waiting"); ?></div>
                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </li>
</script>

<script>
    $(function () {
        $('#drag-and-drop-zone-audio').dmUploader({
            url: '<?= base_url("FileController/uploadAudio"); ?>',
            queue: true,
            allowedTypes: 'audio/*',
            extFilter: ["mp3", "wav"],
            extraData: function (id) {
                return {
                    "file_id": id,
                    "download_button": $('input[name=audio_download_button]:checked').val(),
                    '<?= csrf_token() ?>': getCsrfHash()
                };
            },
            onDragEnter: function () {
                this.addClass('active');
            },
            onDragLeave: function () {
                this.removeClass('active');
            },
            onNewFile: function (id, file) {
                ui_multi_add_file(id, file, "audio");
            },
            onBeforeUpload: function (id) {
                $('#uploaderFile' + id + ' .dm-progress-waiting').hide();
                ui_multi_update_file_progress(id, 0, '', true);
                ui_multi_update_file_status(id, 'uploading', 'Uploading...');
                $("#btn_reset_upload_audio").show();
            },
            onUploadProgress: function (id, percent) {
                ui_multi_update_file_progress(id, percent);
            },
            onUploadSuccess: function (id, data) {
                refresh_audios();
                document.getElementById("uploaderFile" + id).remove();
                ui_multi_update_file_status(id, 'success', 'Upload Complete');
                ui_multi_update_file_progress(id, 100, 'success', false);
                $("#btn_reset_upload_audio").hide();
            },
            onFileTypeError: function (file) {
                swal({
                    text: "<?= trans("invalid_file_type");?>",
                    icon: "warning",
                    button: VrConfig.textOk
                });
            },
            onFileExtError: function (file) {
                swal({
                    text: "<?= trans("invalid_file_type");?>",
                    icon: "warning",
                    button: VrConfig.textOk
                });
            }
        });
    });
    $(document).on('click', '#btn_reset_upload_audio', function () {
        $("#drag-and-drop-zone-audio").dmUploader("reset");
        $("#files-audio").empty();
        $(this).hide();
    });
</script>
