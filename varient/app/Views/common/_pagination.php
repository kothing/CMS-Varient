<?php if (countItems($pager->links()) > 1): ?>
    <nav aria-label="<?= lang('Pager.pageNavigation') ?>">
        <ul class="pagination justify-content-end">
            <?php if ($pager->hasPreviousPage()) : ?>
                <li class="page-item">
                    <a href="<?= $pager->getFirst() ?>" class="page-link" aria-label="">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li class="page-item">
                    <a href="<?= $pager->getPreviousPage() ?>" class="page-link" aria-label="">
                        <span aria-hidden="true">&lsaquo;</span>
                    </a>
                </li>
            <?php endif;
            foreach ($pager->links() as $link) : ?>
                <li class="page-item<?= $link['active'] ? ' active' : ''; ?>">
                    <a href="<?= $link['uri'] ?>" class="page-link">
                        <?= $link['title'] ?>
                    </a>
                </li>
            <?php endforeach;
            if ($pager->hasNextPage()) : ?>
                <li class="page-item">
                    <a href="<?= $pager->getNextPage() ?>" class="page-link" aria-label="">
                        <span aria-hidden="true">&rsaquo;</span>
                    </a>
                </li>
                <li class="page-item">
                    <a href="<?= $pager->getLast() ?>" class="page-link" aria-label="">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>