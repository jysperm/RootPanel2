CREATE TABLE IF NOT EXISTS `lpTrachAuth` (
  `id`               INT(11)          NOT NULL AUTO_INCREMENT,
  `user`             VARCHAR(255)     NOT NULL,
  `token`            TEXT             NOT NULL,
  `lastactivitytime` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;

CREATE TABLE IF NOT EXISTS `User` (
  `id`            INT(11)          NOT NULL AUTO_INCREMENT,
  `uname`         TEXT             NOT NULL,
  `passwd`        TEXT             NOT NULL,
  `lastlogintime` INT(10) UNSIGNED,
  `lastloginip`   TEXT,
  `email`         TEXT             NOT NULL,
  `qq`            TEXT             NOT NULL,
  `regtime`       INT(11)          NOT NULL,
  `lastloginua`   TEXT,
  `type`          TEXT             NOT NULL,
  `expired`       INT(10) UNSIGNED NOT NULL,
  `settings`      TEXT             NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;

CREATE TABLE IF NOT EXISTS `Log` (
  `id`     INT(11)          NOT NULL AUTO_INCREMENT,
  `time`   INT(10) UNSIGNED NOT NULL,
  `type`   TEXT             NOT NULL,
  `info`   TEXT             NOT NULL,
  `uname`  TEXT             NOT NULL,
  `detail` TEXT             NOT NULL,
  `by`     TEXT             NOT NULL,
  `ua`     TEXT             NOT NULL,
  `ip`     TEXT             NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;

CREATE TABLE IF NOT EXISTS `VirtualHost` (
  `id`         INT(11)          NOT NULL AUTO_INCREMENT,
  `uname`      TEXT             NOT NULL,
  `domains`    TEXT             NOT NULL,
  `lastchange` INT(10) UNSIGNED NOT NULL,
  `general`    TEXT             NOT NULL,
  `source`     TEXT             NOT NULL,
  `type`       TEXT             NOT NULL,
  `settings`   TEXT             NOT NULL,
  `ison`       INT(11)          NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  AUTO_INCREMENT = 1;
