<?php
$file = $_GET['file'] ?? '';
$delete = $_GET['delete'] ?? '';
$basePath = "../root/" . $delete;

rmrf($basePath);
// header("Location:../index.php");
header("Location:../index.php?file=$file");

function rmrf($dir)
{
    if (is_dir($dir)) {
        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file)
            rmrf("$dir/$file");
        rmdir($dir);
    } else {
        unlink($dir);
    }
}
