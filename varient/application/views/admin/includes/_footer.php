<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

</section><!-- /.content -->
</div><!-- /.content-wrapper -->

<footer id="footer" class="main-footer">
    <div class="pull-right hidden-xs">
        <strong style="font-weight: 600;"><?php echo $this->settings->copyright; ?>&nbsp;</strong>
    </div>
    <b>Version</b> 1.7.1
</footer>
</div><!-- ./wrapper -->
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url(); ?>assets/admin/js/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/admin/js/adminlte.min.js"></script>
<!-- DataTables js -->
<script src="<?php echo base_url(); ?>assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- Lazy Load js -->
<script src="<?php echo base_url(); ?>assets/admin/js/lazysizes.min.js"></script>
<!-- iCheck js -->
<script src="<?php echo base_url(); ?>assets/vendor/icheck/icheck.min.js"></script>
<!-- Pace -->
<script src="<?php echo base_url(); ?>assets/admin/plugins/pace/pace.min.js"></script>
<!-- File Manager -->
<script src="<?php echo base_url(); ?>assets/admin/plugins/file-manager/file-manager.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/plugins/tagsinput/jquery.tagsinput.min.js"></script>
<!-- Plugins js -->
<script src="<?php echo base_url(); ?>assets/admin/js/plugins.js"></script>
<!-- Color Picker js -->
<script src="<?php echo base_url(); ?>assets/admin/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<!-- Datepicker js -->
<script src="<?php echo base_url(); ?>assets/vendor/bootstrap-datetimepicker/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
<!-- Custom js -->
<script src="<?php echo base_url(); ?>assets/admin/js/custom.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/post-types.js"></script>

<!--tinyMCE-->
<script src="<?php echo base_url(); ?>assets/admin/plugins/tinymce/jquery.tinymce.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/plugins/tinymce/tinymce.min.js"></script>

<script>
    function init_tinymce(selector, min_height) {
        var menu_bar = 'file edit view insert format tools table help';
        if (selector == '.tinyMCEQuiz') {
            menu_bar = false;
        }
        tinymce.init({
            selector: selector,
            min_height: min_height,
            valid_elements: '*[*]',
            relative_urls: false,
            remove_script_host: false,
            language: '<?php echo $this->general_settings->text_editor_lang; ?>',
            menubar: menu_bar,
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code codesample fullscreen",
                "insertdatetime media table paste imagetools"
            ],
            toolbar: 'fullscreen code preview | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | numlist bullist | forecolor backcolor removeformat | image media link | outdent indent',
            content_css: ['<?php echo base_url(); ?>assets/admin/plugins/tinymce/editor_content.css'],
        });
        tinymce.DOM.loadCSS('<?php echo base_url(); ?>assets/admin/plugins/tinymce/editor_ui.css');
    }

    if ($('.tinyMCE').length > 0) {
        init_tinymce('.tinyMCE', 500);
    }
    if ($('.tinyMCEsmall').length > 0) {
        init_tinymce('.tinyMCEsmall', 300);
    }
    if ($('.tinyMCEQuiz').length > 0) {
        init_tinymce('.tinyMCEQuiz', 200);
    }

    $(document).on('click', '.btn_tinymce_add_media', function () {
        var editor_id = $(this).attr('data-editor-id');
        $("#" + editor_id + " [aria-label='Insert/edit media']").trigger("click");
    });
</script>

<?php if (isset($lang_search_column)): ?>
    <script>
        var table = $('#cs_datatable_lang').DataTable({
            dom: 'l<"#table_dropdown">frtip',
            "order": [[0, "desc"]],
            "aLengthMenu": [[15, 30, 60, 100], [15, 30, 60, 100, "All"]]
        });
        //insert a label
        $('<label class="table-label"><label/>').text('Language').appendTo('#table_dropdown');

        //insert the select and some options
        $select = $('<select class="form-control input-sm"><select/>').appendTo('#table_dropdown');

        $('<option/>').val('').text('<?php echo trans("all"); ?>').appendTo($select);
        <?php foreach ($this->languages as $lang): ?>
        $('<option/>').val('<?php echo $lang->name; ?>').text('<?php echo $lang->name; ?>').appendTo($select);
        <?php endforeach; ?>


        $("#table_dropdown select").change(function () {
            table.column(<?php echo $lang_search_column; ?>).search($(this).val()).draw();
        });
    </script>
<?php endif; ?>

</body>
</html>

