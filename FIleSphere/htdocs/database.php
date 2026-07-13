<?php

$host = "sql201.infinityfree.com";
$user = "if0_42317318";
$password = "mXGqkqoKNy0MW";
$database = "if0_42317318_filesphere_db";

$conn = mysqli_connect($host, $user, $password, $database);
mysqli_set_charset($conn, "utf8mb4");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}



$stmt = mysqli_prepare(

    $conn,

    "SELECT

        files.*

    FROM files

    INNER JOIN shared_files

    ON files.id = shared_files.file_id

    WHERE shared_files.shared_with = ?

    ORDER BY shared_date DESC"

);

mysqli_stmt_bind_param(

    $stmt,

    "s",

    $username

);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

?>