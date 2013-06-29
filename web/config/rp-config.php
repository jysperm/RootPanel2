<?php

$rpCfg["Version"]["main"] = "2.0.2 B";
$rpCfg["Version"]["time"] = "2013.6.8";
$rpCfg["Version"]["type"] = "of";

$rpCfg["DefaultLanguage"] = "zh_CN";

// 每页显示日志条数
$rpCfg["LogPerPage"] = 30;
// 每页显示工单条数
$rpCfg["TKPerPage"] = 15;

// Gravatar基准URL
$rpCfg["GravaterURL"] = "http://www.gravatar.com/avatar/";
$rpCfg["GravaterURL"] = "http://ruby-china.org/avatar/";

// ----- 覆盖LightPHP的配置

$lpCfg["LightPHP"]["Mode"] = "debug";

return $rpCfg;
