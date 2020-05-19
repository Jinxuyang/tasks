
//这个函数的功能是，向服务器发送get请求，服务器返回一个json数据，内容包括任务名称开始时间，结束时间.....
function gettaskinfo(){
    var jsondata;
    //这个$.ajax是jquery的一个方法，比原生js好用，作用是发送Ajax请求的
    $.ajax({
            url:'http://121.36.19.47/tasks/getTaskInfo.php',//请求的地址
            type:'get',//请求类型
            async: false,//同步or异步，false为同步
            data:{//向服务器发送的数据
                taskId:'*',
            },
            success:function(data){ //成功后执行，data为服务器返回的东西
                console.log("ok");
                jsondata = $.parseJSON(data);//这个$.parseJSON(),用来解析json数据，把json数据变成一个js对象
            },
            error:function(errorinfo){//错误后执行
                console.log("错误"+errorinfo.statusText);
            }
    })
    return jsondata;//把这个js对象return出去
}
//这个函数的功能是，任务的相关信息插入到div2这个地方
function showlist(){
    var jsoninfo = gettaskinfo();
    
    for (let index = 0; jsoninfo[index] != undefined; index++) {//遍历jsoninfo(有点像php里的关联数组?)这个对象的所有小伙子
        var percent = (jsoninfo[index].total-jsoninfo[index].undone)/jsoninfo[index].total;//计算完成人数的百分比
        //一会就是把这个对象插到div2里
        var task = '<a href="http://121.36.19.47/tasks/detail.html?task_id='+ jsoninfo[index].id +' " class="list-group-item" ><div><h4>' + jsoninfo[index].name + '</h4><h5>创建时间:'+jsoninfo[index].stime+'</h5></div><p>'+jsoninfo[index].des+'</p><div class="progress"><div class="progress-bar" role="progressbar"  aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: ' + parseInt(percent*100+0.5) +'%;">'+ parseInt(percent*100+0.5)+'%</div></div></a>';
        $("#div2").append(task);
    }
}

//页面加载完后执行
window.onload = function () {
    showlist();
}