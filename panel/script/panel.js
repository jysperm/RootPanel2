$($("#new-website").click(function() {
    $("#editWebsite .dialog-title").html("新增站点");
    $.post("/panel-action/get-new-vhost/", {}, function(data) {
        $("#editWebsite .dialog-body").html(data);

        bindSwitch();

        $("#editWebsite .rp-ok").unbind('click');
        $("#editWebsite .rp-ok").click(function(){
            postdata=$("#editWebsite .rp-form").serializeArray();
            postdata.push({name:"do",value:"add"});
            $.post("/commit/panel/", postdata,function(data){
                if(data.status=="ok")
                    window.location.reload();
                else
                    alert(data.msg);
            },"json");
            return false;
        });

        $("#editWebsite").modal();
    },"html");
}));