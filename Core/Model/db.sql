CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `passwd` text NOT NULL,
  `email` text NOT NULL,
  `contacts` text NOT NULL,
  `settings` text NOT NULL,
  `group` text NOT NULL,
  `signup_at` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `tokens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `token` varchar(40) NOT NULL,
  `accessed_at` int(11) unsigned NOT NULL,
  `status` text NOT NULL,
  `settings` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`token`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
