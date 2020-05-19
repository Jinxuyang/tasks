<?php
    header('Access-Control-Allow-Origin:*');
     
    $name = $_GET['name'];
    $id = $_GET['id'];
    $taskId = $_GET['taskId'];

    $host = "localhost";
    $username = "root";
    $dbname = "tasks_test";
    $passwd = "";
    $port = 3308;
    $mysqli = new mysqli($host,$username,$passwd,$dbname,$port);
    
    if ($mysqli->connect_errno) {
        printf("Connect failed: %s\n", $mysqli->connect_error);
        exit();
    }

    $checkinfo = "SELECT * FROM users_info WHERE user_id = $id";

    $userinfo = $mysqli->query($checkinfo);
    if(empty($userinfo)){
        echo "未匹配到此人($name)，请重新输入";
    }else{
        $info = $userinfo->fetch_array(MYSQLI_ASSOC);
        if($info['user_name'] != $name){
            echo "学号($id)与姓名($name)不匹配";
        }else{
            $gettaskinfo = "SELECT users_sta FROM tasks_sta WHERE tasks_id = $taskId";
                $info = $mysqli->query($gettaskinfo);
                $row = $info->fetch_row();
                $staCode = $row[0];
            if($staCode[$id] == 1){
                echo "您($name)今日已签到";
            }else{
                $changedCode = $staCode;
                $changedCode[$id] = 1;
                $updateSta = "UPDATE tasks_sta SET users_sta = $changedCode WHERE tasks_id = $taskId";
                $mysqli->query($updateSta);
                echo "您($name)签到成功";
            }
        } 
    }
    $mysqli->close();
?>