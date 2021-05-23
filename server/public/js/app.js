'use strict';

const DISPLAY_TEXT_CLOSE = '表示項目を閉じる';
const DISPLAY_TEXT_EDIT = '表示項目を編集';
let display_on = true;

function displayChange(){
    let display_class = document.getElementsByClassName("display");
    let display_button = document.getElementById("btn_display");
    if (display_on) {
        display_button.value = DISPLAY_TEXT_CLOSE;
        for (let i = 0; i < display_class.length; i++) {
        display_class[i].style.display = "block";
        };
        display_on = false;
    } else {
        display_button.value = DISPLAY_TEXT_EDIT;
        for (let i = 0; i < display_class.length; i++) {
        display_class[i].style.display = "none";
        };
        display_on = true;
    };
}