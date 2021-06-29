<?php

/********************************
Simple PHP File Manager
Copyright Brahim & Einar
 */

$search = $_POST['search'] ?? '';
$dir = $_POST['dir'] ?? '';
$dir = "../root/" . $dir;

$data['result'] = searchFilesClass($dir, $search);

// Response from the server
$data['search'] = $search;
$data['dir'] =  $dir;
echo json_encode($data);

/*
 * Functions
 * The same result is achieved in two different ways
 * searchFiles: 
 * searchFilesClass: uses Recursive PHP classes
 */
function searchFiles($dir, $search)
{
    $bsName = strtolower(basename($dir));
    $search = strtolower($search);

    if (is_dir($dir)) {
        $results = array();
        $files = array_diff(scandir($dir), ['.', '..']);
        str_contains($bsName, $search) && $results[] = $dir;
        foreach ($files as $file) {
            $route = searchFiles("$dir/$file", $search);
            $route && $results[] = $route;
        }
        return $results;
    }
    if (str_contains($bsName, $search))
        return $dir;
}

function searchFilesClass($dir, $search)
{
    $directory  = new RecursiveDirectoryIterator($dir);
    $iterator = new RecursiveIteratorIterator($directory);
    $search = strtolower($search);
    $files = array();

    foreach ($iterator as $info) {
        if (is_dir($info)) {
            $folder = dirname($info->getPathname());
            $bsName = strtolower(basename($folder));
            if (str_contains($bsName, $search)) $files[] = $folder;
            continue;
        }
        $bsName = strtolower(basename($info->getPathname()));
        if (str_contains($bsName, $search)) $files[] = $info->getPathname();
    }

    return array_unique($files);
}
