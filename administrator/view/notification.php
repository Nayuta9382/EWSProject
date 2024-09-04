<?php
session_start();

// getパラメータで表示するカテゴリーを受け取る
$categoryList = ["all", "hotel", "restaurant", "morinokuni", "else"];
require_once "../model/db_connect.php";
// データベースからお知らせを取得するし、  
// カテゴリーが存在するなら検索をかける
if(!empty($_GET['category']) && in_array($_GET["category"],$categoryList)){
    $sql = "SELECT * FROM notification WHERE category = :category ORDER BY postDate DESC";
    $stm = $pdo->prepare($sql);
    $stm->bindValue(":category",$_GET["category"],PDO::PARAM_STR);
}else{
    // 存在るる場合
    $sql = "SELECT * FROM notification ORDER BY postDate DESC";
    $stm = $pdo->prepare($sql);
}

$stm->execute();
$data = $stm->fetchAll(PDO::FETCH_ASSOC);


// エスケープ処理の関数
function escape($str){
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/notification-source-style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zen+Maru+Gothic&display=swap" rel="stylesheet">
</head>
<body>
    <?php foreach ($data as $key => $value):?>
        <div class="notification-container">
        <div class="notification-info">
            <div>
                <?php 
                // ハイフンで日付を区切る
                $date = explode("-",$value["postDate"]);
                ?>
                <span><?php echo escape($date[0])?>-</span><span><?php echo escape($date[1])?>-<?php echo escape($date[2])?></span>
            </div>
            <div class="notification-genre">
                <?php
                // カテゴーの値が格納された配列
                $categoryList = ["all" => "全般", "hotel" => "ホテル", "restaurant" => "レストラン", "morinokuni" => "森のくに", "else" => "その他"];
                 echo escape($categoryList[$value["category"]]);?>
            </div>
        </div>
        <div class="notification-content">
            <?php
            // こちらをリンクに置き換える機能
            $content = escape($value["content"]);
            $link = escape($value["link"]);
            
            // aタグを生成して表示
            $text = str_replace("こちら","<a href='".$link."' target='_blank' rel='noopener' >こちら</a>",$content);
            ?>
            <?php echo $text;?>
        </div>
    </div>
    <?php endforeach;?>
    
</body>
</html>