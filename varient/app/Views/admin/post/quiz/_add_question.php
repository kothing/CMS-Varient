<?php if (empty($newQuestionOrder)) {
    $newQuestionOrder = 1;
}
$uniqueID = uniqid(); ?>
<div id="panel_quiz_question_<?= $uniqueID; ?>" class="panel panel-default panel-quiz-question" data-question-id="<?= $uniqueID; ?>">
    <div class="panel-heading">
        <h4 class="panel-title" data-toggle="collapse" data-target="#collapse_<?= $uniqueID; ?>">
            #<span id="quiz_question_order_<?= $uniqueID; ?>"><?= $newQuestionOrder; ?></span>&nbsp;&nbsp;<span id="quiz_question_title_<?= $uniqueID; ?>"></span>
        </h4>
        <input type="hidden" name="question_unique_id[]" value="<?= $uniqueID; ?>">
        <div class="btn-group btn-group-post-list-option" role="group">
            <input type="number" name="question_order[]" class="input_quiz_question_order" data-question-id="<?= $uniqueID; ?>" value="<?= $newQuestionOrder; ?>" placeholder="<?= trans("order_1"); ?>">
            <button type="button" class="btn btn-default" onclick="deleteQuizQuestion('<?= $uniqueID; ?>','<?= clrQuotes(trans("confirm_question")); ?>');"><i class="fa fa-trash"></i></button>
        </div>
    </div>
    <div id="collapse_<?= $uniqueID; ?>" class="panel-collapse collapse in">
        <div class="panel-body quiz-question">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label"><?= trans("question"); ?></label>
                        <input type="text" class="form-control input-question-text" data-question-id="<?= $uniqueID; ?>" name="question_title[]" placeholder="<?= trans("question"); ?>" value="">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="list-item-description question-description">
                        <div class="left">
                            <label class="control-label"><?= trans("image"); ?></label>
                            <div id="quiz_question_image_container_<?= $uniqueID; ?>">
                                <div class="quiz-question-image-container">
                                    <input type="hidden" name="question_image[]" value="">
                                    <input type="hidden" name="question_image_storage[]" value="">
                                    <a class='btn-select-image' data-toggle="modal" data-target="#file_manager_quiz_image" data-quiz-image-type="question" data-question-id="<?= $uniqueID; ?>" data-answer-id="" data-is-update="0">
                                        <div class="btn-select-image-inner">
                                            <i class="fa fa-image"></i>
                                            <button class="btn"><?= trans("select_image"); ?></button>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="right">
                            <div id="editor_<?= $uniqueID; ?>">
                                <label class="control-label"><?= trans("description"); ?></label>
                                <textarea class="tinyMCEQuiz form-control" name="question_description[]"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12 m-b-15">
                            <label class="control-label"><?= trans("answers"); ?></label>
                        </div>
                    </div>
                    <div class="quiz-answers">
                        <div class="row">
                            <div class="col-sm-12 btn-group-answer-formats-container">
                                <input type="hidden" name="answer_format[]" id="input_answer_format_<?= $uniqueID; ?>" value="small_image">
                                <span class="span-answer-format"><?= trans("answer_format"); ?></span>
                                <div class="btn-group btn-group-answer-formats" role="group">
                                    <button type="button" class="btn btn-default active" data-answer-format="small_image" data-question-id="<?= $uniqueID; ?>"><i class="fa fa-th"></i></button>
                                    <button type="button" class="btn btn-default" data-answer-format="large_image" data-question-id="<?= $uniqueID; ?>"><i class="fa fa-th-large"></i></button>
                                    <button type="button" class="btn btn-default" data-answer-format="text" data-question-id="<?= $uniqueID; ?>"><i class="fa fa-th-list"></i></button>
                                </div>
                            </div>
                        </div>
                        <div id="quiz_answers_container_question_<?= $uniqueID; ?>" class="row row-answer">
                            <?= view("admin/post/quiz/_add_answer", ['questionId' => $uniqueID]);
                            echo view("admin/post/quiz/_add_answer", ['questionId' => $uniqueID]); ?>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <button type="button" id="btn_add_quiz_answer" class="btn btn-add-answer" data-question-id="<?= $uniqueID; ?>"><i class="fa fa-plus"></i>&nbsp;<?= trans("add_answer"); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>