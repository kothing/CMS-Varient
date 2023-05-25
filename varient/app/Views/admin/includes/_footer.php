</section>
</div>
<footer id="footer" class="main-footer">
    <div class="pull-right hidden-xs">
        <strong style="font-weight: 600;"><?= $baseSettings->copyright; ?>&nbsp;</strong>
    </div>
    <b>Version</b>&nbsp;2.1.1
</footer>
</div>
<script src="<?= base_url('assets/admin/js/jquery-ui.min.js'); ?>"></script>
<script>$.widget.bridge('uibutton', $.ui.button);</script>
<script src="<?= base_url('assets/vendor/bootstrap-v3/js/bootstrap.min.js'); ?>"></script>
<script src="<?= base_url('assets/admin/js/adminlte.min.js'); ?>"></script>
<script src="<?= base_url('assets/admin/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= base_url('assets/admin/plugins/datatables/dataTables.bootstrap.min.js'); ?>"></script>
<script src="<?= base_url('assets/admin/js/lazysizes.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/icheck/icheck.min.js'); ?>"></script>
<script src="<?= base_url('assets/admin/plugins/pace/pace.min.js'); ?>"></script>
<script src="<?= base_url('assets/admin/plugins/file-manager/file-manager-2.1.js'); ?>"></script>
<script src="<?= base_url('assets/admin/plugins/tagsinput/jquery.tagsinput.min.js'); ?>"></script>
<script src="<?= base_url('assets/admin/plugins/file-uploader/js/jquery.dm-uploader.min.js'); ?>"></script>
<script src="<?= base_url('assets/admin/plugins/file-uploader/js/ui.js'); ?>"></script>
<script src="<?= base_url('assets/admin/js/plugins.js'); ?>"></script>
<script src="<?= base_url('assets/admin/plugins/colorpicker/bootstrap-colorpicker.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/bootstrap-datetimepicker/moment.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js'); ?>"></script>
<script src="<?= base_url('assets/admin/js/custom-2.0.js'); ?>"></script>
<script src="<?= base_url('assets/admin/js/post-types-2.1.js'); ?>"></script>
<script src="<?= base_url('assets/admin/plugins/tinymce/tinymce.min.js'); ?>"></script>
<script>
    function initTinyMCE(selector, minHeight) {
        var menuBar = 'file insert format table help';
        if (selector == '.tinyMCEQuiz') {
            menuBar = false;
        }
        tinymce.init({
            selector: selector,
            height: minHeight,
            min_height: minHeight,
            valid_elements: '*[*]',
            relative_urls: false,
            remove_script_host: false,
            directionality: directionality,
            language: '<?= $activeLang->text_editor_lang; ?>',
            menubar: menuBar,
            plugins: 'advlist autolink lists link image charmap preview searchreplace visualblocks code codesample fullscreen insertdatetime media table',
            toolbar: 'fullscreen code preview | undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | numlist bullist | forecolor backcolor removeformat | image media link',
            content_css: ['<?= base_url('assets/admin/plugins/tinymce/editor_content.css'); ?>'],
        });
    }

    if ($('.tinyMCE').length > 0) {
        initTinyMCE('.tinyMCE', 500);
    }
    if ($('.tinyMCEsmall').length > 0) {
        initTinyMCE('.tinyMCEsmall', 300);
    }
    if ($('.tinyMCEQuiz').length > 0) {
        initTinyMCE('.tinyMCEQuiz', 205);
    }
</script>
<style>.pagination a, .pagination span {border-radius: 0 !important;}</style>
<?php if (isset($langSearchColumn)): ?>
    <script>
        var table = $('#cs_datatable_lang').DataTable({
            dom: 'l<"#table_dropdown">frtip',
            "order": [[0, "desc"]],
            "aLengthMenu": [[15, 30, 60, 100], [15, 30, 60, 100, "All"]]
        });
        $('<label class="table-label"><label/>').text('Language').appendTo('#table_dropdown');
        $select = $('<select class="form-control input-sm"><select/>').appendTo('#table_dropdown');
        $('<option/>').val('').text('<?= trans("all"); ?>').appendTo($select);
        <?php foreach ($activeLanguages as $lang): ?>
        $('<option/>').val('<?= $lang->name; ?>').text('<?= $lang->name; ?>').appendTo($select);
        <?php endforeach; ?>
        $("#table_dropdown select").change(function () {
            table.column(<?= $langSearchColumn; ?>).search($(this).val()).draw();
        });
    </script>
<?php endif; ?>
</body>
</html>