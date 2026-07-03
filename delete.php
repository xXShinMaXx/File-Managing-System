<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: auth.html");
    exit();
}

$uploadDir = "uploads/";
$jsonFile = "files.json";

/* Check if file parameter exists */

if (!isset($_GET['file'])) {
    header("Location: filemanager.php");
    exit();
}

/* Get safe filename */

$file = basename($_GET['file']);
$filePath = $uploadDir . $file;

/* Delete the actual file */

if (file_exists($filePath)) {
    unlink($filePath);
}

/* Remove metadata */

if (file_exists($jsonFile)) {

    $metadata = json_decode(file_get_contents($jsonFile), true);

    if (isset($metadata[$file])) {

        unset($metadata[$file]);

        file_put_contents(
            $jsonFile,
            json_encode($metadata, JSON_PRETTY_PRINT)
        );
    }
}

/* Return to File Manager */

header("Location: filemanager.php");
exit();

?>