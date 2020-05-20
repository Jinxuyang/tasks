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

    //创建一个对象，包含这个任务的各种信息
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

    //判断用户要查那个任务的信息，然后动态改变查询语句
    if($taskId === '*'){
        $gettaskinfo = "SELECT * FROM tasks_info";
    }else{
        $gettaskinfo = "SELECT * FROM tasks_info WHERE tasks_id = $taskId";
    }

    //执行语句，返回一个对象
    $info = $mysqli->query($gettaskinfo);

    //判读$info是否为空，空则没查找到或查找失败
    if($info){
        //遍历$info的每一行
        while ($row = $info->fetch_row())
        {

            $taskInfo = new taskInfo();//new 一个taskInfo对象
            //写入对应信息
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

            //新建一个data数组，存放每一行的信息
            $data[]=$taskInfo;

        }
        //
        $json = json_encode($data);//把数据转换为JSON数据.
        echo $json;//向客户端返回json数据

    }else{
        echo "查询失败";
        }
    $mysqli->close();//关闭与数据库的连接
?>