<?php if (!empty($subCategories)): ?>
    <ul class="nav nav-tabs nav-category-block" role="tablist">
        <li class="nav-item category-block-links"><a href="javascript:void(0)" class="nav-link active" data-bs-toggle="tab" data-bs-target="#tabCategoryAll<?= esc($category->id); ?>"><?= trans("all"); ?></a></li>
        <?php $i = 0;
        if (!empty($subCategories)):
            foreach ($subCategories as $subCategory):
                if ($i < 5): ?>
                    <li class="nav-item category-block-links"><a href="javascript:void(0)" class="nav-link" data-bs-toggle="tab" data-bs-target="#tabCategory<?= esc($subCategory->id); ?>"><?= esc($subCategory->name); ?></a></li>
                <?php endif;
                $i++;
            endforeach;
        endif;
        if (countItems($subCategories) >= 5):
            $i = 0; ?>
            <li class="nav-item dropdown category-block-links">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?= trans("more"); ?></a>
                <ul class="dropdown-menu">
                    <?php if (!empty($subCategories)):
                        foreach ($subCategories as $subCategory):
                            if ($i >= 5): ?>
                                <li><a href="javascript:void(0)" class="dropdown-item" data-bs-toggle="tab" data-bs-target="#tabCategory<?= esc($subCategory->id); ?>"><?= esc($subCategory->name); ?></a></li>
                            <?php endif;
                            $i++;
                        endforeach;
                    endif; ?>
                </ul>
            </li>
        <?php endif; ?>
        <li class="nav-item dropdown category-block-links-mobile">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?= trans("more"); ?></a>
            <ul class="dropdown-menu">
                <li><a href="javascript:void(0)" class="dropdown-item" data-bs-toggle="tab" data-bs-target="#tabCategoryAll<?= esc($category->id); ?>"><?= trans("all"); ?></a></li>
                <?php if (!empty($subCategories)):
                    foreach ($subCategories as $subCategory): ?>
                        <li><a href="javascript:void(0)" class="dropdown-item" data-bs-toggle="tab" data-bs-target="#tabCategory<?= esc($subCategory->id); ?>"><?= esc($subCategory->name); ?></a></li>
                    <?php endforeach;
                endif; ?>
            </ul>
        </li>
    </ul>
<?php endif; ?>