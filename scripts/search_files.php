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
    $statResult = statFiles($value);
    $arrInfo[] = [
        'path' => $statResult['path'],
        'name' =>  $statResult['name'],
        'icon' => fileIcon($statResult),
    ];
}

$data['results'] = $arrInfo ?? [];

// Response from the server
$data['search'] = $search;
$data['dir'] =  $dir;
echo json_encode($data);
