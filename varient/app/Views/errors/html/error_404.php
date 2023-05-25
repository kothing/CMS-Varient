<style>.container-error-404{display:flex;justify-content:center;align-items:center;min-height:600px}.error-404 h1{font-family:Verdana,Geneva,sans-serif;text-align:center;font-size:142px;line-height:142px;font-weight:700;margin-bottom:10px;text-transform:uppercase;background:linear-gradient(to right, #537895 0%, #09203F  100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent}.error-404 h2{text-align:center;font-size:24px;font-weight:600}.error-404 p{text-align:center;font-size:14px;font-weight:400}</style>
<?php if ($activeTheme->theme == 'classic'): ?>
    <div id="wrapper" style="min-height: 600px;">
        <div class="container">
            <div class="container-error-404">
                <div class="error-404">
                    <h1>404</h1>
                    <h2><?= trans("page_not_found"); ?></h2>
                    <p class="text-muted"><?= trans("page_not_found_sub"); ?></p>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <section class="section section-page mb-0">
        <div class="container-xl">
            <div class="container-error-404">
                <div class="error-404">
                    <h1>404</h1>
                    <h2><?= trans("page_not_found"); ?></h2>
                    <p class="text-muted"><?= trans("page_not_found_sub"); ?></p>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>