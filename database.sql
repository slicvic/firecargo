-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Jul 06, 2015 at 02:52 PM
-- Server version: 5.5.34
-- PHP Version: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `ssg`
--

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fax` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `postal_code` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `country_id` int(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `phone`, `fax`, `email`, `address1`, `address2`, `city`, `state`, `postal_code`, `country_id`, `created_at`, `updated_at`) VALUES
(1, 'Lantigua Group', '1234567', '7654321', 'hello@gmail.com', '6320 NW 114TH AVE', 'APT 1237', 'City', 'State', '33178', 1, '2015-03-23 22:58:37', '2015-07-05 20:22:18'),
(2, 'Sion Services Group', '', '', '', '', '', '', '', '', 0, '2015-03-23 22:59:07', '2015-03-23 23:05:58'),
(3, 'TEST COMpany', '', '', '', '', '', '', '', '', 0, '2015-07-02 17:14:09', '2015-07-02 17:14:09'),
(4, 'test23', '', '', '', '', '', '', '', '', 0, '2015-07-02 17:14:25', '2015-07-02 17:14:25'),
(5, 'new test', '', '', '', '', '', '', '', '', 0, '2015-07-02 17:48:24', '2015-07-02 17:48:24');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`) VALUES
(1, 'United States'),
(2, 'Colombia');

-- --------------------------------------------------------

--
-- Table structure for table `couriers`
--

CREATE TABLE `couriers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` bigint(20) unsigned NOT NULL,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `couriers`
--

INSERT INTO `couriers` (`id`, `site_id`, `name`, `created_at`, `updated_at`) VALUES
(16, 0, 'UPS', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 0, 'USPS', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 0, 'FedEx', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 0, 'LaserShip', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 1, 'dd22', '2015-07-02 17:27:38', '2015-07-02 17:31:06'),
(21, 1, 'xx', '2015-07-02 17:31:00', '2015-07-02 17:31:00'),
(22, 1, 'new test', '2015-07-02 17:49:38', '2015-07-02 17:49:38');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `warehouse_id` bigint(20) unsigned NOT NULL,
  `type_id` bigint(20) unsigned DEFAULT NULL,
  `status_id` bigint(20) unsigned DEFAULT NULL,
  `length` float NOT NULL,
  `width` float NOT NULL,
  `height` float NOT NULL,
  `weight` float NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `invoice_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `invoice_amount` decimal(12,4) NOT NULL,
  `tracking_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ship` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `warehouse_id` (`warehouse_id`),
  KEY `type_id` (`type_id`),
  KEY `status_id` (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=58 ;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `warehouse_id`, `type_id`, `status_id`, `length`, `width`, `height`, `weight`, `description`, `invoice_number`, `invoice_amount`, `tracking_number`, `ship`, `created_at`, `updated_at`) VALUES
(52, 21, 10, 1, 0, 0, 0, 0, '', '', 0.0000, '', 1, '2015-06-26 19:28:29', '2015-06-26 19:28:29'),
(57, 22, 10, 10, 16, 10, 10, 6, '', '', 0.0000, '123123123123', 1, '2015-07-05 21:40:48', '2015-07-05 21:40:48');

-- --------------------------------------------------------

--
-- Table structure for table `package_statuses`
--

CREATE TABLE `package_statuses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(10) unsigned NOT NULL,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `is_default` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `package_statuses`
--

INSERT INTO `package_statuses` (`id`, `site_id`, `name`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 2, 'Recibido USA', 0, '0000-00-00 00:00:00', '2015-04-12 18:55:50'),
(2, 2, 'En proceso de despacho USA', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 2, 'Despachado desde USA', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 2, 'Recibido Colombia', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 2, 'En reparto Nacional', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 1, 'Status 1', 0, '2015-06-01 12:25:26', '2015-07-02 17:35:16'),
(9, 1, 'Status 1', 0, '2015-06-01 12:25:31', '2015-06-01 13:46:49'),
(10, 1, 'Status 2', 1, '2015-06-01 12:25:36', '2015-06-01 13:46:49'),
(11, 1, 'resdasd', 0, '2015-07-02 17:35:41', '2015-07-02 17:35:41'),
(12, 1, 'new test', 0, '2015-07-02 17:49:54', '2015-07-02 17:49:54');

-- --------------------------------------------------------

--
-- Table structure for table `package_types`
--

CREATE TABLE `package_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(10) unsigned NOT NULL,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `package_types`
--

INSERT INTO `package_types` (`id`, `site_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 0, 'Box', '2015-03-23 01:29:12', '2015-04-12 19:02:06'),
(2, 0, 'Piece', '2015-03-23 02:10:00', '2015-03-26 03:30:45'),
(3, 0, 'Bundle', '2015-03-23 02:10:07', '2015-03-26 03:30:50'),
(4, 0, 'Carton', '2015-03-23 02:11:07', '2015-03-26 03:30:54'),
(5, 0, 'Roll', '2015-03-23 02:11:19', '2015-03-26 03:30:59'),
(6, 0, 'Crate', '2015-03-23 02:11:31', '2015-03-26 03:31:03'),
(7, 0, 'Pallet', '2015-03-23 02:11:39', '2015-03-23 02:11:39'),
(8, 0, 'Drum', '2015-03-23 02:11:42', '2015-03-26 03:31:28'),
(9, 0, 'Tube', '2015-03-23 02:11:48', '2015-03-23 02:11:48'),
(10, 0, 'Envelope', '2015-03-23 02:11:52', '2015-03-26 03:31:37'),
(11, 1, 'adasdxx2', '2015-05-29 14:23:44', '2015-07-02 17:25:56'),
(12, 1, 'xx', '2015-05-29 14:33:27', '2015-05-29 14:35:58'),
(13, 1, '2323', '2015-05-29 14:36:30', '2015-05-29 14:36:36'),
(14, 1, 'xxx', '2015-05-29 14:36:51', '2015-05-29 14:44:34'),
(15, 1, 'sdsd', '2015-07-02 17:26:06', '2015-07-02 17:26:06'),
(16, 1, 'new test', '2015-07-02 17:49:21', '2015-07-02 17:49:21');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'login', 'Login privileges', '0000-00-00 00:00:00', '2015-07-02 17:16:48'),
(2, 'admin', 'Administrative user, has access to everything.', '0000-00-00 00:00:00', '2015-03-21 17:34:02'),
(3, 'agent', 'A registered company or business', '0000-00-00 00:00:00', '2015-03-24 03:18:46'),
(4, 'client', 'A client of a company or business', '0000-00-00 00:00:00', '2015-03-24 03:19:00'),
(6, 'consignee', 'A consignee', '0000-00-00 00:00:00', '2015-05-29 18:24:21'),
(7, 'shipper', 'A shipper', '0000-00-00 00:00:00', '2015-05-29 18:24:29'),
(8, 'test1', 'test1 desc', '2015-07-02 17:00:50', '2015-07-02 17:00:50'),
(9, 'sss', 'eqwew', '2015-07-02 17:06:31', '2015-07-02 17:06:31'),
(10, 'tssdf', 'asd', '2015-07-02 17:07:29', '2015-07-02 17:07:29'),
(13, 'sadasd', 'asd', '2015-07-02 17:07:55', '2015-07-02 17:07:55'),
(14, 'saasd', 'asdasd', '2015-07-02 17:08:30', '2015-07-02 17:08:30'),
(16, 'ASD', 'SADA', '2015-07-02 17:09:16', '2015-07-02 17:09:16'),
(17, 'test', 'wewe', '2015-07-02 17:16:56', '2015-07-02 17:16:56'),
(18, 'new test', '', '2015-07-02 17:48:02', '2015-07-02 17:48:02'),
(19, 'zxcz', 'zxc', '2015-07-02 17:51:02', '2015-07-02 17:51:02');

-- --------------------------------------------------------

--
-- Table structure for table `roles_users`
--

CREATE TABLE `roles_users` (
  `user_id` bigint(20) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles_users`
--

INSERT INTO `roles_users` (`user_id`, `role_id`) VALUES
(1003, 1),
(1003, 2),
(1004, 1),
(1004, 4),
(1005, 4),
(1005, 6),
(1005, 7),
(1008, 6),
(1008, 7),
(1009, 4),
(1009, 6),
(1009, 7),
(1010, 4),
(1010, 6),
(1010, 7),
(1011, 1),
(1011, 3),
(1011, 4),
(1011, 6),
(1011, 7),
(1017, 1),
(1017, 4),
(1017, 6),
(1018, 1),
(1018, 3),
(1018, 4),
(1018, 6),
(1018, 7),
(1020, 1),
(1020, 2),
(1020, 3),
(1021, 1),
(1021, 4),
(1022, 1),
(1022, 4),
(1023, 7),
(1024, 4),
(1025, 1),
(1025, 4),
(1026, 1),
(1026, 4),
(1027, 1),
(1027, 3),
(1028, 1),
(1028, 3),
(1033, 1),
(1033, 4),
(1034, 1),
(1034, 4),
(1035, 1),
(1035, 4),
(1036, 1),
(1036, 4);

-- --------------------------------------------------------

--
-- Table structure for table `sites`
--

CREATE TABLE `sites` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `sites`
--

INSERT INTO `sites` (`id`, `company_id`, `name`, `display_name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Master', 'Master', '2015-03-23 23:20:35', '2015-04-16 12:48:30'),
(2, 2, 'SionBox', 'SionBox Display Name', '2015-03-23 23:05:44', '2015-03-29 17:21:02'),
(3, 1, 'test', 'test2', '2015-07-02 17:18:47', '2015-07-02 17:18:47'),
(4, 1, 'new test', 'new test', '2015-07-02 17:49:01', '2015-07-02 17:49:01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` bigint(20) unsigned NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `business_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `first_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `id_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mobile_phone` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fax` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `postal_code` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `country_id` int(10) unsigned NOT NULL,
  `autoship_packages` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `remember_token` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `logins` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1037 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `site_id`, `email`, `password`, `business_name`, `first_name`, `last_name`, `dob`, `id_number`, `phone`, `mobile_phone`, `fax`, `address1`, `address2`, `city`, `state`, `postal_code`, `country_id`, `autoship_packages`, `remember_token`, `logins`, `last_login`, `created_at`, `updated_at`) VALUES
(1003, 2, 'agent@gmail.com', '$2y$10$FtActDLxelaBV0JilSUllutHMZ7Vv9syyBvIIR0Q0lt/RSxQUTo2m', 'agent jose b', 'Agent', 'Jose', '2011-11-11', '', '', '', '', '6320 nw 114th ave', '', '', '', '', 1, 1, 'gDSoVruinsDIw8PDfs5FO0iirdlGiti1Q6M58eS23gWeUnZHET6467JZklbN', 60, '2015-06-26 19:26:53', '2015-01-29 04:41:09', '2015-06-26 19:26:53'),
(1004, 2, 'client@gmail.com', '$2y$10$DKPhhl46ZzQU/nPw1AOhTu/N7XkdbXzDK8t3YOB4dg.y3Lg6EQsRy', '', 'Jane', 'Doe', '1922-06-14', '', '', '', '', '', '', '', '', '', 1, 1, 'UXvH3FdK6HAbEm9mD3Q9hEKFmV9rH4SZKe8aEMeFI7IhaZHd1uPQFbMZnRP5', 13, '2015-02-24 02:22:43', '2015-01-30 01:35:49', '2015-06-25 21:07:40'),
(1020, 1, 'admin@gmail.com', '$2y$10$bmFFlOhyrPGRKEwAUuD01ON7u3Xe70MEOf8ORAReaPnTSnpFX.NP2', '', 'Admin', 'Vic', '2011-11-11', '13212121212', '1234567', '7654321', '', 'LINE 1', 'LINE 2', 'City', 'State', '12345', 1, 1, 'vjC1HcYjSusMC6m83bayfxQfYaI7JRlOHZF0L8pmvRQ5ElHUcVq75zHidQmB', 93, '2015-07-06 11:45:08', '2015-01-29 04:41:09', '2015-07-06 12:24:10'),
(1023, 1, '', NULL, 'Amazon', '', '', '0000-00-00', '', '', '', '', '1200 12th Ave', '', 'Seattle', 'WA', '98144', 1, 1, NULL, 0, '0000-00-00 00:00:00', '2015-06-25 21:03:57', '2015-06-30 13:08:24'),
(1024, 1, '', NULL, '', '', '', '0000-00-00', '', '', '', '323', '3535 NW 87th Ave', 'Apt 12345', 'Doral', 'FL', '3312', 1, 1, NULL, 0, '0000-00-00 00:00:00', '2015-06-25 21:13:24', '2015-06-30 13:08:36'),
(1025, 1, 'michaeljordan@gmail.com', '$2y$10$Kws9jtAzFLdRfelc2RzGueywtXNlscILXderdbVfLV2yfUa6sHbL2', '', 'Michael', 'Jordan', '0000-00-00', '', '3053626016', '7863214567', '', '1234 Ave 18th Ct', 'Apt 66', 'Chicago', 'IL', '23455', 1, 1, 'HmPphVnWwG5NRSxyYSXAVJ8xW2lIjxpfOw8nkzxmdSS3daiytaJctSaK6DXw', 0, '0000-00-00 00:00:00', '2015-06-26 12:18:23', '2015-06-26 12:24:04'),
(1026, 1, '', NULL, 'test', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 1, 1, NULL, 0, '0000-00-00 00:00:00', '2015-07-02 15:52:24', '2015-07-02 15:52:24'),
(1027, 1, '', NULL, 'test', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 1, 1, NULL, 0, '0000-00-00 00:00:00', '2015-07-02 16:12:17', '2015-07-02 16:12:17'),
(1028, 1, '', NULL, 'test2', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 1, 1, NULL, 0, '0000-00-00 00:00:00', '2015-07-02 16:31:13', '2015-07-02 16:31:13'),
(1029, 1, '', NULL, 'test55', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 1, 1, NULL, 0, '0000-00-00 00:00:00', '2015-07-02 16:32:03', '2015-07-02 16:32:03'),
(1030, 1, '', NULL, 'test3333', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 1, 1, NULL, 0, '0000-00-00 00:00:00', '2015-07-02 16:49:38', '2015-07-02 16:49:38'),
(1031, 1, '', NULL, 'asd', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 1, 1, NULL, 0, '0000-00-00 00:00:00', '2015-07-02 16:50:52', '2015-07-02 16:50:52'),
(1032, 2, '', NULL, 'new test', '', '', '0000-00-00', '', '', '', '', '', '', '', '', '', 1, 1, NULL, 0, '0000-00-00 00:00:00', '2015-07-02 17:47:32', '2015-07-02 17:47:32'),
(1033, 1, 'asdas@gmail.com', '$2y$10$Erj8KjBAKVHUbpk.cuA9cuWDL/rZrMCXQTICJqnWcveeTBiQ1WPNS', '', 'Sdasd', 'Cscas', '0000-00-00', '', '', '23', '', 'sd', '', 'Asd', 'asd', 'sdfs', 1, 1, NULL, 0, '0000-00-00 00:00:00', '2015-07-02 21:18:27', '2015-07-02 21:18:27'),
(1034, 1, 'asdxxxxxas@gmail.com', '$2y$10$z/YfDqu9Bqc8cQ755j/.fuMh3v/fIJ21BivwaITnRjNd4PfnW562C', '', 'Sdasd', 'Cscas', '0000-00-00', '', '', '23', '', 'sd', '', 'Asd', 'asd', 'sdfs', 1, 1, NULL, 0, '0000-00-00 00:00:00', '2015-07-02 21:19:04', '2015-07-02 21:19:04'),
(1035, 1, 'adklknlkknlmin@gmail.com', '$2y$10$wp4cduKcsyoT3qFH7B.o2OBVIJKqmof1Wwq09/te3QZ69jCO61Tva', '', 'Sadasd', 'Jkhkj', '0000-00-00', '', '', '23', '', 'asdasd', '', 'Asdas', 'asd', '3234', 1, 1, NULL, 0, '0000-00-00 00:00:00', '2015-07-02 21:22:38', '2015-07-02 21:22:38'),
(1036, 1, 'adklknlkkkkkknlmin@gmail.com', '$2y$10$yGdh9yOH5LzBMo4jtG0w4.CvtcQMzYTPgFqUJAp4YuFVkFMK/6Qcq', '', 'Sadasd', 'Jkhkj', '0000-00-00', '', '', '23', '', 'asdasd', '', 'Asdas', 'asd', '3234', 1, 1, '4uT8th5B6OY9mYUEQL6YQcyW7Xk6b1fUakGUCFZMaYzVec1zDQngZ3CDrQjK', 0, '0000-00-00 00:00:00', '2015-07-02 21:24:39', '2015-07-02 21:24:47');

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(10) unsigned NOT NULL,
  `shipper_user_id` bigint(20) unsigned NOT NULL,
  `consignee_user_id` bigint(20) unsigned NOT NULL,
  `courier_id` int(10) unsigned DEFAULT NULL,
  `description` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `arrived_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `courier_id` (`courier_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`id`, `site_id`, `shipper_user_id`, `consignee_user_id`, `courier_id`, `description`, `arrived_at`, `created_at`, `updated_at`) VALUES
(21, 2, 1003, 1003, NULL, '', '2015-06-26 19:27:00', '2015-06-26 19:28:29', '2015-06-26 19:28:29'),
(22, 1, 1023, 1025, 19, 'hi there', '2015-06-27 04:10:00', '2015-06-27 04:11:52', '2015-07-05 21:38:05');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `packages`
--
ALTER TABLE `packages`
  ADD CONSTRAINT `fk_packages_packagestatuses_statusid` FOREIGN KEY (`status_id`) REFERENCES `package_statuses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_packages_packagetypes_typeid` FOREIGN KEY (`type_id`) REFERENCES `package_types` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_packages_warehouses_warehouseid` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD CONSTRAINT `fk_warehouses_couriers_courierid` FOREIGN KEY (`courier_id`) REFERENCES `couriers` (`id`) ON DELETE SET NULL;
