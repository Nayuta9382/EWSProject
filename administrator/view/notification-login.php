<?php
// エラーがあるかを受け取る
session_start();

$error = false;
if(isset($_SESSION["errorFlg"])){
    $error = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お知らせ更新ログインページ</title>
    <link rel="stylesheet" href="../../css/all-style.css">
</head>
<body>
    <form action="../model/login.php" method="post">
        <?php if($error):?>
        <p class="error"> idとパスワードが一致しません</p>   
        <?php endif;?>   
        <label>id:</label>
        <input type="text" name="id">
        <label>password:</label>
        <input type="password" name="   password">
        <input type="submit" value="送信">
    </form>
</body>
</html>