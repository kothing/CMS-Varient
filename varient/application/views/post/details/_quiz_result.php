<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php if (!empty($result)): ?>
    <div class="quiz-result">
        <h4 class="title">
            <?php echo html_escape($result->result_title); ?>
        </h4>
        <?php if (!empty($result->image_path)): ?>
            <img src="<?php echo base_url() . $result->image_path; ?>" alt="<?php echo html_escape($result->result_title); ?>" class="img-responsive"/>
        <?php endif; ?>
        <div class="description">
            <?php echo $result->description; ?>
        </div>
    </div>
<?php endif; ?>