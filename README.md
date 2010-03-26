# Logapp

Logapp is a module to make application logs (for example, users login/logout, adding/deleting/editing information etc.).

## Quick Start

* Place logapp module to modules folder;
* Enable logapp module in bootstrap.php;
* Copy-paste logap config to you application/config folder;
* Build database tables.

To start logging call Logapp instance method write():

	Logapp::instance()->write($tog_type, $log_result, $log_description)

Logapp remembers tog_types adn log_results automaticly. You don't need to fill certain tables before using this helper.

## Database structure

	CREATE TABLE IF NOT EXISTS `logs` (
	  `id` int(10) unsigned NOT NULL auto_increment,
	  `time` int(10) unsigned NOT NULL COMMENT 'timestamp',
	  `type_id` smallint(5) unsigned NOT NULL COMMENT 'log type',
	  `result_id` smallint(5) unsigned NOT NULL,
	  `user_id` smallint(5) unsigned default NULL,
	  `description` text NOT NULL,
	  PRIMARY KEY  (`id`),
	  KEY `fk_log_user` (`user_id`),
	  KEY `fk_log_result` (`result_id`),
	  KEY `fk_log_type` (`type_id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

	CREATE TABLE IF NOT EXISTS `log_results` (
	  `id` smallint(5) unsigned NOT NULL auto_increment,
	  `name` varchar(64) NOT NULL,
	  PRIMARY KEY  (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;


	CREATE TABLE IF NOT EXISTS `log_types` (
	  `id` smallint(5) unsigned NOT NULL auto_increment,
	  `name` varchar(64) NOT NULL,
	  PRIMARY KEY  (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

	ALTER TABLE `logs`
	  ADD CONSTRAINT `fk_log_type` FOREIGN KEY (`type_id`) REFERENCES `log_types` (`id`) ON UPDATE CASCADE,
	  ADD CONSTRAINT `fk_log_result` FOREIGN KEY (`result_id`) REFERENCES `log_results` (`id`) ON UPDATE CASCADE,
	  ADD CONSTRAINT `fk_log_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;