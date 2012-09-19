<?php

require_once("./LightPHP/lp-load.php");
require_once("config.php");


require_once("handler/view.php");

lpMVC::bind('^/$',function(){
    lpTemplate::parseFile("template/index.php");
    return "";
});

lpMVC::onDefault(function()
{
    return "404 - 不存在对应的处理器";
});

?>
