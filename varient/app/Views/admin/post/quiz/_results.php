<div class="row">
    <div class="col-sm-12">
        <label class="control-label control-label-content"><?= trans("results"); ?></label>
        <div id="quiz_results_container" class="panel-group post-list-items quiz-questions">
            <input type="hidden" name="content" value="">
            <?php if (!empty($quizResults)):
                foreach ($quizResults as $quizResult):
                    echo view("admin/post/quiz/_edit_result", ['result' => $quizResult, 'postType' => $postType]);
                endforeach;
            else:
                echo view("admin/post/quiz/_add_result");
            endif; ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 text-center">
        <?php if (!empty($post)): ?>
            <button type="button" id="btn_add_quiz_result_database" data-post-id="<?= $post->id; ?>" class="btn btn-md btn-success btn-add-post-item"><i class="fa fa-plus"></i><?= trans("add_result"); ?></button>
        <?php else: ?>
            <button type="button" id="btn_append_quiz_result" class="btn btn-md btn-success btn-add-post-item"><i class="fa fa-plus"></i><?= trans("add_result"); ?></button>
        <?php endif; ?>
    </div>
</div>