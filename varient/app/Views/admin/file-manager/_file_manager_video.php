<div id="file_manager_video" class="modal fade modal-file-manager" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?= trans('videos'); ?></h4>
                <div class="file-manager-search">
                    <input type="text" id="input_search_video" class="form-control" placeholder="<?= trans("search"); ?>">
                </div>
            </div>
            <div class="modal-body">
                <div class="file-manager">
                    <div class="file-manager-left">
                        <div class="dm-uploader-container">
                            <div id="drag-and-drop-zone-video" class="dm-uploader text-center">
                                <p class="file-manager-file-types">
                                    <span>MP4</span>
                                    <span>WEBM</span>
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
                                <ul class="dm-uploaded-files" id="files-video"></ul>
                                <button type="button" id="btn_reset_upload_video" class="btn btn-reset-upload"><?= trans("reset"); ?></button>
                            </div>
                        </div>
                    </div>
                    <div class="file-manager-right">
                        <div class="file-manager-content">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div id="video_upload_response"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="selected_video_id">
                    <input type="hidden" id="selected_video_path">
                    <input type="hidden" id="selected_video_storage">
                    <input type="hidden" id="selected_video_base_url">
                </div>
            </div>
            <div class="modal-footer">
                <div class="file-manager-footer">
                    <button type="button" id="btn_video_delete" class="btn btn-danger pull-left btn-file-delete"><i class="fa fa-trash"></i>&nbsp;&nbsp;<?= trans('delete'); ?></button>
                    <button type="button" id="btn_video_select" class="btn bg-olive btn-file-select"><i class="fa fa-check"></i>&nbsp;&nbsp;<?= trans('select_video'); ?></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= trans('close'); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/html" id="files-template-video">
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
        $('#drag-and-drop-zone-video').dmUploader({
            url: '<?= base_url("FileController/uploadVideo"); ?>',
            queue: true,
            allowedTypes: 'video/*',
            extFilter: ["mp4", "webm"],
            extraData: function (id) {
                return {
                    "file_id": id,
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
                ui_multi_add_file(id, file, "video");
            },
            onBeforeUpload: function (id) {
                $('#uploaderFile' + id + ' .dm-progress-waiting').hide();
                ui_multi_update_file_progress(id, 0, '', true);
                ui_multi_update_file_status(id, 'uploading', 'Uploading...');
                $("#btn_reset_upload_video").show();
            },
            onUploadProgress: function (id, percent) {
                ui_multi_update_file_progress(id, percent);
            },
            onUploadSuccess: function (id, data) {
                refresh_videos();
                document.getElementById("uploaderFile" + id).remove();
                ui_multi_update_file_status(id, 'success', 'Upload Complete');
                ui_multi_update_file_progress(id, 100, 'success', false);
                $("#btn_reset_upload_video").hide();
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
    $(document).on('click', '#btn_reset_upload_video', function () {
        $("#drag-and-drop-zone-video").dmUploader("reset");
        $("#files-video").empty();
        $(this).hide();
    });
</script>
