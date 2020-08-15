<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $answer_unique_id = uniqid(); ?>
<div id="quiz_answer_<?php echo $answer_unique_id; ?>" class="answer">
    <div class="answer-inner">
        <a href="javascript:void(0)" class="btn-delete-answer" onclick="delete_quiz_answer('<?php echo $answer_unique_id; ?>','<?php echo trans("confirm_answer"); ?>')"><i class="fa fa-times"></i></a>
        <div class="form-group m-b-0">
            <input type="hidden" name="answer_unique_id_question_<?php echo $question_id; ?>[]" value="<?php echo $answer_unique_id; ?>">
            <div id="quiz_answer_image_container_answer_<?php echo $answer_unique_id; ?>" class="quiz-answer-image-item">
                <div class="quiz-answer-image-container">
                    <input type="hidden" name="answer_image_question_<?php echo $question_id; ?>[]" value="">
                    <a class="btn-select-image" data-toggle="modal" data-target="#file_manager_quiz_image" data-quiz-image-type="answer" data-question-id="<?php echo $question_id; ?>" data-answer-id="<?php echo $answer_unique_id; ?>" data-is-update="0">
                        <div class="btn-select-image-inner">
                            <i class="icon-images"></i>
                            <button class="btn"><?php echo trans("select_image"); ?></button>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="form-group">
            <textarea name="answer_text_question_<?php echo $question_id; ?>[]" class="form-control answer-text" placeholder="<?php echo trans("answer_text"); ?>"></textarea>
        </div>
        <?php if ($post_type == 'trivia_quiz'): ?>
            <div class="form-group">
                <div class="answer-radio-container">
                    <div class="left">
                        <input type="radio" name="correct_answer_question_<?php echo $question_id; ?>" id="radio_answer_<?php echo $answer_unique_id; ?>" value="<?php echo $answer_unique_id; ?>" class="square-purple">
                    </div>
                    <div class="right">
                        <label for="radio_answer_<?php echo $answer_unique_id; ?>" class="control-label"><?php echo trans('correct'); ?></label>
                    </div>
                </div>
            </div>
        <?php elseif ($post_type == 'personality_quiz'): ?>
            <div class="form-group">
                <div class="answer-select-container">
                    <select name="answer_selected_result_question_<?php echo $question_id; ?>[]" class="form-control personality-quiz-result-dropdown">
                        <option><?php echo trans("select_a_result"); ?></option>
                        <option value="1">1.</option>
                    </select>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

