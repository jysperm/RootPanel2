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
    apt-get install screen git wget zip unzip iftop rar unrar axel vim emacs subversion subversion-tools
    apt-get install python python-dev libapache2-mod-wsgi python-setuptools python-pip libapache2-mod-python python-virtualenv
    
    pip install django tornado
    
### 创建用户

    adduser rpadmin

### 克隆代码库

    cd /
    git clone git://github.com/jybox/RootPanel.git
	cd /RootPanel
	git submodule update --init
    
### 软件包设置

    a2enmod rewrite
    cp -r /usr/share/phpmyadmin /RootPanel/panel/
    
    chown -R rpadmin:rpadmin /RootPanel
    chmod -R 770 /RootPanel
	
	mkdir -p /root/log
	
	证书/私钥分别放在`/RootPanel/rp.jybox.net.crt`/`/RootPanel/rp.jybox.net.key`
    
### 配置文件

    cd RootPanel/etc
    cp /etc/apache2/apache2.conf /etc/apache2/apache2.conf.old
    cp apache2/apache2.conf /etc/apache2/apache2.conf
    cp /etc/apache2/ports.conf /etc/apache2/ports.conf.old
    cp apache2/ports.conf /etc/apache2/ports.conf
    cp /etc/apache2/sites-enabled/000-default /etc/apache2/sites-enabled/000-default.old
    cp apache2/sites-enabled/000-default /etc/apache2/sites-enabled/000-default
    cp /etc/apache2/sites-enabled/00000-rphost /etc/apache2/sites-enabled/00000-rphost.old
    cp apache2/sites-enabled/00000-rphost /etc/apache2/sites-enabled/00000-rphost
    cp /etc/nginx/nginx.conf /etc/nginx/nginx.conf.old
    cp nginx/nginx.conf /etc/nginx/nginx.conf
    cp /etc/nginx/sites-enabled/default /etc/nginx/sites-enabled/default.old
    cp nginx/sites-enabled/default /etc/nginx/sites-enabled/default
    cp /etc/nginx/sites-enabled/00000-rphost /etc/nginx/sites-enabled/00000-rphost.old
    cp nginx/sites-enabled/00000-rphost /etc/nginx/sites-enabled/00000-rphost
    cp /etc/sudoers /etc/sudoers.old
    cp sudoers /etc/sudoers
	
    
### 重启服务器

    service nginx restart
    service apache2 restart
    
### 数据库

    在PHPMyAdmin导入 `panel/db.sql`
    在 `panel/config.php` 修改数据库连接信息，建议数据库名使用`rpadmin`
    
### 设置站点

* 登录网站，注册`rpadmin`，该用户为管理员.

## 待办

* PHP配置文件

    

