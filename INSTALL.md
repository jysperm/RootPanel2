## 安装
并非一定要使用纯净的操作系统来安装, 但要保证相应的包都存在.

### 操作系统

>   Ubuntu Server 12.04
>   ftp://ftp.sjtu.edu.cn/ubuntu-cd/precise/ubuntu-12.04.1-server-amd64.iso

务必使用原版的Ubuntu Server 12.04

### 挂载磁盘

有些服务器有两个磁盘分区，分别用于 `/` 和 `/home`

### 上传公钥 修改root密码

本地：
    ~/.ssh/id_rsa.pub

服务器：
    ~/.ssh/authorized_keys

    chmod -R 600 ~/.ssh

### 更新安装软件包

    apt-get update
    apt-get install python-software-properties

    add-apt-repository ppa:ondrej/php5
    add-apt-repository ppa:nginx/development

    apt-get update
    apt-get upgrade

    # Nginx, Apache2, PHP-FPM
    apt-get install nginx php5-cli php5-fpm php-pear build-essential libpcre3-dev apache2-mpm-itk apache2-dev libapache2-mod-php5 php5-dev
    # PHP 扩展
    apt-get install php5-mysql php5-curl php5-gd php-pear php5-imagick php5-imap php5-mcrypt php5-memcache php5-ming php5-pspell php5-recode php5-snmp php5-tidy php5-xmlrpc php5-sqlite php5-xsl
    pecl install apc mongo
    # MySQL, Memcached, PPTPD
    apt-get install mysql-server mysql-client phpmyadmin memcached pptpd mongodb
    # 工具
    apt-get install screen git wget zip unzip iftop unrar-free axel vim emacs subversion subversion-tools curl chkconfig ntp snmpd quota quotatool tmux mercurial
    # Python
    apt-get install python python-dev libapache2-mod-wsgi python-setuptools python-pip libapache2-mod-python
    pip install django tornado markdown python-memcached web.py mongo uwsgi virtualenv virtualenvwrapper
    # C/C++ Dev
    apt-get install g++ gcc clang cmake

    # Go NodeJS 二进制包

### 克隆代码库

    cd /
    git clone git://github.com/jybox/RootPanel.git
    cd /RootPanel

### 创建用户

    adduser rpadmin
    usermod -G rpadmin -a www-data




