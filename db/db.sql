CREATE TABLE `games` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `word_length` int(11) DEFAULT NULL,
  `guesses` int(11) DEFAULT NULL,
  `player_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `player_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `player_1_word` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `player_2_word` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `player_1_complete` int(11) DEFAULT NULL,
  `player_2_complete` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;