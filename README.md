
    
### 系统设置
    
    chown -R rpadmin:rpadmin /RootPanel
    chmod -R 770 /RootPanel

  
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

    

