<?php

require_once "../includes/config.php";

if(!isset($_SESSION['user_id'])){
    exit("Unauthorized");
}

$name = trim($_POST['folder_name']);

if($name==""){
    exit("Invalid Folder Name");
}

$stmt = $pdo->prepare("
INSERT INTO folders
(user_id,parent_folder_id,folder_name)
VALUES(?,?,?)
");

$stmt->execute([
    $_SESSION['user_id'],
    null,
    $name
]);

echo "フォルダを作成しました。";