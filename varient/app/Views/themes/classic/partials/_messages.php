<?php $session = session();
if ($session->getFlashdata('errors')):
    $errors = $session->getFlashdata('errors'); ?>
    <div class="m-b-15">
        <div class="alert alert-danger alert-dismissable alert-messages">
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
<?php endif;
if ($session->getFlashdata('error')): ?>
    <div class="m-b-15">
        <div class="alert alert-danger">
            <?= $session->getFlashdata('error'); ?>
        </div>
    </div>
<?php elseif ($session->getFlashdata('success')): ?>
    <div class="m-b-15">
        <div class="alert alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
            </svg>
            <?= $session->getFlashdata('success'); ?>
        </div>
    </div>
<?php endif; ?>