<?php 
    session_start();

    if(isset($_GET['submitted']) && $_GET['submitted'] === 'true') {
        $_SESSION = [];
        if(isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 1800);
        }
        session_destroy();
        
        header('Location: contact.php');
    };
    
    $errors = [
        'genre' => '',
        'date' => '',
        'date2' => '',
        'headcount' => '',
        'name' => '',
        'furigana' => '',
        'email' => '',
        'tel' => '',
        'message' => ''
    ];

    if(isset($_SESSION['errors'])) {
        $errors['genre'] = isset($_SESSION['errors']['genre']) ? $_SESSION['errors']['genre'] : "";
        $errors['date'] = isset($_SESSION['errors']['date']) ? $_SESSION['errors']['date'] : "";
        $errors['date2'] = isset($_SESSION['errors']['date2']) ? $_SESSION['errors']['date2'] : "";
        $errors['headcount'] = isset($_SESSION['errors']['headcount']) ? $_SESSION['errors']['headcount'] : "";
        $errors['name'] = isset($_SESSION['errors']['name']) ? $_SESSION['errors']['name'] : "";
        $errors['furigana'] = isset($_SESSION['errors']['furigana']) ? $_SESSION['errors']['furigana'] : "";
        $errors['email'] = isset($_SESSION['errors']['email']) ? $_SESSION['errors']['email'] : "";
        $errors['tel'] = isset($_SESSION['errors']['tel']) ? $_SESSION['errors']['tel'] : "";
        $errors['message'] = isset($_SESSION['errors']['message']) ? $_SESSION['errors']['message'] : "";
    }

    $genre = isset($_SESSION['genre']) ? $_SESSION['genre'] : "レストラン";
    $genreCheck = [
        "レストラン" => "",
        "ホテル" => "",
        "森のくに" => "",
        "おすすめプラン" => "",
        "その他" => ""
    ];
    $genreCheck[$genre] = "selected";
    
    $date = isset($_SESSION['date']) ? $_SESSION['date'] : "";
    $date2 = isset($_SESSION['date2']) ? $_SESSION['date2'] : "";
    $headcount = isset($_SESSION['headcount']) ? $_SESSION['headcount'] : "";
    $name = isset($_SESSION['name']) ? $_SESSION['name'] : "";
    $furigana = isset($_SESSION['furigana']) ? $_SESSION['furigana'] : "";
    $email = isset($_SESSION['email']) ? $_SESSION['email'] : "";
    $tel = isset($_SESSION['tel']) ? $_SESSION['tel'] : "";
    $message = isset($_SESSION['message']) ? $_SESSION['message'] : "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お問い合わせ | 株式会社エーデルワイン・サポート</title>
    <link rel="stylesheet" href="./css/all-style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zen+Maru+Gothic&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <a class="company-logo" href="index.html">
            <img src="./img/logo.png" alt="ロゴ">
        </a>
        <div id="menu-btn">
            <span></span>
        </div>
    </header>

    <nav id="nav-menu">
        <ul>
            <li><a href="index.html">トップページ</a></li>
            <li><a href="restaurant.html">レストランベルンドルフ</a></li>
            <li><a href="hotel.html">ホテルベルンドルフ</a></li>
            <li><a href="mori-no-kuni.html">ガラス体験工房　森のくに</a></li>
            <li><a href="recommended-package.html">おすすめプラン</a></li>
            <li><a href="about-us.html">会社概要・アクセス</a></li>
            <li><a href="#">お問い合わせ</a></li>
        </ul>
    </nav>

    <nav id="breadcrumbs">
        <ul>
            <li><a href="index.html">ホーム</a></li>
            <li><span>お問い合わせ</span></li>
        </ul>
    </nav>

    <div class="top_heading">
        <img src="./img/glassmorikuni-icon.jpg" alt="">
        <h1>お問い合わせ</h1>
        <p>Contact</p>
    </div>
    
    <main>
        <div class="container">
            <p class="text">
                各施設のご利用や、イベント、プランのご相談等、お気軽にご相談下さい。
            </p>
            <p class="text">
                また、繁忙期等すぐに返信できない場合がございますので、お急ぎのかたはお電話にてお問い合わせお願いいたします。
            </p>
        </div>

        <div class="container">
            <form action="check.php" method="post" id="formToCheck">
                <div class="input-container">
                    <label>
                        <p class="input-item-name">お問い合わせ種別
                            <span>必須</span>
                        </p>
                        <p class="error-message"><?php echo $errors['genre'] ?></p>
                        <select name="genre" id="contact-genre" required>
                            <option value="レストラン" <?php echo $genreCheck['レストラン'] ?>>レストランベルンドルフ について</option>
                            <option value="ホテル" <?php echo $genreCheck['ホテル'] ?>>ホテルベルンドルフ について</option>
                            <option value="森のくに" <?php echo $genreCheck['森のくに'] ?>>ガラス体験工房　森のくに について</option>
                            <option value="おすすめプラン" <?php echo $genreCheck['おすすめプラン'] ?>>おすすめプランの申し込み</option>
                            <option value="その他" <?php echo $genreCheck['その他'] ?>>その他のお問い合わせ</option>
                        </select>
                    </label>
                </div>
            
                <div id="contact-detail">
                    <div class="input-container">
                        <label>
                            <p class="input-item-name" id="contact-date-p">予約日
                                <span>必須</span>
                            </p>
                            <p class="error-message"><?php echo $errors['date'] ?></p>
                            <input type="date" name="date" id="contact-date" required>
                        </label>
                    </div>

                    <div class="input-container" id="contact-checkout">
                        <label>
                            <p class="input-item-name">チェックアウト
                                <span>必須</span>
                            </p>
                            <p class="error-message"><?php echo $errors['date2'] ?></p>
                            <input type="date" name="date2" id="contact-checkout-date">
                        </label>
                    </div>

                    <div class="input-container">
                        <label>
                            <p class="input-item-name">人数
                                <span>必須</span>
                            </p>
                            <p class="error-message"><?php echo $errors['headcount'] ?></p>
                            <input type="number" name="headcount" value="1" step="1" min="1" required>
                        </label>
                    </div>
                </div>

                <div class="input-container">
                    <label>
                        <p class="input-item-name">お名前
                            <span>必須</span>
                        </p>
                        <p class="error-message"><?php echo $errors['name'] ?></p>
                        <input type="text" name="name" value="<?php echo $name ?>" placeholder="例 : 大迫 太郎" required>
                    </label>
                </div>

                <div class="input-container">
                    <label>
                        <p class="input-item-name">ふりがな</p>
                        <p class="error-message"><?php echo $errors['furigana'] ?></p>
                        <input type="text" name="furigana" value="<?php echo $furigana ?>" placeholder="例 : おおはさま たろう">
                    </label>
                </div>

                <div class="input-container">
                    <label>
                        <p class="input-item-name">メールアドレス
                            <span>必須</span>
                        </p>
                        <p class="error-message"><?php echo $errors['email'] ?></p>
                        <input type="email" name="email" value="<?php echo $email ?>" placeholder="例 : sample@edelwein.co.jp" required>
                    </label>
                </div>

                <div class="input-container">
                    <label>
                        <p class="input-item-name">電話番号
                        </p>
                        <p class="error-message"><?php echo $errors['tel'] ?></p>
                        <input type="tel" name="tel" value="<?php echo $tel ?>" placeholder="例 : 090-1234-5678">
                    </label>
                </div>

                <div class="input-container">
                    <label>
                        <p class="input-item-name">お問い合わせ内容
                            <span>必須</span>
                        </p>
                        <p class="error-message"><?php echo $errors['message'] ?></p>
                        <textarea name="message" placeholder="お問い合わせの内容をご入力ください" required><?php echo $message ?></textarea>
                    </label>
                </div>
            
                <div class="input-container">
                    <input type="submit" class="submit-btn">
                </div>
            </form>
        </div>
    </main>

    <footer>
        <div id="footer-container">
        <div id="site-map-container">
          <ul id="site-map">
            <li class="site-map-content">
              <a href="./index.html">トップページ</a>
            </li>
            <li class="site-map-content">
              <a href="./restaurant.html">レストランベルンドルフ</a>
            </li>
            <li class="site-map-content">
              <a href="./hotel.html">ホテルベルンドルフ</a>
            </li>
            <li class="site-map-indent">
              <a href="./hotel-room.html">部屋紹介・料金</a>
            </li>
            <li class="site-map-indent">
              <a href="./hotel-facilities.html">館内紹介</a>
            </li>
            <li class="site-map-content">
              <a href="./mori-no-kuni.html">ガラス体験工房　森のくに</a>
            </li>
            <li class="site-map-indent">
              <a href="./mori-no-kuni.html#blown-glass">吹きガラス</a>
            </li>
            <li class="site-map-indent">
              <a href="./mori-no-kuni.html#sandblast">サンドブラスト</a>
            </li>
            <li class="site-map-indent">
              <a href="./mori-no-kuni.html#glass-beads">トンボ玉</a>
            </li>
            <li class="site-map-indent">
              <a href="./mori-no-kuni.html#fusing">フュージング</a>
            </li>
            <li class="site-map-indent">
                <a href="#">食体験イベント</a>
            </li>
            <li class="site-map-content">
              <a href="./recommended-package.html">おすすめプラン</a>
            </li>
            <li class="site-map-content">
              <a href="./about-us.html">会社概要・アクセス</a>
            </li>
            <li class="site-map-content">
              <a href="#">お問い合わせ</a>
            </li>
          </ul>
        </div>

            
            <div id="company-info">
                <div class="company-logo">
                    <img src="./img/logo.png" alt="ロゴ">
                </div>
                <p>〒028-3203<br>岩手県花巻市大迫町大迫10-16-1</p>
                <p>TEL : 0198-48-2155　FAX : 0198-48-4082</p>
                <p class="copy-right">©edelwein support. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script src="./js/contact.js"></script>
    <script src="./js/main.js"></script>
</body>
</html>