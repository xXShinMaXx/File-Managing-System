<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

include "includes/database.php";

if (!isset($_SESSION['username'])) {
    http_response_code(401);
    exit("Unauthorized");
}

// FIX: Get the username from the session
$username = $_SESSION['username'];

$uploadDir = "uploads/";

if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$allowed = [
    "jpg",
    "jpeg",
    "png",
    "gif",
    "webp",
    "pdf",
    "doc",
    "docx",
    "xls",
    "xlsx",
    "ppt",
    "pptx",
    "txt",
    "csv",
    "zip",
    "rar",
    "7z",
    "mp3",
    "wav",
    "mp4",
    "avi",
    "mov",
    "php",
    "html",
    "css",
    "js"
];

$maxSize = 20 * 1024 * 1024; // 20MB

if (!isset($_FILES['uploaded_file'])) {
    exit("No file selected.");
}

/*
Convert single upload into multiple upload format
*/

$fileNames = $_FILES['uploaded_file']['name'];

if (!is_array($fileNames)) {

    $fileNames = [$_FILES['uploaded_file']['name']];
    $tmpNames = [$_FILES['uploaded_file']['tmp_name']];
    $sizes = [$_FILES['uploaded_file']['size']];
    $errors = [$_FILES['uploaded_file']['error']];

} else {

    $tmpNames = $_FILES['uploaded_file']['tmp_name'];
    $sizes = $_FILES['uploaded_file']['size'];
    $errors = $_FILES['uploaded_file']['error'];

}

foreach ($fileNames as $i => $originalName) {

    if ($errors[$i] != UPLOAD_ERR_OK) {
        continue;
    }

    $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    if (!in_array($extension, $allowed)) {
        continue;
    }

    if ($sizes[$i] > $maxSize) {
        continue;
    }

    $filename = preg_replace(
        "/[^A-Za-z0-9_\-.]/",
        "_",
        basename($originalName)
    );

    $destination = $uploadDir . $filename;

    // Prevent duplicate filenames
    if (file_exists($destination)) {
        $filename = time() . "_" . $filename;
        $destination = $uploadDir . $filename;
    }

    if (move_uploaded_file($tmpNames[$i], $destination)) {

        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO files (filename, owner, filesize, filetype)
             VALUES (?, ?, ?, ?)"
        );

        // Show SQL error if prepare() fails
        if (!$stmt) {
            die("Prepare failed: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param(
            $stmt,
            "ssis",
            $filename,
            $username,
            $sizes[$i],
            $extension
        );

        if (!mysqli_stmt_execute($stmt)) {
            die("Execute failed: " . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
    }
}

echo "success";
?>