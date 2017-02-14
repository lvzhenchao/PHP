CREATE TABLE `post` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `title` char(255) NOT NULL,
  `content` text NOT NULL,
  `ctime` int(11) NOT NULL,
  `count` int(11) NOT NULL,
  `elite` enum('0','1') DEFAULT '0',
  `top` enum('0','1') DEFAULT '0',
  `recycle` enum('0','1') DEFAULT '0',
  `reply` enum('0','1') DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `content` text NOT NULL,
  `ctime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(20) NOT NULL,
  `pid` int(11) NOT NULL DEFAULT '0',
  `path` char(255) NOT NULL DEFAULT '0',
  `ico` char(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userName` char(20) NOT NULL,
  `password` char(32) NOT NULL,
  `auth` enum('0','1') NOT NULL DEFAULT '0',
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `score` int(11) NOT NULL DEFAULT '50',
  `lastLogTime` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`userName`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `userdetail` (
  `id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` char(50) NOT NULL,
  `email` char(50) DEFAULT NULL,
  `qq` int(11) DEFAULT NULL,
  `photo` char(255) DEFAULT 'default.jpg',
  `info` char(255) DEFAULT '这个人很懒，什么都没留下。',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

