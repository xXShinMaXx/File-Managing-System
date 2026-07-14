<?php
session_start();

if (!isset($_SESSION['username'])) {
    die("Access denied.");
}

include "database.php";

$username = $_SESSION['username'];

if (!isset($_GET['file'])) {
    die("No file specified.");
}

$file = basename($_GET['file']);

$uploadDir = "uploads/";
$filePath = $uploadDir . $file;

/*
---------------------------------------
Check if user owns the file
---------------------------------------
*/

$stmt = mysqli_prepare(
    $conn,
    "SELECT id
     FROM files
     WHERE filename = ?
     AND owner = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "ss",
    $file,
    $username
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$allowed = false;

if (mysqli_num_rows($result) > 0) {

    $allowed = true;

} else {

    /*
    ---------------------------------------
    Check if file was shared with user
    ---------------------------------------
    */

    $stmt = mysqli_prepare(
        $conn,
        "SELECT files.id
         FROM files
         INNER JOIN shared_files
             ON files.id = shared_files.file_id
         WHERE files.filename = ?
         AND shared_files.shared_with = ?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ss",
        $file,
        $username
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {

        $allowed = true;

    }

}

if (!$allowed) {

    die("Access Denied.");

}

if (!file_exists($filePath)) {

    die("File not found.");

}

header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"" . basename($file) . "\"");
header("Content-Length: " . filesize($filePath));

readfile($filePath);
exit;