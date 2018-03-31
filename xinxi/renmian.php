<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/20
 * Time: 10:20
 */
require "phpQuery/phpQuery.php";
// 开始
// $url = "http://cpc.people.com.cn/GB/64192/105996/6463136.html";
$url = "http://district.ce.cn/zt/rwk/sf/bj/index.shtml";

function get_page_info($url){
    // 声明使用全局变量
    global $titles  ;
    global $contents;
    global $cags    ;
    global $pictures;
    global $times;
    
   
$context=file_get_contents($url);

$document=phpQuery::newDocumentHTML($context);

$doc=phpQuery::pq("");
$variable   = $doc->find("body > div.main > div.right > div.list > ul > li");
// print_r($variable);die;
    foreach ($variable as $text_box) {
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
                    $conten    = pq($text_box3)->find("#articleText > div.TRS_Editor p")->text();
                    $picture=pq($text_box3)->find("#articleText > div.TRS_Editor p img")->attr('src');
                    $time     =pq($text_box3)->find("#articleTime")->text();
                    $cag_ok   = pq($text_box3)->find("#articleSource")->text();
                    $cag = str_replace("来源：","",$cag_ok);
                    // sleep(1);                
                    // print_r($title);echo "</br>";    
                    // print_r($picture);echo "</br>";
                    // print_r($cag);echo "</br>";
                    // print_r($time);echo "</br>";
                    // print_r($conten);echo "</br>";echo "</br>";

        //将每一条内容添加到相对应的数组中进行保存
        array_push($titles,$title);
        array_push($contents,$content_ok);
        array_push($cags,$cag);
        array_push($pictures,$picture);
        array_push($times,$time);
    }
//    exit();
}

/**
 * 将获取的所有内容做成 table中的表格形式
 * @param $id
 * @param $title
 * @param $content
 * @param $catg
 * @return string
 */
function show($id,$title,$content,$cag,$picture,$time){
    $table = "<tr>
			<td>%d</td>
			<td class='col-lg-2'>%s</td>
			<td class='col-lg-4'>%s</td>
            <td>%s</td>
            <td class='col-lg-2'>%s</td>
			<td class='col-lg-4'>%s</td>
		</tr>";
    return sprintf($table,$id,$title,$content,$cag,$picture,$time);
}

/**
 * 将获取到的内容利用表格样式输出到浏览器
 */
function echo_to_web( ){
    // 声明使用全局变量
    global $titles  ;
    global $contents;
    global $cags    ;
    global $pictures;
    global $times;

    $html = file_get_contents("./show.html");
    $tab  = "";
    for($i = 0; $i<count($titles);$i++){
        $tab .= show($i+1,$titles[$i],$contents[$i],$cags[$i],$pictures[$i],$time[$i]);
    }

    printf($html,$tab);
}



   // 来源

// 获取单个页面的内容
get_page_info($url);
echo_to_web();

// 获取多个页面的内容
// $url_page = "http://renshi.beijing.gov.cn/library/138/144/139/608582/index%d.html";
// foreach (range(1,5) as $v){
//     $url = sprintf($url_page,$v);
//     get_page_info($url);
//     sleep(3); //停止执行3秒，防止速度过快导致对方网站服务器崩溃
// }
// echo_to_web();