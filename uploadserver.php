<?php
error_reporting(E_ALL^E_WARNING);
session_start();
if (!empty($_FILES)) {
    $tempFile = $_FILES['file']['tmp_name'];
    $targetFile = $_FILES['file']['name'];
    $_SESSION['targetfile'] = __DIR__.'/pics/'.$targetFile;
    move_uploaded_file($tempFile, __DIR__.'/pics/'.$targetFile);
    echo 'pics/'.$targetFile;
}
?>