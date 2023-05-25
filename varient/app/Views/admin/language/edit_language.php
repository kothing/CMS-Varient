<?php $edLangArray = array();
$edLangArray[] = array("short" => "ar", "name" => "Arabic");
$edLangArray[] = array("short" => "hy", "name" => "Armenian");
$edLangArray[] = array("short" => "az", "name" => "Azerbaijani");
$edLangArray[] = array("short" => "eu", "name" => "Basque");
$edLangArray[] = array("short" => "be", "name" => "Belarusian");
$edLangArray[] = array("short" => "bn_BD", "name" => "Bengali (Bangladesh)");
$edLangArray[] = array("short" => "bs", "name" => "Bosnian");
$edLangArray[] = array("short" => "bg_BG", "name" => "Bulgarian");
$edLangArray[] = array("short" => "ca", "name" => "Catalan");
$edLangArray[] = array("short" => "zh_CN", "name" => "Chinese (China)");
$edLangArray[] = array("short" => "zh_TW", "name" => "Chinese (Taiwan)");
$edLangArray[] = array("short" => "hr", "name" => "Croatian");
$edLangArray[] = array("short" => "cs", "name" => "Czech");
$edLangArray[] = array("short" => "da", "name" => "Danish");
$edLangArray[] = array("short" => "dv", "name" => "Divehi");
$edLangArray[] = array("short" => "nl", "name" => "Dutch");
$edLangArray[] = array("short" => "en", "name" => "English");
$edLangArray[] = array("short" => "et", "name" => "Estonian");
$edLangArray[] = array("short" => "fo", "name" => "Faroese");
$edLangArray[] = array("short" => "fi", "name" => "Finnish");
$edLangArray[] = array("short" => "fr_FR", "name" => "French");
$edLangArray[] = array("short" => "gd", "name" => "Gaelic, Scottish");
$edLangArray[] = array("short" => "gl", "name" => "Galician");
$edLangArray[] = array("short" => "ka_GE", "name" => "Georgian");
$edLangArray[] = array("short" => "de", "name" => "German");
$edLangArray[] = array("short" => "el", "name" => "Greek");
$edLangArray[] = array("short" => "he", "name" => "Hebrew");
$edLangArray[] = array("short" => "hi_IN", "name" => "Hindi");
$edLangArray[] = array("short" => "hu_HU", "name" => "Hungarian");
$edLangArray[] = array("short" => "is_IS", "name" => "Icelandic");
$edLangArray[] = array("short" => "id", "name" => "Indonesian");
$edLangArray[] = array("short" => "it", "name" => "Italian");
$edLangArray[] = array("short" => "ja", "name" => "Japanese");
$edLangArray[] = array("short" => "kab", "name" => "Kabyle");
$edLangArray[] = array("short" => "kk", "name" => "Kazakh");
$edLangArray[] = array("short" => "km_KH", "name" => "Khmer");
$edLangArray[] = array("short" => "ko_KR", "name" => "Korean");
$edLangArray[] = array("short" => "ku", "name" => "Kurdish");
$edLangArray[] = array("short" => "lv", "name" => "Latvian");
$edLangArray[] = array("short" => "lt", "name" => "Lithuanian");
$edLangArray[] = array("short" => "lb", "name" => "Luxembourgish");
$edLangArray[] = array("short" => "ml", "name" => "Malayalam");
$edLangArray[] = array("short" => "mn", "name" => "Mongolian");
$edLangArray[] = array("short" => "nb_NO", "name" => "Norwegian Bokmål (Norway)");
$edLangArray[] = array("short" => "fa", "name" => "Persian");
$edLangArray[] = array("short" => "pl", "name" => "Polish");
$edLangArray[] = array("short" => "pt_BR", "name" => "Portuguese (Brazil)");
$edLangArray[] = array("short" => "pt_PT", "name" => "Portuguese (Portugal)");
$edLangArray[] = array("short" => "ro", "name" => "Romanian");
$edLangArray[] = array("short" => "ru", "name" => "Russian");
$edLangArray[] = array("short" => "sr", "name" => "Serbian");
$edLangArray[] = array("short" => "si_LK", "name" => "Sinhala (Sri Lanka)");
$edLangArray[] = array("short" => "sk", "name" => "Slovak");
$edLangArray[] = array("short" => "sl_SI", "name" => "Slovenian (Slovenia)");
$edLangArray[] = array("short" => "es", "name" => "Spanish");
$edLangArray[] = array("short" => "es_MX", "name" => "Spanish (Mexico)");
$edLangArray[] = array("short" => "sv_SE", "name" => "Swedish (Sweden)");
$edLangArray[] = array("short" => "tg", "name" => "Tajik");
$edLangArray[] = array("short" => "ta", "name" => "Tamil");
$edLangArray[] = array("short" => "tt", "name" => "Tatar");
$edLangArray[] = array("short" => "th_TH", "name" => "Thai");
$edLangArray[] = array("short" => "tr", "name" => "Turkish");
$edLangArray[] = array("short" => "ug", "name" => "Uighur");
$edLangArray[] = array("short" => "uk", "name" => "Ukrainian");
$edLangArray[] = array("short" => "vi", "name" => "Vietnamese");
$edLangArray[] = array("short" => "cy", "name" => "Welsh"); ?>
<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-5 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans("update_language"); ?></h3>
            </div>
            <form action="<?= base_url('LanguageController/editLanguagePost'); ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" value="<?= $language->id; ?>">

                <div class="box-body">
                    <div class="form-group">
                        <label><?= trans("language_name"); ?></label>
                        <input type="text" class="form-control" name="name" placeholder="<?= trans("language_name"); ?>" value="<?= $language->name; ?>" maxlength="200" required>
                        <small>(Ex: English)</small>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans("short_form"); ?> </label>
                        <input type="text" class="form-control" name="short_form" placeholder="<?= trans("short_form"); ?>" value="<?= $language->short_form; ?>" maxlength="200" required>
                        <small>(Ex: en)</small>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans("language_code"); ?> </label>
                        <input type="text" class="form-control" name="language_code" placeholder="<?= trans("language_code"); ?>" value="<?= $language->language_code; ?>" maxlength="200" required>
                        <small>(Ex: en_us)</small>
                    </div>

                    <div class="form-group">
                        <label><?= trans('order_1'); ?></label>
                        <input type="number" class="form-control" name="language_order" placeholder="<?= trans('order'); ?>" value="<?= $language->language_order; ?>" min="1" required>
                    </div>

                    <div class="form-group">
                        <label><?= trans('text_editor_language'); ?></label>
                        <select name="text_editor_lang" class="form-control" required>
                            <option value=""><?= trans("select"); ?></option>
                            <?php foreach ($edLangArray as $item): ?>
                                <option value="<?= $item['short']; ?>" <?= $item['short'] == $language->text_editor_lang ? 'selected' : ''; ?>><?= $item['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12">
                                <label><?= trans('text_direction'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" id="rb_type_1" name="text_direction" value="ltr" class="square-purple" <?= $language->text_direction == "ltr" ? 'checked' : ''; ?>>
                                <label for="rb_type_1" class="cursor-pointer"><?= trans("left_to_right"); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" id="rb_type_2" name="text_direction" value="rtl" class="square-purple" <?= $language->text_direction == "rtl" ? 'checked' : ''; ?>>
                                <label for="rb_type_2" class="cursor-pointer"><?= trans("right_to_left"); ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12">
                                <label><?= trans('status'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="status" value="1" id="status1" class="square-purple" <?= $language->status == "1" ? 'checked' : ''; ?>>
                                <label for="status1" class="option-label"><?= trans('active'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="status" value="0" id="status2" class="square-purple" <?= $language->status != "1" ? 'checked' : ''; ?>>
                                <label for="status2" class="option-label"><?= trans('inactive'); ?></label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>