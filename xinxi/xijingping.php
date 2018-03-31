<?php
require "phpQuery/phpQuery.php";
    //连接数据库
    global $link;
$link = mysqli_connect('localhost','root','','renmian');
    $sql = "use tjrenmian";
    mysqli_query($link,$sql);
    mysqli_query($link,"set names utf8");

$url = "http://district.ce.cn/zt/rwk/sf/tj/index.shtml";

foreach (range(0,22) as $v){
    if($v==0){
        $url_page = "http://district.ce.cn/zt/rwk/sf/tj/index.shtml";
        $url = sprintf($url_page);
        }
        else{   
            $url_page = "http://district.ce.cn/zt/rwk/sf/tj/index_%d.shtml";
            $url = sprintf($url_page,$v);
        }
    get_page_info($url);
    sleep(1); //停止执行1秒，防止速度过快导致对方网站服务器崩溃
}


function get_page_info($url){
    $link = mysqli_connect('localhost','root','','renmian');
    $sql = "use bjrenmian";
    mysqli_query($link,$sql);
    mysqli_query($link,"set names utf8");


$context=file_get_contents($url);

$document=phpQuery::newDocumentHTML($context);

$doc=phpQuery::pq("");
$text_boxs   = $doc->find("body > div.main > div.right > div.list > ul > li");
// print_r($variable);die;
    foreach ($text_boxs as $text_box) {
        $url_new0=pq($text_box)->find(" a")->attr('href');
        $url_new01= str_replace("../../../..","",$url_new0);
        $url_new="http://district.ce.cn".$url_new01;
        $context1=file_get_contents($url_new);
        $document1=phpQuery::newDocumentHTML($context1);
        $doc1=phpQuery::pq("");
        $text_box1   = $doc1->find("#article");
        // print_r($text_box1);die;
                foreach ($text_box1 as $text_box3) {
    
                    $title      = pq($text_box3)->find("h1")->text();
                    $content    = pq($text_box3)->find("#articleText > div.TRS_Editor p")->text();
                    $picture=pq($text_box3)->find("#articleText > div.TRS_Editor p img")->attr('src');
                    $time     =pq($text_box3)->find("#articleTime")->text();
                    $cag_ok   = pq($text_box3)->find("#articleSource")->text();
                    $cag = str_replace("来源：","",$cag_ok);
                    // sleep(1);       
                        
                    // print_r($title);echo "</br>";    
                    // print_r($picture);echo "</br>";
                    // print_r($cag);echo "</br>";
                    // print_r($time);echo "</br>";
                    // print_r($content);echo "</br>";echo "</br>";

                    
                  //将数据插入数据表中
        $sql = "insert into tjrenmian (title,content,time,cag,picture) value ('$title','$content','$time','$cag','$picture')";
        if (mysqli_multi_query($link, $sql)){
        echo "新记录插入成功";
        echo "</br>";
       } 
       else {
       echo "Error: " . $sql . "<br>" . mysqli_error($link);
           }
                
            }
        }
    }
      
        