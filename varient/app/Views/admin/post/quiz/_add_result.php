<?php $resultUniqueID = 'result_' . uniqid(); ?>
<div id="panel_quiz_<?= $resultUniqueID; ?>" class="panel panel-default panel-quiz-result" data-result-id="<?= $resultUniqueID; ?>">
    <div class="panel-heading">
        <h4 class="panel-title" data-toggle="collapse" data-target="#collapse_<?= $resultUniqueID; ?>">
            #<span id="quiz_result_order_<?= $resultUniqueID; ?>"></span>&nbsp;&nbsp;<span id="quiz_result_title_<?= $resultUniqueID; ?>"></span>
        </h4>
        <input type="hidden" name="result_order[]" id="input_quiz_result_order_<?= $resultUniqueID; ?>" value="">
        <div class="btn-group btn-group-post-list-option" role="group">
            <button type="button" class="btn btn-default" onclick="deleteQuizResult('<?= $resultUniqueID; ?>','<?= clrQuotes(trans("confirm_result")); ?>');"><i class="fa fa-trash"></i></button>
        </div>
    </div>
    <div id="collapse_<?= $resultUniqueID; ?>" class="panel-collapse collapse in">
        <div class="panel-body quiz-question">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label"><?= trans("result"); ?></label>
                        <input type="text" class="form-control input-result-text" id="input_result_text_<?= $resultUniqueID; ?>" data-result-id="<?= $resultUniqueID; ?>" name="result_title[]" placeholder="<?= trans("result"); ?>" value="">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="list-item-description question-description result-description">
                        <div class="left">
                            <label class="control-label"><?= trans("image"); ?></label>
                            <div id="quiz_result_image_container_<?= $resultUniqueID; ?>">
                                <div class="quiz-question-image-container">
                                    <input type="hidden" name="result_image[]" value="">
                                    <input type="hidden" name="result_image_storage[]" value="">
                                    <a class="btn-select-image" data-toggle="modal" data-target="#file_manager_quiz_image" data-quiz-image-type="result" data-result-id="<?= $resultUniqueID; ?>">
                                        <div class="btn-select-image-inner">
                                            <i class="fa fa-image"></i>
                                            <button class="btn"><?= trans("select_image"); ?></button>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="right">
                            <div id="editor_<?= $resultUniqueID; ?>">
                                <label class="control-label"><?= trans("description"); ?></label>
                                <textarea class="tinyMCEQuiz form-control" name="result_description[]"></textarea>
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
                                <input type="number" class="form-control input-question-text" data-result-id="<?= $resultUniqueID; ?>" name="min_correct_count[]" placeholder="<?= trans("min"); ?>" value="">
                            </div>
                            <div class="col-sm-5">
                                <input type="number" class="form-control input-question-text" data-result-id="<?= $resultUniqueID; ?>" name="max_correct_count[]" placeholder="<?= trans("max"); ?>" value="">
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>