var array_quiz_answers = [];
var array_quiz_results = [];
var quiz_answered_questions = [];
var quiz_user_answers = [];
var quiz_correct_count = 0;
var is_last_question_answered = false;

//get quiz answers
function get_quiz_answers(post_id) {
    var data = {
        "post_id": post_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "ajax_controller/get_quiz_answers",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                array_quiz_answers = obj.array_quiz_answers;
            }
        }
    });
}

//get trivia quiz results
function get_quiz_results(post_id) {
    var data = {
        "post_id": post_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "ajax_controller/get_quiz_results",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                array_quiz_results = obj.array_quiz_results;
            }
        }
    });
}

//quiz trivia answer click
$(document).on('click', '.quiz-question .answer_trivia_quiz', function () {
    var post_id = $(this).attr('data-post-id');
    var question_id = $(this).attr('data-question-id');
    var answer_id = $(this).attr('data-answer-id');

    if (array_quiz_answers.length < 1) {
        return false;
    }
    if (jQuery.inArray(question_id, quiz_answered_questions) !== -1) {
        return false;
    }

    $('#question_answer_' + answer_id + ' .quiz-answer-icon').removeClass('icon-circle-outline');
    if (check_quiz_question_answer(question_id, answer_id)) {
        quiz_correct_count += 1;
        $(this).addClass('answer-correct');
        $('#question_answer_' + answer_id + ' .quiz-answer-icon').addClass('icon-check-circle');
        $('#quiz_question_' + question_id + ' .alert-success').show();
    } else {
        var correct_answer_id = get_quiz_question_answer_id(question_id);
        $(this).addClass('answer-wrong');
        $('#question_answer_' + answer_id + ' .quiz-answer-icon').addClass('icon-close-circle');
        //show correct answer
        $('#question_answer_' + correct_answer_id).addClass('answer-correct');
        $('#question_answer_' + correct_answer_id + ' .quiz-answer-icon').removeClass('icon-circle-outline');
        $('#question_answer_' + correct_answer_id + ' .quiz-answer-icon').addClass('icon-check-circle');
        $('#quiz_question_' + question_id + ' .alert-danger').show();
    }

    $('#quiz_question_' + question_id).addClass('quiz-question-answered');
    quiz_answered_questions.push(question_id);

    //check if last question answered
    var is_last_question = $('#quiz_question_' + question_id).attr('data-is-last-question');
    if (is_last_question == 1) {
        is_last_question_answered = true;
    }

    //scroll
    if (is_last_question_answered) {
        var div_element_id = "quiz_result_container";
        //check unanswered questions
        $(".quiz-question").each(function (index) {
            if (!$(this).hasClass('quiz-question-answered')) {
                div_element_id = $(this).attr('id');
            }
        });
        if (div_element_id == "quiz_result_container") {
            setTimeout(function () {
                show_trivia_quiz_result();
            }, 1000);
        }
        setTimeout(function () {
            $('html, body').animate({
                scrollTop: $("#" + div_element_id).offset().top
            }, 500);
        }, 700);
    }
});

//show trivia quiz result
function show_trivia_quiz_result() {
    if (array_quiz_results.length > 0) {
        var result = "";
        var i;
        if (quiz_correct_count == 0) {
            var min_correct = array_quiz_results[0][1];
            var result = array_quiz_results[0][3];
            for (i = 0; i < array_quiz_results.length; i++) {
                if (min_correct > array_quiz_results[i][1]) {
                    var min_correct = array_quiz_results[i][1];
                    var result = array_quiz_results[i][3];
                }
            }
        } else {
            for (i = 0; i < array_quiz_results.length; i++) {
                if (quiz_correct_count >= array_quiz_results[i][1] && quiz_correct_count <= array_quiz_results[i][2]) {
                    var result = array_quiz_results[i][3];
                }
            }
        }
        if (result.length > 0) {
            result = '<p class="quiz-score"><span class="correct">' + txt_correct_answer + ': <b>' + quiz_correct_count + '</b></span> <span class="wrong">' + txt_wrong_answer + ': <b>' + (quiz_answered_questions.length - quiz_correct_count) + '</b></span></p>' + result;
            document.getElementById("quiz_result_container").innerHTML = result;
            $('.btn-play-again-content').show();
        }
    }
}

//quiz personality answer click
$(document).on('click', '.quiz-question .answer_personality_quiz', function () {
    var post_id = $(this).attr('data-post-id');
    var question_id = $(this).attr('data-question-id');
    var answer_id = $(this).attr('data-answer-id');
    var assigned_result_id = $(this).attr('data-answer-assigned-id');

    $('#question_answer_' + answer_id + ' .quiz-answer-icon').removeClass('icon-circle-outline');
    $(this).addClass('answer-correct');
    $('#question_answer_' + answer_id + ' .quiz-answer-icon').addClass('icon-check-circle');

    $('#quiz_question_' + question_id).addClass('quiz-question-answered');
    //set question answered
    quiz_answered_questions.push(question_id);
    //add user select
    quiz_user_answers.push(assigned_result_id);

    //check if last question answered
    var is_last_question = $('#quiz_question_' + question_id).attr('data-is-last-question');
    if (is_last_question == 1) {
        is_last_question_answered = true;
    }
    //scroll
    if (is_last_question_answered) {
        var div_element_id = "quiz_result_container";
        //check unanswered questions
        $(".quiz-question").each(function (index) {
            if (!$(this).hasClass('quiz-question-answered')) {
                div_element_id = $(this).attr('id');
            }
        });
        if (div_element_id == "quiz_result_container") {
            setTimeout(function () {
                show_personality_quiz_result();
            }, 1000);
        }
        setTimeout(function () {
            $('html, body').animate({
                scrollTop: $("#" + div_element_id).offset().top
            }, 500);
        }, 700);
    }
});

//show personality quiz result
function show_personality_quiz_result() {
    var result_id = get_max_occurred_array_value(quiz_user_answers);
    var result;
    var i;
    if (result_id.length < 1) {
        result_id = quiz_user_answers[0];
    }
    for (i = 0; i < array_quiz_results.length; i++) {
        if (result_id == array_quiz_results[i][0]) {
            result = array_quiz_results[i][3];
            break;
        }
    }
    if (result.length > 0) {
        document.getElementById("quiz_result_container").innerHTML = result;
        $('.btn-play-again-content').show();
    }
}

//check quiz question answer
function check_quiz_question_answer(question_id, answer_id) {
    var i;
    for (i = 0; i < array_quiz_answers.length; i++) {
        if (array_quiz_answers[i][0] == question_id) {
            if (array_quiz_answers[i][1] == answer_id) {
                return true;
            }
        }
    }
    return false;
}

//get correct answer id
function get_quiz_question_answer_id(question_id) {
    var i;
    for (i = 0; i < array_quiz_answers.length; i++) {
        if (array_quiz_answers[i][0] == question_id) {
            return array_quiz_answers[i][1];
        }
    }
}

//get max occurred array value
function get_max_occurred_array_value(array) {
    var counts = {}, max = 0, res;
    for (var v in array) {
        counts[array[v]] = (counts[array[v]] || 0) + 1;
        if (counts[array[v]] > max) {
            max = counts[array[v]];
            res = array[v];
        }
    }
    for (var k in counts) {
        if (counts[k] == max) {
            return k;
        }
    }
}
