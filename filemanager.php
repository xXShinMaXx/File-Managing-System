<?php
session_start();

/* ===========================
   Authentication
=========================== */

if (!isset($_SESSION['username'])) {
    header("Location: auth.html");
    exit();
}

$username = $_SESSION['username'];

/* ===========================
   Upload Folder
=========================== */

$uploadDir = "uploads/";

if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

/* ===========================
   Metadata
=========================== */

$metadata = [];

if(file_exists("files.json")){
    $metadata = json_decode(file_get_contents("files.json"), true);
}

/* ===========================
   Read Files
=========================== */

$files = array_diff(scandir($uploadDir), ['.','..']);
?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>File Manager | FileSphere</title>

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="filemanager.css">

<link rel="preconnect"
href="https://fonts.googleapis.com">

<link rel="preconnect"
href="https://fonts.gstatic.com"
crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Kumbh+Sans:wght@300;400;500;600;700&display=swap"
rel="stylesheet">

<script src="https://kit.fontawesome.com/db86999413.js"
crossorigin="anonymous"></script>

</head>

<body>

<!-- ===========================
NAVIGATION BAR
=========================== -->

<nav class="navbar">

<div class="navbar__container">

<a href="index.php" id="navbar__logo">

<i class="fa-solid fa-file"
style="color:#42b5f2;"></i>

FileSphere

</a>

<div class="navbar__toggle"
id="mobile-menu">

<span class="bar"></span>
<span class="bar"></span>
<span class="bar"></span>

</div>

<ul class="navbar__menu">

<li class="navbar__item">
<a href="index.php"
class="navbar__links">
ホーム
</a>
</li>

<li class="navbar__item">
<a href="cprofile.php"
class="navbar__links">
会社概要
</a>
</li>

<li class="navbar__item">
<a href="careers.php"
class="navbar__links">
システムの使い方
</a>
</li>
    
<li class="navbar__item">
<a href="filemanager.php"
class="navbar__links">
ファイル管理
</a>
</li>

<li class="navbar__item">
<a href="contact.php"
class="navbar__links">
お問い合わせ
</a>
</li>

<li class="navbar__item">

<span class="navbar__links"
style="color:#42b5f2;font-weight:bold;">

<i class="fa-solid fa-user"></i>

<?php echo htmlspecialchars($username); ?> さん

</span>

</li>

<li class="navbar__btn">

<a href="logout.php"
class="button"
style="background:#f44336;">

ログアウト

</a>

</li>

</ul>

</div>

</nav>

<!-- ===========================
MAIN LAYOUT
=========================== -->

<div class="drive-layout">

<!-- ===========================
SIDEBAR
=========================== -->

<aside class="sidebar">

<button class="upload-btn"
onclick="document.getElementById('fileInput').click();">

<i class="fa-solid fa-plus"></i>

New

</button>

<ul>

<li class="active">

<i class="fa-solid fa-folder"></i>

My Files

</li>

<li>

<i class="fa-solid fa-users"></i>

Shared

</li>

<li>

<i class="fa-solid fa-clock"></i>

Recent

</li>

<li>

<i class="fa-solid fa-box-archive"></i>

Archive

</li>

<li>

<i class="fa-solid fa-trash"></i>

Trash

</li>

</ul>

</aside>

<!-- ===========================
CONTENT
=========================== -->

<main class="content">

<!-- Toolbar -->

<div class="toolbar">

<div class="search">

<i class="fa-solid fa-magnifying-glass"></i>

<input
type="text"
id="searchInput"
placeholder="Search files...">

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

<!-- ===========================
UPLOAD FORM
=========================== -->

<form
    id="uploadForm"
    action="upload.php"
    method="POST"
    enctype="multipart/form-data">

    <input
        type="file"
        id="fileInput"
        name="uploaded_file[]"
        multiple
        hidden>
      

</form>

<!-- ===========================
DRAG & DROP
=========================== -->

<div
id="dropZone"
class="drop-zone">

<i class="fa-solid fa-cloud-arrow-up"></i>

<h2>Drag & Drop Files Here</h2>

<p>or click <strong>New</strong> to upload.</p>

</div>
    
<!-- ===========================
GRID VIEW
=========================== -->

<div id="gridContainer" class="grid-view active">

<?php

if(count($files) == 0){

    echo "<h3>No files uploaded.</h3>";

}else{

    foreach($files as $file){

        if($file == ".htaccess") continue;

        $filePath = $uploadDir . $file;

        $size = round(filesize($filePath)/1024,2) . " KB";

		$date = date("Y-m-d H:i", filemtime($filePath));

        /* File Extension */

        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        /* Default Icon */

        $icon = "fa-file";
        $iconClass = "";

        switch($extension){

            case "pdf":
                $icon = "fa-file-pdf";
                $iconClass = "fa-file-pdf";
                break;

            case "doc":
            case "docx":
                $icon = "fa-file-word";
                $iconClass = "fa-file-word";
                break;

            case "xls":
            case "xlsx":
            case "csv":
                $icon = "fa-file-excel";
                $iconClass = "fa-file-excel";
                break;

            case "png":
            case "jpg":
            case "jpeg":
            case "gif":
            case "webp":
                $icon = "fa-file-image";
                $iconClass = "fa-file-image";
                break;

            case "zip":
            case "rar":
            case "7z":
                $icon = "fa-file-zipper";
                $iconClass = "fa-file-zipper";
                break;

            case "ppt":
            case "pptx":
                $icon = "fa-file-powerpoint";
                break;

            case "mp4":
            case "avi":
            case "mov":
                $icon = "fa-file-video";
                break;

            case "mp3":
            case "wav":
                $icon = "fa-file-audio";
                break;

            case "php":
            case "html":
            case "css":
            case "js":
                $icon = "fa-file-code";
                break;

        }

?>

<div class="file-card"
     data-name="<?php echo strtolower($file); ?>">

<i class="fa-regular <?php echo $icon; ?> <?php echo $iconClass; ?>"></i>

<h3>

<?php echo htmlspecialchars($file); ?>

</h3>

<p>
<i class="fa-solid fa-calendar"></i>
<?php echo date("Y-m-d H:i", filemtime($filePath)); ?>
</p>

<p>

<i class="fa-solid fa-hard-drive"></i>

<?php echo $size; ?>

</p>

<div class="card-buttons">

<a
href="download.php?file=<?php echo urlencode($file); ?>"
class="btn-download">

<i class="fa-solid fa-download"></i>

Download

</a>

<a
href="delete.php?file=<?php echo urlencode($file); ?>"
class="btn-delete"
onclick="return confirm('Delete this file?');">

<i class="fa-solid fa-trash"></i>

Delete

</a>

</div>

</div>

<?php

    }

}

?>

</div>
    
<!-- ===========================
LIST VIEW
=========================== -->

<table class="file-table" id="listContainer">

<thead>

<tr>

<th>File Name</th>

<th>Size</th>

<th>Last Modified</th>

<th>Actions</th>

</tr>

</thead>

<tbody>

<?php

foreach($files as $file){

    if($file == ".htaccess") continue;

    $filePath = $uploadDir.$file;

    $size = round(filesize($filePath)/1024,2)." KB";

    $date = $metadata[$file]['date'] ??
            date("Y-m-d H:i", filemtime($filePath));

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

<?php echo $date; ?>

</td>

<td>

<a
href="download.php?file=<?php echo urlencode($file); ?>"
class="btn-download">

<i class="fa-solid fa-download"></i>

Download

</a>

<a
href="delete.php?file=<?php echo urlencode($file); ?>"
class="btn-delete"
onclick="return confirm('このファイルを削除しますか？?');">

<i class="fa-solid fa-trash"></i>

Delete

</a>

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</main>

</div>

<script src="app.js"></script>
<script src="filemanager.js"></script>

</body>

</html>