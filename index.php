<?php
require_once('./modules/functions.php');
// require_once('./modules/create_directory.php');
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
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./assets/css/styles.css">

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
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm">
                                        Name
                                    </div>
                                    <div class="col-sm">
                                        Creation date
                                    </div>
                                    <div class="col-sm">
                                        Modified
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
                                require_once('./modules/alert.php');
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="./assets/js/script.js" charset="utf-8"></script>

</body>

</html>