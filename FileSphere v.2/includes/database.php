<?php

/*
 * ===========================================================
 *  FileSphere - Database Connection (Local / IIS + MySQL)
 * ===========================================================
 *  Ported from a shared-hosting (InfinityFree) connection to a
 *  local Windows/IIS + MySQL + phpMyAdmin environment.
 *
 *  Adjust these values to match your local MySQL install.
 *  Defaults below match a fresh MySQL install created via the
 *  included schema.sql (root user, no password - dev only).
 * ===========================================================
 */

$host     = "localhost";
$user     = "root";
$password = "local";
$database = "filesphere_db";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");

?>
