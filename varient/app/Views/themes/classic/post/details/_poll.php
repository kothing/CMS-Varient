<div class="quiz-container">
    <?php $itemCount = 1;
    if (!empty($quizQuestions)):
        foreach ($quizQuestions as $question):
            $totalVotes = 0;
            $userAnswerId = getPollQuestionAnswerByUser($post, $userPollAnswers, $question->id); ?>
            <div id="quiz_question_<?= $question->id; ?>" class="quiz-question <?= !empty($userAnswerId) ? 'quiz-question-answered' : ''; ?>" data-is-last-question="<?= countItems($quizQuestions) == $itemCount ? '1' : '0'; ?>" data-is-poll-public="<?= $post->is_poll_public; ?>">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="title">
                            <?= $itemCount . '. ' . esc($question->question); ?>
                        </h3>
                        <div class="description font-text"><?= $question->description; ?></div>
                        <?php if (!empty($question->image_path)):
                            $questionImgBaseURL = getBaseURLByStorage($question->image_storage); ?>
                            <div class="question-image">
                                <img src="<?= IMG_BASE64_750x500; ?>" data-src="<?= $questionImgBaseURL . $question->image_path; ?>" alt="<?= esc($question->question); ?>" class="lazyload img-responsive" width="856" height="570"/>
                            </div>
                        <?php endif;
                        $questionAnswers = getQuizQuestionAnswers($question->id);
                        if (!empty($questionAnswers)):
                            foreach ($questionAnswers as $answer):
                                $totalVotes += $answer->total_votes;
                            endforeach; ?>
                            <div class="question-answers">
                                <div class="row row-answer">
                                    <?php $i = 1;
                                    foreach ($questionAnswers as $answer):
                                        $answerPercentage = calculatePercentage($totalVotes, $answer->total_votes);
                                        if ($question->answer_format == 'small_image'): ?>
                                            <div class="col-xs-12 col-sm-4 col-answer answer-format-image">
                                                <div id="question_answer_<?= $answer->id; ?>" class="answer answer_<?= $post->post_type; ?> <?= $userAnswerId == $answer->id ? 'answer-correct' : ''; ?>" data-post-id="<?= $post->id; ?>" data-question-id="<?= $question->id; ?>" data-answer-id="<?= $answer->id; ?>" data-answer-answer-format="small_image">
                                                    <?php if (!empty($answer->image_path)):
                                                        $answerImgBaseURL = getBaseURLByStorage($answer->image_storage); ?>
                                                        <div class="answer-image">
                                                            <img src="<?= IMG_BASE64_1x1; ?>" data-src="<?= $answerImgBaseURL . $answer->image_path; ?>" alt="<?= esc($answer->answer_text); ?>" class="lazyload img-responsive" width="273" height="273"/>
                                                            <?php if (!empty($userAnswerId)): ?>
                                                                <div id="ans_progress_<?= $answer->id; ?>">
                                                                    <div class="progress">
                                                                        <?php if ($answerPercentage == 0): ?>
                                                                            <b class="perc-zero">0%</b>
                                                                        <?php else: ?>
                                                                            <div class="progress-bar" style="width: <?= $answerPercentage; ?>%"><b><?= $answerPercentage; ?>%</b></div>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                            <?php else: ?>
                                                                <div id="ans_progress_<?= $answer->id; ?>"></div>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="answer-bottom">
                                                        <div class="answer-radio">
                                                            <i class="quiz-answer-icon <?= $userAnswerId == $answer->id ? 'icon-check-circle' : 'icon-circle-outline'; ?> "></i>
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
                                                <div id="question_answer_<?= $answer->id; ?>" class="answer answer_<?= $post->post_type; ?> <?= $userAnswerId == $answer->id ? 'answer-correct' : ''; ?>" data-post-id="<?= $post->id; ?>" data-question-id="<?= $question->id; ?>" data-answer-id="<?= $answer->id; ?>" data-answer-answer-format="large_image">
                                                    <?php if (!empty($answer->image_path)):
                                                        $answerImgBaseURL = getBaseURLByStorage($answer->image_storage); ?>
                                                        <div class="answer-image">
                                                            <img src="<?= IMG_BASE64_1x1; ?>" data-src="<?= $answerImgBaseURL . $answer->image_path; ?>" alt="<?= esc($answer->answer_text); ?>" class="lazyload img-responsive" width="418.5" height="418.5"/>
                                                            <?php if (!empty($userAnswerId)): ?>
                                                                <div id="ans_progress_<?= $answer->id; ?>">
                                                                    <div class="progress">
                                                                        <?php if ($answerPercentage == 0): ?>
                                                                            <b class="perc-zero">0%</b>
                                                                        <?php else: ?>
                                                                            <div class="progress-bar" style="width: <?= $answerPercentage; ?>%"><b><?= $answerPercentage; ?>%</b></div>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                            <?php else: ?>
                                                                <div id="ans_progress_<?= $answer->id; ?>"></div>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="answer-bottom">
                                                        <div class="answer-radio">
                                                            <i class="quiz-answer-icon <?= $userAnswerId == $answer->id ? 'icon-check-circle' : 'icon-circle-outline'; ?> "></i>
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
                                                <div id="question_answer_<?= $answer->id; ?>" class="answer answer_<?= $post->post_type; ?> <?= $userAnswerId == $answer->id ? 'answer-correct' : ''; ?>" data-post-id="<?= $post->id; ?>" data-question-id="<?= $question->id; ?>" data-answer-id="<?= $answer->id; ?>" data-answer-answer-format="text">
                                                    <?php if (!empty($userAnswerId)): ?>
                                                        <div id="ans_progress_<?= $answer->id; ?>">
                                                            <div class="progress">
                                                                <div class="progress-bar" style="width: <?= $answerPercentage; ?>%"></div>
                                                            </div>
                                                        </div>
                                                    <?php else: ?>
                                                        <div id="ans_progress_<?= $answer->id; ?>"></div>
                                                    <?php endif; ?>
                                                    <div id="ans_progress_<?= $answer->id; ?>"></div>
                                                    <div class="answer-radio">
                                                        <i class="quiz-answer-icon <?= $userAnswerId == $answer->id ? 'icon-check-circle' : 'icon-circle-outline'; ?> "></i>
                                                    </div>
                                                    <div class="answer-text">
                                                        <span><?= esc($answer->answer_text); ?></span>
                                                    </div>
                                                    <div class="answer-vote">
                                                        <span id="text_op_num_votes_<?= $answer->id; ?>"><?= !empty($userAnswerId) ? $answerPercentage . '%' : ''; ?></span>
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
                        <b><?= trans("total_votes"); ?>:&nbsp;<span id="question_votes_<?= $question->id; ?>"><?= $totalVotes; ?></span></b>
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