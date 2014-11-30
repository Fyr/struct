CREATE TABLE `project_events` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `project_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `event_type` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `msg_id` bigint(20) unsigned DEFAULT NULL,
  `file_id` bigint(20) unsigned DEFAULT NULL,
  `task_id` int(11) unsigned DEFAULT NULL,
  `subproject_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_events` (`project_id`,`created`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

CREATE TABLE `projects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `group_id` int(11) unsigned NOT NULL,
  `owner_id` int(11) unsigned NOT NULL,
  `title` varchar(1023) NOT NULL,
  `descr` text,
  `deadline` date DEFAULT NULL,
  `hidden` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `closed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

CREATE TABLE `subprojects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `project_id` int(11) unsigned NOT NULL,
  `title` varchar(1023) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;


CREATE TABLE `tasks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `subproject_id` int(11) unsigned NOT NULL,
  `title` varchar(1023) NOT NULL,
  `creator_id` int(11) unsigned NOT NULL,
  `manager_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `closed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `deadline` date DEFAULT NULL,
  `descr` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
