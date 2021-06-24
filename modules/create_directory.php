<?php
$file = $_GET['file'] ?? '';
$basePath = "../root/" . $file;
$newName =  $_POST["directory-name"];
$directoryName = $basePath . '/' . $newName;

echo $directoryName;

if (mkdir($directoryName, 0777)) {
    // created
    header("Location:../index.php?file=$file");
} else {
    //echo "This directory name already exists";
}
