CREATE TABLE IF NOT EXISTS `#__jmap` (
		  `id` int(11) unsigned NOT NULL auto_increment,
		  `type` varchar(100) NOT NULL,
		  `name` text NOT NULL,
		  `description` text NOT NULL,
		  `checked_out` int(11) unsigned NOT NULL default '0',
		  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
		  `published` tinyint(1) NOT NULL default '0',
		  `ordering` int(11) NOT NULL default '0',
		  `sqlquery` text NULL,
		  `sqlquery_managed` text NULL,
		  `params` text NOT NULL,
		  PRIMARY KEY  (`id`),
		  KEY `published` (`published`)
		) ENGINE=MyISAM ;

INSERT INTO `#__jmap` (`id`, `type`, `name`, `description`, `checked_out`, `checked_out_time`, `published`, `ordering`, `sqlquery`, `sqlquery_managed`, `params`) VALUES (1, 'content', 'Content', 'Default contents source', 0, '0000-00-00 00:00:00', 1, 1, '', '', '');