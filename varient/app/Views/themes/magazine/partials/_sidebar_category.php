<div class="col-sm-12 col-md-12 col-lg-4">
    <div class="col-sidebar sticky-lg-top">
        <div class="row">
            <div class="col-12">
                <?php if (!empty($objectWidgets->widgets)):
                    foreach ($objectWidgets->widgets as $widget):
                        echo loadView('partials/_load_widget', ['widgetKey' => $widget->type]);
                    endforeach;
                endif; ?>
            </div>
            <div class="col-12">
                <?php if (!empty($objectWidgets->ads)):
                    foreach ($objectWidgets->ads as $ad):
                        if ($ad->ad_space == 'sidebar_1'):
                            echo loadView('partials/_ad_spaces', ['adSpace' => 'sidebar_1', 'class' => 'mb-4']);
                        endif;
                    endforeach;
                endif;
                if (!empty($objectWidgets->ads)):
                    foreach ($objectWidgets->ads as $ad):
                        if ($ad->ad_space == 'sidebar_2'):
                            echo loadView('partials/_ad_spaces', ['adSpace' => 'sidebar_2', 'class' => 'mb-4']);
                        endif;
                    endforeach;
                endif; ?>
            </div>
        </div>
    </div>
</div>