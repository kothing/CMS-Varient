<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans('ad_spaces'); ?></h3>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label><?= trans("settings_language"); ?></label>
                    <select name="lang_id" class="form-control" onchange="window.location.href = '<?= adminUrl(); ?>'+'/ad-spaces?lang='+this.value+'&ad_space=<?= strSlug($adSpaceKey); ?>';" style="max-width: 800px;">
                        <?php foreach ($activeLanguages as $language): ?>
                            <option value="<?= $language->id; ?>" <?= $langId == $language->id ? 'selected' : ''; ?>><?= $language->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label><?= trans('select_ad_spaces'); ?></label>
                    <select class="form-control custom-select" name="parent_id" onchange="window.location.href = '<?= adminUrl(); ?>'+'/ad-spaces?lang=<?= cleanNumber($langId); ?>&ad_space='+this.value;" style="max-width: 800px;">
                        <?php foreach ($arrayAdSpaces as $key => $value): ?>
                            <option value="<?= $key; ?>" <?= $key == $adSpace->ad_space ? 'selected' : ''; ?>><?= esc($value); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <form action="<?= base_url('AdminController/adSpacesPost'); ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="back_url" value="<?= currentFullURL(); ?>">
                    <input type="hidden" name="id" value="<?= $adSpace->id; ?>">
                    <?php if (!empty($arrayAdSpaces[$adSpace->ad_space])): ?>
                        <h4>
                            <?= $arrayAdSpaces[$adSpace->ad_space]; ?>
                            <?php if ($adSpace->ad_space == 'posts_top' || $adSpace->ad_space == 'posts_bottom'): ?>
                                <small>(<?= trans("ad_space_posts_exp"); ?>)</small>
                            <?php endif; ?>
                        </h4>
                    <?php endif; ?>
                    <p><strong><?= trans("banner_desktop"); ?></strong>&nbsp;<small class="title-exp">(<?= trans("banner_desktop_exp"); ?>)</small></p>
                    <div class="row-container">
                        <div class="form-group">
                            <label class="m-b-10"><?= trans("ad_size"); ?></label>
                            <div class="row" style="max-width: 500px;">
                                <div class="col-sm-12 col-md-6">
                                    <input type="number" name="desktop_width" class="form-control" value="<?= $adSpace->desktop_width; ?>" min="1" max="5000" placeholder="<?= trans("width"); ?>">
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <input type="number" name="desktop_height" class="form-control" value="<?= $adSpace->desktop_height; ?>" min="1" max="5000" placeholder="<?= trans("height"); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-b-0">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="control-label"><?= trans('paste_ad_code'); ?></label>
                                    <textarea class="form-control text-area-adspace" name="ad_code_desktop" placeholder="<?= trans('paste_ad_code'); ?>"><?= $adSpace->ad_code_desktop; ?></textarea>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label"><?= trans('upload_your_banner'); ?>&nbsp;<small class="small-exp">(<?= trans("create_ad_exp"); ?>)</small></label>
                                    <input type="text" class="form-control" name="url_ad_code_desktop" placeholder="<?= trans('paste_ad_url'); ?>">
                                    <div class="row m-t-15">
                                        <div class="col-sm-12">
                                            <a class='btn bg-olive btn-sm btn-file-upload'>
                                                <?= trans('select_image'); ?>
                                                <input type="file" name="file_ad_code_desktop" size="40" accept=".png, .jpg, .jpeg, .gif" onchange="$('#upload-file-info1').html($(this).val().replace(/.*[\/\\]/, ''));">
                                            </a>
                                        </div>
                                    </div>
                                    <span class='label label-info' id="upload-file-info1"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <p class="m-t-30"><strong><?= trans("banner_mobile"); ?></strong>&nbsp;<small class="title-exp">(<?= trans("banner_mobile_exp"); ?>)</small></p>
                    <div class="row-container">
                        <div class="form-group">
                            <label class="m-b-10"><?= trans("ad_size"); ?></label>
                            <div class="row" style="max-width: 500px;">
                                <div class="col-sm-12 col-md-6">
                                    <input type="number" name="mobile_width" class="form-control" value="<?= $adSpace->mobile_width; ?>" min="1" max="5000" placeholder="<?= trans("width"); ?>">
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <input type="number" name="mobile_height" class="form-control" value="<?= $adSpace->mobile_height; ?>" min="1" max="5000" placeholder="<?= trans("height"); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-b-0">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="control-label"><?= trans('paste_ad_code'); ?></label>
                                    <textarea class="form-control text-area-adspace" name="ad_code_mobile" placeholder="<?= trans('paste_ad_code'); ?>"><?= $adSpace->ad_code_mobile; ?></textarea>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label"><?= trans('upload_your_banner'); ?>&nbsp;<small class="small-exp">(<?= trans("create_ad_exp"); ?>)</small></label>
                                    <input type="text" class="form-control" name="url_ad_code_mobile" placeholder="<?= trans('paste_ad_url'); ?>">
                                    <div class="row m-t-15">
                                        <div class="col-sm-12">
                                            <a class='btn bg-olive btn-sm btn-file-upload'>
                                                <?= trans('select_image'); ?>
                                                <input type="file" name="file_ad_code_mobile" size="40" accept=".png, .jpg, .jpeg, .gif" onchange="$('#upload-file-info2').html($(this).val().replace(/.*[\/\\]/, ''));">
                                            </a>
                                        </div>
                                    </div>
                                    <span class='label label-info' id="upload-file-info2"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if ($activeTheme->theme != 'classic' && ($adSpace->ad_space == 'sidebar_1' || $adSpace->ad_space == 'sidebar_2')): ?>
                        <div class="form-group m-t-30">
                            <label class="m-b-10"><?= trans('where_to_display'); ?></label>
                            <div class="row">
                                <div class="col-sm-12 m-b-5">
                                    <input type="radio" id="radio_category_latest_posts" name="display_category_id" value="latest_posts" class="square-purple" <?= empty($adSpace->display_category_id) ? 'checked' : ''; ?> required>
                                    <label id="label_latest_posts" for="radio_category_latest_posts" class="cursor-pointer" style="font-weight: 400 !important; margin-left: 5px;"><?= trans('latest_posts'); ?></label>
                                </div>
                                <?php if (!empty($categories)):
                                    foreach ($categories as $category):
                                        if ($category->block_type == 'block-2' || $category->block_type == 'block-3' || $category->block_type == 'block-4'):?>
                                            <div class="col-sm-12 m-b-5 category-row category-lang-<?= $category->lang_id; ?>" required>
                                                <input type="radio" id="radio_category_<?= $category->id; ?>" name="display_category_id" value="<?= $category->id; ?>" class="square-purple" <?= $adSpace->display_category_id == $category->id ? 'checked' : ''; ?>>
                                                <label for="radio_category_<?= $category->id; ?>" class="cursor-pointer" style="font-weight: 400 !important; margin-left: 5px;"><?= esc($category->name); ?>&nbsp;(<small><?= trans("category"); ?></small>)</label>
                                            </div>
                                        <?php endif;
                                    endforeach;
                                endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($adSpace->ad_space == 'in_article_1' || $adSpace->ad_space == 'in_article_2'): ?>
                        <div class="form-group m-t-30">
                            <label><?= trans("paragraph"); ?>&nbsp;(<?= trans("ad_space_paragraph_exp"); ?>)</label>
                            <select name="paragraph_number" class="form-control max-500">
                                <?php for ($i = 1; $i <= 50; $i++): ?>
                                    <option value="<?= $i; ?>" <?= $adSpace->paragraph_number == $i ? 'selected' : ''; ?>><?= $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    <?php endif; ?>

                    <div class="row m-t-15">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans('adsense_activation_code'); ?></h3><small class="small-title"><?= trans("custom_footer_codes_exp"); ?></small>
            </div>
            <form action="<?= base_url('AdminController/googleAdsenseCodePost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <textarea name="adsense_activation_code" class="form-control" placeholder="<?= trans('adsense_activation_code'); ?>" style="min-height: 140px;"><?= $generalSettings->adsense_activation_code; ?></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .row-container {
        padding: 20px;
        background-color: #f1f4f6;
    }

    textarea {
        height: 140px !important;
    }

    h4 {
        color: #0d6aad;
        text-align: left;
        font-weight: 600;
        margin-bottom: 15px;
        margin-top: 30px;
    }

    h4 small {
        color: #0d6aad !important;
        font-weight: bold;
    }

    p strong {
        font-size: 16px;
    }

    .title-exp {
        font-size: 14px !important;
        color: #6f7379 !important;
        font-weight: 600;
    }

    .small-exp {
        color: #555 !important;
        font-weight: normal !important;
        font-size: 13px !important;
    }
</style>
<?php if ($activeLang->text_direction == "rtl"): ?>
    <style>
        h4 {
            text-align: right;
        }
    </style>
<?php endif; ?>
