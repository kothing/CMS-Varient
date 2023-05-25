<?php $answerUniqueID = uniqid(); ?>
<div id="quiz_answer_<?= $answerUniqueID; ?>" class="answer">
    <div class="answer-inner">
        <a href="javascript:void(0)" class="btn-delete-answer" onclick="deleteQuizAnswer('<?= $answerUniqueID; ?>','<?= clrQuotes(trans("confirm_answer")); ?>')"><i class="fa fa-times"></i></a>
        <div class="form-group m-b-0">
            <input type="hidden" name="answer_unique_id_question_<?= $questionId; ?>[]" value="<?= $answerUniqueID; ?>">
            <div id="quiz_answer_image_container_answer_<?= $answerUniqueID; ?>" class="quiz-answer-image-item">
                <div class="quiz-answer-image-container">
                    <input type="hidden" name="answer_image_question_<?= $questionId; ?>[]" value="">
                    <input type="hidden" name="answer_image_question_storage_<?= $questionId; ?>[]" value="">
                    <a class="btn-select-image" data-toggle="modal" data-target="#file_manager_quiz_image" data-quiz-image-type="answer" data-question-id="<?= $questionId; ?>" data-answer-id="<?= $answerUniqueID; ?>" data-is-update="0">
                        <div class="btn-select-image-inner">
                            <i class="fa fa-image"></i>
                            <button class="btn"><?= trans("select_image"); ?></button>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="form-group">
            <textarea name="answer_text_question_<?= $questionId; ?>[]" class="form-control answer-text" placeholder="<?= trans("answer_text"); ?>"></textarea>
        </div>
        <?php if ($postType == 'trivia_quiz'): ?>
            <div class="form-group">
                <div class="answer-radio-container">
                    <div class="left">
                        <input type="radio" name="correct_answer_question_<?= $questionId; ?>" id="radio_answer_<?= $answerUniqueID; ?>" value="<?= $answerUniqueID; ?>" class="square-purple">
                    </div>
                    <div class="right">
                        <label for="radio_answer_<?= $answerUniqueID; ?>" class="control-label"><?= trans('correct'); ?></label>
                    </div>
                </div>
            </div>
        <?php elseif ($postType == 'personality_quiz'): ?>
            <div class="form-group">
                <div class="answer-select-container">
                    <select name="answer_selected_result_question_<?= $questionId; ?>[]" class="form-control personality-quiz-result-dropdown">
                        <option><?= trans("select_a_result"); ?></option>
                        <option value="1">1.</option>
                    </select>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

