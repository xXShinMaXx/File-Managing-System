<?php
session_start();

if (!isset($_SESSION['username'])) {
    http_response_code(401);
    exit("Unauthorized");
}

$username = $_SESSION['username'];

$uploadDir = "uploads/";
$jsonFile = "files.json";

if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

/* Load Metadata */

$metadata = [];

if (file_exists($jsonFile)) {
    $metadata = json_decode(file_get_contents($jsonFile), true);

    if (!is_array($metadata)) {
        $metadata = [];
    }
}

/* Allowed File Types */

$allowed = [
    "jpg","jpeg","png","gif","webp",
    "pdf",
    "doc","docx",
    "xls","xlsx",
    "ppt","pptx",
    "txt",
    "csv",
    "zip","rar","7z",
    "mp3","wav",
    "mp4","avi","mov",
    "php","html","css","js"
];

$maxSize = 20 * 1024 * 1024; //20MB

if (!isset($_FILES['uploaded_file'])) {
    exit("No file selected.");
}

/*
----------------------------------------
Convert SINGLE upload into MULTIPLE format
----------------------------------------
*/

$fileNames = $_FILES['uploaded_file']['name'];

if (!is_array($fileNames)) {

    $fileNames = [$_FILES['uploaded_file']['name']];
    $tmpNames  = [$_FILES['uploaded_file']['tmp_name']];
    $sizes     = [$_FILES['uploaded_file']['size']];
    $errors    = [$_FILES['uploaded_file']['error']];

} else {

    $tmpNames = $_FILES['uploaded_file']['tmp_name'];
    $sizes    = $_FILES['uploaded_file']['size'];
    $errors   = $_FILES['uploaded_file']['error'];

}

/* Upload Files */

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

    if (file_exists($destination)) {

        $filename = time() . "_" . $filename;

        $destination = $uploadDir . $filename;

    }

    if (move_uploaded_file($tmpNames[$i], $destination)) {

        $metadata[$filename] = [

            "uploader" => $username,

            "date" => date("Y-m-d H:i:s"),

            "size" => filesize($destination)

        ];

    }

}

file_put_contents(
    $jsonFile,
    json_encode($metadata, JSON_PRETTY_PRINT)
);

echo "success";
?>