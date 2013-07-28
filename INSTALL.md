## 安装
并非一定要使用纯净的操作系统来安装, 但要保证相应的包都存在.

### 操作系统

>   Ubuntu Server 12.04 LTS
>   ftp://ftp.sjtu.edu.cn/ubuntu-cd/precise/ubuntu-12.04.1-server-amd64.iso

### 准备工作

* 挂载磁盘分区
* 上传公钥

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
    pecl install apc mongo memcache
    # MySQL, Memcached, PPTPD
    apt-get purge exim4
    apt-get install mysql-server mysql-client phpmyadmin memcached pptpd mongodb sendmail-bin
    # 工具
    apt-get install screen git wget zip unzip iftop unrar-free axel vim emacs subversion subversion-tools curl chkconfig ntp quota quotatool tmux mercurial
    # Python
    apt-get install python python-dev libapache2-mod-wsgi python-setuptools python-pip libapache2-mod-python
    pip install django tornado markdown python-memcached web.py mongo uwsgi virtualenv virtualenvwrapper
    # C/C++ Dev
    apt-get install g++ gcc clang cmake

    # Go NodeJS 二进制包

### 克隆代码库

    cd /
    git clone git://github.com/jybox/RootPanel.git

### 创建用户

    adduser rpadmin
    usermod -G rpadmin -a www-data

### 系统设置

    a2enmod rewrite
    cp -r /usr/share/phpmyadmin /RootPanel/web/

    mkdir -p /var/tmp/nginx/cache
    ln -s /usr/lib/insserv/insserv /sbin/insserv

    chkconfig memcached off
    chkconfig mongodb off

    hostname NODE.jybox.net
    echo "NODE.jybox.net" > /etc/hostname
    echo "127.0.0.1 NODE.jybox.net" >> /etc/hosts

    chown -R rpadmin:rpadmin /RootPanel
    chmod -R 770 /RootPanel

* 参照 EDIT-CONFIG.md 修改配置文件
* 重启服务器
* 登录 Phpmyadmin 建立数据库和帐号
* 修改 RootPanel 的配置文件
* 访问 `/install/` 创建数据库结构
* 注册管理员帐号



