<header>

<div class="search">

<span class="material-icons">

search

</span>

<input
type="text"
id="search"
placeholder="ファイルを検索">

</div>

<div class="right">

<button id="darkMode">

<span class="material-icons">

dark_mode

</span>

</button>

<div class="profile" id="profileButton">

    <div class="avatar">

        <?= strtoupper(substr($_SESSION['username'],0,1)); ?>

    </div>

    <span><?= htmlspecialchars($_SESSION['username']); ?></span>

</div>

<?php include "profile-menu.php"; ?>

</span>

</div>

</div>

</header>