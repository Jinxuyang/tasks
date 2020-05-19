<?php
    header('Access-Control-Allow-Origin:*');
    //这一部分是用mysqli这个对象链接数据库
    $host = "localhost";//数据库的地址
    $username = "root";
    $dbname = "tasks";//要连接的数据库名
    $passwd = "";
    $port = 3306;
    $mysqli = new mysqli($host,$username,$passwd,$dbname,$port);//new 一个mysqli对象
    
    //判断链接是否成功
    if ($mysqli->connect_errno) {
        echo "Connect failed:", $mysqli->connect_error;
        exit();
    }
    
    //使用$_GET获取客户端传上来的taskId
    $taskId = $_GET["taskId"];
    
    // 获取任务id为$taskId的状态字符串
    $gettaskinfo = "SELECT tasks_sta FROM tasks_info WHERE tasks_id = $taskId";
    $info = $mysqli->query($gettaskinfo);
    if($info){
        $row = $info->fetch_row();
        $staCode = $row[0];
    }else{
        echo "查询失败";
    }
    //将状态为0的人的名字返回前端

    for ($i=1; $i < 30  ; $i++) { 
        if($staCode[$i] == 0){
            $getUserInfo = "SELECT users_name FROM dx198 WHERE users_id = $i";
            $info = $mysqli->query($getUserInfo);
            $data = $info->fetch_assoc();
            if($data){
                $name[]=$data["users_name"];
            }
        }
    }
    $json = json_encode($name);
    echo $json;
    $mysqli->close();
?>