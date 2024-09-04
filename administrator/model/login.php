<?php
// ログインを管理するフラグ変数
$errorFlg = false;
session_start();

// formからデータを受け取る
if(isset($_POST["id"]) && $_POST["id"] !== ""){
    $id = $_POST["id"];
}else{
    $errorFlg = true;
}

if(isset($_POST["password"]) && $_POST["password"] !== ""){
    $password = $_POST["password"];
}else{
    $errorFlg = true;
}

// エラーならログインページへリダイレクト
if($errorFlg){
    $_SESSION["errorFlg"] = true;
    header("Location:../view/notification-login.php");
    exit();
}

// セッションを削除
unset($_SESSION["errorFlg"]);


// データベースからアカウント譲歩を取得する処理
require_once "../model/db_connect.php";
$sql = "SELECT password FROM user WHERE id = :id";
$stm = $pdo->prepare($sql);
$stm->bindValue(":id",$id,PDO::PARAM_INT);
$stm->execute();
$data = $stm->fetch(PDO::FETCH_ASSOC);

// idが存在しない又はパスワードが一致しない
if(!$data || empty($data) || ($data["password"] !== $password)){
    $_SESSION["errorFlg"] = true;
    header("Location:../view/notification-login.php");
    exit();
}

$_SESSION["id"] = $id;


// セッションを削除
unset($_SESSION["errorFlg"]);

// 編集ページへリダイレクト
header("Location:../view/notification-top.php");