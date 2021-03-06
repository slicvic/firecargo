delimiter |
CREATE TRIGGER update_warehouse_status AFTER UPDATE ON packages
FOR EACH ROW
BEGIN

# Total packages in the warehouse
DECLARE totalPkgs integer;

# Total packages in the warehouse that have been shipped
DECLARE totalPkgsShipped integer;

# Difference of: totalPkgs - totalPkgsShipped
DECLARE totalPkgsDiff integer;

# The new warehouse status id
DECLARE newStatusId integer;

SET totalPkgs := (SELECT COUNT(*) FROM packages WHERE warehouse_id = NEW.warehouse_id);
SET totalPkgsShipped := (SELECT COUNT(*) FROM packages WHERE warehouse_id = NEW.warehouse_id AND shipment_id IS NOT NULL);
SET totalPkgsDiff = totalPkgs - totalPkgsShipped;

IF totalPkgsDiff = 0 THEN
    # Complete (Green)
    SET newStatusId = 3;
ELSEIF totalPkgsDiff = totalPkgs THEN
    # Unprocessed (Red)
    SET newStatusId = 1;
ELSE
    # Pending (Yellow)
    SET newStatusId = 2;
END IF;

UPDATE warehouses SET status_id = newStatusId WHERE id = NEW.warehouse_id;

END;

|

delimiter ;


-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Jul 26, 2015 at 03:42 PM
-- Server version: 5.5.34
-- PHP Version: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `cargo`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL,
  `type_id` int(11) unsigned DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `firstname` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lastname` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mobile_phone` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fax` varchar(39) NOT NULL,
  `autoship` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`),
  KEY `role_id` (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `company_id`, `type_id`, `user_id`, `name`, `firstname`, `lastname`, `email`, `phone`, `mobile_phone`, `fax`, `autoship`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1142, 'Pablo Pueblo', 'Pablo', 'Pueblo', 'client@gmail.com', '233', '4454', '', 1, '0000-00-00 00:00:00', '2015-07-25 15:04:58'),
(7, 1, 1, NULL, 'Lucky Luchy', 'Lucky', 'Luchy', 'luckyluchy@gmail.com', '', '', '', 1, '2015-07-21 03:09:30', '2015-07-21 03:09:30'),
(8, 1, 1, NULL, 'Lucky Luchy', 'Lucky', 'Luchy', 'luckyluchy2@gmail.com', '', '', '', 1, '2015-07-21 03:16:28', '2015-07-21 03:16:28'),
(9, 1, 1, NULL, 'Lucky Luchy', 'Lucky', 'Luchy', 'luckyluchy42@gmail.com', '', '', '', 1, '2015-07-21 03:17:24', '2015-07-21 03:17:24'),
(10, 1, 1, NULL, 'Lucky Luchy', 'Lucky', 'Luchy', 'luckyluchy421@gmail.com', '', '', '', 1, '2015-07-21 03:19:13', '2015-07-21 03:19:13'),
(11, 1, 1, NULL, 'Lucky Luchy', 'Lucky', 'Luchy', 'luckyluchy4210@gmail.com', '', '', '', 1, '2015-07-21 03:19:56', '2015-07-21 03:19:56'),
(12, 1, 1, 1150, 'Lucky41 Luchy41', 'Lucky41', 'Luchy41', 'lucky555@gmail.com', '', '', '', 1, '2015-07-21 03:22:15', '2015-07-21 03:26:27'),
(13, 1, 1, 1151, 'Pepito Billetero', 'Pepito', 'Billetero', 'pepito@gmail.com', '', '', '', 1, '2015-07-21 03:30:57', '2015-07-21 03:31:57'),
(14, 1, 1, 1149, 'Lucky4 Luchy4', 'Lucky4', 'Luchy4', 'luckyluchy421111110@gmail.com', '', '', '', 1, '2015-07-21 21:33:09', '2015-07-21 21:33:09'),
(15, 1, 3, NULL, 'dasdasd', '', '', '', '', '', '', 1, '2015-07-25 14:29:15', '2015-07-25 14:29:15'),
(16, 1, 3, NULL, 'vic', '', '', '', '', '', '', 1, '2015-07-25 14:29:37', '2015-07-25 14:29:37'),
(17, 1, 1, 1152, 'Chapo Sadsd', 'Chapo', 'Sadsd', 'asd@gmail.c', '', '', '', 1, '2015-07-25 15:21:25', '2015-07-25 15:21:25');

-- --------------------------------------------------------

--
-- Table structure for table `account_types`
--

CREATE TABLE `account_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `account_types`
--

INSERT INTO `account_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Client', NULL, NULL),
(3, 'Consignee', NULL, NULL),
(4, 'Shipper', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` bigint(20) unsigned DEFAULT NULL,
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
  UNIQUE KEY `user_id` (`account_id`),
  UNIQUE KEY `company_id` (`company_id`),
  KEY `user_id_2` (`account_id`),
  KEY `company_id_2` (`company_id`),
  KEY `country_id` (`country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=109 ;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `account_id`, `company_id`, `address1`, `address2`, `city`, `state`, `postal_code`, `country_id`, `created_at`, `updated_at`) VALUES
(84, 1, NULL, '6320 NW 114TH AVE', 'ASDASDASD', 'DORAL', 'FLORIDA', '33178', 1, '2015-07-16 04:12:52', '2015-07-21 00:14:23'),
(101, 3, NULL, '', '', '', '', '', 1, '2015-07-21 01:32:08', '2015-07-21 01:32:08'),
(102, 4, NULL, '', '', '', '', '', 1, '2015-07-21 01:32:26', '2015-07-21 01:32:26'),
(103, 5, NULL, '', '', '', '', '', 1, '2015-07-21 01:43:27', '2015-07-21 01:43:27'),
(104, 6, NULL, '', '', '', '', '', 1, '2015-07-21 01:44:33', '2015-07-21 01:44:33'),
(105, 2, NULL, '6320 NW 114TH AVE', 'KK', 'DORAL', 'FLORIDA', '33178', 1, '2015-07-21 01:47:21', '2015-07-21 01:48:04'),
(106, NULL, 1, '6320 NW 114TH AVE', '', 'DORAL', 'FLORIDA', '33178', 1, '2015-07-21 03:39:22', '2015-07-21 03:39:22'),
(107, 15, NULL, 'SD', '', '', '', '', 1, '2015-07-25 14:29:15', '2015-07-25 14:29:15'),
(108, 16, NULL, '1', '', '', '', '', 1, '2015-07-25 14:29:37', '2015-07-25 14:29:37');

-- --------------------------------------------------------

--
-- Table structure for table `carriers`
--

CREATE TABLE `carriers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `prefix` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=771 ;

--
-- Dumping data for table `carriers`
--

INSERT INTO `carriers` (`id`, `name`, `code`, `prefix`, `created_at`, `updated_at`) VALUES
(531, 'AMERICAN AIRLINES', 'AA', '001', '2015-07-13 22:33:34', '2015-07-25 15:11:10'),
(532, 'CONTINENTAL AIRLINES', 'CO', '005', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(533, 'DELTA AIR LINES', 'DL', '006', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(534, 'DELTA AIR LINES', 'NW', '012', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(535, 'GABON AIRLINES', 'GY', '013', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(536, 'AIR CANADA', 'AC', '014', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(537, 'UNITED AIRLINES CARGO', 'UA', '016', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(538, 'CANADIAN AIRLINES INTL', 'CP', '018', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(539, 'LUFTHANSA CARGO AG', 'LH', '020', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(540, 'FEDEX', 'FX', '023', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(541, 'ALASKA AIRLINES', 'AS', '027', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(542, 'USAIRWAYS', 'US', '037', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(543, 'CAMAIRCO', 'QC', '040', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(544, 'VARIG', 'RG', '042', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(545, 'DRAGONAIR', 'KA', '043', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(546, 'AEROLINEAS ARGENTINAS', 'AR', '044', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(547, 'LAN AIRLINES (LATAM)', 'LA', '045', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(548, 'TAP AIR PORTUGAL', 'TP', '047', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(549, 'CYPRUS AIRWAYS', 'CY', '048', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(550, 'OLYMPIC AIRWAYS', 'OA', '050', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(551, 'AER LINGUS CARGO', 'EI', '053', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(552, 'ALITALIA', 'AZ', '055', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(553, 'AIR FRANCE', 'AF', '057', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(554, 'AIR SEYCHELLES', 'HM', '061', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(555, 'CZECH AIRLINES', 'OK', '064', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(556, 'SAUDI ARABIAN AIRLINES', 'SV', '065', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(557, 'SYRIAN ARAB AIRLINES', 'RB', '070', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(558, 'ETHIOPIAN AIRLINES', 'ET', '071', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(559, 'GULF AIR', 'GF', '072', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(560, 'KLM CARGO', 'KL', '074', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(561, 'IBERIA', 'IB', '075', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(562, 'MIDDLE EAST AIRLINES', 'ME', '076', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(563, 'EGYPTAIR', 'MS', '077', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(564, 'PHILIPPINE AIRLINES', 'PR', '079', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(565, 'LOT POLISH AIRLINES', 'LO', '080', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(566, 'QANTAS AIRWAYS', 'QF', '081', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(567, 'BRUSSELS AIRLINES', 'SN', '082', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(568, 'SOUTH AFRICAN AIRWAYS', 'SA', '083', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(569, 'AIR NEW ZEALAND', 'NZ', '086', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(570, 'IRAN AIR', 'IR', '096', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(571, 'AIR INDIA', 'AI', '098', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(572, 'FINNAIR', 'AY', '105', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(573, 'CARIBBEAN AIRLINES', 'BW', '106', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(574, 'ICELANDAIR', 'FI', '108', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(575, 'BAHAMASAIR', 'UP', '111', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(576, 'CHINA CARGO AIRLINES', 'CK', '112', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(577, 'EL AL', 'LY', '114', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(578, 'AIR SERBIA (JAT)', 'JU', '115', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(579, 'SASSCANDINAVIAN AIRLINES SYSTEM', 'SK', '117', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(580, 'TAAG ANGOLA AIRLINES', 'DT', '118', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(581, 'AIR ALGERIE', 'AH', '124', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(582, 'BRITISH AIRWAYS', 'BA', '125', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(583, 'GARUDA INDONESIA', 'GA', '126', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(584, 'GOL AIRLINES', 'G3', '127', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(585, 'HONGKONG EXPRESS', 'UO', '128', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(586, 'MARTINAIR CARGO', 'MP', '129', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(587, 'JAPAN AIRLINES', 'JL', '131', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(588, 'LACSA AIRLINES OF COSTA RICA', 'LR', '133', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(589, 'AVIANCA CARGO', 'AV', '134', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(590, 'CUBANA DE AVIACION', 'CU', '136', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(591, 'AEROMEXICO CARGO', 'AM', '139', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(592, 'LIAT AIRLINES', 'LI', '140', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(593, 'FLYDUBAI CARGO', 'FZ', '141', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(594, 'LAN CHILE CARGO', 'UC', '145', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(595, 'ROYAL AIR MAROC', 'AT', '147', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(596, 'QATAR AIRWAYS', 'QR', '157', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(597, 'CATHAY PACIFIC AIRWAYS', 'CX', '160', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(598, 'ADRIA AIRWAYS', 'JP', '165', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(599, 'AIR MALAWI', 'QM', '167', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(600, 'CARGOLUX AIRLINES', 'CV', '172', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(601, 'HAWAIIAN AIRLINES', 'HA', '173', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(602, 'EMIRATES', 'EK', '176', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(603, 'KOREAN AIR', 'KE', '180', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(604, 'VARIG', 'RG', '183', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(605, 'TUNISAIR', 'TU', '199', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(606, 'AIR JAMAICA', 'JM', '201', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(607, 'TACA', 'TA', '202', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(608, 'ANA ALL NIPPON CARGO', 'NH', '205', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(609, 'PAKISTAN INTL AIRLINES', 'PK', '214', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(610, 'THAI AIRWAYS', 'TG', '217', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(611, 'KUWAIT AIRWAYS', 'KU', '229', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(612, 'COPA AIRLINES CARGO', 'CM', '230', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(613, 'LAUDA AIR', 'NG', '231', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(614, 'MALAYSIAN AIRLINE SYSTEM', 'MH', '232', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(615, 'JAPAN AIR SYSTEM', 'JD', '234', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(616, 'TURKISH AIRLINES', 'TK', '235', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(617, 'AIR MAURITIUS', 'MK', '239', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(618, 'AIR TAHITI NUI', 'TN', '244', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(619, 'JET CLUB', '0J', '254', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(620, 'AUSTRIAN CARGO', 'OS', '257', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(621, 'AIR MADAGASCAR', 'MD', '258', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(622, 'URAL AIRLINES CARGO', 'U6', '262', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(623, 'FAR EASTERN AIR TRANSPORT', 'EF', '265', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(624, 'TRANS MEDITERRANEAN AIRWAYS', 'TL', '270', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(625, 'KALITTA AIR', 'K4', '272', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(626, 'JETBLUE AIRWAYS', 'B6', '279', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(627, 'TAROM', 'RO', '281', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(628, 'AIR HONG KONG', 'LD', '288', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(629, 'CHINA AIRLINES', 'CI', '297', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(630, 'GLOBAL AVIATION AND SERVICES', '5S', '301', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(631, 'SKY WEST AIRLINES', 'OO', '302', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(632, 'CENTURION AIR CARGO', 'WE', '307', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(633, 'INDIGO CARGO', '6E', '312', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(634, 'AIR ATLANTA ICELANDIC', 'CC', '318', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(635, 'STARLIGHT AIRLINES', 'QP', '321', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(636, 'SHANDONG AIRLINES', 'SC', '324', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(637, 'NORWEGIAN CARGO', 'DY', '328', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(638, 'SATA INTERNATIONAL', 'S4', '331', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(639, 'NORTHERN AIR CARGO', 'NC', '345', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(640, 'ESTAFETA CARGA AEREA', 'E7', '355', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(641, 'CARGOLUX ITALIA', 'C8', '356', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(642, 'SKYGREECE AIRLINES', 'GW', '358', '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(643, 'ATLAS AIR', '5Y', '369', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(644, 'TMA TRANS MEDITERRANEAN AIRWAYS', 'TL', '370', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(645, 'CAYMAN AIRWAYS', 'KX', '378', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(646, 'AEGEAN AIRLINES', 'A3', '390', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(647, 'POLAR AIR CARGO', 'PO', '403', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(648, 'UPS AIR CARGO', '5X', '406', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(649, 'NATIONAL AIR CARGO', 'N8', '416', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(650, 'BRINGER AIR CARGO', 'E6', '417', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(651, 'SIBERIA AIRLINES', 'S7', '421', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(652, 'DHL AVIATION/DHL AIRWAYS', 'ER', '423', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(653, 'SILK WAY AIRLINES', 'ZP', '463', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(654, 'AIR ASTANA', 'KC', '465', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(655, 'SHENZHEN AIRLINES', 'ZH', '479', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(656, 'ASTRAL AVIATION', '8V', '485', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(657, 'CARGOJET AIRWAYS', 'W8', '489', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(658, 'SILK WAY WEST AIRLINES', '7L', '501', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(659, 'AEROFLOT', 'SU', '507', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(660, 'JET AIRWAYS INC (US)', 'QJ', '508', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(661, 'ROYAL JORDANIAN', 'RJ', '512', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(662, 'AIR ARABIA', 'G9', '514', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(663, 'UNI AIRWAYS', 'B7', '525', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(664, 'SOUTHWEST AIRLINES', 'WN', '526', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(665, 'TRANS AMERICAN AIRWAYS/TACA PERU', 'T0', '530', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(666, 'JUBBA AIRWAYS', '3J', '535', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(667, 'ABSA CARGO AIRLINE', 'M3', '549', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(668, 'AEROFLOT', 'SU', '555', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(669, 'UKRAINE INTL AIRLINES', 'PS', '566', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(670, 'AIR MOLDOVA', '9U', '572', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(671, 'ALLIED AIR', '4W', '574', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(672, 'COYNE AIRWAYS', '7C', '575', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(673, 'SKYLEASE CARGO', 'KY', '576', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(674, 'AZUL CARGO', 'AD', '577', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(675, 'AIRBRIDGE CARGO', 'RU', '580', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(676, 'JET AIRWAYS', '9W', '589', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(677, 'SRILANKAN CARGO', 'UL', '603', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(678, 'ETIHAD AIRWAYS', 'EY', '607', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(679, 'DHL AVIATION / EUROPEAN AIR TRAN', 'QY', '615', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(680, 'SINGAPORE AIRLINES', 'SQ', '618', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(681, 'BULGARIA AIR', 'FB', '623', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(682, 'PEGASUS CARGO', 'PC', '624', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(683, 'SILK AIR', 'MI', '629', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(684, 'AIR GREENLAND', 'GL', '631', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(685, 'YEMENIA YEMEN AIRWAYS', 'IY', '635', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(686, 'AIR MALTA', 'KM', '643', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(687, 'SOLAR CARGO', '4S', '644', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(688, 'AIR TRANSAT', 'TS', '649', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(689, 'AIR NIUGINI', 'PX', '656', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(690, 'AIR BALTIC', 'BT', '657', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(691, 'AIRMAX CARGO', 'M8', '658', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(692, 'ROYAL BRUNEI AIRLINES', 'BI', '672', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(693, 'TMA TRANS MEDITERRANEAN AIRWAYS', 'N2', '673', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(694, 'AIR MACAU', 'NX', '675', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(695, 'ALOHA AIR CARGO', 'KH', '687', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(696, 'EVA AIRWAYS', 'BR', '695', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(697, 'CAL CARGO AIR LINES', '5C', '700', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(698, 'KENYA AIRWAYS', 'KQ', '706', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(699, 'MOVIE REVIEWS', 'MR', '711', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(700, 'MNG AIRLINES', 'MB', '716', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(701, 'SWISS', 'LX', '724', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(702, 'ARIK AIR', 'W3', '725', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(703, 'TAMPA AIRLINES', 'QT', '729', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(704, 'XIAMENAIR', 'MF', '731', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(705, 'SATA AIR ACORES', 'SP', '737', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(706, 'VIETNAM AIRLINES', 'VN', '738', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(707, 'AIR BERLIN', 'AB', '745', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(708, 'LTU LEISURE CARGO', 'AB', '745', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(709, 'THOMSON AIRWAYS', 'AB', '745', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(710, 'JETAIRFLY', 'TB', '754', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(711, 'TNT AIRWAYS', '3V', '756', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(712, 'AV CARGO', 'Z3', '757', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(713, 'AZERBAIJAN AIRLINES', 'J2', '771', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(714, 'SHANGHAI AIRLINES', 'FM', '774', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(715, 'SPICEJET', 'SG', '775', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(716, 'CHINA EASTERN AIRLINES', 'MU', '781', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(717, 'CHINA SOUTHERN AIRLINES', 'CZ', '784', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(718, 'LEADERJET', '1A', '790', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(719, 'MANDARIN AIRLINES', 'AE', '803', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(720, 'AIRASIA BERHAD', 'AK', '807', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(721, 'AMERIJET INTERNATIONAL', 'M6', '810', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(722, 'SAC SOUTH AMERICAN AIRWAYS', 'S6', '817', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(723, 'RUS (RELIABLE UNIQUE SERVICES) A', 'R4', '827', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(724, 'BANGKOK AIRWAYS', 'PG', '829', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(725, 'CROATIA AIRLINES', 'OU', '831', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(726, 'WESTJET CARGO', 'WS', '838', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(727, 'AIRASIA', 'D7', '843', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(728, 'HONG KONG AIRLINES', 'N8', '851', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(729, 'ATLANTIC SOUTHEAST AIRLINES', 'EV', '862', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(730, 'MASAIR', 'MY', '865', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(731, 'AEROSVIT', 'VV', '870', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(732, 'YANGTZE RIVER EXPRESS AIRLINES', 'Y8', '871', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(733, 'AEROUNION', '6R', '873', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(734, 'SICHUAN AIRLINES', '3U', '876', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(735, 'HAINAN AIRLINES', 'HU', '880', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(736, 'COMAIR', 'OH', '886', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(737, 'TAB TRANSPORTES AEREOS BOLIVIANO', 'B1', '901', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(738, 'AIR ARMENIA', 'QN', '907', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(739, 'OMAN AIR', 'WY', '910', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(740, 'CORSAIR', 'SS', '923', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(741, 'VIRGIN ATLANTIC', 'VS', '932', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(742, 'NIPPON CARGO AIRLINES', 'KZ', '933', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(743, 'VENSECAR INTERNACIONAL', 'V4', '946', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(744, 'TAM BRAZILIAN AIRLINES', 'JJ', '957', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(745, 'INSEL AIR CARGO', '7I', '958', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(746, 'ESTONIAN AIR', 'OV', '960', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(747, 'ASIANA AIRLINES', 'OZ', '988', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(748, 'DHL AERO EXPRESO', 'D5', '992', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(749, 'AIR EUROPA CARGO', 'UX', '996', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(750, 'BIMAN BANGLADESH', 'BG', '997', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(751, 'AIR CHINA', 'CA', '999', '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(752, 'FEDEX', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(753, 'UPS', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(754, 'DHL', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(755, 'USPS', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(756, 'LASERSHIP', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `shortname` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fax` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `has_logo` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `shortname`, `phone`, `fax`, `email`, `created_at`, `updated_at`, `has_logo`) VALUES
(1, 'Lantigua Group', 'LG', '123', '456', '789@gmail.com', '2015-03-23 22:58:37', '2015-07-23 15:16:18', 1),
(2, 'Sion Services Group', 'SSG', '', '', '', '2015-03-23 22:59:07', '2015-07-09 14:39:34', NULL),
(3, 'TESTxad22', 'test2xx22', '', '', '', '2015-07-16 03:42:10', '2015-07-21 02:07:46', NULL);

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
-- Table structure for table `log_user_actions`
--

CREATE TABLE `log_user_actions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(10) unsigned NOT NULL,
  `action` enum('create','read','update','delete') COLLATE utf8_unicode_ci DEFAULT NULL,
  `table_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `record_id` bigint(20) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=131 ;

--
-- Dumping data for table `log_user_actions`
--

INSERT INTO `log_user_actions` (`id`, `user_id`, `action`, `table_name`, `record_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'update', 'users', 1, '2015-07-21 13:32:23', '2015-07-21 13:32:23'),
(2, 1, 'update', 'package_statuses', 1, '2015-07-21 13:32:43', '2015-07-21 13:32:43'),
(3, 1, 'update', 'users', 1, '2015-07-21 13:41:48', '2015-07-21 13:41:48'),
(4, 1, 'update', 'package_statuses', 1, '2015-07-21 13:48:24', '2015-07-21 13:48:24'),
(5, 1, 'update', 'package_statuses', 1, '2015-07-21 13:48:32', '2015-07-21 13:48:32'),
(6, 1, 'update', 'package_statuses', 5, '2015-07-21 13:48:44', '2015-07-21 13:48:44'),
(7, 1, 'update', 'package_statuses', 5, '2015-07-21 13:48:50', '2015-07-21 13:48:50'),
(8, 1, 'update', 'package_statuses', 1, '2015-07-21 13:48:58', '2015-07-21 13:48:58'),
(9, 1, 'update', 'package_statuses', 1, '2015-07-21 13:49:02', '2015-07-21 13:49:02'),
(10, 1, 'update', 'accounts', 1, '2015-07-21 13:58:34', '2015-07-21 13:58:34'),
(11, 1, 'update', 'addresses', 84, '2015-07-21 13:58:34', '2015-07-21 13:58:34'),
(12, 1, 'update', 'addresses', 84, '2015-07-21 13:58:46', '2015-07-21 13:58:46'),
(13, 1, 'update', 'accounts', 1, '2015-07-21 14:00:12', '2015-07-21 14:00:12'),
(14, 1, 'update', 'addresses', 84, '2015-07-21 14:00:12', '2015-07-21 14:00:12'),
(15, 1, 'update', 'accounts', 1, '2015-07-21 14:01:02', '2015-07-21 14:01:02'),
(16, 1, 'update', 'addresses', 84, '2015-07-21 14:01:03', '2015-07-21 14:01:03'),
(17, 1, 'update', 'accounts', 1, '2015-07-21 14:01:09', '2015-07-21 14:01:09'),
(18, 1, 'update', 'addresses', 84, '2015-07-21 14:01:09', '2015-07-21 14:01:09'),
(19, 1, 'update', 'accounts', 1, '2015-07-21 14:01:15', '2015-07-21 14:01:15'),
(20, 1, 'update', 'addresses', 84, '2015-07-21 14:01:15', '2015-07-21 14:01:15'),
(21, 1, 'update', 'accounts', 1, '2015-07-21 14:01:20', '2015-07-21 14:01:20'),
(22, 1, 'update', 'addresses', 84, '2015-07-21 14:01:20', '2015-07-21 14:01:20'),
(23, 1, 'update', 'accounts', 1, '2015-07-21 14:04:32', '2015-07-21 14:04:32'),
(24, 1, 'update', 'addresses', 84, '2015-07-21 14:04:32', '2015-07-21 14:04:32'),
(25, 1, 'update', 'accounts', 1, '2015-07-21 14:04:42', '2015-07-21 14:04:42'),
(26, 1, 'update', 'addresses', 84, '2015-07-21 14:04:42', '2015-07-21 14:04:42'),
(27, 1, 'update', 'accounts', 1, '2015-07-21 14:04:47', '2015-07-21 14:04:47'),
(28, 1, 'update', 'addresses', 84, '2015-07-21 14:04:47', '2015-07-21 14:04:47'),
(29, 1, 'update', 'accounts', 1, '2015-07-21 14:04:58', '2015-07-21 14:04:58'),
(30, 1, 'update', 'addresses', 84, '2015-07-21 14:04:58', '2015-07-21 14:04:58'),
(31, 1, 'update', 'accounts', 1, '2015-07-21 14:05:20', '2015-07-21 14:05:20'),
(32, 1, 'update', 'addresses', 84, '2015-07-21 14:05:20', '2015-07-21 14:05:20'),
(33, 1, 'update', 'accounts', 1, '2015-07-21 14:06:23', '2015-07-21 14:06:23'),
(34, 1, 'update', 'addresses', 84, '2015-07-21 14:06:23', '2015-07-21 14:06:23'),
(35, 1, 'create', 'warehouses', 106, '2015-07-21 15:49:45', '2015-07-21 15:49:45'),
(36, 1, 'create', 'packages', 174, '2015-07-21 15:49:45', '2015-07-21 15:49:45'),
(37, 1, 'create', 'packages', 175, '2015-07-21 15:49:45', '2015-07-21 15:49:45'),
(38, 1, 'update', 'package_statuses', 3, '2015-07-21 15:52:49', '2015-07-21 15:52:49'),
(39, 1, 'update', 'package_statuses', 4, '2015-07-21 15:53:03', '2015-07-21 15:53:03'),
(40, 1, 'update', 'users', 1, '2015-07-21 16:26:19', '2015-07-21 16:26:19'),
(41, 1, 'create', 'warehouses', 107, '2015-07-21 16:54:00', '2015-07-21 16:54:00'),
(42, 1, 'create', 'packages', 176, '2015-07-21 16:54:00', '2015-07-21 16:54:00'),
(43, 1, 'create', 'packages', 177, '2015-07-21 16:54:00', '2015-07-21 16:54:00'),
(44, 1, 'create', 'packages', 178, '2015-07-21 16:54:00', '2015-07-21 16:54:00'),
(45, 1, 'update', 'warehouses', 106, '2015-07-21 16:54:21', '2015-07-21 16:54:21'),
(46, 1, 'update', 'packages', 174, '2015-07-21 16:54:21', '2015-07-21 16:54:21'),
(47, 1, 'update', 'packages', 175, '2015-07-21 16:54:21', '2015-07-21 16:54:21'),
(48, 1, 'create', 'shipments', 29, '2015-07-21 17:31:50', '2015-07-21 17:31:50'),
(49, 1, 'update', 'shipments', 29, '2015-07-21 17:43:19', '2015-07-21 17:43:19'),
(50, 1, 'create', 'carriers', 770, '2015-07-21 17:46:35', '2015-07-21 17:46:35'),
(51, 1, 'create', 'shipments', 30, '2015-07-21 17:46:35', '2015-07-21 17:46:35'),
(52, 1, 'update', 'shipments', 30, '2015-07-21 17:51:12', '2015-07-21 17:51:12'),
(53, 1, 'update', 'shipments', 30, '2015-07-21 17:55:04', '2015-07-21 17:55:04'),
(54, 1, 'update', 'warehouses', 107, '2015-07-21 18:09:52', '2015-07-21 18:09:52'),
(55, 1, 'update', 'packages', 176, '2015-07-21 18:09:52', '2015-07-21 18:09:52'),
(56, 1, 'update', 'packages', 177, '2015-07-21 18:09:52', '2015-07-21 18:09:52'),
(57, 1, 'update', 'packages', 178, '2015-07-21 18:09:52', '2015-07-21 18:09:52'),
(58, 1, 'update', 'warehouses', 107, '2015-07-21 18:10:44', '2015-07-21 18:10:44'),
(59, 1, 'update', 'packages', 176, '2015-07-21 18:10:44', '2015-07-21 18:10:44'),
(60, 1, 'update', 'packages', 177, '2015-07-21 18:10:44', '2015-07-21 18:10:44'),
(61, 1, 'update', 'packages', 178, '2015-07-21 18:10:44', '2015-07-21 18:10:44'),
(62, 1, 'create', 'warehouses', 108, '2015-07-21 18:12:16', '2015-07-21 18:12:16'),
(63, 1, 'create', 'packages', 179, '2015-07-21 18:12:16', '2015-07-21 18:12:16'),
(64, 1, 'update', 'users', 1, '2015-07-21 20:56:39', '2015-07-21 20:56:39'),
(65, 1, 'update', 'shipments', 29, '2015-07-21 21:01:35', '2015-07-21 21:01:35'),
(66, 1, 'create', 'shipments', 31, '2015-07-21 21:05:29', '2015-07-21 21:05:29'),
(67, 1, 'update', 'shipments', 29, '2015-07-21 21:05:39', '2015-07-21 21:05:39'),
(68, 1, 'create', 'accounts', 14, '2015-07-21 21:33:09', '2015-07-21 21:33:09'),
(69, 1, 'update', 'users', 1149, '2015-07-21 21:33:09', '2015-07-21 21:33:09'),
(70, 1, 'update', 'users', 1, '2015-07-22 00:47:27', '2015-07-22 00:47:27'),
(71, 1, 'update', 'users', 1, '2015-07-22 21:06:30', '2015-07-22 21:06:30'),
(72, 1, 'update', 'users', 1, '2015-07-22 22:02:11', '2015-07-22 22:02:11'),
(73, 1, 'update', 'users', 1, '2015-07-22 22:02:31', '2015-07-22 22:02:31'),
(74, 1, 'update', 'users', 1, '2015-07-22 22:06:26', '2015-07-22 22:06:26'),
(75, 1, 'update', 'users', 1, '2015-07-22 22:06:52', '2015-07-22 22:06:52'),
(76, 1, 'update', 'users', 1, '2015-07-22 22:07:28', '2015-07-22 22:07:28'),
(77, 1, 'update', 'users', 1, '2015-07-22 22:12:26', '2015-07-22 22:12:26'),
(78, 1, 'update', 'companies', 1, '2015-07-22 22:12:42', '2015-07-22 22:12:42'),
(79, 1, 'update', 'companies', 1, '2015-07-22 22:12:59', '2015-07-22 22:12:59'),
(80, 1, 'update', 'companies', 1, '2015-07-22 22:13:33', '2015-07-22 22:13:33'),
(81, 1, 'update', 'companies', 1, '2015-07-22 22:13:51', '2015-07-22 22:13:51'),
(82, 1, 'update', 'companies', 1, '2015-07-22 22:16:26', '2015-07-22 22:16:26'),
(83, 1, 'update', 'companies', 1, '2015-07-22 22:16:36', '2015-07-22 22:16:36'),
(84, 1, 'update', 'companies', 1, '2015-07-22 22:27:53', '2015-07-22 22:27:53'),
(85, 1, 'update', 'companies', 1, '2015-07-22 22:28:48', '2015-07-22 22:28:48'),
(86, 1, 'update', 'users', 1, '2015-07-22 22:29:23', '2015-07-22 22:29:23'),
(87, 1, 'update', 'users', 1, '2015-07-22 22:29:37', '2015-07-22 22:29:37'),
(88, 1, 'update', 'users', 1, '2015-07-23 12:10:58', '2015-07-23 12:10:58'),
(89, 1, 'update', 'users', 1, '2015-07-23 12:43:32', '2015-07-23 12:43:32'),
(90, 1, 'update', 'companies', 1, '2015-07-23 13:14:16', '2015-07-23 13:14:16'),
(91, 1, 'update', 'companies', 1, '2015-07-23 13:14:27', '2015-07-23 13:14:27'),
(92, 1, 'update', 'users', 1, '2015-07-23 13:14:58', '2015-07-23 13:14:58'),
(93, 1, 'update', 'companies', 1, '2015-07-23 13:15:43', '2015-07-23 13:15:43'),
(94, 1, 'update', 'companies', 1, '2015-07-23 13:17:16', '2015-07-23 13:17:16'),
(95, 1, 'update', 'users', 1, '2015-07-23 13:18:36', '2015-07-23 13:18:36'),
(96, 1, 'update', 'users', 1, '2015-07-23 14:30:27', '2015-07-23 14:30:27'),
(97, 1, 'update', 'companies', 1, '2015-07-23 14:30:51', '2015-07-23 14:30:51'),
(98, 1, 'update', 'users', 1, '2015-07-23 14:36:30', '2015-07-23 14:36:30'),
(99, 1, 'update', 'companies', 1, '2015-07-23 15:08:33', '2015-07-23 15:08:33'),
(100, 1, 'update', 'companies', 1, '2015-07-23 15:08:37', '2015-07-23 15:08:37'),
(101, 1, 'update', 'companies', 1, '2015-07-23 15:08:48', '2015-07-23 15:08:48'),
(102, 1, 'update', 'companies', 1, '2015-07-23 15:12:02', '2015-07-23 15:12:02'),
(103, 1, 'update', 'users', 1, '2015-07-23 15:12:11', '2015-07-23 15:12:11'),
(104, 1, 'update', 'users', 1, '2015-07-23 15:12:17', '2015-07-23 15:12:17'),
(105, 1, 'update', 'users', 1, '2015-07-23 15:13:28', '2015-07-23 15:13:28'),
(106, 1, 'update', 'users', 1, '2015-07-23 15:14:40', '2015-07-23 15:14:40'),
(107, 1, 'update', 'users', 1, '2015-07-23 15:15:48', '2015-07-23 15:15:48'),
(108, 1, 'update', 'users', 1, '2015-07-23 15:15:55', '2015-07-23 15:15:55'),
(109, 1, 'update', 'companies', 1, '2015-07-23 15:16:18', '2015-07-23 15:16:18'),
(110, 1, 'update', 'users', 1, '2015-07-25 02:19:22', '2015-07-25 02:19:22'),
(111, 1, 'update', 'users', 1, '2015-07-25 14:28:07', '2015-07-25 14:28:07'),
(112, 1, 'create', 'accounts', 15, '2015-07-25 14:29:15', '2015-07-25 14:29:15'),
(113, 1, 'create', 'addresses', 107, '2015-07-25 14:29:15', '2015-07-25 14:29:15'),
(114, 1, 'create', 'accounts', 16, '2015-07-25 14:29:37', '2015-07-25 14:29:37'),
(115, 1, 'create', 'addresses', 108, '2015-07-25 14:29:37', '2015-07-25 14:29:37'),
(116, 1, 'update', 'accounts', 1, '2015-07-25 15:04:58', '2015-07-25 15:04:58'),
(117, 1, 'update', 'users', 1142, '2015-07-25 15:04:58', '2015-07-25 15:04:58'),
(118, 1, 'update', 'accounts', 1, '2015-07-25 15:05:00', '2015-07-25 15:05:00'),
(119, 1, 'update', 'users', 1142, '2015-07-25 15:05:00', '2015-07-25 15:05:00'),
(120, 1, 'update', 'carriers', 531, '2015-07-25 15:11:06', '2015-07-25 15:11:06'),
(121, 1, 'update', 'carriers', 531, '2015-07-25 15:11:10', '2015-07-25 15:11:10'),
(122, 1, 'create', 'accounts', 17, '2015-07-25 15:21:25', '2015-07-25 15:21:25'),
(123, 1, 'create', 'users', 1152, '2015-07-25 15:21:25', '2015-07-25 15:21:25'),
(124, 1, 'create', 'warehouses', 109, '2015-07-25 16:20:24', '2015-07-25 16:20:24'),
(125, 1, 'create', 'packages', 180, '2015-07-25 16:20:24', '2015-07-25 16:20:24'),
(126, 1, 'create', 'shipments', 32, '2015-07-25 16:31:04', '2015-07-25 16:31:04'),
(127, 1, 'update', 'shipments', 32, '2015-07-25 16:31:29', '2015-07-25 16:31:29'),
(128, 1, 'update', 'shipments', 32, '2015-07-25 16:31:33', '2015-07-25 16:31:33'),
(129, 1, 'update', 'warehouses', 109, '2015-07-25 16:32:39', '2015-07-25 16:32:39'),
(130, 1, 'update', 'packages', 180, '2015-07-25 16:32:39', '2015-07-25 16:32:39');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL,
  `warehouse_id` bigint(20) unsigned DEFAULT NULL,
  `type_id` bigint(20) unsigned DEFAULT NULL,
  `status_id` bigint(20) unsigned DEFAULT NULL,
  `shipment_id` int(10) unsigned DEFAULT NULL,
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
  KEY `company_id` (`company_id`),
  KEY `shipment_id` (`shipment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=181 ;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `company_id`, `warehouse_id`, `type_id`, `status_id`, `shipment_id`, `length`, `width`, `height`, `weight`, `description`, `invoice_number`, `invoice_amount`, `tracking_number`, `ship`, `created_at`, `updated_at`, `deleted_at`) VALUES
(180, 1, 109, 1, 4, 32, 12, 12, 12, 12, '', '', 344.0000, '', 1, '2015-07-25 16:20:24', '2015-07-25 16:32:39', '0000-00-00 00:00:00');

--
-- Triggers `packages`
--
DROP TRIGGER IF EXISTS `update_warehouse_status`;
DELIMITER //
CREATE TRIGGER `update_warehouse_status` AFTER UPDATE ON `packages`
 FOR EACH ROW BEGIN

    # Total packages in the warehouse
    DECLARE totalPkgs integer;
    # Total packages in the warehouse that have been shipped
    DECLARE totalPkgsShipped integer;
    # Difference of: totalPkgs - totalPkgsShipped
    DECLARE totalPkgsDiff integer;
    # The new warehouse status id
    DECLARE newWarehouseStatusId integer;

    SET totalPkgs := (SELECT COUNT(*) FROM packages WHERE warehouse_id = NEW.warehouse_id);
    SET totalPkgsShipped := (SELECT COUNT(*) FROM packages WHERE warehouse_id = NEW.warehouse_id AND shipment_id IS NOT NULL);
    SET totalPkgsDiff = totalPkgs - totalPkgsShipped;

    IF totalPkgsDiff = 0 THEN
        # Complete (Green)
        SET newWarehouseStatusId = 3;
    ELSEIF totalPkgsDiff = totalPkgs THEN
        # New (Red)
        SET newWarehouseStatusId = 1;
    ELSE
        # Pending (Yellow)
        SET newWarehouseStatusId = 2;
    END IF;

    UPDATE warehouses SET status_id = newWarehouseStatusId WHERE id = NEW.warehouse_id;

END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `package_statuses`
--

CREATE TABLE `package_statuses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL,
  `default` tinyint(3) unsigned DEFAULT NULL,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `package_statuses`
--

INSERT INTO `package_statuses` (`id`, `company_id`, `default`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 'Recibido USA', '0000-00-00 00:00:00', '2015-07-21 15:53:03'),
(2, 2, 0, 'En proceso de despacho USA', '0000-00-00 00:00:00', '2015-07-16 03:30:48'),
(3, 1, 0, 'Despachado desde USA', '0000-00-00 00:00:00', '2015-07-21 15:53:03'),
(4, 1, 1, 'Recibido Colombia', '0000-00-00 00:00:00', '2015-07-21 15:53:03'),
(5, 1, 0, 'test2', '2015-07-21 13:24:13', '2015-07-21 15:53:03');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `package_types`
--

INSERT INTO `package_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Box', '2015-03-23 01:29:12', '2015-07-15 19:21:33'),
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'Administrative user, has access to everything.', '0000-00-00 00:00:00', '2015-07-16 03:57:48'),
(3, 'Super Agent', 'Owner of a registered company', '0000-00-00 00:00:00', '2015-07-17 19:23:12'),
(9, 'Client', 'Customer of a company', '0000-00-00 00:00:00', '2015-07-17 19:27:19');

-- --------------------------------------------------------

--
-- Table structure for table `shipments`
--

CREATE TABLE `shipments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL,
  `carrier_id` bigint(20) unsigned NOT NULL,
  `reference_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `departed_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `creator_user_id` int(11) DEFAULT NULL,
  `updater_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`),
  KEY `carrier_id` (`carrier_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `shipments`
--

INSERT INTO `shipments` (`id`, `company_id`, `carrier_id`, `reference_number`, `departed_at`, `created_at`, `updated_at`, `creator_user_id`, `updater_user_id`) VALUES
(32, 1, 648, '2132132', '2015-07-25 00:00:00', '2015-07-25 16:31:04', '2015-07-25 16:31:29', 1, 1),
(33, 1, 648, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL);

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
(6, 1, 'testx', '2015-07-16 04:01:08', '2015-07-16 04:02:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL,
  `role_id` int(11) unsigned DEFAULT NULL,
  `firstname` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `lastname` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(3) unsigned NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `logins` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `has_photo` tinyint(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1153 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `company_id`, `role_id`, `firstname`, `lastname`, `email`, `password`, `active`, `remember_token`, `logins`, `last_login`, `created_at`, `updated_at`, `has_photo`) VALUES
(1, 1, 1, 'Slicx', 'Vicx', 'vmlantigua@gmail.com', '$2y$10$F6qNSi3uFaE47opz3UItTuIbuGK53xO2kI7uLLnALfyFlnTE89j.u', 1, 'hQOyuIrJISmE5NYscNpOkNfsqpQc58sGC7pbnkJ65T4w9rUPu2dUQEL3VdAj', 166, '2015-07-25 14:28:07', '2015-01-29 04:41:09', '2015-07-25 14:28:07', 1),
(1142, 1, 9, 'Pablo', 'Pueblo', 'client@gmail.com', '$2y$10$YVETz6HFt5ytFpB.ddVWu.ckE5l0VbOW450Hqcvb3QZQttaAYaTya', 1, '1GZhzpgG7SQrm9YDKVU545RX0N0YytYBXHDdezxGfl4Q4NI9F6kRR9YQUaZE', 4, '2015-07-21 02:11:09', '0000-00-00 00:00:00', '2015-07-25 15:05:00', NULL),
(1143, 1, 9, 'Admin', 'Man', 'vmlantiguadd@gmail.com', '$2y$10$Dk/dBUQlzG1nk/uB0B7kGeEp/n1yzlc5UTyTJGyzmrUx8Wm4upFrO', 1, '', 0, '0000-00-00 00:00:00', '2015-07-21 03:01:57', '2015-07-21 03:05:28', NULL),
(1144, 1, 9, 'Lucky', 'Luchy', 'luckyluchy@gmail.com', '$2y$10$YEab0YSkv.ErBAeXv7ELSud4c6K.TbmVKYc4GKKXWYyV7LHA6FWSa', 0, '', 0, '0000-00-00 00:00:00', '2015-07-21 03:09:30', '2015-07-21 03:09:30', NULL),
(1145, 1, 9, 'Lucky', 'Luchy', 'luckyluchy2@gmail.com', '$2y$10$gBVN8nOHR/5M5Z2HJQHoh.C9rvwOh2j7J/zxiJXO1wobgyad52bPu', 0, '', 0, '0000-00-00 00:00:00', '2015-07-21 03:16:28', '2015-07-21 03:16:28', NULL),
(1146, 1, 9, 'Lucky', 'Luchy', 'luckyluchy42@gmail.com', '$2y$10$IIo.qzcH7reFGkX7gWNuBOWhy66hh/8/8/.bvMqZnLG7LuAWNQcKW', 0, '', 0, '0000-00-00 00:00:00', '2015-07-21 03:17:24', '2015-07-21 03:17:24', NULL),
(1147, 1, 9, 'Lucky', 'Luchy', 'luckyluchy421@gmail.com', '$2y$10$o828eFdx4y2jRewyL3Ad8uLbkhWvRcU/2wYa8S7w2gEAihxmlErnC', 0, '', 0, '0000-00-00 00:00:00', '2015-07-21 03:19:13', '2015-07-21 03:19:13', NULL),
(1148, 1, 9, 'Lucky', 'Luchy', 'luckyluchy4210@gmail.com', '$2y$10$UkbbLUt6V7IwEQ8xhwsCKO0tn5WZgTlyXhujq45qXR4r4YPt15tnq', 0, '', 0, '0000-00-00 00:00:00', '2015-07-21 03:19:56', '2015-07-21 03:19:56', NULL),
(1149, 2, 9, 'Lucky4', 'Luchy4', 'luckyluchy421111110@gmail.com', '$2y$10$Npa0dKuQdfmcgDB6j8z.IeMiHmuPzpwYvBNWqBMZJoVlihGPO1hRO', 0, '', 0, '0000-00-00 00:00:00', '2015-07-21 03:21:54', '2015-07-21 21:33:09', NULL),
(1150, 1, 9, 'Lucky41', 'Luchy41', 'lucky555@gmail.com', '$2y$10$8pa/8dEXA3aC4uS8clRsbutgoqsS5ytpiYal.5awDu0kvcWBnYuQW', 0, '', 0, '0000-00-00 00:00:00', '2015-07-21 03:22:15', '2015-07-21 03:30:36', NULL),
(1151, 1, 9, 'Pepito', 'Billetero', 'pepito@gmail.com', '$2y$10$1CuPYbPMjWocKfng3lHIduW3EUUEBUe/05HXaLxoL/GmQrO8jtMUa', 0, '', 0, '0000-00-00 00:00:00', '2015-07-21 03:30:57', '2015-07-21 03:31:57', NULL),
(1152, 2, 9, 'Chapo', 'Sadsd', 'asd@gmail.c', '$2y$10$MY4byNzCc8HE.ijM0TDjN.bdNoI3eztaDZ0lo.bC7z9Yjb.Vv0GJa', 0, '', 0, '0000-00-00 00:00:00', '2015-07-25 15:21:25', '2015-07-25 15:21:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL,
  `status_id` int(10) unsigned DEFAULT '1',
  `shipper_account_id` bigint(20) unsigned NOT NULL,
  `consignee_account_id` bigint(20) unsigned NOT NULL,
  `carrier_id` bigint(20) unsigned DEFAULT NULL,
  `notes` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `creator_user_id` int(10) unsigned NOT NULL,
  `updater_user_id` int(11) NOT NULL,
  `arrived_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `courier_id` (`carrier_id`),
  KEY `company_id` (`company_id`),
  KEY `shipper_user_id` (`shipper_account_id`),
  KEY `consignee_user_id` (`consignee_account_id`),
  KEY `status_id` (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=110 ;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`id`, `company_id`, `status_id`, `shipper_account_id`, `consignee_account_id`, `carrier_id`, `notes`, `creator_user_id`, `updater_user_id`, `arrived_at`, `created_at`, `updated_at`) VALUES
(109, 1, 3, 16, 1, 575, '', 1, 1, '2015-07-25 16:19:00', '2015-07-25 16:20:23', '2015-07-25 16:32:39');

-- --------------------------------------------------------

--
-- Table structure for table `warehouse_statuses`
--

CREATE TABLE `warehouse_statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `warehouse_statuses`
--

INSERT INTO `warehouse_statuses` (`id`, `name`, `color`) VALUES
(1, 'new', 'red'),
(2, 'pending', 'yellow'),
(3, 'complete', 'green');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_countries_countryid` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `fk_addresses_companies_companyid` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `packages`
--
ALTER TABLE `packages`
  ADD CONSTRAINT `fk_packages_companies_companyid` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  ADD CONSTRAINT `fk_packages_packagestatuses_statusid` FOREIGN KEY (`status_id`) REFERENCES `package_statuses` (`id`),
  ADD CONSTRAINT `fk_packages_packagetypes_typeid` FOREIGN KEY (`type_id`) REFERENCES `package_types` (`id`),
  ADD CONSTRAINT `fk_packages_shipments_shipmentid` FOREIGN KEY (`shipment_id`) REFERENCES `shipments` (`id`),
  ADD CONSTRAINT `fk_packages_warehouses_warehouseid` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`);

--
-- Constraints for table `package_statuses`
--
ALTER TABLE `package_statuses`
  ADD CONSTRAINT `packagestatuses_companies_companyid` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`);

--
-- Constraints for table `shipments`
--
ALTER TABLE `shipments`
  ADD CONSTRAINT `containers_carriers_carrierid` FOREIGN KEY (`carrier_id`) REFERENCES `carriers` (`id`),
  ADD CONSTRAINT `containers_companies_companyid` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`);

--
-- Constraints for table `sites`
--
ALTER TABLE `sites`
  ADD CONSTRAINT `sites_companies_companyid` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_companies_companyid` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  ADD CONSTRAINT `fk_users_roles_roleid` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
