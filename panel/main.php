<?php

require_once("./LightPHP/lp-load.php");
require_once("config.php");
require_once("handler/global.php");

lpMVC::bind('^/$',function(){
    require_once("index.php");
    return "";
});

lpMVC::bind('^/panel/?',function(){
    if(!lpAuth::login())
    {
        gotoUrl("/login/");
        exit();
    }
        
    $conn=new lpMySQL;
    $rs=$conn->select("user",array("uname"=>lpAuth::getUName()));
    if($rs->read() && $rs->type!="no")
    {
        lpTemplate::parseFile("template/panel.php");
    }
    else
    {
        gotoUrl("/pay/");
    }
    
    return "";
});

lpMVC::bind('^/commit/virtualhost/?',function(){
    require_once("handler/virtualhost.php");
    return new VirtualHost;
});

lpMVC::bind('^/pay/?',function(){
    require_once("template/pay.php");
    return "";
});

lpMVC::bind('^/login/?',function()
{
    require_once("handler/user.php");
    return new Login;
});

lpMVC::bind('^/logout/?',function()
{
    require_once("handler/user.php");
    return new Logout;
});

lpMVC::bind('^/signup/?',function()
{
    require_once("handler/user.php");
    return new Signup;
});

lpMVC::onDefault(function()
{
    return "404 - 不存在对应的处理器";
});

?>
