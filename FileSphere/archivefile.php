<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: auth.html");
    exit();
}

include "database.php";

$username = $_SESSION['username'];

if (!isset($_GET['id'])) {
    die("No file selected.");
}

$fileId = intval($_GET['id']);

/* Verify ownership */

$stmt = mysqli_prepare(
    $conn,
    "SELECT id
     FROM files
     WHERE id = ?
     AND owner = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "is",
    $fileId,
    $username
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    die("You do not have permission to archive this file.");
}

/* Archive */

$stmt = mysqli_prepare(
    $conn,
    "UPDATE files
     SET archived = 1
     WHERE id = ?
     AND owner = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "is",
    $fileId,
    $username
);

if (mysqli_stmt_execute($stmt)) {

    header("Location: filemanager.php");
    exit();

} else {

    die("Database Error: " . mysqli_error($conn));

}
?>