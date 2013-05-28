function addTime(uname)
{
    $.post("/admin-action/add-time/",{"uname": uname, "day": prompt("请输入要延时的天数")}, function(data){
        if(data.status=="ok")
            window.location.reload();
        else
            alert(data.msg);
    },"json");
}

function alertUser(uname, type)
{
    $.post("/admin-action/alert-user/",{"uname": uname, "type":type}, function(data){
        alert(data.msg);
    },"json");
}

function newTK(uname)
{
    $("#dialog .dialog-title").html("创建工单");
    $.post("/admin-action/get-new-ticket/", {}, function (data) {
        $("#dialog .dialog-body").html(data);

        $("#dialog .dialog-ok").unbind('click');
        $("#dialog .dialog-ok").click(function () {
            var postdata = $("#dialog .website-form").serializeArray();
            postdata.push({name: "onlyclosebyadmin", value: ($("#onlyclosebyadmin").hasClass("active") ? 1 : 0)});
            $.post("/ticket/create/", postdata, function (data) {
                if(data.status == "ok")
                    window.location.reload();
                else
                    alert(data.msg);
            }, "json");
            return false;
        });

        $("#dialog").modal();
        $("#dialog #users").val(uname);
    }, "html");
}

function getPasswd(uname)
{
    $("#dialog .dialog-title").html(uname);
    $.post("/admin-action/get-passwd/", {"uname": uname}, function (data) {
        $("#dialog .dialog-body").html(data);

        $("#dialog").modal();
    }, "html");
}

/*
enableUser
deleteUser
disableUser
*/

function userDelete(uname)
{
    if(confirm("你确定要删除？"))
    {
        $.post("/commit/admin/",{"do":"delete","uname":uname},function(data){
            if(data.status=="ok")
                window.location.reload();
            else
                alert(data.msg);
        },"json");
    }
    return false;
}

function commonAct(act,uname,isReload)
{
    $.post("/commit/admin/",{"do":act,"uname":uname},function(data){
        if(data.status=="ok")
        {
            if(isReload)
                window.location.reload();
            else
                alert(data.status);
        }
        else
            alert(data.msg);
    },"json");
    return false;
}