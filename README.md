# Logapp

Logapp is a module to make application logs (for example, users login/logout, adding/deleting/editing
information etc.) and editing table locks (to prevent multiple table record editing).

## Quick Start

* Place logapp module to modules folder;
* Enable logapp module in bootstrap.php;
* Copy-paste logap config to you application/config folder;
* Build database tables.

To start logging call Logapp instance method write():

	Logapp::instance()->write($tog_type, $log_result, $log_description);

Logapp remembers tog_types adn log_results automaticly. You don't need to fill certain tables before
using this helper.

To work with table locking:

	// Sets table record lock
	Logapp::instance()->set_lock($table_name, $record_id, $user_id);

	// Investigate table record lock existance
	// Returnes lock object or FALSE if record is not locked
	$lock = Logapp::instance()->get_lock($table_name, $record_id);

	// Clears table record lock
	// Uses lock object
	// Returnes TRUE if lock was deleted
	$lock = Logapp::instance()->clear_lock($lock_object);

	// Deletes all locks
	$lock = Logapp::instance()->clear_all_locks();

## Database structure

	CREATE TABLE IF NOT EXISTS `locks` (
	  `id` int(10) unsigned NOT NULL auto_increment,
	  `time` int(10) unsigned NOT NULL COMMENT 'timestamp',
	  `table_name` varchar(20) unsigned NOT NULL,
	  `table_record` smallint(5) unsigned NOT NULL,
	  `user_id` smallint(5) unsigned default NULL,
	  PRIMARY KEY  (`id`),
	  KEY `fk_lock_user` (`user_id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

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
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

	CREATE TABLE IF NOT EXISTS `log_results` (
	  `id` smallint(5) unsigned NOT NULL auto_increment,
	  `name` varchar(64) NOT NULL,
	  PRIMARY KEY  (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


	CREATE TABLE IF NOT EXISTS `log_types` (
	  `id` smallint(5) unsigned NOT NULL auto_increment,
	  `name` varchar(64) NOT NULL,
	  PRIMARY KEY  (`id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

	ALTER TABLE `logs`
	  ADD CONSTRAINT `fk_log_type` FOREIGN KEY (`type_id`) REFERENCES `log_types` (`id`) ON UPDATE CASCADE,
	  ADD CONSTRAINT `fk_log_result` FOREIGN KEY (`result_id`) REFERENCES `log_results` (`id`) ON UPDATE CASCADE,
	  ADD CONSTRAINT `fk_log_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

	ALTER TABLE `locks`
	  ADD CONSTRAINT `fk_lock_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;