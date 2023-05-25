<div class="col-sidebar sticky-lg-top">
    <div class="row">
        <div class="col-12">
            <?php $i = 0;
            if (!empty($baseWidgets)):
                foreach ($baseWidgets as $widget):
                    if ($i == 1) {
                        echo loadView('partials/_ad_spaces', ['adSpace' => 'sidebar_1', 'class' => 'mb-5']);
                    }
                    echo loadView('partials/_load_widget', ['widgetKey' => $widget->type]);
                    $i++;
                endforeach;
            endif;
            echo loadView('partials/_ad_spaces', ['adSpace' => 'sidebar_2', 'class' => 'mb-4']); ?>
        </div>
    </div>
</div>