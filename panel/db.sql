--日志表，所有操作都会产生一条日志
CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` int(10) unsigned NOT NULL,
  `uname` text NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uname` text NOT NULL,
  `passwd` text NOT NULL,
  `lastlogintime` int(10) unsigned NOT NULL,
  `lastloginip` text NOT NULL,
  `email` text NOT NULL,
  `regtime` int(10) unsigned NOT NULL,
  `lastloginua` text NOT NULL,
--该用户的类型，取值：no（未开通）、std（标准用户）、ext（额外技术支持）、free（试用用户）
  `type` text NOT NULL,
--该用户的到期时间
  `expired` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--Web服务中的虚拟主机表
CREATE TABLE IF NOT EXISTS `virtualhost` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uname` text NOT NULL,
--虚拟主机的模板，取值：web（常规Web/PHP等CGI脚本）、proxy（反向代理）、python（Python WSGI）
  `template` text NOT NULL,
--与其绑定的域名，以空格隔开，仅可以在域名的开头有`*.`形式的通配符，其他位置不能有通配符或其他特殊字符
--同一时间，一个域名只能与一个虚拟主机绑定
  `domains` text NOT NULL,
--上次修改设置的时间
  `lastchange` int(10) unsigned NOT NULL,
  `time` int(10) unsigned NOT NULL,
--Alias别名，json，键值对应形式
  `alias` text NOT NULL,
--首页文件的次序，template=proxy时无效,空格隔开
  `indexs` text NOT NULL,
--是否在没有首页的情况下显示文件列表，template=proxy时无效，取值：0、1
  `autoindex` int(11) NOT NULL,
--apache access日志路径，仅能位于用户的home目录，或/dev/null
  `apacheaccess` text NOT NULL,
--apache error路径，同上
  `apacheerror` text NOT NULL,
--nginx access路径，同上
  `nginxaccess` text NOT NULL,
--nginx error路径，同上
  `nginxerror` text NOT NULL,
--是否开启SSL，取值：0、1
  `isssl` int(11) NOT NULL,
--ssl证书路径，仅能位于用户的home目录
  `sslcrt` text NOT NULL,
--ssl私玥路径，仅能位于用户的home目录
  `sslkey` text NOT NULL,
--template=web或python时为web根目录，仅能位于用户的home目录;template=proxy时为被代理的url
  `root` text NOT NULL,
--仅当template=web时有效，取值：all（全部转到apache）、only（仅转发与`php`、`cgi`、`is404`匹配的url）、unless（除了`static`制定的url，其他的都转发）
  `type` text NOT NULL,
--仅当type=only时有效，作为php处理的扩展名，以空格隔开
  `php` text NOT NULL,
--仅当type=only时有效，作为cgi处理的扩展名，以空格隔开
  `cgi` text NOT NULL,
--仅当type=only时有效，是否转发404（文件不存在）的请求，取值：0、1
  `is404` int(11) NOT NULL,
--仅当type=static，不转发的扩展名，空格隔开
  `static` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
