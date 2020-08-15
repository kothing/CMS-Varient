<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-sm-12">
        <label class="control-label control-label-content"><?php echo trans("results"); ?></label>
        <div id="quiz_results_container" class="panel-group post-list-items quiz-questions">
            <input type="hidden" name="content" value="">
            <?php if (!empty($quiz_results)):
                foreach ($quiz_results as $quiz_result):
                    $this->load->view("admin/post/quiz/_update_result", ['result' => $quiz_result, 'post_type' => $post_type]);
                endforeach;
            else:
                $this->load->view("admin/post/quiz/_add_result");
            endif; ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 text-center">
        <?php if (!empty($post)): ?>
            <button type="button" id="btn_add_quiz_result_database" data-post-id="<?php echo $post->id; ?>" class="btn btn-md btn-success btn-add-post-item"><i class="fa fa-plus"></i><?php echo trans("add_result"); ?></button>
        <?php else: ?>
            <button type="button" id="btn_append_quiz_result" class="btn btn-md btn-success btn-add-post-item"><i class="fa fa-plus"></i><?php echo trans("add_result"); ?></button>
        <?php endif; ?>
    </div>
</div>
