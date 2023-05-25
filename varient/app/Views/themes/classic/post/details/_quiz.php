<div class="quiz-container">
    <?php $itemCount = 1;
    if (!empty($quizQuestions)):
        foreach ($quizQuestions as $question): ?>
            <div id="quiz_question_<?= $question->id; ?>" class="quiz-question" data-is-last-question="<?= countItems($quizQuestions) == $itemCount ? '1' : '0'; ?>">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="title">
                            <?= $itemCount . '. ' . esc($question->question); ?>
                        </h3>
                        <div class="description font-text"><?= $question->description; ?></div>
                        <?php if (!empty($question->image_path)):
                            $questionImgBaseURL = getBaseURLByStorage($question->image_storage); ?>
                            <div class="question-image">
                                <img src="<?= IMG_PATH_BG_LG; ?>" data-src="<?= $questionImgBaseURL . $question->image_path; ?>" alt="<?= esc($question->question); ?>" class="lazyload img-responsive"/>
                            </div>
                        <?php endif;
                        $questionAnswers = getQuizQuestionAnswers($question->id);
                        if (!empty($questionAnswers)):?>
                            <div class="question-answers">
                                <div class="row row-answer">
                                    <?php $i = 1;
                                    foreach ($questionAnswers as $answer):
                                        if ($question->answer_format == 'small_image'): ?>
                                            <div class="col-xs-12 col-sm-4 col-answer answer-format-image">
                                                <div id="question_answer_<?= $answer->id; ?>" class="answer answer_<?= $post->post_type; ?>" data-post-id="<?= $post->id; ?>" data-question-id="<?= $question->id; ?>" data-answer-id="<?= $answer->id; ?>" data-answer-assigned-id="<?= $answer->assigned_result_id; ?>">
                                                    <?php if (!empty($answer->image_path)):
                                                        $answerImgBaseURL = getBaseURLByStorage($answer->image_storage); ?>
                                                        <div class="answer-image">
                                                            <img src="<?= IMG_BASE64_1x1; ?>" data-src="<?= $answerImgBaseURL . $answer->image_path; ?>" alt="<?= esc($answer->answer_text); ?>" class="lazyload img-responsive"/>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="answer-bottom">
                                                        <div class="answer-radio">
                                                            <i class="quiz-answer-icon icon-circle-outline"></i>
                                                        </div>
                                                        <div class="answer-text">
                                                            <span><?= esc($answer->answer_text); ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if ($i % 3 == 0): ?>
                                                <div class="col-sm-12"></div>
                                            <?php endif;
                                        elseif ($question->answer_format == 'large_image'): ?>
                                            <div class="col-xs-12 col-sm-6 col-answer answer-format-image">
                                                <div id="question_answer_<?= $answer->id; ?>" class="answer answer_<?= $post->post_type; ?>" data-post-id="<?= $post->id; ?>" data-question-id="<?= $question->id; ?>" data-answer-id="<?= $answer->id; ?>" data-answer-assigned-id="<?= $answer->assigned_result_id; ?>">
                                                    <?php if (!empty($answer->image_path)):
                                                        $answerImgBaseURL = getBaseURLByStorage($answer->image_storage); ?>
                                                        <div class="answer-image">
                                                            <img src="<?= IMG_BASE64_1x1; ?>" data-src="<?= $answerImgBaseURL . $answer->image_path; ?>" alt="<?= esc($answer->answer_text); ?>" class="lazyload img-responsive"/>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="answer-bottom">
                                                        <div class="answer-radio">
                                                            <i class="quiz-answer-icon icon-circle-outline"></i>
                                                        </div>
                                                        <div class="answer-text">
                                                            <span><?= esc($answer->answer_text); ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if ($i % 2 == 0): ?>
                                                <div class="col-sm-12"></div>
                                            <?php endif;
                                        elseif ($question->answer_format == 'text'): ?>
                                            <div class="col-xs-12 col-sm-12 col-answer answer-format-text">
                                                <div id="question_answer_<?= $answer->id; ?>" class="answer answer_<?= $post->post_type; ?>" data-post-id="<?= $post->id; ?>" data-question-id="<?= $question->id; ?>" data-answer-id="<?= $answer->id; ?>" data-answer-assigned-id="<?= $answer->assigned_result_id; ?>">
                                                    <div class="answer-radio">
                                                        <i class="quiz-answer-icon icon-circle-outline"></i>
                                                    </div>
                                                    <div class="answer-text">
                                                        <span><?= esc($answer->answer_text); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif;
                                        $i++;
                                    endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-xs-12 col-sm-12">
                        <div class="alert alert-success" role="alert">
                            <h4 class="text"><i class="icon-check"></i>&nbsp;&nbsp;<?= trans("correct_answer"); ?></h4>
                        </div>
                        <div class="alert alert-danger" role="alert">
                            <h4 class="text"><i class="icon-cross"></i>&nbsp;&nbsp;<?= trans("wrong_answer"); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <?php $itemCount++;
        endforeach;
    endif; ?>
    <div class="row">
        <div class="col-xs-12 col-sm-12">
            <div id="quiz_result_container"></div>
        </div>
        <div class="col-xs-12 col-sm-12 btn-play-again-content">
            <button type="button" class="btn btn-xl btn-custom" onclick="window.location.reload(); parent.scrollTo(0,0);"><i class="icon-refresh"></i><?= trans("play_again"); ?></button>
        </div>
    </div>
</div>