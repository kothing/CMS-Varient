<div class="row">
    <div class="col-sm-12">
        <label class="control-label control-label-content"><?= trans("questions"); ?></label>
        <div id="quiz_questions_container" class="panel-group post-list-items post-list-items-sort quiz-questions">
            <input type="hidden" name="content" value="">
            <?php if (!empty($quizQuestions)):
                foreach ($quizQuestions as $question):
                    echo view("admin/post/quiz/_edit_question", ['question' => $question, 'postType' => $postType]);
                endforeach;
            else:
                echo view("admin/post/quiz/_add_question");
            endif; ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 text-center">
        <?php if (!empty($post)): ?>
            <button type="button" id="btn_add_quiz_question_database" data-post-id="<?= $post->id; ?>" class="btn btn-md btn-success btn-add-post-item"><i class="fa fa-plus"></i><?= trans("add_question"); ?></button>
        <?php else: ?>
            <button type="button" id="btn_append_quiz_question" class="btn btn-md btn-success btn-add-post-item"><i class="fa fa-plus"></i><?= trans("add_question"); ?></button>
        <?php endif; ?>
    </div>
</div>