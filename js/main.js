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