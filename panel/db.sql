CREATE TABLE IF NOT EXISTS `lptrackauth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) NOT NULL,
  `token` text NOT NULL,
  `lastactivitytime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uname` text NOT NULL,
  `passwd` text NOT NULL,
  `lastlogintime` int(10) unsigned NOT NULL,
  `lastloginip` text NOT NULL,
  `email` text NOT NULL,
  `qq` text NOT NULL,
  `regtime` int(11) NOT NULL,
  `lastloginua` text NOT NULL,
  `type` text NOT NULL,
  `expired` int(10) unsigned NOT NULL,
  `extconfnginx` text NOT NULL,
  `extconfapache` text NOT NULL,
  `pptppasswd` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` int(10) unsigned NOT NULL,
  `uname` text NOT NULL,
  `description` text NOT NULL,
  `detail` text NOT NULL,
  `by` text NOT NULL,
  `ua` text NOT NULL,
  `ip` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `virtualhost` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uname` text NOT NULL,
  `domains` text NOT NULL,
  `lastchange` int(10) unsigned NOT NULL,
  `alias` text NOT NULL,
  `indexs` text NOT NULL,
  `autoindex` int(11) NOT NULL,
  `isssl` int(11) NOT NULL,
  `sslcrt` text NOT NULL,
  `sslkey` text NOT NULL,
  `source` text NOT NULL,
  `type` text NOT NULL,
  `php` text NOT NULL,
  `cgi` text NOT NULL,
  `is404` int(11) NOT NULL,
  `static` text NOT NULL,
  `ison` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
