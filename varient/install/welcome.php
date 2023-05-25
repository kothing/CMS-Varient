<!DOCTYPE html>
<html>
<head>
    <title>Varient</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet">
    <style>
        b, br {
            display: none;
        }

        html {
            height: 100%;
        }

        body {
            height: 100%;
            font-family: 'Open Sans', sans-serif;
            color: #fff !important;
            font-size: 15px;
            overflow: hidden;
        }

        .wrapper {
            width: 100%;
            height: 100%;
            position: relative;
            display: block;
        }

        .center {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            height: 400px;
            width: 400px;
            max-width: 100%;
            margin: auto;
            text-align: center;
        }

        .title {
            color: #555 !important;
            font-size: 102px;
            line-height: 102px;
            font-weight: 300;
            margin: 0;
        }

        .version {
            margin-bottom: 60px;
            color: #999;
        }

        .button {
            display: inline-block;
            text-align: center;
            vertical-align: middle;
            -ms-touch-action: manipulation;
            touch-action: manipulation;
            cursor: pointer;
            font-size: 16px;
            border-radius: 25px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            color: #fff;
            text-decoration: none;
            height: 50px;
            line-height: 50px;
            padding: 0 80px;
        }

        .button {
            background-image: linear-gradient(to right, #02AAB0 0%, #00CDAC 51%, #02AAB0 100%)
        }

        .button:hover {
            background-position: right center;
        }

        @media only screen and (max-width: 768px) {
            .title {
                font-size: 72px;
                line-height: 72px;
            }
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="center">
        <h1 class="title">Varient</h1>
        <p class="version">Version 2.1.1</p>
        <a href="index.php" class="button">Install</a>
    </div>
</div>
</body>
</html>