<?php
    header('Access-Control-Allow-Origin:*');
    $host = "localhost";
    $username = "root";
    $dbname = "tasks";
    $passwd = "";
    $port = 3306;
    $mysqli = new mysqli($host,$username,$passwd,$dbname,$port);
    
    if ($mysqli->connect_errno) {
        echo "Connect failed:", $mysqli->connect_error;
        exit();
    }
    
    $taskId = $_GET["taskId"];

    
        class taskInfo 
        {
            public $id;
            public $name;
            public $des;
            public $type;
            public $stime;
            public $etime;
            public $owner;
            public $sta;
            public $major;
            public $class;
            public $undone;
            public $total;
        }
        
        if($taskId === '*'){
            $gettaskinfo = "SELECT * FROM tasks_info";
        }else{
            $gettaskinfo = "SELECT * FROM tasks_info WHERE tasks_id = $taskId";
        }

        $info = $mysqli->query($gettaskinfo);

        if($info){
            while ($row = $info->fetch_row())
            {
                $taskInfo = new taskInfo();
                $taskInfo->id = $row[0];
                $taskInfo->name = $row[1];
                $taskInfo->des = $row[2];
                $taskInfo->type = $row[3];
                $taskInfo->stime = $row[4];
                $taskInfo->etime = $row[5];
                $taskInfo->owner = $row[6];
                $taskInfo->sta = $row[7];
                $taskInfo->major = $row[8];
                $taskInfo->class = $row[9];
                $taskInfo->undone = $row[10];
                $taskInfo->total = $row[11];

                $data[]=$taskInfo;

            }
        
            $json = json_encode($data);//把数据转换为JSON数据.
            echo $json;

        }else{
            echo "查询失败";
            }
        $mysqli->close();
    ?>