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
    $scanned_directory = array_diff(scandir($path), array('..', '.'));

    foreach ($scanned_directory as $entry) {
        $i = $path . '/' . $entry;
        $stat = stat($i);
        $result[] = [
            'mtime' => $stat['mtime'],
            'ctime' => $stat['ctime'],
            'size' => $stat['size'],
            'name' => basename($i),
            'path' => $path ?  $path  . '/' . $entry :  $entry,
            'is_dir' => is_dir($i),
            'is_media' => is_audio($i) || is_video($i),
            'is_image' => is_image($i),
            'is_readable' => is_readable($i),
            'is_writable' => is_writable($i),
            'is_executable' => is_executable($i),
        ];
    }
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
        return  '<i class="bi bi-file-earmark-image"></i>';
    } elseif ($file["is_media"]) {
        return '<i class="bi bi-file-earmark-play-fill"></i>';
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

/*
*/
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

/*
 * Search Functions
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

/*
*/
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
