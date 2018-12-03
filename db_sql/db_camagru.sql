-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 03, 2018 at 02:38 AM
-- Server version: 5.7.23
-- PHP Version: 7.1.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_camagru`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `type` enum('comment','like') NOT NULL,
  `img_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `src` mediumblob NOT NULL,
  `creation_date` datetime NOT NULL,
  `type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(15) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `first_name`, `last_name`, `email`, `hash`, `avatar`, `type`, `em_subs`, `verified`, `verification_key`, `forgot_key`) VALUES
(8, 'Fred-Dee', 'Fred', 'Dilapisho', 'fred.dilapisho@mailinator.com', '$2y$10$nA7HluPcM55Sck060Ya3ouRExrx4v.3dChwAcyawYb9aNLUcIVWJ.', NULL, NULL, 1, 1, NULL, 0x2c07a9a73044d40527f1),
(9, 'Tester', 'Fred', 'Dilapisho', 'fred.dilapisho@mailinator.com', '$2y$10$.X2U1o1Em1m6s/7ZtYoZseACMIb1lA5JVN1uQoU1ouGkGbDBgFo1W', NULL, NULL, 0, 1, NULL, NULL),
(10, 'KGart', 'Kyle', 'Gartland', 'fred.dilapisho@gmail.com', '$2y$10$tdQ9N/oR86zXwsDhsyA7QOErX822jdN.APVENKalDdMKmI6GRD5OO', NULL, NULL, 1, 1, 0x8918b41d6891917ae328, NULL),
(11, 'JDee', 'Jonathan', 'Dilapisho', 'fred.dilapisho@mailinator.com', '$2y$10$C6RYRuZXoxiEweVpz/PkweTRVjU6hvR3qQRGbkkt8qya1Xmxg3p/G', NULL, NULL, 1, 1, 0x5aa4b6e590b04dc6e54b, 0xeb50ffa56a00d842b8f7),
(14, 'tmarking2', 'Thato', 'Marking', 'tmarking@mailinator.com', '$2y$10$nCo/bO7jg3UZj3tSg6kMaO6fvVqAX9pfLpnHUrCeR8u/NzZP6bB4C', NULL, NULL, 1, 1, 0x09ceeb4e4d9c4db09f17, 0x3b600d5424b33b3ba7a7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `img_id` (`img_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `img_id` FOREIGN KEY (`img_id`) REFERENCES `images` (`id`),
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
