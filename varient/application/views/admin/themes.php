<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="box box-primary" style="background-color: transparent;border: 0;box-shadow: none;">
            <div class="box-header with-border">

            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <!-- include message block -->
                <?php $this->load->view('admin/includes/_messages'); ?>

                <?php echo form_open('admin_controller/set_theme_post'); ?>

                <div class="row-layout-items">
                    <div class="layout-item <?php echo ($this->dark_mode == 0) ? 'active' : ''; ?>" data-val="layout_1" onclick="set_theme('layout_1');">
                        <button type="submit" name="dark_mode" value="0" class="btn btn-block">
                            <div style="width: 308px; height: 360.7px;">
                                <img src="<?php echo base_url(); ?>assets/admin/img/theme_light.jpg" alt="" class="img-responsive">
                            </div>
                            <p>
                                <?php echo ($this->dark_mode == 0) ? trans("activated") : trans("activate"); ?>
                            </p>
                        </button>
                    </div>
                    <div class="layout-item <?php echo ($this->dark_mode == 1) ? 'active' : ''; ?>" data-val="layout_2" onclick="set_theme('layout_2');">
                        <button type="submit" name="dark_mode" value="1" class="btn btn-block">
                            <div style="width: 308px; height: 360.7px;">
                                <img src="<?php echo base_url(); ?>assets/admin/img/theme_dark.jpg" alt="" class="img-responsive">
                            </div>
                            <p>
                                <?php echo ($this->dark_mode == 1) ? trans("activated") : trans("activate"); ?>
                            </p>
                        </button>
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>

        </div>
        <!-- /.box -->
    </div>
</div>


