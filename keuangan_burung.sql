-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 09, 2025 at 08:04 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `keuangan_burung`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `venue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `saldo_awal` bigint NOT NULL DEFAULT '0',
  `total_tiket` bigint UNSIGNED NOT NULL DEFAULT '0',
  `total_hadiah` bigint UNSIGNED NOT NULL DEFAULT '0',
  `total_operasional` bigint UNSIGNED NOT NULL DEFAULT '0',
  `saldo_akhir` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `tanggal`, `venue`, `saldo_awal`, `total_tiket`, `total_hadiah`, `total_operasional`, `saldo_akhir`, `created_at`, `updated_at`) VALUES
(1, '2025-09-07', 'Colomadu', 0, 33430000, 22120000, 13331000, -4671000, '2025-09-06 21:35:02', '2025-10-05 00:31:15'),
(2, '2025-09-16', 'dddd', -2021000, 600000, 460000, 0, -1881000, '2025-09-16 03:06:02', '2025-09-16 03:35:09'),
(4, '2025-10-05', 'Gawanan', 0, 19840000, 14300000, 2400000, 1360000, '2025-10-05 04:47:01', '2025-10-05 05:49:31');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kelas_lombas`
--

CREATE TABLE `kelas_lombas` (
  `id` bigint UNSIGNED NOT NULL,
  `event_id` bigint UNSIGNED NOT NULL,
  `nama_kelas` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_tiket` int UNSIGNED NOT NULL,
  `jumlah_peserta` int UNSIGNED NOT NULL,
  `total_tiket` bigint UNSIGNED NOT NULL,
  `hadiah_1` bigint NOT NULL DEFAULT '0',
  `hadiah_2` bigint NOT NULL DEFAULT '0',
  `hadiah_3` bigint NOT NULL DEFAULT '0',
  `hadiah_4` bigint NOT NULL DEFAULT '0',
  `hadiah_5` bigint NOT NULL DEFAULT '0',
  `hadiah_6` bigint NOT NULL DEFAULT '0',
  `hadiah_7` bigint NOT NULL DEFAULT '0',
  `hadiah_8` bigint NOT NULL,
  `hadiah_9` bigint NOT NULL,
  `hadiah_10` bigint NOT NULL,
  `total_hadiah` bigint NOT NULL DEFAULT '0',
  `hadiah` bigint UNSIGNED NOT NULL DEFAULT '0',
  `jumlah_piala` int UNSIGNED NOT NULL DEFAULT '0',
  `sisa_piala` int UNSIGNED NOT NULL DEFAULT '0',
  `sisa_tiket` bigint NOT NULL DEFAULT '0',
  `laba_bersih` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kelas_lombas`
--

INSERT INTO `kelas_lombas` (`id`, `event_id`, `nama_kelas`, `harga_tiket`, `jumlah_peserta`, `total_tiket`, `hadiah_1`, `hadiah_2`, `hadiah_3`, `hadiah_4`, `hadiah_5`, `hadiah_6`, `hadiah_7`, `hadiah_8`, `hadiah_9`, `hadiah_10`, `total_hadiah`, `hadiah`, `jumlah_piala`, `sisa_piala`, `sisa_tiket`, `laba_bersih`, `created_at`, `updated_at`) VALUES
(2, 1, 'MURAI BATU SAHABAT SAP-', 110000, 30, 3300000, 1000000, 600000, 300000, 170000, 150000, 110000, 0, 0, 0, 0, 2330000, 0, 200000, 0, 0, 770000, '2025-09-10 00:34:54', '2025-09-21 21:34:52'),
(3, 1, 'CUCAK HIAJU COLOMADU', 55000, 19, 1045000, 200000, 125000, 70000, 55000, 0, 0, 0, 0, 0, 0, 450000, 0, 200000, 0, 0, 395000, '2025-09-10 00:37:01', '2025-09-21 21:35:03'),
(4, 1, 'MURAI REMAJA AIR AJAIB', 110000, 13, 1430000, 350000, 180000, 110000, 0, 0, 0, 0, 0, 0, 0, 640000, 0, 200000, 0, 0, 590000, '2025-09-10 00:38:03', '2025-09-21 21:35:18'),
(5, 1, 'MURAI BATU AKP', 220000, 24, 5280000, 1500000, 800000, 550000, 350000, 220000, 0, 0, 0, 0, 0, 3420000, 0, 200000, 0, 0, 1660000, '2025-09-10 00:41:27', '2025-09-21 21:35:25'),
(6, 1, 'CUCAK HIAJU SEMAR', 110000, 16, 1760000, 600000, 350000, 200000, 110000, 0, 0, 0, 0, 0, 0, 1260000, 0, 200000, 0, 0, 300000, '2025-09-10 00:43:09', '2025-09-21 21:35:32'),
(7, 1, 'MURAI REMAJA ABDI DALEM', 220000, 12, 2640000, 800000, 400000, 0, 0, 0, 0, 0, 0, 0, 0, 1200000, 0, 150000, 0, 0, 1290000, '2025-09-10 00:44:29', '2025-09-21 21:35:42'),
(8, 1, 'MURAI BATU HALAL BI HALAL', 350000, 16, 5600000, 4000000, 1000000, 600000, 0, 0, 0, 0, 0, 0, 0, 5600000, 0, 50000, 0, 0, -50000, '2025-09-10 00:46:57', '2025-10-05 00:31:15'),
(9, 1, 'CUCAK HIJAU MANDRO SF', 85000, 24, 2040000, 600000, 350000, 200000, 100000, 85000, 0, 0, 0, 0, 0, 1335000, 0, 200000, 0, 0, 505000, '2025-09-10 00:49:08', '2025-09-21 21:35:55'),
(10, 1, 'MURAI REMAJA FAGAS', 85000, 16, 1360000, 300000, 160000, 120000, 0, 0, 0, 0, 0, 0, 0, 580000, 0, 200000, 0, 0, 580000, '2025-09-10 00:49:58', '2025-09-21 21:36:01'),
(11, 1, 'MURAI BATU MODAL NEKAT', 110000, 24, 2640000, 700000, 500000, 300000, 150000, 110000, 0, 0, 0, 0, 0, 1760000, 0, 200000, 0, 0, 680000, '2025-09-10 00:50:39', '2025-09-21 21:36:07'),
(12, 1, 'CUCAK HIJAU B COLOMADU', 55000, 16, 880000, 180000, 110000, 65000, 0, 0, 0, 0, 0, 0, 0, 355000, 0, 200000, 0, 0, 325000, '2025-09-10 00:51:35', '2025-09-21 21:36:15'),
(13, 1, 'MURAI REMAJA KHOLIQ CAR', 55000, 8, 440000, 125000, 55000, 0, 0, 0, 0, 0, 0, 0, 0, 180000, 0, 100000, 0, 0, 160000, '2025-09-10 00:52:11', '2025-10-04 23:49:57'),
(14, 1, 'MURAI BATU FAGAS', 85000, 15, 1275000, 250000, 150000, 100000, 0, 0, 0, 0, 0, 0, 0, 500000, 0, 200000, 0, 0, 575000, '2025-09-10 00:52:44', '2025-09-21 21:36:21'),
(15, 1, 'MB DEWASA TAMBAHAN', 55000, 8, 440000, 125000, 55000, 0, 0, 0, 0, 0, 0, 0, 0, 180000, 0, 150000, 0, 0, 110000, '2025-09-10 00:53:12', '2025-09-21 21:36:27'),
(16, 1, 'MURAI BATU SAHABAT SAP-', 110000, 30, 3300000, 1000000, 600000, 300000, 170000, 150000, 110000, 0, 0, 0, 0, 2330000, 0, 200000, 0, 0, 770000, '2025-09-10 20:14:29', '2025-09-21 21:36:32'),
(17, 2, 'murai batu losgan', 15000, 24, 360000, 100000, 60000, 50000, 30000, 20000, 0, 0, 0, 0, 0, 260000, 0, 5, 0, 0, 100000, '2025-09-16 03:08:59', '2025-09-16 03:08:59'),
(18, 2, 'fdddu', 20000, 12, 240000, 200000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 200000, 0, 2, 0, 0, 40000, '2025-09-16 03:35:09', '2025-09-16 03:35:09'),
(19, 4, 'mb dewasa ginastel', 220000, 24, 5280000, 2000000, 1000000, 500000, 350000, 250000, 0, 0, 0, 0, 0, 4100000, 0, 220000, 0, 0, 960000, '2025-10-05 04:49:49', '2025-10-05 04:49:49'),
(20, 4, 'mb dewasa bulldog', 350000, 24, 8400000, 3000000, 1500000, 800000, 500000, 350000, 0, 0, 0, 0, 0, 6150000, 0, 350000, 0, 0, 1900000, '2025-10-05 04:52:00', '2025-10-05 04:52:00'),
(21, 4, 'mb remaja', 110000, 24, 2640000, 1000000, 500000, 250000, 160000, 110000, 0, 0, 0, 0, 0, 2020000, 0, 1100000, 0, 0, -480000, '2025-10-05 05:43:29', '2025-10-05 05:43:29'),
(22, 4, 'mb dewasa arena', 110000, 32, 3520000, 1000000, 500000, 200000, 110000, 110000, 110000, 0, 0, 0, 0, 2030000, 0, 110000, 0, 0, 1380000, '2025-10-05 05:45:25', '2025-10-05 05:45:25');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('abeejiaa@gmail.com', '$2y$12$aG5YxzmeMbdTAKJakEjHC.7rfy47F4z/fRSIRvlS4KqmwwIZo0nPS', '2025-10-06 08:03:23'),
('della@gmail.com', '$2y$12$Eyz9h0tsPg0CGuMejJ0js.GVbfYkPHnAOpZEuG88nKwLjughifUCq', '2025-10-06 08:02:17');

-- --------------------------------------------------------

--
-- Table structure for table `pengeluarans`
--

CREATE TABLE `pengeluarans` (
  `id` bigint UNSIGNED NOT NULL,
  `event_id` bigint UNSIGNED NOT NULL,
  `uraian` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengeluarans`
--

INSERT INTO `pengeluarans` (`id`, `event_id`, `uraian`, `jumlah`, `created_at`, `updated_at`) VALUES
(1, 1, 'Juri 1', 400000, '2025-09-10 00:55:59', '2025-09-10 00:55:59'),
(2, 1, 'Juri 2', 300000, '2025-09-10 00:56:12', '2025-09-10 00:56:12'),
(3, 1, 'Juri 3', 300000, '2025-09-10 00:56:24', '2025-09-10 00:56:24'),
(4, 1, 'Juri 4', 300000, '2025-09-10 00:56:36', '2025-09-10 00:56:36'),
(5, 1, 'Juri 5', 300000, '2025-09-10 00:56:49', '2025-09-10 00:56:49'),
(6, 1, 'Juri 6', 300000, '2025-09-10 00:57:01', '2025-09-10 00:57:01'),
(7, 1, 'Juri 7', 300000, '2025-09-10 00:57:11', '2025-09-10 00:57:11'),
(8, 1, 'Juri 8', 300000, '2025-09-10 00:57:23', '2025-09-10 00:57:23'),
(9, 1, 'Juri 9', 300000, '2025-09-10 00:58:09', '2025-09-10 00:58:09'),
(10, 1, 'Admin 1', 150000, '2025-09-10 00:58:20', '2025-09-10 00:58:20'),
(11, 1, 'Admin 2', 150000, '2025-09-10 00:58:29', '2025-09-10 00:58:29'),
(12, 1, 'Admin 3', 150000, '2025-09-10 00:58:39', '2025-09-10 00:58:39'),
(13, 1, 'Admin 4', 150000, '2025-09-10 00:58:51', '2025-09-10 00:58:51'),
(14, 1, 'Admin 5 (JERY)', 200000, '2025-09-10 00:59:06', '2025-09-10 20:25:07'),
(15, 1, 'Piala', 2875000, '2025-09-10 00:59:18', '2025-09-10 00:59:18'),
(16, 1, 'Security', 300000, '2025-09-10 00:59:29', '2025-09-10 00:59:29'),
(17, 1, 'Konsumsi', 600000, '2025-09-10 00:59:41', '2025-09-10 00:59:41'),
(18, 1, 'ATK', 200000, '2025-09-10 01:03:51', '2025-09-10 01:03:51'),
(19, 1, 'Lain-Lain', 200000, '2025-09-10 01:04:18', '2025-09-10 01:04:18'),
(20, 1, 'Spanduk', 486000, '2025-09-10 01:04:35', '2025-09-10 01:04:35'),
(21, 1, 'Jangkrik', 15000, '2025-09-10 01:05:03', '2025-09-10 01:05:03'),
(22, 1, 'Kondisional', 150000, '2025-09-10 01:05:26', '2025-09-10 01:05:26'),
(23, 1, 'Panpel', 750000, '2025-09-10 01:05:39', '2025-09-10 01:05:39'),
(24, 1, 'MC', 300000, '2025-09-10 01:05:50', '2025-09-10 01:05:50'),
(25, 1, 'Tulis', 200000, '2025-09-10 01:06:04', '2025-09-10 01:06:04'),
(26, 1, 'Sound', 250000, '2025-09-10 01:06:17', '2025-09-10 01:06:17'),
(27, 1, 'Jamtrok', 200000, '2025-09-10 01:06:41', '2025-09-10 01:06:41'),
(28, 1, 'Listrik & Kursi', 150000, '2025-09-10 01:06:55', '2025-09-10 01:06:55'),
(29, 1, 'Piagam & Tiket', 700000, '2025-09-10 01:07:17', '2025-09-10 01:07:17'),
(30, 1, 'Media', 350000, '2025-09-10 01:07:31', '2025-09-10 01:07:31'),
(31, 1, 'Free', 1705000, '2025-09-10 01:07:43', '2025-09-10 01:07:43'),
(32, 1, 'Gantangan', 300000, '2025-09-10 01:07:54', '2025-09-10 01:07:54'),
(33, 4, 'Juri 1', 200000, '2025-10-05 05:46:22', '2025-10-05 05:46:22'),
(34, 4, 'Juri 2', 200000, '2025-10-05 05:46:46', '2025-10-05 05:46:46'),
(35, 4, 'Juri 3', 200000, '2025-10-05 05:47:08', '2025-10-05 05:47:08'),
(36, 4, 'Juri 4', 200000, '2025-10-05 05:47:31', '2025-10-05 05:47:31'),
(37, 4, 'Juri 5', 200000, '2025-10-05 05:47:53', '2025-10-05 05:47:53'),
(38, 4, 'Admin 1', 500000, '2025-10-05 05:48:30', '2025-10-05 05:48:30'),
(39, 4, 'Konsumsi', 400000, '2025-10-05 05:49:00', '2025-10-05 05:49:00'),
(40, 4, 'piala', 500000, '2025-10-05 05:49:31', '2025-10-05 05:49:31');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('kdDKFxMWrDwKhBia8qcYIh5zRI61oMI5hXng7hvo', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWUlKR2NydzZPRFd5cGFsVFNvWkI4dnlqRnRIazJhQUxxVjhEMVBQNCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1759818968),
('KDoQJwZUPbo9Rflfum2AtjQErZrTqm99nkBiDxNR', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibUl3N1VGWXpvNmFiZ1pQRzN6Yk9Sb2t1a1F4Z00yUUtTSzRaWGpzYSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO319', 1759763257),
('zzbFytPvMeni5qH2YJJy4aV7kmDw362YLWl0kH0i', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidzRhOURjVVFXU21TaktWVWZXZzhjYkV3QjRjSTEzNmg0bUkzbVBEWCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO319', 1759799528);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'coba', 'coba@gmail.com', NULL, '$2y$12$ofY2JwfIkobQPPwW4R1ebOyFDM5QCesYSBBc03fEsMsHCmGwDwzA.', NULL, '2025-09-05 21:11:20', '2025-09-05 21:11:20'),
(3, 'Della', 'della@gmail.com', NULL, '$2y$12$PXjriV.DlAidJJJpelU.relVnJlQIKWBpa4WRF5BN50iL0E9Eu3fK', NULL, '2025-10-06 07:47:10', '2025-10-06 07:47:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_events_tanggal` (`tanggal`),
  ADD KEY `idx_events_tanggal` (`tanggal`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelas_lombas`
--
ALTER TABLE `kelas_lombas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_kelas_event` (`event_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pengeluarans`
--
ALTER TABLE `pengeluarans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_peng_event` (`event_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kelas_lombas`
--
ALTER TABLE `kelas_lombas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pengeluarans`
--
ALTER TABLE `pengeluarans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kelas_lombas`
--
ALTER TABLE `kelas_lombas`
  ADD CONSTRAINT `fk_kelas_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pengeluarans`
--
ALTER TABLE `pengeluarans`
  ADD CONSTRAINT `fk_peng_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
