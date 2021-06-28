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
            'is_media' => is_media($i),
            'is_image' => is_image($i),
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
    $href = isset($_GET['file']) ? $_GET['file'] . '/' . $name :  $name;

    echo fileIcon($entry);
    if ($entry["is_dir"]) {
        echo "<a href= \"?file=$href\"data-type=\"dir\"> $name </a>";
        return;
    } elseif ($entry["is_media"]) {
        echo "<a href= \"./root/$href\"data-type=\"iframe\"> $name </a>";
        return;
    } elseif ($entry["is_image"]) {
        echo "<a href= \"./root/$href\"data-type=\"image\"> $name </a>";
        return;
    }
    echo "<a href= \"#\"data-type=\"other\"> $name</a>";
}

/*
*/
function fileIcon($file)
{
    if ($file["is_dir"]) {
        return '<i class="bx bxs-folder text-primary"></i>';
    } else {
        return '<i class="bx bxs-file"></i> ';
    }
}

/*
 * This function operates at the bit level 
 * shifting bits to left
 * ex: 1024 (dec) -> 1 << 10 (bin)
*/
function asBytes($value)
{
    $ini_v = trim($value);
    $str = ['g' => 1 << 30, 'm' => 1 << 20, 'k' => 1 << 10];
    return intval($ini_v) * ($str[strtolower(substr($ini_v, -1))] ?: 1);
}

/*
*/
function is_media($tmp)
{
    // check REAL MIME type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $type = finfo_file($finfo, $tmp);
    finfo_close($finfo);

    if (
        str_contains($type, 'audio/') ||
        str_contains($type, 'video/')
    ) {
        return true;
    } else {
        return false;
    }
}

/*
*/
function is_image($tmp)
{
    // check REAL MIME type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $type = finfo_file($finfo, $tmp);
    finfo_close($finfo);

    if (str_contains($type, 'image/')) {
        return true;
    } else {
        return false;
    }
}
