<?php

require "phpQuery/phpQuery.php";
$str = file_get_contents("123.txt");
        $pattern ='/http.*html/';       
        $a=preg_match_all($pattern,$str,$cag_a);
        foreach ($cag_a as $value) {
            foreach ($value as $url) {
                get_page_info($url);
                print_r($a);
                }
            }

// 开始
// $url = "http://cpc.people.com.cn/gbzl/html/121000298.html";

function get_page_info($url){
    // 声明使用全局变量
    global $titles  ;
    global $contents;
    global $cags    ;

    //获取页面源代码
    $context    = file_get_contents($url);
// 通过phpQuery对象将源代码进行解析
    $document   = phpQuery::newDocumentHTML($context);
    $doc        = phpQuery::pq("");
    $text_box   = $doc->find("div.ej_left");

    foreach ($text_box as $value){
        $title      = pq($value)->find("strong")->text();
        $title_ok = str_replace("纠错、提醒管理员更新","",$title);
        $content    = pq($value)->find("div.gr_img")->text();
        $content_ok=pq($value)->find("img")->attr('src');
        $cag        = pq($value)->find("p")->text();

        //将每一条内容添加到相对应的数组中进行保存
        array_push($titles,$title_ok);
        array_push($contents,$content_ok);
        array_push($cags,$cag);
    }
}

/**
 * 将获取的所有内容做成 table中的表格形式
 * @param $id
 * @param $title
 * @param $content
 * @param $catg
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

/**
 * 将获取到的内容利用表格样式输出到浏览器
 */
function echo_to_web( ){
    // 声明使用全局变量
    global $titles  ;
    global $contents;
    global $cags    ;

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
// $url_page = "http://renshi.beijing.gov.cn/library/138/144/139/608582/index%d.html";
// foreach (range(1,5) as $v){
//     $url = sprintf($url_page,$v);
//     get_page_info($url);
//     sleep(3); //停止执行3秒，防止速度过快导致对方网站服务器崩溃
// }
// echo_to_web();