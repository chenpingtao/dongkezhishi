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

<html>
<form id="fm" method="post" action="refer.php">
	<input type="text" name="conment" value="" />
	<input type="submit" value="提交" />
</form>
</html>

<?php
// error_reporting(0);
// print_r($_get);
$con = [];
$com = $_POST["conment"];
echo '<table width="1000" border="1px solid red" cellpadding="5"><tr><th>标题</th><th>时间</th><th>来源</th><th>内容</th><th>图片</th></tr>'
?>

<?php
global $value;
global $users;
foreach ($users as $value) {
	echo "<tr><td>".$value["title"]."</td>";
	echo "<td>".$value["time"]."</td>";
	echo "<td>".$value["cag"]."</td>";
	echo "<td>".$value["content"]."</td>";
	echo "<td>".$value["picture"]."</td><tr>";
};
echo "<table>";
?> 