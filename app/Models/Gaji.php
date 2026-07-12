<?php

namespace App\Models;

use CodeIgniter\Model;

class Gaji extends Model
{
    protected $table            = 'gaji_karyawan';
    protected $primaryKey       = 'idgaji';
    protected $protectFields    = true;
    protected $allowedFields    = ['idgaji', 'idkaryawan', 'bulan', 'tahun', 'jumlah_cucian', 'total_upah', 'bonus', 'potongan', 'total_bayar', 'tanggal_bayar', 'status'];

    protected $useTimestamps = false;
}
