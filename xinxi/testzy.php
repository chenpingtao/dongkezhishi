<?php

require "phpQuery/phpQuery.php";
// 开始
$url = "http://sousuo.gov.cn/column/30614/0.htm";

/**
 * 获取一个页面中的所有需要的信息，并保存在上面定义的全局变量中
 * @param $url
 */
function get_page_info($url){
    // 声明使用全局变量
    global $titles  ;
    global $contents;
    global $cags    ;
    global $times   ;
    global $autuors ;

    //获取页面源代码
    $context    = file_get_contents($url);

//    print_r($context);
// 通过phpQuery对象将源代码进行解析
    $document   = phpQuery::newDocumentHTML($context);
//    print_r($document);
//    exit;

// 将整页面节点都转为pq 对象，
//因为这个对象可以有读取节点相应信息的方法，如果find   html。text 等方法；
    // $(  )
    $doc        = phpQuery::pq("");

    $text_box   = $doc->find("div.content > div > div.news_box > div.list.list_1.list_2 > ul > li > h4 ");
//print_r($text_box);
//echo "length:".count($text_box);
//exit;

    foreach ($text_box as $value){

        $url_new=pq($value)->find(" a")->attr('href');
        // $url_ok="http://www.bjmb.gov.cn".$url_new;
        // $title_ok=str_replace($area_ok,"",$title);
        // echo $url_new;
        // die;
        $context1=file_get_contents($url_new);
        // print_r($context1);
        // die;
        $document=phpQuery::newDocumentHTML($context1);
        // //将整个页面节点转为pq对象
        $doc1=phpQuery::pq("");
        // $area=$doc->find(" div.w_781 > h4 > span")->text();
        // $area_ok=str_replace("您现在的位置：首页»预警信息»","",$area);
        $text_box1=$doc1->find(" div.content > div.padd > div.article.oneColumn.pub_border");
        // print_r($text_box1);
        // die;
        $title      = pq($text_box1)->find("h1")->text();
        // echo $title;
        // die;
        $content    = pq($text_box1)->find("#UCAP-CONTENT")->text();
        $cag        = pq($text_box1)->find(".pages-date > span")->text();
        $cag_ok = str_replace("来源： ","",$cag);
        $ti         = pq($text_box1)->find("div.pages-date")->text();
        //字符串截取
        $ti_ok      =substr($ti,0,16);
        $autuor     = pq($text_box1)->find("div.editor")->text();
        $autuor_ok  = str_replace("【我要纠错】 责任编辑：","",$autuor);
        //将每一条内容添加到相对应的数组中进行保存
        array_push($titles,$title);
        array_push($contents,$content);
        array_push($cags,$cag_ok);
        array_push($times,$ti_ok);
        array_push($autuors,$autuor_ok);
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
function show($id,$autuor,$title,$content,$catg,$tim){
    $table = "<tr>
			<td>%d</td>
			<td>%s</td>
			<td class='col-lg-2'>%s</td>
			<td class='col-lg-4'>%s</td>
			<td>%s</td>
			<td>%s</td>
		</tr>";
    return sprintf($table,$id,$autuor,$title,$content,$catg,$tim);
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
        $tab .= show($i+1,$autuors[$i],$titles[$i],$contents[$i],$cags[$i],$times[$i]);
    }

    printf($html,$tab);
}


// 使用循环获取出每个节点的内容
$titles         = [];   // 标题
$contents       = [];   // 正文
$cags           = [];   // 来源
$times          = [];   // 发表时间
$autuors        = [];   // 责任编辑

// 获取单个页面的内容
// get_page_info($url);
// echo_to_web();

// 获取多个页面的内容
$url_page = "http://sousuo.gov.cn/column/30614/%d.htm";
foreach (range(0,8) as $v){
    $url = sprintf($url_page,$v);
    get_page_info($url);
    sleep(3); //停止执行3秒，防止速度过快导致对方网站服务器崩溃
}
echo_to_web();