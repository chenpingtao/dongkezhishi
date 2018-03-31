window.onload=function(){
    var oLi=document.getElementById('li');
    var oContainer=document.getElementsByClassName('container')[0];

    oContainer.onmouseover=oLi.onmouseover=function(){
        startMove(250);
    };

    oContainer.onmouseout=oLi.onmouseout=function(){
        startMove(0);
    };

};
var timer=null;
function startMove(iTarget){
    var oContainer=document.getElementsByClassName('container')[0];
    clearInterval(timer);
    timer=setInterval(function(){
        var speed=0;
        if(oContainer.offsetLeft>iTarget){
            speed=-10;
        }
        else{
            speed=10;
        }
        if(oContainer.offsetLeft==iTarget){
            clearInterval(timer);
        }
        else{
            oContainer.style.left=oContainer.offsetLeft+speed+'px';
        }
    },20);
};