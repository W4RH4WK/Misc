CREATE TABLE IF NOT EXISTS `CustomPage` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) COLLATE utf8_bin NOT NULL,
  `text` text COLLATE utf8_bin NOT NULL,
  `markdown` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

INSERT INTO `CustomPage` (`id`, `name`, `text`, `markdown`) VALUES
(1, 'Home', '# Welcome\r\n\r\nThis is Another Stupid CMS. Checkout the Source'' on Github  \r\n<http://github.com/W4RH4WK/AS-CMS>\r\n\r\n## Features\r\n - Custom page creation with HTML or markdown\r\n - Gallery with automatic thumbnail creation (organized with tags)\r\n - Multiple Navigation bars (manageable through admin area)\r\n - Admin user management with simple permissions\r\n - Installer so you can add components after the original setup\r\n - Link alias (permanent shortcuts)\r\n - RSS feeds\r\n\r\n## Screen shots\r\n<div id="carousel" class="carousel slide">\r\n    <div class="carousel-inner">\r\n        <div class="active item">\r\n            <img src="inc/Gallery/up/adminnavigation.png" />\r\n        </div>\r\n        <div class="item">\r\n            <img src="inc/Gallery/up/adminusers.png" />\r\n        </div>\r\n        <div class="item">\r\n            <img src="inc/Gallery/up/dropdown.png" />\r\n        </div>\r\n        <div class="item">\r\n            <img src="inc/Gallery/up/gallery.png" />\r\n        </div>\r\n        <div class="item">\r\n            <img src="inc/Gallery/up/galleryediting.png" />\r\n        </div>\r\n        <div class="item">\r\n            <img src="inc/Gallery/up/home.png" />\r\n        </div>\r\n        <div class="item">\r\n            <img src="inc/Gallery/up/login.png" />\r\n        </div>\r\n        <div class="item">\r\n            <img src="inc/Gallery/up/navigationediting.png" />\r\n        </div>\r\n        <div class="item">\r\n            <img src="inc/Gallery/up/pagecreation.png" />\r\n        </div>\r\n    </div>\r\n    <a class="carousel-control left" href="#carousel" data-slide="prev">‹</a>\r\n    <a class="carousel-control right" href="#carousel" data-slide="next">›</a>\r\n</div>\r\n<script type="text/javascript">\r\n    $(".carousel").carousel()\r\n</script>', 1),
(2, 'md test', '# Markdown Test\r\n\r\n## General\r\n\r\nThis page uses markdown to markup the text.\r\nYou can have *italic* or **bold** text.\r\n\r\nKeep blank lines between text to separate paragraphs\r\n\r\n## line break\r\n\r\nIn order to force a linebreak  \r\nadd 2 spaces to the end of the line you want to break\r\n\r\n## Links\r\n\r\nLinks can be inserted directly like <http://example.com/> or [aliased](http://example.com/)\r\n\r\n## Lists\r\n\r\n1. This\r\n2. List\r\n3. Is\r\n4. Sorted\r\n\r\n- This\r\n- List\r\n- Is\r\n- Not\r\n- Sorted\r\n\r\n## blocks\r\n\r\n> text can be \r\n> aligned in a block\r\n> to add some special\r\n> style (you need to force line breaks)\r\n\r\n## horizontal line\r\n\r\n---', 1),
(3, 'no md test', '<h1>No Markdown Test</h1>\r\n\r\n<h2>General</h2>\r\n\r\n<p>This page does not use markdown to markup the text.\r\nIn order to do this, standard HTML is used.\r\nYou can have <i>italic</i> or <b>bold</b> text.</p>\r\n\r\n<p>paragraphs need to be added by hand</p>\r\n\r\n<h2>line break</h2>\r\n\r\n<p>In order to force a linebreak  <br />\r\nuse the &lt;br&gt; tag.</p>\r\n\r\n<h2>Links</h2>\r\n\r\n<p>In order to add a link, you have to use the &lt;a&gt; tag. <a href="http://example.com/">alias is possible of course</a></p>\r\n\r\n<h2>Lists</h2>\r\n\r\n<ol>\r\n  <li>This</li>\r\n  <li>List</li>\r\n  <li>Is</li>\r\n  <li>Sorted</li>\r\n</ol>\r\n\r\n<ul>\r\n  <li>This</li>\r\n  <li>List</li>\r\n  <li>Is</li>\r\n  <li>Not</li>\r\n  <li>Sorted</li>\r\n</ul>\r\n\r\n<h2>blocks</h2>\r\n\r\n<blockquote>\r\ntext can be \r\naligned in a block\r\nto add some special\r\nstyle (you need to force line breaks)\r\n</blockquote>\r\n\r\n<h2>horizontal line</h2>\r\n\r\n<hr />', 0),
(4, 'from Word', '<h1>\r\n    Word Test\r\n</h1>\r\n<h2>\r\n    General\r\n</h2>\r\n<p>\r\n    This page is created in word and imported in the page afterwards. This text can be <em>italic</em> or <strong>bold</strong>.\r\n</p>\r\n<p>\r\n    Paragraphs behave the same way.\r\n</p>\r\n<h2>\r\n    line break\r\n</h2>\r\n<p>\r\n    use &lt;shift&gt; + &lt;return&gt; to add\r\n    <br/>\r\n    a linebreak\r\n</p>\r\n<h2>\r\n    Links\r\n</h2>\r\n<p>\r\n    Links can also be created and <a href="http://example.org/">aliased</a>.\r\n</p>\r\n<h2>\r\n    Lists\r\n</h2>\r\n<p>\r\n    1. This\r\n</p>\r\n<p>\r\n    2. List\r\n</p>\r\n<p>\r\n    3. Is\r\n</p>\r\n<p>\r\n    4. Sorted\r\n</p>\r\n<ul>\r\n    <li>\r\n        This\r\n    </li>\r\n    <li>\r\n        List\r\n    </li>\r\n    <li>\r\n        Is\r\n    </li>\r\n    <li>\r\n        Not\r\n    </li>\r\n    <li>\r\n        Sorted\r\n    </li>\r\n</ul>', 0);