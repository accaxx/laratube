'use strict';

function displayChange(){
    let display_class = document.getElementsByClassName("display");
    let display_button = document.getElementById("btn_display");
    if (display_button.value === "表示項目を編集") {
        display_button.value = "表示項目を閉じる";
        for (let i = 0; i < display_class.length; i++) {
        display_class[i].style.display = "block";
        };
    } else {
        display_button.value = "表示項目を編集";
        for (let i = 0; i < display_class.length; i++) {
        display_class[i].style.display = "none";
        };
    };
}