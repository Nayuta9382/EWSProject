// お知らせ
const tag = document.getElementById("tag_list");
const tag_button = tag.querySelectorAll("button");
const plan_info = document.getElementsByClassName("plan_info");
tag_button.forEach((button) => {
    button.addEventListener("click",tag_filter);
});
function tag_filter(event){ 
    if(event.target.classList.contains('narrow_down') == true){
            // 消す処理
            event.target.classList.remove("narrow_down");
            const on_plan = tag.querySelectorAll(".narrow_down");
            let on_plan_id = [];
            for(let i = 0; i < on_plan.length; i++){
                on_plan_id.push(on_plan[i].id);
            }
            for(let i = 0; i < plan_info.length; i++){
                let hidden_flg = false; 
                const plan_tags = plan_info[i].querySelector(".tag").querySelectorAll("button");
                for(let j = 0; j < plan_tags.length; j++){
                    if(on_plan_id.includes(plan_tags[j].className)){
                        hidden_flg = true;
                        break;
                    }
                }
                if(!hidden_flg){
                    plan_info[i].setAttribute("hidden","");
                }
            }
               
        }else{
            // 表示する処理
            event.target.classList.add("narrow_down");
            for(let i = 0; i < plan_info.length; i++){
                plan =  plan_info[i].querySelectorAll("." + event.target.id);
                if(plan.length !== 0 ){
                    plan_info[i].removeAttribute("hidden");
                }
            }
        }
}
