
    
### 系统设置
    
    chown -R rpadmin:rpadmin /RootPanel
    chmod -R 770 /RootPanel
    
### 重启服务器

    service apache2 restart
    service nginx restart
    
### 数据库

在PHPMyAdmin新建用户`rpadmin`，赋予全局权限，创建同名数据库导入 `panel/db.sql`.
  
### 软件包设置

* /RootPanel/panel/config.php
* /etc/fstab

    /dev/sdb1 /home ext3 defaults,usrquota 0 0
    
重启

### 磁盘配额

    quotacheck -uvag /home
    quotaon -av

### 监控

* Apache2 http://0status.rp2.jybox.net/server-status
* Nginx http://0status.rp2.jybox.net/nginx-status
    
### 设置站点

* 登录网站，注册`rpadmin`，`rpadmin`用户为管理员.

    

