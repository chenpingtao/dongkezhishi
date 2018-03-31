<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/20
 * Time: 10:20
 */
require "phpQuery/phpQuery.php";
// 开始
$url = "http://www.gov.cn/xinwen/2016-01/20/content_5034708.htm";
/**
 * 获取一个页面中的所有需要的信息，并保存在上面定义的全局变量中
 * @param $url
 */
function get_page_info($url){
    // 声明使用全局变量
    global $titles  ;
    global $contents;
    global $cags    ;
   // global $tags    ;
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

    $text_box   = $doc->find("div.wrap > div.frame-pane");
//print_r($text_box);   div.article-colum > div.pages-title
//echo "length:".count($text_box);
//exit;

    foreach ($text_box as $value){
//    var_dump($value);
        $title      = pq($value)->find("div.article-colum > div.pages-title")->text();
        $content    = pq($value)->find("#printContent > tbody > tr > td")->text();
        $cag        = pq($value)->find("span:pq(1)")->text();
        $cag_ok      =substr($cag,48,10);
        // $cag_ok = str_replace(" 中央政府门户网站　www.gov.cn 来源：  ","",$cag);
        // alert(str.match(/\d+/g));
        $ti         = pq($value)->find(" div.pages-date")->text();
        //字符串截取
        // $ti_ok      =substr($ti,37,18);
        // $pattern1 ='/\d/';
        $pattern ='/\d{4}(-\d{2})+\s+\d{2}:\d{2}/';
        $ti_o=preg_match_all($pattern,$ti,$ti_ok);
        $ti_ok = $ti_ok[0][0];
        // $ti_ok=preg_replace($pattern,$pattern1,$ti)
        // print_r($ti_ok);die;
        
        $autuor     = pq($value)->find("div.editor")->text();
        $autuor_ok  = str_replace("责任编辑：","",$autuor);
//    print_r($autuor_ok);
//    echo "<br>";

        //将每一条内容添加到相对应的数组中进行保存
        array_push($titles,$title);
        array_push($contents,$content);
        array_push($cags,$cag_ok);
        //array_push($tags,$a_tags);
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
 * @param $tag
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

/**
 *  $tag 是一个数组，我们给数组中的每个标签添加css样式
 * @param $tag
 * @return string
 */


/**
 * 将获取到的内容利用表格样式输出到浏览器
 */
function echo_to_web( ){
    // 声明使用全局变量
    global $titles  ;
    global $contents;
    global $cags    ;
    //global $tags    ;
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
//$tags           = [];   // 标签
$times          = [];   // 发表时间
$autuors        = [];   // 责任编辑

// 获取单个页面的内容
get_page_info($url);
echo_to_web();

// 获取多个页面的内容
// $url_page = "https://www.helloweba.net/index-%d.html";
// foreach (range(1,5) as $v){
//     $url = sprintf($url_page,$v);
//     get_page_info($url);
//     sleep(3); //停止执行3秒，防止速度过快导致对方网站服务器崩溃
// }
// echo_to_web();