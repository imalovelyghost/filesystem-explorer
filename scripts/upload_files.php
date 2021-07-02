<?php

/********************************
Simple PHP File Manager
Copyright Brahim & Einar
 */

require_once('../constants/path.php');

$action = $_POST['do'] ?? '';
$dir = ($_POST['dir']) ?? '';
$dir = !empty($dir) ? $dir . '/' : '';

if ($action == 'upload-file') {
    $file = $_FILES['file']['tmp_name'];
    $destination = ROOT_PATH_BACK . str_replace('.', '', $dir)
        . $_FILES['file']['name'];

    $data['destination'] = $destination;
    $data['status'] = move_uploaded_file($file, $destination);
}

$data['files'] = $_FILES;
echo json_encode($data);
