<div class="row">
    <div class="col-sm-12">
        <?= view('admin/includes/_messages'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="left">
                    <h3 class="box-title"><?= trans('add_poll'); ?></h3>
                </div>
                <div class="right">
                    <a href="<?= adminUrl('polls'); ?>" class="btn btn-success btn-add-new"><i class="fa fa-bars"></i><?= trans('polls'); ?></a>
                </div>
            </div>
            <form action="<?= base_url('AdminController/addPollPost'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="box-body">
                    <div class="form-group">
                        <label><?= trans("language"); ?></label>
                        <select name="lang_id" class="form-control max-600">
                            <?php foreach ($activeLanguages as $language): ?>
                                <option value="<?= $language->id; ?>" <?= $activeLang->id == $language->id ? 'selected' : ''; ?>><?= $language->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?= trans('question'); ?></label>
                        <textarea class="form-control text-area" name="question" placeholder="<?= trans('question'); ?>" required><?= old('question'); ?></textarea>
                    </div>

                    <?php for ($i = 1; $i <= 10; $i++): ?>
                        <div class="form-group">
                            <label class="control-label"><?= trans('option_' . $i); ?></label>
                            <input type="text" class="form-control" name="option<?= $i; ?>" placeholder="<?= trans('option_' . $i); ?>" value="<?= old('option' . $i); ?>" <?= $i <= 2 ? 'required' : ''; ?>>
                        </div>
                    <?php endfor; ?>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12">
                                <label><?= trans('vote_permission'); ?></label>
                            </div>
                            <div class="col-md-3 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="vote_permission" value="all" id="vote_permission1" class="square-purple" checked>
                                <label for="vote_permission1" class="option-label"><?= trans('all_users_can_vote'); ?></label>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="vote_permission" value="registered" id="vote_permission2" class="square-purple">
                                <label for="vote_permission2" class="option-label"><?= trans('registered_users_can_vote'); ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12">
                                <label><?= trans('status'); ?></label>
                            </div>
                            <div class="col-md-3 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="status" value="1" id="status1" class="square-purple" checked>
                                <label for="status1" class="option-label"><?= trans('active'); ?></label>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="status" value="0" id="status2" class="square-purple">
                                <label for="status2" class="option-label"><?= trans('inactive'); ?></label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><?= trans('add_poll'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>