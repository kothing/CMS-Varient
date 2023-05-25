<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex">
    <title>An error occurred!</title>
    <style type="text/css">
        <?= preg_replace('#[\r\n\t ]+#', ' ', file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'debug.css')) ?>
    </style>
</head>
<body>
<div class="container text-center">
    <h1 class="headline">An error occurred!</h1>
    <p class="lead">Please try again later...</p>
    <small>To see the error, open the <b style="font-weight: bold">.env</b> file and change the <b style="font-weight: bold">CI_ENVIRONMENT</b> value to <b style="font-weight: bold">"development"</b> ( CI_ENVIRONMENT = development ).</small>
</div>
</body>
</html>