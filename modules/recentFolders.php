<?php
$sessionArr = $_SESSION["recentFolders"] ?? [];

if (
    isset($_GET['file']) &&
    !in_array($_GET['file'], $sessionArr)
)
    array_unshift($sessionArr, $_GET['file']);

$_SESSION["recentFolders"] = array_slice($sessionArr, 0, 3);

if (isset($_SESSION["recentFolders"])) {
?>
    <h5>Recent folders</h5>
    <div class="row mt-3">
        <?php
        foreach ($_SESSION["recentFolders"] as $key => $folder) {
            if ($key >= 3) break;
        ?>
            <div class="col-12 col-md-4">
                <div class="card shadow-none border radius-15">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="font-30 text-primary">
                                <i class="bi bi-folder-fill text-primary h4"></i>
                            </div>
                        </div>
                        <h6 class="mb-0 text-primary"><?= $folder ?></h6>
                        <small>
                            <?= getFilesCount($folder); ?> files
                        </small>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
<?php
}
?>