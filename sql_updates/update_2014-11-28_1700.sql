ALTER TABLE users DROP first_name;
ALTER TABLE users DROP last_name;
ALTER TABLE users DROP middle_name;
ALTER TABLE users DROP phone;
ALTER TABLE users DROP active;
ALTER TABLE users DROP email;

ALTER TABLE users ADD (
  `full_name` varchar(1023) DEFAULT NULL,
  `video_url` varchar(1023) DEFAULT NULL,
  `skills` text,
  `birthday` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `lang` varchar(3) DEFAULT 'eng',
  `phone` varchar(1023) DEFAULT NULL,
  `live_place` text,
  `university` varchar(1023) DEFAULT NULL,
  `speciality` varchar(1023) DEFAULT NULL,
  `live_country` varchar(1023) DEFAULT NULL,
  `timezone` varchar(50) DEFAULT NULL
);

INSERT INTO users (id, created, username, password, phone, video_url, skills, birthday, live_place, full_name, lang, university, speciality, live_country, timezone) 
SELECT c.id, c.created, c.username, c.password, p.phone, p.video_url, p.skills, p.birthday, p.live_place, p.full_name, p.lang, p.university, p.speciality, p.live_country, p.timezone 
FROM clients AS c 
LEFT JOIN profiles AS p ON p.user_id = c.id;

DROP TABLE IF EXISTS `user_achievements`;
CREATE TABLE `user_achievements` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) unsigned NOT NULL,
  `title` text,
  `url` varchar(1023) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

INSERT INTO user_achievements (created, user_id, title, url)
SELECT pa.created, c.id, pa.title, pa.url 
FROM `profile_achievements` AS pa
JOIN profiles AS p ON p.id = pa.profile_id
JOIN clients AS c ON c.id = p.user_id;

UPDATE media AS m SET object_type = 'User', object_id = (SELECT user_id FROM profiles AS p WHERE p.id = m.object_id) WHERE object_type = 'Profile';
UPDATE media AS m SET object_type = 'UserUniversity', object_id = (SELECT user_id FROM profiles AS p WHERE p.id = m.object_id) WHERE object_type = 'ProfileUniversity';

ALTER TABLE group_members ADD `sort_order` int(11) unsigned NOT NULL DEFAULT '1';
ALTER TABLE group_members ADD KEY `group_sort_order` (`group_id`,`sort_order`);

INSERT INTO group_members (group_id, user_id, role, approved, approve_date, sort_order)
SELECT g.id, g.owner_id, 'Administrator', 1, g.created, 0 FROM groups AS g;