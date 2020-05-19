<?php
    $host = "localhost";
    $username = "root";
    $dbname = "tasks_test";
    $passwd = "";
    $port = 3308;
    $mysqli = new mysqli($host,$username,$passwd,$dbname,$port);
    //获取任务id
    $taskId = $_GET["taskId"];
    // 获取任务id为$taskId的状态字符串
    $gettaskinfo = "SELECT users_sta FROM tasks_sta WHERE tasks_id = $taskId";
    $info = $mysqli->query($gettaskinfo);
    if($info){
        $row = $info->fetch_row();
        $staCode = $row[0];
        //echo $staCode[0];
    }else{
        echo "查询失败";
    }
    //将状态为0的人的名字返回前端

    for ($i=1; $i < 30  ; $i++) { 
        if($staCode[$i] == 0){
            $getUserInfo = "SELECT user_name FROM users_info WHERE user_id = $i";
            $info = $mysqli->query($getUserInfo);
            $data = $info->fetch_assoc();
            if($data){
                $name[]=$data["user_name"];
            }
        }
    }
    $json = json_encode($name);
    echo $json;
    $mysqli->close();
?>