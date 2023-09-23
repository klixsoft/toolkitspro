-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 22, 2023 at 05:04 PM
-- Server version: 10.5.22-MariaDB
-- PHP Version: 8.1.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Table structure for table `{{prefix}}category`
--

CREATE TABLE IF NOT EXISTS `{{prefix}}category` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `cat_of` varchar(50) NOT NULL,
  `title` longtext NOT NULL,
  `slug` longtext NOT NULL,
  `description` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `{{prefix}}download`
--

CREATE TABLE IF NOT EXISTS `{{prefix}}download` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `data` mediumtext NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `{{prefix}}meta_data`
--

CREATE TABLE IF NOT EXISTS `{{prefix}}meta_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `meta_of` varchar(100) NOT NULL,
  `meta_id` int(11) NOT NULL,
  `meta_key` varchar(200) NOT NULL,
  `meta_value` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `{{prefix}}posts`
--

CREATE TABLE IF NOT EXISTS `{{prefix}}posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` longtext NOT NULL,
  `slug` longtext NOT NULL,
  `author` int(11) NOT NULL,
  `description` longtext NOT NULL,
  `status` varchar(50) NOT NULL,
  `type` longtext NOT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `extra` text DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `modified` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `{{prefix}}proxy`
--

CREATE TABLE IF NOT EXISTS `{{prefix}}proxy` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `type` varchar(50) NOT NULL,
  `value` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `{{prefix}}report`
--

CREATE TABLE IF NOT EXISTS `{{prefix}}report` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `tool` longtext NOT NULL,
  `hashvalue` text DEFAULT NULL,
  `input` longtext NOT NULL,
  `output` longtext NOT NULL,
  `extra` longtext DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `{{prefix}}settings`
--

CREATE TABLE IF NOT EXISTS `{{prefix}}settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `option_name` mediumtext NOT NULL,
  `option_value` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `{{prefix}}tooldata`
--

CREATE TABLE IF NOT EXISTS `{{prefix}}tooldata` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `toolid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `options` text DEFAULT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `{{prefix}}users`
--

CREATE TABLE IF NOT EXISTS `{{prefix}}users` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(200) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `role` varchar(100) NOT NULL,
  `password` longtext NOT NULL,
  `status` varchar(100) NOT NULL,
  `date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `{{prefix}}orders`
--

CREATE TABLE IF NOT EXISTS `{{prefix}}orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `plan` int(11) NOT NULL,
  `price` double NOT NULL,
  `user` int(11) NOT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'monthly',
  `orderid` text DEFAULT NULL,
  `source` text NOT NULL,
  `response` text DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'on-hold',
  `apikey` text NOT NULL,
  `expiry` datetime NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `{{prefix}}apikey_request`
--

CREATE TABLE IF NOT EXISTS `{{prefix}}apikey_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `apikey` text NOT NULL,
  `request_date` date NOT NULL DEFAULT current_timestamp(),
  `total_request` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

COMMIT;