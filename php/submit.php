<?php
    header('Access-Control-Allow-Origin:*');
     
    $name = $_GET['name'];
    $id = $_GET['id'];
    $taskId = $_GET['taskId'];

    $host = "localhost";
    $username = "root";
    $dbname = "tasks";
    $passwd = "";
    $port = 3306;
    $mysqli = new mysqli($host,$username,$passwd,$dbname,$port);
    
    if ($mysqli->connect_errno) {
        printf("Connect failed:", $mysqli->connect_error);
        exit();
    }
    
    $checkinfo = "SELECT users_name FROM dx198 WHERE users_id = $id";

    $userinfo = $mysqli->query($checkinfo);
    if(empty($userinfo)){
        echo "未匹配到此人($name)，请重新输入";
    }else{
        $info = $userinfo->fetch_array(MYSQLI_ASSOC);
        if($info['users_name'] != $name){
            echo "学号($id)与姓名($name)不匹配";
        }else{
            $gettaskinfo = "SELECT tasks_sta,tasks_undone FROM tasks_info WHERE tasks_id = $taskId";
                $info = $mysqli->query($gettaskinfo);
                $row = $info->fetch_row();
                $staCode = $row[0];
            if($staCode[$id] == 1){
                echo "您($name)今日已签到";
            }else{
                $staCode[$id] = 1;
                $undoneNum = $row[1] - 1;
                $updateSta = "UPDATE tasks_info SET tasks_sta = $staCode WHERE tasks_id = $taskId";
                $updateUndone = "UPDATE tasks_info SET tasks_undone = $undoneNum WHERE tasks_id = $taskId";
                $mysqli->query($updateUndone);
                $mysqli->query($updateSta);
                echo "您($name)签到成功";
            }
        } 
    }
    $mysqli->close();
?>