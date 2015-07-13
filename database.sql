-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Jul 13, 2015 at 04:37 PM
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
  `country_id` int(10) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `company_id` (`company_id`),
  KEY `user_id_2` (`user_id`),
  KEY `company_id_2` (`company_id`),
  KEY `country_id` (`country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=76 ;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `company_id`, `address1`, `address2`, `city`, `state`, `postal_code`, `country_id`, `created_at`, `updated_at`) VALUES
(73, 1092, NULL, '', '', '', '', '', 1, '2015-07-11 21:38:50', '2015-07-11 21:38:50'),
(74, 1093, NULL, '', '', '', '', '', 1, '2015-07-11 22:12:07', '2015-07-11 22:12:07'),
(75, 1020, NULL, '', '', '', '', '', 1, '2015-07-12 21:51:19', '2015-07-12 21:51:19');

-- --------------------------------------------------------

--
-- Table structure for table `cargos`
--

CREATE TABLE `cargos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL,
  `carrier_id` bigint(20) unsigned NOT NULL,
  `receipt_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `departed_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`),
  KEY `carrier_id` (`carrier_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `cargos`
--

INSERT INTO `cargos` (`id`, `company_id`, `carrier_id`, `receipt_number`, `departed_at`, `created_at`, `updated_at`) VALUES
(12, 1, 82, 'ASDASD', '2015-07-12 23:55:58', '2015-07-12 23:56:06', '2015-07-12 23:56:06'),
(13, 1, 80, 'SDASD', '2015-07-12 00:00:00', '2015-07-12 23:57:16', '2015-07-13 01:48:36'),
(14, 1, 79, 'TEST', '2015-07-29 00:00:00', '2015-07-12 23:58:12', '2015-07-13 00:11:46');

-- --------------------------------------------------------

--
-- Table structure for table `carriers`
--

CREATE TABLE `carriers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_by_user_id` bigint(20) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=83 ;

--
-- Dumping data for table `carriers`
--

INSERT INTO `carriers` (`id`, `name`, `created_by_user_id`, `created_at`, `updated_at`) VALUES
(79, 'UPS', 1020, '2015-07-11 21:40:07', '2015-07-11 21:40:07'),
(80, 'UPSS', 1020, '2015-07-12 23:54:34', '2015-07-12 23:54:34'),
(82, 'UPSSS', 1020, '2015-07-12 23:56:06', '2015-07-12 23:56:06');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `corp_code` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fax` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `corp_code`, `phone`, `fax`, `email`, `created_at`, `updated_at`) VALUES
(1, 'Lantigua Group', 'LG', '1234567', '7654321', 'hello@gmail.com', '2015-03-23 22:58:37', '2015-07-11 12:48:31'),
(2, 'Sion Services Group', 'SSG', '', '', '', '2015-03-23 22:59:07', '2015-07-09 14:39:34');

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
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL,
  `warehouse_id` bigint(20) unsigned DEFAULT NULL,
  `original_warehouse_id` bigint(20) unsigned NOT NULL,
  `type_id` bigint(20) unsigned DEFAULT NULL,
  `status_id` bigint(20) unsigned DEFAULT NULL,
  `cargo_id` int(10) unsigned DEFAULT NULL,
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
  `deleted_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `warehouse_id` (`warehouse_id`),
  KEY `type_id` (`type_id`),
  KEY `status_id` (`status_id`),
  KEY `type_id_2` (`type_id`),
  KEY `cargo_id` (`cargo_id`),
  KEY `company_id` (`company_id`),
  KEY `consignee_user_id` (`original_warehouse_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=139 ;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `company_id`, `warehouse_id`, `original_warehouse_id`, `type_id`, `status_id`, `cargo_id`, `length`, `width`, `height`, `weight`, `description`, `invoice_number`, `invoice_amount`, `tracking_number`, `ship`, `created_at`, `updated_at`, `deleted_at`) VALUES
(134, 1, NULL, 79, 1, 1, NULL, 2222, 0, 0, 0, '', '', 0.0000, '', 1, '2015-07-12 23:40:47', '2015-07-12 23:41:19', '0000-00-00 00:00:00'),
(135, 1, 79, 79, 6, 3, 13, 444, 0, 0, 0, '', '', 0.0000, '', 1, '2015-07-12 23:40:59', '2015-07-13 01:48:36', '0000-00-00 00:00:00'),
(136, 1, 80, 80, 1, 1, 14, 0, 0, 0, 0, 'hello 136', '', 0.0000, 'tn136', 1, '2015-07-12 23:49:41', '2015-07-13 02:24:07', '0000-00-00 00:00:00'),
(137, 1, 80, 80, 1, 1, 14, 0, 0, 0, 0, '1', '', 0.0000, '', 1, '2015-07-12 23:49:41', '2015-07-13 02:24:07', '0000-00-00 00:00:00'),
(138, 1, 81, 81, 1, 1, 13, 0, 0, 0, 0, '', 'sadasd', 0.0000, '', 1, '2015-07-12 23:54:34', '2015-07-13 01:48:36', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `package_statuses`
--

CREATE TABLE `package_statuses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL,
  `is_default` tinyint(3) unsigned DEFAULT NULL,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=54 ;

--
-- Dumping data for table `package_statuses`
--

INSERT INTO `package_statuses` (`id`, `company_id`, `is_default`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 'Recibido USA', '0000-00-00 00:00:00', '2015-07-11 21:31:48'),
(2, 1, 0, 'En proceso de despacho USA', '0000-00-00 00:00:00', '2015-07-11 21:31:48'),
(3, 1, 0, 'Despachado desde USA', '0000-00-00 00:00:00', '2015-07-11 21:31:48'),
(4, 1, 0, 'Recibido Colombia', '0000-00-00 00:00:00', '2015-07-11 21:31:48'),
(5, 1, 0, 'En reparto Nacional', '0000-00-00 00:00:00', '2015-07-11 21:31:48');

-- --------------------------------------------------------

--
-- Table structure for table `package_types`
--

CREATE TABLE `package_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `package_types`
--

INSERT INTO `package_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Box', '2015-03-23 01:29:12', '2015-07-11 01:45:25'),
(2, 'Piece', '2015-03-23 02:10:00', '2015-03-26 03:30:45'),
(3, 'Bundle', '2015-03-23 02:10:07', '2015-03-26 03:30:50'),
(4, 'Carton', '2015-03-23 02:11:07', '2015-03-26 03:30:54'),
(5, 'Roll', '2015-03-23 02:11:19', '2015-03-26 03:30:59'),
(6, 'Crate', '2015-03-23 02:11:31', '2015-03-26 03:31:03'),
(7, 'Pallet', '2015-03-23 02:11:39', '2015-03-23 02:11:39'),
(8, 'Drum', '2015-03-23 02:11:42', '2015-03-26 03:31:28'),
(9, 'Tube', '2015-03-23 02:11:48', '2015-03-23 02:11:48'),
(10, 'Envolope', '2015-07-08 01:32:53', '2015-07-11 14:15:08');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'login', 'Login privileges', '0000-00-00 00:00:00', '2015-07-12 16:50:36'),
(2, 'admin', 'Administrative user, has access to everything.', '0000-00-00 00:00:00', '2015-03-21 17:34:02'),
(3, 'agent', 'A worker of registered company', '0000-00-00 00:00:00', '2015-07-08 03:36:44'),
(4, 'client', 'A customer of registered company', '0000-00-00 00:00:00', '2015-07-08 03:36:54'),
(5, 'shipper', 'A shipper of registered company', '0000-00-00 00:00:00', '2015-07-08 03:37:09'),
(6, 'consignee', 'A consignee', '2015-07-08 14:44:27', '2015-07-08 14:44:27');

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
(1020, 2),
(1060, 1),
(1060, 3),
(1092, 5),
(1093, 5);

-- --------------------------------------------------------

--
-- Table structure for table `sites`
--

CREATE TABLE `sites` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `sites`
--

INSERT INTO `sites` (`id`, `company_id`, `name`, `created_at`, `updated_at`) VALUES
(2, 2, 'SionBox', '2015-03-23 23:05:44', '2015-07-11 14:30:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(10) unsigned DEFAULT NULL,
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
  `autoship_setting` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `remember_token` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `logins` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1094 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `site_id`, `company_id`, `email`, `password`, `company_name`, `first_name`, `last_name`, `dob`, `id_number`, `phone`, `mobile_phone`, `autoship_setting`, `remember_token`, `logins`, `last_login`, `created_at`, `updated_at`) VALUES
(1020, NULL, 1, 'admin@gmail.com', '$2y$10$1jCgi5z6Q47X3B5nJMVtM.xgFEVKCKklHJMxXWYYu1H0yCiiYOcPK', '', 'Victor', 'Admin', '2011-11-11', '13212121212', '1234567', '7654321', 1, '2iEXSVt7jaPCKZaddxpuIvcsUs3uRZufLg1X5tCWMK14mbLRA8SH7O6A3l44', 121, '2015-07-13 14:31:09', '2015-01-29 04:41:09', '2015-07-13 14:32:13'),
(1060, NULL, 2, 'agent@gmail.com', '$2y$10$/KHLLdkQiLuyV6h/bcVjGOk2bK0CETqQxsIF/baD6d6MsZs2/HDrO', '', 'Jose', 'Agent', '0000-00-00', '', '', '', 1, 'YuyZukuzoq1hB2x7o2XN87gMORKpAn844JAqAYnRwu1bnksWVlV16cURmvpz', 6, '2015-07-11 01:39:21', '2015-07-07 20:30:59', '2015-07-11 01:39:29'),
(1092, NULL, 1, '', '$2y$10$joFtVVUdIlpHFrvNjAXBdOut/9aX3YSwbvjlY/TRcHHwYkrlkwQMO', 'AMAZON', '', '', '0000-00-00', '', '', '', 1, NULL, 0, '0000-00-00 00:00:00', '2015-07-11 21:38:50', '2015-07-13 14:32:02'),
(1093, NULL, 1, '', NULL, 'EBAY', '', '', '0000-00-00', '', '', '', 1, NULL, 0, '0000-00-00 00:00:00', '2015-07-11 22:12:07', '2015-07-11 22:12:07');

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL,
  `shipper_user_id` bigint(20) unsigned NOT NULL,
  `consignee_user_id` bigint(20) unsigned NOT NULL,
  `carrier_id` bigint(20) unsigned DEFAULT NULL,
  `notes` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `arrived_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `courier_id` (`carrier_id`),
  KEY `company_id` (`company_id`),
  KEY `shipper_user_id` (`shipper_user_id`),
  KEY `consignee_user_id` (`consignee_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=82 ;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`id`, `company_id`, `shipper_user_id`, `consignee_user_id`, `carrier_id`, `notes`, `arrived_at`, `created_at`, `updated_at`) VALUES
(79, 1, 1092, 1020, 79, 'asdas', '2015-07-12 23:40:00', '2015-07-12 23:40:47', '2015-07-12 23:40:47'),
(80, 1, 1093, 1020, 79, '', '2015-07-12 23:49:00', '2015-07-12 23:49:41', '2015-07-12 23:49:41'),
(81, 1, 1092, 1020, 80, 'asd', '2015-07-12 23:54:00', '2015-07-12 23:54:34', '2015-07-12 23:54:34');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_countries_countryid` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `fk_addresses_companies_companyid` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_addresses_users_userid` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cargos`
--
ALTER TABLE `cargos`
  ADD CONSTRAINT `containers_carriers_carrierid` FOREIGN KEY (`carrier_id`) REFERENCES `carriers` (`id`),
  ADD CONSTRAINT `containers_companies_companyid` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`);

--
-- Constraints for table `packages`
--
ALTER TABLE `packages`
  ADD CONSTRAINT `fk_packages_warehouses_originalwarehouseid` FOREIGN KEY (`original_warehouse_id`) REFERENCES `warehouses` (`id`),
  ADD CONSTRAINT `fk_packages_cargos_cargoid` FOREIGN KEY (`cargo_id`) REFERENCES `cargos` (`id`),
  ADD CONSTRAINT `fk_packages_companies_companyid` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  ADD CONSTRAINT `fk_packages_packagestatuses_statusid` FOREIGN KEY (`status_id`) REFERENCES `package_statuses` (`id`),
  ADD CONSTRAINT `fk_packages_packagetypes_typeid` FOREIGN KEY (`type_id`) REFERENCES `package_types` (`id`),
  ADD CONSTRAINT `fk_packages_warehouses_warehouseid` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`);

--
-- Constraints for table `package_statuses`
--
ALTER TABLE `package_statuses`
  ADD CONSTRAINT `packagestatuses_companies_companyid` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`);

--
-- Constraints for table `roles_users`
--
ALTER TABLE `roles_users`
  ADD CONSTRAINT `fk_rolesusers_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sites`
--
ALTER TABLE `sites`
  ADD CONSTRAINT `sites_companies_companyid` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_companies_companyid` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  ADD CONSTRAINT `users_sites_siteid` FOREIGN KEY (`site_id`) REFERENCES `sites` (`id`);

--
-- Constraints for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD CONSTRAINT `fk_warehouses_carriers_carrierid` FOREIGN KEY (`carrier_id`) REFERENCES `carriers` (`id`),
  ADD CONSTRAINT `fk_warehouses_companies_companyid` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  ADD CONSTRAINT `fk_warehouses_users_consigneeid` FOREIGN KEY (`consignee_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_warehouses_users_shipperuserid` FOREIGN KEY (`shipper_user_id`) REFERENCES `users` (`id`);
