DROPTABLE IF EXISTS `chat_contacts`;
CREATE TABLE `chat_contacts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NULL DEFAULT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `initiator_id` int(11) unsigned NOT NULL,
  `active_count` int(11) unsigned NOT NULL DEFAULT '0',
  `msg` text,
  `room_id` int(11) unsigned NOT NULL,
  `chat_event_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id_room_id` (`user_id`,`room_id`),
  KEY `user_id_modified` (`user_id`,`modified`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;