-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 03 Kas 2022, 15:54:58
-- Sunucu sürümü: 10.4.19-MariaDB
-- PHP Sürümü: 8.0.7

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `car_brand_id` int(11) NOT NULL,
  `car_plate` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cities`
--

CREATE TABLE `cities` (
  `city_id` int(11) NOT NULL,
  `city_name` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `pl_name` varchar(30) NOT NULL,
  `pl_city_id` int(11) NOT NULL,
  `pl_district_id` int(11) NOT NULL,
  `pl_address` varchar(50) NOT NULL,
  `pl_geojson` text NOT NULL,
  `pl_capacity` int(11) NOT NULL,
  `pl_size` int(11) NOT NULL DEFAULT 0,
  `pl_hourly_rate` int(11) NOT NULL,
  `pl_balance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `parking_lot`
--

INSERT INTO `parking_lot` (`pl_id`, `pl_owner_id`, `pl_is_active`, `pl_name`, `pl_city_id`, `pl_district_id`, `pl_address`, `pl_geojson`, `pl_capacity`, `pl_size`, `pl_hourly_rate`, `pl_balance`) VALUES
(1, 3, 1, 'kadıköy-1', 34, 23, 'Kadıköy Merkez', '-', 50, 0, 25, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `pl_owners`
--

CREATE TABLE `pl_owners` (
  `plo_id` int(11) NOT NULL,
  `plo_name` varchar(30) NOT NULL,
  `plo_mobile` varchar(10) NOT NULL,
  `plo_email` varchar(40) NOT NULL,
  `plo_username` varchar(50) NOT NULL,
  `plo_password` varchar(255) NOT NULL,
  `admin_type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `pl_owners`
--

INSERT INTO `pl_owners` (`plo_id`, `plo_name`, `plo_mobile`, `plo_email`, `plo_username`, `plo_password`, `admin_type`) VALUES
(1, '0', '0', '0', 'superadmin', '59ed67cbd74b0a853e23c931be491f8b0d3a0db2', 'super'),
(2, '0', '0', '0', 'anand', '59ed67cbd74b0a853e23c931be491f8b0d3a0db2', 'admin'),
(3, '0', '0', '0', 'admin', '59ed67cbd74b0a853e23c931be491f8b0d3a0db2', 'admin');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `user_password` varchar(15) NOT NULL,
  `user_mobile` varchar(10) NOT NULL,
  `user_email` varchar(40) NOT NULL,
  `user_balance` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  ADD PRIMARY KEY (`user_id`);

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
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `pl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `pl_owners`
--
ALTER TABLE `pl_owners`
  MODIFY `plo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_ibfk_1` FOREIGN KEY (`car_owner_id`) REFERENCES `users` (`user_id`);

--
-- Tablo kısıtlamaları `districts`
--
ALTER TABLE `districts`
  ADD CONSTRAINT `districts_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `cities` (`city_id`);

--
-- Tablo kısıtlamaları `parking_lot`
--
ALTER TABLE `parking_lot`
  ADD CONSTRAINT `parking_lot_ibfk_1` FOREIGN KEY (`pl_city_id`) REFERENCES `cities` (`city_id`),
  ADD CONSTRAINT `parking_lot_ibfk_2` FOREIGN KEY (`pl_district_id`) REFERENCES `districts` (`district_id`),
  ADD CONSTRAINT `parking_lot_ibfk_3` FOREIGN KEY (`pl_owner_id`) REFERENCES `pl_owners` (`plo_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
