<?php 
    session_start();

    $jumpFrom = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "";
    if(strpos($jumpFrom, 'contact.php') !== false) {
        $_SESSION['check'] = false;
    }

    $formError = false;
    $_SESSION['errors'] = [];

    if(!$_SESSION['check']) {
        // ---------- 種別チェック ----------
        $genreValues = ['レストラン', 'ホテル', '森のくに', 'おすすめプラン', 'その他'];
        if(isset($_POST['genre']) && in_array($_POST['genre'], $genreValues, true)) {
            $_SESSION['genre'] = $_POST['genre'];
        } else {
            $_SESSION['errors']['genre'] = "お問い合わせ種別の値が不正です";
            $formError = true;
        }

        // ---------- 予約日(チェックイン)チェック ----------
        if(!empty($_POST['date'])) {
            $currentDate = date('Y-m-d');
            if($_SESSION['genre'] !== 'その他') {
                if($_POST['date'] <= $currentDate) {
                    $_SESSION['errors']['date'] = "今日より過去の日付は選択できません";
                    $formError = true;
                } else {
                    $_SESSION['date'] = $_POST['date'];
                }
            } else {
                $_SESSION['date'] = '0001-01-01';
            }
        } else {
            $_SESSION['errors']['date'] = "日付が選択されていません";
            $formError = true;
        }

        // ---------- チェックアウトチェック ----------
        if(!empty($_POST['date2'])) {
            if($_SESSION['genre'] === 'ホテル') {
                if($_POST['date2'] <= $_SESSION['date']) {
                    $_SESSION['errors']['date2'] = "チェックインより過去の日付は選択できません";
                    $formError = true;
                } else {
                    $_SESSION['date2'] = $_POST['date2'];
                }
            } else {
                $_SESSION['date2'] = '0001-01-01';
            }
        } else {
            $_SESSION['errors']['date2'] = "日付が選択されていません";
            $formError = true;
        }

        // ---------- 人数チェック ----------
        if(!empty($_POST['headcount'])) {
            if($_SESSION['genre'] !== 'その他') {
                $headcount = (int)$_POST['headcount'];
                if ($headcount > 0 && $headcount <= 100) {
                    $_SESSION['headcount'] = $headcount;
                } else {
                    $_SESSION['errors']['headcount'] = "人数の値が不正です";
                    $formError = true;
                }
            } else {
                $_SESSION['headcount'] = '';
            }
        } else {
            $_SESSION['errors']['headcount'] = "人数が選択されていません";
            $formError = true;
        }

        // ---------- 名前チェック ----------
        if(!empty($_POST['name'])) {
            $_SESSION['name'] = $_POST['name'];
        } else {
            $_SESSION['errors']['name'] = "名前が空です";
            $formError = true;
        }

        // ---------- ふりがなチェック ----------
        if(!empty($_POST['furigana'])) {
            $_SESSION['furigana'] = $_POST['furigana'];
        } else {
            $_SESSION['furigana'] = "";
        }

        // ---------- メールアドレスチェック ----------
        if(!empty($_POST['email'])) {
            $_SESSION['email'] = $_POST['email'];
        } else {
            $_SESSION['errors']['email'] = "メールアドレスが空です";
            $formError = true;
        }
        
        // ---------- 電話番号チェック ----------
        if(!empty($_POST['tel'])) {
            if(telFormat($_POST['tel'])) {
                $_SESSION['tel'] = $_POST['tel'];
            } else {
                $_SESSION['errors']['tel'] = "電話番号の値が不正です";
                $formError = true;
            }
        } else {
            $_SESSION['tel'] = "";
        }

        // ---------- 問い合わせ内容チェック ----------
        if(!empty($_POST['message'])) {
            $_SESSION['message'] = $_POST['message'];
        } else {
            $_SESSION['errors']['message'] = "お問い合わせ内容が空です";
            $formError = true;
        }
    } else {
        header('Location: contact.php');
    }

    // ----------------------------------------
    if($formError) { // どこかの値にエラーがあった場合indexに戻る
        header('Location: contact.php');
    } else {
        $_SESSION['check'] = true;
    }
    // ----------------------------------------
    $genreCheck[$_SESSION['genre']] = "selected";

    function telFormat($tel) {
        if(!preg_match('/^(0{1}\d{1,4}-{0,1}\d{1,4}-{0,1}\d{4})$/', $tel)){
            return false;
        }
        return true;
    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>送信中…</title>
    <link rel="stylesheet" href="./css/all-style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zen+Maru+Gothic&display=swap" rel="stylesheet">
</head>
<body style="padding-top: 0;">
    <h1>送信中…</h1>

    <form 
    action="https://docs.google.com/forms/u/0/d/e/1FAIpQLScrxsS8RWTPnVuqRV9AlN0uNpf2H_ky4yfbiNFXwTX0VmM1OQ/formResponse"
    method="POST"
    target="_blank"
    id="formToGF">
        <!-- お問い合わせ種別 -->
        <select name="entry.987577699" class="hidden-form">
            <option value="レストランベルンドルフについて" <?php echo $genreCheck['レストラン'] ?>></option>
            <option value="ホテルベルンドルフについて" <?php echo $genreCheck['ホテル'] ?>></option>
            <option value="ガラス体験工房 森のくにについて" <?php echo $genreCheck['森のくに'] ?>></option>
            <option value="おすすめプランの申し込み" <?php echo $genreCheck['おすすめプラン'] ?>></option>
            <option value="その他のお問い合わせ" <?php echo $genreCheck['その他'] ?>></option>
        </select>

        <!-- 予約日(チェックイン) -->
        <input type="date" name="entry.1160554725" value="<?php echo $_SESSION['date'] ?>" class="hidden-form">

        <!-- チェックアウト -->
        <input type="date" name="entry.1953586701" value="<?php echo $_SESSION['date2'] ?>" class="hidden-form">

        <!-- 人数 -->
        <input type="number" name="entry.1523496348" value="<?php echo $_SESSION['headcount'] ?>" class="hidden-form">

        <!-- お名前 -->
        <input type="text" name="entry.1744964176" value="<?php echo $_SESSION['name'] ?>" class="hidden-form">

        <!-- ふりがな -->
        <input type="text" name="entry.1102074063" value="<?php echo $_SESSION['furigana'] ?>" class="hidden-form">

        <!-- メールアドレス -->
        <input type="email" name="entry.140642569" value="<?php echo $_SESSION['email'] ?>" class="hidden-form">

        <!-- 電話番号 -->
        <input type="tel" name="entry.1134501165" value="<?php echo $_SESSION['tel'] ?>" class="hidden-form">

        <!-- お問い合わせ内容 -->
        <textarea name="entry.1956422393" class="hidden-form"><?php echo $_SESSION['message'] ?></textarea>
    </form>

    <script type="text/javascript">
        formToGF.submit();
        window.location.href = 'contact.php?submitted=true';
    </script>
</body>
</html>