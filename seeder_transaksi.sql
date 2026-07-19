-- ============================================================
-- SEEDER TRANSAKSI QENZA - Januari s/d Juli 2026
-- Minimal 5 data per bulan
-- Jalankan di phpMyAdmin (db_qenza)
-- ============================================================

USE `db_qenza`;

SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE `kendaraan_selesai`;
TRUNCATE TABLE `detail_paket`;
TRUNCATE TABLE `detail_kendaraan`;
TRUNCATE TABLE `reservasi`;
SET FOREIGN_KEY_CHECKS = 1;

-- Reset auto increment
ALTER TABLE `detail_kendaraan` AUTO_INCREMENT = 1;

-- ============================================================
-- JANUARI 2026
-- ============================================================
INSERT INTO `reservasi` (`idreservasi`, `idpelanggan`, `tgl`, `jamdatang`, `status_bayar`) VALUES
('FKP-20260105-0001', 'PL0001', '2026-01-05', '08:00:00', 'lunas'),
('FKP-20260108-0002', 'PL0002', '2026-01-08', '09:30:00', 'lunas'),
('FKP-20260112-0003', 'PL0003', '2026-01-12', '10:15:00', 'lunas'),
('FKP-20260118-0004', 'PL0004', '2026-01-18', '13:00:00', 'lunas'),
('FKP-20260125-0005', 'PL0005', '2026-01-25', '14:30:00', 'lunas');

INSERT INTO `detail_kendaraan` (`id`, `idreservasi`, `platnomor`, `idkaryawan`, `status`) VALUES
(1,  'FKP-20260105-0001', 'BA 1234 AA', 'KW0001', 'selesai'),
(2,  'FKP-20260108-0002', 'BA 5678 BB', 'KW0002', 'selesai'),
(3,  'FKP-20260112-0003', 'BA 9012 CC', 'KW0003', 'selesai'),
(4,  'FKP-20260118-0004', 'BA 3456 DD', 'KW0001', 'selesai'),
(5,  'FKP-20260118-0004', 'BA 7890 EE', 'KW0002', 'selesai'),
(6,  'FKP-20260125-0005', 'BA 1111 FF', 'KW0003', 'selesai');

INSERT INTO `detail_paket` (`id_detail_kendaraan`, `idpaket`) VALUES
(1, 'PKT0001'),
(2, 'PKT0002'),
(3, 'PKT0003'),
(3, 'PKT0004'),
(4, 'PKT0004'),
(5, 'PKT0003'),
(6, 'PKT0001'),
(6, 'PKT0002');

INSERT INTO `kendaraan_selesai` (`idselesai`, `id_detail_kendaraan`, `jamjemput`, `totalbayar`, `totaldibayar`) VALUES
('SLS-20260105-0001', 1, '08:45:00', 20000, 20000),
('SLS-20260108-0002', 2, '10:15:00', 25000, 25000),
('SLS-20260112-0003', 3, '11:30:00', 90000, 100000),
('SLS-20260118-0004', 4, '14:00:00', 50000, 50000),
('SLS-20260118-0005', 5, '14:00:00', 40000, 50000),
('SLS-20260125-0006', 6, '15:30:00', 45000, 50000);

-- ============================================================
-- FEBRUARI 2026
-- ============================================================
INSERT INTO `reservasi` (`idreservasi`, `idpelanggan`, `tgl`, `jamdatang`, `status_bayar`) VALUES
('FKP-20260203-0001', 'PL0003', '2026-02-03', '08:30:00', 'lunas'),
('FKP-20260207-0002', 'PL0001', '2026-02-07', '09:00:00', 'lunas'),
('FKP-20260214-0003', 'PL0005', '2026-02-14', '10:00:00', 'lunas'),
('FKP-20260220-0004', 'PL0002', '2026-02-20', '11:30:00', 'lunas'),
('FKP-20260228-0005', 'PL0004', '2026-02-28', '13:00:00', 'lunas');

INSERT INTO `detail_kendaraan` (`id`, `idreservasi`, `platnomor`, `idkaryawan`, `status`) VALUES
(7,  'FKP-20260203-0001', 'BA 9012 CC', 'KW0001', 'selesai'),
(8,  'FKP-20260207-0002', 'BA 1234 AA', 'KW0002', 'selesai'),
(9,  'FKP-20260214-0003', 'BA 2222 GG', 'KW0003', 'selesai'),
(10, 'FKP-20260220-0004', 'BA 5678 BB', 'KW0001', 'selesai'),
(11, 'FKP-20260228-0005', 'BA 3456 DD', 'KW0002', 'selesai'),
(12, 'FKP-20260228-0005', 'BA 7890 EE', 'KW0003', 'selesai');

INSERT INTO `detail_paket` (`id_detail_kendaraan`, `idpaket`) VALUES
(7,  'PKT0001'),
(8,  'PKT0003'),
(8,  'PKT0004'),
(9,  'PKT0002'),
(10, 'PKT0002'),
(11, 'PKT0004'),
(12, 'PKT0003');

INSERT INTO `kendaraan_selesai` (`idselesai`, `id_detail_kendaraan`, `jamjemput`, `totalbayar`, `totaldibayar`) VALUES
('SLS-20260203-0001', 7,  '09:15:00', 20000, 20000),
('SLS-20260207-0002', 8,  '10:30:00', 90000, 100000),
('SLS-20260214-0003', 9,  '10:45:00', 25000, 25000),
('SLS-20260220-0004', 10, '12:15:00', 25000, 25000),
('SLS-20260228-0005', 11, '14:00:00', 50000, 50000),
('SLS-20260228-0006', 12, '14:00:00', 40000, 50000);

-- ============================================================
-- MARET 2026
-- ============================================================
INSERT INTO `reservasi` (`idreservasi`, `idpelanggan`, `tgl`, `jamdatang`, `status_bayar`) VALUES
('FKP-20260302-0001', 'PL0001', '2026-03-02', '08:00:00', 'lunas'),
('FKP-20260306-0002', 'PL0004', '2026-03-06', '09:30:00', 'lunas'),
('FKP-20260315-0003', 'PL0002', '2026-03-15', '10:00:00', 'lunas'),
('FKP-20260321-0004', 'PL0003', '2026-03-21', '11:00:00', 'lunas'),
('FKP-20260328-0005', 'PL0005', '2026-03-28', '14:00:00', 'lunas');

INSERT INTO `detail_kendaraan` (`id`, `idreservasi`, `platnomor`, `idkaryawan`, `status`) VALUES
(13, 'FKP-20260302-0001', 'BA 1234 AA', 'KW0001', 'selesai'),
(14, 'FKP-20260306-0002', 'BA 7890 EE', 'KW0002', 'selesai'),
(15, 'FKP-20260306-0002', 'BA 3456 DD', 'KW0003', 'selesai'),
(16, 'FKP-20260315-0003', 'BA 5678 BB', 'KW0001', 'selesai'),
(17, 'FKP-20260321-0004', 'BA 9012 CC', 'KW0002', 'selesai'),
(18, 'FKP-20260328-0005', 'BA 1111 FF', 'KW0003', 'selesai');

INSERT INTO `detail_paket` (`id_detail_kendaraan`, `idpaket`) VALUES
(13, 'PKT0001'),
(14, 'PKT0004'),
(15, 'PKT0003'),
(16, 'PKT0002'),
(17, 'PKT0003'),
(17, 'PKT0004'),
(18, 'PKT0005');

INSERT INTO `kendaraan_selesai` (`idselesai`, `id_detail_kendaraan`, `jamjemput`, `totalbayar`, `totaldibayar`) VALUES
('SLS-20260302-0001', 13, '08:45:00', 20000, 20000),
('SLS-20260306-0002', 14, '10:30:00', 50000, 50000),
('SLS-20260306-0003', 15, '10:30:00', 40000, 50000),
('SLS-20260315-0004', 16, '10:45:00', 25000, 25000),
('SLS-20260321-0005', 17, '12:30:00', 90000, 100000),
('SLS-20260328-0006', 18, '15:00:00', 250000, 250000);

-- ============================================================
-- APRIL 2026
-- ============================================================
INSERT INTO `reservasi` (`idreservasi`, `idpelanggan`, `tgl`, `jamdatang`, `status_bayar`) VALUES
('FKP-20260401-0001', 'PL0002', '2026-04-01', '08:15:00', 'lunas'),
('FKP-20260407-0002', 'PL0005', '2026-04-07', '09:00:00', 'lunas'),
('FKP-20260413-0003', 'PL0001', '2026-04-13', '10:30:00', 'lunas'),
('FKP-20260420-0004', 'PL0004', '2026-04-20', '13:00:00', 'lunas'),
('FKP-20260427-0005', 'PL0003', '2026-04-27', '14:30:00', 'lunas');

INSERT INTO `detail_kendaraan` (`id`, `idreservasi`, `platnomor`, `idkaryawan`, `status`) VALUES
(19, 'FKP-20260401-0001', 'BA 5678 BB', 'KW0001', 'selesai'),
(20, 'FKP-20260407-0002', 'BA 2222 GG', 'KW0002', 'selesai'),
(21, 'FKP-20260413-0003', 'BA 1234 AA', 'KW0003', 'selesai'),
(22, 'FKP-20260413-0003', 'BA 1111 FF', 'KW0001', 'selesai'),
(23, 'FKP-20260420-0004', 'BA 7890 EE', 'KW0002', 'selesai'),
(24, 'FKP-20260427-0005', 'BA 9012 CC', 'KW0003', 'selesai');

INSERT INTO `detail_paket` (`id_detail_kendaraan`, `idpaket`) VALUES
(19, 'PKT0002'),
(20, 'PKT0001'),
(21, 'PKT0003'),
(21, 'PKT0004'),
(22, 'PKT0002'),
(23, 'PKT0004'),
(24, 'PKT0005');

INSERT INTO `kendaraan_selesai` (`idselesai`, `id_detail_kendaraan`, `jamjemput`, `totalbayar`, `totaldibayar`) VALUES
('SLS-20260401-0001', 19, '09:00:00', 25000, 25000),
('SLS-20260407-0002', 20, '09:45:00', 20000, 20000),
('SLS-20260413-0003', 21, '11:45:00', 90000, 100000),
('SLS-20260413-0004', 22, '11:45:00', 25000, 25000),
('SLS-20260420-0005', 23, '14:00:00', 50000, 50000),
('SLS-20260427-0006', 24, '15:30:00', 250000, 250000);

-- ============================================================
-- MEI 2026
-- ============================================================
INSERT INTO `reservasi` (`idreservasi`, `idpelanggan`, `tgl`, `jamdatang`, `status_bayar`) VALUES
('FKP-20260503-0001', 'PL0001', '2026-05-03', '08:00:00', 'lunas'),
('FKP-20260509-0002', 'PL0003', '2026-05-09', '09:30:00', 'lunas'),
('FKP-20260515-0003', 'PL0002', '2026-05-15', '10:00:00', 'lunas'),
('FKP-20260522-0004', 'PL0005', '2026-05-22', '11:30:00', 'lunas'),
('FKP-20260528-0005', 'PL0004', '2026-05-28', '13:00:00', 'lunas');

INSERT INTO `detail_kendaraan` (`id`, `idreservasi`, `platnomor`, `idkaryawan`, `status`) VALUES
(25, 'FKP-20260503-0001', 'BA 1234 AA', 'KW0001', 'selesai'),
(26, 'FKP-20260503-0001', 'BA 5678 BB', 'KW0002', 'selesai'),
(27, 'FKP-20260509-0002', 'BA 9012 CC', 'KW0003', 'selesai'),
(28, 'FKP-20260515-0003', 'BA 5678 BB', 'KW0001', 'selesai'),
(29, 'FKP-20260522-0004', 'BA 2222 GG', 'KW0002', 'selesai'),
(30, 'FKP-20260528-0005', 'BA 3456 DD', 'KW0003', 'selesai');

INSERT INTO `detail_paket` (`id_detail_kendaraan`, `idpaket`) VALUES
(25, 'PKT0001'),
(26, 'PKT0002'),
(27, 'PKT0003'),
(28, 'PKT0004'),
(28, 'PKT0005'),
(29, 'PKT0001'),
(30, 'PKT0004');

INSERT INTO `kendaraan_selesai` (`idselesai`, `id_detail_kendaraan`, `jamjemput`, `totalbayar`, `totaldibayar`) VALUES
('SLS-20260503-0001', 25, '08:45:00', 20000, 20000),
('SLS-20260503-0002', 26, '08:45:00', 25000, 25000),
('SLS-20260509-0003', 27, '10:30:00', 40000, 50000),
('SLS-20260515-0004', 28, '11:30:00', 300000, 300000),
('SLS-20260522-0005', 29, '12:15:00', 20000, 20000),
('SLS-20260528-0006', 30, '14:00:00', 50000, 50000);

-- ============================================================
-- JUNI 2026
-- ============================================================
INSERT INTO `reservasi` (`idreservasi`, `idpelanggan`, `tgl`, `jamdatang`, `status_bayar`) VALUES
('FKP-20260602-0001', 'PL0004', '2026-06-02', '08:00:00', 'lunas'),
('FKP-20260608-0002', 'PL0001', '2026-06-08', '09:15:00', 'lunas'),
('FKP-20260614-0003', 'PL0003', '2026-06-14', '10:00:00', 'lunas'),
('FKP-20260620-0004', 'PL0002', '2026-06-20', '11:30:00', 'lunas'),
('FKP-20260627-0005', 'PL0005', '2026-06-27', '13:00:00', 'lunas');

INSERT INTO `detail_kendaraan` (`id`, `idreservasi`, `platnomor`, `idkaryawan`, `status`) VALUES
(31, 'FKP-20260602-0001', 'BA 7890 EE', 'KW0001', 'selesai'),
(32, 'FKP-20260608-0002', 'BA 1234 AA', 'KW0002', 'selesai'),
(33, 'FKP-20260614-0003', 'BA 9012 CC', 'KW0003', 'selesai'),
(34, 'FKP-20260614-0003', 'BA 3456 DD', 'KW0001', 'selesai'),
(35, 'FKP-20260620-0004', 'BA 5678 BB', 'KW0002', 'selesai'),
(36, 'FKP-20260627-0005', 'BA 1111 FF', 'KW0003', 'selesai');

INSERT INTO `detail_paket` (`id_detail_kendaraan`, `idpaket`) VALUES
(31, 'PKT0004'),
(32, 'PKT0003'),
(32, 'PKT0004'),
(33, 'PKT0001'),
(34, 'PKT0002'),
(35, 'PKT0005'),
(36, 'PKT0001');

INSERT INTO `kendaraan_selesai` (`idselesai`, `id_detail_kendaraan`, `jamjemput`, `totalbayar`, `totaldibayar`) VALUES
('SLS-20260602-0001', 31, '09:00:00', 50000, 50000),
('SLS-20260608-0002', 32, '10:30:00', 90000, 100000),
('SLS-20260614-0003', 33, '10:45:00', 20000, 20000),
('SLS-20260614-0004', 34, '10:45:00', 25000, 25000),
('SLS-20260620-0005', 35, '13:00:00', 250000, 250000),
('SLS-20260627-0006', 36, '13:45:00', 20000, 20000);

-- ============================================================
-- JULI 2026 (sampai tanggal 20)
-- ============================================================
INSERT INTO `reservasi` (`idreservasi`, `idpelanggan`, `tgl`, `jamdatang`, `status_bayar`) VALUES
('FKP-20260702-0001', 'PL0002', '2026-07-02', '08:00:00', 'lunas'),
('FKP-20260705-0002', 'PL0001', '2026-07-05', '09:00:00', 'lunas'),
('FKP-20260710-0003', 'PL0004', '2026-07-10', '10:30:00', 'lunas'),
('FKP-20260713-0004', 'PL0003', '2026-07-13', '08:00:00', 'lunas'),
('FKP-20260713-0005', 'PL0002', '2026-07-13', '09:15:00', 'lunas'),
('FKP-20260714-0006', 'PL0005', '2026-07-14', '10:00:00', 'belum'),
('FKP-20260718-0007', 'PL0001', '2026-07-18', '11:00:00', 'belum');

INSERT INTO `detail_kendaraan` (`id`, `idreservasi`, `platnomor`, `idkaryawan`, `status`) VALUES
(37, 'FKP-20260702-0001', 'BA 5678 BB', 'KW0001', 'selesai'),
(38, 'FKP-20260705-0002', 'BA 1234 AA', 'KW0002', 'selesai'),
(39, 'FKP-20260710-0003', 'BA 7890 EE', 'KW0003', 'selesai'),
(40, 'FKP-20260713-0004', 'BA 9012 CC', 'KW0001', 'selesai'),
(41, 'FKP-20260713-0005', 'BA 5678 BB', 'KW0002', 'selesai'),
(42, 'FKP-20260714-0006', 'BA 4364 IK', 'KW0003', 'diproses'),
(43, 'FKP-20260714-0006', 'BA 4364 JJ', NULL, 'pending'),
(44, 'FKP-20260718-0007', 'BA 1234 AA', NULL, 'pending');

INSERT INTO `detail_paket` (`id_detail_kendaraan`, `idpaket`) VALUES
(37, 'PKT0002'),
(38, 'PKT0003'),
(38, 'PKT0004'),
(39, 'PKT0004'),
(40, 'PKT0001'),
(41, 'PKT0002'),
(42, 'PKT0003'),
(42, 'PKT0004'),
(43, 'PKT0004'),
(44, 'PKT0001');

INSERT INTO `kendaraan_selesai` (`idselesai`, `id_detail_kendaraan`, `jamjemput`, `totalbayar`, `totaldibayar`) VALUES
('SLS-20260702-0001', 37, '08:45:00', 25000, 25000),
('SLS-20260705-0002', 38, '10:30:00', 90000, 100000),
('SLS-20260710-0003', 39, '11:30:00', 50000, 50000),
('SLS-20260713-0004', 40, '08:45:00', 20000, 20000),
('SLS-20260713-0005', 41, '10:00:00', 25000, 25000);
