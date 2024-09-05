"use strict";

// ハンバーガーボタン
document.addEventListener('DOMContentLoaded', function() {
    const menuButton = document.getElementById('menu-btn');
    const navMenu = document.getElementById('nav-menu');
    if(!menuButton || !navMenu) {
        return false;
    }
    menuButton.addEventListener('click', function() {
        navMenu.classList.toggle('open');
        this.classList.toggle('active');
    });
});

   // 画像がクリックされたら拡大表示する処理
   const upImg = document.getElementsByClassName("up_img");
   for(let i = 0; i < upImg.length; i++){
     upImg[i].addEventListener("click",(e)=>{
       const img = e.target;
       // 拡大用のdivタグを生成
       const div = document.createElement("div");
       // クラスを付与
       div.classList.add("img_up_div");
       // imgタグをコピーする
       const copyImg = img.cloneNode(true)
       // クラスを付与
       copyImg.classList.add("img_up_img");
       // div タグにimgを追加
       div.appendChild(copyImg);
       // bodyを取得
       const body = document.querySelector("body");
       // bodyの末尾に追加
       body.appendChild(div);
       // 他の要素のユーザーイベントを無効化
       body.classList.add("event_no");

       // ☓ボタンを生成し、表示する
       const close = document.createElement("button");
       close.setAttribute("type","button");
       // クラスを付与
       close.classList.add("close_button");
       // imgタグを生成
       const closeImg = document.createElement("img");
       // パスを指定
       closeImg.src="./img/close.png";
       // ボタンに追加
       close.appendChild(closeImg);
       // idを付与
       close.setAttribute("id","close")
       // divに追加
       div.appendChild(close);
       
       // ☓が押されたら閉じる処理
       close.addEventListener("click",()=>{
         // bodyの制御をなくす
         body.classList.remove("event_no");
         // div要素を削除
         div.remove();
       });
     });
   }