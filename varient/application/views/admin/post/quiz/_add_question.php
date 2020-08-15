<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if (empty($new_question_order)):
    $new_question_order = 1;
endif; ?>
<?php $unique_id = uniqid(); ?>
<div id="panel_quiz_question_<?php echo $unique_id; ?>" class="panel panel-default panel-quiz-question" data-question-id="<?php echo $unique_id; ?>">
    <div class="panel-heading">
        <h4 class="panel-title" data-toggle="collapse" data-target="#collapse_<?php echo $unique_id; ?>">
            #<span id="quiz_question_order_<?php echo $unique_id; ?>"><?php echo $new_question_order; ?></span>&nbsp;&nbsp;<span id="quiz_question_title_<?php echo $unique_id; ?>"></span>
        </h4>
        <input type="hidden" name="question_unique_id[]" value="<?php echo $unique_id; ?>">
        <div class="btn-group btn-group-post-list-option" role="group">
            <input type="number" name="question_order[]" class="input_quiz_question_order" data-question-id="<?php echo $unique_id; ?>" value="<?php echo $new_question_order; ?>" placeholder="<?php echo trans("order_1"); ?>">
            <button type="button" class="btn btn-default" onclick="delete_quiz_question('<?php echo $unique_id; ?>','<?php echo trans("confirm_question"); ?>');"><i class="fa fa-trash"></i></button>
        </div>
    </div>
    <div id="collapse_<?php echo $unique_id; ?>" class="panel-collapse collapse in">
        <div class="panel-body quiz-question">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label"><?php echo trans("question"); ?></label>
                        <input type="text" class="form-control input-question-text" data-question-id="<?php echo $unique_id; ?>" name="question_title[]" placeholder="<?php echo trans("question"); ?>" value="" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="list-item-description question-description">
                        <div class="left">
                            <label class="control-label"><?php echo trans("image"); ?></label>
                            <div id="quiz_question_image_container_<?php echo $unique_id; ?>">
                                <div class="quiz-question-image-container">
                                    <input type="hidden" name="question_image[]" value="">
                                    <a class='btn-select-image' data-toggle="modal" data-target="#file_manager_quiz_image" data-quiz-image-type="question" data-question-id="<?php echo $unique_id; ?>" data-answer-id="" data-is-update="0">
                                        <div class="btn-select-image-inner">
                                            <i class="icon-images"></i>
                                            <button class="btn"><?php echo trans("select_image"); ?></button>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="right">
                            <div id="editor_<?php echo $unique_id; ?>">
                                <label class="control-label"><?php echo trans("description"); ?></label>
                                <textarea class="tinyMCEQuiz form-control" name="question_description[]"></textarea>
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
                    <div class="quiz-answers">
                        <div class="row">
                            <div class="col-sm-12 btn-group-answer-formats-container">
                                <input type="hidden" name="answer_format[]" id="input_answer_format_<?php echo $unique_id; ?>" value="small_image">
                                <span class="span-answer-format"><?php echo trans("answer_format"); ?></span>
                                <div class="btn-group btn-group-answer-formats" role="group">
                                    <button type="button" class="btn btn-default active" data-answer-format="small_image" data-question-id="<?php echo $unique_id; ?>"><i class="fa fa-th"></i></button>
                                    <button type="button" class="btn btn-default" data-answer-format="large_image" data-question-id="<?php echo $unique_id; ?>"><i class="fa fa-th-large"></i></button>
                                    <button type="button" class="btn btn-default" data-answer-format="text" data-question-id="<?php echo $unique_id; ?>"><i class="fa fa-th-list"></i></button>
                                </div>
                            </div>
                        </div>
                        <div id="quiz_answers_container_question_<?php echo $unique_id; ?>" class="row row-answer">
                            <?php $this->load->view("admin/post/quiz/_add_answer", ['question_id' => $unique_id]);
                            $this->load->view("admin/post/quiz/_add_answer", ['question_id' => $unique_id]); ?>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <button type="button" id="btn_add_quiz_answer" class="btn btn-add-answer" data-question-id="<?php echo $unique_id; ?>"><i class="fa fa-plus"></i>&nbsp;<?php echo trans("add_answer"); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
