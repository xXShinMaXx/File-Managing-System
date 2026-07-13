<?php
session_start();

/* =========================== Authentication =========================== */

if (!isset($_SESSION['username'])) {
    header("Location: auth.html");
    exit();
}

$username = $_SESSION['username'];

/* =========================== Upload Folder =========================== */

$uploadDir = "uploads/";

if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

/* =========================== Read Files =========================== */

include "database.php";

$stmt = mysqli_prepare(
    $conn,
    "SELECT *
FROM files
WHERE owner=?
AND archived=0
AND deleted=0
ORDER BY upload_date DESC"
);

mysqli_stmt_bind_param(
    $stmt,
    "s",
    $username
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ファイルマネージャー | FileSphere</title>

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="filemanager.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <script src="https://kit.fontawesome.com/db86999413.js" crossorigin="anonymous"></script>

</head>

<body>

    <!-- =========================== NAVIGATION BAR =========================== -->

    <nav class="navbar">

        <div class="navbar__container">

            <a href="index.php" id="navbar__logo">

                <i class="fa-solid fa-file" style="color:#42b5f2;"></i>

                FileSphere

            </a>

            <div class="navbar__toggle" id="mobile-menu">

                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>

            </div>

            <ul class="navbar__menu">

                <li class="navbar__item">
                    <a href="index.php" class="navbar__links">
                        ホーム
                    </a>
                </li>

                <li class="navbar__item">
                    <a href="cprofile.php" class="navbar__links">
                        会社概要
                    </a>
                </li>

                <li class="navbar__item">
                    <a href="careers.php" class="navbar__links">
                        システムの使い方
                    </a>
                </li>

                <li class="navbar__item">
                    <a href="filemanager.php" class="navbar__links">
                        ファイル管理
                    </a>
                </li>

                <li class="navbar__item">
                    <a href="contact.php" class="navbar__links">
                        お問い合わせ
                    </a>
                </li>

                <li class="navbar__item">

                    <span class="navbar__links" style="color:#42b5f2;font-weight:bold;">

                        <i class="fa-solid fa-user"></i>

                        <?php echo htmlspecialchars($username); ?> さん

                    </span>

                </li>

                <li class="navbar__btn">

                    <a href="logout.php" class="button" style="background:#f44336;">

                        ログアウト

                    </a>

                </li>

            </ul>

        </div>

    </nav>

    <!-- =========================== MAIN LAYOUT =========================== -->

    <div class="drive-layout">

        <!-- =========================== SIDEBAR =========================== -->

        <aside class="sidebar">

            <button class="upload-btn" onclick="document.getElementById('fileInput').click();">

                <i class="fa-solid fa-plus"></i>

                新規

            </button>

            <ul>

                <li class="active">

                    <i class="fa-solid fa-folder"></i>

                    私のファイル

                </li>

                <li onclick="location.href='shared.php'">

                    <i class="fa-solid fa-users"></i>

                    共有ファイル

                </li>

                <li onclick="location.href='recent.php'">

                    <i class="fa-solid fa-clock"></i>

                    最近の

                </li>

                <li onclick="location.href='archive.php'">

                    <i class="fa-solid fa-box-archive"></i>

                    アーカイブ

                </li>

                <li onclick="location.href='trash.php'">
                    <i class="fa-solid fa-trash"></i>

                    ゴミ箱ファイル

                </li>

            </ul>

        </aside>

        <!-- =========================== CONTENT =========================== -->

        <main class="content">

            <!-- Toolbar -->

            <div class="toolbar">

                <div class="search">

                    <i class="fa-solid fa-magnifying-glass"></i>

                    <input type="text" id="searchInput" placeholder="ファイルを検索する...">

                </div>

                <div class="view-buttons">

                    <button id="gridView">

                        <i class="fa-solid fa-table-cells-large"></i>

                    </button>

                    <button id="listView">

                        <i class="fa-solid fa-list"></i>

                    </button>

                </div>

            </div>

            <!-- =========================== UPLOAD FORM =========================== -->

            <form id="uploadForm" action="upload.php" method="POST" enctype="multipart/form-data">

                <input type="file" id="fileInput" name="uploaded_file[]" multiple hidden>


            </form>

            <!-- =========================== DRAG & DROP =========================== -->

            <div id="dropZone" class="drop-zone">

                <i class="fa-solid fa-cloud-arrow-up"></i>

                <h2>ここにファイルをドラッグ＆ドロップしてください</h2>

                <p>または <strong>「新規」</strong> をクリックしてアップロードしてください。</p>

            </div>

            <!-- =========================== GRID VIEW =========================== -->

            <div id="gridContainer" class="grid-view active">

                <?php

                if (mysqli_num_rows($result) == 0) {

                    echo "<h3>No files uploaded.</h3>";

                } else {

                    while ($row = mysqli_fetch_assoc($result)) {

                        $file = $row["filename"];

                        $filePath = $uploadDir . $file;

                        if (!file_exists($filePath)) {
                            continue;
                        }

                        $size = round($row["filesize"] / 1024, 2) . " KB";

                        $date = $row["upload_date"];

                        $owner = $row["owner"];

                        ?>

                        <div class="file-card" data-name="<?php echo strtolower($file); ?>">

                            <i class="fa-regular fa-file"></i>

                            <h3>

                                <?php echo htmlspecialchars($file); ?>

                            </h3>

                            <p>

                                <i class="fa-solid fa-user"></i>

                                <?php echo htmlspecialchars($owner); ?>

                            </p>

                            <p>

                                <i class="fa-solid fa-calendar"></i>

                                <?php echo date("Y-m-d H:i", strtotime($date)); ?>

                            </p>

                            <p>

                                <i class="fa-solid fa-hard-drive"></i>
                                <?php echo $size; ?>

                            </p>

                            <div class="card-buttons">

                                <a href="download.php?file=<?php echo urlencode($file); ?>" class="btn-download">
                                    <i class="fa-solid fa-download"></i>
                                    ダウンロード
                                </a>

                                <button type="button" class="btn-share"
                                    onclick="openShareModal(<?php echo $row['id']; ?>,'<?php echo htmlspecialchars($file, ENT_QUOTES); ?>')">

                                    <i class="fa-solid fa-share-nodes"></i>
                                    共有

                                </button>

                                <a href="trashfile.php?id=<?php echo $row['id']; ?>" class="btn-delete"
                                    onclick="return confirm('Delete this file?');">

                                    <i class="fa-solid fa-trash"></i>
                                    消去

                                </a>

                                <a href="archivefile.php?id=<?php echo $row['id']; ?>" class="btn-archive">

                                    <i class="fa-solid fa-box-archive"></i>
                                    アーカイブ

                                </a>

                            </div>

                        </div>

                        <?php

                    }

                }

                ?>

            </div>

            <!-- =========================== LIST VIEW =========================== -->

            <table class="file-table" id="listContainer">

                <thead>

                    <tr>

                        <th>ファイル名</th>

                        <th>サイズ</th>

                        <th>最終更新日</th>

                        <th>アクション</th>

                    </tr>

                </thead>

                <tbody>

                    <?php

                    // Reuse the result set from the Grid View instead of
                    // re-including database.php and re-running the query,
                    // which was causing a duplicate query (and risked a
                    // fatal "Cannot redeclare" error if database.php
                    // defines any functions).
                    mysqli_data_seek($result, 0);

                    if (mysqli_num_rows($result) > 0) {

                        while ($row = mysqli_fetch_assoc($result)) {

                            $file = $row['filename'];

                            $filePath = $uploadDir . $file;

                            if (!file_exists($filePath)) {
                                continue;
                            }

                            $size = round($row['filesize'] / 1024, 2) . " KB";

                            $date = $row['upload_date'];

                            ?>

                            <tr data-name="<?php echo strtolower($file); ?>">

                                <td>
                                    <i class="fa-regular fa-file"></i>
                                    <?php echo htmlspecialchars($file); ?>
                                </td>

                                <td>
                                    <?php echo $size; ?>
                                </td>

                                <td>
                                    <?php echo date("Y-m-d H:i", strtotime($date)); ?>
                                </td>

                                <td>

                                    <a href="download.php?file=<?php echo urlencode($file); ?>" class="btn-download">

                                        <i class="fa-solid fa-download"></i>

                                        ダウンロード

                                    </a>

                                    <a href="shared.php?id=<?php echo $row['id']; ?>" class="btn-share">

                                        <i class="fa-solid fa-share-nodes"></i>

                                        共有

                                    </a>

                                    <a href="trashfile.php?id=<?php echo $row['id']; ?>" class="btn-delete"
                                        onclick="return confirm('Move to Trash?');">

                                        <i class="fa-solid fa-trash"></i>

                                        消去

                                    </a>

                                    <a href="archivefile.php?id=<?php echo $row['id']; ?>" class="btn-archive">

                                        <i class="fa-solid fa-box-archive"></i>

                                        アーカイブ

                                    </a>

                                </td>

                            </tr>

                            <?php

                        }

                    } else {

                        ?>

                        <tr>
                            <td colspan="4" style="text-align:center;">
                                ファイルはアップロードされていません。
                            </td>
                        </tr>

                        <?php

                    }

                    ?>

                </tbody>

            </table>

        </main>

    </div>

    <!-- =========================== SHARE VIEW =========================== -->

    <div id="shareModal" class="share-modal" style="display:none;">

        <div class="share-box">

            <h2>ファイルを共有する</h2>

            <p>

                共有

                <strong id="shareFileName"></strong>

            </p>

            <input type="hidden" id="shareFileId">

            <input type="text" id="shareUsername" placeholder="Enter username">

            <br><br>

            <div class="share-actions">

                <button class="cancel-btn" onclick="closeShareModal()">
                    キャンセル
                </button>

                <button class="share-btn" onclick="shareFile()">
                    <i class="fa-solid fa-share-nodes"></i>
                    共有
                </button>

            </div>

        </div>

    </div>

    <script src="app.js"></script>
    <script src="filemanager.js?v=<?php echo time(); ?>"></script>

</body>

</html>
