<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/20
 * Time: 10:20
 */
require "phpQuery/phpQuery.php";
// 开始
// $url = "http://cpc.people.com.cn/n1/2017/1025/c414940-29608803.html";
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
//    print_r($context);
//    exit;
// 通过phpQuery对象将源代码进行解析
    $document   = phpQuery::newDocumentHTML($context);
//    print_r($document);
//    exit;

// 将整页面节点都转为pq 对象，
//因为这个对象可以有读取节点相应信息的方法，如果find   html。text 等方法；
    // $(  )
    $doc        = phpQuery::pq("");

    $text_box   = $doc->find("body > div.people_text.clear.clearfix");
//print_r($text_box);   div.article-colum > div.pages-title
//echo "length:".count($text_box);
//exit;

    foreach ($text_box as $value){
//    var_dump($value);
        $title      = pq($value)->find("h2")->text();
        $content    = pq($value)->find("tr:eq(0) > td")->text();
        $content_ok=pq($value)->find("img")->attr('src');
        // $content_ok="http://cpc.people.com.cn".$content_o;
        // print_r($content_o);
        // exit;
        $cag        = pq($value)->find("p")->text();
        // $cag_ok      =substr($cag,9,12);
        // $cag_ok = str_replace("来源： ","",$cag);
        // alert(str.match(/\d+/g));

        //字符串截取
        // $ti_ok = str_replace("发布日期：","",$ti);
        // $ti_ok      =substr($ti,39,18);
        //正则匹配
        // $pattern ='/\d{4}(-\d{2})+\s+\d{2}:\d{2}/';
        // $ti_o=preg_match_all($pattern,$ti,$ti_ok);
        // $ti_ok = $ti_ok[0][0];
    
//    print_r($autuor_ok);
//    echo "<br>";

        //将每一条内容添加到相对应的数组中进行保存
        array_push($titles,$title);
        array_push($contents,$content_ok);
        array_push($cags,$cag);
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
// get_page_info($url);
// echo_to_web();

// 获取多个页面的内容

foreach (range(4,32) as $v){
    if($v<=9){
        $url_page = "http://cpc.people.com.cn/n1/2017/1025/c414940-2960880%d.html";
        // $url = sprintf($url_page);
        if($v==6){
            $url_page = "http://cpc.people.com.cn/n1/2017/1025/c414940-29608803.html";
            $url = sprintf($url_page);
        }else{
            $url_page = "http://cpc.people.com.cn/n1/2017/1025/c414940-2960880%d.html";
            $url = sprintf($url_page,$v);
        }
    }else{
        $url_page = "http://cpc.people.com.cn/n1/2017/1025/c414940-296088%d.html";
        $url = sprintf($url_page,$v);
    }
    get_page_info($url);
    sleep(1); //停止执行3秒，防止速度过快导致对方网站服务器崩溃
}
echo_to_web();