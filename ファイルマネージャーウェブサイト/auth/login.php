<?php
require_once "../includes/config.php";

if(isset($_SESSION['user_id'])){
    header("Location: ../dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>ログイン | FileSphere</title>

<link rel="stylesheet" href="../assets/css/login.css">

</head>

<body>

<div class="login-box">

    <h1>ログイン</h1>

    <form action="login_process.php" method="POST">

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

        <button type="submit">

            ログイン

        </button>

    </form>

    <p>

        アカウントをお持ちでないですか？

        <a href="register.php">

            新規登録

        </a>

    </p>

</div>

</body>
</html>