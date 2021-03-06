CREATE TABLE IF NOT EXISTS `#__jcomments` (
`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`parent` INT(11) UNSIGNED NOT NULL DEFAULT '0',
`object_id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
`object_group` VARCHAR(255) NOT NULL DEFAULT '',
`object_params` TEXT NOT NULL DEFAULT '',
`lang` VARCHAR(255) NOT NULL DEFAULT '',
`userid` INT(11) UNSIGNED NOT NULL DEFAULT '0',
`name`VARCHAR(255) NOT NULL DEFAULT '',
`username`VARCHAR(255) NOT NULL DEFAULT '',
`email` VARCHAR(255) NOT NULL DEFAULT '',
`homepage` VARCHAR(255) NOT NULL DEFAULT '',
`title` VARCHAR(255) NOT NULL DEFAULT '',
`comment` TEXT NOT NULL DEFAULT '',
`ip` VARCHAR(15) NOT NULL DEFAULT '',
`date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`isgood` SMALLINT(5) UNSIGNED NOT NULL default '0',
`ispoor` SMALLINT(5) UNSIGNED NOT NULL default '0',
`published` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
`subscribe` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
`source` VARCHAR(255) NOT NULL DEFAULT '',
`checked_out` INT(11) UNSIGNED NOT NULL DEFAULT '0',
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`editor` VARCHAR(50) DEFAULT NULL,
PRIMARY KEY  (`id`),
KEY `idx_userid` (`userid`),
KEY `idx_source` (`source`),
KEY `idx_email` (`email`),
KEY `idx_lang` (`lang`),
KEY `idx_subscribe` (`subscribe`),
KEY `idx_checkout` (`checked_out`),
KEY `idx_object` (`object_id`, `object_group`, `published`, `date`)
) TYPE=MyISAM;

CREATE TABLE IF NOT EXISTS `#__jcomments_settings` (
`component` VARCHAR(50) NOT NULL DEFAULT '',
`lang` VARCHAR(20) NOT NULL DEFAULT '',
`name` VARCHAR(50) NOT NULL DEFAULT '',
`value` TEXT NOT NULL DEFAULT '',
PRIMARY KEY  (`component`, `lang`, `name`)
) TYPE=MyISAM;

CREATE TABLE IF NOT EXISTS `#__jcomments_votes` (
`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`commentid` INT(11) UNSIGNED NOT NULL DEFAULT '0',
`userid` INT(11) UNSIGNED NOT NULL DEFAULT '0',
`ip` VARCHAR(15) NOT NULL DEFAULT '',
`date` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`value` TINYINT(1) NOT NULL,
PRIMARY KEY  (`id`),
KEY `idx_comment`(`commentid`,`userid`)
) TYPE=MyISAM;

CREATE TABLE IF NOT EXISTS `#__jcomments_subscriptions` (
`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`object_id` INT(11) UNSIGNED NOT NULL DEFAULT '0',
`object_group` VARCHAR(255) NOT NULL DEFAULT '',
`lang` VARCHAR(255) NOT NULL DEFAULT '',
`userid` INT(11) UNSIGNED NOT NULL DEFAULT '0',
`name`VARCHAR(255) NOT NULL DEFAULT '',
`email` VARCHAR(255) NOT NULL DEFAULT '',
`hash` VARCHAR(255) NOT NULL DEFAULT '',
`published` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
PRIMARY KEY  (`id`),
KEY `idx_object` (`object_id`, `object_group`),
KEY `idx_lang` (`lang`),
KEY `idx_hash` (`hash`)
) TYPE=MyISAM;

CREATE TABLE IF NOT EXISTS `#__jcomments_version` (
`version` VARCHAR(16) NOT NULL DEFAULT '',
`previous` VARCHAR(16) NOT NULL DEFAULT '',
`installed` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`updated` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY  (`version`)
) TYPE=MyISAM;
