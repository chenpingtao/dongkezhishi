window.onload=function(){
    var oBox=document.getElementsByClassName('box')[0];
    var oLeftsidebar=document.getElementsByClassName('leftsidebar')[0];
    var oInput = document.getElementsByClassName('input');
    var oInput1 = document.getElementsByClassName('input1');
    var oBtn1 = document.getElementById('btn1');
    var oBtn2 = document.getElementById('btn2');
    var oBtn3 = document.getElementById('btn3');
    var oBtn4 = document.getElementById('btn4');

oBtn1.onclick=function(){
    oInput[0].style.display = "block";
    oInput1[0].style.display = "none";
}
oBtn2.onclick =function(){
    oInput1[0].style.display = "block";
    oInput[0].style.display = "none";
}
oBtn3.onclick = function all() {

    if (oUser[0].value.length == 0 || oPass[0].value.length == 0 || oEmail[0].value.length == 0 || oBrithday[0].value.length == 0) {
        check(2, "请填写完整的信息！");
        return;
    } else {
        check(2, "");
    }
}

oBtn4.onclick = function reall() {
    if (oUser[1].value.length == 0 || oPass[1].value.length == 0) {
        check(4, "请填写完整的信息！");
        return;
    } else {
        check(4, "");
    }
}
};

var oBox=document.getElementsByClassName('box')[0];
var oUser = document.getElementsByClassName('user');
var oPass = document.getElementsByClassName('pass');
var oEmail = document.getElementsByClassName('email');
var oError = document.getElementsByClassName('error');

function check(n, str) {
    oError[n].innerHTML = str;
}

//用户名验证
function checkuser() {
    var checkuser = /^[a-zA-Z0-9_-]{4,16}$/;
    if(!checkuser.test(oUser[0].value)){
        check(0,'用户名必须为为4-16位！');
        return false;
    }
    else{
        check(0,'');
    }
    }

//邮箱验证
function test() {
    var myreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
    if (!myreg.test(oEmail[0].value)) {
        check(2, "邮箱格式错误！");
        return false;
    }
}

function checkpass() {
    if (oPass[0].value.length == 0) {
        check(1, "请输入密码！");
        return;
    } else {
        check(1, "");
    }
}

function checkemail() {
    if (oEmail[0].value.length == 0) {
        check(2, "请输入邮箱！");
        return;
    } else if (test() == false) {
        test()
    } else {
        check(2, "");
    }
}


function reuser() {
    if (oUser[1].value.length == 0) {
        check(3, "请输入用户名！");
        return;
    } else {
        check(3, "");
    }

    if (oUser[1].value.length >= 8) {
        check(3, "用户名不能超过8位！");
        return;
    } else {
        check(3, "");
    }
}

function repass() {
    if (oPass[1].value.length == 0) {
        check(4, "请输入密码！");
        return;
    } else {
        check(4, "");
    }
}
