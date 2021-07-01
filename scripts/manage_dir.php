<?php

/********************************
Simple PHP File Manager
Copyright Brahim & Einar
 */
require_once('../modules/functions.php');

$file = $_GET['file'] ?? '.';
$newName =  $_POST["dirname"] ?? '';

// remove slash from name
$newName = str_replace('/', '', $newName);

if ($_POST['action'] == 'mkdir') {
    $basePath = "../root/" . $file;

    chdir($basePath);

    $data['status'] = mkdir($newName, 0777);
    $data['file'] = $file;
} elseif ($_POST['action'] == 'delete') {
    if (isset($_POST['file'])) {
        $basePath = "../root/" .  $_POST['file'];

        removeDir($basePath);

        $data['status'] = !file_exists($basePath);
        $data['file'] = $basePath;
    }
} elseif ($_POST['action'] == 'rename') {
    $basePath = "../root/" .  $_POST['file'];
    $newPath = dirname($basePath) . '/' .  $newName;

    try {
        $data['status'] = renameFile($basePath, $newPath);
    } catch (Throwable $th) {
        $data['status'] = false;
        $data['msg'] = $th->getMessage();
    }
    $data['file'] = $basePath;
    $data['newPath'] = $newPath;
} else {
    $data['status'] = false;
}

// Response from the server
$data['action'] = $_POST['action'];
echo json_encode($data);

/* Functions
*/
function removeDir($dir)
{
    if (is_dir($dir)) {
        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file)
            removeDir("$dir/$file");
        rmdir($dir);
    } else {
        unlink($dir);
    }
}

function renameFile($basePath, $newPath)
{
    if (file_exists($newPath)) {
        throw new Exception('Directory already exists');
    }
    if (!is_dir($basePath)) {
        $newEntry = pathinfo($newPath, PATHINFO_EXTENSION);
        $entry = pathinfo($basePath, PATHINFO_EXTENSION);
        $newPath =  strlen($newEntry) ?
            $newPath : $newPath . '.' . $entry;
    }

    return rename($basePath, $newPath);
}
