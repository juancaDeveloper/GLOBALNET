CREATE TABLE IF NOT EXISTS `#__tlpteam_team` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`department` INT(11)  NOT NULL ,
`name` VARCHAR(255)  NOT NULL ,
`alias` VARCHAR(255)  NOT NULL ,
`position` VARCHAR(255)  NOT NULL ,
`email` VARCHAR(255)  NOT NULL ,
`phoneno` VARCHAR(255)  NOT NULL ,
`personal_website` VARCHAR(255)  NOT NULL ,
`location` VARCHAR(255)  NOT NULL ,
`profile_image` VARCHAR(255)  NOT NULL ,
`short_bio` TEXT NOT NULL ,
`detail_bio` TEXT NOT NULL ,
`facebook` VARCHAR(255)  NOT NULL ,
`twitter` VARCHAR(255)  NOT NULL ,
`linkedin` VARCHAR(255)  NOT NULL ,
`google_plus` VARCHAR(255)  NOT NULL ,
`youtube` VARCHAR(255)  NOT NULL ,
`vimeo` VARCHAR(255)  NOT NULL ,
`instagram` VARCHAR(255)  NOT NULL ,
`skill1` INT NOT NULL ,
`skill1_no` VARCHAR(255)  NOT NULL ,
`skill2` INT NOT NULL ,
`skill2_no` VARCHAR(255)  NOT NULL ,
`skill3` INT NOT NULL ,
`skill3_no` VARCHAR(255)  NOT NULL ,
`skill4` INT NOT NULL ,
`skill4_no` VARCHAR(255)  NOT NULL ,
`skill5` INT NOT NULL ,
`skill5_no` VARCHAR(255)  NOT NULL ,
`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__tlpteam_skills` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`title` VARCHAR(255)  NOT NULL ,
`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__tlpteam_settings` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`image_path` VARCHAR(255)  NOT NULL ,
`smallimage_width` VARCHAR(255)  NOT NULL ,
`smallimage_height` VARCHAR(255)  NOT NULL ,
`mediumimage_width` VARCHAR(255)  NOT NULL ,
`mediumimage_height` VARCHAR(255)  NOT NULL ,
`largeimage_width` VARCHAR(255)  NOT NULL ,
`largeimage_height` VARCHAR(255)  NOT NULL ,
`display_no` VARCHAR(255)  NOT NULL ,
`enable_bootstrap` TINYINT(1)  NOT NULL ,
`bootstrap_version` TINYINT(1)  NOT NULL ,
`image_grid` VARCHAR(255)  NOT NULL ,
`template` VARCHAR(255)  NOT NULL ,
`primary_color` VARCHAR(255)  NOT NULL ,
`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

