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
  <link rel="stylesheet" href="assets/css/contactstyle.css">
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

  <!-- Contact Page Section -->
  <header class="hero">
    <div class="hero-content">
      <h1>お問い合わせ</h1>
      <p>
        ご質問やご相談、ご依頼などがございましたら、
        お気軽にお問い合わせください。
      </p>
    </div>
  </header>

  <section class="contact-section">

    <div class="contact-info">

      <h2>連絡先情報</h2>

      <div class="info-card">
        <h3>📍 本社所在地</h3>
        <p>東京都、日本</p>
      </div>

      <div class="info-card">
        <h3>📧 メール</h3>
        <p>contact@filesphere.jp</p>
      </div>

      <div class="info-card">
        <h3>📞 電話番号</h3>
        <p>+81 3-1234-5678</p>
      </div>

      <div class="info-card">
        <h3>🕒 営業時間</h3>
        <p>
          月曜日〜金曜日<br>
          9:00〜18:00
        </p>
      </div>

    </div>


    <div class="contact-form">

      <h2>お問い合わせフォーム</h2>

      <form>

        <div class="input-group">
          <label>お名前</label>
          <input type="text" placeholder="山田 太郎">
        </div>

        <div class="input-group">
          <label>メールアドレス</label>
          <input type="email" placeholder="example@email.com">
        </div>

        <div class="input-group">
          <label>会社名</label>
          <input type="text" placeholder="会社名（任意）">
        </div>

        <div class="input-group">
          <label>件名</label>
          <input type="text" placeholder="お問い合わせ内容">
        </div>

        <div class="input-group">
          <label>メッセージ</label>
          <textarea rows="7" placeholder="お問い合わせ内容をご入力ください。"></textarea>
        </div>

        <button type="submit">
          送信する
        </button>

      </form>

    </div>

  </section>

  <footer>

    <p>
      © 2026 Filesphere. All Rights Reserved.
    </p>

  </footer>

  <script src="assets/js/app.js"></script>
</body>

</html>