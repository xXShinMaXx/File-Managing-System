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
          <a href="careers.php" class="navbar__links">システムの使い方</a>
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
  
  <!-- Company Profile Section -->

<section class="company">
    <div class="company__content">
        <span class="tag">会社概要</span>

        <h1>FileSphereについて</h1>

        <p>
            FileSphereは、企業や組織向けのクラウドファイル管理サービスです。<br>
           ファイルの保存・共有・共同編集を安全かつ簡単に行える環境を提供し、
          生産性向上とデジタルワークスペースの実現を支援しています。
        </p>

        <a href="careers.php" class="company__button">
            詳しく見る →
        </a>
    </div>

    <div class="company__card">
        <h2>FileSphere</h2>

        <div class="info">
            <span>設立</span>
            <span>2026年</span>
        </div>

        <div class="info">
            <span>本社</span>
            <span>東京都、日本</span>
        </div>

        <div class="info">
            <span>業界</span>
            <span>テクノロジー</span>
        </div>

        <div class="info">
            <span>従業員数</span>
            <span>300+</span>
        </div>

        <div class="info">
            <span>ミッション</span>
            <span>未来のために革新を。</span>
        </div>
    </div>
</section>

  <script src="app.js"></script>
</body>
</html>