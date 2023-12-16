<?php
require_once 'functions.php';
if (file_exists('../license.php')) {
    include '../license.php';
}
if (!file_exists('../.env')) {
    echo "The .env file does not exist in the main directory of your website. Upload the .env file from the script files to start the installation.";
    exit();
}
if (!is_writable('../.env')) {
    echo "The .env file is not writable. Please set the file permissions of this file to 0644 or 0755.";
    exit();
}

if (!empty($license_array) && !empty($license_array["purchase_code"]) && !empty($license_array["license_code"])) {
    header("Location: system-requirements.php?license_code=" . $license_array["license_code"] . "&purchase_code=" . $license_array["purchase_code"]);
    exit();
}

if (!function_exists('curl_init')) {
    $error = 'cURL is not available on your server! Please enable cURL to continue the installation. You can read the documentation for more information.';
}
if (isset($_POST["btn_license_code"])) {
    $license_code = $_POST['license_code'];
    $purchase_code = "";
    $response = "";

    $current_url = currentUrl($_SERVER);
    $data = verify_license($license_code, $current_url);

    if (!empty($data)) {
        if ($data->code == "error") {
            $error = "Invalid License Code!";
        } else {
            $purchase_code = $data->code;
            header("Location: system-requirements.php?license_code=" . $license_code . "&purchase_code=" . $purchase_code);
            exit();
        }
    } else {
        $error = "Invalid License Code!";
    }
}


if (!isset($license_code)) {
    if (isset($_GET["license_code"])) {
        $license_code = $_GET["license_code"];
    } else {
        $license_code = "";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Varient - Installer</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/vendor/bootstrap-v3/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700" rel="stylesheet">
    <!-- Font-awesome CSS -->
    <link href="../assets/admin/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-sm-12 col-md-offset-2">

            <div class="row">
                <div class="col-sm-12 logo-cnt">
                    <h1>Varient</h1>
                    <p>Welcome to the Installer</p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="install-box">
                        <div class="steps">
                            <div class="step-progress">
                                <div class="step-progress-line" data-now-value="20" data-number-of-steps="5" style="width: 20%;"></div>
                            </div>
                            <div class="step active">
                                <div class="step-icon"><i class="fa fa-code"></i></div>
                                <p>Start</p>
                            </div>
                            <div class="step">
                                <div class="step-icon"><i class="fa fa-gear"></i></div>
                                <p>System Requirements</p>
                            </div>
                            <div class="step">
                                <div class="step-icon"><i class="fa fa-folder-open"></i></div>
                                <p>Folder Permissions</p>
                            </div>
                            <div class="step">
                                <div class="step-icon"><i class="fa fa-database"></i></div>
                                <p>Database</p>
                            </div>
                            <div class="step">
                                <div class="step-icon"><i class="fa fa-user"></i></div>
                                <p>Settings</p>
                            </div>
                        </div>

                        <div class="messages">
                            <?php if (isset($error)): ?>
                                <div class="alert alert-danger">
                                    <strong><?php echo $error; ?></strong>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="step-contents">
                            <div class="tab-1">
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                    <div class="tab-content">
                                        <div class="tab_1">
                                            <h1 class="step-title">Start</h1>
                                            <div class="form-group text-center">
                                                <strong><a href="https://www.youtube.com/watch?v=EW2axJa1rgA" target="_blank">Watch the installation video</a></strong>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">License Code</label>
                                                <textarea name="license_code" class="form-control form-input" style="resize: vertical; height: 100px;line-height: 24px;padding: 10px;" placeholder="Enter RANDOM Code" required><?php echo $license_code; ?></textarea>
                                                <small style="margin-top: 10px;display: block">*You need to enter your license code to this field (<strong>not your purchase code</strong>).</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-footer">
                                        <button type="submit" name="btn_license_code" class="btn-custom pull-right">Next</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
