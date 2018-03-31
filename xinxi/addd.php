<?php
require "phpQuery/phpQuery.php";
    //连接数据库
$link = mysqli_connect('localhost','root','','renmian');
    $sql = "use difang";
    mysqli_query($link,$sql);
    mysqli_query($link,"set names utf8");
// $i=0;

    $str = file_get_contents("shengji.txt");
        $pattern ='/personPage.{5,6}htm/';       
        $a=preg_match_all($pattern,$str,$cag_a);
        foreach ($cag_a as $value) {
            foreach ($value as $value1) {
                $value_ok="http://ldzl.people.com.cn/dfzlk/front/".$value1;
                // print_r($value_ok);
                $context    = file_get_contents($value_ok);
                $document   = phpQuery::newDocumentHTML($context);
                $doc        = phpQuery::pq("");
                // $text_box   = $doc->find("div.fr.p2j_sheng_right.title_2j > p ");
                // print_r($text_box);die;
                // foreach ($text_box as $value){
                //     $url=pq($value)->find("a")->attr('href');
                //     $url_new="http://ldzl.people.com.cn/dfzlk/front/".$url;
                //     print_r($url_new);
                // $context1    = file_get_contents($url_new);
                // $document1   = phpQuery::newDocumentHTML($context1);
                // $doc1        = phpQuery::pq("");
                $text_box1   = $doc->find("div.fl.p2j_text_center.title_2j");
                    $title      = pq($text_box1)->find("ul > li > dl > dd > div > em")->text();
                    $picture    = pq($text_box1)->find("ul > li > dl > dt")->text();
                    $picture_o=pq($text_box1)->find("img#userimg")->attr('src');
                    $picture_ok="http://ldzl.people.com.cn".$picture_o;
                    $cag        = pq($text_box1)->find("div.p2j_text>p")->text();
                    // sleep(1);
                    //将数据插入数据表中
        $sql = "insert into difang (user,picture,content) value ('$title','$picture_ok','$cag')";
         if (mysqli_multi_query($link, $sql)){
         echo "新记录插入成功";
         echo "</br>";
        } 
        else {
        echo "Error: " . $sql . "<br>" . mysqli_error($link);
            }
                    // print_r($title);echo "</br>";    
                    // print_r($picture_ok);echo "</br>";
                    // print_r($cag);echo "</br>";
                // }
                    // $i=$i+1;
                

            }
        }
    //   echo $i;

 // array_push($value[1],$arr)

    // $str = file_get_contents("123.txt");
    //     $pattern1 ='/\/n.*html/';
    //     $b=preg_match_all($pattern1,$str,$cag_ok);
    //    $cag_b="http://cpc.people.com.cn".$cag_ok;
    //     foreach ($cag_b as $value2) {
    //         foreach ($value2 as $value3) {
    //             print_r($value3);
    //         }
    //     }