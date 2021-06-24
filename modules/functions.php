<?php

/********************************
Simple PHP File Manager
Copyright Brahim & Einar
 */

/*
  * This converts from bytes to KB, MB, GB
*/
function FormatSize($file)
{
    if ($file["is_dir"]) {
        return "--";
    }
    $res = ($file["size"]) / 1024;
    $x = 0;
    $units = array(' KB', ' MB', ' GB');
    while ($res >= 1024) {
        $res = $res / 1024;
        $x++;
    }
    return  round($res, 2) . $units[$x];
}

/*
  * Gather files or dirs information
 */
function getFilesInfo($path)
{
    $directory  = (dirname(__DIR__) . "/root/" . $path);
    $scanned_directory = array_diff(scandir($directory), array('..', '.'));

    foreach ($scanned_directory as $entry) {
        $i = $directory . '/' . $entry;
        $stat = stat($i);
        $result[] = [
            'mtime' => $stat['mtime'],
            'ctime' => $stat['ctime'],
            'size' => $stat['size'],
            'name' => basename($i),
            // 'path' => preg_replace('@^\./@', '', $stat),
            'path' => $path ?  $path  . '/' . $entry :  $entry,
            'is_dir' => is_dir($i),
            'is_readable' => is_readable($i),
            'is_writable' => is_writable($i),
            'is_executable' => is_executable($i),
        ];
    }
    // print_r($result);
    return $result ?? 'This folder is empty';
}

/*
*/
function getAnchor($entry)
{
    $name = $entry["name"];
    //echo ($name);
    $href = isset($_GET['file']) ? $_GET['file'] . '/' . $name :  $name;
    //echo ($href);

    echo fileIcon($entry);
    if ($entry["is_dir"]) {
        echo "<a href= \"?file=$href\"> $name</a>";
        return;
    }
    echo "<a href= \"#\"> $name</a>";
}

/*
*/
function fileIcon($file)
{
    if ($file["is_dir"]) {
        return '<i class="bx bxs-folder text-primary"></i> ';
    } else {
        return '<i class="bx bxs-file"></i> ';
    }
}
