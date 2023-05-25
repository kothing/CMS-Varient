<?php $session = session();
if ($session->getFlashdata('errors')):
    $errors = $session->getFlashdata('errors'); ?>
    <div class="m-b-15">
        <div class="alert alert-danger alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
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
        <div class="alert alert-danger alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <h4>
                <i class="icon fa fa-times"></i>
                <?= $session->getFlashdata('error'); ?>
            </h4>
        </div>
    </div>
<?php elseif ($session->getFlashdata('success')): ?>
    <div class="m-b-15">
        <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            <h4>
                <i class="icon fa fa-check"></i>
                <?= $session->getFlashdata('success'); ?>
            </h4>
        </div>
    </div>
<?php endif; ?>