## 安装

### 操作系统

>   Ubuntu Server 12.04 64bit
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

### 克隆代码库

    apt-get install git
    cd /
    git clone git://github.com/jybox/RootPanel.git
    cd /RootPanel

### 更新安装软件包 配置文件

    /RootPanel/etc/install-packets.sh
    /RootPanel/etc/install-config.sh

### 创建用户

    adduser rpadmin
    usermod -G rpadmin -a www-data




