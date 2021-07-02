<?php

/********************************
Simple PHP File Manager
Copyright Brahim & Einar
 */

require_once('../constants/path.php');
require_once('../modules/functions.php');

$search = $_POST['search'] ?? '';
$dir = $_POST['dir'] ?? '';
$dir = ROOT_PATH_BACK . $dir;

$data['paths'] = searchFilesClass($dir, $search);

foreach ($data['paths']  as $value) {
    $statResult = statFiles($value);
    $arrInfo[] = [
        'path' => $statResult['path'],
        'name' =>  getAnchor($statResult, highlight($statResult['name'], $search)),
        'icon' => fileIcon($statResult),
    ];
}

$data['results'] = $arrInfo ?? [];

// Response from the server
$data['search'] = $search;
$data['dir'] =  $dir;
echo json_encode($data);

function highlight($name, $search)
{
    $strAfter = stristr($name, $search);
    $strSearch = substr($strAfter, 0, strlen($search));
    return stristr($name, $search, true) .
        "<span class='bg-warning'>$strSearch</span>" .
        str_ireplace($search, '', $strAfter);
}
