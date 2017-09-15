CREATE TABLE IF NOT EXISTS `Gallery` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tag` varchar(256) COLLATE utf8_bin NOT NULL,
  `files` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag` (`tag`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

INSERT INTO `Gallery` (`id`, `tag`, `files`) VALUES
(1, 'Adminarea', 'adminnavigation.png:adminusers.png:galleryediting.png:login.png:navigationediting.png:pagecreation.png'),
(2, 'Page', 'dropdown.png:gallery.png:home.png');
