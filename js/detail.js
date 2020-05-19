$(document).ready(function (){
    insertInfo();
    //alert("userName");
  });

//获取任务id
function getTaskId() {
    let reg = new RegExp('task_id=([^]*)');
    let r = window.location.search.substr(1).match(reg);
    return r[1];
}
//获取任务信息
function getTaskInfo(){
    var jsondata;
    $.ajax({
            url:'http://121.36.19.47/tasks/getTaskInfo.php',
            type:'get',
            async: false,
            data:{
                taskId:getTaskId(),
            },
            success:function(data){
                console.log("ok");
                jsondata = $.parseJSON(data);
            },
            error:function(errorinfo){
                console.log("错误"+errorinfo.statusText);
            }
    })
    return jsondata;
}
//获取任务完成信息,返回一串01，第一个是id为1的同学的状态，0为未完成
function getTaskSta(){
    var jsondata;
    $.ajax({
        url:'http://121.36.19.47/tasks/getTaskSta.php',
        type:'get',
        async: false,
        data:{
            taskId:getTaskId(),
        },
        success:function(data){
            jsondata = $.parseJSON(data);
        }
    })
    return jsondata;
}
function insertInfo(){
    var taskInfo = getTaskInfo();
    $("#a1").text(taskInfo[0].name);
    console.log(taskInfo[0].name);
    var name = getTaskSta();
    if(name.length > 0){
        $("#p1").text(name);
        
    }else{
        $("#p1").text("全部完成");
    }
    
  
    

}

