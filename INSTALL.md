## 安装
RootPanel 的安装是透明的，无需使用完全纯净的系统来进行安装，只需保证相应软件包都存在即可。

### 操作系统

目前支持 Debain 系的 Linux 发行版，以下发行版将作为首选的测试对象：

* Debain 7
* Ubuntu 12.04

### 准备工作
(如果需要的话)

* 挂载磁盘分区
* 上传公钥
* 生成 SSL 密钥对

### Debain 6

/etc/apt/sources.list

新增：

    deb http://packages.dotdeb.org squeeze all
    deb-src http://packages.dotdeb.org squeeze all

    deb http://packages.dotdeb.org squeeze-php54 all
    deb-src http://packages.dotdeb.org squeeze-php54 all

## 软件包

    apt-get install sudo

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
    # MySQL, Memcached
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

    adduser rpadmin
    usermod -G rpadmin -a www-data

### 系统设置

    a2enmod rewrite
    cp -r /usr/share/phpmyadmin /RootPanel/web/

    mkdir -p /var/tmp/nginx/cache
    ln -s /usr/lib/insserv/insserv /sbin/insserv

    chkconfig memcached off
    chkconfig mongodb off

    hostname NODE.rpvhost.net
    echo "NODE.rpvhost.net" > /etc/hostname
    echo "127.0.0.1 NODE.rpvhost.net" >> /etc/hosts

    chown -R rpadmin:rpadmin /RootPanel
    chmod -R 770 /RootPanel

    quotacheck -acuv -a
    quotaon -av

* 参照 EDIT-CONFIG.md 修改配置文件
* 重启服务器

* 登录 Phpmyadmin 建立数据库和帐号
* 修改 RootPanel 的配置文件
* 访问 `/install/` 创建数据库结构
* 注册管理员帐号



