
    
### 系统设置

    a2enmod rewrite
    cp -r /usr/share/phpmyadmin /RootPanel/panel/
  
    mkdir -p /root/log
    mkdir -p /var/tmp/nginx/cache
    ln -s /usr/lib/insserv/insserv /sbin/insserv
    
    chkconfig memcached off
    
    hostname rp2.jybox.net
    echo "rp2.jybox.net" > /etc/hostname
    echo "127.0.0.1 rp2.jybox.net" > /etc/hosts
    
证书/私钥分别放在`/RootPanel/rp2.jybox.net.crt`/`/RootPanel/rp2.jybox.net.key`
    
### 配置文件

    cd /RootPanel/etc
    
    rm -r /etc/apache2/sites-enabled/*
    rm -r /etc/nginx/sites-enabled/*
    
    ./cp-etc.sh
    
### 系统设置
    
    chown -R rpadmin:rpadmin /RootPanel
    chmod -R 770 /RootPanel
    
### 重启服务器

    service apache2 restart
    service nginx restart
    
### 数据库

在PHPMyAdmin新建用户`rpadmin`，赋予全局权限，创建同名数据库导入 `panel/db.sql`.
  
### 软件包设置

* /etc/snmp/snmpd.conf
* /RootPanel/panel/config.php
* /etc/fstab

    /dev/sdb1 /home ext3 defaults,usrquota 0 0
    
重启

### 磁盘配额

    quotacheck -uvag /home
    quotaon -av
    
### PPTP

* /etc/rc.local

    iptables -t nat -A POSTROUTING -o eth0 -j MASQUERADE

### 监控

* Apache2 http://0status.rp2.jybox.net/server-status
* Nginx http://0status.rp2.jybox.net/nginx-status
    
### 设置站点

* 登录网站，注册`rpadmin`，`rpadmin`用户为管理员.

    

