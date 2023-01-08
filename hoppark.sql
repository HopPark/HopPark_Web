-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 08 Oca 2023, 23:52:25
-- Sunucu sürümü: 10.4.27-MariaDB
-- PHP Sürümü: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `hoppark`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `admin_accounts`
--

CREATE TABLE `admin_accounts` (
  `id` int(25) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `series_id` varchar(60) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `expires` datetime DEFAULT NULL,
  `admin_type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Tablo döküm verisi `admin_accounts`
--

INSERT INTO `admin_accounts` (`id`, `user_name`, `password`, `series_id`, `remember_token`, `expires`, `admin_type`) VALUES
(4, 'superadmin', '$2y$10$eo7.w0Ttuy8mOBMvDlGqDeewQERkXu//7qO3jXp5NC76LwfAZpNrO', 'rvuWJHMd5LTxLC2J', '$2y$10$LDUi4w/UAM2PgfMoKkLo4.igJX39G5/WQOEDHRaDy3y2KZeIxXggm', '2019-02-16 22:39:57', 'super'),
(7, 'anand', '$2y$10$OrQFRZdSUP3X2kvGZrg.zeplQkxcJAq1s6atRehyCpbEvOVPu8KPe', NULL, NULL, NULL, 'admin'),
(8, 'admin', '$2y$10$RnDwpen5c8.gtZLaxHEHDOKWY77t/20A4RRkWBsjlPuu7Wmy0HyBu', 'MyG5Xw2I12EWdJeD', '$2y$10$XL/RhpCz.uQoWE1xV77Wje4I4ker.gtg7YV4yqNwLZfzIYnP7E8Na', '2019-08-22 01:12:33', 'admin');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cars`
--

CREATE TABLE `cars` (
  `car_id` int(11) NOT NULL,
  `car_owner_id` int(11) NOT NULL,
  `car_brand` varchar(15) NOT NULL,
  `car_model` varchar(15) NOT NULL,
  `car_plate` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `cars`
--

INSERT INTO `cars` (`car_id`, `car_owner_id`, `car_brand`, `car_model`, `car_plate`) VALUES
(2, 2, 'Ford', 'Focus', '34b8464'),
(13, 1, '4', '4', '34b8465'),
(14, 1, '5', '5', '5'),
(15, 1, '6', '6', '6'),
(16, 1, '7', '7', '7'),
(17, 1, 'clio', 'bmw', 'r');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `car_parking_logs`
--

CREATE TABLE `car_parking_logs` (
  `cpl_id` int(11) NOT NULL,
  `cpl_car_plate` varchar(8) NOT NULL,
  `cpl_pl_id` int(11) NOT NULL,
  `cpl_enter_date` datetime NOT NULL,
  `cpl_exit_date` datetime DEFAULT NULL,
  `cpl_total_payment` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `car_parking_logs`
--

INSERT INTO `car_parking_logs` (`cpl_id`, `cpl_car_plate`, `cpl_pl_id`, `cpl_enter_date`, `cpl_exit_date`, `cpl_total_payment`) VALUES
(1, '34akz143', 1, '2022-12-01 10:19:21', '2022-12-01 15:19:21', 100),
(2, '34b8464', 1, '2022-12-02 12:00:00', '2022-12-02 15:00:00', 60),
(3, '34akz143', 2, '2022-12-03 10:19:21', '2022-12-03 15:19:21', 100),
(4, '34b8464', 2, '2022-12-05 12:00:00', '2022-12-05 15:00:00', 60),
(5, '34b8465', 1, '2022-12-05 12:00:00', '2022-12-05 15:30:00', 88),
(6, '34b8464', 1, '2022-12-05 12:00:00', '2022-12-05 15:00:00', 75),
(7, '34b8464', 1, '2022-12-05 12:00:00', '2022-12-05 15:00:00', 75),
(11, '34b8464', 1, '2022-12-05 12:00:00', '2022-12-05 15:00:00', 75),
(12, '34b8464', 1, '2022-12-05 12:00:00', '2022-12-05 15:00:00', 75),
(13, '34b8464', 1, '2022-12-05 12:00:00', '2022-12-05 15:00:00', 75),
(14, '34b8464', 1, '2022-12-05 12:00:00', '2022-12-05 15:00:00', 75),
(15, '34b8464', 1, '2022-12-05 12:00:00', '2022-12-05 15:00:00', 75),
(16, '34b8464', 1, '2022-12-05 12:00:00', NULL, NULL),
(17, '06ANK06', 1, '2023-01-08 22:08:23', '2023-01-08 22:08:43', 0),
(18, '06ANK06', 1, '2023-01-08 22:08:47', '2023-01-08 22:14:14', 2),
(19, '06ANK06', 1, '2023-01-08 22:14:10', NULL, NULL),
(20, '06ANK06', 1, '2023-01-08 22:15:30', NULL, NULL),
(21, '59TKR59', 1, '2023-01-08 22:15:45', '2023-01-08 22:20:37', 2),
(23, '59TKR59', 1, '2023-01-08 22:20:33', NULL, NULL),
(24, '06ANK06', 1, '2023-01-08 22:20:53', NULL, NULL),
(25, '06ANK06', 1, '2023-01-08 22:22:36', NULL, NULL),
(26, '09AYD09', 1, '2023-01-08 22:22:53', NULL, NULL),
(27, '05ARK08', 1, '2023-01-08 22:23:23', NULL, NULL);

--
-- Tetikleyiciler `car_parking_logs`
--
DELIMITER $$
CREATE TRIGGER `car_parking_logs_before_update` BEFORE UPDATE ON `car_parking_logs` FOR EACH ROW IF NEW.cpl_exit_date < NEW.cpl_enter_date THEN
SIGNAL SQLSTATE '50001' SET MESSAGE_TEXT = 'Exit date must be greater then enter date.';
END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cities`
--

CREATE TABLE `cities` (
  `city_id` int(11) NOT NULL,
  `city_name` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `cities`
--

INSERT INTO `cities` (`city_id`, `city_name`) VALUES
(1, 'Adana'),
(2, 'Adıyaman'),
(3, 'Afyon'),
(4, 'Ağrı'),
(5, 'Amasya'),
(6, 'Ankara'),
(7, 'Antalya'),
(8, 'Artvin'),
(9, 'Aydın'),
(10, 'Balıkesir'),
(11, 'Bilecik'),
(12, 'Bingöl'),
(13, 'Bitlis'),
(14, 'Bolu'),
(15, 'Burdur'),
(16, 'Bursa'),
(17, 'Çanakkale'),
(18, 'Çankırı'),
(19, 'Çorum'),
(20, 'Denizli'),
(21, 'Diyarbakır'),
(22, 'Edirne'),
(23, 'Elâzığ'),
(24, 'Erzincan'),
(25, 'Erzurum'),
(26, 'Eskişehir'),
(27, 'Gaziantep'),
(28, 'Giresun'),
(29, 'Gümüşhane'),
(30, 'Hakkâri'),
(31, 'Hatay'),
(32, 'Isparta'),
(33, 'Mersin'),
(34, 'İstanbul'),
(35, 'İzmir'),
(36, 'Kars'),
(37, 'Kastamonu'),
(38, 'Kayseri'),
(39, 'Kırklareli'),
(40, 'Kırşehir'),
(41, 'Kocaeli'),
(42, 'Konya'),
(43, 'Kütahya'),
(44, 'Malatya'),
(45, 'Manisa'),
(46, 'Kahramanmaraş'),
(47, 'Mardin'),
(48, 'Muğla'),
(49, 'Muş'),
(50, 'Nevşehir'),
(51, 'Niğde'),
(52, 'Ordu'),
(53, 'Rize'),
(54, 'Sakarya'),
(55, 'Samsun'),
(56, 'Siirt'),
(57, 'Sinop'),
(58, 'Sivas'),
(59, 'Tekirdağ'),
(60, 'Tokat'),
(61, 'Trabzon'),
(62, 'Tunceli'),
(63, 'Şanlıurfa'),
(64, 'Uşak'),
(65, 'Van'),
(66, 'Yozgat'),
(67, 'Zonguldak'),
(68, 'Aksaray'),
(69, 'Bayburt'),
(70, 'Karaman'),
(71, 'Kırıkkale'),
(72, 'Batman'),
(73, 'Şırnak'),
(74, 'Bartın'),
(75, 'Ardahan'),
(76, 'Iğdır'),
(77, 'Yalova'),
(78, 'Karabük'),
(79, 'Kilis'),
(80, 'Osmaniye'),
(81, 'Düzce');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `districts`
--

CREATE TABLE `districts` (
  `district_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `district_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `districts`
--

INSERT INTO `districts` (`district_id`, `city_id`, `district_name`) VALUES
(1, 34, 'Adalar'),
(2, 34, 'Arnavutköy'),
(3, 34, 'Ataşehir'),
(4, 34, 'Avcılar'),
(5, 34, 'Bağcılar'),
(6, 34, 'Bahçelievler'),
(7, 34, 'Bakırköy'),
(8, 34, 'Başakşehir'),
(9, 34, 'Bayrampaşa'),
(10, 34, 'Beşiktaş'),
(11, 34, 'Beykoz'),
(12, 34, 'Beylikdüzü'),
(13, 34, 'Beyoğlu'),
(14, 34, 'Büyükçekmece'),
(15, 34, 'Çatalca'),
(16, 34, 'Çekmeköy'),
(17, 34, 'Esenler'),
(18, 34, 'Esenyurt'),
(19, 34, 'Eyüpsultan'),
(20, 34, 'Fatih'),
(21, 34, 'Gaziosmanpaşa'),
(22, 34, 'Güngören'),
(23, 34, 'Kadıköy'),
(24, 34, 'Kâğıthane'),
(25, 34, 'Kartal'),
(26, 34, 'Küçükçekmece'),
(27, 34, 'Maltepe'),
(28, 34, 'Pendik'),
(29, 34, 'Sancaktepe'),
(30, 34, 'Sarıyer'),
(31, 34, 'Silivri'),
(32, 34, 'Sultanbeyli'),
(33, 34, 'Sultangazi'),
(34, 34, 'Şile'),
(35, 34, 'Şişli'),
(36, 34, 'Tuzla'),
(37, 34, 'Ümraniye'),
(38, 34, 'Üsküdar'),
(39, 34, 'Zeytinburnu');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `parking_lot`
--

CREATE TABLE `parking_lot` (
  `pl_id` int(11) NOT NULL,
  `pl_owner_id` int(11) NOT NULL,
  `pl_is_active` tinyint(1) NOT NULL DEFAULT 0,
  `pl_is_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `pl_name` varchar(30) NOT NULL,
  `pl_city_id` int(11) NOT NULL,
  `pl_district_id` int(11) NOT NULL,
  `pl_address` varchar(50) NOT NULL,
  `pl_geojson` text NOT NULL,
  `pl_capacity` int(11) NOT NULL,
  `pl_size` int(11) NOT NULL DEFAULT 0,
  `pl_hourly_rate` int(11) NOT NULL,
  `pl_balance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `parking_lot`
--

INSERT INTO `parking_lot` (`pl_id`, `pl_owner_id`, `pl_is_active`, `pl_is_deleted`, `pl_name`, `pl_city_id`, `pl_district_id`, `pl_address`, `pl_geojson`, `pl_capacity`, `pl_size`, `pl_hourly_rate`, `pl_balance`) VALUES
(1, 3, 1, 0, 'Kadıköy Merkez Otopark', 34, 23, 'Kadıköy Merkez, 341 Sokak No:12', '{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Point\",\"coordinates\":[29.033775,40.996458]}}', 85, 20, 25, 0),
(2, 3, 1, 0, 'Bayrampaşa Kapalı Otopark-1', 34, 9, '5651 Sokak No:82', '{\"type\":\"Feature\",\"properties\":{},\"geometry\":{\"type\":\"Point\",\"coordinates\":[28.910351,41.040779]}}', 20, 6, 15, 0);

--
-- Tetikleyiciler `parking_lot`
--
DELIMITER $$
CREATE TRIGGER `parking_lot_before_update` BEFORE UPDATE ON `parking_lot` FOR EACH ROW IF NEW.pl_size > NEW.pl_capacity THEN
SIGNAL SQLSTATE '50001' SET MESSAGE_TEXT = 'Size is full.';
END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Görünüm yapısı durumu `pl_log_mobile`
-- (Asıl görünüm için aşağıya bakın)
--
CREATE TABLE `pl_log_mobile` (
`pl_name` varchar(30)
,`pl_address` varchar(50)
,`cpl_enter_date` datetime
,`cpl_exit_date` datetime
,`cpl_total_payment` int(11)
,`user_id` int(11)
,`cpl_car_plate` varchar(8)
);

-- --------------------------------------------------------

--
-- Görünüm yapısı durumu `pl_log_view`
-- (Asıl görünüm için aşağıya bakın)
--
CREATE TABLE `pl_log_view` (
`cpl_id` int(11)
,`cpl_pl_id` int(11)
,`cpl_enter_date` datetime
,`cpl_exit_date` datetime
,`cpl_total_payment` int(11)
,`cpl_car_plate` varchar(8)
);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `pl_owners`
--

CREATE TABLE `pl_owners` (
  `plo_id` int(11) NOT NULL,
  `plo_name` varchar(30) NOT NULL,
  `plo_mobile` varchar(10) NOT NULL,
  `plo_email` varchar(40) NOT NULL,
  `plo_username` varchar(20) NOT NULL,
  `plo_password` varchar(255) NOT NULL,
  `admin_type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Tablo döküm verisi `pl_owners`
--

INSERT INTO `pl_owners` (`plo_id`, `plo_name`, `plo_mobile`, `plo_email`, `plo_username`, `plo_password`, `admin_type`) VALUES
(1, '0', '0', '0', 'superadmin', '59ed67cbd74b0a853e23c931be491f8b0d3a0db2', 'super'),
(2, '0', '0', '0', 'admin2', '59ed67cbd74b0a853e23c931be491f8b0d3a0db2', 'admin'),
(3, 'Mustafa Can', '5325059666', 'mustafacan@gmail.com', 'admin', '59ed67cbd74b0a853e23c931be491f8b0d3a0db2', 'admin'),
(4, 'Ceyda Özbey', '(507) 191-', 'ceydozbey@gmail.com', 'Ceyda', 'aa6d3f1978af4eeb0d77a6e0e3789ff5cef43462', 'admin');

-- --------------------------------------------------------

--
-- Görünüm yapısı durumu `pl_view`
-- (Asıl görünüm için aşağıya bakın)
--
CREATE TABLE `pl_view` (
`pl_id` int(11)
,`pl_owner_id` int(11)
,`pl_is_active` tinyint(1)
,`pl_name` varchar(30)
,`city_name` varchar(13)
,`district_name` varchar(50)
,`pl_address` varchar(50)
,`pl_capacity` int(11)
,`pl_size` int(11)
,`pl_hourly_rate` int(11)
,`pl_balance` int(11)
);

-- --------------------------------------------------------

--
-- Görünüm yapısı durumu `pl_view_mobile`
-- (Asıl görünüm için aşağıya bakın)
--
CREATE TABLE `pl_view_mobile` (
`pl_id` int(11)
,`pl_name` varchar(30)
,`city_id` int(11)
,`city_name` varchar(13)
,`district_id` int(11)
,`district_name` varchar(50)
,`pl_address` varchar(50)
,`pl_geojson` text
,`pl_capacity` int(11)
,`pl_size` int(11)
,`pl_hourly_rate` int(11)
);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_mobile` varchar(10) NOT NULL,
  `user_email` varchar(40) NOT NULL,
  `user_tc` varchar(11) NOT NULL,
  `user_balance` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_password`, `user_mobile`, `user_email`, `user_tc`, `user_balance`) VALUES
(1, 'ozle', '59ed67cbd74b0a853e23c931be491f8b0d3a0db2', '5323334545', 'ceydaozbey@gmail.com', '1111111', 0),
(2, 'ayşe candan', '59ed67cbd74b0a853e23c931be491f8b0d3a0db2', '5361231122', 'aysecandan@gmail.com', '11111211111', 0),
(6, 'alican', '59ed67cbd74b0a853e23c931be491f8b0d3a0db2', '5323334544', 'alican@gmail.com', '11111111112', 0),
(8, 'name', '2', '2522', 'mail', 'tc', 0),
(29, '1', 'cd0033bd926f088f1b428d88f7056051c175164f', '1', '1', '1', 0),
(30, '7', '7', '7', '7', '7', 0),
(38, '2', '2', '2', '2', '2', 0),
(41, 'alican', '59ed67cbd74b0a853e23c931be491f8b0d3a0db2', '12345', 'burakkaya2@gmail.com', '1111111555', 0),
(42, '4', '9099bab06ddbe88fa47b2baf47522b2bc5a13054', '4', '4', '4', 0),
(43, 'mehmet polat', 'bf7d681cee7c664f827cb1e603b9c54412b41085', '12345678', 'm@gmail.com', '1234566', 0),
(44, 'qw', '61c239e5c7203949a78ff72615256c8db5dc04c4', '123', 'm', '123', 0),
(45, '321', 'fe3ed7235ec22ace01b448b1613f458c1f0ddffc', '321', '321', '321', 0);

-- --------------------------------------------------------

--
-- Görünüm yapısı `pl_log_mobile`
--
DROP TABLE IF EXISTS `pl_log_mobile`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pl_log_mobile`  AS SELECT `parking_lot`.`pl_name` AS `pl_name`, `parking_lot`.`pl_address` AS `pl_address`, `car_parking_logs`.`cpl_enter_date` AS `cpl_enter_date`, `car_parking_logs`.`cpl_exit_date` AS `cpl_exit_date`, `car_parking_logs`.`cpl_total_payment` AS `cpl_total_payment`, `cars`.`car_owner_id` AS `user_id`, `car_parking_logs`.`cpl_car_plate` AS `cpl_car_plate` FROM ((`car_parking_logs` join `cars` on(`car_parking_logs`.`cpl_car_plate` = `cars`.`car_plate`)) join `parking_lot` on(`car_parking_logs`.`cpl_pl_id` = `parking_lot`.`pl_id`)) WHERE `car_parking_logs`.`cpl_exit_date` is not null ORDER BY `car_parking_logs`.`cpl_exit_date` AS `DESCdesc` ASC  ;

-- --------------------------------------------------------

--
-- Görünüm yapısı `pl_log_view`
--
DROP TABLE IF EXISTS `pl_log_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pl_log_view`  AS SELECT `car_parking_logs`.`cpl_id` AS `cpl_id`, `car_parking_logs`.`cpl_pl_id` AS `cpl_pl_id`, `car_parking_logs`.`cpl_enter_date` AS `cpl_enter_date`, `car_parking_logs`.`cpl_exit_date` AS `cpl_exit_date`, `car_parking_logs`.`cpl_total_payment` AS `cpl_total_payment`, `car_parking_logs`.`cpl_car_plate` AS `cpl_car_plate` FROM `car_parking_logs` ORDER BY `car_parking_logs`.`cpl_id` ASC  ;

-- --------------------------------------------------------

--
-- Görünüm yapısı `pl_view`
--
DROP TABLE IF EXISTS `pl_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pl_view`  AS SELECT `parking_lot`.`pl_id` AS `pl_id`, `parking_lot`.`pl_owner_id` AS `pl_owner_id`, `parking_lot`.`pl_is_active` AS `pl_is_active`, `parking_lot`.`pl_name` AS `pl_name`, `cities`.`city_name` AS `city_name`, `districts`.`district_name` AS `district_name`, `parking_lot`.`pl_address` AS `pl_address`, `parking_lot`.`pl_capacity` AS `pl_capacity`, `parking_lot`.`pl_size` AS `pl_size`, `parking_lot`.`pl_hourly_rate` AS `pl_hourly_rate`, `parking_lot`.`pl_balance` AS `pl_balance` FROM ((`parking_lot` join `cities` on(`parking_lot`.`pl_city_id` = `cities`.`city_id`)) join `districts` on(`parking_lot`.`pl_district_id` = `districts`.`district_id`)) WHERE `parking_lot`.`pl_is_deleted` = 0 ORDER BY `parking_lot`.`pl_id` ASC  ;

-- --------------------------------------------------------

--
-- Görünüm yapısı `pl_view_mobile`
--
DROP TABLE IF EXISTS `pl_view_mobile`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pl_view_mobile`  AS SELECT `parking_lot`.`pl_id` AS `pl_id`, `parking_lot`.`pl_name` AS `pl_name`, `cities`.`city_id` AS `city_id`, `cities`.`city_name` AS `city_name`, `districts`.`district_id` AS `district_id`, `districts`.`district_name` AS `district_name`, `parking_lot`.`pl_address` AS `pl_address`, `parking_lot`.`pl_geojson` AS `pl_geojson`, `parking_lot`.`pl_capacity` AS `pl_capacity`, `parking_lot`.`pl_size` AS `pl_size`, `parking_lot`.`pl_hourly_rate` AS `pl_hourly_rate` FROM ((`parking_lot` join `cities` on(`parking_lot`.`pl_city_id` = `cities`.`city_id`)) join `districts` on(`parking_lot`.`pl_district_id` = `districts`.`district_id`)) WHERE `parking_lot`.`pl_is_active` = 1 AND `parking_lot`.`pl_is_deleted` = 0 ORDER BY `parking_lot`.`pl_id` ASC  ;

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `admin_accounts`
--
ALTER TABLE `admin_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- Tablo için indeksler `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`),
  ADD UNIQUE KEY `car_plate` (`car_plate`),
  ADD KEY `car_owner_id` (`car_owner_id`);

--
-- Tablo için indeksler `car_parking_logs`
--
ALTER TABLE `car_parking_logs`
  ADD PRIMARY KEY (`cpl_id`),
  ADD KEY `car_parking_logs_ibfk_1` (`cpl_pl_id`);

--
-- Tablo için indeksler `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`city_id`);

--
-- Tablo için indeksler `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`district_id`),
  ADD KEY `city_id` (`city_id`);

--
-- Tablo için indeksler `parking_lot`
--
ALTER TABLE `parking_lot`
  ADD PRIMARY KEY (`pl_id`),
  ADD KEY `pl_city_id` (`pl_city_id`),
  ADD KEY `pl_district_id` (`pl_district_id`),
  ADD KEY `pl_owner_id` (`pl_owner_id`);

--
-- Tablo için indeksler `pl_owners`
--
ALTER TABLE `pl_owners`
  ADD PRIMARY KEY (`plo_id`),
  ADD UNIQUE KEY `plo_username` (`plo_username`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_mobile` (`user_mobile`),
  ADD UNIQUE KEY `user_email` (`user_email`),
  ADD UNIQUE KEY `user_tc` (`user_tc`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `admin_accounts`
--
ALTER TABLE `admin_accounts`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Tablo için AUTO_INCREMENT değeri `car_parking_logs`
--
ALTER TABLE `car_parking_logs`
  MODIFY `cpl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Tablo için AUTO_INCREMENT değeri `cities`
--
ALTER TABLE `cities`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- Tablo için AUTO_INCREMENT değeri `districts`
--
ALTER TABLE `districts`
  MODIFY `district_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Tablo için AUTO_INCREMENT değeri `parking_lot`
--
ALTER TABLE `parking_lot`
  MODIFY `pl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `pl_owners`
--
ALTER TABLE `pl_owners`
  MODIFY `plo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_ibfk_1` FOREIGN KEY (`car_owner_id`) REFERENCES `users` (`user_id`);

--
-- Tablo kısıtlamaları `car_parking_logs`
--
ALTER TABLE `car_parking_logs`
  ADD CONSTRAINT `car_parking_logs_ibfk_1` FOREIGN KEY (`cpl_pl_id`) REFERENCES `parking_lot` (`pl_id`);

--
-- Tablo kısıtlamaları `districts`
--
ALTER TABLE `districts`
  ADD CONSTRAINT `districts_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `cities` (`city_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
