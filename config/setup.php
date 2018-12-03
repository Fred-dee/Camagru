<?php
	require_once './database.php';
	require_once '../includes/functions.php';
	
	$pdo = DB::getConnection();
	try
	{
		$stmt = $pdo->query("CREATE DATABASE IF NOT EXISTS db_camagru");
		$stmt->execute();
		
		$stmt = $pdo->query("CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL  AUTO_INCREMENT PRIMARY KEY,
  `user_name` varchar(15) NOT NULL UNIQUE,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `email` text NOT NULL,
  `hash` text NOT NULL,
  `avatar` mediumblob,
  `type` text,
  `em_subs` tinyint(1) NOT NULL DEFAULT '1',
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `verification_key` varbinary(10) DEFAULT NULL,
  `forgot_key` varbinary(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8");
		$stmt->execute();

		
		
		$stmt = $pdo->query("CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11)  NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `src` mediumblob NOT NULL,
  `creation_date` datetime NOT NULL,
  `type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8");
		$stmt->execute();
		
		
		$stmt = $pdo->query("CREATE TABLE IF NOT EXISTS`events` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `type` enum('comment','like') NOT NULL,
  `img_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8");
		$stmt->execute();
		
		//$stmt = $pdo->query("ALTER TABLE `events`
  //ADD CONSTRAINT `img_id` FOREIGN KEY (`img_id`) REFERENCES `images` (`id`),
  //ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)");
		//$stmt->execute();
		
		$stmt = $pdo->query("INSERT INTO `users` (`user_name`, `first_name`, `last_name`, `email`, `hash`, `avatar`, `type`, `em_subs`, `verified`, `verification_key`, `forgot_key`) VALUES
( 'Fred-Dee', 'Fred', 'Dilapisho', 'fred.dilapisho@mailinator.com', '', NULL, NULL, 1, 1, NULL, 0x2c07a9a73044d40527f1),
('Tester', 'Fred', 'Dilapisho', 'fred.dilapisho@mailinator.com', '', NULL, NULL, 0, 1, NULL, NULL),
('KGart', 'Kyle', 'Gartland', 'fred.dilapisho@gmail.com', '', NULL, NULL, 1, 1, 0x8918b41d6891917ae328, NULL),
('JDee', 'Jonathan', 'Dilapisho', 'fred.dilapisho@mailinator.com', '', NULL, NULL, 1, 1, 0x5aa4b6e590b04dc6e54b, 0xeb50ffa56a00d842b8f7),
('tmarking2', 'Thato', 'Marking', 'tmarking@mailinator.com', '', NULL, NULL, 1, 1, 0x09ceeb4e4d9c4db09f17, 0x3b600d5424b33b3ba7a7)");
		$stmt->execute();
		valid_success(1, "Succesfully installed", "/index");
		
	}catch (\PDOException $e)
	{
		die($e->getMessage());
	}
	
?>