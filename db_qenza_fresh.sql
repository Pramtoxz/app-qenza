-- ============================================================
-- DATABASE QENZA - FRESH START (v2 - One to Many)
-- Jalankan seluruh file ini di phpMyAdmin
-- ============================================================

DROP DATABASE IF EXISTS `qenza`;
CREATE DATABASE `qenza` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `qenza`;

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
-- TABLE: pelanggan
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
  KEY `idx_pelanggan_jk` (`jk`)
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
  KEY `idx_paket_harga` (`harga`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `paket_cucian` (`idpaket`, `namapaket`, `jenis`, `harga`, `keterangan`, `upah`) VALUES
('PKT0001', 'Cuci Biasa Motor', 'motor', 20000, 'Cuci body motor standar', 5000),
('PKT0002', 'Cuci Salju Motor', 'motor', 25000, 'Cuci body motor dengan busa salju', 7000),
('PKT0003', 'Cuci Biasa Mobil', 'mobil', 40000, 'Cuci body mobil standar', 10000),
('PKT0004', 'Paket Luar Dalam Mobil', 'mobil', 50000, 'Cuci luar dalam mobil', 12000),
('PKT0005', 'Detailing Mobil', 'mobil', 250000, 'Full detailing mobil premium', 50000);

-- ============================================================
-- TABLE: reservasi (header transaksi - 1 pelanggan bisa bawa banyak kendaraan)
-- ============================================================
CREATE TABLE `reservasi` (
  `idreservasi` char(30) NOT NULL,
  `idpelanggan` char(30) DEFAULT NULL,
  `tgl` date DEFAULT NULL,
  `jamdatang` time DEFAULT NULL,
  `status_bayar` enum('belum','lunas') DEFAULT 'belum',
  `nomor_antrian` varchar(10) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idreservasi`),
  KEY `fk_reservasi_pelanggan` (`idpelanggan`),
  CONSTRAINT `fk_reservasi_pelanggan` FOREIGN KEY (`idpelanggan`) REFERENCES `pelanggan` (`idpelanggan`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `reservasi` (`idreservasi`, `idpelanggan`, `tgl`, `jamdatang`, `status_bayar`, `nomor_antrian`) VALUES
('FKP-20260713-0001', 'PL0001', '2026-07-13', '08:00:00', 'lunas', '1'),
('FKP-20260713-0002', 'PL0002', '2026-07-13', '09:15:00', 'lunas', '2'),
('FKP-20260713-0003', 'PL0003', '2026-07-13', '10:30:00', 'lunas', '3'),
('FKP-20260713-0004', 'PL0004', '2026-07-13', '11:00:00', 'belum', '4'),
('FKP-20260713-0005', 'PL0005', '2026-07-13', '11:30:00', 'belum', '5');

-- ============================================================
-- TABLE: detail_kendaraan (per kendaraan dalam 1 reservasi)
-- ============================================================
CREATE TABLE `detail_kendaraan` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `idreservasi` char(30) NOT NULL,
  `platnomor` varchar(50) DEFAULT NULL,
  `idkaryawan` char(30) DEFAULT NULL,
  `status` enum('pending','diproses','dijemput','selesai','batal') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_kendaraan_reservasi` (`idreservasi`),
  KEY `fk_kendaraan_karyawan` (`idkaryawan`),
  CONSTRAINT `fk_kendaraan_reservasi` FOREIGN KEY (`idreservasi`) REFERENCES `reservasi` (`idreservasi`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_kendaraan_karyawan` FOREIGN KEY (`idkaryawan`) REFERENCES `karyawan` (`idkaryawan`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Reservasi 1: Andi bawa 2 motor
INSERT INTO `detail_kendaraan` (`id`, `idreservasi`, `platnomor`, `idkaryawan`, `status`) VALUES
(1, 'FKP-20260713-0001', 'BA 1234 AA', 'KW0001', 'selesai'),
(2, 'FKP-20260713-0001', 'BA 5678 BB', 'KW0002', 'selesai');

-- Reservasi 2: Siti bawa 1 motor
INSERT INTO `detail_kendaraan` (`id`, `idreservasi`, `platnomor`, `idkaryawan`, `status`) VALUES
(3, 'FKP-20260713-0002', 'BA 9012 CC', 'KW0003', 'selesai');

-- Reservasi 3: Budi bawa 1 mobil (banyak paket)
INSERT INTO `detail_kendaraan` (`id`, `idreservasi`, `platnomor`, `idkaryawan`, `status`) VALUES
(4, 'FKP-20260713-0003', 'BA 3456 DD', 'KW0001', 'selesai');

-- Reservasi 4: Dewi bawa 1 mobil
INSERT INTO `detail_kendaraan` (`id`, `idreservasi`, `platnomor`, `idkaryawan`, `status`) VALUES
(5, 'FKP-20260713-0004', 'BA 7890 EE', 'KW0002', 'dijemput');

-- Reservasi 5: Fajar bawa 2 motor (pending, belum assign karyawan)
INSERT INTO `detail_kendaraan` (`id`, `idreservasi`, `platnomor`, `idkaryawan`, `status`) VALUES
(6, 'FKP-20260713-0005', 'BA 1111 FF', NULL, 'pending'),
(7, 'FKP-20260713-0005', 'BA 2222 GG', NULL, 'pending');

-- ============================================================
-- TABLE: detail_paket (per paket per kendaraan)
-- ============================================================
CREATE TABLE `detail_paket` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_detail_kendaraan` int UNSIGNED NOT NULL,
  `idpaket` char(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_paket_kendaraan` (`id_detail_kendaraan`),
  KEY `fk_paket_paket` (`idpaket`),
  CONSTRAINT `fk_paket_kendaraan` FOREIGN KEY (`id_detail_kendaraan`) REFERENCES `detail_kendaraan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_paket_paket` FOREIGN KEY (`idpaket`) REFERENCES `paket_cucian` (`idpaket`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Motor 1 (BA 1234): 1 paket
INSERT INTO `detail_paket` (`id_detail_kendaraan`, `idpaket`) VALUES
(1, 'PKT0001');

-- Motor 2 (BA 5678): 1 paket
INSERT INTO `detail_paket` (`id_detail_kendaraan`, `idpaket`) VALUES
(2, 'PKT0002');

-- Motor 3 (BA 9012): 2 paket
INSERT INTO `detail_paket` (`id_detail_kendaraan`, `idpaket`) VALUES
(3, 'PKT0003'),
(3, 'PKT0004');

-- Motor 4 (BA 3456): 3 paket (contoh banyak paket)
INSERT INTO `detail_paket` (`id_detail_kendaraan`, `idpaket`) VALUES
(4, 'PKT0003'),
(4, 'PKT0004'),
(4, 'PKT0005');

-- Motor 5 (BA 7890): 1 paket
INSERT INTO `detail_paket` (`id_detail_kendaraan`, `idpaket`) VALUES
(5, 'PKT0004');

-- Motor 6 (BA 1111): 1 paket
INSERT INTO `detail_paket` (`id_detail_kendaraan`, `idpaket`) VALUES
(6, 'PKT0001');

-- Motor 7 (BA 2222): 2 paket
INSERT INTO `detail_paket` (`id_detail_kendaraan`, `idpaket`) VALUES
(7, 'PKT0001'),
(7, 'PKT0002');

-- ============================================================
-- TABLE: kendaraan_selesai (checkout per kendaraan)
-- ============================================================
CREATE TABLE `kendaraan_selesai` (
  `idselesai` char(30) NOT NULL,
  `id_detail_kendaraan` int UNSIGNED DEFAULT NULL,
  `jamjemput` time DEFAULT NULL,
  `totalbayar` double DEFAULT NULL,
  `totaldibayar` double DEFAULT NULL,
  PRIMARY KEY (`idselesai`),
  KEY `fk_selesai_kendaraan` (`id_detail_kendaraan`),
  CONSTRAINT `fk_selesai_kendaraan` FOREIGN KEY (`id_detail_kendaraan`) REFERENCES `detail_kendaraan` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `kendaraan_selesai` (`idselesai`, `id_detail_kendaraan`, `jamjemput`, `totalbayar`, `totaldibayar`) VALUES
('SLS-20260713-0001', 1, '08:45:00', 20000, 20000),
('SLS-20260713-0002', 2, '10:00:00', 25000, 30000),
('SLS-20260713-0003', 3, '11:30:00', 90000, 100000),
('SLS-20260713-0004', 4, '12:00:00', 340000, 350000);
