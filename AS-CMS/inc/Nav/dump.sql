-- NavLink

CREATE TABLE IF NOT EXISTS `NavLink` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menu` int(10) unsigned NOT NULL DEFAULT '1',
  `label` varchar(256) COLLATE utf8_bin NOT NULL,
  `link` text COLLATE utf8_bin NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=6 ;

INSERT INTO `NavLink` (`id`, `menu`, `label`, `link`, `sort`) VALUES
(1, 1, 'Home', '?run=CustomPage&id=1', 0),
(2, 2, 'Markdown', '?run=CustomPage&id=2', 0),
(3, 2, 'No Markdown', '?run=CustomPage&id=3', 1),
(4, 2, 'from Word', '?run=CustomPage&id=4', 2),
(5, 1, 'Gallery', '?run=Gallery', 2);

-- NavMenu

CREATE TABLE IF NOT EXISTS `NavMenu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(256) COLLATE utf8_bin NOT NULL,
  `parent` int(10) unsigned NOT NULL DEFAULT '1',
  `sort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `label` (`label`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

INSERT INTO `NavMenu` (`id`, `label`, `parent`, `sort`) VALUES
(1, 'root', 0, 0),
(2, 'Pages', 1, 1);
