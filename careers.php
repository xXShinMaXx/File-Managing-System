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
  <link rel="stylesheet" href="careers.css">
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
  
  <!-- Careers Page Section -->

<section class="careers">

    <div class="careers__hero">

        <p class="careers__tag">
            システムの使い方
        </p>

        <h1>
           FileSphereでファイルを簡単・安全に管理できます。
        </h1>

        <p class="careers__subtitle">
            私たちのファイル管理システムで、ファイルをより安全・簡単・効率的に管理しませんか。FileSphereは、アップロード、整理、共有、ダウンロードを一つのプラットフォームで実現します。
        </p>

    </div>

    <div class="careers__cards">

        <div class="career__card">

            <h2>ファイルアップロード</h2>

            <p>
                ドラッグ＆ドロップまたはボタンから簡単にアップロードできます。
            </p>

            <ul>
                <li>ファイル検索 | 名前で瞬時に検索できます。</li>
                <li>ダウンロード | 必要なファイルをいつでもダウンロードできます。</li>
                <li>削除 | 不要なファイルを安全に削除できます。</li>
            </ul>

            <a href="filemanager.php">
                詳細を見る →
            </a>

        </div>

        <div class="career__card">

            <h2>ご利用ガイド</h2>

            <p>
                ログインします。
            </p>

            <ul>
                <li>「New」をクリックします。</li>
                <li>ファイルをアップロードします。</li>
                <li>検索・ダウンロード・削除できます。</li>
            </ul>

            <a href="filemanager.php">
                詳細を見る →
            </a>

        </div>

        <div class="career__card">

            <h2>FAQ</h2>

            <p>
                よくある質問
            </p>

            <ul>
                <li> Q ファイルサイズの上限は？ A 20MBまでアップロードできます。</li>
                <li> Q 複数アップロードできますか？ A はい、対応しています。</li>
                <li> Q 削除したファイルは復元できますか？ A 現在は完全削除されます。</li>
            </ul>

            <a href="filemanager.php">
                詳細を見る →
            </a>

        </div>

    </div>

</section>

 <script src="app.js"></script>
</body>
</html>