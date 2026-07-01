<?php

require_once "../includes/config.php";

$email = trim($_POST['email']);
$password = $_POST['password'];

$stmt = $pdo->prepare("
SELECT *
FROM users
WHERE email = ?
LIMIT 1
");

$stmt->execute([$email]);

$user = $stmt->fetch();

if(!$user){

    die("メールアドレスが見つかりません。");

}

if(!password_verify($password,$user['password'])){

    die("パスワードが間違っています。");

}

$_SESSION['user_id'] = $user['id'];

$_SESSION['username'] = $user['username'];

$_SESSION['email'] = $user['email'];

header("Location: ../dashboard.php");

exit();