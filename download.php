<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: auth.html");
    exit();
}

$uploadDir = "uploads/";

/* Check if file exists in URL */

if (!isset($_GET['file'])) {
    die("No file selected.");
}

/* Prevent path traversal */

$file = basename($_GET['file']);

$filePath = $uploadDir . $file;

/* Check if file exists */

if (!file_exists($filePath)) {
    die("File not found.");
}

/* Determine MIME Type */

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $filePath);
finfo_close($finfo);

/* Download Headers */

header("Content-Description: File Transfer");
header("Content-Type: " . $mime);
header("Content-Disposition: attachment; filename=\"" . basename($file) . "\"");
header("Content-Length: " . filesize($filePath));
header("Cache-Control: no-cache");
header("Pragma: public");
header("Expires: 0");

/* Clear Output Buffer */

ob_clean();
flush();

/* Output File */

readfile($filePath);

exit();
?>