<?php

error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

session_start();
header("Content-Type: application/json");

if (!isset($_SESSION['username'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Please login first."
    ]);
    exit();
}

include "includes/database.php";

$owner = $_SESSION["username"];

$fileId = intval($_POST["fileId"] ?? 0);
$sharedWith = trim($_POST["username"] ?? "");

if ($fileId == 0 || $sharedWith == "") {
    echo json_encode([
        "status" => "error",
        "message" => "Please enter a username."
    ]);
    exit();
}

/* Check recipient exists */

$stmt = mysqli_prepare(
    $conn,
    "SELECT ID FROM user WHERE username=?"
);

mysqli_stmt_bind_param($stmt, "s", $sharedWith);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {

    echo json_encode([
        "status" => "error",
        "message" => "User not found."
    ]);

    exit();
}

/* Check ownership */

$stmt = mysqli_prepare(
    $conn,
    "SELECT ID
     FROM files
     WHERE ID=? AND owner=?"
);

mysqli_stmt_bind_param(
    $stmt,
    "is",
    $fileId,
    $owner
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {

    echo json_encode([
        "status" => "error",
        "message" => "You do not own this file."
    ]);

    exit();
}

/* Prevent duplicate */

$stmt = mysqli_prepare(
    $conn,
    "SELECT ID
     FROM shared_files
     WHERE file_id=? AND shared_with=?"
);

mysqli_stmt_bind_param(
    $stmt,
    "is",
    $fileId,
    $sharedWith
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {

    echo json_encode([
        "status" => "error",
        "message" => "File already shared."
    ]);

    exit();
}

/* Share */

$stmt = mysqli_prepare(
    $conn,
    "INSERT INTO shared_files
    (file_id,owner,shared_with)
    VALUES(?,?,?)"
);

mysqli_stmt_bind_param(
    $stmt,
    "iss",
    $fileId,
    $owner,
    $sharedWith
);

if (mysqli_stmt_execute($stmt)) {

    echo json_encode([
        "status" => "success",
        "message" => "File shared successfully!"
    ]);

} else {

    echo json_encode([
        "status" => "error",
        "message" => mysqli_error($conn),
        "stmt_error" => mysqli_stmt_error($stmt)
    ]);

}

exit();