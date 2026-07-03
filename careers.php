<?php
session_start();

// Check if a user is logged in
$isLoggedIn = isset($_SESSION['username']);
$username = $isLoggedIn ? $_SESSION['username'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FileSphere</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://kit.fontawesome.com/db86999413.js" crossorigin="anonymous"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght,YOPQ@100..900,300&display=swap" rel="stylesheet">
</head>
<body>
  <nav class="navbar">
    <div class="navbar__container">
      <a href="index.php" id="navbar__logo"><i class="fa-solid fa-file" style="color: rgb(66, 171, 242);"></i> FileSphere</a>
      <div class="navbar__toggle" id="mobile-menu">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
      </div>
      <div id="authMessage"></div>
      <ul class="navbar__menu">
        <li class="navbar__item">
          <a href="index.php" class="navbar__links">ホーム</a>
        </li>
        <li class="navbar__item">
          <a href="cprofile.php" class="navbar__links">会社概要</a>
        </li>
        <li class="navbar__item">
          <a href="careers.php" class="navbar__links">採用情報</a>
        </li>
        <?php if ($isLoggedIn): ?>
          <li class="navbar__item">
            <a href="filemanager.php" class="navbar__links">ファイル管理</a>
          </li>
        <?php endif; ?>
        <li class="navbar__item">
          <a href="contact.php" class="navbar__links">お問い合わせ</a>
        </li>
        
        <?php if ($isLoggedIn): ?>
          <li class="navbar__item">
            <span class="navbar__links" style="color: #42b5f2; font-weight: bold;">
              <i class="fa-solid fa-user"></i> <?php echo htmlspecialchars($username); ?>さん
            </span>
          </li>
          <li class="navbar__btn">
            <a href="logout.php" class="button" id="authButton" style="background-color: #f44336;">
              ログアウト
            </a>
          </li>
        <?php else: ?>
          <li class="navbar__btn">
            <a href="auth.html" class="button" id="authButton">
              サインイン
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>
  
  <!-- Careers Page Section -->

<section class="careers">

    <div class="careers__hero">

        <p class="careers__tag">
            採用情報
        </p>

        <h1>
            一緒に未来を創りましょう。
        </h1>

        <p class="careers__subtitle">
            私たちと一緒に未来を創りませんか。
            新しい挑戦を歓迎し、一人ひとりが成長できる環境を提供します。
        </p>

    </div>

    <div class="careers__cards">

        <div class="career__card">

            <h2>ソフトウェアエンジニア</h2>

            <p>
                Webシステム・AI・クラウドサービスの開発を担当します。
            </p>

            <ul>
                <li>正社員</li>
                <li>東京都</li>
                <li>経験者歓迎</li>
            </ul>

            <a href="contact.php">
                詳細を見る →
            </a>

        </div>

        <div class="career__card">

            <h2>UI / UX デザイナー</h2>

            <p>
                ユーザー中心のデザインを通じて
                新しいデジタル体験を創造します。
            </p>

            <ul>
                <li>正社員</li>
                <li>リモート可</li>
                <li>デザイン経験歓迎</li>
            </ul>

            <a href="contact.php">
                詳細を見る →
            </a>

        </div>

        <div class="career__card">

            <h2>サイバーセキュリティエンジニア</h2>

            <p>
                ネットワークやシステムの安全性を守る
                セキュリティ業務を担当します。
            </p>

            <ul>
                <li>正社員</li>
                <li>東京都</li>
                <li>資格保有者歓迎</li>
            </ul>

            <a href="contact.php">
                詳細を見る →
            </a>

        </div>

    </div>

</section>

 <script src="app.js"></script>
</body>
</html>