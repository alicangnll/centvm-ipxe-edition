-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost
-- Üretim Zamanı: 03 Ara 2021, 18:37:25
-- Sunucu sürümü: 10.3.28-MariaDB
-- PHP Sürümü: 7.2.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `pxe_boot`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `admin_list`
--

CREATE TABLE `admin_list` (
  `admin_id` int(11) NOT NULL,
  `admin_email` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `admin_usrname` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `admin_passwd` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `admin_token` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `admin_yetki` varchar(255) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `admin_list`
--

INSERT INTO `admin_list` (`admin_id`, `admin_email`, `admin_usrname`, `admin_passwd`, `admin_token`, `admin_yetki`) VALUES
(1, 'xxx@xxx.com', 'alicangonullu', '060323f33140b4a86b53d01d726a45c7584a3a2b', '060323f33140b4a86b53d01d726a45c7584a3a2b', '1');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `chain_list`
--

CREATE TABLE `chain_list` (
  `id` int(11) NOT NULL,
  `chainname` varchar(255) NOT NULL,
  `chain_file` varchar(255) NOT NULL,
  `chain_config` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `chain_list`
--

INSERT INTO `chain_list` (`id`, `chainname`, `chain_file`, `chain_config`) VALUES
(1, 'GRUB HDD', 'grub.exe', 'root (hd0,0);chainloader +1');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ipxe_list`
--

CREATE TABLE `ipxe_list` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `file_location` varchar(255) NOT NULL,
  `other` text NOT NULL,
  `kernel` varchar(255) NOT NULL,
  `boot_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `ipxe_list`
--

INSERT INTO `ipxe_list` (`id`, `name`, `file_location`, `other`, `kernel`, `boot_type`) VALUES
(1, 'AllInOne', 'allinone.img', '', ' memdisk', 'oth');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `admin_list`
--
ALTER TABLE `admin_list`
  ADD PRIMARY KEY (`admin_id`);

--
-- Tablo için indeksler `chain_list`
--
ALTER TABLE `chain_list`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ipxe_list`
--
ALTER TABLE `ipxe_list`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `admin_list`
--
ALTER TABLE `admin_list`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `chain_list`
--
ALTER TABLE `chain_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `ipxe_list`
--
ALTER TABLE `ipxe_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
