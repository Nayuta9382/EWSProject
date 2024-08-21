"use strict";
// ハンバーガーボタン

let submitted = false;

document.addEventListener('DOMContentLoaded', function() {
    const menuButton = document.getElementById('menu-btn');
    const navMenu = document.getElementById('nav-menu');

    menuButton.addEventListener('click', function() {
        navMenu.classList.toggle('open');
        this.classList.toggle('active');
    });
});