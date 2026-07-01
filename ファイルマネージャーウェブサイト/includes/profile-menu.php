<div id="profileMenu" class="profile-menu">

    <div class="profile-header">

        <div class="profile-avatar">
            <?= strtoupper(substr($_SESSION['username'], 0, 1)); ?>
        </div>

        <div class="profile-info">
            <h3><?= htmlspecialchars($_SESSION['username']); ?></h3>
            <p><?= htmlspecialchars($_SESSION['email']); ?></p>
        </div>

    </div>

    <hr>

    <ul>

        <li>
            <span class="material-icons">person</span>
            マイプロフィール
        </li>

        <li>
            <span class="material-icons">settings</span>
            設定
        </li>

        <li id="toggleDarkMode">
            <span class="material-icons">dark_mode</span>
            ダークモード
        </li>

        <li>
            <span class="material-icons">storage</span>
            ストレージ
        </li>

        <li onclick="location.href='auth/logout.php'">
            <span class="material-icons">logout</span>
            ログアウト
        </li>

    </ul>

</div>