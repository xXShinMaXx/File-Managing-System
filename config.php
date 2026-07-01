<?php

declare(strict_types=1);

// -----------------------------
// Database Configuration
// -----------------------------

$host = "localhost";
$dbname = "filesphere_db";
$username = "root";
$password = "";

// -----------------------------
// PDO Connection
// -----------------------------

try {

    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

} catch (PDOException $e) {

    die("Database Connection Failed: " . $e->getMessage());

}

// -----------------------------
// Start Session
// -----------------------------

if (session_status() === PHP_SESSION_NONE) {

    session_start();

}