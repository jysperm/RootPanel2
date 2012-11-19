<? if($v["template"]!="proxy"): ?>
<?php
    $domains=explode(" ",trim(str_replace("  "," ",$v["domains"])));
    
    if($v["cgi"])
    {
        $cgis=join(" .",explode(" ",trim(str_replace("  "," ",$v["cgi"]))));
        $cgis=join(" .",explode(" ",".".$cgis));
    }
    else
    {
        $cgis=false;
    }
    if($v["php"])
    {
        $phps=join(" .",explode(" ",trim(str_replace("  "," ",$v["php"]))));
        $phps=join(" .",explode(" ",".".$phps));
    }
    else
    {
        $phps=false;
    }
        
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

    <? if($cgis): ?>
    AddHandler cgi-script <?= $cgis; ?>
    <? endif; ?>
    
    <? if($phps): ?>
    AddHandler application/x-httpd-php <?= $phps; ?>
    <? endif; ?>
  
    ErrorLog <?= $apacheerror;?>
    
    LogLevel warn
    
    CustomLog <?= $apacheaccess; ?> combined
      
    AssignUserId <?= $uname; ?> <?= $uname; ?>
    
</VirtualHost>
<? endif; ?>
