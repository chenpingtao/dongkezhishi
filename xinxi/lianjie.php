<?php


$mysql_server="localhost";
$mysql_username="root";
$mysql_password="";
$mysql_database="renmian";
//建立数据库链接
$conn = mysql_connect($mysql_server,$mysql_username,$mysql_password) or die("数据库链接错误");
//选择某个数据库
mysql_select_db($mysql_database,$conn);
mysql_query("set names 'utf8'");
//执行MySQL语句
$result=mysql_query("SELECT id,name FROM 数据库表");
//提取数据
$row=mysql_fetch_row($result);

?>