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
  <link rel="stylesheet" href="assets/css/style.css">
  <script src="https://kit.fontawesome.com/db86999413.js" crossorigin="anonymous"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght,YOPQ@100..900,300&display=swap" rel="stylesheet">
</head>

<body>
  <nav class="navbar">
    <div class="navbar__container">
      <a href="index.php" id="navbar__logo"><i class="fa-solid fa-file" style="color: rgb(66, 171, 242);"></i>
        FileSphere</a>
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

  <!-- ヒーローセクション -->
  <section class="hero">

    <div class="hero__overlay">

      <div class="hero__content">

        <p class="hero__tag">
          FileSphere
        </p>

        <h1>
          ファイルを、<br>
          もっとシンプルに。
        </h1>

        <p class="hero__text">
          保存・共有・共同作業を、いつでもどこでも。<br>
          FileSphereは、あなたのファイル管理をより簡単に、より効率的にします。
        </p>

        <a href="filemanager.php" class="hero__button">
          ファイルを開く
        </a>

      </div>

    </div>

    <svg class="hero__wave" viewBox="0 0 1440 320" preserveAspectRatio="none">

      <path fill="#111111"
        d="M0,224L80,213.3C160,203,320,181,480,181.3C640,181,800,203,960,218.7C1120,235,1280,245,1360,250.7L1440,256L1440,320L0,320Z">
      </path>

    </svg>

  </section>


  <!-- 機能セクション -->
  <section class="features">
    <div class="card">
      <span class="fa-solid fa-cloud">cloud</span>
      <h3>クラウド保存</h3>
      <p>安全なクラウドでファイルを保存。</p>
    </div>
    <div class="card">
      <span class="fa-solid fa-users">groups</span>
      <h3>共同編集</h3>
      <p>チームとリアルタイムで共同作業。</p>
    </div>
    <div class="card">
      <span class="fa-solid fa-lock">lock</span>
      <h3>安全な共有</h3>
      <p>権限設定で安心して共有できます。</p>
    </div>
    <div class="card">
      <span class="fa-solid fa-upload">backup</span>
      <h3>バックアップ</h3>
      <p>大切なデータを自動で保護します。</p>
    </div>
  </section>

  <!-- フッターセクション -->
  <div class="footer__container">
    <section class="social__media">
      <div class="social__media--wrap">
        <div class="footer__logo">
          <a href="/" id="footer__logo"><i class="fa-solid fa-file"></i>FileSphere</a>
        </div>
        <p class="website__rights">© FileSphere 2026. All Rights Reserved.</p>
        <div class="social__icons">
          <a class="social__icon--link" href="/" target="_blank" aria-label="HTML">
            <i class="fab fa-html5"></i>
          </a>
          <a class="social__icon--link" href="/" target="_blank" aria-label="CSS">
            <i class="fab fa-css3-alt"></i>
          </a>
          <a class="social__icon--link" href="/" target="_blank" aria-label="JavaScript">
            <i class="fab fa-js"></i>
          </a>
          <a class="social__icon--link" href="/" target="_blank" aria-label="PHP">
            <i class="fab fa-php"></i>
          </a>
          <a class="social__icon--link" href="/" target="_blank" aria-label="GitHub">
            <i class="fab fa-github"></i>
          </a>
        </div>
      </div>
    </section>
  </div>

  <script src="assets/js/app.js"></script>
</body>

</html>