<?php
session_start();
require_once('./constants/path.php');
require_once('./modules/functions.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.lineicons.com/3.0/lineicons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./assets/css/styles.css">
    <link rel="stylesheet" href="./libs/Magnific-Popup-master/dist/magnific-popup.css">

    <title>FileSystem Explorer</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-3">
                <?php
                // import aside module
                require_once('./modules/aside.php');
                ?>
            </div>
            <div class="col-9">
                <div class="card">
                    <div class="card-body">
                        <?php
                        // import search module
                        require_once('./modules/search.php');
                        ?>
                        <div class="mt-3">
                            <div class="container draggable">
                                <?php
                                require_once('./modules/recentFolders.php');
                                ?>
                                <h5>Files</h5>
                                <div class="files-container mt-3">
                                    <div class="row border-top border-bottom my-2 py-2 bg-light font-weight-bold">
                                        <div class="col-sm">
                                            Name
                                        </div>
                                        <div class="col-sm">
                                            Created
                                        </div>
                                        <div class="col-sm">
                                            Modified
                                        </div>
                                        <div class="col-sm">
                                            ext
                                        </div>
                                        <div class="col-sm">
                                            Size
                                        </div>
                                        <div class="col-sm-2">
                                        </div>
                                    </div>
                                    <?php
                                    // import module to display files and directories 
                                    require_once('./modules/manager.php');
                                    ?>
                                </div>
                                <div class="search-container d-none mt-3">
                                    <div class="row border-top border-bottom my-2 py-2 bg-light font-weight-bold">
                                        <div class="col-sm">
                                            Name
                                        </div>
                                        <div class="col-sm">
                                            path
                                        </div>
                                        <div class="col-sm-2">
                                        </div>
                                    </div>
                                    <div class="search-result"></div>
                                </div>
                                <?php
                                require_once('./modules/alert.php');
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./libs/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
    <script src="./assets/js/script.js" charset="utf-8"></script>

</body>

</html>