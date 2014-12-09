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
COMMIT;