$($("#new-website").click(function () {
    $("#dialog .dialog-title").html(rpL["panel.newSite"]);
    $.post("/panel-action/get-new-vhost/", {}, function (data) {
        $("#dialog .dialog-body").html(data);

        $("#dialog .dialog-ok").unbind('click');
        $("#dialog .dialog-ok").click(function () {
            var postdata = $("#dialog .dialog-form").serializeArray();
            $.post("/panel-action/get-new-vhost/", postdata, function (data) {
                if (data.status == "ok")
                    window.location.reload();
                else
                    alert(data.msg);
            }, "json");
            return false;
        });

        $("#dialog").modal();
    }, "html");
}));

$($("#nginx-extConfig").click(function () {
    $("#dialog .dialog-title").html(rpL["panel.viewNginxExtConfig"]);
    $.post("/panel-action/getExtConfig/nginx/", {}, function (data) {
        $("#dialog .dialog-body").html(data);
    });
    $("#dialog").modal();
}));
$($("#apache2-extConfig").click(function () {
    $("#dialog .dialog-title").html(rpL["panel.viewApache2ExtConfig"]);
    $.post("/panel-action/getExtConfig/apache2/", {}, function (data) {
        $("#dialog .dialog-body").html(data);
    });
    $("#dialog").modal();
}));


function deleteWebsite(websiteId) {
    if (confirm("你确定要删除？")) {
        $.post("/commit/panel/", {"do": "delete", "id": websiteId}, function (data) {
            if (data.status == "ok")
                window.location.reload();
            else
                alert(data.msg);
        }, "json");
    }
    return false;
}

function bindSwitch() {
    $("#editWebsite #opweb").click(function () {
        $("#editWebsite .div-web").show();
        $("#editWebsite .rp-root-name").html("Web根目录");
        $("#editWebsite .div-python").hide();
    });

    $("#editWebsite #opproxy").click(function () {
        $("#editWebsite .div-web").hide();
        $("#editWebsite .rp-root-name").html("反向代理URL");
        $("#editWebsite .div-python").hide();
    });

    $("#editWebsite #oppython").click(function () {
        $("#editWebsite .div-web").hide();
        $("#editWebsite .rp-root-name").html("Web根目录");
        $("#editWebsite .div-python").show();
    });

    $("#editWebsite #opall").click(function () {
        $("#editWebsite .div-only").hide();
        $("#editWebsite .div-unless").hide();
    });

    $("#editWebsite #oponly").click(function () {
        $("#editWebsite .div-only").show();
        $("#editWebsite .div-unless").hide();
    });

    $("#editWebsite #opunless").click(function () {
        $("#editWebsite .div-only").hide();
        $("#editWebsite .div-unless").show();
    });
}

function editWebsite(websiteId) {
    $("#editWebsite .rp-title").html("编辑站点");
    $.post("/commit/panel/", {"do": "get", "id": websiteId}, function (data) {
        $("#editWebsite .rp-body").html(data);

        bindSwitch();

        $("#editWebsite .rp-ok").unbind('click');
        $("#editWebsite .rp-ok").click(function () {
            postdata = $("#editWebsite .rp-form").serializeArray();
            postdata.push({name: "id", value: websiteId});
            postdata.push({name: "do", value: "edit"});
            $.post("/commit/panel/", postdata, function (data) {
                if (data.status == "ok")
                    window.location.reload();
                else
                    alert(data.msg);
            }, "json");
            return false;
        });

        $("#editWebsite").modal();
    }, "html");

    return false;
}


function changePasswd(name, isReload) {
    $.post("/commit/panel/", {"do": name, "passwd": $("#" + name).val()}, function (data) {
        if (data.status == "ok") {
            if (isReload)
                window.location.reload();
            else
                alert(data.status);
        }
        else
            alert(data.msg);
    }, "json");
    return false;
}