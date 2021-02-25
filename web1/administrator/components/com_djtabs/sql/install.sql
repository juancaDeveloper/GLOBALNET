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

INSERT INTO  `#__djtabs_groups` (`id`, `title`, `alias`, `published`, `ordering`) VALUES ('1','Tabs1','tabs1','1','1');

INSERT INTO `#__djtabs_themes` (`id`, `title`, `custom`, `random`, `published`, `ordering`, `params`) VALUES 
('12', 'dj-custom2-blue', '1', '1', '1', '12', '{\"tb-nctv-bck-clr\":\"#302C2C\",\"tb-ctv-bck-clr\":\"#26ADE4\",\"tb-nctv-ttl-clr\":\"#F7F2EB\",\"tb-ctv-ttl-clr\":\"#F7F2EB\",\"pnl-nctv-clr\":\"#FFFFFF\",\"pnl-ctv-clr\":\"#302C2C\",\"pnl-nctv-ttl-clr\":\"#302C2C\",\"pnl-ctv-ttl-clr\":\"#F5F5F5\",\"pnl-dt-clr\":\"#26ADE4\",\"pnl-nctv-brdrs-stl\":\"solid\",\"pnl-ctv-brdrs-stl\":\"solid\",\"pnl-nctv-brdrs-clr\":\"#E2E2E2\",\"pnl-ctv-brdrs-clr\":\"#302C2C\",\"tgglr-nctv-bck-clr\":\"#E2E2E2\",\"tgglr-ctv-bck-clr\":\"#26ADE4\",\"tb-brdr-rds\":\"10\",\"pnl-brdr-rds\":\"10\",\"tgglr-brdr-rds\":\"10\",\"mg-brdr-rds\":\"10\"}'),
('11', 'dj-custom2-green', '1', '1', '1', '11', '{\"tb-nctv-bck-clr\":\"#302C2C\",\"tb-ctv-bck-clr\":\"#59A80F\",\"tb-nctv-ttl-clr\":\"#F7F2EB\",\"tb-ctv-ttl-clr\":\"#F7F2EB\",\"pnl-nctv-clr\":\"#FFFFFF\",\"pnl-ctv-clr\":\"#302C2C\",\"pnl-nctv-ttl-clr\":\"#302C2C\",\"pnl-ctv-ttl-clr\":\"#F5F5F5\",\"pnl-dt-clr\":\"#59A80F\",\"pnl-nctv-brdrs-stl\":\"solid\",\"pnl-ctv-brdrs-stl\":\"solid\",\"pnl-nctv-brdrs-clr\":\"#E2E2E2\",\"pnl-ctv-brdrs-clr\":\"#302C2C\",\"tgglr-nctv-bck-clr\":\"#E2E2E2\",\"tgglr-ctv-bck-clr\":\"#59A80F\",\"tb-brdr-rds\":\"5\",\"pnl-brdr-rds\":\"5\",\"tgglr-brdr-rds\":\"5\",\"mg-brdr-rds\":\"5\"}'),
('10', 'dj-custom2-orange', '1', '1', '1', '10', '{\"tb-nctv-bck-clr\":\"#302C2C\",\"tb-ctv-bck-clr\":\"#F54828\",\"tb-nctv-ttl-clr\":\"#F7F2EB\",\"tb-ctv-ttl-clr\":\"#F7F2EB\",\"pnl-nctv-clr\":\"#FFFFFF\",\"pnl-ctv-clr\":\"#302C2C\",\"pnl-nctv-ttl-clr\":\"#302C2C\",\"pnl-ctv-ttl-clr\":\"#F5F5F5\",\"pnl-dt-clr\":\"#F54828\",\"pnl-nctv-brdrs-stl\":\"solid\",\"pnl-ctv-brdrs-stl\":\"solid\",\"pnl-nctv-brdrs-clr\":\"#E2E2E2\",\"pnl-ctv-brdrs-clr\":\"#302C2C\",\"tgglr-nctv-bck-clr\":\"#E2E2E2\",\"tgglr-ctv-bck-clr\":\"#F54828\",\"tb-brdr-rds\":\"20\",\"pnl-brdr-rds\":\"20\",\"tgglr-brdr-rds\":\"20\",\"mg-brdr-rds\":\"20\"}'),
('9', 'dj-custom2-black', '1', '1', '1', '9', '{\"tb-nctv-bck-clr\":\"#302C2C\",\"tb-ctv-bck-clr\":\"#524C4C\",\"tb-nctv-ttl-clr\":\"#F7F2EB\",\"tb-ctv-ttl-clr\":\"#F7F2EB\",\"pnl-nctv-clr\":\"#FFFFFF\",\"pnl-ctv-clr\":\"#302C2C\",\"pnl-nctv-ttl-clr\":\"#302C2C\",\"pnl-ctv-ttl-clr\":\"#F5F5F5\",\"pnl-dt-clr\":\"#524C4C\",\"pnl-nctv-brdrs-stl\":\"solid\",\"pnl-ctv-brdrs-stl\":\"solid\",\"pnl-nctv-brdrs-clr\":\"#E2E2E2\",\"pnl-ctv-brdrs-clr\":\"#302C2C\",\"tgglr-nctv-bck-clr\":\"#E2E2E2\",\"tgglr-ctv-bck-clr\":\"#524C4C\",\"tb-brdr-rds\":\"5\",\"pnl-brdr-rds\":\"25\",\"tgglr-brdr-rds\":\"25\",\"mg-brdr-rds\":\"5\"}'),
('8', 'dj-custom-blue', '1', '1', '1', '8', '{\"tb-ctv-bck-clr\":\"#26ADE4\",\n\"tb-ctv-ttl-clr\":\"#F7F2EB\",\n\"tb-nctv-bck-clr\":\"#302C2C\",\n\"tb-nctv-ttl-clr\":\"#F7F2EB\",\n\"pnl-dt-clr\":\"#26ADE4\",\n\"pnl-ctv-brdrs-stl\":\"solid\",\n\"pnl-ctv-brdrs-clr\":\"#E2E2E2\",\n\"pnl-ctv-clr\":\"#FFFFFF\",\n\"pnl-ctv-ttl-clr\":\"#302C2C\",\n\"tgglr-ctv-bck-clr\":\"#26ADE4\",\n\"pnl-nctv-brdrs-stl\":\"solid\",\n\"pnl-nctv-brdrs-clr\":\"#E2E2E2\",\n\"pnl-nctv-clr\":\"#FFFFFF\",\n\"pnl-nctv-ttl-clr\":\"#302C2C\",\n\"tgglr-nctv-bck-clr\":\"#E2E2E2\"}'),
('7', 'dj-custom-green', '1', '1', '1', '7', '{\"tb-ctv-bck-clr\":\"#59A80F\",\n\"tb-ctv-ttl-clr\":\"#F7F2EB\",\n\"tb-nctv-bck-clr\":\"#302C2C\",\n\"tb-nctv-ttl-clr\":\"#F7F2EB\",\n\"pnl-dt-clr\":\"#59A80F\",\n\"pnl-ctv-brdrs-stl\":\"solid\",\n\"pnl-ctv-brdrs-clr\":\"#E2E2E2\",\n\"pnl-ctv-clr\":\"#FFFFFF\",\n\"pnl-ctv-ttl-clr\":\"#302C2C\",\n\"tgglr-ctv-bck-clr\":\"#59A80F\",\n\"pnl-nctv-brdrs-stl\":\"solid\",\n\"pnl-nctv-brdrs-clr\":\"#E2E2E2\",\n\"pnl-nctv-clr\":\"#FFFFFF\",\n\"pnl-nctv-ttl-clr\":\"#302C2C\",\n\"tgglr-nctv-bck-clr\":\"#E2E2E2\"}'),
('6', 'dj-custom-orange', '1', '1', '1', '6', '{\"tb-ctv-bck-clr\":\"#F54828\",\n\"tb-ctv-ttl-clr\":\"#F7F2EB\",\n\"tb-nctv-bck-clr\":\"#302C2C\",\n\"tb-nctv-ttl-clr\":\"#F7F2EB\",\n\"pnl-dt-clr\":\"#F54828\",\n\"pnl-ctv-brdrs-stl\":\"solid\",\n\"pnl-ctv-brdrs-clr\":\"#E2E2E2\",\n\"pnl-ctv-clr\":\"#FFFFFF\",\n\"pnl-ctv-ttl-clr\":\"#302C2C\",\n\"tgglr-ctv-bck-clr\":\"#F54828\",\n\"pnl-nctv-brdrs-stl\":\"solid\",\n\"pnl-nctv-brdrs-clr\":\"#E2E2E2\",\n\"pnl-nctv-clr\":\"#FFFFFF\",\n\"pnl-nctv-ttl-clr\":\"#302C2C\",\n\"tgglr-nctv-bck-clr\":\"#E2E2E2\"}'),
('1', 'dj-black', '0', '1', '1', '1', '{\"tb-ctv-bck-clr\":\"#353535\"}'),
('2', 'dj-orange', '0', '1', '1', '2', '{\"tb-ctv-bck-clr\":\"#DD4125\"}'),
('3', 'dj-green', '0', '1', '1', '3', '{\"tb-ctv-bck-clr\":\"#51980E\"}'),
('4', 'dj-blue', '0', '1', '1', '4', '{\"tb-ctv-bck-clr\":\"#239CCD\"}'),
('5', 'dj-custom-black', '1', '1', '1', '5', '{\"tb-ctv-bck-clr\":\"#524C4C\",\"tb-ctv-ttl-clr\":\"#F7F2EB\",\"tb-nctv-bck-clr\":\"#302C2C\",\"tb-nctv-ttl-clr\":\"#F7F2EB\",\"pnl-dt-clr\":\"#524C4C\",\"pnl-ctv-brdrs-stl\":\"solid\",\"pnl-ctv-brdrs-clr\":\"#E2E2E2\",\"pnl-ctv-clr\":\"#FFFFFF\",\"pnl-ctv-ttl-clr\":\"#302C2C\",\"tgglr-ctv-bck-clr\":\"#524C4C\",\"pnl-nctv-brdrs-stl\":\"solid\",\"pnl-nctv-brdrs-clr\":\"#E2E2E2\",\"pnl-nctv-clr\":\"#FFFFFF\",\"pnl-nctv-ttl-clr\":\"#302C2C\",\"tgglr-nctv-bck-clr\":\"#E2E2E2\"}');
