# RootPanel
## 使用
### 操作系统

>`Ubuntu Server 12.04 64bit`  
>ftp://ftp.sjtu.edu.cn/ubuntu-cd/precise/ubuntu-12.04.1-server-amd64.iso

### 更新软件包

    apt-get update
    apt-get upgrade
    
### 安装软件包

    apt-get install apache2-mpm-itk apache2-dev php5 php5-cgi php5-cli libapache2-mod-php5
    apt-get install php5-mysql php5-curl php5-gd php5-idn php-pear php5-imagick php5-imap php5-mcrypt php5-memcache php5-mhash php5-ming php5-pspell php5-recode php5-snmp php5-tidy php5-xmlrpc php5-sqlite php5-xsl
    apt-get install nginx mysql-server mysql-client phpmyadmin memcached
    apt-get install screen git wget zip unzip iftop rar unrar axel vim emacs subversion subversion-tools curl chkconfig ntp snmpd quota quotatool
    apt-get install python python-dev libapache2-mod-wsgi python-setuptools python-pip libapache2-mod-python python-virtualenv
    apt-get install g++ gcc qt4-dev-tools clang cmake
    apt-get install libevent-dev libnoise-dev
    
    pip install django tornado
    
### Ruby

    \curl -L https://get.rvm.io | bash -s stable --ruby
    
重新登录

    rvm install 1.9.3
    rvm install 1.8.7
    
### 创建用户

    adduser rpadmin
    usermod -G rpadmin -a www-data

### 克隆代码库

    cd /
    git clone git://github.com/jybox/RootPanel.git
    cd /RootPanel
    git submodule update --init
    
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

### 监控

* Apache2 http://0status.rp2.jybox.net/server-status
* Nginx http://0status.rp2.jybox.net/nginx-status
    
### 设置站点

* 登录网站，注册`rpadmin`，`rpadmin`用户为管理员.

    

