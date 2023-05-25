<?php if (!empty($subCategories)): ?>
    <ul id="<?= "tabs-" . esc($category->name_slug) . "-" . esc($category->id); ?>" class="nav nav-tabs pull-right sub-block-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#all-<?= esc($category->id); ?>" role="tab" data-toggle="tab"><?= trans("all"); ?></a></li>
        <?php $i = 1;
        foreach ($subCategories as $subCategory):
            if ($i < 5): ?>
                <li role="presentation"><a href="#<?= esc($subCategory->name_slug); ?>-<?= esc($subCategory->id); ?>" role="tab" data-toggle="tab"><?= esc($subCategory->name); ?></a></li>
            <?php endif;
            $i++;
        endforeach; ?>
        <?php if (countItems($subCategories) >= 5): ?>
            <li>
                <a href="javascript:void(0)" class="dropdown-toggle btn-block-more" type="button" data-toggle="dropdown"><span class="icon-ellipsis-h more subcategories-more-icon"></span></a>
                <div class="dropdown-menu sub-block-dropdown pull-right">
                    <ul id="<?= "tabs-" . esc($category->name_slug) . "-" . esc($category->id); ?>" class="nav nav-tabs pull-right" role="tablist">
                        <?php $i = 1;
                        foreach ($subCategories as $subCategory):
                            if ($i >= 5): ?>
                                <li role="presentation"><a href="#<?= esc($subCategory->name_slug); ?>-<?= esc($subCategory->id); ?>" role="tab" data-toggle="tab"><?= esc($subCategory->name); ?></a></li>
                            <?php endif;
                            $i++;
                        endforeach; ?>
                    </ul>
                </div>
            </li>
        <?php endif; ?>
    </ul>
    <div class="sub-block-tabs-mobile">
        <a href="javascript:void(0)" class="dropdown-toggle btn-block-more" type="button" data-toggle="dropdown">
            <span class="icon-ellipsis-h more subcategories-more-icon"></span>
            <span class="caret"></span>
        </a>
        <div class="dropdown-menu sub-block-dropdown pull-right">
            <ul id="<?= "tabs-" . esc($category->name_slug) . "-" . $category->id; ?>" class="nav nav-tabs pull-right" role="tablist">
                <li role="presentation" class="active"><a href="#all-<?= $category->id; ?>" role="tab" data-toggle="tab"><?= trans("all"); ?></a></li>
                <?php foreach ($subCategories as $subCategory): ?>
                    <li role="presentation"><a href="#<?= esc($subCategory->name_slug); ?>-<?= $subCategory->id; ?>" role="tab" data-toggle="tab"><?= esc($subCategory->name); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>