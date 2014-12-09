DROP TABLE IF EXISTS `project_members`;
CREATE TABLE `project_members` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `project_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `sort_order` int(11) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `project_user` (`project_id`,`user_id`),
  KEY `user_project` (`user_id`,`project_id`),
  KEY `project_created` (`project_id`,`created`),
  KEY `project_sort_order` (`project_id`,`sort_order`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

INSERT INTO project_members (project_id, user_id, sort_order)
SELECT g.id, g.owner_id, 0 FROM projects AS g;

ALTER TABLE `group_addresses` ADD `fax` varchar(1023) DEFAULT NULL;
