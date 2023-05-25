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
        <div class="alert alert-danger alert-message">
            <?= $session->getFlashdata('error'); ?>
        </div>
    </div>
<?php elseif ($session->getFlashdata('success')): ?>
    <div class="m-b-15">
        <div class="alert alert-success alert-message">
            <div class="display-flex">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                </svg>&nbsp;
                <?= $session->getFlashdata('success'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>