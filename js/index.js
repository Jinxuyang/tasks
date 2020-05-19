

function gettaskinfo(){
    var jsondata;
    $.ajax({
            url:'http://121.36.19.47/tasks/getTaskInfo.php',
            type:'get',
            async: false,
            data:{
                taskId:'*',
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

function showlist(){
    var jsoninfo = gettaskinfo();
    
    for (let index = 0; jsoninfo[index] != undefined; index++) {
        var percent = (jsoninfo[index].total-jsoninfo[index].undone)/jsoninfo[index].total;
        var task = '<a href="http://121.36.19.47/tasks/detail.html?task_id='+ jsoninfo[index].id +' " class="list-group-item list-group-item-action" ><div ><h5 class="mb-1">' + jsoninfo[index].name + '</h5><small>创建时间:'+jsoninfo[index].stime+'</small></div><p class="mb-1">'+jsoninfo[index].des+'</p><div class="progress" style="height: 13px;"><div class="progress-bar" role="progressbar"  aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: ' + percent +'%;">'+ percent+'%</div></div></a>';
        $("#div2").append(task);
    }
}


window.onload = function () {
    showlist();
}