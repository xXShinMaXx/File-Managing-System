<?php

require_once "includes/config.php";

if(!isset($_SESSION['user_id'])){
    header("Location: auth/login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard | FileSphere</title>

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<link rel="stylesheet" href="assets/css/dashboard.css">
<link rel="stylesheet" href="assets/css/navbar.css">
<link rel="stylesheet" href="assets/css/sidebar.css">
<link rel="stylesheet" href="assets/css/cards.css">
<link rel="stylesheet" href="assets/css/profile-menu.css">

</head>

<body>

<?php include "includes/sidebar.php"; ?>

<div class="main">

<?php include "includes/navbar.php"; ?>
<?php include "includes/upload-modal.php"; ?>
<?php include "includes/content.php"; ?>

</div>

<script src="assets/js/dashboard.js"></script>
<script src="assets/js/folder.js"></script>
<script src="assets/js/profile.js"></script>
<script src="assets/js/upload.js"></script>
</body>

</html>