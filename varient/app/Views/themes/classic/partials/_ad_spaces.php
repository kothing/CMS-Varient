<?php if (!empty($adSpace)):
    $adCodes = null;
    if (!empty($adSpaces)) {
        foreach ($adSpaces as $item) {
            if ($item->lang_id == $activeLang->id && $item->ad_space == $adSpace) {
                $adCodes = $item;
            }
        }
    }
    if (!empty($adCodes)):
        if (strTrim($adCodes->ad_code_desktop) != ''):?>
            <div class="col-sm-12 col-xs-12 col-bn-ds<?= isset($class) ? ' ' . $class : ''; ?>">
                <div class="row">
                    <div class="bn-content<?= $adSpace == 'sidebar_1' || $adSpace == 'sidebar_2' ? ' bn-sidebar-content' : ''; ?>">
                        <div class="bn-inner bn-ds-<?= $adCodes->id; ?>">
                            <?= strTrim($adCodes->ad_code_desktop); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif;
        if (strTrim($adCodes->ad_code_mobile) != ''): ?>
            <div class="col-sm-12 col-xs-12 col-bn-mb<?= isset($class) ? ' ' . $class : ''; ?>">
                <div class="row">
                    <div class="bn-content">
                        <div class="bn-inner bn-mb-<?= $adCodes->id; ?>">
                            <?= strTrim($adCodes->ad_code_mobile); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif;
    endif;
endif; ?>