-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Jul 14, 2015 at 04:00 AM
-- Server version: 5.5.34
-- PHP Version: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `cargo`
--
CREATE DATABASE IF NOT EXISTS `cargo` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `cargo`;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=78 ;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `company_id`, `address1`, `address2`, `city`, `state`, `postal_code`, `country_id`, `created_at`, `updated_at`) VALUES
(76, NULL, 1, '', '', '', '', '', 1, '2015-07-14 01:41:19', '2015-07-14 01:41:19'),
(77, 1094, NULL, '', '', '', '', '', 1, '2015-07-14 01:44:35', '2015-07-14 01:44:35');

-- --------------------------------------------------------

--
-- Table structure for table `cargos`
--

CREATE TABLE `cargos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL,
  `carrier_id` bigint(20) unsigned NOT NULL,
  `reference_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `departed_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`),
  KEY `carrier_id` (`carrier_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `cargos`
--

INSERT INTO `cargos` (`id`, `company_id`, `carrier_id`, `reference_number`, `departed_at`, `created_at`, `updated_at`) VALUES
(16, 1, 531, '0011232323', '2015-07-14 00:00:00', '2015-07-14 01:47:13', '2015-07-14 01:47:13');

-- --------------------------------------------------------

--
-- Table structure for table `carriers`
--

CREATE TABLE `carriers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `prefix` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_by_user_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=757 ;

--
-- Dumping data for table `carriers`
--

INSERT INTO `carriers` (`id`, `name`, `code`, `prefix`, `created_by_user_id`, `created_at`, `updated_at`) VALUES
(531, 'AMERICAN AIRLINES', 'AA', '001', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(532, 'CONTINENTAL AIRLINES', 'CO', '005', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(533, 'DELTA AIR LINES', 'DL', '006', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(534, 'DELTA AIR LINES', 'NW', '012', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(535, 'GABON AIRLINES', 'GY', '013', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(536, 'AIR CANADA', 'AC', '014', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(537, 'UNITED AIRLINES CARGO', 'UA', '016', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(538, 'CANADIAN AIRLINES INTL', 'CP', '018', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(539, 'LUFTHANSA CARGO AG', 'LH', '020', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(540, 'FEDEX', 'FX', '023', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(541, 'ALASKA AIRLINES', 'AS', '027', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(542, 'USAIRWAYS', 'US', '037', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(543, 'CAMAIRCO', 'QC', '040', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(544, 'VARIG', 'RG', '042', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(545, 'DRAGONAIR', 'KA', '043', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(546, 'AEROLINEAS ARGENTINAS', 'AR', '044', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(547, 'LAN AIRLINES (LATAM)', 'LA', '045', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(548, 'TAP AIR PORTUGAL', 'TP', '047', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(549, 'CYPRUS AIRWAYS', 'CY', '048', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(550, 'OLYMPIC AIRWAYS', 'OA', '050', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(551, 'AER LINGUS CARGO', 'EI', '053', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(552, 'ALITALIA', 'AZ', '055', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(553, 'AIR FRANCE', 'AF', '057', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(554, 'AIR SEYCHELLES', 'HM', '061', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(555, 'CZECH AIRLINES', 'OK', '064', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(556, 'SAUDI ARABIAN AIRLINES', 'SV', '065', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(557, 'SYRIAN ARAB AIRLINES', 'RB', '070', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(558, 'ETHIOPIAN AIRLINES', 'ET', '071', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(559, 'GULF AIR', 'GF', '072', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(560, 'KLM CARGO', 'KL', '074', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(561, 'IBERIA', 'IB', '075', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(562, 'MIDDLE EAST AIRLINES', 'ME', '076', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(563, 'EGYPTAIR', 'MS', '077', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(564, 'PHILIPPINE AIRLINES', 'PR', '079', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(565, 'LOT POLISH AIRLINES', 'LO', '080', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(566, 'QANTAS AIRWAYS', 'QF', '081', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(567, 'BRUSSELS AIRLINES', 'SN', '082', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(568, 'SOUTH AFRICAN AIRWAYS', 'SA', '083', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(569, 'AIR NEW ZEALAND', 'NZ', '086', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(570, 'IRAN AIR', 'IR', '096', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(571, 'AIR INDIA', 'AI', '098', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(572, 'FINNAIR', 'AY', '105', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(573, 'CARIBBEAN AIRLINES', 'BW', '106', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(574, 'ICELANDAIR', 'FI', '108', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(575, 'BAHAMASAIR', 'UP', '111', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(576, 'CHINA CARGO AIRLINES', 'CK', '112', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(577, 'EL AL', 'LY', '114', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(578, 'AIR SERBIA (JAT)', 'JU', '115', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(579, 'SASSCANDINAVIAN AIRLINES SYSTEM', 'SK', '117', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(580, 'TAAG ANGOLA AIRLINES', 'DT', '118', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(581, 'AIR ALGERIE', 'AH', '124', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(582, 'BRITISH AIRWAYS', 'BA', '125', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(583, 'GARUDA INDONESIA', 'GA', '126', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(584, 'GOL AIRLINES', 'G3', '127', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(585, 'HONGKONG EXPRESS', 'UO', '128', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(586, 'MARTINAIR CARGO', 'MP', '129', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(587, 'JAPAN AIRLINES', 'JL', '131', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(588, 'LACSA AIRLINES OF COSTA RICA', 'LR', '133', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(589, 'AVIANCA CARGO', 'AV', '134', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(590, 'CUBANA DE AVIACION', 'CU', '136', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(591, 'AEROMEXICO CARGO', 'AM', '139', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(592, 'LIAT AIRLINES', 'LI', '140', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(593, 'FLYDUBAI CARGO', 'FZ', '141', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(594, 'LAN CHILE CARGO', 'UC', '145', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(595, 'ROYAL AIR MAROC', 'AT', '147', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(596, 'QATAR AIRWAYS', 'QR', '157', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(597, 'CATHAY PACIFIC AIRWAYS', 'CX', '160', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(598, 'ADRIA AIRWAYS', 'JP', '165', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(599, 'AIR MALAWI', 'QM', '167', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(600, 'CARGOLUX AIRLINES', 'CV', '172', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(601, 'HAWAIIAN AIRLINES', 'HA', '173', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(602, 'EMIRATES', 'EK', '176', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(603, 'KOREAN AIR', 'KE', '180', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(604, 'VARIG', 'RG', '183', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(605, 'TUNISAIR', 'TU', '199', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(606, 'AIR JAMAICA', 'JM', '201', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(607, 'TACA', 'TA', '202', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(608, 'ANA ALL NIPPON CARGO', 'NH', '205', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(609, 'PAKISTAN INTL AIRLINES', 'PK', '214', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(610, 'THAI AIRWAYS', 'TG', '217', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(611, 'KUWAIT AIRWAYS', 'KU', '229', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(612, 'COPA AIRLINES CARGO', 'CM', '230', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(613, 'LAUDA AIR', 'NG', '231', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(614, 'MALAYSIAN AIRLINE SYSTEM', 'MH', '232', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(615, 'JAPAN AIR SYSTEM', 'JD', '234', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(616, 'TURKISH AIRLINES', 'TK', '235', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(617, 'AIR MAURITIUS', 'MK', '239', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(618, 'AIR TAHITI NUI', 'TN', '244', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(619, 'JET CLUB', '0J', '254', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(620, 'AUSTRIAN CARGO', 'OS', '257', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(621, 'AIR MADAGASCAR', 'MD', '258', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(622, 'URAL AIRLINES CARGO', 'U6', '262', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(623, 'FAR EASTERN AIR TRANSPORT', 'EF', '265', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(624, 'TRANS MEDITERRANEAN AIRWAYS', 'TL', '270', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(625, 'KALITTA AIR', 'K4', '272', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(626, 'JETBLUE AIRWAYS', 'B6', '279', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(627, 'TAROM', 'RO', '281', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(628, 'AIR HONG KONG', 'LD', '288', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(629, 'CHINA AIRLINES', 'CI', '297', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(630, 'GLOBAL AVIATION AND SERVICES', '5S', '301', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(631, 'SKY WEST AIRLINES', 'OO', '302', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(632, 'CENTURION AIR CARGO', 'WE', '307', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(633, 'INDIGO CARGO', '6E', '312', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(634, 'AIR ATLANTA ICELANDIC', 'CC', '318', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(635, 'STARLIGHT AIRLINES', 'QP', '321', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(636, 'SHANDONG AIRLINES', 'SC', '324', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(637, 'NORWEGIAN CARGO', 'DY', '328', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(638, 'SATA INTERNATIONAL', 'S4', '331', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(639, 'NORTHERN AIR CARGO', 'NC', '345', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(640, 'ESTAFETA CARGA AEREA', 'E7', '355', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(641, 'CARGOLUX ITALIA', 'C8', '356', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(642, 'SKYGREECE AIRLINES', 'GW', '358', 1020, '2015-07-13 22:33:34', '2015-07-13 22:33:34'),
(643, 'ATLAS AIR', '5Y', '369', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(644, 'TMA TRANS MEDITERRANEAN AIRWAYS', 'TL', '370', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(645, 'CAYMAN AIRWAYS', 'KX', '378', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(646, 'AEGEAN AIRLINES', 'A3', '390', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(647, 'POLAR AIR CARGO', 'PO', '403', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(648, 'UPS AIR CARGO', '5X', '406', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(649, 'NATIONAL AIR CARGO', 'N8', '416', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(650, 'BRINGER AIR CARGO', 'E6', '417', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(651, 'SIBERIA AIRLINES', 'S7', '421', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(652, 'DHL AVIATION/DHL AIRWAYS', 'ER', '423', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(653, 'SILK WAY AIRLINES', 'ZP', '463', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(654, 'AIR ASTANA', 'KC', '465', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(655, 'SHENZHEN AIRLINES', 'ZH', '479', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(656, 'ASTRAL AVIATION', '8V', '485', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(657, 'CARGOJET AIRWAYS', 'W8', '489', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(658, 'SILK WAY WEST AIRLINES', '7L', '501', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(659, 'AEROFLOT', 'SU', '507', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(660, 'JET AIRWAYS INC (US)', 'QJ', '508', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(661, 'ROYAL JORDANIAN', 'RJ', '512', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(662, 'AIR ARABIA', 'G9', '514', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(663, 'UNI AIRWAYS', 'B7', '525', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(664, 'SOUTHWEST AIRLINES', 'WN', '526', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(665, 'TRANS AMERICAN AIRWAYS/TACA PERU', 'T0', '530', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(666, 'JUBBA AIRWAYS', '3J', '535', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(667, 'ABSA CARGO AIRLINE', 'M3', '549', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(668, 'AEROFLOT', 'SU', '555', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(669, 'UKRAINE INTL AIRLINES', 'PS', '566', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(670, 'AIR MOLDOVA', '9U', '572', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(671, 'ALLIED AIR', '4W', '574', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(672, 'COYNE AIRWAYS', '7C', '575', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(673, 'SKYLEASE CARGO', 'KY', '576', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(674, 'AZUL CARGO', 'AD', '577', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(675, 'AIRBRIDGE CARGO', 'RU', '580', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(676, 'JET AIRWAYS', '9W', '589', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(677, 'SRILANKAN CARGO', 'UL', '603', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(678, 'ETIHAD AIRWAYS', 'EY', '607', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(679, 'DHL AVIATION / EUROPEAN AIR TRAN', 'QY', '615', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(680, 'SINGAPORE AIRLINES', 'SQ', '618', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(681, 'BULGARIA AIR', 'FB', '623', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(682, 'PEGASUS CARGO', 'PC', '624', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(683, 'SILK AIR', 'MI', '629', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(684, 'AIR GREENLAND', 'GL', '631', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(685, 'YEMENIA YEMEN AIRWAYS', 'IY', '635', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(686, 'AIR MALTA', 'KM', '643', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(687, 'SOLAR CARGO', '4S', '644', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(688, 'AIR TRANSAT', 'TS', '649', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(689, 'AIR NIUGINI', 'PX', '656', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(690, 'AIR BALTIC', 'BT', '657', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(691, 'AIRMAX CARGO', 'M8', '658', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(692, 'ROYAL BRUNEI AIRLINES', 'BI', '672', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(693, 'TMA TRANS MEDITERRANEAN AIRWAYS', 'N2', '673', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(694, 'AIR MACAU', 'NX', '675', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(695, 'ALOHA AIR CARGO', 'KH', '687', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(696, 'EVA AIRWAYS', 'BR', '695', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(697, 'CAL CARGO AIR LINES', '5C', '700', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(698, 'KENYA AIRWAYS', 'KQ', '706', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(699, 'MOVIE REVIEWS', 'MR', '711', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(700, 'MNG AIRLINES', 'MB', '716', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(701, 'SWISS', 'LX', '724', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(702, 'ARIK AIR', 'W3', '725', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(703, 'TAMPA AIRLINES', 'QT', '729', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(704, 'XIAMENAIR', 'MF', '731', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(705, 'SATA AIR ACORES', 'SP', '737', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(706, 'VIETNAM AIRLINES', 'VN', '738', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(707, 'AIR BERLIN', 'AB', '745', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(708, 'LTU LEISURE CARGO', 'AB', '745', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(709, 'THOMSON AIRWAYS', 'AB', '745', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(710, 'JETAIRFLY', 'TB', '754', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(711, 'TNT AIRWAYS', '3V', '756', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(712, 'AV CARGO', 'Z3', '757', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(713, 'AZERBAIJAN AIRLINES', 'J2', '771', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(714, 'SHANGHAI AIRLINES', 'FM', '774', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(715, 'SPICEJET', 'SG', '775', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(716, 'CHINA EASTERN AIRLINES', 'MU', '781', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(717, 'CHINA SOUTHERN AIRLINES', 'CZ', '784', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(718, 'LEADERJET', '1A', '790', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(719, 'MANDARIN AIRLINES', 'AE', '803', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(720, 'AIRASIA BERHAD', 'AK', '807', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(721, 'AMERIJET INTERNATIONAL', 'M6', '810', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(722, 'SAC SOUTH AMERICAN AIRWAYS', 'S6', '817', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(723, 'RUS (RELIABLE UNIQUE SERVICES) A', 'R4', '827', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(724, 'BANGKOK AIRWAYS', 'PG', '829', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(725, 'CROATIA AIRLINES', 'OU', '831', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(726, 'WESTJET CARGO', 'WS', '838', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(727, 'AIRASIA', 'D7', '843', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(728, 'HONG KONG AIRLINES', 'N8', '851', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(729, 'ATLANTIC SOUTHEAST AIRLINES', 'EV', '862', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(730, 'MASAIR', 'MY', '865', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(731, 'AEROSVIT', 'VV', '870', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(732, 'YANGTZE RIVER EXPRESS AIRLINES', 'Y8', '871', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(733, 'AEROUNION', '6R', '873', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(734, 'SICHUAN AIRLINES', '3U', '876', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(735, 'HAINAN AIRLINES', 'HU', '880', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(736, 'COMAIR', 'OH', '886', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(737, 'TAB TRANSPORTES AEREOS BOLIVIANO', 'B1', '901', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(738, 'AIR ARMENIA', 'QN', '907', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(739, 'OMAN AIR', 'WY', '910', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(740, 'CORSAIR', 'SS', '923', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(741, 'VIRGIN ATLANTIC', 'VS', '932', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(742, 'NIPPON CARGO AIRLINES', 'KZ', '933', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(743, 'VENSECAR INTERNACIONAL', 'V4', '946', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(744, 'TAM BRAZILIAN AIRLINES', 'JJ', '957', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(745, 'INSEL AIR CARGO', '7I', '958', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(746, 'ESTONIAN AIR', 'OV', '960', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(747, 'ASIANA AIRLINES', 'OZ', '988', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(748, 'DHL AERO EXPRESO', 'D5', '992', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(749, 'AIR EUROPA CARGO', 'UX', '996', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(750, 'BIMAN BANGLADESH', 'BG', '997', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(751, 'AIR CHINA', 'CA', '999', 1020, '2015-07-13 22:33:35', '2015-07-13 22:33:35'),
(752, 'FEDEX', '', '', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(753, 'UPS', '', '', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(754, 'DHL', '', '', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(755, 'USPS', '', '', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(756, 'LASERSHIP', '', '', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `corp_code`, `phone`, `fax`, `email`, `created_at`, `updated_at`) VALUES
(1, 'Lantigua Group', 'LG', '', '', '', '2015-03-23 22:58:37', '2015-07-14 01:41:19'),
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=144 ;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `company_id`, `warehouse_id`, `original_warehouse_id`, `type_id`, `status_id`, `cargo_id`, `length`, `width`, `height`, `weight`, `description`, `invoice_number`, `invoice_amount`, `tracking_number`, `ship`, `created_at`, `updated_at`, `deleted_at`) VALUES
(143, 1, 85, 85, 1, 6, 16, 1, 1, 1, 23, 'nfl mug', 'INV321', 23.0000, 'TN123', 1, '2015-07-14 01:46:46', '2015-07-14 01:47:13', '0000-00-00 00:00:00');

--
-- Triggers `packages`
--
DROP TRIGGER IF EXISTS `update_warehouse_status`;
DELIMITER //
CREATE TRIGGER `update_warehouse_status` AFTER UPDATE ON `packages`
 FOR EACH ROW BEGIN

    DECLARE total_wh_pkgs integer;
    DECLARE total_wh_pkgs_in_cargo integer;
    DECLARE total_wh_pkgs_diff integer;
    DECLARE warehouse_status_id integer;

    SET total_wh_pkgs := (SELECT COUNT(*) FROM packages WHERE warehouse_id = new.warehouse_id);
    SET total_wh_pkgs_in_cargo := (SELECT COUNT(*) FROM packages WHERE warehouse_id = new.warehouse_id AND cargo_id IS NOT NULL);
    SET total_wh_pkgs_diff = total_wh_pkgs - total_wh_pkgs_in_cargo;

    IF total_wh_pkgs_diff = 0 THEN
        # Complete (Green)
        SET warehouse_status_id = 3;
    ELSEIF total_wh_pkgs_diff = total_wh_pkgs THEN
        # New (Red)
        SET warehouse_status_id = 1;
    ELSE
        # Pending (Yellow)
        SET warehouse_status_id = 2;
    END IF;

    UPDATE warehouses SET status_id = warehouse_status_id WHERE id = new.warehouse_id;

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
  `is_default` tinyint(3) unsigned DEFAULT NULL,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `package_statuses`
--

INSERT INTO `package_statuses` (`id`, `company_id`, `is_default`, `name`, `created_at`, `updated_at`) VALUES
(1, 2, 0, 'Recibido USA', '0000-00-00 00:00:00', '2015-07-11 21:31:48'),
(2, 2, 0, 'En proceso de despacho USA', '0000-00-00 00:00:00', '2015-07-11 21:31:48'),
(3, 2, 0, 'Despachado desde USA', '0000-00-00 00:00:00', '2015-07-11 21:31:48'),
(4, 2, 0, 'Recibido Colombia', '0000-00-00 00:00:00', '2015-07-11 21:31:48'),
(5, 2, 0, 'En reparto Nacional', '0000-00-00 00:00:00', '2015-07-11 21:31:48'),
(6, 1, NULL, 'Received', '2015-07-14 01:45:35', '2015-07-14 01:45:35');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

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
(1, 1),
(1, 2),
(1094, 5);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1095 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `site_id`, `company_id`, `email`, `password`, `company_name`, `first_name`, `last_name`, `dob`, `id_number`, `phone`, `mobile_phone`, `autoship_setting`, `remember_token`, `logins`, `last_login`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 'vmlantigua@gmail.com', '$2y$10$1jCgi5z6Q47X3B5nJMVtM.xgFEVKCKklHJMxXWYYu1H0yCiiYOcPK', '', 'Slic', 'Vic', '2011-11-11', '13212121212', '', '', 1, 'lM5DQRWxXoi6gQgWqvqM6tLEhu0i0Kbez1n9KmGq7Ik4TqTPiKrFzZhgAenN', 127, '2015-07-14 01:41:07', '2015-01-29 04:41:09', '2015-07-14 01:41:07'),
(1094, NULL, 1, '', NULL, 'AMAZON', '', '', '0000-00-00', '', '', '', 1, NULL, 0, '0000-00-00 00:00:00', '2015-07-14 01:44:35', '2015-07-14 01:44:35');

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL,
  `status_id` int(10) unsigned DEFAULT NULL,
  `shipper_user_id` bigint(20) unsigned NOT NULL,
  `consignee_user_id` bigint(20) unsigned NOT NULL,
  `carrier_id` bigint(20) unsigned DEFAULT NULL,
  `notes` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('red','green','yellow') NOT NULL,
  `arrived_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `courier_id` (`carrier_id`),
  KEY `company_id` (`company_id`),
  KEY `shipper_user_id` (`shipper_user_id`),
  KEY `consignee_user_id` (`consignee_user_id`),
  KEY `status_id` (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=86 ;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`id`, `company_id`, `status_id`, `shipper_user_id`, `consignee_user_id`, `carrier_id`, `notes`, `status`, `arrived_at`, `created_at`, `updated_at`) VALUES
(85, 1, 3, 1094, 1, 753, 'package has scratch', 'red', '2015-07-14 01:45:00', '2015-07-14 01:46:46', '2015-07-14 01:46:46');

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
  ADD CONSTRAINT `fk_packages_cargos_cargoid` FOREIGN KEY (`cargo_id`) REFERENCES `cargos` (`id`),
  ADD CONSTRAINT `fk_packages_companies_companyid` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  ADD CONSTRAINT `fk_packages_packagestatuses_statusid` FOREIGN KEY (`status_id`) REFERENCES `package_statuses` (`id`),
  ADD CONSTRAINT `fk_packages_packagetypes_typeid` FOREIGN KEY (`type_id`) REFERENCES `package_types` (`id`),
  ADD CONSTRAINT `fk_packages_warehouses_originalwarehouseid` FOREIGN KEY (`original_warehouse_id`) REFERENCES `warehouses` (`id`),
  ADD CONSTRAINT `fk_packages_warehouses_warehouseid` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`);

--
-- Constraints for table `package_statuses`
--
ALTER TABLE `package_statuses`
  ADD CONSTRAINT `packagestatuses_companies_companyid` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`);

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
  ADD CONSTRAINT `fk_warehouses_warehousestatuses_statusid` FOREIGN KEY (`status_id`) REFERENCES `warehouse_statuses` (`id`),
  ADD CONSTRAINT `fk_warehouses_carriers_carrierid` FOREIGN KEY (`carrier_id`) REFERENCES `carriers` (`id`),
  ADD CONSTRAINT `fk_warehouses_companies_companyid` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  ADD CONSTRAINT `fk_warehouses_users_consigneeid` FOREIGN KEY (`consignee_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_warehouses_users_shipperuserid` FOREIGN KEY (`shipper_user_id`) REFERENCES `users` (`id`);
