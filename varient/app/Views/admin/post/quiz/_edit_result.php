<div id="panel_quiz_<?= $result->id; ?>" class="panel panel-default panel-quiz-result" data-result-id="<?= $result->id; ?>">
    <div class="panel-heading">
        <h4 class="panel-title" data-toggle="collapse" data-target="#collapse_result_<?= $result->id; ?>">
            #<span id="quiz_result_order_<?= $result->id; ?>"></span>&nbsp;&nbsp;<span id="quiz_result_title_<?= $result->id; ?>"><?= esc($result->result_title); ?></span>
        </h4>
        <input type="hidden" name="result_order_<?= $result->id; ?>" id="input_quiz_result_order_<?= $result->id; ?>" value="">
        <div class="btn-group btn-group-post-list-option" role="group">
            <button type="button" class="btn btn-default" onclick="deleteQuizResultDatabase('<?= $result->id; ?>','<?= clrQuotes(trans("confirm_result")); ?>');"><i class="fa fa-trash"></i></button>
        </div>
    </div>
    <div id="collapse_result_<?= $result->id; ?>" class="panel-collapse collapse <?= empty($result->result_title) && empty($result->description) && empty($result->image_path) ? 'in' : ''; ?>">
        <div class="panel-body quiz-question">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label"><?= trans("result"); ?></label>
                        <input type="text" class="form-control input-result-text" data-result-id="<?= $result->id; ?>" name="result_title_<?= $result->id; ?>" placeholder="<?= trans("result"); ?>" value="<?= esc($result->result_title); ?>">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="list-item-description question-description result-description">
                        <div class="left">
                            <label class="control-label"><?= trans("image"); ?></label>
                            <div id="quiz_result_image_container_<?= $result->id; ?>">
                                <div class="quiz-question-image-container">
                                    <?php if (!empty($result->image_path)):
                                        $imgBaseURL = getBaseURLByStorage($result->image_storage); ?>
                                        <input type="hidden" name="result_image_<?= $result->id; ?>" value="<?= $result->image_path; ?>">
                                        <input type="hidden" name="result_image_storage_<?= $result->id; ?>" value="<?= $result->image_storage; ?>">
                                        <img src="<?= $imgBaseURL . $result->image_path; ?>" alt="">
                                        <a class="btn btn-danger btn-sm btn-delete-selected-file-image btn-delete-selected-quiz-result-image" data-result-id="<?= $result->id; ?>" data-is-update="1">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    <?php else: ?>
                                        <input type="hidden" name="result_image_<?= $result->id; ?>" value="">
                                        <input type="hidden" name="result_image_storage_<?= $result->id; ?>" value="">
                                        <a class="btn-select-image" data-toggle="modal" data-target="#file_manager_quiz_image" data-quiz-image-type="result" data-result-id="<?= $result->id; ?>" data-is-update="1">
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
                            <div id="editor_result_<?= $result->id; ?>">
                                <label class="control-label"><?= trans("description"); ?></label>
                                <textarea class="tinyMCEQuiz form-control" name="result_description_<?= $result->id; ?>"><?= $result->description; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if ($postType == 'trivia_quiz'): ?>
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="control-label">
                                    <?= trans("number_of_correct_answers"); ?>
                                    <small class="small-title-inline">(<?= trans("number_of_correct_answers_range"); ?>)</small>
                                </label>
                            </div>
                            <div class="col-sm-5">
                                <input type="number" class="form-control input-question-text" data-result-id="<?= $result->id; ?>" name="min_correct_count_<?= $result->id; ?>" placeholder="<?= trans("min"); ?>" value="<?= $result->min_correct_count; ?>">
                            </div>
                            <div class="col-sm-5">
                                <input type="number" class="form-control input-question-text" data-result-id="<?= $result->id; ?>" name="max_correct_count_<?= $result->id; ?>" placeholder="<?= trans("max"); ?>" value="<?= $result->max_correct_count; ?>">
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>