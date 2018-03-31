<?php
function mysqlConnect($host,$user,$pass,$db){
    //第二步1.连接MySQL数据库
    $host='localhost';
    $user='root';
    $pass='';
    $db='renmian';
    $conn=mysqli_connect($host,$user,$pass,$db);
     if (!$conn) {
        die('连接失败('. mysqli_connect_errno() .') '
            . mysqli_connect_error());
    }

    mysqli_set_charset($conn, 'utf8');
    return $conn;
}

function mysqlExecute($conn, $sql)
{
    $result = mysqli_query($conn, $sql);
    // 保证增删改查sql语法没错
    // 保证插入，更新，删除都符合条件（如字数限制，数据类型限制）并成功
    if (!$result) {
        die('执行失败：' . mysqli_error($conn));
    }
    return $result;
}

?>
