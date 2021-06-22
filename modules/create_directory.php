<?php

$basePath = "../root/";
$newName =  $_POST["directory-name"];
$directoryName = $basePath . $newName;

if (mkdir($directoryName, 0777)) {
    // created
    header("Location:../index.php");
} else {
    echo "This directory name already exists";
}
