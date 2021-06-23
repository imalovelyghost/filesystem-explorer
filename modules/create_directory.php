<?php
$file = $_GET['file'] ?? '';
$basePath = "../root/" . $file;
$newName =  $_POST["directory-name"];
$directoryName = $basePath . '/' . $newName;

if (mkdir($directoryName, 0777)) {
    //if (mkdir($directoryName)) {

    // created
    header("Location:../index.php?file=$file");
} else {
    //echo "This directory name already exists";
}
