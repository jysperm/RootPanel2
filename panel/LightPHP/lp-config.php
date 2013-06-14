<?php

/**
 *   该文件包含了LightPHP的全部可修改的配置信息
 *   该文件会被 /lp-load.php 通过 require() 包含, 通常你不需要手动包含该文件.
 *   在你的应用中，你可以自行覆盖下面这些配置信息.
 *   该文件只会给变量赋值, 因此你可以在希望重置配置信息时, 手动重新包含该文件.
 *   但有的配置可能不会随着重新加载而改变, 因为它们已经被其他组件读取并使用了.
 *    只所以使用变量来储存这些配置, 是方便在使用LightPHP的程序中方便地覆盖这些配置, 而不必修改LightPHP的文件.
 * @package LightPHP
 */


// --------------- 经常修改的选项 ---------------

/**
 *   时区
 *   该选项用于设置默认时区, 该选项会被 /lp-load.php 读取并注册到PHP.
 *   经检查, PHP支持的时区列表中没有北京, 因此选用上海作为北京时间.
 *   http://cn2.php.net/manual/zh/timezones.asia.php
 */
$lpCfg["TimeZone"] = "Asia/Shanghai";

/**
 *  运行模式
 *  * debug 调试模式, 会开启详细的日志记录和错误提示
 *  * default 默认模式, 会输出错误提示
 *  * production 生产模式, 不会执行任何额外操作, 最高效地执行代码
 */

const lpDebug = 2;
const lpDefault = 1;
const lpProduction = 0;

$lpCfg["RunMode"] = "default";

/**
 *   LightPHP推荐的PHP最低版本
 *   LightPHP可能用到该版本的新特征, 或者做了依赖于该版本的假设.
 */
$lpCfg["RecommendedPHPVersion.LightPHP"] = "5.4.0";














/**
 *   lpSmtp 类的默认发信帐号.
 *   * host 发信服务器
 *   * address 发信地址
 *   * user 发信用户名
 *   * passwd 发信密码
 * @type array
 */
$lpCfg["lpSmtp"]["Default"] = [
    "host" => "smtp.163.com",
    "address" => "lightphp_test@163.com",
    "user" => "lightphp_test@163.com",
    "passwd" => "passwd123123"
];

/**
 *   lpClasssicAuth 类的Cookie安全码
 *   修改该项会导致所有已登录用户丢失登录状态.
 * @type string
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

$lpCfg["lpTrackAuth"]["CookieName"] = [
    "user" => "lp_tauth_user",
    "passwd" => "lp_tauth_token"
];

$lpCfg["lpTrackAuth"]["Limit"] = 30 * 24 * 3600;



return $lpCfg;
