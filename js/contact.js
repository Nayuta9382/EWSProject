document.addEventListener('DOMContentLoaded', function() {
    function formatDate(date) { // フォームの日付形式に合わせる
        let year = date.getFullYear();
        let month = String(date.getMonth() + 1).padStart(2, '0');
        let day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    function setDefaultDates() { // 予約日(チェックイン)を明日、チェックアウトを明後日に設定(デフォルト)
        let today = new Date();
        let tomorrow = new Date(today);
        tomorrow.setDate(today.getDate() + 1);
        let dayAfterTomorrow = new Date(tomorrow);
        dayAfterTomorrow.setDate(tomorrow.getDate() + 1);

        document.getElementById("contact-date").value = formatDate(tomorrow);
        document.getElementById("contact-checkout-date").value = formatDate(dayAfterTomorrow);
    }

    function updateDisplay() { // お問い合わせ種別によって項目名を変えたり、入力フォームの表示・非表示を切り替える
        let contactGenre = document.getElementById('contact-genre').value; // 選択されているお問い合わせ種別
        let contactDetail = document.getElementById('contact-detail'); // 予約日(チェックイン)、チェックアウト、人数の部分
        let contactDateLabel = document.getElementById('contact-date-p'); // 予約日(チェックイン)の項目名
        let contactCheckout = document.getElementById('contact-checkout'); // チェックアウトの部分のみ

        if (contactGenre === 'その他') {
            contactDetail.style.display = 'none'; // 日付や人数を選択させない
        } else if (contactGenre === 'ホテル') {
            contactDateLabel.innerHTML = 'チェックイン<span>必須</span>';
            contactDetail.style.display = 'block'; // 日付と人数を選択させる
            contactCheckout.style.display = 'block'; // チェックアウトを選択させる
        } else {
            contactDateLabel.innerHTML = '予約日<span>必須</span>';
            contactDetail.style.display = 'block'; // 日付と人数を選択させる
            contactCheckout.style.display = 'none'; // チェックアウトを選択させない
        }
    }

    function updateCheckoutDate() { // チェックインを選択したらチェックアウトをその翌日に設定
        let contactDate = document.getElementById('contact-date');
        let date = new Date(contactDate.value);
        let checkoutDate = new Date(date);
        checkoutDate.setDate(date.getDate() + 1);
        document.getElementById("contact-checkout-date").value = formatDate(checkoutDate);
    }

    // 画面を読み込んだ時
    setDefaultDates();
    updateDisplay();

    document.getElementById('contact-genre').addEventListener('change', updateDisplay); // お問い合わせ種別が変更された時
    document.getElementById('contact-date').addEventListener('change', updateCheckoutDate); // チェックインが変更された時
});