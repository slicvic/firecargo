-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Jun 24, 2015 at 03:30 PM
-- Server version: 5.5.34
-- PHP Version: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `phone`, `fax`, `email`, `address1`, `address2`, `city`, `state`, `postal_code`, `country_id`, `created_at`, `updated_at`) VALUES
(1, 'Lantigua Group', '4074318518', '111', 'xxxmanuel185@gmail.com', '6320 nw 114th ave', 'apt 1237', 'doral', 'FL', '33178', 2, '2015-03-23 22:58:37', '2015-05-30 15:39:14'),
(2, 'Sion Services Group', '', '', '', '', '', '', '', '', 0, '2015-03-23 22:59:07', '2015-03-23 23:05:58');

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
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `couriers`
--

INSERT INTO `couriers` (`id`, `site_id`, `name`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 0, 'UPS', 0, '0000-00-00 00:00:00', '2015-03-26 03:30:34'),
(2, 0, 'USPS', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 0, 'FedEx', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 2, 'LaserShip', 1, '2015-03-23 02:28:36', '2015-04-29 18:13:00'),
(14, 2, 'LaserShip', 0, '2015-04-29 18:13:08', '2015-04-29 18:13:08'),
(15, 1, 'xxxx22', 1, '2015-05-29 14:41:14', '2015-05-29 14:41:27');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `warehouse_id` bigint(20) unsigned NOT NULL,
  `type_id` bigint(20) unsigned NOT NULL,
  `status_id` bigint(20) unsigned NOT NULL,
  `length` float NOT NULL,
  `width` float NOT NULL,
  `height` float NOT NULL,
  `weight` float NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `invoice_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `invoice_amount` decimal(12,4) NOT NULL,
  `tracking_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `roll` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `warehouse_id` (`warehouse_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `warehouse_id`, `type_id`, `status_id`, `length`, `width`, `height`, `weight`, `description`, `invoice_number`, `invoice_amount`, `tracking_number`, `roll`, `deleted`, `created_at`, `updated_at`) VALUES
(7, 1, 1, 0, 1, 1, 1, 1, 'dfsdfsdfsdf\r\ndsfsdf', '', 0.0000, '', 1, 1, '2015-05-27 18:21:56', '2015-05-30 18:36:08'),
(8, 5, 1, 0, 16, 10, 20, 6, 'test desc', '123', 100.0000, '1234567', 1, 0, '2015-05-28 23:13:36', '2015-05-28 23:13:36'),
(9, 5, 0, 0, 16, 10, 20, 6, 'test desc', '123', 100.0000, '', 1, 0, '2015-05-28 23:13:36', '2015-05-28 23:13:36'),
(10, 5, 0, 0, 16, 10, 20, 6, 'test desc', '123', 100.0000, '', 1, 0, '2015-05-28 23:13:36', '2015-05-28 23:13:36'),
(11, 6, 1, 0, 16, 10, 20, 6, 'test desc', '123', 100.0000, '1234567', 1, 0, '2015-05-28 23:13:50', '2015-05-28 23:13:50'),
(12, 7, 1, 0, 16, 10, 10, 6, 'desc', '12313', 100.0000, '12345566', 1, 0, '2015-05-28 23:14:19', '2015-05-28 23:15:51'),
(15, 7, 1, 0, 16, 10, 10, 6, 'desc', '12313', 100.0000, '', 1, 0, '2015-05-28 23:15:51', '2015-05-28 23:15:51'),
(16, 8, 1, 0, 16, 10, 10, 6, 'desc', '123', 100.0000, '123456', 1, 0, '2015-05-29 01:13:10', '2015-05-29 01:13:10'),
(17, 8, 1, 0, 16, 10, 10, 6, 'desc', '123', 100.0000, '', 1, 0, '2015-05-29 01:13:10', '2015-05-29 01:13:10'),
(18, 9, 1, 0, 16, 10, 10, 6, 'desc', '123', 100.0000, '123456', 1, 0, '2015-05-29 01:20:23', '2015-05-29 01:20:23'),
(19, 10, 1, 1, 16, 10, 10, 6, 'desc', '123', 100.0000, '123456', 1, 0, '2015-05-29 01:24:24', '2015-05-29 01:24:24'),
(20, 11, 1, 1, 16, 10, 10, 6, 'desc', '123', 100.0000, '123456', 1, 0, '2015-05-29 01:24:32', '2015-05-29 01:24:32'),
(21, 12, 1, 2, 0, 0, 0, 0, '', '', 0.0000, '', 1, 0, '2015-05-30 18:42:02', '2015-05-30 18:42:31'),
(22, 12, 1, 1, 0, 0, 0, 0, '', '', 0.0000, '', 1, 0, '2015-05-30 18:42:02', '2015-05-30 18:42:31'),
(23, 12, 1, 1, 0, 0, 0, 0, '', '', 0.0000, '', 1, 0, '2015-05-30 18:42:02', '2015-05-30 18:42:31'),
(24, 13, 1, 1, 0, 0, 0, 0, '', '', 0.0000, '', 1, 0, '2015-05-30 18:42:46', '2015-05-30 18:42:46'),
(25, 13, 1, 2, 0, 0, 0, 0, '', '', 0.0000, '', 1, 0, '2015-05-30 18:42:46', '2015-05-30 18:42:46'),
(26, 13, 1, 1, 0, 0, 0, 0, '', '', 0.0000, '', 1, 0, '2015-05-30 18:42:46', '2015-05-30 18:42:46'),
(27, 14, 1, 1, 20, 20, 20, 0, '', '', 0.0000, '', 1, 0, '2015-05-30 18:45:46', '2015-05-30 18:49:46'),
(28, 14, 1, 4, 0, 0, 0, 0, '', '', 0.0000, '', 1, 0, '2015-05-30 18:45:46', '2015-05-30 18:49:46'),
(29, 14, 1, 5, 0, 0, 0, 0, '', '', 0.0000, '', 1, 0, '2015-05-30 18:45:46', '2015-05-30 18:49:46'),
(30, 14, 1, 5, 0, 0, 0, 0, '', '', 0.0000, '', 1, 0, '2015-05-30 18:45:46', '2015-05-30 18:49:46'),
(31, 15, 1, 1, 0, 0, 0, 0, '', '', 0.0000, '', 1, 0, '2015-05-30 18:46:16', '2015-05-30 18:46:16'),
(32, 15, 1, 2, 0, 0, 0, 0, '', '', 0.0000, '', 1, 0, '2015-05-30 18:46:16', '2015-05-30 18:46:16'),
(33, 15, 1, 3, 0, 0, 0, 0, '', '', 0.0000, '', 1, 0, '2015-05-30 18:46:16', '2015-05-30 18:46:16'),
(34, 15, 1, 4, 0, 0, 0, 0, '', '', 0.0000, '', 1, 0, '2015-05-30 18:46:16', '2015-05-30 18:46:16'),
(35, 15, 1, 5, 0, 0, 0, 0, '', '', 0.0000, '', 1, 0, '2015-05-30 18:46:16', '2015-05-30 18:46:16'),
(36, 16, 1, 0, 10, 10, 10, 6, 'item1', 'inv1', 21.0000, '111', 1, 0, '2015-05-31 19:30:23', '2015-05-31 19:32:25'),
(37, 16, 1, 0, 10, 10, 10, 6, 'item2', 'inv2', 22.0000, '222', 1, 0, '2015-05-31 19:30:23', '2015-05-31 19:32:25'),
(38, 17, 1, 0, 1, 1, 1, 0, '', '', 0.0000, '', 1, 0, '2015-05-31 21:23:30', '2015-05-31 21:23:30'),
(39, 18, 1, 0, 1, 1, 1, 0, '', '', 0.0000, '', 0, 0, '2015-05-31 21:24:35', '2015-05-31 21:24:35'),
(40, 19, 1, 8, 1, 1, 1, 0, '', '', 0.0000, '', 0, 0, '2015-05-31 21:26:13', '2015-06-01 12:56:39');

-- --------------------------------------------------------

--
-- Table structure for table `package_statuses`
--

CREATE TABLE `package_statuses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(10) unsigned NOT NULL,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `is_default` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `package_statuses`
--

INSERT INTO `package_statuses` (`id`, `site_id`, `name`, `color`, `is_default`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 2, 'Recibido USA', '', 0, 0, '0000-00-00 00:00:00', '2015-04-12 18:55:50'),
(2, 2, 'En proceso de despacho USA', '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 2, 'Despachado desde USA', '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 2, 'Recibido Colombia', '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 2, 'En reparto Nacional', '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 1, 'Status 1', '#ff40ff', 0, 1, '2015-06-01 12:25:26', '2015-06-01 13:46:49'),
(9, 1, 'Status 1', '#ff8ad8', 0, 0, '2015-06-01 12:25:31', '2015-06-01 13:46:49'),
(10, 1, 'Status 2', '#000000', 1, 0, '2015-06-01 12:25:36', '2015-06-01 13:46:49');

-- --------------------------------------------------------

--
-- Table structure for table `package_types`
--

CREATE TABLE `package_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(10) unsigned NOT NULL,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `package_types`
--

INSERT INTO `package_types` (`id`, `site_id`, `name`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 0, 'Box', 0, '2015-03-23 01:29:12', '2015-04-12 19:02:06'),
(2, 0, 'Piece', 0, '2015-03-23 02:10:00', '2015-03-26 03:30:45'),
(3, 0, 'Bundle', 0, '2015-03-23 02:10:07', '2015-03-26 03:30:50'),
(4, 0, 'Carton', 0, '2015-03-23 02:11:07', '2015-03-26 03:30:54'),
(5, 0, 'Roll', 0, '2015-03-23 02:11:19', '2015-03-26 03:30:59'),
(6, 0, 'Crate', 0, '2015-03-23 02:11:31', '2015-03-26 03:31:03'),
(7, 0, 'Pallet', 0, '2015-03-23 02:11:39', '2015-03-23 02:11:39'),
(8, 0, 'Drum', 0, '2015-03-23 02:11:42', '2015-03-26 03:31:28'),
(9, 0, 'Tube', 0, '2015-03-23 02:11:48', '2015-03-23 02:11:48'),
(10, 0, 'Envelope', 0, '2015-03-23 02:11:52', '2015-03-26 03:31:37'),
(11, 1, 'adasd', 1, '2015-05-29 14:23:44', '2015-05-29 14:36:17'),
(12, 1, 'xx', 1, '2015-05-29 14:33:27', '2015-05-29 14:35:58'),
(13, 1, '2323', 1, '2015-05-29 14:36:30', '2015-05-29 14:36:36'),
(14, 1, 'xxx', 1, '2015-05-29 14:36:51', '2015-05-29 14:44:34');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'login', 'Login privileges', '0000-00-00 00:00:00', '2015-04-12 19:12:37'),
(2, 'admin', 'Administrative user, has access to everything.', '0000-00-00 00:00:00', '2015-03-21 17:34:02'),
(3, 'agent', 'A registered company or business', '0000-00-00 00:00:00', '2015-03-24 03:18:46'),
(4, 'client', 'A client of a company or business', '0000-00-00 00:00:00', '2015-03-24 03:19:00'),
(6, 'consignee', 'A consignee', '0000-00-00 00:00:00', '2015-05-29 18:24:21'),
(7, 'shipper', 'A shipper', '0000-00-00 00:00:00', '2015-05-29 18:24:29');

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
(1003, 3),
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
(1023, 1),
(1023, 4),
(1024, 1),
(1024, 4),
(1026, 1),
(1026, 4),
(1027, 1),
(1027, 3),
(1028, 1),
(1028, 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sites`
--

INSERT INTO `sites` (`id`, `company_id`, `name`, `display_name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Master', 'Master', '2015-03-23 23:20:35', '2015-04-16 12:48:30'),
(2, 2, 'SionBox', 'SionBox Display Name', '2015-03-23 23:05:44', '2015-03-29 17:21:02');

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
  `firstname` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `id_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cellphone` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `postal_code` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `country_id` int(10) unsigned NOT NULL,
  `autoroll_packages` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `remember_token` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `logins` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login` datetime NOT NULL,
  `deleted` tinyint(1) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1023 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `site_id`, `email`, `password`, `business_name`, `firstname`, `lastname`, `dob`, `id_number`, `phone`, `cellphone`, `address1`, `address2`, `city`, `state`, `postal_code`, `country_id`, `autoroll_packages`, `remember_token`, `logins`, `last_login`, `deleted`, `created_at`, `updated_at`) VALUES
(1003, 2, 'agent@gmail.com', '$2y$10$FtActDLxelaBV0JilSUllutHMZ7Vv9syyBvIIR0Q0lt/RSxQUTo2m', '', 'Agent', 'Jose', '2011-11-11', '0', '', '', '6320 nw 114th ave', '', '', '', '', 0, 1, 'gDSoVruinsDIw8PDfs5FO0iirdlGiti1Q6M58eS23gWeUnZHET6467JZklbN', 59, '2015-03-17 02:42:12', 0, '2015-01-29 04:41:09', '2015-05-28 23:19:01'),
(1004, 2, 'client@gmail.com', '$2y$10$DKPhhl46ZzQU/nPw1AOhTu/N7XkdbXzDK8t3YOB4dg.y3Lg6EQsRy', '', 'Client', 'John', '1922-06-14', '', '', '', '', '', '', '', '', 0, 1, 'UXvH3FdK6HAbEm9mD3Q9hEKFmV9rH4SZKe8aEMeFI7IhaZHd1uPQFbMZnRP5', 13, '2015-02-24 02:22:43', 0, '2015-01-30 01:35:49', '2015-04-16 12:43:13'),
(1020, 1, 'admin@gmail.com', '$2y$10$tgDN1MnZDWxeCBhptgK4qOgereq0pKGV5W6eBtsXFc7YXw7TqxkA.', '', 'Admin', 'Vic', '2011-11-11', '', '', '', '', '', '', '', '', 1, 1, 'p8lKpwUIopkjm3Sq6x9zYlte3O9Es8jOd3pDd4FLMJxnrO0GuUqCuFBHEn97', 59, '2015-03-17 02:43:56', 0, '2015-01-29 04:41:09', '2015-05-31 21:26:49'),
(1021, 2, 'vmlantigua@gmail.com', '$2y$10$iYmOEtQojXlztxsFf4y/We3T2CiMPWHDmzi8I1.66sPc0u.Ygus06', '', 'victor', 'lantigua', '0000-00-00', 'sdasdasd', '4074318518', '4074318518', '6320 nw 114th ave', 'apt 1237', 'doral', 'FL', '33178', 0, 1, 'UP3gKWE6n7zMVQOxQQT0J5anPJhfvRQP7uSkv6X6io0s0yvmovRjFsCnbgog', 0, '0000-00-00 00:00:00', 0, '2015-05-28 23:22:21', '2015-05-29 22:46:57'),
(1022, 2, 'jose@lara.com', '$2y$10$hGtzf6gzsuPrUVlqzi0cVOjszmaUX3guaAd7F8C5FWrx32h260lEG', 'xx', 'jose', 'lara', '0000-00-00', '3378', '3053609673', '3053609673', '12374 nw 97 ct', 'apt 2324', 'hialeah gardens', 'Florida', '33018', 1, 1, NULL, 0, '0000-00-00 00:00:00', 0, '2015-05-29 22:55:29', '2015-06-01 14:02:05');

-- --------------------------------------------------------

--
-- Table structure for table `user_settings`
--

CREATE TABLE `user_settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `autoroll_packages` tinyint(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(10) unsigned NOT NULL,
  `shipper_user_id` bigint(20) unsigned NOT NULL,
  `consignee_user_id` bigint(20) unsigned NOT NULL,
  `courier_id` int(10) unsigned NOT NULL,
  `arrived_at` datetime NOT NULL,
  `deleted` tinyint(1) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`id`, `site_id`, `shipper_user_id`, `consignee_user_id`, `courier_id`, `arrived_at`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 1020, 1020, 1, '1970-01-01 00:00:00', 0, '0000-00-00 00:00:00', '2015-05-27 18:21:56'),
(3, 1, 1020, 1020, 1, '2015-05-28 22:33:00', 0, '2015-05-28 22:34:29', '2015-05-28 22:34:29'),
(4, 1, 1020, 1020, 1, '2015-05-28 22:42:00', 0, '2015-05-28 22:43:21', '2015-05-28 22:43:21'),
(5, 2, 1003, 1004, 1, '2015-05-28 23:12:00', 0, '2015-05-28 23:13:36', '2015-05-28 23:13:36'),
(6, 2, 1003, 1004, 1, '2015-05-28 23:12:00', 0, '2015-05-28 23:13:50', '2015-05-28 23:13:50'),
(7, 2, 1003, 1004, 1, '2015-05-28 23:13:00', 0, '2015-05-28 23:14:19', '2015-05-28 23:14:19'),
(8, 2, 1003, 1021, 1, '2015-05-29 01:12:00', 0, '2015-05-29 01:13:10', '2015-05-29 01:13:10'),
(9, 2, 1003, 1021, 1, '2015-05-29 01:12:00', 0, '2015-05-29 01:20:23', '2015-05-29 01:20:23'),
(10, 2, 1003, 1021, 1, '2015-05-29 01:12:00', 0, '2015-05-29 01:24:24', '2015-05-29 01:24:24'),
(11, 2, 1003, 1021, 1, '2015-05-29 01:12:00', 0, '2015-05-29 01:24:32', '2015-05-29 01:24:32'),
(12, 1, 1020, 1020, 1, '2015-05-30 18:40:00', 0, '2015-05-30 18:42:01', '2015-05-30 18:42:01'),
(13, 1, 1020, 1020, 1, '2015-05-30 18:42:00', 0, '2015-05-30 18:42:46', '2015-05-30 18:42:46'),
(14, 1, 1020, 1020, 1, '2015-05-30 18:45:00', 0, '2015-05-30 18:45:45', '2015-05-30 18:45:45'),
(15, 1, 1020, 1020, 1, '2015-05-30 18:45:00', 0, '2015-05-30 18:46:16', '2015-05-30 18:46:16'),
(16, 1, 1020, 1020, 1, '2015-05-31 19:29:00', 0, '2015-05-31 19:30:22', '2015-05-31 19:30:22'),
(17, 1, 1020, 1020, 1, '2015-05-31 21:23:00', 0, '2015-05-31 21:23:30', '2015-05-31 21:23:30'),
(18, 1, 1020, 1020, 1, '2015-05-31 21:24:00', 0, '2015-05-31 21:24:35', '2015-05-31 21:24:35'),
(19, 1, 1020, 1020, 1, '2015-05-31 21:26:00', 0, '2015-05-31 21:26:13', '2015-05-31 21:26:13');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
