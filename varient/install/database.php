<?php
require_once 'functions.php';

if (isset($_POST["btn_install"])) {
    $license_code = $_POST["license_code"];
    $purchase_code = $_POST["purchase_code"];
    if (!isset($license_code) || !isset($purchase_code)) {
        header("Location: index.php");
        exit();
    }
    $data = [
        'db_host' => $_POST['db_host'],
        'db_user' => $_POST['db_user'],
        'db_password' => $_POST['db_password'],
        'db_name' => $_POST['db_name']
    ];

    try {
        $mysqli = new mysqli($data['db_host'], $data['db_user'], $data['db_password'], $data['db_name']);
        if ($mysqli->connect_error) {
            $error = "The database could not be created, please check your database credentials!";
        } else {
            //create tables
            $sqlFile = file_get_contents('sql/install_varient.sql');
            if (!$mysqli->multi_query($sqlFile)) {
                $error = "The database could not be created, please check your database credentials!";
            } else {
                //write config
                if (!write_config($data)) {
                    $error = "The database configuration file could not be written, please change the file permission of the app/Config/Database.php file to 755.";
                } else {
                    header("Refresh: 15; admin.php?license_code=" . $license_code . "&purchase_code=" . $purchase_code);
                    $installing = 1;
                }
            }
            //close connection
            $mysqli->close();
        }
    } catch (Exception $e) {
        $error = "The database could not be created, please check your database credentials!";
    }
} else {
    $license_code = $_GET["license_code"];
    $purchase_code = $_GET["purchase_code"];
    if (!isset($license_code) || !isset($purchase_code)) {
        header("Location: index.php");
        exit();
    }
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Varient - Installer</title>
    <link rel="stylesheet" href="../assets/vendor/bootstrap-v3/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700" rel="stylesheet">
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
                                <div class="step-progress-line" data-now-value="80" data-number-of-steps="5" style="width: 80%;"></div>
                            </div>
                            <div class="step">
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
                            <div class="step active">
                                <div class="step-icon"><i class="fa fa-database"></i></div>
                                <p>Database</p>
                            </div>
                            <div class="step">
                                <div class="step-icon"><i class="fa fa-user"></i></div>
                                <p>Settings</p>
                            </div>
                        </div>
                        <?php if (isset($error)): ?>
                            <div class="messages">
                                <div class="alert alert-danger">
                                    <strong><?= $error; ?></strong>
                                </div>
                            </div>
                        <?php else:
                            if (isset($installing)):?>
                                <div class="messages">
                                    <div class="alert alert-success">
                                        <strong>The database is being created. Please wait!</strong>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="spinner">
                                            <div class="rect1"></div>
                                            <div class="rect2"></div>
                                            <div class="rect3"></div>
                                            <div class="rect4"></div>
                                            <div class="rect5"></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif;
                        endif; ?>
                        <div class="step-contents">
                            <div class="tab-1">
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                    <input type="hidden" name="license_code" value="<?= !empty($license_code) ? $license_code : ''; ?>">
                                    <input type="hidden" name="purchase_code" value="<?= !empty($purchase_code) ? $purchase_code : ''; ?>">
                                    <div class="tab-content">
                                        <div class="tab_1">
                                            <h1 class="step-title">Database</h1>
                                            <div class="form-group">
                                                <label for="email">Host</label>
                                                <input type="text" class="form-control form-input" name="db_host" placeholder="Host" value="<?= !empty($data['db_host']) ? $data['db_host'] : 'localhost'; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Database Name</label>
                                                <input type="text" class="form-control form-input" name="db_name" placeholder="Database Name" value="<?= !empty($data['db_name']) ? $data['db_name'] : ''; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Username</label>
                                                <input type="text" class="form-control form-input" name="db_user" placeholder="Username" value="<?= !empty($data['db_user']) ? $data['db_user'] : ''; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Password</label>
                                                <input type="text" class="form-control form-input" name="db_password" placeholder="Password" value="<?= !empty($data['db_password']) ? $data['db_password'] : ''; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="buttons">
                                        <a href="folder-permissions.php?license_code=<?php echo $license_code; ?>&purchase_code=<?php echo $purchase_code; ?>" class="btn btn-success btn-custom pull-left">Prev</a>
                                        <button type="submit" name="btn_install" class="btn btn-success btn-custom pull-right">Next</button>
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

