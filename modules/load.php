<?php
$filename = $_POST['filename'];

$target_directory = "./root";
$target_file = $target_directory . basename($_FILES["file"]["name"]);
$filetype = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
$newfilename = $target_directory . $filename . "." . $filetype;

move_uploaded_file($_FILES["file"]["tmp_name"], $newfilename); //tmp_name is the file temporary stored in the server

if (move_uploaded_file($_FILES["file"]["tmp_name"], $newfilename)) echo 1;
else echo 0;
