<?php
    $domains=explode(" ",trim(str_replace("  "," ",$v["domains"])));
    $cgis=join(" .",explode(" ",trim(str_replace("  "," ",$v["cgi"]))));
    if(count($cgis))
        $cgis=join(" .",explode(" ",".".$cgis));
    $phps=join(" .",explode(" ",trim(str_replace("  "," ",$v["php"]))));
    if(count($phps))
        $phps=join(" .",explode(" ",".".$phps));
    $alias=json_decode($v["alias"],true);
    
    $apacheerror=$v["apacheerror"];
    $apacheaccess=$v["apacheaccess"];
    $uname=$v["uname"];
?>

<VirtualHost *:8080>
    ServerName <?= $domains[0]; ?>
    
    ServerAlias <?= $v["domains"]; ?>
  
    
    DirectoryIndex <?= $v["indexs"]; ?>
    
    Options <?= $v["autoindex"]?"+":"-"; ?>Indexes +ExecCGI

    <? if($v["template"]=="python"): ?>
    WSGIScriptAlias / <?= $v["root"]; ?>
    <? else: ?>
    DocumentRoot <?= $v["root"]; ?>
    <? endif; ?>

    <? foreach($alias as $k => $v): ?>
    Alias <?= $k;?> <?= $v;?>
    <? endforeach; ?>

    AddHandler cgi-script <?= $cgis; ?>
    
    AddHandler application/x-httpd-php <?= $phps; ?>
  
    ErrorLog <?= $apacheerror;?>
    
    LogLevel warn
    
    CustomLog <?= $apacheaccess; ?> combined
      
    AssignUserId <?= $uname; ?> <?= $uname; ?>
    
</VirtualHost>

