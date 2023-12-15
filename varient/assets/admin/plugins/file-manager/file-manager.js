/*
*------------------------------------------------------------------------------------------
* IMAGES
*------------------------------------------------------------------------------------------
*/
var image_type = 'main';
var data_list_item_id = '';
var data_is_update = '';
var data_editor_id = '';
//update images
$('#file_manager_image').on('show.bs.modal', function (e) {
    image_type = $(e.relatedTarget).attr('data-image-type');
    data_is_update = $(e.relatedTarget).attr('data-is-update');
    if (image_type == 'list_item') {
        data_list_item_id = $(e.relatedTarget).attr('data-list-item-id');
    }
    if (image_type == 'list_item_editor') {
        data_editor_id = $(e.relatedTarget).attr('data-editor-id');
    }
    refresh_images();
});

//select image
$(document).on('click', '#file_manager_image .file-box', function () {
    $('#file_manager_image .file-box').removeClass('selected');
    $(this).addClass('selected');
    $('#selected_img_file_id').val($(this).attr('data-file-id'));
    $('#selected_img_mid_file_path').val($(this).attr('data-mid-file-path'));
    $('#selected_img_default_file_path').val($(this).attr('data-default-file-path'));
    $('#selected_img_slider_file_path').val($(this).attr('data-slider-file-path'));
    $('#selected_img_big_file_path').val($(this).attr('data-big-file-path'));
    $('#selected_img_storage').val($(this).attr('data-file-storage'));
    $('#selected_img_base_url').val($(this).attr('data-file-base-url'));
    $('#btn_img_delete').show();
    $('#btn_img_select').show();
});

//refresh images
function refresh_images() {
    var data = {};
    addCsrf(data);
    $.ajax({
        type: "POST",
        url: VrConfig.baseURL + "/FileController/getImages",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                document.getElementById("image_file_upload_response").innerHTML = obj.content;
            }
        }
    });
}

//delete image file
$(document).on('click', '#file_manager_image #btn_img_delete', function () {
    var file_id = $('#selected_img_file_id').val();
    $('#img_col_id_' + file_id).remove();
    var data = {
        "file_id": file_id
    };
    addCsrf(data);
    $.ajax({
        type: "POST",
        url: VrConfig.baseURL + "/FileController/deleteImage",
        data: data,
        success: function (response) {
            $('#btn_img_delete').hide();
            $('#btn_img_select').hide();
        }
    });
});

//select image file
$(document).on('click', '#file_manager_image #btn_img_select', function () {
    select_image();
});

//select image file on double click
$(document).on('dblclick', '#file_manager_image .file-box', function () {
    select_image();
});

function select_image() {
    var file_id = $('#selected_img_file_id').val();
    var img_mid_file_path = $('#selected_img_mid_file_path').val();
    var img_default_file_path = $('#selected_img_default_file_path').val();
    var img_slider_file_path = $('#selected_img_slider_file_path').val();
    var img_big_file_path = $('#selected_img_big_file_path').val();
    var img_storage = $('#selected_img_storage').val();
    var img_base_url = $('#selected_img_base_url').val();

    if (image_type == 'additional') {
        var image = '<div class="additional-item additional-item-' + file_id + '"><img class="img-additional" src="' + img_base_url + img_mid_file_path + '" alt="">' +
            '<input type="hidden" name="additional_post_image_id[]" value="' + file_id + '">' +
            '<a class="btn btn-danger btn-sm btn-delete-additional-image" data-value="' + file_id + '">' +
            '<i class="fa fa-times"></i> ' +
            '</a>' +
            '</div>';
        $('.additional-image-list').append(image);
    } else if (image_type == 'video_thumbnail') {
        $('input[name=post_image_id]').val(file_id);
        $('#selected_image_file').attr('src', img_mid_file_path);
        if ($("#video_thumbnail_url").length) {
            $('#video_thumbnail_url').val('');
        }
    } else if (image_type == 'editor') {
        tinymce.activeEditor.execCommand('mceInsertContent', false, '<p><img src="' + img_base_url + img_default_file_path + '" alt=""/></p>');
    } else if (image_type == 'list_item_editor') {
        tinymce.get('editor_' + data_editor_id).execCommand('mceInsertContent', false, '<p><img src="' + img_base_url + img_default_file_path + '" alt=""/></p>');
    } else if (image_type == 'list_item') {
        var input = '<input type="hidden" name="list_item_image[]" value="' + img_big_file_path + '">' +
            '<input type="hidden" name="list_item_image_large[]" value="' + img_default_file_path + '">' +
            '<input type="hidden" name="list_item_image_storage[]" value="' + img_storage + '">';
        if (data_is_update == 1) {
            input = '<input type="hidden" name="list_item_image_' + data_list_item_id + '" value="' + img_big_file_path + '">' +
                '<input type="hidden" name="list_item_image_large_' + data_list_item_id + '" value="' + img_default_file_path + '">' +
                '<input type="hidden" name="list_item_image_storage_' + data_list_item_id + '" value="' + img_storage + '">';
        }
        var image = '<div class="list-item-image-container">' +
            input +
            '<img src="' + img_base_url + img_big_file_path + '" alt="">' +
            '<a class="btn btn-danger btn-sm btn-delete-selected-file-image btn-delete-selected-list-item-image" data-image-type="list_item" data-list-item-id="' + data_list_item_id + '" data-is-update="' + data_is_update + '">' +
            '<i class="fa fa-times"></i> ' +
            '</a>' +
            '</div>';
        document.getElementById("post_list_item_image_container_" + data_list_item_id).innerHTML = image;
    } else {
        var image = '<div class="post-select-image-container">' +
            '<img src="' + img_base_url + img_mid_file_path + '" alt="">' +
            '<a id="btn_delete_post_main_image" class="btn btn-danger btn-sm btn-delete-selected-file-image">' +
            '<i class="fa fa-times"></i> ' +
            '</a>' +
            '</div>';
        document.getElementById("post_select_image_container").innerHTML = image;
        $('input[name=post_image_id]').val(file_id);
    }

    $('#file_manager_image').modal('toggle');
    $('#file_manager_image .file-box').removeClass('selected');
    $('#btn_img_delete').hide();
    $('#btn_img_select').hide();
}

//load more images
jQuery(function ($) {
    $('#file_manager_image .file-manager-content').on('scroll', function () {
        var search = $("#input_search_image").val().trim();
        if (search.length < 1) {
            if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
                var min = 0;
                $('#image_file_upload_response .file-box').each(function () {
                    var value = parseInt($(this).attr('data-file-id'));
                    if (min == 0) {
                        min = value;
                    }
                    if (value < min) {
                        min = value;
                    }
                });
                var data = {
                    'min': min
                };
                addCsrf(data);
                $.ajax({
                    type: "POST",
                    url: VrConfig.baseURL + "/FileController/loadMoreImages",
                    data: data,
                    success: function (response) {
                        setTimeout(function () {
                            var obj = JSON.parse(response);
                            if (obj.result == 1) {
                                $("#image_file_upload_response").append(obj.content);
                            }
                        }, 100);
                    }
                });
            }
        }
    })
});

//search image
$(document).on('input', '#input_search_image', function () {
    var search = $(this).val().trim();
    var data = {
        "search": search
    };
    addCsrf(data);
    $.ajax({
        type: "POST",
        url: VrConfig.baseURL + "/FileController/searchImage",
        data: data,
        success: function (response) {
            if (search.length > 1) {
                var obj = JSON.parse(response);
                if (obj.result == 1) {
                    document.getElementById("image_file_upload_response").innerHTML = obj.content;
                }
            } else {
                refresh_images();
            }

        }
    });
});

/*
*------------------------------------------------------------------------------------------
* QUIZ IMAGES
*------------------------------------------------------------------------------------------
*/
var quiz_image_type = 'main';
var data_question_id = '';
var data_answer_id = '';
var data_result_id = '';
//update images
$('#file_manager_quiz_image').on('show.bs.modal', function (e) {
    quiz_image_type = $(e.relatedTarget).attr('data-quiz-image-type');
    data_question_id = $(e.relatedTarget).attr('data-question-id');
    data_answer_id = $(e.relatedTarget).attr('data-answer-id');
    data_result_id = $(e.relatedTarget).attr('data-result-id');
    data_is_update = $(e.relatedTarget).attr('data-is-update');
    refresh_quiz_images();
});

//select quiz image
$(document).on('click', '#file_manager_quiz_image .file-box', function () {
    $('#file_manager_quiz_image .file-box').removeClass('selected');
    $(this).addClass('selected');
    $('#selected_quiz_img_file_id').val($(this).attr('data-file-id'));
    $('#selected_quiz_img_default_file_path').val($(this).attr('data-default-file-path'));
    $('#selected_quiz_img_small_file_path').val($(this).attr('data-small-file-path'));
    $('#selected_quiz_img_base_url').val($(this).attr('data-file-base-url'));
    $('#selected_quiz_img_storage').val($(this).attr('data-file-storage'));
    $('#btn_quiz_img_delete').show();
    $('#btn_quiz_img_select').show();
});

//refresh quiz images
function refresh_quiz_images() {
    var data = {};
    addCsrf(data);
    $.ajax({
        type: "POST",
        url: VrConfig.baseURL + "/FileController/getQuizImages",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                document.getElementById("quiz_image_file_upload_response").innerHTML = obj.content;
            }
        }
    });
}

//delete quiz image file
$(document).on('click', '#file_manager_quiz_image #btn_quiz_img_delete', function () {
    var file_id = $('#selected_quiz_img_file_id').val();
    $('#img_col_id_' + file_id).remove();
    var data = {
        "file_id": file_id
    };
    addCsrf(data);
    $.ajax({
        type: "POST",
        url: VrConfig.baseURL + "/FileController/deleteQuizImage",
        data: data,
        success: function (response) {
            $('#btn_quiz_img_delete').hide();
            $('#btn_quiz_img_select').hide();
        }
    });
});

//select quiz image file
$(document).on('click', '#file_manager_quiz_image #btn_quiz_img_select', function () {
    select_quiz_image();
});

//select quiz image file on double click
$(document).on('dblclick', '#file_manager_quiz_image .file-box', function () {
    select_quiz_image();
});

function select_quiz_image() {
    var file_id = $('#selected_quiz_img_file_id').val();
    var quiz_img_default_file_path = $('#selected_quiz_img_default_file_path').val();
    var quiz_img_small_file_path = $('#selected_quiz_img_small_file_path').val();
    var quiz_img_base_url = $('#selected_quiz_img_base_url').val();
    var quiz_img_storage = $('#selected_quiz_img_storage').val();

    if (quiz_image_type == 'question') {
        var input = '<input type="hidden" name="question_image[]" value="' + quiz_img_default_file_path + '">' +
            '<input type="hidden" name="question_image_storage[]" value="' + quiz_img_storage + '">';
        if (data_is_update == 1) {
            input = '<input type="hidden" name="question_image_' + data_question_id + '" value="' + quiz_img_default_file_path + '">' +
                '<input type="hidden" name="question_image_storage_' + data_question_id + '" value="' + quiz_img_storage + '">';
        }
        var image = '<div class="quiz-question-image-container">' +
            input +
            '<img src="' + quiz_img_base_url + quiz_img_default_file_path + '" alt="">' +
            '<a class="btn btn-danger btn-sm btn-delete-selected-file-image btn-delete-selected-quiz-question-image" data-question-id="' + data_question_id + '" data-answer-id="' + data_answer_id + '" data-is-update="' + data_is_update + '">' +
            '<i class="fa fa-times"></i> ' +
            '</a>' +
            '</div>';
        document.getElementById("quiz_question_image_container_" + data_question_id).innerHTML = image;
    } else if (quiz_image_type == 'answer') {
        var input = '<input type="hidden" name="answer_image_question_' + data_question_id + '[]" value="' + quiz_img_small_file_path + '">' +
            '<input type="hidden" name="answer_image_question_storage_' + data_question_id + '[]" value="' + quiz_img_storage + '">';
        if (data_is_update == 1) {
            input = '<input type="hidden" name="answer_image_' + data_answer_id + '" value="' + quiz_img_small_file_path + '">' +
                '<input type="hidden" name="answer_image_storage_' + data_answer_id + '" value="' + quiz_img_storage + '">';
        }
        var image = '<div class="quiz-answer-image-container">' +
            input +
            '<img src="' + quiz_img_base_url + quiz_img_small_file_path + '" alt="">' +
            '<a class="btn btn-danger btn-sm btn-delete-selected-file-image btn-delete-selected-quiz-answer-image" data-question-id="' + data_question_id + '" data-answer-id="' + data_answer_id + '" data-is-update="' + data_is_update + '">' +
            '<i class="fa fa-times"></i> ' +
            '</a>' +
            '</div>';
        document.getElementById("quiz_answer_image_container_answer_" + data_answer_id).innerHTML = image;
    } else if (quiz_image_type == 'result') {
        var input = '<input type="hidden" name="result_image[]" value="' + quiz_img_default_file_path + '">' +
            '<input type="hidden" name="result_image_storage[]" value="' + quiz_img_storage + '">';
        if (data_is_update == 1) {
            input = '<input type="hidden" name="result_image_' + data_result_id + '" value="' + quiz_img_default_file_path + '">' +
                '<input type="hidden" name="result_image_storage_' + data_result_id + '" value="' + quiz_img_storage + '">';
        }
        var image = '<div class="quiz-question-image-container">' +
            input +
            '<img src="' + quiz_img_base_url + quiz_img_default_file_path + '" alt="">' +
            '<a class="btn btn-danger btn-sm btn-delete-selected-file-image btn-delete-selected-quiz-result-image" data-result-id="' + data_result_id + '" data-is-update="' + data_is_update + '">' +
            '<i class="fa fa-times"></i> ' +
            '</a>' +
            '</div>';
        document.getElementById("quiz_result_image_container_" + data_result_id).innerHTML = image;
    }

    $('#file_manager_quiz_image').modal('toggle');
    $('#file_manager_quiz_image .file-box').removeClass('selected');
    $('#btn_quiz_img_delete').hide();
    $('#btn_quiz_img_select').hide();
}

//load more images
jQuery(function ($) {
    $('#file_manager_quiz_image .file-manager-content').on('scroll', function () {
        var search = $("#input_search_quiz_image").val().trim();
        if (search.length < 1) {
            if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
                var min = 0;
                $('#quiz_image_file_upload_response .file-box').each(function () {
                    var value = parseInt($(this).attr('data-file-id'));
                    if (min == 0) {
                        min = value;
                    }
                    if (value < min) {
                        min = value;
                    }
                });
                var data = {
                    'min': min
                };
                addCsrf(data);
                $.ajax({
                    type: "POST",
                    url: VrConfig.baseURL + "/FileController/loadMoreQuizImages",
                    data: data,
                    success: function (response) {
                        setTimeout(function () {
                            var obj = JSON.parse(response);
                            if (obj.result == 1) {
                                $("#quiz_image_file_upload_response").append(obj.content);
                            }
                        }, 100);
                    }
                });
            }
        }
    })
});

//search quiz image
$(document).on('input', '#input_search_quiz_image', function () {
    var search = $(this).val().trim();
    var data = {
        "search": search
    };
    addCsrf(data);
    $.ajax({
        type: "POST",
        url: VrConfig.baseURL + "/FileController/searchQuizImage",
        data: data,
        success: function (response) {
            if (search.length > 1) {
                var obj = JSON.parse(response);
                if (obj.result == 1) {
                    document.getElementById("quiz_image_file_upload_response").innerHTML = obj.content;
                }
            } else {
                refresh_quiz_images();
            }

        }
    });
});

/*
*------------------------------------------------------------------------------------------
* FILES
*------------------------------------------------------------------------------------------
*/

//select file
$(document).on('click', '#file_manager .file-box', function () {
    $('#file_manager .file-box').removeClass('selected');
    $(this).addClass('selected');
    var file_id = $(this).attr('data-file-id');
    var file_name = $(this).attr('data-file-name');
    $('#selected_file_id').val(file_id);
    $('#selected_file_name').val(file_name);
    $('#btn_file_delete').show();
    $('#btn_file_select').show();
});

//delete file
$(document).on('click', '#file_manager #btn_file_delete', function () {
    var file_id = $('#selected_file_id').val();
    $('#file_col_id_' + file_id).remove();
    var data = {
        "file_id": file_id
    };
    addCsrf(data);
    $.ajax({
        type: "POST",
        url: VrConfig.baseURL + "/FileController/deleteFile",
        data: data,
        success: function (response) {
            $('#btn_file_delete').hide();
            $('#btn_file_select').hide();
        }
    });
});

//select file button
$(document).on('click', '#file_manager #btn_file_select', function () {
    select_file();
});

//select file on double click
$(document).on('dblclick', '#file_manager .file-box', function () {
    select_file();
});

//select file
function select_file() {
    var file_id = $('#selected_file_id').val();
    var file_name = $('#selected_file_name').val();

    var file = '<div id="file_' + file_id + '" class="item">\n' +
        '<input type="hidden" name="post_selected_file_id[]" value="' + file_id + '">\n' +
        '<div class="left">\n' +
        '<i class="fa fa-file"></i>\n' +
        '</div>\n' +
        '<div class="center">\n' +
        '<span>' + file_name + '</span>\n' +
        '</div>\n' +
        '<div class="right">\n' +
        '<a href="javascript:void(0)" class="btn btn-sm btn-selected-file-list-item btn-delete-selected-file" data-value="' + file_id + '"><i class="fa fa-times"></i></a></p>\n' +
        '</div>\n' +
        '</div>';
    $('#post_selected_files').append(file);
    $('#file_manager').modal('toggle');
    $('#file_manager .file-box').removeClass('selected');
    $('#btn_file_delete').hide();
    $('#btn_file_select').hide();
}

//refresh files
function refresh_files() {
    var data = {};
    addCsrf(data);
    $.ajax({
        type: "POST",
        url: VrConfig.baseURL + "/FileController/getFiles",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                document.getElementById("file_upload_response").innerHTML = obj.content;
            }
        }
    });
}

//load more files
jQuery(function ($) {
    $('#file_manager .file-manager-content').on('scroll', function () {
        var search = $("#input_search_file").val().trim();
        if (search.length < 1) {
            if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
                var min = 0;
                $('#file_upload_response .file-box').each(function () {
                    var value = parseInt($(this).attr('data-file-id'));
                    if (min == 0) {
                        min = value;
                    }
                    if (value < min) {
                        min = value;
                    }
                });
                var data = {
                    'min': min
                };
                addCsrf(data);
                $.ajax({
                    type: "POST",
                    url: VrConfig.baseURL + "/FileController/loadMoreFiles",
                    data: data,
                    success: function (response) {
                        setTimeout(function () {
                            var obj = JSON.parse(response);
                            if (obj.result == 1) {
                                $("#file_upload_response").append(obj.content);
                            }
                        }, 100);
                    }
                });
            }
        }
    })
});

//search file
$(document).on('input', '#input_search_file', function () {
    var search = $(this).val().trim();
    var data = {
        "search": search
    };
    addCsrf(data);
    $.ajax({
        type: "POST",
        url: VrConfig.baseURL + "/FileController/searchFiles",
        data: data,
        success: function (response) {
            if (search.length > 1) {
                var obj = JSON.parse(response);
                if (obj.result == 1) {
                    document.getElementById("file_upload_response").innerHTML = obj.content;
                }
            } else {
                refresh_files();
            }
        }
    });
});


/*
*------------------------------------------------------------------------------------------
* VIDEOS
*------------------------------------------------------------------------------------------
*/

$('#file_manager_video').on('show.bs.modal', function (e) {
    refresh_videos();
});

//select video
$(document).on('click', '#file_manager_video .file-box', function () {
    $('#file_manager_video .file-box').removeClass('selected');
    $(this).addClass('selected');
    var video_id = $(this).attr('data-video-id');
    var video_path = $(this).attr('data-video-path');
    var video_storage = $(this).attr('data-video-storage');
    var video_base_url = $(this).attr('data-video-base-url');
    $('#selected_video_id').val(video_id);
    $('#selected_video_path').val(video_path);
    $('#selected_video_storage').val(video_storage);
    $('#selected_video_base_url').val(video_base_url);
    $('#btn_video_delete').show();
    $('#btn_video_select').show();
});

//delete video
$(document).on('click', '#file_manager_video #btn_video_delete', function () {
    var video_id = $('#selected_video_id').val();
    $('#video_col_id_' + video_id).remove();
    var data = {
        "video_id": video_id
    };
    addCsrf(data);
    $.ajax({
        type: "POST",
        url: VrConfig.baseURL + "/FileController/deleteVideo",
        data: data,
        success: function (response) {
            $('#btn_video_delete').hide();
            $('#btn_video_select').hide();
        }
    });
});

//select video button
$(document).on('click', '#file_manager_video #btn_video_select', function () {
    select_video();
});

//select video on double click
$(document).on('dblclick', '#file_manager_video .file-box', function () {
    select_video();
});

//select video
function select_video() {
    var video_path = $('#selected_video_path').val();
    var video_base_url = $('#selected_video_base_url').val();
    var video_storage = $('#selected_video_storage').val();
    var video = '<video controls class="video-preview">' +
        '<source src="' + video_base_url + video_path + '" type="video/mp4">' +
        '<source src="' + video_base_url + video_path + '" type="video/ogg">' +
        '</video>' +
        '<input type="hidden" name="video_path" value="' + video_path + '">' +
        '<input type="hidden" name="video_storage" value="' + video_storage + '">';
    document.getElementById("post_selected_video").innerHTML = video;
    $('#file_manager_video').modal('toggle');
    $('#file_manager_video .file-box').removeClass('selected');
    $('#btn_video_delete').hide();
    $('#btn_video_select').hide();
}

//refresh videos
function refresh_videos() {
    var data = {};
    addCsrf(data);
    $.ajax({
        type: "POST",
        url: VrConfig.baseURL + "/FileController/getVideos",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                document.getElementById("video_upload_response").innerHTML = obj.content;
            }
        }
    });
}

//load more videos
jQuery(function ($) {
    $('#file_manager_video .file-manager-content').on('scroll', function () {
        var search = $("#input_search_video").val().trim();
        if (search.length < 1) {
            if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
                var min = 0;
                $('#video_upload_response .file-box').each(function () {
                    var value = parseInt($(this).attr('data-video-id'));
                    if (min == 0) {
                        min = value;
                    }
                    if (value < min) {
                        min = value;
                    }
                });
                var data = {
                    'min': min
                };
                addCsrf(data);
                $.ajax({
                    type: "POST",
                    url: VrConfig.baseURL + "/FileController/loadMoreVideos",
                    data: data,
                    success: function (response) {
                        setTimeout(function () {
                            var obj = JSON.parse(response);
                            if (obj.result == 1) {
                                $("#video_upload_response").append(obj.content);
                            }
                        }, 100);
                    }
                });
            }
        }
    })
});

//search video
$(document).on('input', '#input_search_video', function () {
    var search = $(this).val().trim();
    var data = {
        "search": search
    };
    addCsrf(data);
    $.ajax({
        type: "POST",
        url: VrConfig.baseURL + "/FileController/searchVideos",
        data: data,
        success: function (response) {
            if (search.length > 1) {
                var obj = JSON.parse(response);
                if (obj.result == 1) {
                    document.getElementById("video_upload_response").innerHTML = obj.content;
                }
            } else {
                refresh_videos();
            }
        }
    });
});


/*
*------------------------------------------------------------------------------------------
* AUDIOS
*------------------------------------------------------------------------------------------
*/

//select audio
$(document).on('click', '#file_manager_audio .file-box', function () {
    $('#file_manager_audio .file-box').removeClass('selected');
    $(this).addClass('selected');
    var audio_id = $(this).attr('data-audio-id');
    var audio_name = $(this).attr('data-audio-name');
    $('#selected_audio_id').val(audio_id);
    $('#selected_audio_name').val(audio_name);
    $('#btn_audio_delete').show();
    $('#btn_audio_select').show();
});

//delete audio
$(document).on('click', '#file_manager_audio #btn_audio_delete', function () {
    var audio_id = $('#selected_audio_id').val();
    $('#audio_col_id_' + audio_id).remove();
    var data = {
        "audio_id": audio_id
    };
    addCsrf(data);
    $.ajax({
        type: "POST",
        url: VrConfig.baseURL + "/FileController/deleteAudio",
        data: data,
        success: function (response) {
            $('#btn_audio_delete').hide();
            $('#btn_audio_select').hide();
        }
    });
});

//select audio button
$(document).on('click', '#file_manager_audio #btn_audio_select', function () {
    select_audio();
});

//select audio on double click
$(document).on('dblclick', '#file_manager_audio .file-box', function () {
    select_audio();
});

//select audio
function select_audio() {
    var audio_id = $('#selected_audio_id').val();
    var audio_name = $('#selected_audio_name').val();
    $('.play-list-empty').remove();
    var file = '<div id="audio_' + audio_id + '" class="item">\n' +
        '<input type="hidden" name="post_audio_id[]" value="' + audio_id + '">\n' +
        '<div class="left">\n' +
        '<i class="fa fa-music"></i>\n' +
        '</div>\n' +
        '<div class="center">\n' +
        '<span>' + audio_name + '</span>\n' +
        '</div>\n' +
        '<div class="right">\n' +
        '<a href="javascript:void(0)" class="btn btn-sm btn-selected-file-list-item btn-delete-selected-audio" data-value="' + audio_id + '"><i class="fa fa-times"></i></a></p>\n' +
        '</div>\n' +
        '</div>';
    $('#post_audio_list').append(file);
    $('#file_manager_audio').modal('toggle');
    $('#file_manager_audio .file-box').removeClass('selected');
    $('#btn_audio_delete').hide();
    $('#btn_audio_select').hide();
}

//refresh audios
function refresh_audios() {
    var data = {};
    addCsrf(data);
    $.ajax({
        type: "POST",
        url: VrConfig.baseURL + "/FileController/getAudios",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                document.getElementById("audio_upload_response").innerHTML = obj.content;
            }
        }
    });
}

//load more audios
jQuery(function ($) {
    $('#file_manager_audio .file-manager-content').on('scroll', function () {
        var search = $("#input_search_audio").val().trim();
        if (search.length < 1) {
            if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
                var min = 0;
                $('#audio_upload_response .file-box').each(function () {
                    var value = parseInt($(this).attr('data-audio-id'));
                    if (min == 0) {
                        min = value;
                    }
                    if (value < min) {
                        min = value;
                    }
                });
                var data = {
                    'min': min
                };
                addCsrf(data);
                $.ajax({
                    type: "POST",
                    url: VrConfig.baseURL + "/FileController/loadMoreAudios",
                    data: data,
                    success: function (response) {
                        setTimeout(function () {
                            var obj = JSON.parse(response);
                            if (obj.result == 1) {
                                $("#audio_upload_response").append(obj.content);
                            }
                        }, 100);
                    }
                });
            }
        }
    })
});

//search audio
$(document).on('input', '#input_search_audio', function () {
    var search = $(this).val().trim();
    var data = {
        "search": search
    };
    addCsrf(data);
    $.ajax({
        type: "POST",
        url: VrConfig.baseURL + "/FileController/searchAudios",
        data: data,
        success: function (response) {
            if (search.length > 1) {
                var obj = JSON.parse(response);
                if (obj.result == 1) {
                    document.getElementById("audio_upload_response").innerHTML = obj.content;
                }
            } else {
                refresh_audios();
            }
        }
    });
});

//validate
$(document).on('input change keyup paste', '.validate-file-manager-input', function () {
    if ($(this).val().trim() == '') {
        $(this).addClass("input-error");
    } else {
        $(this).removeClass("input-error");
    }
});