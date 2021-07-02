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
    $directory  = (ROOT_PATH . $path);
    $scanned_directory = array_diff(scandir($directory), array('..', '.'));
    foreach ($scanned_directory as $entry) {
        $iRoute = $directory . '/' . $entry;
        $result[] = statFiles($iRoute);
    }
    return $result ?? 'This folder is empty';
}

/*
 */
function statFiles($file)
{
    $stat = stat($file);
    return [
        'mtime' => $stat['mtime'],
        'ctime' => $stat['ctime'],
        'size' => $stat['size'],
        'name' => basename($file),
        'path' => deleteRoot($file),
        'ext' => pathinfo($file, PATHINFO_EXTENSION),
        'is_dir' => is_dir($file),
        'is_media' => is_audio($file) || is_video($file),
        'is_image' => is_image($file),
        'is_readable' => is_readable($file),
        'is_writable' => is_writable($file),
        'is_executable' => is_executable($file),
    ];
}

/*
 */
function deleteRoot($path)
{
    if (str_contains($path, 'root')) {
        $path = str_replace('../', '', $path);
        $path = str_replace('./', '', $path);
        $path = str_replace('root//', '', $path);
        $path = str_replace('root/', '', $path);
        $path = str_replace('root\\', '', $path);
        $path = str_replace('root', '', $path);
        return $path;
    }
}

/*
*/
function getAnchor($entry, $nameSearch = "")
{
    $name = $entry["name"];
    $path = $entry["path"];
    $href = ROOT_PATH . $entry["path"];
    $anchorName = $nameSearch ?: $name;
    $type = 'unknown';

    if ($entry["is_dir"]) {
        return " <a href=\"?file=$path\" data-type=\"dir\">$anchorName</a>";
    }
    if ($entry["is_media"]) {
        $type  = 'iframe';
    } elseif ($entry["is_image"]) {
        $type  = 'image';
    }
    return " <a href=\"$href\" data-type=\"$type\">$anchorName</a>";
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
    } elseif ($file["ext"] == "pdf") {
        return '<i class="bi bi-file-earmark-pdf"></i>';
    } elseif ($file["ext"] == "ppt") {
        return '<i class="bi bi-file-earmark-ppt"></i>';
    } elseif ($file["ext"] == "zip") {
        return '<i class="bi bi-file-earmark-zip"></i>';
    } elseif ($file["ext"] == "txt") {
        return '<i class="bi bi-file-earmark-text"></i>';
    } else {
        return '<i class="bi bi-file-earmark"></i>';
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
*/
function getFilesCount($dir)
{
    $dir = ROOT_PATH . $dir;
    if (is_dir($dir)) {
        $files = array_diff(scandir($dir), ['.', '..']);
        return count($files);
    }
    return 0;
}

function formatDate($date)
{
    $todayHour = date("H:i", $date);
    $creationDayFormatted = gmdate("Y D d", $date);
    $creationDay = gmdate("Y/m/d", $date);
    $today = (date("Y/m/d"));

    if ($today == $creationDay) {
        echo ($todayHour);
    } else {
        echo ($creationDayFormatted);
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
