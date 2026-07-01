<?php

require_once "../includes/config.php";

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirm = $_POST['confirm_password'];

// Check passwords
if ($password !== $confirm) {
    die("Passwords do not match.");
}

// Check existing email
$stmt = $pdo->prepare(
    "SELECT id FROM users WHERE email = ?"
);

$stmt->execute([$email]);

if ($stmt->fetch()) {
    die("Email already exists.");
}

// Check existing username
$stmt = $pdo->prepare(
    "SELECT id FROM users WHERE username = ?"
);

$stmt->execute([$username]);

if ($stmt->fetch()) {
    die("Username already exists.");
}

// Hash password
$hashedPassword = password_hash(
    $password,
    PASSWORD_DEFAULT
);

// Insert user
$stmt = $pdo->prepare(
"
INSERT INTO users
(username,email,password)
VALUES
(?,?,?)
"
);

$stmt->execute([
    $username,
    $email,
    $hashedPassword
]);

header("Location: login.php");
exit;