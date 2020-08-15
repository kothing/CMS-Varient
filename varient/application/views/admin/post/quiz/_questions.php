<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-sm-12">
        <label class="control-label control-label-content"><?php echo trans("questions"); ?></label>
        <div id="quiz_questions_container" class="panel-group post-list-items post-list-items-sort quiz-questions">
            <input type="hidden" name="content" value="">
            <?php if (!empty($quiz_questions)):
                foreach ($quiz_questions as $question):
                    $this->load->view("admin/post/quiz/_update_question", ['question' => $question, 'post_type' => $post_type]);
                endforeach;
            else:
                $this->load->view("admin/post/quiz/_add_question");
            endif; ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 text-center">
        <?php if (!empty($post)): ?>
            <button type="button" id="btn_add_quiz_question_database" data-post-id="<?php echo $post->id; ?>" class="btn btn-md btn-success btn-add-post-item"><i class="fa fa-plus"></i><?php echo trans("add_question"); ?></button>
        <?php else: ?>
            <button type="button" id="btn_append_quiz_question" class="btn btn-md btn-success btn-add-post-item"><i class="fa fa-plus"></i><?php echo trans("add_question"); ?></button>
        <?php endif; ?>
    </div>
</div>