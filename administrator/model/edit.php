<?php
// 新規追加
session_start();

// 更新の場合のみ実行
if($_POST["submit"] == "save"){

    // 各エラーを格納する配列
    $errors = [
        "category" => false,
        "postDate" => false,
        "title" => false,
        "content" => false,
        "link" => false
    ];
    $errorFlg = false;

    // カテゴリーの処理
    // カテゴリーのvalueを格納する配列
    $categoryList = ["all", "hotel", "restaurant", "morinokuni", "else"];
    if (isset($_POST["category"])) {
        $category = $_POST["category"];
        // 送られたvalueが存在するかどうか
        if (in_array($category, $categoryList)) {
            $_SESSION["category"] = $category;
        } else {
            $errorFlg = true;
            $errors["category"] = true;
        }
    } else {
        $errorFlg = true;
        $errors["category"] = true;
    }

    // 投稿日の処理
    if (isset($_POST["postDate"])) {
        $postDate = $_POST["postDate"];
        // データの形式が正しいかを判定
        if (preg_match("/^\d{4}-\d{2}-\d{2}$/u", $postDate)) {
            $_SESSION["postDate"] = $postDate;
        } else {
            $errorFlg = true;
            $errors["postDate"] = true;
        }
    } else {
        $errorFlg = true;
        $errors["postDate"] = true;
    }

    // タイトルの処理
    if (isset($_POST["title"]) && $_POST["title"] !== "") {
        $_SESSION["title"] = $_POST["title"];
    } else {
        $errorFlg = true;
        $errors["title"] = true;
    }

    // 本文の処理
    if (isset($_POST["content"]) && $_POST["content"] !== "") {
        $_SESSION["content"] = $_POST["content"];
    } else {
        $errorFlg = true;
        $errors["content"] = true;
    }

    // リンクの処理
    if (isset($_POST["link"]) && $_POST["link"] !== "") {
        $_SESSION["link"] = $_POST["link"];
    } else {
        $_SESSION["link"] = "";
    }

    // エラーがないかどうか
    if ($errorFlg) {
        // 入力ページへリダイレクト
        $_SESSION["addtionError"] = $errors;
        header("Location:../view/notification-edit.php");
        exit();
    }
    require_once "./db_connect.php";

    // データベースへの更新処理
    $sql = 'UPDATE notification SET category = :category, postDate = :postDate, title = :title, content = :content , link = :link WHERE id = :id';

    $stm = $pdo->prepare($sql);

    $stm->bindValue(":category", $_SESSION["category"], PDO::PARAM_STR);
    $stm->bindValue(":postDate", $_SESSION["postDate"], PDO::PARAM_STR);
    $stm->bindValue(":title", $_SESSION["title"], PDO::PARAM_STR);
    $stm->bindValue(":content", $_SESSION["content"], PDO::PARAM_STR);
    $stm->bindValue(":link", $_SESSION["link"], PDO::PARAM_STR);
    $stm->bindValue(":id", $_SESSION["id"], PDO::PARAM_INT);

    $stm->execute();
}
// セッションの中を殻にする

unset($_SESSION["addtionError"]);
unset($_SESSION["category"]);
unset($_SESSION["postDate"]);
unset($_SESSION["title"]);
unset($_SESSION["content"]);
unset($_SESSION["link"]);
unset($_SESSION["id"]);
header("Location:../view/notification-top.php");
