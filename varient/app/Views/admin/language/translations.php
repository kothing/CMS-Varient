<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <div class="left">
            <h3 class="box-title"><?= $title; ?> - <?= $language->name; ?></h3>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <div class="row table-filter-container">
                        <div class="col-sm-12">
                            <form action="<?= adminUrl('edit-translations/' . $language->id); ?>" method="get">
                                <div class="item-table-filter" style="width: 80px; min-width: 80px;">
                                    <label><?= trans("show"); ?></label>
                                    <select name="show" class="form-control">
                                        <option value="50" <?= inputGet('show') == '50' ? 'selected' : ''; ?>>50</option>
                                        <option value="100" <?= inputGet('show') == '100' ? 'selected' : ''; ?>>100</option>
                                        <option value="200" <?= inputGet('show') == '200' ? 'selected' : ''; ?>>200</option>
                                        <option value="300" <?= inputGet('show') == '300' ? 'selected' : ''; ?>>300</option>
                                        <option value="500" <?= inputGet('show') == '500' ? 'selected' : ''; ?>>500</option>
                                    </select>
                                </div>
                                <div class="item-table-filter item-table-filter-long">
                                    <label><?= trans("search"); ?></label>
                                    <input name="q" class="form-control" placeholder="<?= trans("search"); ?>" type="search" value="<?= esc(inputGet('q')); ?>">
                                </div>
                                <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
                                    <label style="display: block">&nbsp;</label>
                                    <button type="submit" class="btn bg-purple"><?= trans("filter"); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <form action="<?= base_url('LanguageController/editTranslationsPost'); ?>" method="post">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="lang_id" value="<?= $language->id; ?>">
                        <table class="table table-bordered table-striped dataTable">
                            <thead>
                            <tr role="row">
                                <th>#</th>
                                <th><?= trans('phrase'); ?></th>
                                <th><?= trans('label'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $show = cleanNumber(inputGet('show'));
                            if (empty($show)) {
                                $show = 15;
                            }
                            $page = cleanNumber(inputGet('page'));
                            if (empty($page)) {
                                $page = 1;
                            }
                            $count = ($show * ($page - 1)) + 1;
                            if (!empty($translations)):
                                foreach ($translations as $item): ?>
                                    <tr class="tr-phrase">
                                        <td style="width: 50px;"><?= $count; ?></td>
                                        <td style="width: 40%;"><input type="text" class="form-control" value="<?= $item->label; ?>" <?= $language->text_direction == "rtl" ? 'dir="rtl"' : ''; ?> readonly></td>
                                        <td style="width: 60%;"><input type="text" name="<?= $item->id; ?>" class="form-control input_translation" value="<?= $item->translation; ?>" <?= $language->text_direction == "rtl" ? 'dir="rtl"' : ''; ?>></td>
                                    </tr>
                                    <?php $count++;
                                endforeach;
                            endif; ?>
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary pull-right"><?= trans("save_changes"); ?></button>
                    </form>
                </div>
                <?php if (empty($translations)): ?>
                    <p class="text-center">
                        <?= trans("no_records_found"); ?>
                    </p>
                <?php endif; ?>
                <div class="col-sm-12 table-ft">
                    <div class="row text-center">
                        <?= view('common/_pagination'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>