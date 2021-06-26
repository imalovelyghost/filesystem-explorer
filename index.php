<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.lineicons.com/3.0/lineicons.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.lineicons.com/3.0/lineicons.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./assets/css/styles.css">

    <title>FileSystem Explorer</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-3">
                <div class="card">

                    <div class="card-body">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                            + Add
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- <label data-error="wrong" data-success="right" for="defaultForm-email">Your email</label> -->
                                        <?php
                                        $file = $_GET['file'] ?? '';
                                        $path = "./modules/create_directory.php?file=" . $file;
                                        ?>
                                        <form action=<?= $path ?> method="post">
                                            <!-- <input type="submit" class="btn btn-primary" value="+ Add File"> -->
                                            <input type="text" id="defaultForm-name" name="directory-name" placeholder="Insert directory name" class="form-control validate">

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->

                        <h5 class="my-3">File Explorer</h5>
                        <div class="fm-menu">
                            <div class="list-group list-group-flush"> <a href="javascript:;" class="list-group-item py-1"><i class="bx bx-folder me-2"></i><span>All Files</span></a>
                                <a href="./" class="list-group-item py-1"><i class="bx bx-devices me-2"></i><span>Root</span></a>
                                <a href="javascript:;" class="list-group-item py-1"><i class="bx bx-analyse me-2"></i><span>Documents</span></a>
                                <a href="javascript:;" class="list-group-item py-1"><i class="bx bx-plug me-2"></i><span>Images</span></a>
                                <a href="javascript:;" class="list-group-item py-1"><i class="bx bx-plug me-2"></i><span>Audio</span></a>
                                <a href="javascript:;" class="list-group-item py-1"><i class="bx bx-plug me-2"></i><span>Video</span></a>
                                <a href="javascript:;" class="list-group-item py-1"><i class="bx bx-trash-alt me-2"></i><span>Deleted Files</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-9">
                <div class="card">
                    <div class="card-body">
                        <div class="fm-search">
                            <div class="mb-0">
                                <div class="input-group input-group-lg"> <span class="input-group-text bg-transparent"><i class="fa fa-search"></i></span>
                                    <input type="text" class="form-control" placeholder="Search the files">
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive mt-3">
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
                                </div>
                                <div class="row">
                                    <div class="col-sm">
                                        <!-- <div class="font-30 text-primary"><i class="bx bxs-folder"></i></div> -->
                                        <?php
                                        $file = $_GET["file"] ?? "";
                                        $arrFiles = getFilesInfo($file);

                                        if (is_array($arrFiles)) {
                                            foreach ($arrFiles as $entry) {
                                        ?>
                                                <div class="row">
                                                    <div class="col-sm">
                                                        <?= getAnchor($entry); ?>
                                                    </div>
                                                    <div class="col-sm">
                                                        <?php
                                                        //$creationDayFormated = gmdate("Y-D-d\ H:i", $entry["ctime"]);
                                                        $todayHour = date("H:i", $entry["ctime"]);
                                                        $creationDayFormated = gmdate("Y D d", $entry["ctime"]);
                                                        $creationDay = gmdate("Y/m/d", $entry["ctime"]);
                                                        $today = (date("Y/m/d"));
                                                        if ($today == $creationDay) {
                                                            echo ($todayHour);
                                                        } else {
                                                            echo ($creationDayFormated);
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="col-sm">
                                                        <?php

                                                        //gmdate("Y-D-d\ H:i", $entry["mtime"]) 
                                                        $todayHourModified = date("H:i:s", $entry["ctime"]);
                                                        $creationDayFormatedModified = gmdate("Y D d\ H:i", $entry["ctime"]);
                                                        $creationDayModified = gmdate("Y/m/d", $entry["mtime"]);
                                                        $todayModified = (date("Y/m/d"));
                                                        if ($todayModified == $creationDayModified) {
                                                            echo ($todayHourModified);
                                                        } else {
                                                            echo ($creationDayFormatedModified);
                                                        }


                                                        ?>
                                                    </div>
                                                    <div class="col-sm">
                                                        <?php

                                                        $size = ($entry["size"]);
                                                        $res = $size;
                                                        $x = 0;
                                                        $units = array('Kb', 'Mb', 'Gb');
                                                        while ($res >= 1024) {
                                                            $res = $res / 1024;
                                                            $x++;
                                                        }
                                                        echo round($res, 2), $units[$x - 1];
                                                        ?>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <div class="col-12 mt-3 p-0">
                                                <?= $arrFiles; ?>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="./assets/js/script.js" charset="utf-8"></script>

    <!-- Upload form -->

    <!-- https://www.youtube.com/watch?v=JaRq73y5MJk -->

    <form action="uploads.php" method="post" enctype="multipart/form-data">
        <input type="file" name="file">
        <button type="submit" name="submit">UPLOAD</button>

    </form>




    <!-- Upload form -->

</body>

</html>

<?php
function getFilesInfo($path)
{
    $directory  = (__DIR__ . "/root/" . $path);
    $scanned_directory = array_diff(scandir($directory), array('..', '.'));
    //echo ($directory);
    //echo ($scanned_directory);

    foreach ($scanned_directory as $entry) {
        $i = $directory . $entry;
        $stat = stat($i);
        $result[] = [
            'mtime' => $stat['mtime'],
            'ctime' => $stat['ctime'],
            'size' => $stat['size'],
            'name' => basename($i),
            // 'path' => preg_replace('@^\./@', '', $stat),
            'is_dir' => is_dir($i),
            'is_readable' => is_readable($i),
            'is_writable' => is_writable($i),
            'is_executable' => is_executable($i),
        ];
    }
    // print_r($result);
    return $result ?? 'This folder is empty';
}

function getAnchor($entry)
{
    $name = $entry["name"];
    //echo ($name);
    $href = isset($_GET['file']) ? $_GET['file'] . '/' . $name :  $name;
    //echo ($href);

    echo fileIcon($entry);
    echo "<a href= \"?file=$href\"> $name</a>";
}

function fileIcon($file)
{
    if ($file["is_dir"]) {
        return '<i class="bx bxs-folder text-primary"></i> ';
    } else {
        return '<i class="bx bxs-file"></i> ';
    }
}
?>