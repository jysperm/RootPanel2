<?php

require_once("LightPHP/lp-load.php");
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
        
    if(isAllowPanel(lpAuth::getUName()))
    {
        lpTemplate::parseFile("template/panel.php");
    }
    else
    {
        gotoUrl("/pay/");
    }
    
    return "";
});

lpMVC::bind('^/admin/?',function(){
    global $rpAdminUsers;
    
    if(!lpAuth::login() || !in_array(lpAuth::getUName(),$rpAdminUsers))
    {
        gotoUrl("/login/");
        exit();
    }
        
    lpTemplate::parseFile("template/admin.php");
    return "";
});

lpMVC::bind('^/commit/virtualhost/?',function(){
    require_once("handler/virtualhost.php");
    return new VirtualHost;
});

lpMVC::bind('^/commit/admin/?',function(){
    require_once("handler/admin.php");
    return new Admin;
});

lpMVC::bind('^/pay/?',function(){
    require_once("template/pay.php");
    return "";
});

lpMVC::bind('^/request-free/?',function(){
    require_once("template/request-free.php");
    return "";
});

lpMVC::bind('^/manual/?',function(){
    require_once("template/manual.php");
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
