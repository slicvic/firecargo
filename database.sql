-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Jul 07, 2015 at 08:03 PM
-- Server version: 5.5.34
-- PHP Version: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `ssg`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `company_id` int(10) unsigned DEFAULT NULL,
  `address1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `postal_code` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `country_id` int(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `company_id` (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `company_id`, `address1`, `address2`, `city`, `state`, `postal_code`, `country_id`, `created_at`, `updated_at`) VALUES
(29, 1020, NULL, '', '', '', '', '', 1, '2015-07-07 16:59:43', '2015-07-07 16:59:43');

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
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `phone`, `fax`, `email`, `created_at`, `updated_at`) VALUES
(1, 'Lantigua Group', '1234567', '7654321', 'hello@gmail.com', '2015-03-23 22:58:37', '2015-07-05 20:22:18'),
(2, 'Sion Services Group', '', '', '', '2015-03-23 22:59:07', '2015-03-23 23:05:58');

-- --------------------------------------------------------

--
-- Table structure for table `containers`
--

CREATE TABLE `containers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL,
  `type_id` int(10) unsigned NOT NULL,
  `tracking_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `departed_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tracking_number` (`tracking_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `container_types`
--

CREATE TABLE `container_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `container_types`
--

INSERT INTO `container_types` (`id`, `name`) VALUES
(1, 'Flight'),
(2, 'Vessel');

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
  `company_id` bigint(20) unsigned NOT NULL,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `couriers`
--

INSERT INTO `couriers` (`id`, `company_id`, `name`, `created_at`, `updated_at`) VALUES
(16, 0, 'UPS', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 0, 'USPS', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 0, 'FedEx', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 0, 'LaserShip', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=72 ;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `warehouse_id`, `type_id`, `status_id`, `length`, `width`, `height`, `weight`, `description`, `invoice_number`, `invoice_amount`, `tracking_number`, `ship`, `created_at`, `updated_at`) VALUES
(70, 24, 10, 5, 0, 0, 0, 0, '', '', 0.0000, '', 1, '2015-07-07 01:01:01', '2015-07-07 01:01:01'),
(71, 24, 10, 5, 0, 0, 0, 0, '', '', 0.0000, '', 1, '2015-07-07 01:01:01', '2015-07-07 01:01:01');

-- --------------------------------------------------------

--
-- Table structure for table `package_statuses`
--

CREATE TABLE `package_statuses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `package_statuses`
--

INSERT INTO `package_statuses` (`id`, `company_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Recibido USA', '0000-00-00 00:00:00', '2015-04-12 18:55:50'),
(2, 1, 'En proceso de despacho USA', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 1, 'Despachado desde USA', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 1, 'Recibido Colombia', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 1, 'En reparto Nacional', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `package_types`
--

CREATE TABLE `package_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `package_types`
--

INSERT INTO `package_types` (`id`, `company_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 0, 'Box', '2015-03-23 01:29:12', '2015-04-12 19:02:06'),
(2, 0, 'Piece', '2015-03-23 02:10:00', '2015-03-26 03:30:45'),
(3, 0, 'Bundle', '2015-03-23 02:10:07', '2015-03-26 03:30:50'),
(4, 0, 'Carton', '2015-03-23 02:11:07', '2015-03-26 03:30:54'),
(5, 0, 'Roll', '2015-03-23 02:11:19', '2015-03-26 03:30:59'),
(6, 0, 'Crate', '2015-03-23 02:11:31', '2015-03-26 03:31:03'),
(7, 0, 'Pallet', '2015-03-23 02:11:39', '2015-03-23 02:11:39'),
(8, 0, 'Drum', '2015-03-23 02:11:42', '2015-03-26 03:31:28'),
(9, 0, 'Tube', '2015-03-23 02:11:48', '2015-03-23 02:11:48'),
(10, 0, 'Envelope', '2015-03-23 02:11:52', '2015-03-26 03:31:37');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'login', 'Login privileges', '0000-00-00 00:00:00', '2015-07-02 17:16:48'),
(2, 'admin', 'Administrative user, has access to everything.', '0000-00-00 00:00:00', '2015-03-21 17:34:02'),
(3, 'agent', 'A registered company or business', '0000-00-00 00:00:00', '2015-03-24 03:18:46'),
(4, 'customer', 'A customer of a company or business', '0000-00-00 00:00:00', '2015-07-07 14:02:24'),
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
(1020, 1),
(1020, 2);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `sites`
--

INSERT INTO `sites` (`id`, `company_id`, `name`, `display_name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Master', 'Master', '2015-03-23 23:20:35', '2015-04-16 12:48:30'),
(2, 2, 'SionBox', 'SionBox Display Name', '2015-03-23 23:05:44', '2015-07-06 18:23:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` bigint(20) unsigned NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `company_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `first_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `id_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mobile_phone` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `autoship_packages` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `remember_token` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `logins` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1060 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `site_id`, `company_id`, `email`, `password`, `company_name`, `first_name`, `last_name`, `dob`, `id_number`, `phone`, `mobile_phone`, `autoship_packages`, `remember_token`, `logins`, `last_login`, `created_at`, `updated_at`) VALUES
(1020, 1, 1, 'admin@gmail.com', '$2y$10$4Pvalc2FFS9pRRmOTVMHYeSmNo2V2vRTveKn/8meoBYyfe9K93JFa', '', 'Admin', 'Vic', '2011-11-11', '13212121212', '1234567', '7654321', 1, 'OGas9iJ8CNuR9I4fMTGUFnObWBqb9qbPs13TNbCZOJTMP5akrx8uGn7pVUCe', 99, '2015-07-07 14:43:34', '2015-01-29 04:41:09', '2015-07-07 17:44:13');

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL,
  `shipper_user_id` bigint(20) unsigned NOT NULL,
  `consignee_user_id` bigint(20) unsigned NOT NULL,
  `courier_id` int(10) unsigned DEFAULT NULL,
  `container_id` int(10) unsigned DEFAULT NULL,
  `notes` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `arrived_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `courier_id` (`courier_id`),
  KEY `group_id` (`container_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`id`, `company_id`, `shipper_user_id`, `consignee_user_id`, `courier_id`, `container_id`, `notes`, `arrived_at`, `created_at`, `updated_at`) VALUES
(23, 1, 1020, 1020, 19, NULL, '', '2015-07-07 00:49:00', '2015-07-07 00:50:24', '2015-07-07 00:50:24'),
(24, 1, 1020, 1020, 19, NULL, '', '2015-07-07 00:49:00', '2015-07-07 00:50:57', '2015-07-07 00:50:57'),
(25, 1, 1020, 1020, 19, NULL, '', '2015-07-07 17:10:00', '2015-07-07 17:11:18', '2015-07-07 17:11:18');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `fk_addresses_companies_companyid` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_addresses_users_userid` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `packages`
--
ALTER TABLE `packages`
  ADD CONSTRAINT `fk_packages_packagestatuses_statusid` FOREIGN KEY (`status_id`) REFERENCES `package_statuses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_packages_packagetypes_typeid` FOREIGN KEY (`type_id`) REFERENCES `package_types` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_packages_warehouses_warehouseid` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `roles_users`
--
ALTER TABLE `roles_users`
  ADD CONSTRAINT `fk_rolesusers_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD CONSTRAINT `fk_warehouses_containers_containerid` FOREIGN KEY (`container_id`) REFERENCES `containers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_warehouses_couriers_courierid` FOREIGN KEY (`courier_id`) REFERENCES `couriers` (`id`) ON DELETE SET NULL;
