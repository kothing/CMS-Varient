var arrayQuizAnswers = [];
var arrayQuizResults = [];
var quizAnsweredQuestions = [];
var quizUserAnswers = [];
var quizCorrectCount = 0;
var isLastQuestionAnswered = false;

//get quiz answers
function getQuizAnswers(postId) {
    var data = {
        'post_id': postId
    };
    addCsrf(data);
    $.ajax({
        type: 'POST',
        url: VrConfig.baseURL + '/AjaxController/getQuizAnswers',
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                arrayQuizAnswers = obj.arrayQuizAnswers;
            }
        }
    });
}

//get trivia quiz results
function getQuizResults(postId) {
    var data = {
        'post_id': postId
    };
    addCsrf(data);
    $.ajax({
        type: "POST",
        url: VrConfig.baseURL + '/AjaxController/getQuizResults',
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                arrayQuizResults = obj.arrayQuizResults;
            }
        }
    });
}

//quiz trivia answer click
$(document).on('click', '.quiz-question .answer_trivia_quiz', function () {
    var questionId = $(this).attr('data-question-id');
    var answerId = $(this).attr('data-answer-id');
    if (arrayQuizAnswers.length < 1) {
        alert("hey");
        return false;
    }
    if (jQuery.inArray(questionId, quizAnsweredQuestions) !== -1) {
        return false;
    }
    $('#question_answer_' + answerId + ' .quiz-answer-icon').removeClass('icon-circle-outline');
    if (checkQuizQuestionAnswer(questionId, answerId)) {
        quizCorrectCount += 1;
        $(this).addClass('answer-correct');
        $('#question_answer_' + answerId + ' .quiz-answer-icon').addClass('icon-check-circle');
        $('#quiz_question_' + questionId + ' .alert-success').show();
    } else {
        var correctAnswerId = getQuizQuestionAnswerId(questionId);
        $(this).addClass('answer-wrong');
        $('#question_answer_' + answerId + ' .quiz-answer-icon').addClass('icon-close-circle');
        //show correct answer
        $('#question_answer_' + correctAnswerId).addClass('answer-correct');
        $('#question_answer_' + correctAnswerId + ' .quiz-answer-icon').removeClass('icon-circle-outline');
        $('#question_answer_' + correctAnswerId + ' .quiz-answer-icon').addClass('icon-check-circle');
        $('#quiz_question_' + questionId + ' .alert-danger').show();
    }
    $('#quiz_question_' + questionId).addClass('quiz-question-answered');
    quizAnsweredQuestions.push(questionId);

    //check if last question answered
    var isLastQuestion = $('#quiz_question_' + questionId).attr('data-is-last-question');
    if (isLastQuestion == 1) {
        isLastQuestionAnswered = true;
    }
    //scroll
    if (isLastQuestionAnswered) {
        var divElementId = "quiz_result_container";
        //check unanswered questions
        $(".quiz-question").each(function (index) {
            if (!$(this).hasClass('quiz-question-answered')) {
                divElementId = $(this).attr('id');
            }
        });
        if (divElementId == "quiz_result_container") {
            setTimeout(function () {
                showTriviaQuizResult();
            }, 1000);
        }
        setTimeout(function () {
            $('html, body').animate({
                scrollTop: $("#" + divElementId).offset().top
            }, 500);
        }, 700);
    }
});

//show trivia quiz result
function showTriviaQuizResult() {
    if (arrayQuizResults.length > 0) {
        var result = "";
        var i;
        if (quizCorrectCount == 0) {
            var min_correct = arrayQuizResults[0][1];
            var result = arrayQuizResults[0][3];
            for (i = 0; i < arrayQuizResults.length; i++) {
                if (min_correct > arrayQuizResults[i][1]) {
                    var min_correct = arrayQuizResults[i][1];
                    var result = arrayQuizResults[i][3];
                }
            }
        } else {
            for (i = 0; i < arrayQuizResults.length; i++) {
                if (quizCorrectCount >= arrayQuizResults[i][1] && quizCorrectCount <= arrayQuizResults[i][2]) {
                    var result = arrayQuizResults[i][3];
                }
            }
        }
        if (result.length > 0) {
            result = '<p class="quiz-score"><span class="correct">' + VrConfig.textCorrectAnswer + ': <b>' + quizCorrectCount + '</b></span> <span class="wrong">' + VrConfig.textWrongAnswer + ': <b>' + (quizAnsweredQuestions.length - quizCorrectCount) + '</b></span></p>' + result;
            document.getElementById("quiz_result_container").innerHTML = result;
            $('.btn-play-again-content').show();
        }
    }
}

//quiz personality answer click
$(document).on('click', '.quiz-question .answer_personality_quiz', function () {
    var questionId = $(this).attr('data-question-id');
    var answerId = $(this).attr('data-answer-id');
    var assignedResultId = $(this).attr('data-answer-assigned-id');

    $('#question_answer_' + answerId + ' .quiz-answer-icon').removeClass('icon-circle-outline');
    $(this).addClass('answer-correct');
    $('#question_answer_' + answerId + ' .quiz-answer-icon').addClass('icon-check-circle');
    $('#quiz_question_' + questionId).addClass('quiz-question-answered');
    //set question answered
    quizAnsweredQuestions.push(questionId);
    //add user select
    quizUserAnswers.push(assignedResultId);

    //check if last question answered
    var isLastQuestion = $('#quiz_question_' + questionId).attr('data-is-last-question');
    if (isLastQuestion == 1) {
        isLastQuestionAnswered = true;
    }
    //scroll
    if (isLastQuestionAnswered) {
        var divElementId = "quiz_result_container";
        //check unanswered questions
        $(".quiz-question").each(function (index) {
            if (!$(this).hasClass('quiz-question-answered')) {
                divElementId = $(this).attr('id');
            }
        });
        if (divElementId == "quiz_result_container") {
            setTimeout(function () {
                showPersonalityQuizResult();
            }, 1000);
        }
        setTimeout(function () {
            $('html, body').animate({
                scrollTop: $("#" + divElementId).offset().top
            }, 500);
        }, 700);
    }
});

//show personality quiz result
function showPersonalityQuizResult() {
    var resultId = getMaxOccurredArrayValue(quizUserAnswers);
    var result;
    var i;
    if (resultId.length < 1) {
        resultId = quizUserAnswers[0];
    }
    for (i = 0; i < arrayQuizResults.length; i++) {
        if (resultId == arrayQuizResults[i][0]) {
            result = arrayQuizResults[i][3];
            break;
        }
    }
    if (result.length > 0) {
        document.getElementById("quiz_result_container").innerHTML = result;
        $('.btn-play-again-content').show();
    }
}

//check quiz question answer
function checkQuizQuestionAnswer(questionId, answerId) {
    var i;
    for (i = 0; i < arrayQuizAnswers.length; i++) {
        if (arrayQuizAnswers[i][0] == questionId) {
            if (arrayQuizAnswers[i][1] == answerId) {
                return true;
            }
        }
    }
    return false;
}

//get correct answer id
function getQuizQuestionAnswerId(questionId) {
    var i;
    for (i = 0; i < arrayQuizAnswers.length; i++) {
        if (arrayQuizAnswers[i][0] == questionId) {
            return arrayQuizAnswers[i][1];
        }
    }
}

//get max occurred array value
function getMaxOccurredArrayValue(array) {
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