$($("#new-website").click(function () {
    $("#dialog .dialog-title").html(rpL["panel.newSite"]);
    $.post("/panel-action/get-new-vhost/", {}, function (data) {
        $("#dialog .dialog-body").html(data);

        $("#dialog .dialog-ok").unbind('click');
        $("#dialog .dialog-ok").click(function () {
            var postdata = $("#dialog .website-form").serializeArray();
            postdata.push({name: "ison", value: ($("#ison").hasClass("active") ? 1 : 0)});
            postdata.push({name: "autoindex", value: ($("#autoindex").hasClass("active") ? 1 : 0)});
            postdata.push({name: "isssl", value: ($("#isssl").hasClass("active") ? 1 : 0)});
            $.post("/panel-action/create-vhost/", postdata, function (data) {
                if(data.success)
                    window.location.reload();
                else
                    alert(data.msg);
            }, "json");
            return false;
        });

        $("#dialog").modal();
        $("a[rel=tooltip]").tooltip({trigger: "hover", html: true, placement: "right"});
    }, "html");
}));

function editWebsite(websiteId) {
    $("#dialog .dialog-title").html(rpL["panel.editSite"]);
    $.post("/panel-action/get-vhost/", {"id": websiteId}, function (data) {
        $("#dialog .dialog-body").html(data);

        $("#dialog .dialog-ok").unbind('click');
        $("#dialog .dialog-ok").click(function () {
            var postdata = $("#dialog .website-form").serializeArray();
            postdata.push({name: "ison", value: ($("#ison").hasClass("active") ? 1 : 0)});
            postdata.push({name: "autoindex", value: ($("#autoindex").hasClass("active") ? 1 : 0)});
            postdata.push({name: "isssl", value: ($("#isssl").hasClass("active") ? 1 : 0)});
            $.post("/panel-action/edit-vhost/" + websiteId + "/", postdata, function (data) {
                if (data.success)
                    window.location.reload();
                else
                    alert(data.msg);
            }, "json");
            return false;
        });

        $("#dialog").modal();
        $("a[rel=tooltip]").tooltip({trigger: "hover", html: true, placement: "right"});
    }, "html");

    return false;
}

function deleteWebsite(websiteId) {
    if (confirm(rpL["panel.sureDelete"])) {
        $.post("/panel-action/delete-vhost/", {"id": websiteId}, function (data) {
            if(data.success)
                window.location.reload();
            else
                alert(data.msg);
        }, "json");
    }
    return false;
}

function changePasswd(name, isReload) {
    $.post("/panel-action/" + name +"-passwd/", {"passwd": $("#" + name + "passwd").val()}, function (data) {
        if(data.success) {
            if(isReload)
                window.location.reload();
            else
                alert(data.status);
        }
        else
            alert(data.msg);
    }, "json");
    return false;
}

$($("#nginx-extConfig").click(function () {
    $("#dialog .dialog-title").html(rpL["panel.viewNginxExtConfig"]);
    $("#dialog .dialog-body").html("");
    $.post("/panel-action/getExtConfig/nginx/", {}, function (data) {
        $("#dialog .dialog-body").html(data);
    });
    $("#dialog").modal();
}));

$($("#apache2-extConfig").click(function () {
    $("#dialog .dialog-title").html(rpL["panel.viewApache2ExtConfig"]);
    $("#dialog .dialog-body").html("");
    $.post("/panel-action/getExtConfig/apache2/", {}, function (data) {
        $("#dialog .dialog-body").html(data);
    });
    $("#dialog").modal();
}));
