function addTime(uname) {
  $.post("/admin-action/add-time/", {"uname": uname, "day": prompt(rpL["admin.addTime"])}, function (data) {
    if (data.status == "ok")
      window.location.reload();
    else
      alert(data.msg);
  }, "json");
}

function alertUser(uname) {
  $.post("/admin-action/alert-user/", {"uname": uname}, function (data) {
    alert(data.status);
  }, "json");
}

function switchUser(uname) {
  $.post("/admin-action/switch-user/", {"uname": uname, "type": prompt(rpL["admin.switch"])}, function (data) {
    if (data.status == "ok")
      window.location.reload();
    else
      alert(data.msg);
  }, "json");
}

function newTK(uname) {
  $("#dialog .dialog-title").html(rpL["admin.newTK"]);
  $.post("/admin-action/get-new-ticket/", {}, function (data) {
    $("#dialog .dialog-body").html(data);

    $("#dialog .dialog-ok").unbind('click');
    $("#dialog .dialog-ok").click(function () {
      var postdata = $("#dialog .website-form").serializeArray();
      postdata.push({name: "onlyclosebyadmin", value: ($("#onlyclosebyadmin").hasClass("active") ? 1 : 0)});
      $.post("/ticket/create/", postdata, function (data) {
        if (data.status == "ok")
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

function editSettings(uname) {
  $("#dialog .dialog-title").html(rpL["admin.editSettings"]);
  $.post("/admin-action/get-edit-settings/" + uname + "/", {}, function (data) {
    $("#dialog .dialog-body").html(data);

    $("#dialog .dialog-ok").unbind('click');
    $("#dialog .dialog-ok").click(function () {
      var postdata = $("#dialog .website-form").serializeArray();
      $.post("/admin-action/edit-settings/" + uname + "/", postdata, function (data) {
        if (data.status == "ok")
          window.location.reload();
        else
          alert(data.msg);
      }, "json");
      return false;
    });

    $("#dialog").modal();
  }, "html");
}

function getPasswd(uname) {
  $("#dialog .dialog-title").html(uname);
  $.post("/admin-action/get-passwd/", {"uname": uname}, function (data) {
    $("#dialog .dialog-body").html(data);

    $("#dialog").modal();
  }, "html");
}

function enableUser(uname, type) {
  $.post("/admin-action/enable-user/", {"uname": uname, "type": type}, function (data) {
    window.location.reload();
  }, "json");
}

function deleteUser(uname) {
  if (confirm(rpL["panel.sureDelete"])) {
    $.post("/admin-action/delete-user/", {"uname": uname}, function (data) {
      window.location.reload();
    }, "json");
  }
}

function disableUser(uname) {
  $.post("/admin-action/disable-user/", {"uname": uname}, function (data) {
    if (data.status == "ok")
      window.location.reload();
    else
      alert(data.msg);
  }, "json");
}
