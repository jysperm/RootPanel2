<?php
    $phps=explode(" ",trim(str_replace("  "," ",$v["php"])));
    $cgis=explode(" ",trim(str_replace("  "," ",$v["cgi"])));
    $scripts=implode("|",array_merge($phps,$cgis));
    $statics=implode("|",explode(" ",trim(str_replace("  "," ",$v["static"]))));
	if(substr($scripts,strlen($scripts)-2)=="|")
		$scripts=substr($scripts,0,strlen($scripts)-1);
    $alias=json_decode($v["alias"],true);
?>
server {
    listen <?= $v["isssl"]?443:80; ?><?= $v["isssl"]?" ssl":""; ?>;
    server_name <?= $v["domains"]; ?>;
    
    <? if($v["isssl"]): ?>
    ssl                  on;
    ssl_certificate      <?= $v["sslcrt"]; ?>;
    ssl_certificate_key  <?= $v["sslkey"]; ?>;
    <? endif; ?>
    
    access_log <?= $v["nginxaccess"]; ?>;
    error_log <?= $v["nginxerror"]; ?>;
    
    <? if($v["template"]=="web" || $v["template"]=="python"): ?>
    
    root <?= $v["root"]; ?>;
    index <?= $v["indexs"]; ?>;
    
        <? if($v["autoindex"]): ?>
        autoindex on;
        <? endif; ?>
    
    <? endif; ?>
    
    <? if($v["template"]=="web"): ?>
    
        <? if($v["type"]=="all"): ?>
        location / {
            proxy_pass http://127.0.0.1:8080;
        }
        <? endif; ?>
        
        
        <? if($v["type"]=="only"): ?>
        location / {
            try_files $uri $uri/ <?= $v["is404"]?"@apache":"=404"?>;
        }
            
            <? if($v["is404"]): ?>
            location = / {
                proxy_pass http://127.0.0.1:8080;
            }
            <? endif; ?>
            location ~ \.(<?= $scripts;?>)$ {
                proxy_pass http://127.0.0.1:8080;
            }
            
        <? endif; ?>
        
        <? if($v["type"]=="unless"): ?>
        location / {
            proxy_pass http://127.0.0.1:8080;
        }
        
        location = / {
            proxy_pass http://127.0.0.1:8080;
        }
		
		
        <? if($statics): ?>
        location ~ \.(<?= $statics;?>)$ {
            try_files $uri  =404;
        }
        <? endif; ?>
		
        <? endif; ?>
        
    <? endif; ?>
    
    
    <? if($v["template"]=="python"): ?>
    location / {
        proxy_pass http://127.0.0.1:8080;
    }
    <? endif; ?>
    
    
    <? if($v["template"]=="proxy"): ?>
    location / {
        proxy_set_header Host $host;
        proxy_redirect off;
        proxy_pass <?= $v["root"]; ?>;
    }
    <? endif; ?>
    
    <? foreach($alias as $k => $v): ?>
    location <?= $k;?> {
        alias <?= $v;?>;
    }
    <? endforeach; ?>
    
    location @apache {
        proxy_pass http://127.0.0.1:8080;
    }

    location ~ /\.(ht|git) {
        deny  all;
    }
}
