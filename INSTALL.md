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
    add-apt-repository ppa:stevecrozz/ppa

    apt-get update
    apt-get upgrade

    # Nginx, Apache2, PHP-FPM
    apt-get install -qq nginx php5-cli php5-fpm php-pear build-essential libpcre3-dev apache2-mpm-itk apache2-dev libapache2-mod-php5 php5-dev
    # PHP 扩展
    apt-get install -qq php5-mysql php5-curl php5-gd php-pear php5-imagick php5-imap php5-mcrypt php5-memcache php5-ming php5-pspell php5-recode php5-snmp php5-tidy php5-xmlrpc php5-sqlite php5-xsl
    pecl install apc mongo
    # MySQL, Memcached, PPTPD
    apt-get install -qq mysql-server mysql-client phpmyadmin memcached pptpd mongodb
    # 工具
    apt-get install -qq screen git wget zip unzip iftop unrar-free axel vim emacs subversion subversion-tools curl chkconfig ntp snmpd quota quotatool tmux
    # Python
    apt-get install -qq python python-dev libapache2-mod-wsgi python-setuptools python-pip libapache2-mod-python python-virtualenv uwsgi
    pip install django tornado markdown python-memcached web.py mongo
    # C/C++ Dev
    apt-get install -qq g++ gcc clang cmake

    # Ruby
    \curl -L https://get.rvm.io | bash -s stable --ruby
    source /usr/local/rvm/scripts/rvm
    rvm install 1.9.3
    rvm install 1.8.7

### 克隆代码库

    cd /
    git clone git://github.com/jybox/RootPanel.git
    cd /RootPanel

### 更新安装软件包 配置文件

    bash /RootPanel/etc/install-config.sh

### 创建用户

    adduser rpadmin
    usermod -G rpadmin -a www-data




