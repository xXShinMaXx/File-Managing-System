<?php
require_once "../includes/config.php";
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規登録 | FileSphere</title>
    <link rel="stylesheet" href="../assets/css/register.css">
</head>
<body>

<div class="register-container">

    <h1>アカウント登録</h1>

    <form action="register_process.php" method="POST">

        <input
            type="text"
            name="username"
            placeholder="ユーザー名"
            required
        >

        <input
            type="email"
            name="email"
            placeholder="メールアドレス"
            required
        >

        <input
            type="password"
            name="password"
            placeholder="パスワード"
            required
        >

        <input
            type="password"
            name="confirm_password"
            placeholder="パスワード（確認）"
            required
        >

        <button type="submit">
            登録
        </button>

    </form>

    <p>
        すでにアカウントをお持ちですか？
        <a href="login.php">ログイン</a>
    </p>

</div>

</body>
</html>