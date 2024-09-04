<?php
session_start();
// エスケープ処理の関数
function escape($str){
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

$errorFlgList = [
    "category" => false,
    "postDate" => false,
    "title" => false,
    "content" => false,
    "link" => false
];

// エラーがある場合は受け取る
if (isset($_SESSION["addtionError"])) {
    $errorFlgList["category"] = $_SESSION["addtionError"]["category"];
    $errorFlgList["postDate"] = $_SESSION["addtionError"]["postDate"];
    $errorFlgList["title"] = $_SESSION["addtionError"]["title"];
    $errorFlgList["content"] = $_SESSION["addtionError"]["content"];
}

// 値の初期値を格納する
$categoryList = ["all" => "", "hotel" => "", "restaurant" => "", "morinokuni" => "", "else" => ""];
if (isset($_SESSION["category"])) {
    $categoryList[$_SESSION["category"]] = "selected";
} else {
    $categoryList["all"] = "selected";
}
//　日付
date_default_timezone_set('Asia/Tokyo');
$postDate = isset($_SESSION["postDate"]) ? $_SESSION["postDate"] : str_replace("/","-",date("Y/m/d"));

$title = isset($_SESSION["title"]) ? $_SESSION["title"] : "";
$content = isset($_SESSION["content"]) ? $_SESSION["content"] : "";
$link = isset($_SESSION["link"]) ? $_SESSION["link"] : "";



// データベースからデータを取得する処理
require_once "../model/db_connect.php";
$sql = "SELECT * FROM notification ORDER BY postDate DESC";
$stm = $pdo->prepare($sql);
$stm->execute();
$data = $stm->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/all-style.css">
    <title>top</title>
</head>

<body>
    <main>
        <!-- 編集のフォーム -->
        <form action="../model/delete.php" method="post">
            <table border="1">
                <tr>
                    <th>タイトル</th>
                    <th>投稿日</th>
                    <th>編集</th>
                    <th>削除</th>
                </tr>
                <?php foreach ($data as $key => $value) : ?>
                    <tr>
                        <td><?php echo  escape($value["title"]); ?></td>
                        <td><?php echo escape($value["postDate"]); ?></td>
                        <td><a href="./notification-edit.php?id=<?php echo escape($value["id"]); ?>">編集</a></td>
                        <td><input type="checkbox" name="delete[]" value="<?php echo escape($value["id"]);?>"></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <input type="submit" value="削除">
        </form>

        <!-- 新規追加のフォーム -->
        <form action="../model/addition.php" method="post">
            <div class="input-container">
                <label>
                    <h2>カテゴリー</h2>
                    <?php if ($errorFlgList["category"]) echo "<p class='error'>カテゴリーがただしくありません</p>"; ?>
                    <select name="category">
                        <option value="all" <?php echo  escape($categoryList["all"]) ?>>全般</option>
                        <option value="hotel" <?php echo  escape($categoryList["hotel"]) ?>>ホテルベルンドルフ</option>
                        <option value="restaurant" <?php echo  escape($categoryList["restaurant"]) ?>>レストランベルンドルフ</option>
                        <option value="morinokuni" <?php echo  escape($categoryList["morinokuni"]) ?>>ガラス体験工房　森のくに</option>
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

            <input type="submit">
        </form>
    </main>
</body>
<style>
    form+form {
        margin-top: 20px;
        border-top: 1px solid black;
    }

    .error {
        color: red;
    }
</style>

</html>