//append list item
$(document).on('click', '#btn_append_post_list_item', function () {
    var maxItemOrder = 0;
    $(".input_list_item_order").each(function (index) {
        var val = parseInt($(this).val());
        if (val > maxItemOrder) {
            maxItemOrder = val;
        }
    });
    var data = {
        'new_item_order': maxItemOrder + 1
    };
    addCsrf(data);
    $.ajax({
        type: 'POST',
        url: VrConfig.baseURL + '/PostController/getListItemHTML',
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                $('#list_items_container').append(obj.html);
            }
        }
    });
});

//add list item database
$(document).on('click', '#btn_add_post_list_item_database', function () {
    var postId = $(this).attr('data-post-id');
    var data = {
        'post_id': postId,
        'post_type': postType
    };
    addCsrf(data);
    $.ajax({
        type: 'POST',
        url: VrConfig.baseURL + '/PostController/addListItem',
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                $('#list_items_container').append(obj.html);
            }
        }
    });
});

//update list item title
$(document).on('input change keyup paste', '.input-post-list-item-title', function () {
    var titleId = $(this).attr('data-title-id');
    var text = $(this).val().substring(0, 80);
    if ($(this).val().length > 80) {
        text = text + '...';
    }
    $("#" + titleId).text(text);
});

//delete list item image
$(document).on('click', '.btn-delete-list-item-image', function () {
    var itemId = $(this).attr("data-list-item-id");
    var content = '<input type="hidden" name="list_item_image_id[]" value="0">' +
        '<a class="btn-post-list-item-image" data-toggle="modal" data-target="#file_manager_image" data-image-type="list_item" data-list-item-id="' + itemId + '">' +
        '<i class="fa fa-plus"></i>' +
        '<p class="select-img-text">' + VrConfig.textSelectImage + '</p>' +
        '</a>';
    document.getElementById("post_list_item_image_container_" + itemId).innerHTML = content;
});

//delete list item
function deletePostListItem(itemId, message) {
    swal({
        text: message,
        icon: 'warning',
        buttons: [VrConfig.textCancel, VrConfig.textOk],
        dangerMode: true,
    }).then(function (willDelete) {
        if (willDelete) {
            $('#panel_list_item_' + itemId).remove();
        }
    });
}

//delete list item database
function deletePostListItemDatabase(itemId, postType, message) {
    swal({
        text: message,
        icon: 'warning',
        buttons: [VrConfig.textCancel, VrConfig.textOk],
        dangerMode: true,
    }).then(function (willDelete) {
        if (willDelete) {
            var data = {
                'item_id': itemId,
                'post_type': postType
            };
            addCsrf(data);
            $.ajax({
                type: 'POST',
                url: VrConfig.baseURL + '/PostController/deletePostListItemPost',
                data: data,
                success: function (response) {
                    $('#panel_list_item_' + itemId).remove();
                }
            });
        }
    });
}

//delete selected list item image
$(document).on('click', '.btn-delete-selected-list-item-image', function () {
    var listItemId = $(this).attr("data-list-item-id");
    var isUpdate = $(this).attr("data-is-update");
    var input = '<input type="hidden" name="list_item_image[]" value="">' +
        '<input type="hidden" name="list_item_image_large[]" value="">';
    if (isUpdate) {
        input = '<input type="hidden" name="list_item_image_' + listItemId + '" value=""> ' +
            '<input type="hidden" name="list_item_image_large_' + listItemId + '" value="">';
    }
    var content = '<div class="list-item-image-container">' +
        input +
        '<a class="btn-select-image" data-toggle="modal" data-target="#file_manager_image" data-image-type="list_item" data-list-item-id="' + listItemId + '" data-is-update="' + isUpdate + '">' +
        '<div class="btn-select-image-inner">' +
        '<i class="fa fa-image"></i>' +
        '<button class="btn">' + VrConfig.textSelectImage + '</button>' +
        '</div>' +
        '</a>' +
        '</div>';
    document.getElementById("post_list_item_image_container_" + listItemId).innerHTML = content;
});

/*
*------------------------------------------------------------------------------------------
* Quiz
*------------------------------------------------------------------------------------------
*/

//append quiz question
$(document).on('click', '#btn_append_quiz_question', function () {
    var maxQuestionOrder = 0;
    $(".input_quiz_question_order").each(function (index) {
        var val = parseInt($(this).val());
        if (val > maxQuestionOrder) {
            maxQuestionOrder = val;
        }
    });
    var data = {
        'post_type': postType,
        'new_question_order': maxQuestionOrder + 1
    };
    addCsrf(data);
    $.ajax({
        type: 'POST',
        url: VrConfig.baseURL + '/PostController/getQuizQuestionHTML',
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                $('#quiz_questions_container').append(obj.html);
            }
        }
    });
});

//add quiz question database
$(document).on('click', '#btn_add_quiz_question_database', function () {
    var postId = $(this).attr('data-post-id');
    var data = {
        'post_id': postId,
        'post_type': postType
    };
    addCsrf(data);
    $.ajax({
        type: 'POST',
        url: VrConfig.baseURL + '/PostController/addQuizQuestion',
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                $('#quiz_questions_container').append(obj.html);
            }
        }
    });
});

//update quiz result orders
function updateQuizResultOrders() {
    $("#quiz_results_container .panel-quiz-result").each(function (index) {
        var resultId = $(this).attr('data-result-id');
        $('#quiz_result_order_' + resultId).text(index + 1);
        $('#input_quiz_result_order_' + resultId).val(index + 1);
    });
};

//update question title
$(document).on('input change keyup paste', '.input-question-text', function () {
    var titleId = $(this).attr('data-question-id');
    var text = $(this).val().substring(0, 80);
    if ($(this).val().length > 80) {
        text = text + '...';
    }
    $("#quiz_question_title_" + titleId).text(text);
});

//update result title
$(document).on('input change keyup paste', '.input-result-text', function () {
    var titleId = $(this).attr('data-result-id');
    var text = $(this).val().substring(0, 80);
    if ($(this).val().length > 80) {
        text = text + '...';
    }
    $("#quiz_result_title_" + titleId).text(text);
    updateAnswerResultDropdowns();
    initTinyMCE('.tinyMCEQuiz', 200);
});

//select quiz answer format
$(document).on('click', '.btn-group-answer-formats .btn', function () {
    var answerFormat = $(this).attr('data-answer-format');
    var questionId = $(this).attr('data-question-id');
    $('.btn-group-answer-formats .btn').removeClass('active');
    $('#panel_quiz_question_' + questionId + ' .quiz-answers').removeClass('quiz-answers-format-text');
    $('#panel_quiz_question_' + questionId + ' .quiz-answers').removeClass('quiz-answers-format-large-image');
    if (answerFormat == 'text') {
        $('#panel_quiz_question_' + questionId + ' .quiz-answers').addClass('quiz-answers-format-text');
    } else if (answerFormat == 'large_image') {
        $('#panel_quiz_question_' + questionId + ' .quiz-answers').addClass('quiz-answers-format-large-image');
    }
    $('#input_answer_format_' + questionId).val(answerFormat);
    $(this).addClass('active');
});

//append quiz answer
$(document).on('click', '#btn_add_quiz_answer', function () {
    var questionId = $(this).attr('data-question-id');
    var data = {
        'post_type': postType,
        'question_id': questionId
    };
    addCsrf(data);
    $.ajax({
        type: 'POST',
        url: VrConfig.baseURL + '/PostController/getQuizAnswerHTML',
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                $('#quiz_answers_container_question_' + questionId).append(obj.html);
            }
        }
    });
});

//append quiz answer database
$(document).on('click', '#btn_add_quiz_answer_database', function () {
    var questionId = $(this).attr('data-question-id');
    var data = {
        'post_type': postType,
        'question_id': questionId
    };
    addCsrf(data);
    $.ajax({
        type: 'POST',
        url: VrConfig.baseURL + '/PostController/addQuizQuestionAnswer',
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                $('#quiz_answers_container_question_' + questionId).append(obj.html);
            }
        }
    });
});

//delete quiz question
function deleteQuizQuestion(questionId, message) {
    swal({
        text: message,
        icon: 'warning',
        buttons: [VrConfig.textCancel, VrConfig.textOk],
        dangerMode: true,
    }).then(function (willDelete) {
        if (willDelete) {
            $('#panel_quiz_question_' + questionId).remove();
        }
    });
}

//delete quiz question database
function deleteQuizQuestionDatabase(questionId, message) {
    swal({
        text: message,
        icon: 'warning',
        buttons: [VrConfig.textCancel, VrConfig.textOk],
        dangerMode: true,
    }).then(function (willDelete) {
        if (willDelete) {
            var data = {
                'question_id': questionId
            };
            addCsrf(data);
            $.ajax({
                type: 'POST',
                url: VrConfig.baseURL + '/PostController/deleteQuizQuestion',
                data: data,
                success: function (response) {
                    $('#panel_quiz_question_' + questionId).remove();
                }
            });
        }
    });
}

//delete quiz answer
function deleteQuizAnswer(answerId, message) {
    swal({
        text: message,
        icon: 'warning',
        buttons: [VrConfig.textCancel, VrConfig.textOk],
        dangerMode: true,
    }).then(function (willDelete) {
        if (willDelete) {
            $('#quiz_answer_' + answerId).remove();
        }
    });
}

//delete quiz answer database
function deleteQuizAnswerDatabase(answerId, message) {
    swal({
        text: message,
        icon: 'warning',
        buttons: [VrConfig.textCancel, VrConfig.textOk],
        dangerMode: true,
    }).then(function (willDelete) {
        if (willDelete) {
            var data = {
                'answer_id': answerId
            };
            addCsrf(data);
            $.ajax({
                type: 'POST',
                url: VrConfig.baseURL + '/PostController/deleteQuizQuestionAnswer',
                data: data,
                success: function (response) {
                    $('#quiz_answer_' + answerId).remove();
                }
            });
        }
    });
}

//append quiz result
$(document).on('click', '#btn_append_quiz_result', function () {
    var data = {
        'post_type': postType
    };
    addCsrf(data);
    $.ajax({
        type: 'POST',
        url: VrConfig.baseURL + '/PostController/getQuizResultHTML',
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                $('#quiz_results_container').append(obj.html);
                updateQuizResultOrders();
            }
        }
    });
});

//append quiz question database
$(document).on('click', '#btn_add_quiz_result_database', function () {
    var postId = $(this).attr('data-post-id');
    var data = {
        'post_id': postId,
        'post_type': postType
    };
    addCsrf(data);
    $.ajax({
        type: 'POST',
        url: VrConfig.baseURL + '/PostController/addQuizResult',
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                $('#quiz_results_container').append(obj.html);
                updateQuizResultOrders();
            }
        }
    });
});

//delete quiz result
function deleteQuizResult(resultId, message) {
    swal({
        text: message,
        icon: 'warning',
        buttons: [VrConfig.textCancel, VrConfig.textOk],
        dangerMode: true,
    }).then(function (willDelete) {
        if (willDelete) {
            $('#panel_quiz_' + resultId).remove();
            updateQuizResultOrders();
        }
    });
}

//delete quiz result database
function deleteQuizResultDatabase(resultId, message) {
    swal({
        text: message,
        icon: 'warning',
        buttons: [VrConfig.textCancel, VrConfig.textOk],
        dangerMode: true,
    }).then(function (willDelete) {
        if (willDelete) {
            var data = {
                'result_id': resultId
            };
            addCsrf(data);
            $.ajax({
                type: 'POST',
                url: VrConfig.baseURL + '/PostController/deleteQuizResult',
                data: data,
                success: function (response) {
                    $('#panel_quiz_' + resultId).remove();
                    updateQuizResultOrders();
                }
            });
        }
    });
}

//update quiz result dropdowns
function updateAnswerResultDropdowns() {
    var dropdownOptionsArray = [];
    $("#quiz_results_container .panel-quiz-result").each(function (index) {
        var resultId = $(this).attr("data-result-id");
        var resultText = $("#panel_quiz_" + resultId + " .input-result-text").val();
        var option = [index + 1, resultText];
        dropdownOptionsArray.push(option);
    });
    $(".personality-quiz-result-dropdown").each(function (index) {
        var val = $(this).val();
        $(this).find('option').remove();
        $(this).append('<option value="">' + textSelectResult + '</option>');
        var i;
        for (i = 0; i < dropdownOptionsArray.length; i++) {
            var order = i + 1;
            if (dropdownOptionsArray[i][0] == val) {
                $(this).append('<option value="' + order + '" selected>' + order + '. ' + dropdownOptionsArray[i][1] + '</option>');
            } else {
                $(this).append('<option value="' + order + '">' + order + '. ' + dropdownOptionsArray[i][1] + '</option>');
            }
        }
    });
}

//delete selected quiz question image
$(document).on('click', '.btn-delete-selected-quiz-question-image', function () {
    var questionId = $(this).attr("data-question-id");
    var isUpdate = $(this).attr("data-is-update");
    var input = '<input type="hidden" name="question_image[]" value="">';
    if (isUpdate) {
        input = '<input type="hidden" name="question_image_' + questionId + '" value="">';
    }
    var content = '<div class="quiz-question-image-container">' +
        input +
        '<a class="btn-select-image" data-toggle="modal" data-target="#file_manager_quiz_image" data-quiz-image-type="question" data-question-id="' + questionId + '" data-answer-id="" data-is-update="' + isUpdate + '">' +
        '<div class="btn-select-image-inner">' +
        '<i class="fa fa-image"></i>' +
        '<button class="btn">' + VrConfig.textSelectImage + '</button>' +
        '</div>' +
        '</a>' +
        '</div>';
    document.getElementById("quiz_question_image_container_" + questionId).innerHTML = content;
});

//delete selected quiz answer image
$(document).on('click', '.btn-delete-selected-quiz-answer-image', function () {
    var answeIid = $(this).attr("data-answer-id");
    var questionId = $(this).attr("data-question-id");
    var isUpdate = $(this).attr("data-is-update");
    var input = '<input type="hidden" name="answer_image[]" value="">';
    if (isUpdate) {
        input = '<input type="hidden" name="answer_image_' + answeIid + '" value="">';
    }
    var content = '<div class="quiz-answer-image-container">' +
        input +
        '<a class="btn-select-image" data-toggle="modal" data-target="#file_manager_quiz_image" data-quiz-image-type="answer" data-question-id="' + questionId + '" data-answer-id="' + answeIid + '" data-is-update="' + isUpdate + '">' +
        '<div class="btn-select-image-inner">' +
        '<i class="fa fa-image"></i>' +
        '<button class="btn">' + VrConfig.textSelectImage + '</button>' +
        '</div>' +
        '</a>' +
        '</div>';
    document.getElementById("quiz_answer_image_container_answer_" + answeIid).innerHTML = content;
});

//delete selected quiz result image
$(document).on('click', '.btn-delete-selected-quiz-result-image', function () {
    var resultId = $(this).attr("data-result-id");
    var isUpdate = $(this).attr("data-is-update");
    var input = '<input type="hidden" name="result_image[]" value="">';
    if (isUpdate) {
        input = '<input type="hidden" name="result_image_' + resultId + '" value="">';
    }
    var content = '<div class="quiz-result-image-container">' +
        input +
        '<a class="btn-select-image" data-toggle="modal" data-target="#file_manager_quiz_image" data-quiz-image-type="result" data-result-id="' + resultId + '" data-is-update="' + isUpdate + '">' +
        '<div class="btn-select-image-inner">' +
        '<i class="fa fa-image"></i>' +
        '<button class="btn">' + VrConfig.textSelectImage + '</button>' +
        '</div>' +
        '</a>' +
        '</div>';
    document.getElementById("quiz_result_image_container_" + resultId).innerHTML = content;
});

$(document).ready(function () {
    updateQuizResultOrders();
});

$(document).ajaxStop(function () {
    updateAnswerResultDropdowns();
    initTinyMCE('.tinyMCE', 500);
    initTinyMCE('.tinyMCEQuiz', 200);
});