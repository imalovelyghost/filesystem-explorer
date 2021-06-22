<?php
$basePath = "../root/";
$newName =  $_POST["directory-name"];
$directoryName = $basePath . $newName;
//mkdir($directoryName, 0777);

if (mkdir($directoryName, 0777)) {
//if (mkdir($directoryName)) {

    // created
    header("Location:../index.php");
} else {
    //echo "This directory name already exists";
}
