function getdate() {
    var date = new Date();
    $("#span1").text(date.toLocaleDateString());
}

function outputinfo(info, status) {
    $("#div3").css("display", "inherit");
    $("#div3").removeClass();
    $("#div3").addClass('alert alert-' + status);
    $("#div3").text(info);
}

function getTaskId() {
    let reg = new RegExp('task_id=([^]*)');
    let r = window.location.search.substr(1).match(reg);
    return r[1];
}

$(document).ready(function () {
    $("#btn1").click(function clickbtn() {
        var info;
        var status;
        if ($("#input1").val() == '' || $("#input2").val() == '') {
            info = "请把信息(姓名或学号)补充完整";
            status = "warning";
            outputinfo(info, status);
        } else {
            if (!($("#1").prop('checked'))) {
                info = "请勾选我已完成信息上报";
                status = "warning";
                outputinfo(info, status);
            } else {
                info = "确认中，请稍后....";
                status = "info";
                outputinfo(info, status);
                $.ajax({
                    url: 'http://121.36.19.47/tasks/submit.php',
                    type: 'get',
                    data: {
                        name: $("#input1").val(),
                        id: $("#input2").val(),
                        taskId: getTaskId(),
                    },
                    success: function (data) {
                        insertInfo();
                        info = data;
                        status = "success";
                        outputinfo(info, status);
                    },
                    error: function () {
                        info = "出现一些未知问题，请稍后重试";
                        status = "warning";
                        outputinfo(info, warning);
                    }
                })
            }
        }
    })
    getdate();
})