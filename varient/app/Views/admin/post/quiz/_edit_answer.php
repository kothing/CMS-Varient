<div id="quiz_answer_<?= $answer->id; ?>" class="answer">
    <div class="answer-inner">
        <a href="javascript:void(0)" class="btn-delete-answer" onclick="deleteQuizAnswerDatabase('<?= $answer->id; ?>','<?= clrQuotes(trans("confirm_answer")); ?>')"><i class="fa fa-times"></i></a>
        <div class="form-group m-b-0">
            <div id="quiz_answer_image_container_answer_<?= $answer->id; ?>" class="quiz-answer-image-item">
                <div class="quiz-answer-image-container">
                    <?php if (!empty($answer->image_path)):
                        $imgBaseURL = getBaseURLByStorage($answer->image_storage); ?>
                        <input type="hidden" name="answer_image_<?= $answer->id; ?>" value="<?= $answer->image_path; ?>">
                        <input type="hidden" name="answer_image_storage_<?= $answer->id; ?>" value="<?= $answer->image_storage; ?>">
                        <img src="<?= $imgBaseURL . $answer->image_path; ?>" alt="">
                        <a class="btn btn-danger btn-sm btn-delete-selected-file-image btn-delete-selected-quiz-answer-image" data-question-id="<?= $answer->question_id; ?>" data-answer-id="<?= $answer->id; ?>" data-is-update="1">
                            <i class="fa fa-times"></i>
                        </a>
                    <?php else: ?>
                        <input type="hidden" name="answer_image_<?= $answer->id; ?>" value="">
                        <input type="hidden" name="answer_image_storage_<?= $answer->id; ?>" value="">
                        <a class="btn-select-image" data-toggle="modal" data-target="#file_manager_quiz_image" data-quiz-image-type="answer" data-question-id="<?= $answer->question_id; ?>" data-answer-id="<?= $answer->id; ?>" data-is-update="1">
                            <div class="btn-select-image-inner">
                                <i class="fa fa-image"></i>
                                <button class="btn"><?= trans("select_image"); ?></button>
                            </div>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <textarea name="answer_text_<?= $answer->id; ?>" class="form-control answer-text" placeholder="<?= trans("answer_text"); ?>"><?= $answer->answer_text; ?></textarea>
        </div>
        <?php if ($postType == 'trivia_quiz'): ?>
            <div class="form-group">
                <div class="answer-radio-container">
                    <div class="left">
                        <input type="radio" name="correct_answer_q<?= $answer->question_id; ?>" id="radio_answer_<?= $answer->id; ?>" value="<?= $answer->id; ?>" class="square-purple" <?= $answer->is_correct == 1 ? 'checked' : ''; ?>>
                    </div>
                    <div class="right">
                        <label for="radio_answer_<?= $answer->id; ?>" class="control-label"><?= trans('correct'); ?></label>
                    </div>
                </div>
            </div>
        <?php elseif ($postType == 'personality_quiz'): ?>
            <div class="form-group">
                <div class="answer-select-container">
                    <select name="answer_selected_result_<?= $answer->id; ?>" class="form-control personality-quiz-result-dropdown">
                        <option><?= trans("select_a_result"); ?></option>
                        <?php if (!empty($quizResults)):
                            foreach ($quizResults as $quizResult):
                                if ($quizResult->id == $answer->assigned_result_id):?>
                                    <option value="<?= $quizResult->result_order; ?>" selected><?= $quizResult->result_order; ?>. <?= esc($quizResult->result_title); ?></option>
                                <?php else: ?>
                                    <option value="<?= $quizResult->result_order; ?>"><?= $quizResult->result_order; ?>. <?= esc($quizResult->result_title); ?></option>
                                <?php endif;
                            endforeach;
                        else: ?>
                            <option value="1"><?= trans("result"); ?>&nbsp;1</option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>