<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if (!empty($subcategories)): ?>
    <ul id="<?php echo "tabs-" . html_escape($category->name_slug) . "-" . html_escape($category->id); ?>" class="nav nav-tabs pull-right sub-block-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#all-<?php echo html_escape($category->id); ?>" role="tab" data-toggle="tab"><?php echo trans("all"); ?></a></li>
        <?php $i = 1;
        foreach ($subcategories as $subcategory):
            if ($i < 5): ?>
                <li role="presentation">
                    <a href="#<?php echo html_escape($subcategory->name_slug); ?>-<?php echo html_escape($subcategory->id); ?>" role="tab" data-toggle="tab">
                        <?php echo html_escape($subcategory->name); ?>
                    </a>
                </li>
            <?php endif;
            $i++;
        endforeach; ?>

        <?php if (count($subcategories) >= 5): ?>
            <li>
                <a href="javascript:void(0)" class="dropdown-toggle btn-block-more" type="button" data-toggle="dropdown">
                    <span class="icon-ellipsis-h more subcategories-more-icon"></span>
                </a>
                <div class="dropdown-menu sub-block-dropdown pull-right">
                    <ul id="<?php echo "tabs-" . html_escape($category->name_slug) . "-" . html_escape($category->id); ?>" class="nav nav-tabs pull-right" role="tablist">
                        <?php $i = 1;
                        foreach ($subcategories as $subcategory):
                            if ($i >= 5): ?>
                                <li role="presentation">
                                    <a href="#<?php echo html_escape($subcategory->name_slug); ?>-<?php echo html_escape($subcategory->id); ?>" role="tab" data-toggle="tab">
                                        <?php echo html_escape($subcategory->name); ?>
                                    </a>
                                </li>
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
            <ul id="<?php echo "tabs-" . html_escape($category->name_slug) . "-" . $category->id; ?>" class="nav nav-tabs pull-right" role="tablist">
                <li role="presentation" class="active"><a href="#all-<?php echo $category->id; ?>" role="tab" data-toggle="tab"><?php echo trans("all"); ?></a></li>

                <?php foreach ($subcategories as $subcategory): ?>
                    <li role="presentation">
                        <a href="#<?php echo html_escape($subcategory->name_slug); ?>-<?php echo $subcategory->id; ?>" role="tab" data-toggle="tab"><?php echo html_escape($subcategory->name); ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>



