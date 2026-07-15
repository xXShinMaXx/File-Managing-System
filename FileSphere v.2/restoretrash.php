<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: auth.html");
    exit();
}

include "includes/database.php";

$username=$_SESSION['username'];

$id=intval($_GET['id']);

$stmt=mysqli_prepare(
$conn,
"UPDATE files
SET deleted=0
WHERE id=?
AND owner=?"
);

mysqli_stmt_bind_param(
$stmt,
"is",
$id,
$username
);

mysqli_stmt_execute($stmt);

header("Location:trash.php");

?>