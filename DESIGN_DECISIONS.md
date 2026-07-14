# Qenza App - Architecture Decision Record
> Keputusan desain sistem hasil diskusi. Dokumen ini jadi acuan utama untuk coding.

---

## 1. Struktur Database (One-to-Many)

### Sebelum (One-to-One)
```
pencucian → 1 baris = 1 pelanggan + 1 kendaraan + 1-2 paket
```

### Sesudah (One-to-Many)
```
faktur → 1 pelanggan bisa bawa banyak kendaraan
faktur_kendaraan → 1 kendaraan bisa punya banyak paket
faktur_paket → detail paket per kendaraan
```

### Tabel

**faktur** (header transaksi)
| Field | Type | Keterangan |
|-------|------|------------|
| idfaktur | char(30) PK | Format: FKP-YYYYMMDD-NNNN |
| idpelanggan | char(30) FK | → pelanggan.idpelanggan |
| tgl | date | Tanggal kunjungan |
| jamdatang | time | Jam kedatangan |
| status_bayar | enum('belum','lunas') | Status pembayaran |
| nomor_antrian | varchar(10) | Nomor antrian |
| created_at, updated_at | timestamp | |

**faktur_kendaraan** (per kendaraan dalam 1 faktur)
| Field | Type | Keterangan |
|-------|------|------------|
| id | int PK AUTO_INCREMENT | |
| idfaktur | char(30) FK | → faktur.idfaktur |
| platnomor | varchar(50) | Plat nomor kendaraan |
| idkaryawan | char(30) FK NULL | → karyawan.idkaryawan (NULL = belum assign) |
| status | enum | 'pending','diproses','dijemput','selesai','batal' |
| created_at, updated_at | timestamp | |

**faktur_paket** (per paket per kendaraan)
| Field | Type | Keterangan |
|-------|------|------------|
| id | int PK AUTO_INCREMENT | |
| id_faktur_kendaraan | int FK | → faktur_kendaraan.id |
| idpaket | char(30) FK | → paket_cucian.idpaket |

**kendaraan_selesai** (checkout per kendaraan)
| Field | Type | Keterangan |
|-------|------|------------|
| idselesai | char(30) PK | Format: SLS-YYYYMMDD-NNNN |
| id_faktur_kendaraan | int FK | → faktur_kendaraan.id |
| jamjemput | time | |
| totalbayar | double | Total harga semua paket |
| totaldibayar | double | Uang yang diterima |

### Tabel Dihapus
- `pencucian` → digantikan oleh `faktur` + `faktur_kendaraan` + `faktur_paket`
- `gaji_karyawan` → slip gaji dihitung on-the-fly dari `faktur_kendaraan` + `faktur_paket` + `paket_cucian.upah`

---

## 2. Contoh Data

```
FKP-001 (Andi, 2 motor, lunas)
├── BA 1234 AA | Khairil | selesai
│   └── Cuci Biasa Motor    20.000
└── BA 5678 BB | Meiden  | selesai
    └── Cuci Salju Motor     25.000

FKP-003 (Budi, 1 mobil, 3 paket, lunas)
└── BA 3456 DD | Khairil | selesai
    ├── Cuci Biasa Mobil      40.000
    ├── Paket Luar Dalam      50.000
    └── Detailing Mobil      250.000

FKP-005 (Fajar, 2 motor, belum bayar)
├── BA 1111 FF | NULL | pending  (belum assign karyawan)
│   └── Cuci Biasa Motor    20.000
└── BA 2222 GG | NULL | pending
    ├── Cuci Biasa Motor    20.000
    └── Cuci Salju Motor    25.000
```

---

## 3. Flow Transaksi

### 3.1 Admin Membuat Faktur
```
1. Admin pilih pelanggan (dropdown/search)
2. Admin tambah kendaraan (platnomor) → bisa banyak
3. Admin tambah paket per kendaraan → bisa banyak per motor
4. Simpan → semua kendaraan status: PENDING, karyawan: NULL
5. Generate QR code per idfaktur → cetak antrian
```

### 3.2 Admin Assign Karyawan
```
1. Admin lihat list motor PENDING (antrian menunggu)
2. Admin pilih karyawan yang AVAILABLE (tidak sedang diproses motor lain)
3. Assign → status berubah: DIPROSES
4. 1 karyawan = 1 motor (tidak bisa assign ke motor lain selama DIPROSES)
5. Assign TIDAK BISA diubah (sekali assign, final)
```

### 3.3 Status Flow per Kendaraan
```
PENDING → DIPROSES → DIJEMPUT → SELESAI
                                ↘ BATAL
```

### 3.4 Checkout (Kendaraan Selesai)
```
1. Motor selesai → admin ubah status: DIJEMPUT
2. Pelanggan datang ambil → admin ubah: SELESAI
3. Admin hitung total bayar (sum harga paket dari faktur_paket)
4. Admin input uang diterima → simpan ke kendaraan_selesai
```

### 3.5 Tracking Public (Pelanggan Scan QR)
```
1. Pelanggan scan QR → redirect ke halaman public
2. Tampil list kendaraan + status masing-masing
3. Status update real-time
```

---

## 4. Karyawan Rules

| Rule | Detail |
|------|--------|
| 1 motor = 1 karyawan | Tidak bisa 1 motor dikerjakan 2 orang |
| 1 karyawan = 1 motor | Saat DIPROSES, tidak bisa assign ke motor lain |
| Assign final | Tidak bisa reassign setelah di-assign |
| Validasi assign | Karyawan yang sedang DIPROSES tidak muncul di dropdown |
| Antrian global | Semua motor pending dari semua pelanggan jadi 1 antrian |

---

## 5. Slip Gaji

- **Tidak ada tabel gaji_karyawan** → hitung on-the-fly
- **Input:** pilih karyawan + rentang tanggal
- **Query:** sum `paket_cucian.upah` dari `faktur_paket` JOIN `faktur_kendaraan` WHERE status='selesai'
- **Output:** slip printable per karyawan
- **Akses:** admin + pimpinan
- **Menu:** di dalam Laporan → Slip Gaji

---

## 6. Menu & Akses

### Sidebar Menu

| Menu | Submenu | Akses |
|------|---------|-------|
| Dashboard | - | admin, pimpinan |
| Master | Karyawan, Pelanggan, Paket Cucian | admin |
| Transaksi | Reservasi, Kendaraan Selesai | admin |
| Laporan | Pelanggan, Paket, Karyawan, Pencucian, Selesai, Slip Gaji | admin, pimpinan |

### Routes yang Dihapus
- `/gaji/*` (seluruh group)

### Routes Baru
```
laporan-transaksi/slip-gaji          GET     → form input
laporan-transaksi/slip-gaji/getkaryawan  POST → AJAX hitung upah
laporan-transaksi/slip-gaji/cetak    POST    → cetak slip (new tab)
pencucian/tracking/(:segment)        GET     → tracking public (tetap)
```

---

## 7. Files yang Sudah Dihapus (Sesi Sebelumnya)

- `app/Controllers/GajiController.php`
- `app/Models/Gaji.php`
- `app/Views/gaji/` (6 file)
- Menu "Gaji Karyawan" dari sidebar
- Routes `/gaji/*` dari Routes.php

---

## 8. Files yang Sudah Dibuat (Sesi Sebelumnya)

- `app/Views/laporan/transaksi/slipgaji.php` — form input slip gaji
- `app/Views/laporan/transaksi/cetakslipgaji.php` — halaman cetak slip
- Controller methods `SlipGaji()`, `getKaryawanSlipGaji()`, `cetakSlipGaji()` di `LaporanTransaksi.php`

---

## 9. Tech Stack

- **Framework:** CodeIgniter 4.7.3
- **PHP:** 8.2+
- **Database:** MySQLi
- **QR Code:** endroid/qr-code ^5.0
- **DataTables:** hermawan/codeigniter4-datatables ^0.8.0
- **Template:** layout/main.php (sidebar + navbar + footer)
- **AJAX:** jQuery + SweetAlert2
- **Roles:** admin, pimpinan

---

## 10. Printer

- **Printer:** RawBT (thermal/kertas kecil)
- **Ukuran kertas:** 58mm atau 80mm (thermal receipt)
- **Implications:**
  - Layout cetak harus sempit, tidak boleh landscape A4
  - Font kecil, tanpa gambar besar
  - Struk format: header → detail baris → total → footer
  - QR code muat di kertas kecil
  - Slip gaji juga format struk, bukan A4

---

## 11. Testing (Playwright)

Semua fitur harus ditest di akhir dengan Playwright. Kategori test:

### 11.1 UI/UX Testing
- [ ] Login page tampil benar, form validasi jalan
- [ ] Sidebar menu sesuai role (admin vs pimpinan)
- [ ] Responsive layout (tidak overlap/terpotong)
- [ ] Form input: required field, validasi format
- [ ] Modal/popup: buka, tutup, data terisi
- [ ] Navigasi: tidak ada broken link/404
- [ ] Loading state: spinner muncul saat AJAX

### 11.2 AJAX Testing
- [ ] CRUD semua module: create, read, update, delete
- [ ] DataTables: load, search, sort, pagination
- [ ] Form submit: success notification muncul
- [ ] Form submit: error notification muncul (validasi gagal)
- [ ] Assign karyawan: dropdown filter sesuai availability
- [ ] Status change: perubahan status tersimpan
- [ ] Slip gaji: hitung upah on-the-fly benar
- [ ] Tracking public: status tampil tanpa login

### 11.3 Edge Cases
- [ ] Karyawan sudah DIPROSES → tidak muncul di dropdown assign
- [ ] Faktur tanpa kendaraan → tidak bisa simpan
- [ ] Kendaraan tanpa paket → tidak bisa simpan
- [ ] Total bayar = 0 → warning
- [ ] Input tanggal salah (akhir < awal) → validasi tolak
- [ ] Session expired → redirect ke login
- [ ] Role akses: pimpinan tidak bisa akses menu admin

---

## 12. Catatan Penting

- `db_qenza_fresh.sql` sudah diupdate ke struktur baru (faktur, faktur_kendaraan, faktur_paket)
- Slip gaji dihitung on-the-fly, bukan dari tabel terpisah
- Status per kendaraan, bukan per faktur
- Status bayar per faktur (lunas/belum)
- QR code per faktur (bukan per kendaraan)
- Print format untuk RawBT (kertas kecil/thermal), BUKAN A4
- Project ini banyak bug → wajib test semua dengan Playwright sebelum selesai
