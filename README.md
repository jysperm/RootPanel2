# RootPanel
## 使用
### 操作系统

    Ubuntu Server 12.04 64bit

>ftp://ftp.sjtu.edu.cn/ubuntu-cd/precise/ubuntu-12.04.1-server-amd64.iso

### 更新软件包

    apt-get update
    apt-get upgrade
    
### 安装软件包

    apt-get install apache2-mpm-itk apache2-dev php5 php5-cgi php5-cli libapache2-mod-php
    apt-get install php5-mysql php5-curl php5-gd php5-idn php-pear php5-imagick php5-imap php5-mcrypt php5-memcache php5-mhash php5-ming php5-pspell php5-recode php5-snmp php5-tidy php5-xmlrpc php5-sqlite php5-xsl
    apt-get install nginx mysql-server mysql-client phpmyadmin
    apt-get install screen git wget zip unzip iftop
    apt-get install python python-dev libapache2-mod-wsgi python-setuptools python-pip libapache2-mod-python python-virtualenv
    
    pip install django tornado
    
### 软件包设置

    a2enmod rewrite

### 克隆代码库

    cd /root
    git clone git://github.com/jybox/RootPanel.git

### 符号链接

    ln -s RootPanel /RootPanel
    

