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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zen+Maru+Gothic&display=swap" rel="stylesheet">
</head>
<body id="notification-login-page">
    <div>
        <form action="../model/login.php" method="post">
            <table>
                <tr>
                    <td colspan="2">
                        <?php if($error):?>
                        <p class="error-message"> idとパスワードが一致しません</p>   
                        <?php endif;?>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="login-id">id:</label>
                    </th>
                    <td>
                        <input type="text" name="id" id="login-id">
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="login-password">password:</label>
                    </th>
                    <td>
                        <input type="password" name="password" id="login-password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" value="ログイン">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>