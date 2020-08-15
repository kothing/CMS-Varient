<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="quiz_answer_<?php echo $answer->id; ?>" class="answer">
    <div class="answer-inner">
        <a href="javascript:void(0)" class="btn-delete-answer" onclick="delete_quiz_answer_database('<?php echo $answer->id; ?>','<?php echo trans("confirm_answer"); ?>')"><i class="fa fa-times"></i></a>
        <div class="form-group m-b-0">
            <div id="quiz_answer_image_container_answer_<?php echo $answer->id; ?>" class="quiz-answer-image-item">
                <div class="quiz-answer-image-container">
                    <?php if (!empty($answer->image_path)): ?>
                        <input type="hidden" name="answer_image_<?php echo $answer->id; ?>" value="<?php echo $answer->image_path; ?>">
                        <img src="<?php echo base_url() . $answer->image_path; ?>" alt="">
                        <a class="btn btn-danger btn-sm btn-delete-selected-file-image btn-delete-selected-quiz-answer-image" data-question-id="<?php echo $answer->question_id; ?>" data-answer-id="<?php echo $answer->id; ?>" data-is-update="1">
                            <i class="fa fa-times"></i>
                        </a>
                    <?php else: ?>
                        <input type="hidden" name="answer_image_<?php echo $answer->id; ?>" value="">
                        <a class="btn-select-image" data-toggle="modal" data-target="#file_manager_quiz_image" data-quiz-image-type="answer" data-question-id="<?php echo $answer->question_id; ?>" data-answer-id="<?php echo $answer->id; ?>" data-is-update="1">
                            <div class="btn-select-image-inner">
                                <i class="icon-images"></i>
                                <button class="btn"><?php echo trans("select_image"); ?></button>
                            </div>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <textarea name="answer_text_<?php echo $answer->id; ?>" class="form-control answer-text" placeholder="<?php echo trans("answer_text"); ?>"><?php echo $answer->answer_text; ?></textarea>
        </div>
        <?php if ($post_type == 'trivia_quiz'): ?>
            <div class="form-group">
                <div class="answer-radio-container">
                    <div class="left">
                        <input type="radio" name="correct_answer_q<?php echo $answer->question_id; ?>" id="radio_answer_<?php echo $answer->id; ?>" value="<?php echo $answer->id; ?>" class="square-purple" <?php echo ($answer->is_correct == 1) ? 'checked' : ''; ?>>
                    </div>
                    <div class="right">
                        <label for="radio_answer_<?php echo $answer->id; ?>" class="control-label"><?php echo trans('correct'); ?></label>
                    </div>
                </div>
            </div>
        <?php elseif ($post_type == 'personality_quiz'): ?>
            <div class="form-group">
                <div class="answer-select-container">
                    <select name="answer_selected_result_<?php echo $answer->id; ?>" class="form-control personality-quiz-result-dropdown">
                        <option><?php echo trans("select_a_result"); ?></option>
                        <?php if (!empty($quiz_results)):
                            foreach ($quiz_results as $quiz_result):
                                if ($quiz_result->id == $answer->assigned_result_id):?>
                                    <option value="<?php echo $quiz_result->result_order; ?>" selected><?php echo $quiz_result->result_order; ?>. <?php echo html_escape($quiz_result->result_title); ?></option>
                                <?php else: ?>
                                    <option value="<?php echo $quiz_result->result_order; ?>"><?php echo $quiz_result->result_order; ?>. <?php echo html_escape($quiz_result->result_title); ?></option>
                                <?php endif;
                            endforeach;
                        else: ?>
                            <option value="1"><?php echo trans("result"); ?>&nbsp;1</option>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>