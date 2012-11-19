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
    apt-get install screen git wget zip unzip iftop rar unrar axel vim emacs subversion subversion-tools curl
    apt-get install python python-dev libapache2-mod-wsgi python-setuptools python-pip libapache2-mod-python python-virtualenv
    apt-get install g++ gcc qt4-dev-tools clang
    
    pip install django tornado
    
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
    
    hostname rp2.jybox.net
    echo "rp2.jybox.net" > /etc/hostname
    echo "127.0.0.1 rp2.jybox.net" > /etc/hosts
    
    证书/私钥分别放在`/RootPanel/rp2.jybox.net.crt`/`/RootPanel/rp2.jybox.net.key`
    
### 配置文件

    cd /RootPanel/etc
    
    cp apache2/apache2.conf /etc/apache2/apache2.conf
    cp apache2/ports.conf /etc/apache2/ports.conf
    rm -r /etc/apache2/sites-enabled/*
    cp apache2/sites-enabled/000-default /etc/apache2/sites-enabled/000-default
    cp apache2/sites-enabled/00000-rphost /etc/apache2/sites-enabled/00000-rphost
    
    cp nginx/nginx.conf /etc/nginx/nginx.conf
    rm -r /etc/nginx/sites-enabled/*
    cp nginx/sites-enabled/00000-rphost /etc/nginx/sites-enabled/00000-rphost
    
    cp php5/cli/conf.d/ming.ini /etc/php5/cli/conf.d/ming.ini
    cp php5/php.ini /etc/php5/apache2/php.ini
    cp php5/php.ini /etc/php5/cgi/php.ini

    cp sudoers /etc/sudoers
    
### 系统设置
    
    chown -R rpadmin:rpadmin /RootPanel
    chmod -R 770 /RootPanel
    
### 重启服务器

    service apache2 restart
    service nginx restart
    
### 数据库

    在PHPMyAdmin导入 `panel/db.sql`
    在 `panel/config.php` 修改数据库连接信息，建议数据库名使用`rpadmin`
    赋予rpadmin用户全局权限
    
### 设置站点

* 登录网站，注册`rpadmin`，`rpadmin`用户为管理员.

## 待办

* PHP配置文件

    

