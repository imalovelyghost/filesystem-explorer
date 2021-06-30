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
            'is_media' => is_audio($i) || is_video($i),
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
    $type = 'unknown';

    echo fileIcon($entry);
    if ($entry["is_dir"]) {
        echo "<a href=\"?file=$href\"data-type=\"dir\"> 
            $name 
        </a>";
        return;
    }

    if ($entry["is_media"]) {
        $type  = 'iframe';
    } elseif ($entry["is_image"]) {
        $type  = 'image';
    }
    echo "<a href= \"./root/$href\"data-type=\"$type\"> 
            $name 
        </a>";
}

/*
*/
function fileIcon($file)
{
    if ($file["is_dir"]) {
        return '<i class="bi bi-folder-fill text-primary"></i>';
    } elseif ($file["is_image"]) {
        echo '<i class="bi bi-file-earmark-image"></i>';
    } elseif ($file["is_media"]) {
        echo '<i class="bi bi-file-earmark-play-fill"></i>';
    } else {
        return '<i class="bi bi-file-earmark"></i> ';
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
function is_audio($tmp)
{
    // check REAL MIME type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $type = finfo_file($finfo, $tmp);
    finfo_close($finfo);

    if (str_contains($type, 'audio/')) {
        return true;
    } else {
        return false;
    }
}

function is_video($tmp)
{
    // check REAL MIME type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $type = finfo_file($finfo, $tmp);
    finfo_close($finfo);

    if (str_contains($type, 'video/')) {
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
