
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

CREATE TABLE `ticket` (
  `id`         INT(11)          NOT NULL AUTO_INCREMENT,
  `reply`      INT(11)          NOT NULL,
  `time`       INT(10) UNSIGNED NOT NULL,
  `uname`      TEXT             NOT NULL,
  `type`       TEXT             NOT NULL,
  `settings`   TEXT             NOT NULL,
  `status`     TEXT             NOT NULL,
  `content`    TEXT             NOT NULL,
  `title`      TEXT             NOT NULL,
  `lastchange` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8