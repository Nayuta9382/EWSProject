<?php
session_start();
// エスケープ処理の関数
function escape($str){
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// エラーを格納する配列
$errorFlgList = [
    "category" => false,
    "postDate" => false,
    "title" => false,
    "content" => false,
    "link" => false
];


// データを格納する変数

$categoryList = ["all" => "", "hotel" => "", "restaurant" => "", "morinokuni" => "", "else" => ""];
if (isset($_SESSION["category"]));

$postDate;
$title;
$content;
$link;

// データを各変数に代入する

// notification-top.phpからの遷移からedit.phpからの遷移かを判定 　edit.phpで作成するerrorのセッションがあるかどうかで判定
if (isset($_SESSION["addtionError"])) {
    // edit.phpでエラーがあった場合

    // エラーを受け取る
    $errorFlgList["category"] = $_SESSION["addtionError"]["category"];
    $errorFlgList["postDate"] = $_SESSION["addtionError"]["postDate"];
    $errorFlgList["title"] = $_SESSION["addtionError"]["title"];
    $errorFlgList["content"] = $_SESSION["addtionError"]["content"];

    // データを変数に格納
    if (isset($_SESSION["category"])) {
        $categoryList[$_SESSION["category"]] = "selected";
    } else {
        $categoryList["all"] = "selected";
    }
    $postDate = isset($_SESSION["postDate"]) ? $_SESSION["postDate"] : "";
    $title = isset($_SESSION["title"]) ? $_SESSION["title"] : "";
    $content = isset($_SESSION["content"]) ? $_SESSION["content"] : "";
    $link = isset($_SESSION["link"]) ? $_SESSION["link"] : "";


} else {
    // notification-top.phpからの遷移の場合
    // getパラメータを受け取る
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
    } else {
        header("Location:./notification-top.php");
        exit();
    }

    // データベースからデータを取得する
    require_once "../model/db_connect.php";
    $sql = "SELECT * FROM notification WHERE id = :id";
    $stm = $pdo->prepare($sql);
    $stm->bindValue(":id", $id, PDO::PARAM_STR);

    $stm->execute();
    $data = $stm->fetch(PDO::FETCH_ASSOC);

    // idが存在していない場合
    if (!$data) {
        header("Location:./notification-top.php");
    }

    // データを格納
    $categoryList[$data["category"]] = "selected";
    $postDate = $data["postDate"];
    $title = $data["title"];
    $content = $data["content"];
    $link = $data["link"];

    // idをセッションに登録
    $_SESSION["id"] = $id;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お知らせ更新編集ページ</title>
    <link rel="stylesheet" href="../../css/all-style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zen+Maru+Gothic&display=swap" rel="stylesheet">
</head>

<body id="notification-edit-page">
    <main>
        <!-- 新規追加のフォーム -->
        <form action="../model/edit.php" method="post">
            <div class="input-container">
                <label>
                    <h2>カテゴリー</h2>
                    <?php if ($errorFlgList["category"]) echo "<p class='error'>カテゴリーがただしくありません</p>"; ?>
                    <select name="category">
                        <option value="all" <?php echo  escape($categoryList["all"]) ?>>全般</option>
                        <option value="hotel" <?php echo  escape($categoryList["hotel"]) ?>>ホテルベルンドルフ</option>
                        <option value="restaurant" <?php echo  escape($categoryList["restaurant"]) ?>>レストランベルンドルフ</option>
                        <option value="morinokuni" <?php echo  escape($categoryList["morinokuni"])?>>ガラス体験工房　森のくに</option>
                        <option value="else" <?php echo  escape($categoryList["else"]) ?>>その他</option>
                    </select>
                </label>
            </div>

            <div class="input-container">
                <label>
                    <h2>投稿日</h2>
                    <?php if ($errorFlgList["postDate"]) echo "<p class='error'>投稿日がただしくありません</p>" ?>
                    <input type="date" name="postDate" value="<?php echo escape($postDate) ?>">
                </label>
            </div>

            <div class="input-container">
                <label>
                    <h2>タイトル</h2>
                    <?php if ($errorFlgList["title"]) echo "<p class='error'>タイトルがただしくありません</p>" ?>
                    <input type="text" name="title" value="<?php echo escape($title) ?>">
                </label>
            </div>

            <div class="input-container">
                <label>
                    <h2>本文</h2>
                    <?php if ($errorFlgList["content"]) echo "<p class='error'>本文がただしくありません</p>" ?>
                    <p>リンクを貼り付けたい場合は、文章内に「こちら」という単語を含めてください。(例:「詳しくはこちら！」)</p>
                    <textarea name="content"><?php echo escape($content) ?></textarea>
                </label>
            </div>

            <div class="input-container">
                <label>
                    <h2>Instagramの投稿　またはPDFのリンク</h2>
                    <input type="text" name="link" value="<?php echo escape($link) ?>">
                </label>
            </div>

            <div class="button-container">
                <button type="submit" name="submit" value="return">戻る</button>
                <button type="submit" name="submit" value="send">更新</button>
            </div>
        </form>
    </main>
</body>

</html>
