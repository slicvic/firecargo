<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CarrierTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('carriers')->truncate();

        DB::insert(
            DB::raw("

INSERT INTO `carriers` (`id`, `name`, `code`, `prefix`, `created_at`, `updated_at`)
VALUES
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

            ")
        );
    }
}
