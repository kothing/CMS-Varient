<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-5 col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans("site_font"); ?></h3>
            </div>
            <form action="<?= base_url('AdminController/setSiteFontPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label><?= trans("language"); ?></label>
                        <select name="lang_id" class="form-control" onchange="window.location.href = '<?= adminUrl(); ?>' + '/font-settings?lang='+this.value;">
                            <?php foreach ($activeLanguages as $language): ?>
                                <option value="<?= $language->id; ?>" <?= $selectedLangId == $language->id ? 'selected' : ''; ?>><?= $language->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="label-sitemap"><?= trans('primary_font'); ?></label>
                        <select name="primary_font" class="form-control custom-select">
                            <?php if (!empty($fonts)):
                                foreach ($fonts as $font): ?>
                                    <option value="<?= $font->id; ?>" <?= $baseSettings->primary_font == $font->id ? 'selected' : ''; ?>><?= $font->font_name; ?></option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="label-sitemap"><?= trans('secondary_font'); ?></label>
                        <select name="secondary_font" class="form-control custom-select" style="width: 100%">
                            <?php if (!empty($fonts)):
                                foreach ($fonts as $font): ?>
                                    <option value="<?= $font->id; ?>" <?= $baseSettings->secondary_font == $font->id ? 'selected' : ''; ?>><?= $font->font_name; ?></option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="label-sitemap"><?= trans('tertiary_font'); ?></label>
                        <select name="tertiary_font" class="form-control custom-select" style="width: 100%">
                            <?php if (!empty($fonts)):
                                foreach ($fonts as $font): ?>
                                    <option value="<?= $font->id; ?>" <?= $baseSettings->tertiary_font == $font->id ? 'selected' : ''; ?>><?= $font->font_name; ?></option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('save_changes'); ?></button>
                </div>
            </form>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= trans("add_font"); ?></h3>
                <a href="https://fonts.google.com/" target="_blank" style="float: right;font-size: 16px;"><strong>Google Fonts&nbsp;<i class="icon-arrow-right"></i></strong></a>
            </div>
            <form action="<?= base_url('AdminController/addFontPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label><?= trans("name"); ?></label>
                        <input type="text" class="form-control" name="font_name" placeholder="<?= trans("name"); ?>" maxlength="200" required>
                        <small>(E.g: Open Sans)</small>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans("url"); ?> </label>
                        <textarea name="font_url" class="form-control" placeholder="<?= trans("url"); ?>" required></textarea>
                        <small>(E.g: <?= esc('<link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">'); ?>)</small>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans("font_family"); ?> </label>
                        <input type="text" class="form-control" name="font_family" placeholder="<?= trans("font_family"); ?>" maxlength="500" required>
                        <small>(E.g: font-family: "Open Sans", Helvetica, sans-serif)</small>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('add_font'); ?></button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-7 col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="pull-left">
                    <h3 class="box-title"><?= trans('fonts'); ?></h3>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped dataTable" id="cs_datatable" role="grid" aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th width="20"><?= trans('id'); ?></th>
                                    <th><?= trans("name"); ?></th>
                                    <th><?= trans("font_family"); ?></th>
                                    <th><?= trans("options"); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($fonts)):
                                    foreach ($fonts as $font): ?>
                                        <tr>
                                            <td><?= esc($font->id); ?></td>
                                            <td><?= esc($font->font_name); ?></td>
                                            <td><?= esc($font->font_family); ?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn bg-purple dropdown-toggle btn-select-option" type="button" data-toggle="dropdown"><?= trans('select_an_option'); ?>
                                                        <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu options-dropdown">
                                                        <li>
                                                            <a href="<?= adminUrl('edit-font/' . $font->id); ?>"><i class="fa fa-edit option-icon"></i><?= trans('edit'); ?></a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0)" onclick="deleteItem('AdminController/deleteFontPost','<?= $font->id; ?>','<?= clrQuotes(trans("confirm_item")); ?>');"><i class="fa fa-trash option-icon"></i><?= trans('delete'); ?></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-9">
        <div class="alert alert-info alert-large m-t-10">
            <strong><?= trans("warning"); ?>!</strong>&nbsp;&nbsp;<?= trans("font_warning"); ?>
        </div>
    </div>
</div>