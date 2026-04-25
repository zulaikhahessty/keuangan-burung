-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 25, 2026 at 02:22 AM
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

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-admsemarfin@gmail.com|127.0.0.1', 'i:1;', 1776962311),
('laravel-cache-admsemarfin@gmail.com|127.0.0.1:timer', 'i:1776962311;', 1776962311),
('laravel-cache-coba@gmail.com|127.0.0.1', 'i:1;', 1776962516),
('laravel-cache-coba@gmail.com|127.0.0.1:timer', 'i:1776962516;', 1776962516),
('laravel-cache-zulaikhahesty@gmail.com|127.0.0.1', 'i:2;', 1776962151),
('laravel-cache-zulaikhahesty@gmail.com|127.0.0.1:timer', 'i:1776962151;', 1776962151);

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
(4, '2025-10-05', 'Gawanan', 0, 19840000, 14300000, 2400000, 1360000, '2025-10-05 04:47:01', '2025-10-05 05:49:31'),
(8, '2026-04-01', 'cawas', 0, 1000000, 650000, 50000, 275000, '2026-04-23 10:05:09', '2026-04-23 10:16:56'),
(9, '2026-04-09', 'Klaten', 0, 2500000, 600000, 100000, 1725002, '2026-04-24 09:03:48', '2026-04-24 09:06:46');

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
(19, 4, 'mb dewasa ginastel', 220000, 24, 5280000, 2000000, 1000000, 500000, 350000, 250000, 0, 0, 0, 0, 0, 4100000, 0, 220000, 0, 0, 960000, '2025-10-05 04:49:49', '2025-10-05 04:49:49'),
(20, 4, 'mb dewasa bulldog', 350000, 24, 8400000, 3000000, 1500000, 800000, 500000, 350000, 0, 0, 0, 0, 0, 6150000, 0, 350000, 0, 0, 1900000, '2025-10-05 04:52:00', '2025-10-05 04:52:00'),
(21, 4, 'mb remaja', 110000, 24, 2640000, 1000000, 500000, 250000, 160000, 110000, 0, 0, 0, 0, 0, 2020000, 0, 1100000, 0, 0, -480000, '2025-10-05 05:43:29', '2025-10-05 05:43:29'),
(22, 4, 'mb dewasa arena', 110000, 32, 3520000, 1000000, 500000, 200000, 110000, 110000, 110000, 0, 0, 0, 0, 2030000, 0, 110000, 0, 0, 1380000, '2025-10-05 05:45:25', '2025-10-05 05:45:25'),
(25, 8, 'murai kicau mania', 50000, 20, 1000000, 300000, 200000, 150000, 0, 0, 0, 0, 0, 0, 0, 650000, 0, 25000, 0, 0, 325000, '2026-04-23 10:14:28', '2026-04-23 10:15:45'),
(26, 9, 'murai pink putih', 50000, 50, 2500000, 300000, 200000, 100000, 0, 0, 0, 0, 0, 0, 0, 600000, 0, 74998, 0, 0, 1825002, '2026-04-24 09:06:20', '2026-04-24 09:06:20');

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
(33, 4, 'Juri 1', 200000, '2025-10-05 05:46:22', '2025-10-05 05:46:22'),
(34, 4, 'Juri 2', 200000, '2025-10-05 05:46:46', '2025-10-05 05:46:46'),
(35, 4, 'Juri 3', 200000, '2025-10-05 05:47:08', '2025-10-05 05:47:08'),
(36, 4, 'Juri 4', 200000, '2025-10-05 05:47:31', '2025-10-05 05:47:31'),
(37, 4, 'Juri 5', 200000, '2025-10-05 05:47:53', '2025-10-05 05:47:53'),
(38, 4, 'Admin 1', 500000, '2025-10-05 05:48:30', '2025-10-05 05:48:30'),
(39, 4, 'Konsumsi', 400000, '2025-10-05 05:49:00', '2025-10-05 05:49:00'),
(40, 4, 'piala', 500000, '2025-10-05 05:49:31', '2025-10-05 05:49:31'),
(45, 8, 'uang makan', 50000, '2026-04-23 10:16:56', '2026-04-23 10:16:56'),
(46, 9, 'uang makan', 100000, '2026-04-24 09:06:46', '2026-04-24 09:06:46');

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
('abbVq58xO2ag3Xvt6lAf9UXIqjQa4XWvCOKThPfy', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMGdSQ29kbTJSTjdsR0Zob3RDNjRHWHVRTnBVNkRUYlpxNmtuUmxEbCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2Rhc2hib2FyZCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1777077539),
('EA4iopccfTpjWH8bOA4GKo1x085s7jQcSB2oqMIX', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVWJVQlozUFg1UFMxeVpEcFNUdnZ1OGE2NVNkMWR1ZlNCVEtrMkVlUyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjM6InVybCI7YTowOnt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NTt9', 1777052816),
('rz6oDEsfrvKmk3LC40OKEyGpBxNkXXLKm7UUzguM', 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiS2hDNFQwOXlycVRwOTMzVklKSGZWcVhPWTBUWmZkbVd1SjhDd2lRbSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjM6InVybCI7YTowOnt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Nzt9', 1777077192);

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
(3, 'Della', 'della@gmail.com', NULL, '$2y$12$PXjriV.DlAidJJJpelU.relVnJlQIKWBpa4WRF5BN50iL0E9Eu3fK', NULL, '2025-10-06 07:47:10', '2025-10-06 07:47:10'),
(5, 'hesty', 'hesty@gmail.com', NULL, '$2y$12$7RlAQrP0mHs2BiqR49qIo.LPdZh/U21tm1aWiEp5.MMkLrxBRTTbe', NULL, NULL, '2026-04-23 09:41:34'),
(7, 'admin', 'admin@gmail.com', NULL, '$2y$12$cMpPsliGlJX/YkGlC9wa5uc/SOT8aPxN7TL0.G5xElMamQUwmTjN.', NULL, '2026-04-25 00:31:50', '2026-04-24 17:33:04');

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pengeluarans`
--
ALTER TABLE `pengeluarans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
