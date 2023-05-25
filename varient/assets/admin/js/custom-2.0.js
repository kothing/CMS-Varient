//update token
$("form").submit(function () {
    $("input[name='" + VrConfig.csrfTokenName + "']").val(getCsrfHash());
});

//datatable
$(document).ready(function () {
    $('#cs_datatable').DataTable({
        "order": [[0, "desc"]],
        "aLengthMenu": [[15, 30, 60, 100], [15, 30, 60, 100, "All"]]
    });
});

//load tags input
$(function () {
    $('#tags_1').tagsInput({
        width: '100%',
        height: '80px',
        'defaultText': '',
    });
    $('#input_allowed_file_extensions').tagsInput({
        width: '100%',
        height: '100px',
        'defaultText': '',
    });
});

//load ICheck
$('input[type="checkbox"].square-purple, input[type="radio"].square-purple').iCheck({
    checkboxClass: 'icheckbox_square-purple',
    radioClass: 'iradio_square-purple',
    increaseArea: '20%'
});
$('#cb_scheduled').on('ifChecked', function () {
    $("#date_published_content").show();
    $("#input_date_published").prop('required', true);
});
$('#cb_scheduled').on('ifUnchecked', function () {
    $("#date_published_content").hide();
    $("#input_date_published").prop('required', false);
});

//color picker with addon
$(".my-colorpicker").colorpicker();

//datetimepicker
$(function () {
    $('#datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss'
    });
});

//delete item
function deleteItem(url, id, message) {
    swal({
        text: message,
        icon: "warning",
        buttons: [VrConfig.textCancel, VrConfig.textOk],
        dangerMode: true,
    }).then(function (willDelete) {
        if (willDelete) {
            var data = {
                'id': id,
            };
            addCsrf(data);
            $.ajax({
                type: 'POST',
                url: VrConfig.baseURL + '/' + url,
                data: data,
                success: function (response) {
                    location.reload();
                }
            });
        }
    });
};

//get menu links by language
function getMenuLinksByLang(val) {
    var data = {
        "lang_id": val
    };
    addCsrf(data);
    $.ajax({
        type: 'POST',
        url: VrConfig.baseURL + '/AdminController/getMenuLinksByLang',
        data: data,
        success: function (response) {
            $('#parent_links').children('option:not(:first)').remove();
            $("#parent_links").append(response);
        }
    });
}

//get parent categories by language
function getParentCategoriesByLang(val) {
    var data = {
        "lang_id": val
    };
    addCsrf(data);
    $.ajax({
        type: 'POST',
        url: VrConfig.baseURL + '/CategoryController/getParentCategoriesByLang',
        data: data,
        success: function (response) {
            $('#categories').children('option:not(:first)').remove();
            $('#subcategories').children('option:not(:first)').remove();
            $("#categories").append(response);
        }
    });
}

//set image as album cover
function setAsAlbumCover(val) {
    var data = {
        "image_id": val
    };
    addCsrf(data);
    $.ajax({
        type: 'POST',
        url: VrConfig.baseURL + '/GalleryController/setAsAlbumCover',
        data: data,
        success: function (response) {
            location.reload();
        }
    });
}

//get gallery albums by language
function getAlbumsByLang(val) {
    var data = {
        "lang_id": val
    };
    addCsrf(data);
    $.ajax({
        type: 'POST',
        url: VrConfig.baseURL + '/GalleryController/getAlbumsByLang',
        data: data,
        success: function (response) {
            $('#albums').children('option:not(:first)').remove();
            $('#categories').children('option:not(:first)').remove();
            $("#albums").append(response);
        }
    });
}

//get gallery categories by album
function getCategoriesByAlbum(val) {
    var data = {
        "album_id": val
    };
    addCsrf(data);
    $.ajax({
        type: 'POST',
        url: VrConfig.baseURL + '/GalleryController/getCategoriesByAlbum',
        data: data,
        success: function (response) {
            $('#categories').children('option:not(:first)').remove();
            $("#categories").append(response);
        }
    });
}

//approve selected comments
function approveSelectedComments() {
    var commentIds = [];
    $("input[name='checkbox-table']:checked").each(function () {
        commentIds.push(this.value);
    });
    var data = {
        'comment_ids': commentIds,
    };
    addCsrf(data);
    $.ajax({
        type: 'POST',
        url: VrConfig.baseURL + '/AdminController/approveSelectedComments',
        data: data,
        success: function (response) {
            location.reload();
        }
    });
};

//delete selected comments
function deleteSelectedComments(message) {
    swal({
        text: message,
        icon: "warning",
        buttons: [VrConfig.textCancel, VrConfig.textOk],
        dangerMode: true,
    }).then(function (willDelete) {
        if (willDelete) {
            var commentIds = [];
            $("input[name='checkbox-table']:checked").each(function () {
                commentIds.push(this.value);
            });
            var data = {
                'comment_ids': commentIds,
            };
            addCsrf(data);
            $.ajax({
                type: 'POST',
                url: VrConfig.baseURL + '/AdminController/deleteSelectedComments',
                data: data,
                success: function (response) {
                    location.reload();
                }
            });
        }
    });
};

//delete selected contact messages
function deleteSelectedContactMessages(message) {
    swal({
        text: message,
        icon: "warning",
        buttons: [VrConfig.textCancel, VrConfig.textOk],
        dangerMode: true,
    }).then(function (willDelete) {
        if (willDelete) {
            var messagesIds = [];
            $("input[name='checkbox-table']:checked").each(function () {
                messagesIds.push(this.value);
            });
            var data = {
                'messages_ids': messagesIds,
            };
            addCsrf(data);
            $.ajax({
                type: 'POST',
                url: VrConfig.baseURL + '/AdminController/deleteSelectedContactMessages',
                data: data,
                success: function (response) {
                    location.reload();
                }
            });
        }
    });
};

//get subcategories
function getSubCategories(val) {
    var data = {
        "parent_id": val
    };
    addCsrf(data);
    $.ajax({
        type: 'POST',
        url: VrConfig.baseURL + '/CategoryController/getSubCategories',
        data: data,
        success: function (response) {
            $('#subcategories').children('option:not(:first)').remove();
            $("#subcategories").append(response);
        }
    });
}

//delete post main image
$(document).on('click', '#btn_delete_post_main_image', function () {
    var content = '<a class="btn-select-image" data-toggle="modal" data-target="#file_manager_image" data-image-type="main">' +
        '<div class="btn-select-image-inner">' +
        '<i class="fa fa-image"></i>' +
        '<button class="btn">' + VrConfig.textSelectImage + '</button>' +
        '</div>' +
        '</a>';
    document.getElementById("post_select_image_container").innerHTML = content;
    $("#post_image_id").val('');
    $("#video_thumbnail_url").val('');
});

//delete post main image database
$(document).on('click', '#btn_delete_post_main_image_database', function () {
    var data = {
        "post_id": $(this).attr("data-post-id")
    };
    addCsrf(data);
    $.ajax({
        type: 'POST',
        url: VrConfig.baseURL + '/PostController/deletePostMainImage',
        data: data,
        success: function (response) {
            var content = '<a class="btn-select-image" data-toggle="modal" data-target="#file_manager_image" data-image-type="main">' +
                '<div class="btn-select-image-inner">' +
                '<i class="fa fa-image"></i>' +
                '<button class="btn">' + VrConfig.textSelectImage + '</button>' +
                '</div>' +
                '</a>';
            document.getElementById("post_select_image_container").innerHTML = content;
            $("#post_image_id").val('');
            $("#video_thumbnail_url").val('');
        }
    });
});

//delete additional image
$(document).on('click', '.btn-delete-additional-image', function () {
    var fileId = $(this).attr("data-value");
    $('.additional-item-' + fileId).remove();
});

//delete additional image from database
$(document).on('click', '.btn-delete-additional-image-database', function () {
    var fileId = $(this).attr("data-value");
    $('.additional-item-' + fileId).remove();
    var data = {
        "file_id": fileId
    };
    addCsrf(data);
    $.ajax({
        type: 'POST',
        url: VrConfig.baseURL + '/PostController/deletePostAdditionalImage',
        data: data,
        success: function (response) {
        }
    });
});

//set home slider order
$(document).on('input', '.input-slider-post-order', function () {
    var id = $(this).attr('data-id');
    var order = $(this).val();
    var data = {
        'id': id,
        'order': order
    };
    addCsrf(data);
    $.ajax({
        type: 'POST',
        url: VrConfig.baseURL + "/PostController/setHomeSliderPostOrderPost",
        data: data,
        success: function (response) {
        }
    });
});

//set featured order
$(document).on('input', '.input-featured-post-order', function () {
    var id = $(this).attr('data-id');
    var order = $(this).val();
    var data = {
        'id': id,
        'order': order
    };
    addCsrf(data);
    $.ajax({
        type: 'POST',
        url: VrConfig.baseURL + "/PostController/setFeaturedPostOrderPost",
        data: data,
        success: function (response) {
        }
    });
});

//delete selected posts
function deleteSelectePosts(message) {
    swal({
        text: message,
        icon: "warning",
        buttons: [VrConfig.textCancel, VrConfig.textOk],
        dangerMode: true,
    }).then(function (willDelete) {
        if (willDelete) {
            var postIds = [];
            $("input[name='checkbox-table']:checked").each(function () {
                postIds.push(this.value);
            });
            var data = {
                'post_ids': postIds,
            };
            addCsrf(data);
            $.ajax({
                type: 'POST',
                url: VrConfig.baseURL + '/PostController/deleteSelectedPosts',
                data: data,
                success: function (response) {
                    location.reload();
                }
            });
        }
    });
};

//post bulk options
function postBulkOptions(operation) {
    var postIds = [];
    $("input[name='checkbox-table']:checked").each(function () {
        postIds.push(this.value);
    });
    var data = {
        'operation': operation,
        'post_ids': postIds,
    };
    addCsrf(data);
    $.ajax({
        type: 'POST',
        url: VrConfig.baseURL + '/PostController/postBulkOptionsPost',
        data: data,
        success: function (response) {
            location.reload();
        }
    });
};

//show video image when there is an img url
$("#video_thumbnail_url").on("input change keyup paste", function () {
    var url = $("#video_thumbnail_url").val();
    var image = '<div class="post-select-image-container">' +
        '<img src="' + url + '" alt="">' +
        '<a id="btn_delete_post_main_image" class="btn btn-danger btn-sm btn-delete-selected-file-image">' +
        '<i class="fa fa-times"></i> ' +
        '</a>' +
        '</div>';
    document.getElementById("post_select_image_container").innerHTML = image;
    $('input[name="post_image_id"]').val('');
});

//show video when there is an embed code
$("#video_embed_code").on("input change keyup paste", function () {
    var embedCode = $("#video_embed_code").val();
    $("#video_embed_preview").attr('src', embedCode);
    $("#video_embed_preview").show();
    if ($("#video_embed_code").val() == '') {
        $("#video_embed_preview").attr('src', '');
        $("#video_embed_preview").hide();
    }
});

//get video from URL
function getVideoFromURL() {
    var url = $("#video_url").val();
    if (url) {
        var data = {
            'url': url,
        };
        addCsrf(data);
        $.ajax({
            type: 'POST',
            url: VrConfig.baseURL + '/PostController/getVideoFromURL',
            data: data,
            success: function (response) {
                var obj = JSON.parse(response);
                if (obj.videoEmbedCode) {
                    $("#video_embed_code").val(obj.videoEmbedCode);
                    $("#video_embed_preview").attr('src', obj.videoEmbedCode);
                    $("#video_embed_preview").show();
                }
                if (obj.videoThumbnail) {
                    $("#video_thumbnail_url").val(obj.videoThumbnail);
                    var image = '<div class="post-select-image-container">' +
                        '<img src="' + obj.videoThumbnail + '" alt="">' +
                        '<a id="btn_delete_post_main_image" class="btn btn-danger btn-sm btn-delete-selected-file-image">' +
                        '<i class="fa fa-times"></i> ' +
                        '</a>' +
                        '</div>';
                    document.getElementById("post_select_image_container").innerHTML = image;
                }
            }
        });
    }
}

//delete post video
function deletePostVideo(postId) {
    var data = {
        'post_id': postId,
    };
    addCsrf(data);
    $.ajax({
        type: 'POST',
        url: VrConfig.baseURL + '/PostController/deletePostVideo',
        data: data,
        success: function (response) {
            document.getElementById("post_selected_video").innerHTML = " ";
            $(".btn-delete-post-video").hide();
        }
    });
}

//delete selected audio
$(document).on('click', '.btn-delete-selected-audio', function () {
    var itemId = $(this).attr("data-value");
    $('#audio_' + itemId).remove();
});

//delete selected audio from database
$(document).on('click', '.btn-delete-selected-audio-database', function () {
    var postAudioId = $(this).attr("data-value");
    $('#post_selected_audio_' + postAudioId).remove();
    var data = {
        'post_audio_id': postAudioId
    };
    addCsrf(data);
    $.ajax({
        type: 'POST',
        url: VrConfig.baseURL + '/PostController/deletePostAudio',
        data: data,
        success: function (response) {
        }
    });
});

//delete selected file
$(document).on('click', '.btn-delete-selected-file', function () {
    var itemId = $(this).attr("data-value");
    $('#file_' + itemId).remove();
});

//delete selected file from database
$(document).on('click', '.btn-delete-selected-file-database', function () {
    var itemId = $(this).attr("data-value");
    $('#post_selected_file_' + itemId).remove();
    var data = {
        'id': itemId
    };
    addCsrf(data);
    $.ajax({
        type: 'POST',
        url: VrConfig.baseURL + '/PostController/deletePostFile',
        data: data,
        success: function (response) {
        }
    });
});

//check all checkboxes
$("#checkAll").click(function () {
    $('input:checkbox').not(this).prop('checked', this.checked);
});

//show hide delete button
$('.checkbox-table').click(function () {
    if ($(".checkbox-table").is(':checked')) {
        $(".btn-table-delete").show();
    } else {
        $(".btn-table-delete").hide();
    }
});

//bootstrap tooltip
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});

//admin index counters
$('.increase-count').each(function () {
    $(this).prop('Counter', 0).animate({
        Counter: $(this).text()
    }, {
        duration: 1000,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now));
        }
    });
});

//disable for 5 seconds
$(document).on('click', '.btn-submit-disable', function () {
    $('.btn-submit-disable').prop('disabled', true);
    setTimeout(function () {
        $('.btn-submit-disable').prop('disabled', false);
    }, 2000);
});

//price input
$('.price-input').keypress(function (event) {
    var $this = $(this);
    if ((event.which != 46 || $this.val().indexOf('.') != -1) &&
        ((event.which < 48 || event.which > 57) &&
            (event.which != 0 && event.which != 8))) {
        event.preventDefault();
    }
    var text = $(this).val();
    if ((text.indexOf('.') != -1) &&
        (text.substring(text.indexOf('.')).length > 2) &&
        (event.which != 0 && event.which != 8) &&
        ($(this)[0].selectionStart >= text.length - 2)) {
        event.preventDefault();
    }
});

//display selected images before upload
$(document).on('change', '#Multifileupload', function () {
    var MultifileUpload = document.getElementById("Multifileupload");
    if (typeof (FileReader) != "undefined") {
        var MultidvPreview = document.getElementById("MultidvPreview");
        MultidvPreview.innerHTML = "";
        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
        for (var i = 0; i < MultifileUpload.files.length; i++) {
            var file = MultifileUpload.files[i];
            var reader = new FileReader();
            reader.onload = function (e) {
                var img = document.createElement("IMG");
                img.height = "100";
                img.width = "100";
                img.src = e.target.result;
                img.id = "Multifileupload_image";
                MultidvPreview.appendChild(img);
                $("#Multifileupload_button").show();
            }
            reader.readAsDataURL(file);
        }
    } else {
        alert("This browser does not support HTML5 FileReader.");
    }
});

//load after AJAX
$(document).ajaxStop(function () {
    $('input[type="checkbox"].square-purple, input[type="radio"].square-purple').iCheck({
        checkboxClass: 'icheckbox_square-purple',
        radioClass: 'iradio_square-purple',
        increaseArea: '20%'
    });
    $('#cb_scheduled').on('ifChecked', function () {
        $("#date_published_content").show();
        $("#input_date_published").prop('required', true);
    });
    $('#cb_scheduled').on('ifUnchecked', function () {
        $("#date_published_content").hide();
        $("#input_date_published").prop('required', false);
    });
});