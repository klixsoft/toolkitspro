<?php

$createTable = "CREATE TABLE IF NOT EXISTS `{$prefix}comments` (
    `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `post` int(11) NOT NULL,
    `user` int(11) NOT NULL,
    `review` int(11) NOT NULL DEFAULT 5,
    `message` text NOT NULL,
    `parent` int(11) NOT NULL DEFAULT 0,
    `status` varchar(50) NOT NULL DEFAULT 'pending',
    `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
  
mysqli_query($conn, $createTable);