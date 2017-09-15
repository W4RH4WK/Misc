CREATE TABLE IF NOT EXISTS `Admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(256) COLLATE utf8_bin NOT NULL,
  `hash` varchar(256) COLLATE utf8_bin NOT NULL,
  `salt` varchar(256) COLLATE utf8_bin NOT NULL,
  `perm` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`user`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;
