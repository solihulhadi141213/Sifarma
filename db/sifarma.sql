-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 25, 2026 at 07:41 PM
-- Server version: 9.1.0
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sifarma`
--

-- --------------------------------------------------------

--
-- Table structure for table `access`
--

DROP TABLE IF EXISTS `access`;
CREATE TABLE IF NOT EXISTS `access` (
  `id_access` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_access_group` int DEFAULT NULL,
  `access_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_contact` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `access_foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `access_client` tinyint(1) NOT NULL COMMENT 'If true, the account is a client.',
  `access_active` tinyint(1) NOT NULL COMMENT 'true or false',
  PRIMARY KEY (`id_access`),
  KEY `id_access_group` (`id_access_group`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `access`
--

INSERT INTO `access` (`id_access`, `id_access_group`, `access_name`, `access_email`, `access_contact`, `access_password`, `access_foto`, `access_client`, `access_active`) VALUES
(1, 1, 'Solihul Hadi', 'dhiforester@gmail.com', '089601154726', '$2y$10$KnOYcmK1U3iE8ta.PnDefOTr1h5Cz1LaGHfyM5wBqg1vuqqg1i5le', 'ca6526b10323e5ffc519def7f71e10.jpg', 0, 1),
(2, 8, 'Dewi Widiastuti', 'dewiwidiastuti@gmail.com', '08975657467', '$2y$10$YW/wCElX7HYlfipjFo80eO89RkvlUZ9iIOwZk4lK.Cf/BR8ypeygm', '4522beb0ae8aabe337284b439dcc79.png', 0, 1),
(8, 1, 'Bayu Anugrah', 'bayu88aaa@gmail.com', '085693168595', '$2y$10$gNbRZTnQ8lPJtrg5TGCyoe0N2k7EcFKI1znNWu8XI/UkuCJA4S8Ae', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `access_feature`
--

DROP TABLE IF EXISTS `access_feature`;
CREATE TABLE IF NOT EXISTS `access_feature` (
  `id_access_feature` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `feature_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `feature_category` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `feature_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `datetime_creat` timestamp NOT NULL,
  PRIMARY KEY (`id_access_feature`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `access_feature`
--

INSERT INTO `access_feature` (`id_access_feature`, `feature_name`, `feature_category`, `feature_description`, `datetime_creat`) VALUES
('1myRE11AReOH1p51B5fWru65SUDwmwqXrmTX', 'Obat &amp; Alkes', 'Master', 'Halaman yang digunakan untuk mengelola master data obat dan alat kesehatan (ALKES)', '2026-01-08 19:19:07'),
('36grsDsU11UKOCFPKlh5Gx7K2YbR6XpRHJ5y', 'Koneksi SIMRS', 'Koneksi', 'Pengaturan parameter koneksi dengan SIMRS', '2025-12-16 20:07:41'),
('5a7yRbkFPs6fXNHQf8a7bI79IZcbbIaijE0E', 'Koneksi Satu Sehat', 'Koneksi', 'Pengaturan parameter koneksi ke Satu Sehat Platform', '2025-12-17 18:47:14'),
('Dnd2UZLzazCqJ9WfuzQKlIOpYueb2fXxNHXA', 'Bantuan', 'Lainnya', 'Halaman untuk mengelola konten bantuan atau dokumentasi', '2025-09-06 14:36:36'),
('EQxQwv6ZDPyB9vqc3Fp5MkKe6ninWGlnEX06', 'Satuan Dosis', 'Referensi', 'Halaman yang berguna untuk menyimpan informasi referensi satuan dosis', '2026-01-25 17:58:51'),
('Mt24BYzC76RJBEuHdY95bmMKrulttEQzblzH', 'Pengaturan Umum', 'Pengaturan', 'Halaman yang berfungsi untuk mengatur aplikasi secara umum', '2025-09-01 19:27:07'),
('Ooc86evItaAofDGz0GeGvUo1zWJ9PzMGT8Iw', 'Satuan Denominator', 'Referensi', 'Halaman yang berfungsi untuk mengelola referensi satuan Denominator', '2026-01-11 21:13:44'),
('Yw29wopHlztYeHUJW67syfO7quPLQvmPq9kS', 'Sediaan', 'Referensi', 'Halaman untuk mengelola data referensi sediaan', '2026-01-10 21:15:52'),
('aziAs4ZofHmVooUohitYSojDp7oR2zbjrwpY', 'Email Gateway', 'Pengaturan', 'Halaman yang berguna untuk menyimpan pengaturan email gateway', '2025-09-01 19:32:54'),
('emy9Q1p9V9hhsdoYK0Wz0CQPdZj41uKrSP7H', 'Peresepan', 'Master', 'Halaman untuk mengelola resep dokter', '2026-01-23 19:50:05'),
('fErKPHIY6bEuhp7sOivMHglXHOP2gVubzGyw', 'Daftar Pertanyaan', 'Referensi', 'Halaman untuk mengelola daftar pertanyaan dalam assesment radiologi', '2025-12-30 20:58:40'),
('fi0CSLGoOEoMoWUPqkTIFJatGVFYZ7nhlJxt', 'Satuan Numerator', 'Referensi', 'Halaman untuk mengelola referensi satuan secara Numerator', '2026-01-11 15:13:20'),
('jO3M0NopVQeXi4VuDHpvD9SRJzntpUGAe6Sw', 'Akses Pengguna', 'Akses', 'Halaman untuk mengelola akun akses pengguna', '2025-08-31 20:23:54'),
('lInyeHHg924zNLaXZ3SmjjnuyCOYBnUyUuTD', 'Entitas Akses Pengguna', 'Akses', 'Halaman untuk mengelola entitas/group/level pengguna', '2025-08-31 20:23:01'),
('nSYinRWpCF9MHNUIlW7Up5vTip70gNNLlrqv', 'Fitur Aplikasi', 'Akses', 'Halaman untuk mengelola fitur aplikasi', '2025-08-31 20:21:48'),
('nkYXm3U8XWpOt1cD3PNeCwDQzesMYmmUUbee', 'API Key', 'Koneksi', 'Halaman untuk mengelola data API key untuk aplikasi lain agar terhubung Ke Redix', '2025-12-19 16:28:20');

-- --------------------------------------------------------

--
-- Table structure for table `access_group`
--

DROP TABLE IF EXISTS `access_group`;
CREATE TABLE IF NOT EXISTS `access_group` (
  `id_access_group` int NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_access_group`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `access_group`
--

INSERT INTO `access_group` (`id_access_group`, `group_name`, `group_description`) VALUES
(1, 'Admin', 'Pihak yang berwenang melakukan akses ke semua fitur'),
(3, 'Sekretaris', 'Pihak yang melakukan verifikasi pembayaran'),
(8, 'Bendahara', 'Pihak yang berhak menyimpan keuangan');

-- --------------------------------------------------------

--
-- Table structure for table `access_log`
--

DROP TABLE IF EXISTS `access_log`;
CREATE TABLE IF NOT EXISTS `access_log` (
  `id_access_log` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_access` int UNSIGNED NOT NULL,
  `log_datetime` datetime NOT NULL,
  `log_category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `log_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_access_log`),
  KEY `access_log_id_access_index` (`id_access`)
) ENGINE=InnoDB AUTO_INCREMENT=418 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `access_login`
--

DROP TABLE IF EXISTS `access_login`;
CREATE TABLE IF NOT EXISTS `access_login` (
  `id_access_login` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_access` int UNSIGNED NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `datetime_creat` datetime NOT NULL,
  `datetime_expired` datetime NOT NULL,
  PRIMARY KEY (`id_access_login`),
  KEY `access_login_id_access_index` (`id_access`)
) ENGINE=InnoDB AUTO_INCREMENT=335 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `access_permission`
--

DROP TABLE IF EXISTS `access_permission`;
CREATE TABLE IF NOT EXISTS `access_permission` (
  `id_permission` int NOT NULL AUTO_INCREMENT,
  `id_access` int UNSIGNED NOT NULL,
  `id_access_feature` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id_permission`),
  KEY `id_access` (`id_access`),
  KEY `id_access_feature` (`id_access_feature`)
) ENGINE=InnoDB AUTO_INCREMENT=365 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `access_permission`
--

INSERT INTO `access_permission` (`id_permission`, `id_access`, `id_access_feature`) VALUES
(349, 1, 'jO3M0NopVQeXi4VuDHpvD9SRJzntpUGAe6Sw'),
(350, 1, 'lInyeHHg924zNLaXZ3SmjjnuyCOYBnUyUuTD'),
(351, 1, 'nSYinRWpCF9MHNUIlW7Up5vTip70gNNLlrqv'),
(352, 1, 'nkYXm3U8XWpOt1cD3PNeCwDQzesMYmmUUbee'),
(353, 1, '5a7yRbkFPs6fXNHQf8a7bI79IZcbbIaijE0E'),
(354, 1, '36grsDsU11UKOCFPKlh5Gx7K2YbR6XpRHJ5y'),
(355, 1, 'Dnd2UZLzazCqJ9WfuzQKlIOpYueb2fXxNHXA'),
(356, 1, '1myRE11AReOH1p51B5fWru65SUDwmwqXrmTX'),
(357, 1, 'emy9Q1p9V9hhsdoYK0Wz0CQPdZj41uKrSP7H'),
(358, 1, 'aziAs4ZofHmVooUohitYSojDp7oR2zbjrwpY'),
(359, 1, 'Mt24BYzC76RJBEuHdY95bmMKrulttEQzblzH'),
(360, 1, 'fErKPHIY6bEuhp7sOivMHglXHOP2gVubzGyw'),
(361, 1, 'Ooc86evItaAofDGz0GeGvUo1zWJ9PzMGT8Iw'),
(362, 1, 'EQxQwv6ZDPyB9vqc3Fp5MkKe6ninWGlnEX06'),
(363, 1, 'fi0CSLGoOEoMoWUPqkTIFJatGVFYZ7nhlJxt'),
(364, 1, 'Yw29wopHlztYeHUJW67syfO7quPLQvmPq9kS');

-- --------------------------------------------------------

--
-- Table structure for table `access_reference`
--

DROP TABLE IF EXISTS `access_reference`;
CREATE TABLE IF NOT EXISTS `access_reference` (
  `id_access_reference` int NOT NULL AUTO_INCREMENT,
  `id_access_group` int NOT NULL,
  `id_access_feature` varchar(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id_access_reference`),
  KEY `id_access_group` (`id_access_group`),
  KEY `id_access_fitures` (`id_access_feature`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `access_reference`
--

INSERT INTO `access_reference` (`id_access_reference`, `id_access_group`, `id_access_feature`) VALUES
(1, 1, 'jO3M0NopVQeXi4VuDHpvD9SRJzntpUGAe6Sw'),
(2, 1, 'lInyeHHg924zNLaXZ3SmjjnuyCOYBnUyUuTD'),
(3, 1, 'nSYinRWpCF9MHNUIlW7Up5vTip70gNNLlrqv'),
(4, 1, 'nkYXm3U8XWpOt1cD3PNeCwDQzesMYmmUUbee'),
(5, 1, '5a7yRbkFPs6fXNHQf8a7bI79IZcbbIaijE0E'),
(6, 1, '36grsDsU11UKOCFPKlh5Gx7K2YbR6XpRHJ5y'),
(7, 1, 'Dnd2UZLzazCqJ9WfuzQKlIOpYueb2fXxNHXA'),
(8, 1, '1myRE11AReOH1p51B5fWru65SUDwmwqXrmTX'),
(9, 1, 'emy9Q1p9V9hhsdoYK0Wz0CQPdZj41uKrSP7H'),
(10, 1, 'aziAs4ZofHmVooUohitYSojDp7oR2zbjrwpY'),
(11, 1, 'Mt24BYzC76RJBEuHdY95bmMKrulttEQzblzH'),
(12, 1, 'fErKPHIY6bEuhp7sOivMHglXHOP2gVubzGyw'),
(13, 1, 'Ooc86evItaAofDGz0GeGvUo1zWJ9PzMGT8Iw'),
(14, 1, 'EQxQwv6ZDPyB9vqc3Fp5MkKe6ninWGlnEX06'),
(15, 1, 'fi0CSLGoOEoMoWUPqkTIFJatGVFYZ7nhlJxt'),
(16, 1, 'Yw29wopHlztYeHUJW67syfO7quPLQvmPq9kS');

-- --------------------------------------------------------

--
-- Table structure for table `access_reset`
--

DROP TABLE IF EXISTS `access_reset`;
CREATE TABLE IF NOT EXISTS `access_reset` (
  `id_access_reset` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_access` int UNSIGNED NOT NULL,
  `datetime_creat` datetime NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id_access_reset`),
  KEY `reset_to_access` (`id_access`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `api_account`
--

DROP TABLE IF EXISTS `api_account`;
CREATE TABLE IF NOT EXISTS `api_account` (
  `id_api_account` int NOT NULL AUTO_INCREMENT,
  `api_name` varchar(255) NOT NULL COMMENT 'Nama Environment',
  `base_url_api` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `created_at` datetime NOT NULL,
  `duration_expired` bigint UNSIGNED NOT NULL COMMENT 'milisecond',
  PRIMARY KEY (`id_api_account`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `api_token`
--

DROP TABLE IF EXISTS `api_token`;
CREATE TABLE IF NOT EXISTS `api_token` (
  `id_api_token` int NOT NULL AUTO_INCREMENT,
  `id_api_account` int NOT NULL COMMENT 'From api_account',
  `token` text NOT NULL COMMENT 'Hasing',
  `created_at` datetime NOT NULL,
  `expired_at` datetime NOT NULL,
  PRIMARY KEY (`id_api_token`),
  KEY `token_to_account` (`id_api_account`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `app_configuration`
--

DROP TABLE IF EXISTS `app_configuration`;
CREATE TABLE IF NOT EXISTS `app_configuration` (
  `id_configuration` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `app_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `app_keyword` json NOT NULL,
  `app_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `app_favicon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `app_logo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `app_base_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `app_author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `app_year` int NOT NULL,
  `app_company` json NOT NULL,
  PRIMARY KEY (`id_configuration`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `app_configuration`
--

INSERT INTO `app_configuration` (`id_configuration`, `app_title`, `app_keyword`, `app_description`, `app_favicon`, `app_logo`, `app_base_url`, `app_author`, `app_year`, `app_company`) VALUES
(1, 'SIFARMA v1.0', '[\"Farmasi\", \"el-syifa\", \"kuningan\"]', 'Aplikasi Farmasi merupakan aplikasi berbasis web yang berfungsi sebagai layanan microservice dalam ekosistem Sistem Informasi Manajemen Rumah Sakit (SIMRS). Aplikasi ini dirancang untuk mendukung dan mengelola seluruh proses pelayanan kefarmasian secara terintegrasi, akurat, dan real-time, mulai dari penerimaan resep hingga pelaporan farmasi.', '95a8368b2302ba5d268b68208bd31e.png', '26802d057d82c89ca18070029ede00.png', 'http://localhost/Sifarma', 'Solihul Hadi', 2026, '{\"company_code\": \"0124R006\", \"company_name\": \"RSU El-Syifa Kuningan\", \"company_email\": \"hallo.rsuelsyifa@gmail.com\", \"company_address\": \"Jalan RE Martadinata No.21 Ancaran Kuningan\", \"company_contact\": \"(0232) 876240\"}');

-- --------------------------------------------------------

--
-- Table structure for table `captcha`
--

DROP TABLE IF EXISTS `captcha`;
CREATE TABLE IF NOT EXISTS `captcha` (
  `id_captcha` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `captcha` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `datetime_creat` datetime NOT NULL,
  `datetime_expired` datetime NOT NULL,
  PRIMARY KEY (`id_captcha`)
) ENGINE=InnoDB AUTO_INCREMENT=5653 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `connection_satu_sehat`
--

DROP TABLE IF EXISTS `connection_satu_sehat`;
CREATE TABLE IF NOT EXISTS `connection_satu_sehat` (
  `id_connection_satu_sehat` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_connection_satu_sehat` varchar(255) NOT NULL COMMENT 'Ex: Development, Staging, Production',
  `url_connection_satu_sehat` varchar(255) NOT NULL COMMENT 'Dari Satu Sehat',
  `organization_id` varchar(255) NOT NULL COMMENT 'Dari Satu Sehat',
  `client_key` varchar(255) NOT NULL COMMENT 'Dari Satu Sehat',
  `secret_key` varchar(255) NOT NULL COMMENT 'Dari Satu Sehat',
  `token` varchar(255) NOT NULL,
  `datetime_expired` datetime DEFAULT NULL,
  `status_connection_satu_sehat` tinyint(1) NOT NULL COMMENT 'True Or False',
  PRIMARY KEY (`id_connection_satu_sehat`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `connection_simrs`
--

DROP TABLE IF EXISTS `connection_simrs`;
CREATE TABLE IF NOT EXISTS `connection_simrs` (
  `id_connection_simrs` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_connection_simrs` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'ex: Development, Staging, Local, Production',
  `url_connection_simrs` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `client_id` varchar(255) NOT NULL,
  `client_key` varchar(255) NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `datetime_expired` datetime DEFAULT NULL,
  `status_connection_simrs` tinyint(1) NOT NULL COMMENT 'true or false',
  PRIMARY KEY (`id_connection_simrs`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medication`
--

DROP TABLE IF EXISTS `medication`;
CREATE TABLE IF NOT EXISTS `medication` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_medication` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Dari Satu sehat',
  `medication_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Kode Lokal',
  `medication_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'nama obat',
  `medication_category` enum('Obat','Alkes','Lainnya','') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Obat, Alkes, Lainnya',
  `kfa_code` varchar(255) DEFAULT NULL COMMENT 'Kode KFA',
  `kfa_display` varchar(255) DEFAULT NULL COMMENT 'Nama KFA',
  `sediaan_code` varchar(255) DEFAULT NULL COMMENT 'medication-form',
  `sediaan_display` varchar(255) DEFAULT NULL COMMENT 'medication-form',
  `racikan_code` varchar(255) DEFAULT NULL COMMENT 'medication-type',
  `racikan_display` varchar(255) DEFAULT NULL COMMENT 'medication-type',
  `manufacturer_id` varchar(255) DEFAULT NULL,
  `manufacturer_name` varchar(255) DEFAULT NULL,
  `ingredient` json DEFAULT NULL COMMENT 'JSON LIST',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code_medication` (`medication_code`),
  KEY `id_medication` (`id_medication`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medication_request`
--

DROP TABLE IF EXISTS `medication_request`;
CREATE TABLE IF NOT EXISTS `medication_request` (
  `kode_medication_request` varchar(255) NOT NULL COMMENT 'Kode Unik RS',
  `id_medication_request_group` int UNSIGNED NOT NULL COMMENT 'Dari medication_request_group',
  `id_medication_request` varchar(255) DEFAULT NULL COMMENT 'Dari Satu Sehat',
  `intent` enum('order','plan','proposal') NOT NULL COMMENT 'Tujuan Permintaan',
  `id_medication` varchar(255) DEFAULT NULL COMMENT 'Jika kosong maka obat belum terindex',
  `name_medication` varchar(255) NOT NULL COMMENT 'Wajib terisi',
  `status` enum('active','on-hold','completed','stopped','cancelled','entered-in-error') NOT NULL,
  `dosage_inst_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci COMMENT 'Ex : Diminum Setelah Makan',
  `dosage_inst_frequency` int NOT NULL COMMENT 'Berapa kali dalam 1 hari (Ex: 3)',
  `dosage_inst_period` int NOT NULL COMMENT 'Interval (1)',
  `dosage_inst_period_unit` varchar(255) NOT NULL COMMENT 'd (Day)',
  `dose_value` decimal(11,0) NOT NULL COMMENT 'Dosis per sekali minum (ex: 1 Or 0.5)',
  `dose_unit` varchar(255) NOT NULL COMMENT 'Satuan dosis (ex: tablet)',
  `dose_code` varchar(255) NOT NULL COMMENT 'Kode Satuan (Ex: TAB)',
  `dose_system` varchar(255) NOT NULL COMMENT 'Code System (http://unitsofmeasure.org)',
  `route_display` varchar(255) NOT NULL COMMENT 'Cara obat masuk (ex:Oral) ',
  `route_code` varchar(255) NOT NULL COMMENT 'Kode cara obat masuk (Ex: O)',
  `route_system` text NOT NULL COMMENT 'Code System (Ex: http://www.whocc.no/atc)',
  `dispense_value` decimal(10,0) NOT NULL COMMENT 'Jumlah obat yang harus diserahkan apotek (ex: 10)',
  `dispense_unit` varchar(255) NOT NULL COMMENT 'Satuan obat yang diserahkan (Ex: tablet)',
  `dispense_code` text NOT NULL COMMENT 'Kode satuan obat yang diserahkan (Ex: TAB)',
  `dispense_sys` text NOT NULL COMMENT 'Code System satuan obat yang diserahkan (EX: http://unitsofmeasure.org)',
  `supply_duration_value` int NOT NULL COMMENT 'Durasi waktu obat dikonsumsi (Ex: 3)',
  `supply_duration_unit` varchar(255) NOT NULL COMMENT 'Unit Durasi waktu obat dikonsumsi (Ex: days)',
  `supply_duration_code` varchar(255) NOT NULL COMMENT 'code unit durasi waktu obat dikonsumsi (Ex: d)',
  `supply_duration_sys` text NOT NULL COMMENT 'System unit durasi waktu obat dikonsumsi (Ex: http://unitsofmeasure.org)',
  `racikan_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'C, NC',
  `racikan_display` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Non-compound, Compound',
  `ingredient` json DEFAULT NULL COMMENT 'Jika obat racikan maka isikan kandungan nya',
  PRIMARY KEY (`kode_medication_request`),
  KEY `id_medication` (`id_medication`),
  KEY `medication_request_to_group` (`id_medication_request_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medication_request_group`
--

DROP TABLE IF EXISTS `medication_request_group`;
CREATE TABLE IF NOT EXISTS `medication_request_group` (
  `id_medication_request_group` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_pasien` int DEFAULT NULL COMMENT 'No RM pasien dari RM',
  `id_kunjungan` int DEFAULT NULL COMMENT 'ID Kunjungan pasien',
  `id_encounter` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'ID Encounter Satu Sehat',
  `pasien_nama` varchar(255) NOT NULL COMMENT 'Nama lengkap pasien',
  `pasien_gender` enum('Laki-laki','Perempuan') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Jenis Kelamin',
  `pasien_tanggal_lahir` date DEFAULT NULL COMMENT 'Tanggal Lahir Pasien',
  `kunjungan_tujuan` enum('Rajal','Ranap') NOT NULL,
  `kunjungan_pembayaran` varchar(255) NOT NULL COMMENT 'UMUM, BPJS PBI, BPJS NON PBI Dll',
  `priority` enum('routine','urgent','asap','stat') NOT NULL,
  `datetime_creat` datetime NOT NULL COMMENT 'Tanggal/Waktu Resep Dibuat',
  `datetime_verified` datetime DEFAULT NULL COMMENT 'Tanggal/Waktu Resep Diterima Apoteker',
  `datetime_completed` datetime DEFAULT NULL COMMENT 'Tanggal/Waktu Resep Selesai',
  `dokter_kode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Kode dokter di SIMRS',
  `dokter_ihs` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'ID Practitioner dokter',
  `dokter_nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Nama dokter',
  `reason_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'http://hl7.org/fhir/sid/icd-10',
  `reason_display` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Nama Diagnosa',
  `reason_system` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci COMMENT 'Kode Diagnosa',
  `apoteker` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Nama Lengkap Apoteker',
  `sumber_data` varchar(255) NOT NULL COMMENT 'nama Sistem yang mengirim resep',
  `status_resep` enum('Draft','Verified','Partially','Completed','Cancelled') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_medication_request_group`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `referensi_denominator`
--

DROP TABLE IF EXISTS `referensi_denominator`;
CREATE TABLE IF NOT EXISTS `referensi_denominator` (
  `id_referensi_denominator` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `code_denominator` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `display_denominator` varchar(255) NOT NULL,
  `system_denominator` text NOT NULL,
  PRIMARY KEY (`id_referensi_denominator`)
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `referensi_denominator`
--

INSERT INTO `referensi_denominator` (`id_referensi_denominator`, `code_denominator`, `display_denominator`, `system_denominator`) VALUES
(1, 'APPFUL', 'Applicatorful', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(2, 'DROP', 'Drops', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(4, 'NDROP', 'Nasal Drops', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(5, 'OPDROP', 'Ophthalmic Drops', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(6, 'ORDROP', 'Oral Drops', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(7, 'OTDROP', 'Otic Drops', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(8, 'PUFF', 'Puff', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(9, 'SCOOP', 'Scoops', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(10, 'SPRY', 'Sprays', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(11, 'GASINHL', 'Gas for Inhalation', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(12, 'AER', 'Aerosol', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(13, 'BAINHL', 'Breath Activated Inhaler', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(14, 'INHLSOL', 'Inhalant Solution', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(15, 'MDINHL', 'Metered Dose Inhaler', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(16, 'NASSPRY', 'Nasal Spray', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(17, 'DERMSPRY', 'Dermal Spray', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(18, 'FOAM', 'Foam', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(19, 'FOAMAPL', 'Foam with Applicator', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(20, 'RECFORM', 'Rectal Foam', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(21, 'VAGFOAM', 'Vaginal Foam', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(22, 'VAGFOAMAPL', 'Vaginal Foam with Applicator', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(23, 'RECSPRY', 'Rectal Spray', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(24, 'VAGSPRY', 'Vaginal Spray', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(25, 'INHL', 'Inhalant', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(26, 'BAINHLPWD', 'Breath Activated Powder Inhaler', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(27, 'INHLPWD', 'Inhalant Powder', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(28, 'MDINHLPWD', 'Metered Dose Powder Inhaler', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(29, 'NASINHL', 'Nasal Inhalant', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(30, 'ORINHL', 'Oral Inhalant', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(31, 'PWDSPRY', 'Powder Spray', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(32, 'SPRYADAPT', 'Spray with Adaptor', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(33, 'LIQCLN', 'Liquid Cleanser', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(34, 'LIQSOAP', 'Medicated Liquid Soap', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(35, 'SHMP', 'Shampoo', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(36, 'OIL', 'Oil', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(37, 'TOPOIL', 'Topical Oil', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(38, 'SOL', 'Solution', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(39, 'IPSOL', 'Intraperitoneal Solution', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(40, 'IRSOL', 'Irrigation Solution', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(41, 'DOUCHE', 'Douche', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(42, 'ENEMA', 'Enema', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(43, 'OPIRSOL', 'Ophthalmic Irrigation Solution', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(44, 'IVSOL', 'Intravenous Solution', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(45, 'ORALSOL', 'Oral Solution', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(46, 'ELIXIR', 'Elixir', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(47, 'RINSE', 'Mouthwash/Rinse', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(48, 'SYRUP', 'Syrup', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(49, 'RECSOL', 'Rectal Solution', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(50, 'TOPSOL', 'Topical Solution', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(51, 'LIN', 'Liniment', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(52, 'MUCTOPSOL', 'Mucous Membrane Topical Solution', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(53, 'TINC', 'Tincture', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(54, 'CRM', 'Cream', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(55, 'NASCRM', 'Nasal Cream', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(56, 'OPCRM', 'Ophthalmic Cream', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(57, 'ORCRM', 'Oral Cream', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(58, 'OTCRM', 'Otic Cream', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(59, 'RECCRM', 'Rectal Cream', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(60, 'TOPCRM', 'Topical Cream', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(61, 'VAGCRM', 'Vaginal Cream', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(62, 'VAGCRMAPL', 'Vaginal Cream with Applicator', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(63, 'LTN', 'Lotion', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(64, 'TOPLTN', 'Topical Lotion', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(65, 'OINT', 'Ointment', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(66, 'NASOINT', 'Nasal Ointment', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(67, 'OINTAPL', 'Ointment with Applicator', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(68, 'OPOINT', 'Ophthalmic Ointment', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(69, 'OTOINT', 'Otic Ointment', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(70, 'RECOINT', 'Rectal Ointment', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(71, 'TOPOINT', 'Topical Ointment', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(72, 'VAGOINT', 'Vaginal Ointment', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(73, 'VAGOINTAPL', 'Vaginal Ointment with Applicator', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(74, 'GEL', 'Gel', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(75, 'GELAPL', 'Gel with Applicator', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(76, 'NASGEL', 'Nasal Gel', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(77, 'OPGEL', 'Ophthalmic Gel', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(78, 'OTGEL', 'Otic Gel', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(79, 'TOPGEL', 'Topical Gel', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(80, 'URETHGEL', 'Urethral Gel', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(81, 'VAGGEL', 'Vaginal Gel', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(82, 'VGELAPL', 'Vaginal Gel with Applicator', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(83, 'PASTE', 'Paste', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(84, 'PUD', 'Pudding', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(85, 'TPASTE', 'Toothpaste', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(86, 'SUSP', 'Suspension', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(87, 'ITSUSP', 'Intrathecal Suspension', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(88, 'OPSUSP', 'Ophthalmic Suspension', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(89, 'ORSUSP', 'Oral Suspension', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(90, 'ERSUSP', 'Extended-Release Suspension', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(91, 'ERSUSP12', '12 Hour Extended-Release Suspension', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(92, 'ERSUSP24', '24 Hour Extended-Release Suspension', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(93, 'OTSUSP', 'Otic Suspension', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(94, 'RECSUSP', 'Rectal Suspension', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(95, 'BAR', 'Bar', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(96, 'BARSOAP', 'Bar Soap', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(97, 'MEDBAR', 'Medicated Bar Soap', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(98, 'CHEWBAR', 'Chewable Bar', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(99, 'BEAD', 'Beads', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(100, 'CAKE', 'Cake', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(101, 'CEMENT', 'Cement', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(102, 'CRYS', 'Crystals', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(103, 'DISK', 'Disk', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(104, 'FLAKE', 'Flakes', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(105, 'GRAN', 'Granules', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(106, 'GUM', 'Chewing Gum', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(107, 'PAD', 'Pad', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(108, 'MEDPAD', 'Medicated Pad', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(109, 'PATCH', 'Patch', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(110, 'TPATCH', 'Transdermal Patch', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(111, 'TPATH16', '16 Hour Transdermal Patch', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(112, 'TPATH24', '24 Hour Transdermal Patch', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(113, 'TPATH2WK', 'Biweekly Transdermal Patch', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(114, 'TPATH72', '72 Hour Transdermal Patch', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(115, 'TPATHWK', 'Weekly Transdermal Patch', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(116, 'PELLET', 'Pellet', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(117, 'PILL', 'Pill', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(118, 'CAP', 'Capsule', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(119, 'ORCAP', 'Oral Capsule', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(120, 'ENTCAP', 'Enteric Coated Capsule', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(121, 'ERENTCAP', 'Extended Release Enteric Coated Capsule', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(122, 'ERCAP', 'Extended Release Capsule', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(123, 'ERCAP12', '12 Hour Extended Release Capsule', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(124, 'ERCAP24', '24 Hour Extended Release Capsule', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(125, 'TAB', 'Tablet', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(126, 'ORTAB', 'Oral Tablet', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(127, 'BUCTAB', 'Buccal Tablet', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(128, 'SRBUCTAB', 'Sustained Release Buccal Tablet', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(129, 'CAPLET', 'Caplet', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(130, 'CHEWTAB', 'Chewable Tablet', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(131, 'CPTAB', 'Coated Particles Tablet', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(132, 'DISINTAB', 'Disintegrating Tablet', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(133, 'DRTAB', 'Delayed Release Tablet', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(134, 'ECTAB', 'Enteric Coated Tablet', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(135, 'ERECTAB', 'Extended Release Enteric Coated Tablet', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(136, 'ERTAB', 'Extended Release Tablet', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(137, 'ERTAB12', '12 Hour Extended Release Tablet', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(138, 'ERTAB24', '24 Hour Extended Release Tablet', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(139, 'ORTROCHE', 'Lozenge/Oral Troche', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(140, 'SLTAB', 'Sublingual Tablet', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(141, 'VAGTAB', 'Vaginal Tablet', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(142, 'POWD', 'Powder', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(143, 'TOPPWD', 'Topical Powder', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(144, 'RECPWD', 'Rectal Powder', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(145, 'VAGPWD', 'Vaginal Powder', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(146, 'SUPP', 'Suppository', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(147, 'RECSUPP', 'Rectal Suppository', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(148, 'URETHSUPP', 'Urethral Suppository', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(149, 'VAGSUPP', 'Vaginal Suppository', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(150, 'SWAB', 'Swab', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(151, 'MEDSWAB', 'Medicated Swab', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html'),
(152, 'WAFER', 'Wafer', 'https://terminology.hl7.org/7.0.1/CodeSystem-v3-orderableDrugForm.html');

-- --------------------------------------------------------

--
-- Table structure for table `referensi_numerator`
--

DROP TABLE IF EXISTS `referensi_numerator`;
CREATE TABLE IF NOT EXISTS `referensi_numerator` (
  `id_referensi_numerator` int NOT NULL AUTO_INCREMENT,
  `unit` varchar(255) NOT NULL,
  `code_numerator` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `system_numerator` text NOT NULL,
  PRIMARY KEY (`id_referensi_numerator`)
) ENGINE=InnoDB AUTO_INCREMENT=845 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `referensi_numerator`
--

INSERT INTO `referensi_numerator` (`id_referensi_numerator`, `unit`, `code_numerator`, `system_numerator`) VALUES
(1, '10 liter per minute', '10.L/min', 'http://unitsofmeasure.org'),
(2, '10 liter per minute per square meter', '10.L/(min.m2)', 'http://unitsofmeasure.org'),
(3, '10 micronewton second per centimeter to the fifth power per square meter', '10.uN.s/(cm5.m2)', 'http://unitsofmeasure.org'),
(4, '10 thousand per microliter', '10*4/uL', 'http://unitsofmeasure.org'),
(5, '100 million', '10*8', 'http://unitsofmeasure.org'),
(6, '24 hour', '24.h', 'http://unitsofmeasure.org'),
(7, 'absorbance', '{absorbance}', 'http://unitsofmeasure.org'),
(8, 'activity', '{activity}', 'http://unitsofmeasure.org'),
(9, 'allergy unit', '[AU]', 'http://unitsofmeasure.org'),
(10, 'American Hospital Formulary unit', '{AHF\'U}', 'http://unitsofmeasure.org'),
(11, 'year', 'A', 'http://unitsofmeasure.org'),
(12, 'ampere per meter', 'A/m', 'http://unitsofmeasure.org'),
(13, 'arbitrary unit', '[arb\'U]', 'http://unitsofmeasure.org'),
(14, 'arbitrary unit per milliliter', '[arb\'U]/mL', 'http://unitsofmeasure.org'),
(15, 'aspirin response unit', '{ARU}', 'http://unitsofmeasure.org'),
(16, 'atmosphere', 'atm', 'http://unitsofmeasure.org'),
(17, 'attogram per cell', 'ag/{cell}', 'http://unitsofmeasure.org'),
(18, 'bar', 'bar', 'http://unitsofmeasure.org'),
(19, 'Becquerel', 'Bq', 'http://unitsofmeasure.org'),
(20, 'Bethesda unit', '[beth\'U]', 'http://unitsofmeasure.org'),
(21, 'billion per liter', '10*9/L', 'http://unitsofmeasure.org'),
(22, 'billion per microliter', '10*9/uL', 'http://unitsofmeasure.org'),
(23, 'billion per milliliter', '10*9/mL', 'http://unitsofmeasure.org'),
(24, 'binding index', '{binding_index}', 'http://unitsofmeasure.org'),
(25, 'Bodansky unit', '[bdsk\'U]', 'http://unitsofmeasure.org'),
(26, 'breaths per minute', '{breaths}/min', 'http://unitsofmeasure.org'),
(27, 'CAG trinucleotide repeats', '{CAG_repeats}', 'http://unitsofmeasure.org'),
(28, 'calorie', 'cal', 'http://unitsofmeasure.org'),
(29, 'cells', '{cells}', 'http://unitsofmeasure.org'),
(30, 'cells per high power field', '{cells}/[HPF]', 'http://unitsofmeasure.org'),
(31, 'cells per microliter', '{cells}/uL', 'http://unitsofmeasure.org'),
(32, 'centigram', 'cg', 'http://unitsofmeasure.org'),
(33, 'centiliter', 'cL', 'http://unitsofmeasure.org'),
(34, 'centimeter', 'cm', 'http://unitsofmeasure.org'),
(35, 'centimeter of mercury', 'cm[Hg]', 'http://unitsofmeasure.org'),
(36, 'centimeter of water', 'cm[H2O]', 'http://unitsofmeasure.org'),
(37, 'centimeter of water per liter per second', 'cm[H2O]/L/s', 'http://unitsofmeasure.org'),
(38, 'centimeter of water per second per meter', 'cm[H2O]/s/m', 'http://unitsofmeasure.org'),
(39, 'centimeter per second', 'cm/s', 'http://unitsofmeasure.org'),
(40, 'centipoise', 'cP', 'http://unitsofmeasure.org'),
(41, 'centistoke', 'cSt', 'http://unitsofmeasure.org'),
(42, 'change in (delta) optical density', '{delta_OD}', 'http://unitsofmeasure.org'),
(43, 'clock time e.g 12:30PM', '{clock_time}', 'http://unitsofmeasure.org'),
(44, 'colony forming unit', '[CFU]', 'http://unitsofmeasure.org'),
(45, 'colony forming unit per liter', '[CFU]/L', 'http://unitsofmeasure.org'),
(46, 'colony forming unit per milliliter', '[CFU]/mL', 'http://unitsofmeasure.org'),
(47, 'complement activity enzyme unit', '{CAE\'U}', 'http://unitsofmeasure.org'),
(48, 'complement CH100 unit', '{CH100\'U}', 'http://unitsofmeasure.org'),
(49, 'copies', '{copies}', 'http://unitsofmeasure.org'),
(50, 'copies per microgram', '{copies}/ug', 'http://unitsofmeasure.org'),
(51, 'copies per milliliter', '{copies}/mL', 'http://unitsofmeasure.org'),
(52, 'count', '{count}', 'http://unitsofmeasure.org'),
(53, 'counts per minute', '{CPM}', 'http://unitsofmeasure.org'),
(54, 'counts per minute per thousand cells', '{CPM}/10*3{cell}', 'http://unitsofmeasure.org'),
(55, 'cubic centimeter', 'cm3', 'http://unitsofmeasure.org'),
(56, 'cubic inch (international)', '[cin_i]', 'http://unitsofmeasure.org'),
(57, 'cubic meter per second', 'm3/s', 'http://unitsofmeasure.org'),
(58, 'Cycle threshold value', '{Ct_value}', 'http://unitsofmeasure.org'),
(59, 'day', 'd', 'http://unitsofmeasure.org'),
(60, 'day per 7 day', 'd/(7.d)', 'http://unitsofmeasure.org'),
(61, 'days per week', 'd/wk', 'http://unitsofmeasure.org'),
(62, 'decibel', 'dB', 'http://unitsofmeasure.org'),
(63, 'decigram', 'dg', 'http://unitsofmeasure.org'),
(64, 'deciliter', 'dL', 'http://unitsofmeasure.org'),
(65, 'decimeter', 'dm', 'http://unitsofmeasure.org'),
(66, 'degree (plane angle)', 'deg', 'http://unitsofmeasure.org'),
(67, 'degree Celsius', 'Cel', 'http://unitsofmeasure.org'),
(68, 'degree Fahrenheit', '[degF]', 'http://unitsofmeasure.org'),
(69, 'degree Kelvin', 'K', 'http://unitsofmeasure.org'),
(70, 'degree Kelvin per Watt', 'K/W', 'http://unitsofmeasure.org'),
(71, 'degree per second', 'deg/s', 'http://unitsofmeasure.org'),
(72, 'dekaliter per minute', 'daL/min', 'http://unitsofmeasure.org'),
(73, 'dekaliter per minute per square meter', 'daL/min/m2', 'http://unitsofmeasure.org'),
(74, 'dilution', '{dilution}', 'http://unitsofmeasure.org'),
(75, 'diopter', '[diop]', 'http://unitsofmeasure.org'),
(76, 'dram  (US and British)', '[dr_av]', 'http://unitsofmeasure.org'),
(77, 'drop (1/12 milliliter)', '[drp]', 'http://unitsofmeasure.org'),
(78, 'dyne second per centimeter', 'dyn.s/cm', 'http://unitsofmeasure.org'),
(79, 'dyne second per centimeter per square meter', 'dyn.s/(cm.m2)', 'http://unitsofmeasure.org'),
(80, 'Ehrlich unit', '{Ehrlich\'U}', 'http://unitsofmeasure.org'),
(81, 'Ehrlich unit per 100 gram', '{Ehrlich\'U}/100.g', 'http://unitsofmeasure.org'),
(82, 'Ehrlich unit per 2 hour', '{Ehrlich\'U}/(2.h)', 'http://unitsofmeasure.org'),
(83, 'Ehrlich unit per day', '{Ehrlich\'U}/d', 'http://unitsofmeasure.org'),
(84, 'Ehrlich unit per deciliter', '{Ehrlich\'U}/dL', 'http://unitsofmeasure.org'),
(85, 'EIA index', '{EIA_index}', 'http://unitsofmeasure.org'),
(86, 'EIA titer', '{EIA_titer}', 'http://unitsofmeasure.org'),
(87, 'EIA unit', '{EIA\'U}', 'http://unitsofmeasure.org'),
(88, 'EIA unit per enzyme unit', '{EIA\'U}/U', 'http://unitsofmeasure.org'),
(89, 'EIA value', '{EV}', 'http://unitsofmeasure.org'),
(90, 'electron Volt', 'eV', 'http://unitsofmeasure.org'),
(91, 'ELISA unit', '{ELISA\'U}', 'http://unitsofmeasure.org'),
(92, 'enzyme unit', 'U', 'http://unitsofmeasure.org'),
(93, 'enzyme unit per 10', 'U/10', 'http://unitsofmeasure.org'),
(94, 'enzyme unit per 10 billion', 'U/10*10', 'http://unitsofmeasure.org'),
(95, 'enzyme unit per 10 billion cells', 'U/10*10{cells}', 'http://unitsofmeasure.org'),
(96, 'enzyme unit per 10 gram of feces', 'U/(10.g){feces}', 'http://unitsofmeasure.org'),
(97, 'enzyme unit per 12 hour', 'U/(12.h)', 'http://unitsofmeasure.org'),
(98, 'enzyme unit per 2 hour', 'U/(2.h)', 'http://unitsofmeasure.org'),
(99, 'enzyme unit per 24 hour', 'U/(24.h)', 'http://unitsofmeasure.org'),
(100, 'enzyme unit per billion', 'U/10*9', 'http://unitsofmeasure.org'),
(101, 'enzyme unit per day', 'U/d', 'http://unitsofmeasure.org'),
(102, 'enzyme unit per deciliter', 'U/dL', 'http://unitsofmeasure.org'),
(103, 'enzyme unit per gram', 'U/g', 'http://unitsofmeasure.org'),
(104, 'enzyme unit per gram of creatinine', 'U/g{creat}', 'http://unitsofmeasure.org'),
(105, 'enzyme unit per gram of hemoglobin', 'U/g{Hb}', 'http://unitsofmeasure.org'),
(106, 'enzyme unit per gram of protein', 'U/g{protein}', 'http://unitsofmeasure.org'),
(107, 'enzyme unit per hour', 'U/h', 'http://unitsofmeasure.org'),
(108, 'enzyme unit per kilogram of hemoglobin', 'U/kg{Hb}', 'http://unitsofmeasure.org'),
(109, 'enzyme unit per liter', 'U/L', 'http://unitsofmeasure.org'),
(110, 'enzyme unit per liter at 25 deg Celsius', 'U{25Cel}/L', 'http://unitsofmeasure.org'),
(111, 'enzyme unit per liter at 37 deg Celsius', 'U{37Cel}/L', 'http://unitsofmeasure.org'),
(112, 'enzyme unit per milliliter', 'U/mL', 'http://unitsofmeasure.org'),
(113, 'enzyme unit per milliliter of red blood cells', 'U/mL{RBCs}', 'http://unitsofmeasure.org'),
(114, 'enzyme unit per millimole of creatinine', 'U/mmol{creat}', 'http://unitsofmeasure.org'),
(115, 'enzyme unit per million', 'U/10*6', 'http://unitsofmeasure.org'),
(116, 'enzyme unit per minute', 'U/min', 'http://unitsofmeasure.org'),
(117, 'enzyme unit per second', 'U/s', 'http://unitsofmeasure.org'),
(118, 'enzyme unit per trillion', 'U/10*12', 'http://unitsofmeasure.org'),
(119, 'enzyme unit per trillion red blood cells', 'U/10*12{RBCs}', 'http://unitsofmeasure.org'),
(120, 'equivalent', 'eq', 'http://unitsofmeasure.org'),
(121, 'equivalent per liter', 'eq/L', 'http://unitsofmeasure.org'),
(122, 'equivalent per micromole', 'eq/umol', 'http://unitsofmeasure.org'),
(123, 'equivalent per milliliter', 'eq/mL', 'http://unitsofmeasure.org'),
(124, 'equivalent per millimole', 'eq/mmol', 'http://unitsofmeasure.org'),
(125, 'erg', 'erg', 'http://unitsofmeasure.org'),
(126, 'Farad', 'F', 'http://unitsofmeasure.org'),
(127, 'feet (US) per feet (US)', '[ft_us]/[ft_us]', 'http://unitsofmeasure.org'),
(128, 'femtogram', 'fg', 'http://unitsofmeasure.org'),
(129, 'femtoliter', 'fL', 'http://unitsofmeasure.org'),
(130, 'femtometer', 'fm', 'http://unitsofmeasure.org'),
(131, 'femtomole', 'fmol', 'http://unitsofmeasure.org'),
(132, 'femtomole per gram', 'fmol/g', 'http://unitsofmeasure.org'),
(133, 'femtomole per liter', 'fmol/L', 'http://unitsofmeasure.org'),
(134, 'femtomole per milligram', 'fmol/mg', 'http://unitsofmeasure.org'),
(135, 'femtomole per milligram of cytosol protein', 'fmol/mg{cyt_prot}', 'http://unitsofmeasure.org'),
(136, 'femtomole per milligram of protein', 'fmol/mg{prot}', 'http://unitsofmeasure.org'),
(137, 'femtomole per milliliter', 'fmol/mL', 'http://unitsofmeasure.org'),
(138, 'fluid ounce (US)', '[foz_us]', 'http://unitsofmeasure.org'),
(139, 'fluorescent intensity unit', '{FIU}', 'http://unitsofmeasure.org'),
(140, 'foot (international)', '[ft_i]', 'http://unitsofmeasure.org'),
(141, 'fraction', '{fraction}', 'http://unitsofmeasure.org'),
(142, 'French (catheter gauge)', '[Ch]', 'http://unitsofmeasure.org'),
(143, 'GAA trinucleotide repeats', '{GAA_repeats}', 'http://unitsofmeasure.org'),
(144, 'gallon (US)', '[gal_us]', 'http://unitsofmeasure.org'),
(145, 'genomes per milliliter', '{genomes}/mL', 'http://unitsofmeasure.org'),
(146, 'globules (drops)  per high power field', '{Globules}/[HPF]', 'http://unitsofmeasure.org'),
(147, 'gram', 'g', 'http://unitsofmeasure.org'),
(148, 'gram meter', 'g.m', 'http://unitsofmeasure.org'),
(149, 'gram meter per heart beat', 'g.m/{beat}', 'http://unitsofmeasure.org'),
(150, 'gram of creatinine', 'g{creat}', 'http://unitsofmeasure.org'),
(151, 'gram of hemoglobin', 'g{Hb}', 'http://unitsofmeasure.org'),
(152, 'gram of total nitrogen', 'g{total_nit}', 'http://unitsofmeasure.org'),
(153, 'gram of total protein', 'g{total_prot}', 'http://unitsofmeasure.org'),
(154, 'gram of wet tissue', 'g{wet_tissue}', 'http://unitsofmeasure.org'),
(155, 'gram per  kilogram per 8 hour', 'g/kg/(8.h)', 'http://unitsofmeasure.org'),
(156, 'gram per 100 gram', 'g/(100.g)', 'http://unitsofmeasure.org'),
(157, 'gram per 12 hour', 'g/(12.h)', 'http://unitsofmeasure.org'),
(158, 'gram per 24 hour', 'g/(24.h)', 'http://unitsofmeasure.org'),
(159, 'gram per 3 days', 'g/(3.d)', 'http://unitsofmeasure.org'),
(160, 'gram per 4 hour', 'g/(4.h)', 'http://unitsofmeasure.org'),
(161, 'gram per 48 hour', 'g/(48.h)', 'http://unitsofmeasure.org'),
(162, 'gram per 5 hour', 'g/(5.h)', 'http://unitsofmeasure.org'),
(163, 'gram per 6 hour', 'g/(6.h)', 'http://unitsofmeasure.org'),
(164, 'gram per 72 hour', 'g/(72.h)', 'http://unitsofmeasure.org'),
(165, 'gram per 8 hour shift', 'g/(8.h){shift}', 'http://unitsofmeasure.org'),
(166, 'gram per cubic centimeter', 'g/cm3', 'http://unitsofmeasure.org'),
(167, 'gram per day', 'g/d', 'http://unitsofmeasure.org'),
(168, 'gram per deciliter', 'g/dL', 'http://unitsofmeasure.org'),
(169, 'gram per gram', 'g/g', 'http://unitsofmeasure.org'),
(170, 'gram per gram of creatinine', 'g/g{creat}', 'http://unitsofmeasure.org'),
(171, 'gram per gram of globulin', 'g/g{globulin}', 'http://unitsofmeasure.org'),
(172, 'gram per gram of tissue', 'g/g{tissue}', 'http://unitsofmeasure.org'),
(173, 'gram per hour', 'g/h', 'http://unitsofmeasure.org'),
(174, 'gram per hour per square meter', 'g/h/m2', 'http://unitsofmeasure.org'),
(175, 'gram per kilogram', 'g/kg', 'http://unitsofmeasure.org'),
(176, 'gram per kilogram per 8 hour shift', 'g/kg/(8.h){shift}', 'http://unitsofmeasure.org'),
(177, 'gram per kilogram per day', 'g/kg/d', 'http://unitsofmeasure.org'),
(178, 'gram per kilogram per hour', 'g/kg/h', 'http://unitsofmeasure.org'),
(179, 'gram per kilogram per minute', 'g/kg/min', 'http://unitsofmeasure.org'),
(180, 'gram per liter', 'g/L', 'http://unitsofmeasure.org'),
(181, 'gram per milligram', 'g/mg', 'http://unitsofmeasure.org'),
(182, 'gram per milliliter', 'g/mL', 'http://unitsofmeasure.org'),
(183, 'gram per millimole', 'g/mmol', 'http://unitsofmeasure.org'),
(184, 'gram per minute', 'g/min', 'http://unitsofmeasure.org'),
(185, 'gram per mole of creatinine', 'g/mol{creat}', 'http://unitsofmeasure.org'),
(186, 'gram per specimen', 'g/{specimen}', 'http://unitsofmeasure.org'),
(187, 'gram per square centimeter', 'g/cm2', 'http://unitsofmeasure.org'),
(188, 'gram per square meter', 'g/m2', 'http://unitsofmeasure.org'),
(189, 'gram per total output', 'g/{total_output}', 'http://unitsofmeasure.org'),
(190, 'gram per total weight', 'g/{total_weight}', 'http://unitsofmeasure.org'),
(191, 'Gray', 'Gy', 'http://unitsofmeasure.org'),
(192, 'heart beats per minute', '{beats}/min', 'http://unitsofmeasure.org'),
(193, 'hour', 'H', 'http://unitsofmeasure.org'),
(194, 'Hertz', 'Hz', 'http://unitsofmeasure.org'),
(195, 'high power field', '[HPF]', 'http://unitsofmeasure.org'),
(196, 'hour per day', 'h/d', 'http://unitsofmeasure.org'),
(197, 'hour per week', 'h/wk', 'http://unitsofmeasure.org'),
(198, 'IgA anticardiolipin unit per milliliter**', '[APL\'U]/mL', 'http://unitsofmeasure.org'),
(199, 'IgA anticardiolipin unit**', '[APL\'U]', 'http://unitsofmeasure.org'),
(200, 'IgA antiphosphatidylserine unit', '{APS\'U}', 'http://unitsofmeasure.org'),
(201, 'IgG anticardiolipin unit per milliliter**', '[GPL\'U]/mL', 'http://unitsofmeasure.org'),
(202, 'IgG anticardiolipin unit**', '[GPL\'U]', 'http://unitsofmeasure.org'),
(203, 'IgG antiphosphatidylserine unit', '{GPS\'U}', 'http://unitsofmeasure.org'),
(204, 'IgM anticardiolipin unit per milliliter**', '[MPL\'U]/mL', 'http://unitsofmeasure.org'),
(205, 'IgM anticardiolipin unit**', '[MPL\'U]', 'http://unitsofmeasure.org'),
(206, 'IgM antiphosphatidylserine unit', '{MPS\'U}', 'http://unitsofmeasure.org'),
(207, 'IgM antiphosphatidylserine unit per milliliter', '{MPS\'U}/mL', 'http://unitsofmeasure.org'),
(208, 'immune complex unit', '{ImmuneComplex\'U}', 'http://unitsofmeasure.org'),
(209, 'immune status ratio', '{ISR}', 'http://unitsofmeasure.org'),
(210, 'immunofluorescence assay index', '{IFA_index}', 'http://unitsofmeasure.org'),
(211, 'Immunofluorescence assay titer', '{IFA_titer}', 'http://unitsofmeasure.org'),
(212, 'inch (international)', '[in_i]', 'http://unitsofmeasure.org'),
(213, 'inch (international) of water', '[in_i\'H2O]', 'http://unitsofmeasure.org'),
(214, 'inches (US)', '[in_us]', 'http://unitsofmeasure.org'),
(215, 'index value', '{index_val}', 'http://unitsofmeasure.org'),
(216, 'index value', '{index}', 'http://unitsofmeasure.org'),
(217, 'influenza hemagglutination titer', '{HA_titer}', 'http://unitsofmeasure.org'),
(218, 'international normalized ratio', '{INR}', 'http://unitsofmeasure.org'),
(219, 'international unit', '[IU]', 'http://unitsofmeasure.org'),
(220, 'international unit per 2 hour', '[IU]/(2.h)', 'http://unitsofmeasure.org'),
(221, 'international unit per 24 hour', '[IU]/(24.h)', 'http://unitsofmeasure.org'),
(222, 'international unit per billion red blood cells', '[IU]/10*9{RBCs}', 'http://unitsofmeasure.org'),
(223, 'international unit per day', '[IU]/d', 'http://unitsofmeasure.org'),
(224, 'international unit per deciliter', '[IU]/dL', 'http://unitsofmeasure.org'),
(225, 'international unit per gram', '[IU]/g', 'http://unitsofmeasure.org'),
(226, 'international unit per gram of hemoglobin', '[IU]/g{Hb}', 'http://unitsofmeasure.org'),
(227, 'international unit per hour', '[IU]/h', 'http://unitsofmeasure.org'),
(228, 'international unit per kilogram', '[IU]/kg', 'http://unitsofmeasure.org'),
(229, 'international unit per kilogram per day', '[IU]/kg/d', 'http://unitsofmeasure.org'),
(230, 'international unit per liter', '[IU]/L', 'http://unitsofmeasure.org'),
(231, 'international unit per liter at 37 degrees Celsius', '[IU]/L{37Cel}', 'http://unitsofmeasure.org'),
(232, 'international unit per milligram of creatinine', '[IU]/mg{creat}', 'http://unitsofmeasure.org'),
(233, 'international unit per milliliter', '[IU]/mL', 'http://unitsofmeasure.org'),
(234, 'international unit per minute', '[IU]/min', 'http://unitsofmeasure.org'),
(235, 'joule', 'J', 'http://unitsofmeasure.org'),
(236, 'joule per liter', 'J/L', 'http://unitsofmeasure.org'),
(237, 'Juvenile Diabetes Foundation unit', '{JDF\'U}', 'http://unitsofmeasure.org'),
(238, 'Juvenile Diabetes Foundation unit per liter', '{JDF\'U}/L', 'http://unitsofmeasure.org'),
(239, 'kaolin clotting time', '{KCT\'U}', 'http://unitsofmeasure.org'),
(240, 'katal', 'kat', 'http://unitsofmeasure.org'),
(241, 'katal per kilogram', 'kat/kg', 'http://unitsofmeasure.org'),
(242, 'katal per liter', 'kat/L', 'http://unitsofmeasure.org'),
(243, 'kilo enzyme unit', 'kU', 'http://unitsofmeasure.org'),
(244, 'kilo enzyme unit per gram', 'kU/g', 'http://unitsofmeasure.org'),
(245, 'kilo enzyme unit per liter', 'kU/L', 'http://unitsofmeasure.org'),
(246, 'kilo enzyme unit per liter class', 'kU/L{class}', 'http://unitsofmeasure.org'),
(247, 'kilo enzyme unit per milliliter', 'kU/mL', 'http://unitsofmeasure.org'),
(248, 'kilo international unit per liter', 'k[IU]/L', 'http://unitsofmeasure.org'),
(249, 'kilo international unit per milliliter', 'k[IU]/mL', 'http://unitsofmeasure.org'),
(250, 'kilocalorie', 'kcal', 'http://unitsofmeasure.org'),
(251, 'kilocalorie per 24 hour', 'kcal/(24.h)', 'http://unitsofmeasure.org'),
(252, 'kilocalorie per day', 'kcal/d', 'http://unitsofmeasure.org'),
(253, 'kilocalorie per hour', 'kcal/h', 'http://unitsofmeasure.org'),
(254, 'kilocalorie per kilogram per 24 hour', 'kcal/kg/(24.h)', 'http://unitsofmeasure.org'),
(255, 'kilocalorie per ounce (US & British)', 'kcal/[oz_av]', 'http://unitsofmeasure.org'),
(256, 'kilogram', 'kg', 'http://unitsofmeasure.org'),
(257, 'kilogram meter per second', 'kg.m/s', 'http://unitsofmeasure.org'),
(258, 'kilogram per cubic meter', 'kg/m3', 'http://unitsofmeasure.org'),
(259, 'kilogram per hour', 'kg/h', 'http://unitsofmeasure.org'),
(260, 'kilogram per liter', 'kg/L', 'http://unitsofmeasure.org'),
(261, 'kilogram per minute', 'kg/min', 'http://unitsofmeasure.org'),
(262, 'kilogram per mole', 'kg/mol', 'http://unitsofmeasure.org'),
(263, 'kilogram per second', 'kg/s', 'http://unitsofmeasure.org'),
(264, 'kilogram per second per square meter', 'kg/(s.m2)', 'http://unitsofmeasure.org'),
(265, 'kilogram per square meter', 'kg/m2', 'http://unitsofmeasure.org'),
(266, 'kiloliter', 'kL', 'http://unitsofmeasure.org'),
(267, 'kilometer', 'km', 'http://unitsofmeasure.org'),
(268, 'kilopascal', 'kPa', 'http://unitsofmeasure.org'),
(269, 'kilosecond', 'ks', 'http://unitsofmeasure.org'),
(270, 'King Armstrong unit', '[ka\'U]', 'http://unitsofmeasure.org'),
(271, 'Kronus unit per milliliter', '{KRONU\'U}/mL', 'http://unitsofmeasure.org'),
(272, 'Kunkel unit', '[knk\'U]', 'http://unitsofmeasure.org'),
(273, 'liter', 'L', 'http://unitsofmeasure.org'),
(274, 'liter per 24 hour', 'L/(24.h)', 'http://unitsofmeasure.org'),
(275, 'liter per 8 hour', 'L/(8.h)', 'http://unitsofmeasure.org'),
(276, 'liter per day', 'L/d', 'http://unitsofmeasure.org'),
(277, 'liter per hour', 'L/h', 'http://unitsofmeasure.org'),
(278, 'liter per kilogram', 'L/kg', 'http://unitsofmeasure.org'),
(279, 'liter per liter', 'L/L', 'http://unitsofmeasure.org'),
(280, 'liter per minute', 'L/min', 'http://unitsofmeasure.org'),
(281, 'liter per minute per sqaure meter', 'L/min/m2', 'http://unitsofmeasure.org'),
(282, 'liter per minute per square meter', 'L/(min.m2)', 'http://unitsofmeasure.org'),
(283, 'liter per second', 'L/s', 'http://unitsofmeasure.org'),
(284, 'liter per second per square second', 'L/s/s2', 'http://unitsofmeasure.org'),
(285, 'log (base 10) copies per milliliter', '{Log_copies}/mL', 'http://unitsofmeasure.org'),
(286, 'log (base 10) international unit', '{Log_IU}', 'http://unitsofmeasure.org'),
(287, 'log (base 10) international unit per milliliter', '{Log_IU}/mL', 'http://unitsofmeasure.org'),
(288, 'log base 10', '{Log}', 'http://unitsofmeasure.org'),
(289, 'low power field', '[LPF]', 'http://unitsofmeasure.org'),
(290, 'lumen', 'lm', 'http://unitsofmeasure.org'),
(291, 'lumen square meter', 'lm.m2', 'http://unitsofmeasure.org'),
(292, 'Lyme index value', '{Lyme_index_value}', 'http://unitsofmeasure.org'),
(293, 'Maclagan unit', '[mclg\'U]', 'http://unitsofmeasure.org'),
(294, 'millisecond', 'Ms', 'http://unitsofmeasure.org'),
(295, 'metabolic equivalent minute per week', '[MET].min/wk', 'http://unitsofmeasure.org'),
(296, 'meter', 'm', 'http://unitsofmeasure.org'),
(297, 'meter per second', 'm/s', 'http://unitsofmeasure.org'),
(298, 'meter per square second', 'm/s2', 'http://unitsofmeasure.org'),
(299, 'Tesla', 't', 'http://unitsofmeasure.org'),
(300, 'micro enzyme unit per gram', 'uU/g', 'http://unitsofmeasure.org'),
(301, 'micro enzyme unit per liter', 'uU/L', 'http://unitsofmeasure.org'),
(302, 'micro enzyme unit per milliliter', 'uU/mL', 'http://unitsofmeasure.org'),
(303, 'micro international unit', 'u[IU]', 'http://unitsofmeasure.org'),
(304, 'micro international unit per milliliter', 'u[IU]/mL', 'http://unitsofmeasure.org'),
(305, 'microequivalent', 'ueq', 'http://unitsofmeasure.org'),
(306, 'microequivalent per liter', 'ueq/L', 'http://unitsofmeasure.org'),
(307, 'microequivalent per milliliter', 'ueq/mL', 'http://unitsofmeasure.org'),
(308, 'microgram', 'ug', 'http://unitsofmeasure.org'),
(309, 'microgram  per gram of feces', 'ug/g{feces}', 'http://unitsofmeasure.org'),
(310, 'microgram fibrinogen equivalent unit per milliliter', 'ug{FEU}/mL', 'http://unitsofmeasure.org'),
(311, 'microgram per 100 gram', 'ug/(100.g)', 'http://unitsofmeasure.org'),
(312, 'microgram per 24 hour', 'ug/(24.h)', 'http://unitsofmeasure.org'),
(313, 'microgram per 8 hour', 'ug/(8.h)', 'http://unitsofmeasure.org'),
(314, 'microgram per cubic meter', 'ug/m3', 'http://unitsofmeasure.org'),
(315, 'microgram per day', 'ug/d', 'http://unitsofmeasure.org'),
(316, 'microgram per deciliter', 'ug/dL', 'http://unitsofmeasure.org'),
(317, 'microgram per deciliter of red blood cells', 'ug/dL{RBCs}', 'http://unitsofmeasure.org'),
(318, 'microgram per gram', 'ug/g', 'http://unitsofmeasure.org'),
(319, 'microgram per gram of creatinine', 'ug/g{creat}', 'http://unitsofmeasure.org'),
(320, 'microgram per gram of dry tissue', 'ug/g{dry_tissue}', 'http://unitsofmeasure.org'),
(321, 'microgram per gram of dry weight', 'ug/g{dry_wt}', 'http://unitsofmeasure.org'),
(322, 'microgram per gram of hair', 'ug/g{hair}', 'http://unitsofmeasure.org'),
(323, 'microgram per gram of hemoglobin', 'ug/g{Hb}', 'http://unitsofmeasure.org'),
(324, 'microgram per gram of tissue', 'ug/g{tissue}', 'http://unitsofmeasure.org'),
(325, 'microgram per hour', 'ug/h', 'http://unitsofmeasure.org'),
(326, 'microgram per kilogram', 'ug/kg', 'http://unitsofmeasure.org'),
(327, 'microgram per kilogram per 8 hour', 'ug/kg/(8.h)', 'http://unitsofmeasure.org'),
(328, 'microgram per kilogram per day', 'ug/kg/d', 'http://unitsofmeasure.org'),
(329, 'microgram per kilogram per hour', 'ug/kg/h', 'http://unitsofmeasure.org'),
(330, 'microgram per kilogram per minute', 'ug/kg/min', 'http://unitsofmeasure.org'),
(331, 'microgram per liter', 'ug/L', 'http://unitsofmeasure.org'),
(332, 'microgram per liter of red blood cells', 'ug/L{RBCs}', 'http://unitsofmeasure.org'),
(333, 'microgram per liter per 24 hour', 'ug/L/(24.h)', 'http://unitsofmeasure.org'),
(334, 'microgram per milligram', 'ug/mg', 'http://unitsofmeasure.org'),
(335, 'microgram per milligram of creatinine', 'ug/mg{creat}', 'http://unitsofmeasure.org'),
(336, 'microgram per milliliter', 'ug/mL', 'http://unitsofmeasure.org'),
(337, 'microgram per milliliter class', 'ug/mL{class}', 'http://unitsofmeasure.org'),
(338, 'microgram per milliliter equivalent', 'ug/mL{eqv}', 'http://unitsofmeasure.org'),
(339, 'microgram per millimole', 'ug/mmol', 'http://unitsofmeasure.org'),
(340, 'microgram per millimole of creatinine', 'ug/mmol{creat}', 'http://unitsofmeasure.org'),
(341, 'microgram per minute', 'ug/min', 'http://unitsofmeasure.org'),
(342, 'microgram per nanogram', 'ug/ng', 'http://unitsofmeasure.org'),
(343, 'microgram per specimen', 'ug/{specimen}', 'http://unitsofmeasure.org'),
(344, 'microgram per square foot (international)', 'ug/[sft_i]', 'http://unitsofmeasure.org'),
(345, 'microgram per square meter', 'ug/m2', 'http://unitsofmeasure.org'),
(346, 'microinternational unit per liter', 'u[IU]/L', 'http://unitsofmeasure.org'),
(347, 'microkatal', 'ukat', 'http://unitsofmeasure.org'),
(348, 'microliter', 'uL', 'http://unitsofmeasure.org'),
(349, 'microliter per 2 hour', 'uL/(2.h)', 'http://unitsofmeasure.org'),
(350, 'microliter per hour', 'uL/h', 'http://unitsofmeasure.org'),
(351, 'micrometer', 'um', 'http://unitsofmeasure.org'),
(352, 'micromole', 'umol', 'http://unitsofmeasure.org'),
(353, 'micromole bone collagen equivalent per mole', 'umol{BCE}/mol', 'http://unitsofmeasure.org'),
(354, 'micromole per 2 hour', 'umol/(2.h)', 'http://unitsofmeasure.org'),
(355, 'micromole per 24 hour', 'umol/(24.h)', 'http://unitsofmeasure.org'),
(356, 'micromole per 8 hour', 'umol/(8.h)', 'http://unitsofmeasure.org'),
(357, 'micromole per day', 'umol/d', 'http://unitsofmeasure.org'),
(358, 'micromole per deciliter', 'umol/dL', 'http://unitsofmeasure.org'),
(359, 'micromole per deciliter of glomerular filtrate', 'umol/dL{GF}', 'http://unitsofmeasure.org'),
(360, 'micromole per gram', 'umol/g', 'http://unitsofmeasure.org'),
(361, 'micromole per gram of creatinine', 'umol/g{creat}', 'http://unitsofmeasure.org'),
(362, 'micromole per gram of hemoglobin', 'umol/g{Hb}', 'http://unitsofmeasure.org'),
(363, 'micromole per hour', 'umol/h', 'http://unitsofmeasure.org'),
(364, 'micromole per kilogram', 'umol/kg', 'http://unitsofmeasure.org'),
(365, 'micromole per kilogram of feces', 'umol/kg{feces}', 'http://unitsofmeasure.org'),
(366, 'micromole per liter', 'umol/L', 'http://unitsofmeasure.org'),
(367, 'micromole per liter of red blood cells', 'umol/L{RBCs}', 'http://unitsofmeasure.org'),
(368, 'micromole per liter per hour', 'umol/L/h', 'http://unitsofmeasure.org'),
(369, 'micromole per micromole', 'umol/umol', 'http://unitsofmeasure.org'),
(370, 'micromole per micromole of creatinine', 'umol/umol{creat}', 'http://unitsofmeasure.org'),
(371, 'micromole per milligram', 'umol/mg', 'http://unitsofmeasure.org'),
(372, 'micromole per milligram of creatinine', 'umol/mg{creat}', 'http://unitsofmeasure.org'),
(373, 'micromole per milliliter', 'umol/mL', 'http://unitsofmeasure.org'),
(374, 'micromole per milliliter per minute', 'umol/mL/min', 'http://unitsofmeasure.org'),
(375, 'micromole per millimole', 'umol/mmol', 'http://unitsofmeasure.org'),
(376, 'micromole per millimole of creatinine', 'umol/mmol{creat}', 'http://unitsofmeasure.org'),
(377, 'micromole per million red blood cell', 'umol/10*6{RBC}', 'http://unitsofmeasure.org'),
(378, 'micromole per minute', 'umol/min', 'http://unitsofmeasure.org'),
(379, 'micromole per minute per gram', 'umol/min/g', 'http://unitsofmeasure.org'),
(380, 'micromole per minute per gram of mucosa', 'umol/min/g{mucosa}', 'http://unitsofmeasure.org'),
(381, 'micromole per minute per gram of protein', 'umol/min/g{prot}', 'http://unitsofmeasure.org'),
(382, 'micromole per minute per liter', 'umol/min/L', 'http://unitsofmeasure.org'),
(383, 'micromole per mole', 'umol/mol', 'http://unitsofmeasure.org'),
(384, 'micromole per mole of creatinine', 'umol/mol{creat}', 'http://unitsofmeasure.org'),
(385, 'micromole per mole of hemoglobin', 'umol/mol{Hb}', 'http://unitsofmeasure.org'),
(386, 'microns per second', 'um/s', 'http://unitsofmeasure.org'),
(387, 'microOhm', 'uOhm', 'http://unitsofmeasure.org'),
(388, 'microsecond', 'us', 'http://unitsofmeasure.org'),
(389, 'microvolt', 'uV', 'http://unitsofmeasure.org'),
(390, 'mile (international)', '[mi_i]', 'http://unitsofmeasure.org'),
(391, 'milli  enzyme unit per gram', 'mU/g', 'http://unitsofmeasure.org'),
(392, 'milli  enzyme unit per milliliter', 'mU/mL', 'http://unitsofmeasure.org'),
(393, 'milli  enzyme unit per milliliter per minute', 'mU/mL/min', 'http://unitsofmeasure.org'),
(394, 'milli  enzyme unit per millimole of creatinine', 'mU/mmol{creat}', 'http://unitsofmeasure.org'),
(395, 'milli  enzyme unit per millimole of red blood cells', 'mU/mmol{RBCs}', 'http://unitsofmeasure.org'),
(396, 'milli  international unit per milliliter', 'm[IU]/mL', 'http://unitsofmeasure.org'),
(397, 'milli enzyme unit per gram of hemoglobin', 'mU/g{Hb}', 'http://unitsofmeasure.org'),
(398, 'milli enzyme unit per gram of protein', 'mU/g{prot}', 'http://unitsofmeasure.org'),
(399, 'milli enzyme unit per liter', 'mU/L', 'http://unitsofmeasure.org'),
(400, 'milli enzyme unit per milligram', 'mU/mg', 'http://unitsofmeasure.org'),
(401, 'milli enzyme unit per milligram of creatinine', 'mU/mg{creat}', 'http://unitsofmeasure.org'),
(402, 'milli international unit per liter', 'm[IU]/L', 'http://unitsofmeasure.org'),
(403, 'milliampere', 'mA', 'http://unitsofmeasure.org'),
(404, 'millibar', 'mbar', 'http://unitsofmeasure.org'),
(405, 'millibar per liter per second', 'mbar/L/s', 'http://unitsofmeasure.org'),
(406, 'millibar second per liter', 'mbar.s/L', 'http://unitsofmeasure.org'),
(407, 'milliequivalent', 'meq', 'http://unitsofmeasure.org'),
(408, 'milliequivalent per 2 hour', 'meq/(2.h)', 'http://unitsofmeasure.org'),
(409, 'milliequivalent per 24 hour', 'meq/(24.h)', 'http://unitsofmeasure.org'),
(410, 'milliequivalent per 8 hour', 'meq/(8.h)', 'http://unitsofmeasure.org'),
(411, 'milliequivalent per day', 'meq/d', 'http://unitsofmeasure.org'),
(412, 'milliequivalent per deciliter', 'meq/dL', 'http://unitsofmeasure.org'),
(413, 'milliequivalent per gram', 'meq/g', 'http://unitsofmeasure.org'),
(414, 'milliequivalent per gram of creatinine', 'meq/g{creat}', 'http://unitsofmeasure.org'),
(415, 'milliequivalent per hour', 'meq/h', 'http://unitsofmeasure.org'),
(416, 'milliequivalent per kilogram', 'meq/kg', 'http://unitsofmeasure.org'),
(417, 'milliequivalent per kilogram per hour', 'meq/kg/h', 'http://unitsofmeasure.org'),
(418, 'milliequivalent per liter', 'meq/L', 'http://unitsofmeasure.org'),
(419, 'milliequivalent per milliliter', 'meq/mL', 'http://unitsofmeasure.org'),
(420, 'milliequivalent per minute', 'meq/min', 'http://unitsofmeasure.org'),
(421, 'milliequivalent per specimen', 'meq/{specimen}', 'http://unitsofmeasure.org'),
(422, 'milliequivalent per square meter', 'meq/m2', 'http://unitsofmeasure.org'),
(423, 'milliequivalent per total volume', 'meq/{total_volume}', 'http://unitsofmeasure.org'),
(424, 'milligram', 'mg', 'http://unitsofmeasure.org'),
(425, 'milligram fibrinogen equivalent unit per liter', 'mg{FEU}/L', 'http://unitsofmeasure.org'),
(426, 'milligram per 10 hour', 'mg/(10.h)', 'http://unitsofmeasure.org'),
(427, 'milligram per 12 hour', 'mg/(12.h)', 'http://unitsofmeasure.org'),
(428, 'milligram per 2 hour', 'mg/(2.h)', 'http://unitsofmeasure.org'),
(429, 'milligram per 24 hour', 'mg/(24.h)', 'http://unitsofmeasure.org'),
(430, 'milligram per 6 hour', 'mg/(6.h)', 'http://unitsofmeasure.org'),
(431, 'milligram per 72 hour', 'mg/(72.h)', 'http://unitsofmeasure.org'),
(432, 'milligram per 8 hour', 'mg/(8.h)', 'http://unitsofmeasure.org'),
(433, 'milligram per collection', 'mg/{collection}', 'http://unitsofmeasure.org'),
(434, 'milligram per cubic meter', 'mg/m3', 'http://unitsofmeasure.org'),
(435, 'milligram per day', 'mg/d', 'http://unitsofmeasure.org'),
(436, 'milligram per day per 1.73 square meter', 'mg/d/{1.73_m2}', 'http://unitsofmeasure.org'),
(437, 'milligram per deciliter', 'mg/dL', 'http://unitsofmeasure.org'),
(438, 'milligram per deciliter of red blood cells', 'mg/dL{RBCs}', 'http://unitsofmeasure.org'),
(439, 'milligram per gram', 'mg/g', 'http://unitsofmeasure.org'),
(440, 'milligram per gram of creatinine', 'mg/g{creat}', 'http://unitsofmeasure.org'),
(441, 'milligram per gram of dry tissue', 'mg/g{dry_tissue}', 'http://unitsofmeasure.org'),
(442, 'milligram per gram of feces', 'mg/g{feces}', 'http://unitsofmeasure.org'),
(443, 'milligram per gram of tissue', 'mg/g{tissue}', 'http://unitsofmeasure.org'),
(444, 'milligram per gram of wet tissue', 'mg/g{wet_tissue}', 'http://unitsofmeasure.org'),
(445, 'milligram per hour', 'mg/h', 'http://unitsofmeasure.org'),
(446, 'milligram per kilogram', 'mg/kg', 'http://unitsofmeasure.org'),
(447, 'milligram per kilogram per 8 hour', 'mg/kg/(8.h)', 'http://unitsofmeasure.org'),
(448, 'milligram per kilogram per day', 'mg/kg/d', 'http://unitsofmeasure.org'),
(449, 'milligram per kilogram per hour', 'mg/kg/h', 'http://unitsofmeasure.org'),
(450, 'milligram per kilogram per minute', 'mg/kg/min', 'http://unitsofmeasure.org'),
(451, 'milligram per liter', 'mg/L', 'http://unitsofmeasure.org'),
(452, 'milligram per liter of red blood cells', 'mg/L{RBCs}', 'http://unitsofmeasure.org'),
(453, 'milligram per milligram', 'mg/mg', 'http://unitsofmeasure.org'),
(454, 'milligram per milligram of creatinine', 'mg/mg{creat}', 'http://unitsofmeasure.org'),
(455, 'milligram per milliliter', 'mg/mL', 'http://unitsofmeasure.org'),
(456, 'milligram per millimole', 'mg/mmol', 'http://unitsofmeasure.org'),
(457, 'milligram per millimole of creatinine', 'mg/mmol{creat}', 'http://unitsofmeasure.org'),
(458, 'milligram per minute', 'mg/min', 'http://unitsofmeasure.org'),
(459, 'milligram per specimen', 'mg/{specimen}', 'http://unitsofmeasure.org'),
(460, 'milligram per square meter', 'mg/m2', 'http://unitsofmeasure.org'),
(461, 'milligram per total output', 'mg/{total_output}', 'http://unitsofmeasure.org'),
(462, 'milligram per total volume', 'mg/{total_volume}', 'http://unitsofmeasure.org'),
(463, 'milligram per week', 'mg/wk', 'http://unitsofmeasure.org'),
(464, 'milliliter', 'mL', 'http://unitsofmeasure.org'),
(465, 'milliliter of fetal red blood cells', 'mL{fetal_RBCs}', 'http://unitsofmeasure.org'),
(466, 'milliliter per 10 hour', 'mL/(10.h)', 'http://unitsofmeasure.org'),
(467, 'milliliter per 12 hour', 'mL/(12.h)', 'http://unitsofmeasure.org'),
(468, 'milliliter per 2 hour', 'mL/(2.h)', 'http://unitsofmeasure.org'),
(469, 'milliliter per 24 hour', 'mL/(24.h)', 'http://unitsofmeasure.org'),
(470, 'milliliter per 4 hour', 'mL/(4.h)', 'http://unitsofmeasure.org'),
(471, 'milliliter per 5 hour', 'mL/(5.h)', 'http://unitsofmeasure.org'),
(472, 'milliliter per 6 hour', 'mL/(6.h)', 'http://unitsofmeasure.org'),
(473, 'milliliter per 72 hour', 'mL/(72.h)', 'http://unitsofmeasure.org'),
(474, 'milliliter per 8 hour', 'mL/(8.h)', 'http://unitsofmeasure.org'),
(475, 'milliliter per 8 hour per kilogram', 'mL/(8.h)/kg', 'http://unitsofmeasure.org'),
(476, 'milliliter per centimeter of water', 'mL/cm[H2O]', 'http://unitsofmeasure.org'),
(477, 'milliliter per day', 'mL/d', 'http://unitsofmeasure.org'),
(478, 'milliliter per deciliter', 'mL/dL', 'http://unitsofmeasure.org'),
(479, 'milliliter per heart beat', 'mL/{beat}', 'http://unitsofmeasure.org'),
(480, 'milliliter per heart beat per  square meter', 'mL/{beat}/m2', 'http://unitsofmeasure.org'),
(481, 'milliliter per hour', 'mL/h', 'http://unitsofmeasure.org'),
(482, 'milliliter per kilogram', 'mL/kg', 'http://unitsofmeasure.org'),
(483, 'milliliter per kilogram per 8 hour', 'mL/kg/(8.h)', 'http://unitsofmeasure.org'),
(484, 'milliliter per kilogram per day', 'mL/kg/d', 'http://unitsofmeasure.org'),
(485, 'milliliter per kilogram per hour', 'mL/kg/h', 'http://unitsofmeasure.org'),
(486, 'milliliter per kilogram per minute', 'mL/kg/min', 'http://unitsofmeasure.org'),
(487, 'milliliter per millibar', 'mL/mbar', 'http://unitsofmeasure.org'),
(488, 'milliliter per millimeter', 'mL/mm', 'http://unitsofmeasure.org'),
(489, 'milliliter per minute', 'mL/min', 'http://unitsofmeasure.org'),
(490, 'milliliter per minute per 1.73 square meter', 'mL/min/{1.73_m2}', 'http://unitsofmeasure.org'),
(491, 'milliliter per minute per square meter', 'mL/min/m2', 'http://unitsofmeasure.org'),
(492, 'milliliter per second', 'mL/s', 'http://unitsofmeasure.org'),
(493, 'milliliter per square inch (international)', 'mL/[sin_i]', 'http://unitsofmeasure.org'),
(494, 'milliliter per square meter', 'mL/m2', 'http://unitsofmeasure.org'),
(495, 'millimeter', 'mm', 'http://unitsofmeasure.org'),
(496, 'millimeter of mercury', 'mm[Hg]', 'http://unitsofmeasure.org'),
(497, 'millimeter of water', 'mm[H2O]', 'http://unitsofmeasure.org'),
(498, 'millimeter per hour', 'mm/h', 'http://unitsofmeasure.org'),
(499, 'millimeter per minute', 'mm/min', 'http://unitsofmeasure.org'),
(500, 'millimole', 'mmol', 'http://unitsofmeasure.org'),
(501, 'millimole per 12 hour', 'mmol/(12.h)', 'http://unitsofmeasure.org'),
(502, 'millimole per 2 hour', 'mmol/(2.h)', 'http://unitsofmeasure.org'),
(503, 'millimole per 24 hour', 'mmol/(24.h)', 'http://unitsofmeasure.org'),
(504, 'millimole per 5 hour', 'mmol/(5.h)', 'http://unitsofmeasure.org'),
(505, 'millimole per 6 hour', 'mmol/(6.h)', 'http://unitsofmeasure.org'),
(506, 'millimole per 8 hour', 'mmol/(8.h)', 'http://unitsofmeasure.org'),
(507, 'millimole per day', 'mmol/d', 'http://unitsofmeasure.org'),
(508, 'millimole per deciliter', 'mmol/dL', 'http://unitsofmeasure.org'),
(509, 'millimole per ejaculate', 'mmol/{ejaculate}', 'http://unitsofmeasure.org'),
(510, 'millimole per gram', 'mmol/g', 'http://unitsofmeasure.org'),
(511, 'millimole per gram of creatinine', 'mmol/g{creat}', 'http://unitsofmeasure.org'),
(512, 'millimole per hour', 'mmol/h', 'http://unitsofmeasure.org'),
(513, 'millimole per hour per milligram of hemoglobin', 'mmol/h/mg{Hb}', 'http://unitsofmeasure.org'),
(514, 'millimole per hour per milligram of protein', 'mmol/h/mg{prot}', 'http://unitsofmeasure.org'),
(515, 'millimole per kilogram', 'mmol/kg', 'http://unitsofmeasure.org'),
(516, 'millimole per kilogram per 8 hour', 'mmol/kg/(8.h)', 'http://unitsofmeasure.org'),
(517, 'millimole per kilogram per day', 'mmol/kg/d', 'http://unitsofmeasure.org'),
(518, 'millimole per kilogram per hour', 'mmol/kg/h', 'http://unitsofmeasure.org'),
(519, 'millimole per kilogram per minute', 'mmol/kg/min', 'http://unitsofmeasure.org'),
(520, 'millimole per liter', 'mmol/L', 'http://unitsofmeasure.org'),
(521, 'millimole per liter of red blood cells', 'mmol/L{RBCs}', 'http://unitsofmeasure.org'),
(522, 'millimole per millimole', 'mmol/mmol', 'http://unitsofmeasure.org'),
(523, 'millimole per millimole of urea', 'mmol/mmol{urea}', 'http://unitsofmeasure.org'),
(524, 'millimole per millmole of creatinine', 'mmol/mmol{creat}', 'http://unitsofmeasure.org'),
(525, 'millimole per minute', 'mmol/min', 'http://unitsofmeasure.org'),
(526, 'millimole per mole', 'mmol/mol', 'http://unitsofmeasure.org'),
(527, 'millimole per mole of creatinine', 'mmol/mol{creat}', 'http://unitsofmeasure.org'),
(528, 'millimole per second per liter', 'mmol/s/L', 'http://unitsofmeasure.org'),
(529, 'millimole per specimen', 'mmol/{specimen}', 'http://unitsofmeasure.org'),
(530, 'millimole per square meter', 'mmol/m2', 'http://unitsofmeasure.org'),
(531, 'millimole per total volume', 'mmol/{total_vol}', 'http://unitsofmeasure.org'),
(532, 'million', '10*6', 'http://unitsofmeasure.org'),
(533, 'million colony forming unit per liter', '10*6.[CFU]/L', 'http://unitsofmeasure.org'),
(534, 'million international unit', '10*6.[IU]', 'http://unitsofmeasure.org'),
(535, 'million per 24 hour', '10*6/(24.h)', 'http://unitsofmeasure.org'),
(536, 'million per kilogram', '10*6/kg', 'http://unitsofmeasure.org'),
(537, 'million per liter', '10*6/L', 'http://unitsofmeasure.org'),
(538, 'million per microliter', '10*6/uL', 'http://unitsofmeasure.org'),
(539, 'million per milliliter', '10*6/mL', 'http://unitsofmeasure.org'),
(540, 'milliosmole', 'mosm', 'http://unitsofmeasure.org'),
(541, 'milliosmole per kilogram', 'mosm/kg', 'http://unitsofmeasure.org'),
(542, 'milliosmole per liter', 'mosm/L', 'http://unitsofmeasure.org'),
(543, 'millipascal', 'mPa', 'http://unitsofmeasure.org'),
(544, 'millipascal second', 'mPa.s', 'http://unitsofmeasure.org'),
(545, 'millivolt', 'mV', 'http://unitsofmeasure.org'),
(546, 'millivolt per second', 'mV/s', 'http://unitsofmeasure.org'),
(547, 'minidrop per minute', '{minidrop}/min', 'http://unitsofmeasure.org'),
(548, 'minidrop per second', '{minidrop}/s', 'http://unitsofmeasure.org'),
(549, 'minute', 'min', 'http://unitsofmeasure.org'),
(550, 'minute per day', 'min/d', 'http://unitsofmeasure.org'),
(551, 'minute per week', 'min/wk', 'http://unitsofmeasure.org'),
(552, 'mole', 'mol', 'http://unitsofmeasure.org'),
(553, 'mole per cubic meter', 'mol/m3', 'http://unitsofmeasure.org'),
(554, 'mole per kilogram', 'mol/kg', 'http://unitsofmeasure.org'),
(555, 'mole per kilogram per second', 'mol/kg/s', 'http://unitsofmeasure.org'),
(556, 'mole per liter', 'mol/L', 'http://unitsofmeasure.org'),
(557, 'mole per milliliter', 'mol/mL', 'http://unitsofmeasure.org'),
(558, 'mole per mole', 'mol/mol', 'http://unitsofmeasure.org'),
(559, 'mole per second', 'mol/s', 'http://unitsofmeasure.org'),
(560, 'molecule per platelet', '{#}/{platelet}', 'http://unitsofmeasure.org'),
(561, 'month', 'mo', 'http://unitsofmeasure.org'),
(562, 'month-day-year', '{mm/dd/yyyy}', 'http://unitsofmeasure.org'),
(563, 'multiple of the median', '{M.o.M}', 'http://unitsofmeasure.org'),
(564, 'mutation', '{mutation}', 'http://unitsofmeasure.org'),
(565, 'nanoenzyme unit per milliliter', 'nU/mL', 'http://unitsofmeasure.org'),
(566, 'nanoenzyme unit per red blood cell', 'nU/{RBC}', 'http://unitsofmeasure.org'),
(567, 'nanogram', 'ng', 'http://unitsofmeasure.org'),
(568, 'nanogram fibrinogen equivalent unit per milliliter', 'ng{FEU}/mL', 'http://unitsofmeasure.org'),
(569, 'nanogram per 24 hour', 'ng/(24.h)', 'http://unitsofmeasure.org'),
(570, 'nanogram per 8 hour', 'ng/(8.h)', 'http://unitsofmeasure.org'),
(571, 'nanogram per day', 'ng/d', 'http://unitsofmeasure.org'),
(572, 'nanogram per deciliter', 'ng/dL', 'http://unitsofmeasure.org'),
(573, 'nanogram per enzyme unit', 'ng/U', 'http://unitsofmeasure.org'),
(574, 'nanogram per gram', 'ng/g', 'http://unitsofmeasure.org'),
(575, 'nanogram per gram of creatinine', 'ng/g{creat}', 'http://unitsofmeasure.org'),
(576, 'nanogram per hour', 'ng/h', 'http://unitsofmeasure.org'),
(577, 'nanogram per kilogram', 'ng/kg', 'http://unitsofmeasure.org'),
(578, 'nanogram per kilogram per 8 hour', 'ng/kg/(8.h)', 'http://unitsofmeasure.org'),
(579, 'nanogram per kilogram per hour', 'ng/kg/h', 'http://unitsofmeasure.org'),
(580, 'nanogram per kilogram per minute', 'ng/kg/min', 'http://unitsofmeasure.org'),
(581, 'nanogram per liter', 'ng/L', 'http://unitsofmeasure.org'),
(582, 'nanogram per milligram', 'ng/mg', 'http://unitsofmeasure.org'),
(583, 'nanogram per milligram of creatinine', 'ng/mg{creat}', 'http://unitsofmeasure.org'),
(584, 'nanogram per milligram of protein', 'ng/mg{prot}', 'http://unitsofmeasure.org'),
(585, 'nanogram per milligram per hour', 'ng/mg/h', 'http://unitsofmeasure.org'),
(586, 'nanogram per milliliter of red blood cells', 'ng/mL{RBCs}', 'http://unitsofmeasure.org'),
(587, 'nanogram per milliliter per hour', 'ng/mL/h', 'http://unitsofmeasure.org'),
(588, 'nanogram per million', 'ng/10*6', 'http://unitsofmeasure.org'),
(589, 'nanogram per million red blood cells', 'ng/10*6{RBCs}', 'http://unitsofmeasure.org'),
(590, 'nanogram per millliiter', 'ng/mL', 'http://unitsofmeasure.org'),
(591, 'nanogram per minute', 'ng/min', 'http://unitsofmeasure.org'),
(592, 'nanogram per second', 'ng/s', 'http://unitsofmeasure.org'),
(593, 'nanogram per square meter', 'ng/m2', 'http://unitsofmeasure.org'),
(594, 'nanokatal', 'nkat', 'http://unitsofmeasure.org'),
(595, 'nanoliter', 'nL', 'http://unitsofmeasure.org'),
(596, 'nanometer', 'nm', 'http://unitsofmeasure.org'),
(597, 'nanometer per second per liter', 'nm/s/L', 'http://unitsofmeasure.org'),
(598, 'nanomole', 'nmol', 'http://unitsofmeasure.org'),
(599, 'nanomole bone collagen equivalent', 'nmol{BCE}', 'http://unitsofmeasure.org'),
(600, 'nanomole bone collagen equivalent per liter', 'nmol{BCE}/L', 'http://unitsofmeasure.org'),
(601, 'nanomole per millimole of creatinine', 'nmol/mmol{creat}', 'http://unitsofmeasure.org'),
(602, 'nanomole per milligram of protein', 'nmol/mg{prot}', 'http://unitsofmeasure.org'),
(603, 'nanomole of ATP', 'nmol{ATP}', 'http://unitsofmeasure.org'),
(604, 'nanomole per 24 hour', 'nmol/(24.h)', 'http://unitsofmeasure.org'),
(605, 'nanomole per day', 'nmol/d', 'http://unitsofmeasure.org'),
(606, 'nanomole per deciliter', 'nmol/dL', 'http://unitsofmeasure.org'),
(607, 'nanomole per deciliter of glomerular filtrate', 'nmol/dL{GF}', 'http://unitsofmeasure.org'),
(608, 'nanomole per gram', 'nmol/g', 'http://unitsofmeasure.org'),
(609, 'nanomole per gram of creatinine', 'nmol/g{creat}', 'http://unitsofmeasure.org'),
(610, 'nanomole per gram of dry weight', 'nmol/g{dry_wt}', 'http://unitsofmeasure.org'),
(611, 'nanomole per hour per liter', 'nmol/h/L', 'http://unitsofmeasure.org'),
(612, 'nanomole per hour per milligram of protein', 'nmol/h/mg{prot}', 'http://unitsofmeasure.org'),
(613, 'nanomole per hour per milliliter', 'nmol/h/mL', 'http://unitsofmeasure.org'),
(614, 'nanomole per liter', 'nmol/L', 'http://unitsofmeasure.org'),
(615, 'nanomole per liter of red blood cells', 'nmol/L{RBCs}', 'http://unitsofmeasure.org'),
(616, 'nanomole per liter per millimole of creatinine', 'nmol/L/mmol{creat}', 'http://unitsofmeasure.org'),
(617, 'nanomole per meter per milligram of protein', 'nmol/m/mg{prot}', 'http://unitsofmeasure.org'),
(618, 'nanomole per micromole  of creatinine', 'nmol/umol{creat}', 'http://unitsofmeasure.org'),
(619, 'nanomole per milligram', 'nmol/mg', 'http://unitsofmeasure.org'),
(620, 'nanomole per milligram of creatinine', 'nmol/mg{creat}', 'http://unitsofmeasure.org'),
(621, 'nanomole per milligram of protein per hour', 'nmol/mg{prot}/h', 'http://unitsofmeasure.org'),
(622, 'nanomole per milligram per hour', 'nmol/mg/h', 'http://unitsofmeasure.org'),
(623, 'nanomole per milliliter', 'nmol/mL', 'http://unitsofmeasure.org'),
(624, 'nanomole per milliliter per hour', 'nmol/mL/h', 'http://unitsofmeasure.org'),
(625, 'nanomole per milliliter per minute', 'nmol/mL/min', 'http://unitsofmeasure.org'),
(626, 'nanomole per millimole', 'nmol/mmol', 'http://unitsofmeasure.org'),
(627, 'nanomole per minute', 'nmol/min', 'http://unitsofmeasure.org'),
(628, 'nanomole per minute per milligram of hemoglobin', 'nmol/min/mg{Hb}', 'http://unitsofmeasure.org'),
(629, 'nanomole per minute per milligram of protein', 'nmol/min/mg{prot}', 'http://unitsofmeasure.org'),
(630, 'nanomole per minute per milligram protein', 'nmol/min/mg{protein}', 'http://unitsofmeasure.org'),
(631, 'nanomole per minute per milliliter', 'nmol/min/mL', 'http://unitsofmeasure.org'),
(632, 'nanomole per minute per million cells', 'nmol/min/10*6{cells}', 'http://unitsofmeasure.org'),
(633, 'nanomole per mole', 'nmol/mol', 'http://unitsofmeasure.org'),
(634, 'nanomole per mole creatinine', 'nmol/mol{creat}', 'http://unitsofmeasure.org'),
(635, 'nanomole per nanomole', 'nmol/nmol', 'http://unitsofmeasure.org'),
(636, 'nanomole per second', 'nmol/s', 'http://unitsofmeasure.org'),
(637, 'nanomole per second per liter', 'nmol/s/L', 'http://unitsofmeasure.org'),
(638, 'nanosecond', 'ns', 'http://unitsofmeasure.org'),
(639, 'Newton', 'N', 'http://unitsofmeasure.org'),
(640, 'Newton centimeter', 'N.cm', 'http://unitsofmeasure.org'),
(641, 'Newton second', 'N.s', 'http://unitsofmeasure.org'),
(642, 'number', '{#}', 'http://unitsofmeasure.org'),
(643, 'number per annum (year)', '{#}/a', 'http://unitsofmeasure.org'),
(644, 'number per day', '{#}/d', 'http://unitsofmeasure.org'),
(645, 'number per gram', '{#}/g', 'http://unitsofmeasure.org'),
(646, 'number per high power field', '{#}/[HPF]', 'http://unitsofmeasure.org'),
(647, 'number per liter', '{#}/L', 'http://unitsofmeasure.org'),
(648, 'number per low power field', '{#}/[LPF]', 'http://unitsofmeasure.org'),
(649, 'number per microliter', '{#}/uL', 'http://unitsofmeasure.org'),
(650, 'number per milliliter', '{#}/mL', 'http://unitsofmeasure.org'),
(651, 'number per minute', '{#}/min', 'http://unitsofmeasure.org'),
(652, 'number per week', '{#}/wk', 'http://unitsofmeasure.org'),
(653, 'Ohm', 'Ohm', 'http://unitsofmeasure.org'),
(654, 'Ohm meter', 'Ohm.m', 'http://unitsofmeasure.org'),
(655, 'one hundred thousand', '10*5', 'http://unitsofmeasure.org'),
(656, 'optical density unit', '{OD_unit}', 'http://unitsofmeasure.org'),
(657, 'osmole', 'osm', 'http://unitsofmeasure.org'),
(658, 'osmole per kilogram', 'osm/kg', 'http://unitsofmeasure.org'),
(659, 'osmole per liter', 'osm/L', 'http://unitsofmeasure.org'),
(660, 'ounce (US and British)', '[oz_av]', 'http://unitsofmeasure.org'),
(661, 'panbio unit', '{Pan_Bio\'U}', 'http://unitsofmeasure.org'),
(662, 'part per billion', '[ppb]', 'http://unitsofmeasure.org'),
(663, 'part per million', '[ppm]', 'http://unitsofmeasure.org'),
(664, 'part per million in volume per volume', '[ppm]{v/v}', 'http://unitsofmeasure.org'),
(665, 'part per thousand', '[ppth]', 'http://unitsofmeasure.org'),
(666, 'part per trillion', '[pptr]', 'http://unitsofmeasure.org'),
(667, 'picoampere', 'Pa', 'http://unitsofmeasure.org'),
(668, 'per 10 billion', '/10*10', 'http://unitsofmeasure.org'),
(669, 'per 10 thousand red blood cells', '/10*4{RBCs}', 'http://unitsofmeasure.org'),
(670, 'per 100', '/100', 'http://unitsofmeasure.org'),
(671, 'per 100 cells', '/100{cells}', 'http://unitsofmeasure.org'),
(672, 'per 100 neutrophils', '/100{neutrophils}', 'http://unitsofmeasure.org'),
(673, 'per 100 spermatozoa', '/100{spermatozoa}', 'http://unitsofmeasure.org'),
(674, 'per 100 white blood cells', '/100{WBCs}', 'http://unitsofmeasure.org'),
(675, 'per arbitrary unit', '/[arb\'U]', 'http://unitsofmeasure.org'),
(676, 'per billion', '/10*9', 'http://unitsofmeasure.org'),
(677, 'per centimeter of water', '/cm[H2O]', 'http://unitsofmeasure.org'),
(678, 'per cubic meter', '/m3', 'http://unitsofmeasure.org'),
(679, 'per day', '/d', 'http://unitsofmeasure.org'),
(680, 'per deciliter', '/dL', 'http://unitsofmeasure.org'),
(681, 'per entity', '/{entity}', 'http://unitsofmeasure.org'),
(682, 'per enzyme unit', '/U', 'http://unitsofmeasure.org'),
(683, 'per gram', '/g', 'http://unitsofmeasure.org'),
(684, 'per gram of creatinine', '/g{creat}', 'http://unitsofmeasure.org'),
(685, 'per gram of hemoglobin', '/g{Hb}', 'http://unitsofmeasure.org');
INSERT INTO `referensi_numerator` (`id_referensi_numerator`, `unit`, `code_numerator`, `system_numerator`) VALUES
(686, 'per gram of total nitrogen', '/g{tot_nit}', 'http://unitsofmeasure.org'),
(687, 'per gram of total protein', '/g{tot_prot}', 'http://unitsofmeasure.org'),
(688, 'per gram of wet tissue', '/g{wet_tis}', 'http://unitsofmeasure.org'),
(689, 'per high power field', '/[HPF]', 'http://unitsofmeasure.org'),
(690, 'per hour', '/h', 'http://unitsofmeasure.org'),
(691, 'per international unit', '/[IU]', 'http://unitsofmeasure.org'),
(692, 'per kilogram', '/kg', 'http://unitsofmeasure.org'),
(693, 'per kilogram of body weight', '/kg{body_wt}', 'http://unitsofmeasure.org'),
(694, 'per liter', '/L', 'http://unitsofmeasure.org'),
(695, 'per low power field', '/[LPF]', 'http://unitsofmeasure.org'),
(696, 'per microliter', '/uL', 'http://unitsofmeasure.org'),
(697, 'per milligram', '/mg', 'http://unitsofmeasure.org'),
(698, 'per milliliter', '/mL', 'http://unitsofmeasure.org'),
(699, 'per millimeter', '/mm', 'http://unitsofmeasure.org'),
(700, 'per millimole of creatinine', '/mmol{creat}', 'http://unitsofmeasure.org'),
(701, 'per million', '/10*6', 'http://unitsofmeasure.org'),
(702, 'per minute', '/min', 'http://unitsofmeasure.org'),
(703, 'per month', '/mo', 'http://unitsofmeasure.org'),
(704, 'per oil immersion field', '/{OIF}', 'http://unitsofmeasure.org'),
(705, 'per second', '/s', 'http://unitsofmeasure.org'),
(706, 'per square meter', '/m2', 'http://unitsofmeasure.org'),
(707, 'per thousand', '/10*3', 'http://unitsofmeasure.org'),
(708, 'per thousand red blood cells', '/10*3{RBCs}', 'http://unitsofmeasure.org'),
(709, 'per trillion', '/10*12', 'http://unitsofmeasure.org'),
(710, 'per trillion red blood cells', '/10*12{RBCs}', 'http://unitsofmeasure.org'),
(711, 'per twelve hour', '/(12.h)', 'http://unitsofmeasure.org'),
(712, 'per week', '/wk', 'http://unitsofmeasure.org'),
(713, 'per year', '/a', 'http://unitsofmeasure.org'),
(714, 'percent', '%', 'http://unitsofmeasure.org'),
(715, 'percent  loss of acetylcholine receptor', '%{loss_AChR}', 'http://unitsofmeasure.org'),
(716, 'percent  penetration', '%{penetration}', 'http://unitsofmeasure.org'),
(717, 'percent abnormal', '%{abnormal}', 'http://unitsofmeasure.org'),
(718, 'percent activity', '%{activity}', 'http://unitsofmeasure.org'),
(719, 'percent aggregation', '%{aggregation}', 'http://unitsofmeasure.org'),
(720, 'percent at 60 minute', '%{at_60_min}', 'http://unitsofmeasure.org'),
(721, 'percent basal activity', '%{basal_activity}', 'http://unitsofmeasure.org'),
(722, 'percent binding', '%{binding}', 'http://unitsofmeasure.org'),
(723, 'percent blockade', '%{blockade}', 'http://unitsofmeasure.org'),
(724, 'percent blocked', '%{blocked}', 'http://unitsofmeasure.org'),
(725, 'percent bound', '%{bound}', 'http://unitsofmeasure.org'),
(726, 'percent breakdown', '%{breakdown}', 'http://unitsofmeasure.org'),
(727, 'percent by volume', '%{vol}', 'http://unitsofmeasure.org'),
(728, 'percent deficient', '%{deficient}', 'http://unitsofmeasure.org'),
(729, 'percent dose', '%{dose}', 'http://unitsofmeasure.org'),
(730, 'percent excretion', '%{excretion}', 'http://unitsofmeasure.org'),
(731, 'percent hemoglobin', '%{Hb}', 'http://unitsofmeasure.org'),
(732, 'percent hemolysis', '%{hemolysis}', 'http://unitsofmeasure.org'),
(733, 'percent index', '%{index}', 'http://unitsofmeasure.org'),
(734, 'percent inhibition', '%{inhibition}', 'http://unitsofmeasure.org'),
(735, 'percent loss', '%{loss}', 'http://unitsofmeasure.org'),
(736, 'percent lysis', '%{lysis}', 'http://unitsofmeasure.org'),
(737, 'percent normal', '%{normal}', 'http://unitsofmeasure.org'),
(738, 'percent normal pooled plasma', '%{pooled_plasma}', 'http://unitsofmeasure.org'),
(739, 'percent of bacteria', '%{bacteria}', 'http://unitsofmeasure.org'),
(740, 'percent of baseline', '%{baseline}', 'http://unitsofmeasure.org'),
(741, 'percent of cells', '%{cells}', 'http://unitsofmeasure.org'),
(742, 'percent of red blood cells', '%{RBCs}', 'http://unitsofmeasure.org'),
(743, 'percent of white blood cells', '%{WBCs}', 'http://unitsofmeasure.org'),
(744, 'percent positive', '%{positive}', 'http://unitsofmeasure.org'),
(745, 'percent reactive', '%{reactive}', 'http://unitsofmeasure.org'),
(746, 'percent recovery', '%{recovery}', 'http://unitsofmeasure.org'),
(747, 'percent reference', '%{reference}', 'http://unitsofmeasure.org'),
(748, 'percent residual', '%{residual}', 'http://unitsofmeasure.org'),
(749, 'percent response', '%{response}', 'http://unitsofmeasure.org'),
(750, 'percent saturation', '%{saturation}', 'http://unitsofmeasure.org'),
(751, 'percent total', '%{total}', 'http://unitsofmeasure.org'),
(752, 'percent uptake', '%{uptake}', 'http://unitsofmeasure.org'),
(753, 'percent viable', '%{viable}', 'http://unitsofmeasure.org'),
(754, 'percentile', '{percentile}', 'http://unitsofmeasure.org'),
(755, 'pH', '[pH]', 'http://unitsofmeasure.org'),
(756, 'phenotype', '{phenotype}', 'http://unitsofmeasure.org'),
(757, 'picogram', 'pg', 'http://unitsofmeasure.org'),
(758, 'picogram per cell', 'pg/{cell}', 'http://unitsofmeasure.org'),
(759, 'picogram per deciliter', 'pg/dL', 'http://unitsofmeasure.org'),
(760, 'picogram per liter', 'pg/L', 'http://unitsofmeasure.org'),
(761, 'picogram per milligram', 'pg/mg', 'http://unitsofmeasure.org'),
(762, 'picogram per milligram of creatinine', 'pg/mg{creat}', 'http://unitsofmeasure.org'),
(763, 'picogram per milliliter', 'pg/mL', 'http://unitsofmeasure.org'),
(764, 'picogram per milliliter sulfidoleukotrienes', 'pg/mL{sLT}', 'http://unitsofmeasure.org'),
(765, 'picogram per millimeter', 'pg/mm', 'http://unitsofmeasure.org'),
(766, 'picogram per red blood cell', 'pg/{RBC}', 'http://unitsofmeasure.org'),
(767, 'picokatal', 'pkat', 'http://unitsofmeasure.org'),
(768, 'picoliter', 'pL', 'http://unitsofmeasure.org'),
(769, 'picometer', 'pm', 'http://unitsofmeasure.org'),
(770, 'picomole', 'pmol', 'http://unitsofmeasure.org'),
(771, 'picomole per 24 hour', 'pmol/(24.h)', 'http://unitsofmeasure.org'),
(772, 'picomole per day', 'pmol/d', 'http://unitsofmeasure.org'),
(773, 'picomole per deciliter', 'pmol/dL', 'http://unitsofmeasure.org'),
(774, 'picomole per gram', 'pmol/g', 'http://unitsofmeasure.org'),
(775, 'picomole per hour per milligram of protein', 'pmol/h/mg{prot}', 'http://unitsofmeasure.org'),
(776, 'picomole per hour per milligram protein', 'pmol/H/mg{protein}', 'http://unitsofmeasure.org'),
(777, 'picomole per hour per milliliter', 'pmol/h/mL', 'http://unitsofmeasure.org'),
(778, 'picomole per liter', 'pmol/L', 'http://unitsofmeasure.org'),
(779, 'picomole per micromole', 'pmol/umol', 'http://unitsofmeasure.org'),
(780, 'picomole per micromole of creatinine', 'pmol/umol{creat}', 'http://unitsofmeasure.org'),
(781, 'picomole per milligram of protein', 'pmol/mg{prot}', 'http://unitsofmeasure.org'),
(782, 'picomole per milliliter', 'pmol/mL', 'http://unitsofmeasure.org'),
(783, 'picomole per millimole of creatinine', 'pmol/mmol{creat}', 'http://unitsofmeasure.org'),
(784, 'picomole per minute', 'pmol/min', 'http://unitsofmeasure.org'),
(785, 'picomole per minute per milligram of protein', 'pmol/min/mg{prot}', 'http://unitsofmeasure.org'),
(786, 'picomole per red blood cell', 'pmol/{RBC}', 'http://unitsofmeasure.org'),
(787, 'picosecond', 'ps', 'http://unitsofmeasure.org'),
(788, 'picotesla', 'pT', 'http://unitsofmeasure.org'),
(789, 'pint (US)', '[pt_us]', 'http://unitsofmeasure.org'),
(790, 'pound (US and British)', '[lb_av]', 'http://unitsofmeasure.org'),
(791, 'pound per square inch', '[psi]', 'http://unitsofmeasure.org'),
(792, 'quart (US)', '[qt_us]', 'http://unitsofmeasure.org'),
(793, 'ratio', '{ratio}', 'http://unitsofmeasure.org'),
(794, 'red blood cell per microliter', '{RBC}/uL', 'http://unitsofmeasure.org'),
(795, 'relative percent', '%{relative}', 'http://unitsofmeasure.org'),
(796, 'relative saturation', '{rel_saturation}', 'http://unitsofmeasure.org'),
(797, 'risk', '{risk}', 'http://unitsofmeasure.org'),
(798, 'rubella virus', '{Rubella_virus}', 'http://unitsofmeasure.org'),
(799, 'saturation', '{saturation}', 'http://unitsofmeasure.org'),
(800, 'score', '{score}', 'http://unitsofmeasure.org'),
(801, 'Siemens', 's', 'http://unitsofmeasure.org'),
(802, 'second per control', 's/{control}', 'http://unitsofmeasure.org'),
(803, 'shift', '{shift}', 'http://unitsofmeasure.org'),
(804, 'Sievert', 'Sv', 'http://unitsofmeasure.org'),
(805, 'signal to cutoff ratio', '{s_co_ratio}', 'http://unitsofmeasure.org'),
(806, 'spermatozoa per milliliter', '{spermatozoa}/mL', 'http://unitsofmeasure.org'),
(807, 'square centimeter', 'cm2', 'http://unitsofmeasure.org'),
(808, 'square centimeter per second', 'cm2/s', 'http://unitsofmeasure.org'),
(809, 'square decimeter per square second', 'dm2/s2', 'http://unitsofmeasure.org'),
(810, 'square foot (international)', '[sft_i]', 'http://unitsofmeasure.org'),
(811, 'square inch (international)', '[sin_i]', 'http://unitsofmeasure.org'),
(812, 'square meter', 'm2', 'http://unitsofmeasure.org'),
(813, 'square meter per second', 'm2/s', 'http://unitsofmeasure.org'),
(814, 'square millimeter', 'mm2', 'http://unitsofmeasure.org'),
(815, 'square yard (international)', '[syd_i]', 'http://unitsofmeasure.org'),
(816, 'standard deviation', '{STDV}', 'http://unitsofmeasure.org'),
(817, 't score', '{Tscore}', 'http://unitsofmeasure.org'),
(818, 'tablespoon (US)', '[tbs_us]', 'http://unitsofmeasure.org'),
(819, 'teaspoon (US)', '[tsp_us]', 'http://unitsofmeasure.org'),
(820, 'thousand', '10*3', 'http://unitsofmeasure.org'),
(821, 'thousand copies per milliliter', '10*3{copies}/mL', 'http://unitsofmeasure.org'),
(822, 'thousand per liter', '10*3/L', 'http://unitsofmeasure.org'),
(823, 'thousand per microliter', '10*3/uL', 'http://unitsofmeasure.org'),
(824, 'thousand per milliliter', '10*3/mL', 'http://unitsofmeasure.org'),
(825, 'thousand red blood cells', '10*3{RBCs}', 'http://unitsofmeasure.org'),
(826, 'thyroid-stimulating immunoglobulin index', '{TSI_index}', 'http://unitsofmeasure.org'),
(827, 'time stamp', '{TmStp}', 'http://unitsofmeasure.org'),
(828, 'titer', '{titer}', 'http://unitsofmeasure.org'),
(829, 'Todd unit', '[todd\'U]', 'http://unitsofmeasure.org'),
(830, 'Torr', 'Torr', 'http://unitsofmeasure.org'),
(831, 'trillion per liter', '10*12/L', 'http://unitsofmeasure.org'),
(832, 'Troy ounce', '[oz_tr]', 'http://unitsofmeasure.org'),
(833, 'tuberculin unit', '[tb\'U]', 'http://unitsofmeasure.org'),
(834, 'volt', 'V', 'http://unitsofmeasure.org'),
(835, 'Weber', 'Wb', 'http://unitsofmeasure.org'),
(836, 'week', 'wk', 'http://unitsofmeasure.org'),
(837, 'white blood cells', '{WBCs}', 'http://unitsofmeasure.org'),
(838, 'yard (international)', '[yd_i]', 'http://unitsofmeasure.org'),
(839, 'year', '{yyyy}', 'http://unitsofmeasure.org'),
(840, 'z score', '{Zscore}', 'http://unitsofmeasure.org'),
(841, 'milliCurie', 'mCi', 'http://unitsofmeasure.org');

-- --------------------------------------------------------

--
-- Table structure for table `referensi_satuan_dosis`
--

DROP TABLE IF EXISTS `referensi_satuan_dosis`;
CREATE TABLE IF NOT EXISTS `referensi_satuan_dosis` (
  `id_referensi_satuan_dosis` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_satuan_dosis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Bahas indonesia / Yang Ditampilkan',
  `unit_satuan_dosis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Nama sesuai FHIR',
  `code_satuan_dosis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Kode sesuai FHIR',
  `system_satuan_dosis` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci COMMENT 'Sistem yang digunakan',
  PRIMARY KEY (`id_referensi_satuan_dosis`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Referensi satuan untuk dosis resep';

--
-- Dumping data for table `referensi_satuan_dosis`
--

INSERT INTO `referensi_satuan_dosis` (`id_referensi_satuan_dosis`, `nama_satuan_dosis`, `unit_satuan_dosis`, `code_satuan_dosis`, `system_satuan_dosis`) VALUES
(1, 'Sendok Makan', 'tablespoon', 'tbsp', 'http://unitsofmeasure.org'),
(2, 'Sendok Teh', 'teaspoon', 'tsp', 'http://unitsofmeasure.org'),
(3, 'Tablet', 'TAB', 'Tablet', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm'),
(4, 'Oral Tablet', 'ORTAB', 'Oral Tablet', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm'),
(5, 'Kaplet', 'Caplet', 'CAPLET', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm'),
(6, 'Chewable Tablet', 'CHEWTAB', 'Chewable Tablet', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm'),
(7, 'Capsule', 'CAP', 'Capsule', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm'),
(8, 'Oral Capsule', 'ORCAP', 'Oral Capsule', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm'),
(9, 'Extended-Release Capsule', 'ERCAP', 'Extended Release Capsule', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm'),
(10, 'Suppository', 'SUPP', 'Suppository', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm'),
(11, 'Drops', 'DROP', 'Drops', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm'),
(12, 'Puff (Inhalasi)', 'PUFF', 'Puff', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm'),
(13, 'Sprays', 'SPRY', 'Sprays', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm'),
(14, 'Powder', 'POWD', 'Powder', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm'),
(15, 'Oral Suspension', 'ORSUSP', 'Oral Suspension', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm'),
(16, 'Syrup', 'SYRUP', 'Syrup', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm'),
(17, 'Elixir', 'ELIXIR', 'Elixir', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm'),
(18, 'Oral Drops', 'ORDROP', 'Oral Drops', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm'),
(19, 'Nasal Drops', 'NDROP', 'Nasal Drops', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm'),
(20, 'Ophthalmic Drops', 'OPDROP', 'Ophthalmic Drops', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm'),
(21, 'Otic Drops', 'OTDROP', 'Otic Drops', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm'),
(22, 'Liniment', 'LIN', 'Liniment', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm'),
(23, 'Tablet', 'Tablet', 'TAB', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm'),
(24, 'Kapsul', 'Capsule', 'CAP', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm'),
(25, 'Sirup', 'Oral Solution', 'SOL', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm'),
(26, 'Suspensi', 'Suspension', 'SUSP', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm'),
(27, 'Tetes', 'Drops', 'DROP', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm'),
(28, 'Salep', 'Ointment', 'OINT', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm'),
(29, 'Krim', 'Cream', 'CRM', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm'),
(30, 'Injeksi', 'Injection', 'INJ', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm'),
(31, 'Infus', 'Infusion', 'IV', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm'),
(32, 'Suppositoria', 'Suppository', 'SUPP', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm'),
(33, 'Inhaler', 'Metered Dose Inhaler', 'MDI', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm'),
(34, 'Spray', 'Spray', 'SPRAY', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm'),
(35, 'Patch', 'Transdermal Patch', 'PATCH', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm'),
(36, 'Ampul', 'Ampoule', 'AMP', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm'),
(37, 'Vial', 'Vial', 'VIAL', 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm');

-- --------------------------------------------------------

--
-- Table structure for table `referensi_sediaan`
--

DROP TABLE IF EXISTS `referensi_sediaan`;
CREATE TABLE IF NOT EXISTS `referensi_sediaan` (
  `id_referensi_sediaan` int NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `display` varchar(255) NOT NULL,
  `system_referensi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `category` varchar(255) NOT NULL,
  `group_name` enum('Alkes','Obat') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Alkes, Obat',
  PRIMARY KEY (`id_referensi_sediaan`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `referensi_sediaan`
--

INSERT INTO `referensi_sediaan` (`id_referensi_sediaan`, `code`, `display`, `system_referensi`, `category`, `group_name`) VALUES
(1, 'BS001', 'Aerosol Foam', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Inhalasi', 'Obat'),
(2, 'BS002', 'Aerosol Metered Dose', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Aerosol', 'Obat'),
(3, 'BS003', 'Aerosol Spray', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Aerosol', 'Obat'),
(4, 'BS004', 'Oral Spray', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Spray', 'Obat'),
(6, 'DRS-STD', 'Dressing Standar', 'https://rs-elsyifa.co.id/codesystem/alkes-form', 'Dressing & Luka', 'Alkes'),
(7, 'FOAM-SAC', 'Foam Dressing Sacrum', 'https://rs-elsyifa.co.id/codesystem/alkes-form', 'Dressing & Luka', 'Alkes'),
(8, 'FOAM-STD', 'Foam Dressing', 'https://rs-elsyifa.co.id/codesystem/alkes-form', 'Dressing & Luka', 'Alkes'),
(9, 'GAU-ROL', 'Kasa Roll', 'https://rs-elsyifa.co.id/codesystem/alkes-form', 'Dressing & Luka', 'Alkes'),
(10, 'GAU-PAD', 'Kasa Pad', 'https://rs-elsyifa.co.id/codesystem/alkes-form', 'Dressing & Luka', 'Alkes'),
(11, 'BDG-ROL', 'Bandage Roll', 'https://rs-elsyifa.co.id/codesystem/alkes-form', 'Dressing & Luka', 'Alkes'),
(12, 'PLS-STR', 'Plester Steril', 'https://rs-elsyifa.co.id/codesystem/alkes-form', 'Dressing & Luka', 'Alkes'),
(13, 'SYR-DIS', 'Syringe Disposable', 'https://rs-elsyifa.co.id/codesystem/alkes-form', 'Injeksi & Infus', 'Alkes'),
(14, 'SYR-USE', 'Syringe Sekali Pakai', 'https://rs-elsyifa.co.id/codesystem/alkes-form', 'Injeksi & Infus', 'Alkes'),
(15, 'INF-SET', 'Infusion Set', 'https://rs-elsyifa.co.id/codesystem/alkes-form', 'Injeksi & Infus', 'Alkes'),
(16, 'INF-MAC', 'Infusion Set Macro', 'https://rs-elsyifa.co.id/codesystem/alkes-form', 'Injeksi & Infus', 'Alkes'),
(17, 'INF-MIC', 'Infusion Set Micro', 'https://rs-elsyifa.co.id/codesystem/alkes-form', 'Injeksi & Infus', 'Alkes'),
(18, 'NEB-SET', 'Nebulizer Set', 'https://rs-elsyifa.co.id/codesystem/alkes-form', 'Respirasi', 'Alkes'),
(19, 'MSK-OXY', 'Masker Oksigen', 'https://rs-elsyifa.co.id/codesystem/alkes-form', 'Respirasi', 'Alkes'),
(20, 'MSK-NRM', 'Masker Non Rebreathing', 'https://rs-elsyifa.co.id/codesystem/alkes-form', 'Respirasi', 'Alkes'),
(21, 'GLO-STR', 'Sarung Tangan Steril', 'https://rs-elsyifa.co.id/codesystem/alkes-form', 'APD', 'Alkes'),
(22, 'GLO-NON', 'Sarung Tangan Non Steril', 'https://rs-elsyifa.co.id/codesystem/alkes-form', 'APD', 'Alkes'),
(23, 'MSK-SRG', 'Masker Bedah', 'https://rs-elsyifa.co.id/codesystem/alkes-form', 'APD', 'Alkes'),
(24, 'MSK-N95', 'Masker N95', 'https://rs-elsyifa.co.id/codesystem/alkes-form', 'APD', 'Alkes'),
(25, 'CAT-FOL', 'Catheter Foley', 'https://rs-elsyifa.co.id/codesystem/alkes-form', 'Alat Umum', 'Alkes'),
(26, 'TUB-SUC', 'Suction Tube', 'https://rs-elsyifa.co.id/codesystem/alkes-form', 'Alat Umum', 'Alkes'),
(27, 'DEV-MED', 'Medical Device Umum', 'https://rs-elsyifa.co.id/codesystem/alkes-form', 'Alat Umum', 'Alkes'),
(28, 'BS019', 'Kapsul', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Oral Padat', 'Obat'),
(29, 'BS020', 'Kapsul Lunak', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Oral Padat', 'Obat'),
(30, 'BS022', 'Kaplet', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Oral Padat', 'Obat'),
(31, 'BS066', 'Tablet', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Oral Padat', 'Obat'),
(32, 'BS068', 'Tablet Hisap', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Oral Padat', 'Obat'),
(33, 'BS069', 'Tablet Kunyah', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Oral Padat', 'Obat'),
(34, 'BS071', 'Tablet Lepas Lambat', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Oral Padat', 'Obat'),
(35, 'BS073', 'Tablet Dispersibel', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Oral Padat', 'Obat'),
(36, 'BS078', 'Tablet Sublingual', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Oral Padat', 'Obat'),
(37, 'BS055', 'Sirup', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Oral Cair', 'Obat'),
(38, 'BS056', 'Sirup Kering', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Oral Cair', 'Obat'),
(39, 'BS060', 'Suspensi', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Oral Cair', 'Obat'),
(40, 'BS087', 'Tetes Oral', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Oral Cair', 'Obat'),
(41, 'BS030', 'Krim', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Topikal', 'Obat'),
(42, 'BS042', 'Salep', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Topikal', 'Obat'),
(43, 'BS038', 'Pasta', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Topikal', 'Obat'),
(44, 'BS091', 'Tulle / Plester Obat', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Topikal', 'Obat'),
(45, 'BS034', 'Larutan Injeksi', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Parenteral', 'Obat'),
(46, 'BS035', 'Infus', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Parenteral', 'Obat'),
(47, 'BS049', 'Serbuk Injeksi', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Parenteral', 'Obat'),
(48, 'BS050', 'Serbuk Injeksi Liofilisasi', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Parenteral', 'Obat'),
(49, 'BS033', 'Larutan Inhalasi', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Inhalasi', 'Obat'),
(50, 'BS048', 'Serbuk Inhaler', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Inhalasi', 'Obat'),
(51, 'BS084', 'Tetes Mata', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Okular', 'Obat'),
(52, 'BS086', 'Tetes Telinga', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Otik', 'Obat'),
(53, 'BS085', 'Tetes Hidung', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Nasal', 'Obat'),
(54, 'BS059', 'Supositoria', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Rektal', 'Obat'),
(55, 'BS092', 'Vaginal Cream', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Vaginal', 'Obat'),
(56, 'BS095', 'Vaginal Ring', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Vaginal', 'Obat'),
(57, 'BS018', 'Implant', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Implant', 'Obat'),
(58, 'BS058', 'Subdermal Implant', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Implant', 'Obat'),
(59, 'MF000001', 'Cairan Obat Luar', 'https://terminology.kemkes.go.id/CodeSystem/medication-form', 'Cairan Luar', 'Obat');

-- --------------------------------------------------------

--
-- Table structure for table `setting_email_gateway`
--

DROP TABLE IF EXISTS `setting_email_gateway`;
CREATE TABLE IF NOT EXISTS `setting_email_gateway` (
  `id_setting_email_gateway` int NOT NULL AUTO_INCREMENT,
  `email_gateway` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `password_gateway` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `url_provider` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `port_gateway` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `nama_pengirim` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `url_service` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `validasi_email` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `redirect_validasi` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `pesan_validasi_email` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id_setting_email_gateway`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `access`
--
ALTER TABLE `access`
  ADD CONSTRAINT `access_to_group` FOREIGN KEY (`id_access_group`) REFERENCES `access_group` (`id_access_group`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `access_log`
--
ALTER TABLE `access_log`
  ADD CONSTRAINT `log_to_access` FOREIGN KEY (`id_access`) REFERENCES `access` (`id_access`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `access_login`
--
ALTER TABLE `access_login`
  ADD CONSTRAINT `login_to_access` FOREIGN KEY (`id_access`) REFERENCES `access` (`id_access`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `access_permission`
--
ALTER TABLE `access_permission`
  ADD CONSTRAINT `permission_to_access` FOREIGN KEY (`id_access`) REFERENCES `access` (`id_access`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_to_features` FOREIGN KEY (`id_access_feature`) REFERENCES `access_feature` (`id_access_feature`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `access_reference`
--
ALTER TABLE `access_reference`
  ADD CONSTRAINT `referenc_to_features` FOREIGN KEY (`id_access_feature`) REFERENCES `access_feature` (`id_access_feature`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reference_to_group` FOREIGN KEY (`id_access_group`) REFERENCES `access_group` (`id_access_group`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `access_reset`
--
ALTER TABLE `access_reset`
  ADD CONSTRAINT `reset_to_access` FOREIGN KEY (`id_access`) REFERENCES `access` (`id_access`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `api_token`
--
ALTER TABLE `api_token`
  ADD CONSTRAINT `token_to_api` FOREIGN KEY (`id_api_account`) REFERENCES `api_account` (`id_api_account`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `medication_request`
--
ALTER TABLE `medication_request`
  ADD CONSTRAINT `medication_request_to_group` FOREIGN KEY (`id_medication_request_group`) REFERENCES `medication_request_group` (`id_medication_request_group`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
