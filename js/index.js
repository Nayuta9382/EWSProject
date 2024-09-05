const left_button = document.getElementById("left_button");
const right_button = document.getElementById("right_button");

left_button.addEventListener("click",()=>{
    slide_right();
});
right_button.addEventListener("click",()=>{
    slide_left();
});

const carousel = document.getElementsByClassName("slide");
const slide_element = document.getElementsByClassName("slide_link");
const new_frist_element = slide_element[0].cloneNode(true);
const new_last_element = slide_element[2].cloneNode(true);
carousel[0].appendChild(new_frist_element);
carousel[0].prepend(new_last_element);
// スライドを常時動かす
let slide_interval =  setInterval(slide_left,4000);
function slide_left(){
    // ボタンのクリックを無効化する
    right_button.classList.add("pointer_off");
    // 常時実行しているスライドを一時停止
    clearInterval(slide_interval);
    for(let i = 0; i < slide_element.length; i++){
        slide_element[i].classList.add("slide_left");
    }
    setTimeout(()=>{
        const new_element = slide_element[2].cloneNode(true);
        carousel[0].appendChild(new_element);
        slide_element[0].remove();
        for(let i = 0; i < slide_element.length; i++){
            slide_element[i].classList.remove("slide_left");
        }
        // ボタンを有効化する
        right_button.classList.remove("pointer_off");
        // スライドを再開する
        slide_interval =  setInterval(slide_left,4000);
    },1000);
}
function slide_right(){
   // ボタンのクリックを無効化する
    left_button.classList.add("pointer_off");
    // 常時実行しているスライドを一時停止
    clearInterval(slide_interval);
    for(let i = 0; i < slide_element.length; i++){
        slide_element[i].classList.add("slide_right");
    }
    setTimeout(()=>{
        const new_element = slide_element[2].cloneNode(true);
        carousel[0].prepend(new_element);
        slide_element[slide_element.length-1].remove();
        for(let i = 0; i < slide_element.length; i++){
            slide_element[i].classList.remove("slide_right");
        }
          // ボタンのクリックを有効化する
    left_button.classList.remove("pointer_off");
     // スライドを再開する
     slide_interval =  setInterval(slide_left,4000);
    },1000);
}