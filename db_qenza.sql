-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 28, 2026 at 06:14 PM
-- Server version: 8.0.30
-- PHP Version: 8.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_qenza`
--

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `idkaryawan` char(30) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `alamat` text,
  `nohp` char(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`idkaryawan`, `nama`, `alamat`, `nohp`) VALUES
('KW0001', 'cias', 'adasdsad', '08123123');

-- --------------------------------------------------------

--
-- Table structure for table `kendaraan_selesai`
--

CREATE TABLE `kendaraan_selesai` (
  `idselesai` char(30) DEFAULT NULL,
  `idpencucian` char(30) DEFAULT NULL,
  `jamjemput` time DEFAULT NULL,
  `totalbayar` double DEFAULT NULL,
  `totaldibayar` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kendaraan_selesai`
--

INSERT INTO `kendaraan_selesai` (`idselesai`, `idpencucian`, `jamjemput`, `totalbayar`, `totaldibayar`) VALUES
('SLS-20250803-0001', 'FKP-20250803-0001', '13:59:00', 15000, 20000);

-- --------------------------------------------------------

--
-- Table structure for table `paket_cucian`
--

CREATE TABLE `paket_cucian` (
  `idpaket` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `namapaket` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `jenis` varchar(50) DEFAULT NULL,
  `harga` double DEFAULT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `upah` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `paket_cucian`
--

INSERT INTO `paket_cucian` (`idpaket`, `namapaket`, `jenis`, `harga`, `keterangan`, `created_at`, `updated_at`, `upah`) VALUES
('PKT0001', 'Paket Salju', 'motor', 20000, 'asdsdsd', '2026-06-29 16:25:51', '2026-06-29 16:25:51', 5000),
('PKT0002', 'asdasd', 'motor', 25000, 'asdadadasdhasgd', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `idpelanggan` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` text,
  `nohp` char(30) DEFAULT NULL,
  `jk` enum('L','P') DEFAULT NULL,
  `platnomor` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`idpelanggan`, `nama`, `alamat`, `nohp`, `jk`, `platnomor`, `created_at`, `updated_at`, `deleted_at`) VALUES
('PL0001', 'cia', 'cia', '123', 'L', 'BA 4365 gg', NULL, NULL, NULL),
('PL0002', 'Theresia', 'Padang', '089828282', 'P', 'BA 4344 NH', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pencucian`
--

CREATE TABLE `pencucian` (
  `idpencucian` char(30) NOT NULL,
  `idkaryawan` char(30) DEFAULT NULL,
  `tgl` date DEFAULT NULL,
  `jamdatang` time DEFAULT NULL,
  `idpelanggan` char(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `idpaket` char(30) DEFAULT NULL,
  `status` enum('diproses','dijemput','selesai') DEFAULT NULL,
  `nomor_antrian` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pencucian`
--

INSERT INTO `pencucian` (`idpencucian`, `idkaryawan`, `tgl`, `jamdatang`, `idpelanggan`, `idpaket`, `status`, `nomor_antrian`) VALUES
('FKP-20250803-0001', 'KW0001', '2025-08-03', '12:05:47', 'PL0002', 'PKT0001', 'selesai', NULL),
('FKP-20260626-0001', 'KW0001', '2026-06-26', '21:25:32', 'PL0001', 'PKT0001', 'diproses', NULL),
('FKP-20260626-0002', NULL, '2026-06-26', '21:26:10', 'PL0002', 'PKT0001', '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL COMMENT 'admin, user, dll',
  `status` varchar(20) NOT NULL DEFAULT 'active' COMMENT 'active, inactive',
  `last_login` datetime DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `status`, `last_login`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin', 'kasir@gmail.com', '$2y$12$7iMdIAEVUK6urCKjyqMTP.FvTfFIAkUgXL6W3bWLDFenuFNaamDKS', 'admin', 'active', '2026-06-29 00:08:00', NULL, '2025-06-14 21:50:56', '2025-06-14 21:50:56', NULL),
(26, 'Pimpinan', 'pimpinan@gmail.com', '$2y$12$7iMdIAEVUK6urCKjyqMTP.FvTfFIAkUgXL6W3bWLDFenuFNaamDKS', 'pimpinan', 'active', '2025-07-27 12:58:39', NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`idkaryawan`);

--
-- Indexes for table `paket_cucian`
--
ALTER TABLE `paket_cucian`
  ADD PRIMARY KEY (`idpaket`),
  ADD KEY `idx_kamar_status` (`harga`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`idpelanggan`),
  ADD KEY `fk_tamu_user` (`platnomor`),
  ADD KEY `idx_tamu_jk` (`jk`);

--
-- Indexes for table `pencucian`
--
ALTER TABLE `pencucian`
  ADD PRIMARY KEY (`idpencucian`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_users_role` (`role`),
  ADD KEY `idx_users_status` (`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
