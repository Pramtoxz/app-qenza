-- ============================================================
-- DATABASE QENZA - FRESH START
-- Jalankan seluruh file ini di phpMyAdmin
-- ============================================================

DROP DATABASE IF EXISTS `db_qenza`;
CREATE DATABASE `db_qenza` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `db_qenza`;

-- ============================================================
-- TABLE: users
-- ============================================================
CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL COMMENT 'admin, pimpinan',
  `status` varchar(20) NOT NULL DEFAULT 'active' COMMENT 'active, inactive',
  `last_login` datetime DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_users_role` (`role`),
  KEY `idx_users_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `status`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'kasir@gmail.com', '$2y$12$7iMdIAEVUK6urCKjyqMTP.FvTfFIAkUgXL6W3bWLDFenuFNaamDKS', 'admin', 'active', NOW(), NOW(), NOW()),
(2, 'Pimpinan', 'pimpinan@gmail.com', '$2y$12$7iMdIAEVUK6urCKjyqMTP.FvTfFIAkUgXL6W3bWLDFenuFNaamDKS', 'pimpinan', 'active', NOW(), NOW(), NOW());

-- ============================================================
-- TABLE: karyawan
-- ============================================================
CREATE TABLE `karyawan` (
  `idkaryawan` char(30) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `alamat` text,
  `nohp` char(30) DEFAULT NULL,
  PRIMARY KEY (`idkaryawan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `karyawan` (`idkaryawan`, `nama`, `alamat`, `nohp`) VALUES
('KW0001', 'Khairil', 'Sijunjung', '081234567890'),
('KW0002', 'Meiden', 'Padang', '081298765432'),
('KW0003', 'Riko', 'Solok', '081377788899');

-- ============================================================
-- TABLE: pelanggan (TANPA platnomor - sudah dipindah ke pencucian)
-- ============================================================
CREATE TABLE `pelanggan` (
  `idpelanggan` char(30) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` text,
  `nohp` char(30) DEFAULT NULL,
  `jk` enum('L','P') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idpelanggan`),
  KEY `idx_tamu_jk` (`jk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `pelanggan` (`idpelanggan`, `nama`, `alamat`, `nohp`, `jk`) VALUES
('PL0001', 'Andi Saputra', 'Sijunjung', '081211112222', 'L'),
('PL0002', 'Siti Rahma', 'Padang', '081333344444', 'P'),
('PL0003', 'Budi Santoso', 'Bukittinggi', '081255556666', 'L'),
('PL0004', 'Dewi Lestari', 'Solok', '081277778888', 'P'),
('PL0005', 'Fajar Nugroho', 'Pariaman', '081299990000', 'L');

-- ============================================================
-- TABLE: paket_cucian
-- ============================================================
CREATE TABLE `paket_cucian` (
  `idpaket` char(30) NOT NULL,
  `namapaket` varchar(50) DEFAULT NULL,
  `jenis` varchar(50) DEFAULT NULL,
  `harga` double DEFAULT NULL,
  `keterangan` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `upah` double DEFAULT NULL,
  PRIMARY KEY (`idpaket`),
  KEY `idx_kamar_status` (`harga`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `paket_cucian` (`idpaket`, `namapaket`, `jenis`, `harga`, `keterangan`, `upah`) VALUES
('PKT0001', 'Cuci Biasa Motor', 'motor', 20000, 'Cuci body motor standar', 5000),
('PKT0002', 'Cuci Salju Motor', 'motor', 25000, 'Cuci body motor dengan busa salju', 7000),
('PKT0003', 'Cuci Biasa Mobil', 'mobil', 40000, 'Cuci body mobil standar', 10000),
('PKT0004', 'Paket Luar Dalam Mobil', 'mobil', 50000, 'Cuci luar dalam mobil', 12000),
('PKT0005', 'Detailing Mobil', 'mobil', 250000, 'Full detailing mobil premium', 50000);

-- ============================================================
-- TABLE: pencucian (DENGAN platnomor DAN idpaket2)
-- ============================================================
CREATE TABLE `pencucian` (
  `idpencucian` char(30) NOT NULL,
  `idkaryawan` char(30) DEFAULT NULL,
  `tgl` date DEFAULT NULL,
  `jamdatang` time DEFAULT NULL,
  `idpelanggan` char(30) DEFAULT NULL,
  `platnomor` varchar(50) DEFAULT NULL,
  `idpaket` char(30) DEFAULT NULL,
  `idpaket2` char(30) DEFAULT NULL,
  `status` enum('diproses','dijemput','selesai','pending','batal') DEFAULT NULL,
  `nomor_antrian` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idpencucian`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `pencucian` (`idpencucian`, `idkaryawan`, `tgl`, `jamdatang`, `idpelanggan`, `platnomor`, `idpaket`, `idpaket2`, `status`, `nomor_antrian`) VALUES
('FKP-20260713-0001', 'KW0001', '2026-07-13', '08:00:00', 'PL0001', 'BA 1234 AA', 'PKT0001', NULL, 'selesai', '1'),
('FKP-20260713-0002', 'KW0002', '2026-07-13', '09:15:00', 'PL0002', 'BA 5678 BB', 'PKT0002', NULL, 'selesai', '2'),
('FKP-20260713-0003', 'KW0003', '2026-07-13', '10:30:00', 'PL0003', 'BA 9012 CC', 'PKT0003', 'PKT0004', 'selesai', '3'),
('FKP-20260713-0004', 'KW0001', '2026-07-13', '11:00:00', 'PL0004', 'BA 3456 DD', 'PKT0005', NULL, 'dijemput', '4'),
('FKP-20260713-0005', NULL, '2026-07-13', '11:30:00', 'PL0005', 'BA 7890 EE', 'PKT0001', 'PKT0002', 'pending', '5'),
('FKP-20260713-0006', 'KW0002', '2026-07-13', '12:00:00', 'PL0001', 'BA 1111 FF', 'PKT0004', NULL, 'diproses', '6');

-- ============================================================
-- TABLE: kendaraan_selesai
-- ============================================================
CREATE TABLE `kendaraan_selesai` (
  `idselesai` char(30) NOT NULL,
  `idpencucian` char(30) DEFAULT NULL,
  `jamjemput` time DEFAULT NULL,
  `totalbayar` double DEFAULT NULL,
  `totaldibayar` double DEFAULT NULL,
  PRIMARY KEY (`idselesai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `kendaraan_selesai` (`idselesai`, `idpencucian`, `jamjemput`, `totalbayar`, `totaldibayar`) VALUES
('SLS-20260713-0001', 'FKP-20260713-0001', '08:45:00', 20000, 20000),
('SLS-20260713-0002', 'FKP-20260713-0002', '10:00:00', 25000, 30000),
('SLS-20260713-0003', 'FKP-20260713-0003', '11:30:00', 90000, 100000);

-- ============================================================
-- TABLE: gaji_karyawan
-- ============================================================
CREATE TABLE `gaji_karyawan` (
  `idgaji` char(30) NOT NULL,
  `idkaryawan` char(30) NOT NULL,
  `bulan` int NOT NULL,
  `tahun` int NOT NULL,
  `jumlah_cucian` int DEFAULT 0,
  `total_upah` double DEFAULT 0,
  `bonus` double DEFAULT 0,
  `potongan` double DEFAULT 0,
  `total_bayar` double DEFAULT 0,
  `tanggal_bayar` date DEFAULT NULL,
  `status` enum('draft','dibayar') DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idgaji`),
  KEY `fk_gaji_karyawan` (`idkaryawan`),
  CONSTRAINT `fk_gaji_karyawan` FOREIGN KEY (`idkaryawan`) REFERENCES `karyawan` (`idkaryawan`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `gaji_karyawan` (`idgaji`, `idkaryawan`, `bulan`, `tahun`, `jumlah_cucian`, `total_upah`, `bonus`, `potongan`, `total_bayar`, `tanggal_bayar`, `status`) VALUES
('GJI-20260713-0001', 'KW0001', 7, 2026, 2, 12000, 0, 0, 12000, '2026-07-13', 'dibayar'),
('GJI-20260713-0002', 'KW0002', 7, 2026, 2, 17000, 5000, 0, 22000, '2026-07-13', 'dibayar'),
('GJI-20260713-0003', 'KW0003', 7, 2026, 1, 22000, 0, 2000, 20000, NULL, 'draft');
