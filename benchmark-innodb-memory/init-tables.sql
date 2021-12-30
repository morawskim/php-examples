CREATE TABLE `refresh_tokens_memory` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `refresh_token` varchar(128) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
 `username` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
 `valid` datetime NOT NULL,
 PRIMARY KEY (`id`),
 UNIQUE KEY `UNIQ_9BACE7E1C74F2195` (`refresh_token`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `refresh_tokens_innodb` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `refresh_token` varchar(128) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
 `username` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
 `valid` datetime NOT NULL,
 PRIMARY KEY (`id`),
 UNIQUE KEY `UNIQ_9BACE7E1C74F2195` (`refresh_token`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
