<?php

/********************************
Simple PHP File Manager
Copyright Brahim & Einar
 */

require_once('../constants/path.php');

$file = $_GET['file'] ?? '';
$directory  = ROOT_PATH_BACK . $file;
$scanned_directory = array_diff(scandir($directory), array('..', '.'));

foreach ($scanned_directory as $entry) {
    $i = $directory . '/' . $entry;
    $stat = stat($i);
    $result[] = [
        'mtime' => $stat['mtime'],
        'ctime' => $stat['ctime'],
        'size' => $stat['size'],
        'name' => basename($i),
        'is_dir' => is_dir($i),
        'is_readable' => is_readable($i),
        'is_writable' => is_writable($i),
        'is_executable' => is_executable($i),
    ];
}

echo json_encode(["results" => $result]);
