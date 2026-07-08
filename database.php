<?php

$host = "sql201.infinityfree.com";
$user = "if0_42317318";
$password = "mXGqkqoKNy0MW";
$database = "if0_42317318_filesphere_db";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>