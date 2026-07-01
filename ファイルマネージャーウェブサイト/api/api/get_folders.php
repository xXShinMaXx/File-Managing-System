<?php

require_once "../includes/config.php";

$stmt = $pdo->prepare("
SELECT *
FROM folders
WHERE user_id=?
ORDER BY created_at DESC
");

$stmt->execute([
    $_SESSION['user_id']
]);

echo json_encode($stmt->fetchAll());