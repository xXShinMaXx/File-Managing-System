<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: auth.html");
    exit();
}

$username = $_SESSION['username'];

include "database.php";

$uploadDir = "uploads/";

$stmt = mysqli_prepare(
    $conn,
    "SELECT *
     FROM files
     WHERE owner=?
     AND archived=0
     AND deleted=0
     ORDER BY upload_date DESC"
);

mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>最近のファイル | FileSphere</title>

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="filemanager.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <script src="https://kit.fontawesome.com/db86999413.js" crossorigin="anonymous"></script>

</head>

<body>

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
                    <a href="index.php" class="navbar__links">ホーム</a>
                </li>

                <li class="navbar__item">
                    <a href="cprofile.php" class="navbar__links">会社概要</a>
                </li>

                <li class="navbar__item">
                    <a href="careers.php" class="navbar__links">システムの使い方</a>
                </li>

                <li class="navbar__item">
                    <a href="filemanager.php" class="navbar__links">ファイル管理</a>
                </li>

                <li class="navbar__item">
                    <a href="contact.php" class="navbar__links">お問い合わせ</a>
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

    <div class="drive-layout">

        <aside class="sidebar">

            <button class="upload-btn" onclick="location.href='filemanager.php'">

                <i class="fa-solid fa-folder"></i>

                戻る

            </button>

            <ul>

                <li onclick="location.href='filemanager.php'">

                    <i class="fa-solid fa-folder"></i>

                    私のファイル

                </li>

                <li onclick="location.href='shared.php'">

                    <i class="fa-solid fa-users"></i>

                    共有ファイル

                </li>

                <li class="active">

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

        <main class="content">

            <h1 style="margin-bottom:30px;">

                <i class="fa-solid fa-clock"></i>

                最近のファイル

            </h1>

            <div class="grid-view active">

                <?php

                if (mysqli_num_rows($result) == 0) {

                    echo "<h3>最近のファイルはありません。</h3>";

                } else {

                    while ($row = mysqli_fetch_assoc($result)) {

                        $file = $row["filename"];
                        $filePath = $uploadDir . $file;

                        if (!file_exists($filePath)) {
                            continue;
                        }

                        $size = round($row["filesize"] / 1024, 2) . " KB";
                        $date = $row["upload_date"];

                        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

                        $icon = "fa-file";
                        $iconStyle = "fa-regular";

                        switch ($extension) {

                            case "pdf":
                                $icon = "fa-file-pdf";
                                $iconStyle = "fa-solid";
                                break;

                            case "doc":
                            case "docx":
                                $icon = "fa-file-word";
                                $iconStyle = "fa-solid";
                                break;

                            case "xls":
                            case "xlsx":
                            case "csv":
                                $icon = "fa-file-excel";
                                $iconStyle = "fa-solid";
                                break;

                            case "png":
                            case "jpg":
                            case "jpeg":
                            case "gif":
                            case "webp":
                                $icon = "fa-file-image";
                                $iconStyle = "fa-solid";
                                break;

                            case "zip":
                            case "rar":
                            case "7z":
                                $icon = "fa-file-zipper";
                                $iconStyle = "fa-solid";
                                break;

                            case "ppt":
                            case "pptx":
                                $icon = "fa-file-powerpoint";
                                $iconStyle = "fa-solid";
                                break;

                            case "mp4":
                            case "avi":
                            case "mov":
                                $icon = "fa-file-video";
                                $iconStyle = "fa-solid";
                                break;

                            case "mp3":
                            case "wav":
                                $icon = "fa-file-audio";
                                $iconStyle = "fa-solid";
                                break;

                            case "php":
                            case "html":
                            case "css":
                            case "js":
                                $icon = "fa-file-code";
                                $iconStyle = "fa-solid";
                                break;

                        }

                        ?>

                        <div class="file-card" data-name="<?php echo strtolower($file); ?>">

                            <i class="<?php echo $iconStyle; ?> <?php echo $icon; ?>"></i>

                            <h3><?php echo htmlspecialchars($file); ?></h3>

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

                            </div>

                        </div>

                        <?php

                    }

                }

                ?>

            </div>

        </main>

    </div>

    <script src="app.js"></script>
    <script src="filemanager.js"></script>

</body>

</html>
```