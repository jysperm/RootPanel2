<?php

/**
*   该文件包含了LightPHP的全部可修改的配置信息
*
*   该文件会被 /lp-load.php 通过 require() 包含, 通常你不需要手动包含该文件.
*   在你的应用中，你可以自行覆盖下面这些配置信息.
*
*   该文件只会给变量赋值, 因此你可以在希望重置配置信息时, 手动重新包含该文件.
*   但有的配置可能不会随着重新加载而改变, 因为它们已经被其他组件读取并使用了.
*
*	只所以使用变量来储存这些配置, 是方便在使用LightPHP的程序中方便地覆盖这些配置, 而不必修改LightPHP的文件.
*
*   @package LightPHP
*/


// --------------- 经常修改的选项 ---------------


/**
*   时区
*
*   该选项用于设置默认时区, 该选项会被 /lp-load.php 读取并注册到PHP.
*
*   经检查, PHP支持的时区列表中没有北京, 因此选用上海作为北京时间.
*   http://cn2.php.net/manual/zh/timezones.asia.php
*
*   @type string
*/
$lpCfg["LightPHP"]["TimeZone"] = "Asia/Shanghai";


/**
 *  运行模式
 *
 *  * debug 调试模式, 会开启详细的日志记录和错误提示
 *  * default 默认模式, 会输出错误提示
 *  * production 生产模式, 不会执行任何额外操作, 最高效地执行代码
 */
$lpCfg["LightPHP"]["Mode"] = "default";

/**  
*   lpSmtp 类的默认发信帐号. 
*
*   * host 发信服务器
*   * address 发信地址
*   * user 发信用户名
*   * passwd 发信密码
*
*   @type array
*/
$lpCfg["lpSmtp"]["Default"] = [
    "host" => "smtp.163.com",
    "address" => "lightphp_test@163.com",
    "user" => "lightphp_test@163.com",
    "passwd" => "passwd123123"
];

/**
*	lpMySQLDrive 类的默认连接选项
*
*	* host 服务器IP或主机名(如`localhost`), 还可以指定端口(如`localhost:4567`), 也可以使用本地Socket(如`/var/run/mysqld/mysqld.sock`)
*	* dbname 数据库名
*	* user 数据库用户名
*	* passwd 数据库密码
*	* charset 数据库字符集
*
*	@type array
*/
$lpCfg["Default.lpMySQLDBDrive"] = [
	"host" => "localhost",
	"dbname" => "mydb",
	"user" => "myuser",
	"passwd" => "mypasswd",
	"charset" => "utf8"
];

/**
*   lpMongoDrive 类的默认连接选项
*
*   * host 服务器IP或主机名(如`localhost`), 还可以指定端口(如`localhost:4567`), 可以指定多个服务器
*   * dbname 数据库名
*   * user 数据库用户名
*   * passwd 数据库密码
*
*   @type array
*/
$lpCfg["lpMongoDBDrive"]["Default"] = [
    "host" => "localhost",
    "dbname" => "mydb",
    "user" => "",
    "passwd" => ""
];

/**
*   lpClasssicAuth 类的Cookie安全码
*
*   修改该项会导致所有已登录用户丢失登录状态.
*
*   @type string
*/
$lpCfg["lpClasssicAuth"]["SecurityCode"] = "140fd4bfdbd9a925fbf10245a58f603e541c9b82063b8339754aed509af11698";

$lpCfg["lpClassicAuth"]["GetPasswd"]["Default"] = [
    "table" => "user",
    "user" => "uname",
    "passwd" => "passwd"
];

$lpCfg["lpClassicAuth"]["CookieName"] = [
    "user" => "lp_cauth_user",
    "passwd" => "lp_cauth_token"
];

$lpCfg["lpClassicAuth"]["Limit"] = 30 * 24 * 3600;

$lpCfg["lpTrackAuth"]["GetPasswd"] = $lpCfg["lpClassicAuth"]["GetPasswd"];

$lpCfg["lpTrackAuth"]["Default"] = [
    "table" => "lptrackauth",
    "user" => "user",
    "token" => "token",
    "lastactivitytime" => "lastactivitytime"
];

/*
CREATE TABLE IF NOT EXISTS `lptrackauth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) NOT NULL,
  `token` text NOT NULL,
  `lastactivitytime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
*/

$lpCfg["lpTrackAuth"]["CookieName"] = [
    "user" => "lp_tauth_user",
    "passwd" => "lp_tauth_token"
];

$lpCfg["lpTrackAuth"]["Limit"] = 30 * 24 * 3600;

/**
*   关闭PHP版本号过低时显示的警告.
*
*   无论是为了安全、效率、享受新的特征, 你都应该将PHP更新到较新的版本.
*   http://cn2.php.net/downloads.php
*   http://cn2.php.net/manual/zh/install.php
*   当然如果在服务器上你没有更新软件的权限, 当我没说.
*
*   @see $lpCfg["RecommendedPHPVersion.LightPHP"]
*   @type bool
*/
$lpCfg["PHPVersion.TrunOff.Warning"] = false;






// --------------- 高级选项(请慎重修改) ---------------


/**
*   LightPHP推荐的PHP最低版本
*
*   LightPHP可能用到该版本的新特征, 或者做了依赖于该版本的假设.
*
*   @type string
*/
$lpCfg["RecommendedPHPVersion.LightPHP"] = "5.4.0";
