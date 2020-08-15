<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="panel_quiz_<?php echo $result->id; ?>" class="panel panel-default panel-quiz-result" data-result-id="<?php echo $result->id; ?>">
    <div class="panel-heading">
        <h4 class="panel-title" data-toggle="collapse" data-target="#collapse_result_<?php echo $result->id; ?>">
            #<span id="quiz_result_order_<?php echo $result->id; ?>"></span>&nbsp;&nbsp;<span id="quiz_result_title_<?php echo $result->id; ?>"><?php echo html_escape($result->result_title); ?></span>
        </h4>
        <input type="hidden" name="result_order_<?php echo $result->id; ?>" id="input_quiz_result_order_<?php echo $result->id; ?>" value="">
        <div class="btn-group btn-group-post-list-option" role="group">
            <button type="button" class="btn btn-default" onclick="delete_quiz_result_database('<?php echo $result->id; ?>','<?php echo trans("confirm_result"); ?>');"><i class="fa fa-trash"></i></button>
        </div>
    </div>
    <div id="collapse_result_<?php echo $result->id; ?>" class="panel-collapse collapse <?php echo (empty($result->result_title) && empty($result->description) && empty($result->image_path)) ? 'in' : ''; ?>">
        <div class="panel-body quiz-question">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label"><?php echo trans("result"); ?></label>
                        <input type="text" class="form-control input-result-text" data-result-id="<?php echo $result->id; ?>" name="result_title_<?php echo $result->id; ?>" placeholder="<?php echo trans("result"); ?>" value="<?php echo html_escape($result->result_title); ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="list-item-description question-description result-description">
                        <div class="left">
                            <label class="control-label"><?php echo trans("image"); ?></label>
                            <div id="quiz_result_image_container_<?php echo $result->id; ?>">
                                <div class="quiz-question-image-container">
                                    <?php if (!empty($result->image_path)): ?>
                                        <input type="hidden" name="result_image_<?php echo $result->id; ?>" value="<?php echo $result->image_path; ?>">
                                        <img src="<?php echo base_url() . $result->image_path; ?>" alt="">
                                        <a class="btn btn-danger btn-sm btn-delete-selected-file-image btn-delete-selected-quiz-result-image" data-result-id="<?php echo $result->id; ?>" data-is-update="1">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    <?php else: ?>
                                        <input type="hidden" name="result_image_<?php echo $result->id; ?>" value="">
                                        <a class="btn-select-image" data-toggle="modal" data-target="#file_manager_quiz_image" data-quiz-image-type="result" data-result-id="<?php echo $result->id; ?>" data-is-update="1">
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
                            <div id="editor_result_<?php echo $result->id; ?>">
                                <label class="control-label"><?php echo trans("description"); ?></label>
                                <textarea class="tinyMCEQuiz form-control" name="result_description_<?php echo $result->id; ?>"><?php echo $result->description; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if ($post_type == 'trivia_quiz'): ?>
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="control-label">
                                    <?php echo trans("number_of_correct_answers"); ?>
                                    <small class="small-title-inline">(<?php echo trans("number_of_correct_answers_range"); ?>)</small>
                                </label>
                            </div>
                            <div class="col-sm-5">
                                <input type="number" class="form-control input-question-text" data-result-id="<?php echo $result->id; ?>" name="min_correct_count_<?php echo $result->id; ?>" placeholder="<?php echo trans("min"); ?>" value="<?php echo $result->min_correct_count; ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                            </div>
                            <div class="col-sm-5">
                                <input type="number" class="form-control input-question-text" data-result-id="<?php echo $result->id; ?>" name="max_correct_count_<?php echo $result->id; ?>" placeholder="<?php echo trans("max"); ?>" value="<?php echo $result->max_correct_count; ?>" <?php echo ($this->rtl == true) ? 'dir="rtl"' : ''; ?>>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>