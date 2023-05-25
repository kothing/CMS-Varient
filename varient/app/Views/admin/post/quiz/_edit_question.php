<?php $answerClass = "";
if ($question->answer_format == 'large_image') {
    $answerClass = "quiz-answers-format-large-image";
} elseif ($question->answer_format == 'text') {
    $answerClass = "quiz-answers-format-text";
} ?>
<div id="panel_quiz_question_<?= $question->id; ?>" class="panel panel-default panel-quiz-question" data-question-id="<?= $question->id; ?>">
    <div class="panel-heading">
        <h4 class="panel-title" data-toggle="collapse" data-target="#collapse_<?= $question->id; ?>">
            #<span id="quiz_question_order_<?= $question->id; ?>"><?= $question->question_order; ?></span>&nbsp;&nbsp;<span id="quiz_question_title_<?= $question->id; ?>"><?= esc($question->question); ?></span>
        </h4>
        <input type="hidden" name="question_order_<?= $question->id; ?>" id="input_quiz_question_order_<?= $question->id; ?>" value="">
        <div class="btn-group btn-group-post-list-option" role="group">
            <input type="number" name="question_order_<?= $question->id; ?>" class="input_quiz_question_order" data-question-id="<?= $question->id; ?>" value="<?= $question->question_order; ?>" placeholder="<?= trans("order_1"); ?>">
            <button type="button" class="btn btn-default" onclick="deleteQuizQuestionDatabase('<?= $question->id; ?>','<?= clrQuotes(trans("confirm_question")); ?>');"><i class="fa fa-trash"></i></button>
        </div>
    </div>
    <div id="collapse_<?= $question->id; ?>" class="panel-collapse collapse <?= empty($post) ? 'in' : ''; ?>">
        <div class="panel-body quiz-question">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label"><?= trans("question"); ?></label>
                        <input type="text" class="form-control input-question-text" data-question-id="<?= $question->id; ?>" name="question_title_<?= $question->id; ?>" placeholder="<?= trans("question"); ?>" value="<?= esc($question->question); ?>">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="list-item-description question-description">
                        <div class="left">
                            <label class="control-label"><?= trans("image"); ?></label>
                            <div id="quiz_question_image_container_<?= $question->id; ?>">
                                <div class="quiz-question-image-container">
                                    <?php if (!empty($question->image_path)):
                                        $imgBaseURL = getBaseURLByStorage($question->image_storage); ?>
                                        <input type="hidden" name="question_image_<?= $question->id; ?>" value="<?= $question->image_path; ?>">
                                        <input type="hidden" name="question_image_storage_<?= $question->id; ?>" value="<?= $question->image_storage; ?>">
                                        <img src="<?= $imgBaseURL . $question->image_path; ?>" alt="">
                                        <a class="btn btn-danger btn-sm btn-delete-selected-file-image btn-delete-selected-quiz-question-image" data-question-id="<?= $question->id; ?>" data-answer-id="" data-is-update="1">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    <?php else: ?>
                                        <input type="hidden" name="question_image_<?= $question->id; ?>" value="">
                                        <input type="hidden" name="question_image_storage_<?= $question->id; ?>" value="">
                                        <a class='btn-select-image' data-toggle="modal" data-target="#file_manager_quiz_image" data-quiz-image-type="question" data-question-id="<?= $question->id; ?>" data-answer-id="" data-is-update="1">
                                            <div class="btn-select-image-inner">
                                                <i class="fa fa-image"></i>
                                                <button class="btn"><?= trans("select_image"); ?></button>
                                            </div>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="right">
                            <div id="editor_<?= $question->id; ?>">
                                <label class="control-label"><?= trans("description"); ?></label>
                                <textarea class="tinyMCEQuiz form-control" name="question_description_<?= $question->id; ?>"><?= $question->description; ?></textarea>
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
                    <div class="quiz-answers <?= $answerClass; ?>">
                        <div class="row">
                            <div class="col-sm-12 btn-group-answer-formats-container">
                                <input type="hidden" name="answer_format_<?= $question->id; ?>" id="input_answer_format_<?= $question->id; ?>" value="<?= esc($question->answer_format); ?>">
                                <span class="span-answer-format"><?= trans("answer_format"); ?></span>
                                <div class="btn-group btn-group-answer-formats" role="group">
                                    <button type="button" class="btn btn-default <?= $question->answer_format == 'small_image' ? 'active' : ''; ?>" data-answer-format="small_image" data-question-id="<?= $question->id; ?>"><i class="fa fa-th"></i></button>
                                    <button type="button" class="btn btn-default <?= $question->answer_format == 'large_image' ? 'active' : ''; ?>" data-answer-format="large_image" data-question-id="<?= $question->id; ?>"><i class="fa fa-th-large"></i></button>
                                    <button type="button" class="btn btn-default <?= $question->answer_format == 'text' ? 'active' : ''; ?>" data-answer-format="text" data-question-id="<?= $question->id; ?>"><i class="fa fa-th-list"></i></button>
                                </div>
                            </div>
                        </div>
                        <div id="quiz_answers_container_question_<?= $question->id; ?>" class="row row-answer">
                            <?php $answers = getQuizQuestionAnswers($question->id);
                            if (!empty($answers)):
                                foreach ($answers as $answer):
                                    echo view("admin/post/quiz/_edit_answer", ['answer' => $answer, 'postType' => $postType]);
                                endforeach;
                            endif; ?>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <button type="button" id="btn_add_quiz_answer_database" class="btn btn-add-answer" data-question-id="<?= $question->id; ?>"><i class="fa fa-plus"></i>&nbsp;<?= trans("add_answer"); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>