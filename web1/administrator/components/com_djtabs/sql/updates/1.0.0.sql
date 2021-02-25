CREATE TABLE IF NOT EXISTS `#__djtabs_groups` (
   `id` int(10) unsigned not null auto_increment,
   `parent_id` int(10) unsigned not null default '0',
   `title` varchar(255) not null,
   `alias` varchar(255) not null,
   `image` varchar(255) not null,
   `description` text not null,
   `published` tinyint(1) not null default '0',
   `checked_out` int(10) unsigned not null default '0',
   `checked_out_time` datetime not null default '0000-00-00 00:00:00',
   `ordering` int(11) not null default '0',
   `params` text not null,
   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;

CREATE TABLE IF NOT EXISTS `#__djtabs_themes` (
   `id` int(11) not null auto_increment,
   `title` varchar(255) not null,
   `custom` tinyint(1) not null default '1',
   `random` tinyint(1) not null default '1',
   `published` tinyint(1) not null default '0',
   `ordering` int(11) not null default '0',
   `params` text not null,
   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;

CREATE TABLE IF NOT EXISTS `#__djtabs_items` (
   `id` int(11) not null auto_increment,
   `name` varchar(255) not null,
   `type` tinyint(4) not null,
   `group_id` int(11) not null,
   `ordering` int(11) not null,
   `params` text,
   `published` int(11) not null,
   PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;