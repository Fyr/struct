DROP TABLE IF EXISTS chat_room_users;
DROP TABLE IF EXISTS chat_members;
CREATE TABLE `chat_members` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `room_id` bigint(20) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `room_id` (`room_id`,`user_id`),
  KEY `user_id` (`user_id`,`room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO chat_members (room_id, user_id) 
SELECT id, initiator_id FROM chat_rooms;

INSERT INTO chat_members (room_id, user_id)
SELECT id, recipient_id FROM chat_rooms;

DROP TABLE IF EXISTS articles;
CREATE TABLE `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `title` varchar(1023) NOT NULL,
  `body` text,
  `section` varchar(1023) DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

UPDATE `users` SET created = '2014-11-13 00:01:00', modified = NOW() WHERE created < '2014-11-12';