<div class="d-flex mb-4">
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
                                    <img src="<?= IMG_BASE64_750x500; ?>" data-src="<?= $questionImgBaseURL . $question->image_path; ?>" alt="<?= esc($question->question); ?>" class="lazyload img-fluid" width="856" height="570"/>
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
                                                                <img src="<?= IMG_BASE64_1x1; ?>" data-src="<?= $answerImgBaseURL . $answer->image_path; ?>" alt="<?= esc($answer->answer_text); ?>" class="lazyload img-fluid" width="273" height="273"/>
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
                                                                <img src="<?= IMG_BASE64_1x1; ?>" data-src="<?= $answerImgBaseURL . $answer->image_path; ?>" alt="<?= esc($answer->answer_text); ?>" class="lazyload img-fluid" width="418.5" height="418.5"/>
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
            <div class="col-sm-12">
                <div id="quiz_result_container"></div>
            </div>
            <div class="col-sm-12 btn-play-again-content">
                <button type="button" class="btn btn-lg btn-custom" onclick="window.location.reload(); parent.scrollTo(0,0);">
                    <?= trans("play_again"); ?>
                    <svg width="16" height="16" viewBox="0 0 1792 1792" fill="#ffffff" class="m-l-5" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1664 256v448q0 26-19 45t-45 19h-448q-42 0-59-40-17-39 14-69l138-138q-148-137-349-137-104 0-198.5 40.5t-163.5 109.5-109.5 163.5-40.5 198.5 40.5 198.5 109.5 163.5 163.5 109.5 198.5 40.5q119 0 225-52t179-147q7-10 23-12 15 0 25 9l137 138q9 8 9.5 20.5t-7.5 22.5q-109 132-264 204.5t-327 72.5q-156 0-298-61t-245-164-164-245-61-298 61-298 164-245 245-164 298-61q147 0 284.5 55.5t244.5 156.5l130-129q29-31 70-14 39 17 39 59z"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>