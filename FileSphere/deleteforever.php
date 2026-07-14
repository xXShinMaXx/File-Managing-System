<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: auth.html");
    exit();
}

include "database.php";

$username=$_SESSION['username'];

$id=intval($_GET['id']);

$stmt=mysqli_prepare(
$conn,
"SELECT filename
FROM files
WHERE id=?
AND owner=?
AND deleted=1"
);

mysqli_stmt_bind_param(
$stmt,
"is",
$id,
$username
);

mysqli_stmt_execute($stmt);

$result=mysqli_stmt_get_result($stmt);

if($row=mysqli_fetch_assoc($result)){

$file="uploads/".$row['filename'];

if(file_exists($file)){
unlink($file);
}

$stmt=mysqli_prepare(
$conn,
"DELETE FROM files
WHERE id=?"
);

mysqli_stmt_bind_param(
$stmt,
"i",
$id
);

mysqli_stmt_execute($stmt);

}

header("Location:trash.php");

?>