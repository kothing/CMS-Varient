<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $answer_class = "";
if ($question->answer_format == 'large_image') {
    $answer_class = "quiz-answers-format-large-image";
} elseif ($question->answer_format == 'text') {
    $answer_class = "quiz-answers-format-text";
} ?>

<div id="panel_quiz_question_<?php echo $question->id; ?>" class="panel panel-default panel-quiz-question" data-question-id="<?php echo $question->id; ?>">
    <div class="panel-heading">
        <h4 class="panel-title" data-toggle="collapse" data-target="#collapse_<?php echo $question->id; ?>">
            #<span id="quiz_question_order_<?php echo $question->id; ?>"><?php echo $question->question_order; ?></span>&nbsp;&nbsp;<span id="quiz_question_title_<?php echo $question->id; ?>"><?php echo html_escape($question->question); ?></span>
        </h4>
        <input type="hidden" name="question_order_<?php echo $question->id; ?>" id="input_quiz_question_order_<?php echo $question->id; ?>" value="">
        <div class="btn-group btn-group-post-list-option" role="group">
            <input type="number" name="question_order_<?php echo $question->id; ?>" class="input_quiz_question_order" data-question-id="<?php echo $question->id; ?>" value="<?php echo $question->question_order; ?>" placeholder="<?php echo trans("order_1"); ?>">
            <button type="button" class="btn btn-default" onclick="delete_quiz_question_database('<?php echo $question->id; ?>','<?php echo trans("confirm_question"); ?>');"><i class="fa fa-trash"></i></button>
        </div>
    </div>
    <div id="collapse_<?php echo $question->id; ?>" class="panel-collapse collapse <?php echo (empty($post)) ? 'in' : ''; ?>">
        <div class="panel-body quiz-question">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label"><?php echo trans("question"); ?></label>
                        <input type="text" class="form-control input-question-text" data-question-id="<?php echo $question->id; ?>" name="question_title_<?php echo $question->id; ?>" placeholder="<?php echo trans("question"); ?>" value="<?php echo html_escape($question->question); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="list-item-description question-description">
                        <div class="left">
                            <label class="control-label"><?php echo trans("image"); ?></label>
                            <div id="quiz_question_image_container_<?php echo $question->id; ?>">
                                <div class="quiz-question-image-container">
                                    <?php if (!empty($question->image_path)): ?>
                                        <input type="hidden" name="question_image_<?php echo $question->id; ?>" value="<?php echo $question->image_path; ?>">
                                        <img src="<?php echo base_url() . $question->image_path; ?>" alt="">
                                        <a class="btn btn-danger btn-sm btn-delete-selected-file-image btn-delete-selected-quiz-question-image" data-question-id="<?php echo $question->id; ?>" data-answer-id="" data-is-update="1">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    <?php else: ?>
                                        <input type="hidden" name="question_image_<?php echo $question->id; ?>" value="">
                                        <a class='btn-select-image' data-toggle="modal" data-target="#file_manager_quiz_image" data-quiz-image-type="question" data-question-id="<?php echo $question->id; ?>" data-answer-id="" data-is-update="1">
                                            <div class="btn-select-image-inner">
                                                <i class="icon-images"></i>
                                                <button class="btn"><?php echo trans("select_image"); ?></button>
                                            </div>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="right">
                            <div id="editor_<?php echo $question->id; ?>">
                                <label class="control-label"><?php echo trans("description"); ?></label>
                                <textarea class="tinyMCEQuiz form-control" name="question_description_<?php echo $question->id; ?>"><?php echo $question->description; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12 m-b-15">
                            <label class="control-label"><?php echo trans("answers"); ?></label>
                        </div>
                    </div>
                    <div class="quiz-answers <?php echo $answer_class; ?>">
                        <div class="row">
                            <div class="col-sm-12 btn-group-answer-formats-container">
                                <input type="hidden" name="answer_format_<?php echo $question->id; ?>" id="input_answer_format_<?php echo $question->id; ?>" value="<?php echo html_escape($question->answer_format); ?>">
                                <span class="span-answer-format"><?php echo trans("answer_format"); ?></span>
                                <div class="btn-group btn-group-answer-formats" role="group">
                                    <button type="button" class="btn btn-default <?php echo ($question->answer_format == 'small_image') ? 'active' : ''; ?>" data-answer-format="small_image" data-question-id="<?php echo $question->id; ?>"><i class="fa fa-th"></i></button>
                                    <button type="button" class="btn btn-default <?php echo ($question->answer_format == 'large_image') ? 'active' : ''; ?>" data-answer-format="large_image" data-question-id="<?php echo $question->id; ?>"><i class="fa fa-th-large"></i></button>
                                    <button type="button" class="btn btn-default <?php echo ($question->answer_format == 'text') ? 'active' : ''; ?>" data-answer-format="text" data-question-id="<?php echo $question->id; ?>"><i class="fa fa-th-list"></i></button>
                                </div>
                            </div>
                        </div>
                        <div id="quiz_answers_container_question_<?php echo $question->id; ?>" class="row row-answer">
                            <?php $answers = get_quiz_question_answers($question->id);
                            if (!empty($answers)):
                                foreach ($answers as $answer):
                                    $this->load->view("admin/post/quiz/_update_answer", ['answer' => $answer, 'post_type' => $post_type]);
                                endforeach;
                            endif; ?>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <button type="button" id="btn_add_quiz_answer_database" class="btn btn-add-answer" data-question-id="<?php echo $question->id; ?>"><i class="fa fa-plus"></i>&nbsp;<?php echo trans("add_answer"); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>