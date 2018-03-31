<?php
$dbhost = 'localhost:3306';
$dbuser = 'root';
$dbpass = '';
$conn = mysqli_connect($dbhost,$dbuser,$dbpass,"renmian");
if(!$conn){
	die('Could not connect:'.mysqli_error());
}
// echo '数据库连接成功！';
// mysqli_close($conn);
mysqli_query($conn,'set names utf8');
// error_reporting(0);
global $users;
$row = array();
$conment = isset($_POST["conment"]) ? trim($_POST['conment']) : '';
echo "<p style='color:red'>".$conment."</p>";
if($conment){
	
$name = mysqli_query($conn,"select * from bjrenmian where content like '%{$conment}%'");
while($row  =  mysqli_fetch_assoc ($name)){
	$row['content']  = str_replace($conment, '<font color="red">'.$conment.'</font>', $row['content']);
	$users[] = $row;
}
// print_r($users);
}
else{
echo "请输入关键词";
}
// while ( $row  =  mysqli_fetch_assoc ($conn,$name )) {
//         echo  $row [ "name" ];
//         echo  $row [ "sex" ];
//         echo  $row [ "number" ];
//     };
// echo "<br>";
// print_r($_POST["conment"]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <title>知仕网</title>
    <link rel="stylesheet" type="text/css" href="css/base.css">
    <link rel="stylesheet" type="text/css" href="css/common.css">
    <link rel="stylesheet" type="text/css" href="css/news.css">
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css">
    <script src="bootstrap/dist/js/jquery.min.js"></script>
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    
</head>
    <body>
      <!--搜索内容-->
      <div class="news_box">
           <div class="list list_1 list_2">
                <ul>
    <div class="container">
        <h1>全国人民代表大会常务委员会任命名单</h1>
        <div class="source">2018-03-21   20:19       来源：新华社</div>
        <hr size=2 style="color: black;border-style: dotted;width:90%;">
        <div class="zhidian">新华社北京3月21日电</div>
        <h3>全国人民代表大会常委员会任命名单</h3>
        <h4>(2018年3月21日第十三届全国人民代表大会常务委员会第一次会议通过)</h4>
        <div class="content">任命信春鹰（女）、韩晓武、郭雷、古小王、郭振华、柯良栋、何新为第十三届全国人民代表大会常务委员会副秘书长。</div>
        <img src="images/1.jpg">
    </div>                
<?php
global $value;
global $users;
foreach ($users as $value) {
	echo "<li><h1>".$value["title"]."</h1>";
    echo "<span>".$value["time"]."</span>";
    echo "<a class=\"source\" style=\"color:blue\">".$value["cag"]."</a>";
	echo "<a class=\"content\">".$value["content"]."</a>";
    echo "<a>".$value["picture"]."</a></li>";
    
}
echo "<table>";
?> 
                </ul>
           </div> 
            <!--分页-->
            <div class="">
              <ul class="pagination ">
                  <li><a href="#">&laquo;</a></li>
                  <li class="active"><a href="#">1</a></li>
                  <li><a href="#">2</a></li>
                  <li><a href="#">3</a></li>
                  <li><a href="#">4</a></li>
                  <li><a href="#">5</a></li>
                  <li><a href="#">6</a></li>
                  <li><a href="#">&raquo;</a></li>
              </ul>
          </div>
   
    </body>
    </html>

<?php
// error_reporting(0);
// print_r($_get);
$con = [];
$com = $_POST["conment"];
// echo '<table width="1000" border="1px solid red" cellpadding="5"><tr><th>标题</th><th>时间</th><th>来源</th><th>内容</th><th>图片</th></tr>'
?>

<?php
// global $value;
// // global $users;
// foreach ($users as $value) {
// 	echo "<tr><td>".$value["title"]."</td>";
// 	echo "<td>".$value["time"]."</td>";
// 	echo "<td>".$value["cag"]."</td>";
// 	echo "<td>".$value["content"]."</td>";
// 	echo "<td>".$value["picture"]."</td><tr>";
// };
// echo "<table>";
?> 