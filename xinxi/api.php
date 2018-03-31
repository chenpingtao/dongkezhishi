<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/20
 * Time: 15:09
 */
$url = "http://bus.ctrip.com/ship/index.php?param=data/getShipLine";
//print_r(file_get_contents($url));
//$ch = curl_init($url);
//print_r(curl_exec($ch));

// 创建一个新cURL资源
$ch = curl_init();

// 设置URL和相应的选项
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);

// 抓取URL并把它传递给浏览器
curl_exec($ch);

// 关闭cURL资源，并且释放系统资源
curl_close($ch);