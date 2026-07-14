<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: auth.html");
    exit();
}

include "database.php";

$username = $_SESSION['username'];

if (!isset($_GET['id'])) {
    header("Location: filemanager.php");
    exit();
}

$id = intval($_GET['id']);

/* Move to trash, verifying ownership first (matches trashfile.php) */

$stmt = mysqli_prepare(
    $conn,
    "UPDATE files
     SET deleted = 1
     WHERE id = ?
     AND owner = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "is",
    $id,
    $username
);

mysqli_stmt_execute($stmt);

header("Location: filemanager.php");
exit();

?>
