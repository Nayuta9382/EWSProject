<?php
if(empty($_POST["delete"])){
    // 送られたデータが存在しないため
    header("Location:../view/notification-top.php");
    exit();
}
// 削除するidを受け取る

$deleteList = $_POST["delete"];

// 指定したidのデータを削除する
require_once "../model/db_connect.php";
$sql = "DELETE FROM notification WHERE id = :id";
foreach ($deleteList as $key => $value) {
    $stm = $pdo->prepare($sql);
    $stm->bindValue(":id",$value,PDO::PARAM_INT);
    $stm->execute();
}

header("Location:../view/notification-top.php");
