<?php

require "phpQuery/phpQuery.php";
// 开始
$url = "http://ldzl.people.com.cn/dfzlk/front/personProvince1.htm";

/**
 * 获取一个页面中的所有需要的信息，并保存在上面定义的全局变量中
 * @param $url
 */
function get_page_info($url){
    // 声明使用全局变量
    global $titles  ;
    global $contents;
    global $cags    ;

    //获取页面源代码
    $context    = file_get_contents($url);
    $document   = phpQuery::newDocumentHTML($context);
//    print_r($document);
//    exit;
    $doc        = phpQuery::pq("");
    $text_box   = $doc->find("ul>li:eq(0)")->text();
// print_r($text_box);die;
//echo "length:".count($text_box);> li:nth-child(1) > a
    foreach ($text_box as $value){
        $url_new=pq($value)->find("a")->attr('href');
        $url_ok="http://ldzl.people.com.cn".$url_new;
        
        print_r($url_ok);
        // echo "length:".count($text_box);
        exit;
        
        $context1=file_get_contents($url_ok);
        // print_r($context1);
        // die;
        $document=phpQuery::newDocumentHTML($context1);
        // echo $document;
        // die;
        //将整个页面节点转为pq对象
        $doc1=phpQuery::pq("");
        $text_box1=$doc1->find("body > div.people_text.clear.clearfix");
        // print_r($text_box1);
        // die;
        $title      = pq($text_box1)->find("h2")->text();
        // echo $title;
        // die;
        $content    = pq($text_box1)->find("tr:eq(0) > td")->text();
        $content_o=pq($value)->find("img")->attr('src');
        $content_ok="http://cpc.people.com.cn".$content_o;
        $cag        = pq($text_box1)->find("p")->text();
        // $cag_ok = str_replace("来源： ","",$cag);

        //将每一条内容添加到相对应的数组中进行保存
        array_push($titles,$title);
        array_push($contents,$content_ok);
        array_push($cags,$cag);
        sleep(1);
    }
//    exit();
}

/**
 * 将获取的所有内容做成 table中的表格形式
 * @param $id
 * @param $autuor
 * @param $title
 * @param $content
 * @param $catg
 * @param $tim
 * @return string
 */
function show($id,$title,$content,$catg){
    $table = "<tr>
			<td>%d</td>
			<td class='col-lg-2'>%s</td>
			<td class='col-lg-4'>%s</td>
			<td>%s</td>
		</tr>";
    return sprintf($table,$id,$title,$content,$catg);
}

//     return $span;
// }

/**
 * 将获取到的内容利用表格样式输出到浏览器
 */
function echo_to_web( ){
    // 声明使用全局变量
    global $titles  ;
    global $contents;
    global $cags    ;
    global $times   ;
    global $autuors ;

    $html = file_get_contents("./show.html");
    $tab  = "";
    for($i = 0; $i<count($titles);$i++){
        $tab .= show($i+1,$titles[$i],$contents[$i],$cags[$i]);
    }

    printf($html,$tab);
}


// 使用循环获取出每个节点的内容
$titles         = [];   // 标题
$contents       = [];   // 正文
$cags           = [];   // 来源

// 获取单个页面的内容
get_page_info($url);
echo_to_web();

// 获取多个页面的内容
// $url_page = "http://sousuo.gov.cn/column/30615/0.htm";
// foreach (range(0,3) as $v){
//     $url = sprintf($url_page,$v);
//     get_page_info($url);
//     sleep(3); //停止执行3秒，防止速度过快导致对方网站服务器崩溃
// }
// echo_to_web();