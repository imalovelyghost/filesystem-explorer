<?php

/********************************
Simple PHP File Manager
Copyright Brahim & Einar
 */

require_once('../modules/functions.php');

$search = $_POST['search'] ?? '';
$dir = $_POST['dir'] ?? '';
$dir = "../root/" . $dir;

$data['paths'] = searchFilesClass($dir, $search);

foreach ($data['paths']  as $value) {
    $stat = stat($value);
    $result[] = [
        'size' => $stat['size'],
        'name' => basename($value),
        'path' => $value,
        'is_dir' => is_dir($value),
        'is_media' => is_audio($value) || is_video($value),
        'is_image' => is_image($value),
    ];
}
$filesInfo = $result ?? [];
foreach ($filesInfo as $entry) {
    $arrInfo[] = [
        'path' => $entry['path'],
        'name' =>  $entry['name'],
        'icon' => fileIcon($entry),
    ];
}

$data['results'] = $arrInfo ?? [];

// Response from the server
$data['search'] = $search;
$data['dir'] =  $dir;
echo json_encode($data);
