ALTER TABLE articles DROP `section`;
ALTER TABLE articles ADD `cat_id` int(11) unsigned NOT NULL;
ALTER TABLE articles ADD KEY `cat_id` (`cat_id`);