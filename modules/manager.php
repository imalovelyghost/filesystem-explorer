<!-- <div class="table-responsive mt-3"> -->
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
                                $todayHour = date("H:i", $entry["ctime"]);
                                $creationDayFormatted = gmdate("Y D d", $entry["ctime"]);
                                $creationDay = gmdate("Y/m/d", $entry["ctime"]);
                                $today = (date("Y/m/d"));
                                if ($today == $creationDay) {
                                    echo ($todayHour);
                                } else {
                                    echo ($creationDayFormatted);
                                }
                                ?>
                            </div>
                            <div class="col-sm">
                                <?php
                                //gmdate("Y-D-d\ H:i", $entry["mtime"]) 
                                $todayHourModified = date("H:i:s", $entry["mtime"]);
                                $creationDayFormattedModified = gmdate("Y D d\ H:i", $entry["mtime"]);
                                $creationDayModified = gmdate("Y/m/d", $entry["mtime"]);
                                $todayModified = (date("Y/m/d"));
                                if ($todayModified == $creationDayModified) {
                                    echo ($todayHourModified);
                                } else {
                                    echo ($creationDayFormattedModified);
                                }
                                ?>
                            </div>
                            <div class="col-sm">
                                <?= FormatSize($entry); ?>
                            </div>
                            <div class="col-sm-2 d-flex justify-content-end">
                                <!-- <i data-file="<?= $entry["path"]; ?>" class="fa fa-ellipsis-h"></i> -->

                                <div class="dropdown">
                                    <button class="btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i data-file="<?= $entry["path"]; ?>" class="fa fa-ellipsis-h"></i>
                                    </button>
                                    <?php
                                    $pathDelete = './modules/delete_directory.php?file=' . $file . '&delete=' . $entry["path"];
                                    // $pathDelete = './modules/delete_directory.php?file=' . $entry["path"];
                                    ?>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="<?= $pathDelete; ?>">Delete</a>
                                        <a class="dropdown-item" href="#">Rename</a>
                                        <a class="dropdown-item" href="#">Download</a>
                                    </div>
                                </div>
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