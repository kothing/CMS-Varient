<?php if (!empty($result)): ?>
    <div class="quiz-result">
        <h4 class="title">
            <?= esc($result->result_title); ?>
        </h4>
        <?php if (!empty($result->image_path)):
            $imgBaseURL = getBaseURLByStorage($result->image_storage); ?>
            <img src="<?= $imgBaseURL . $result->image_path; ?>" alt="<?= esc($result->result_title); ?>" class="img-responsive"/>
        <?php endif; ?>
        <div class="description">
            <?= $result->description; ?>
        </div>
    </div>
<?php endif; ?>