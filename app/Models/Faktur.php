<?php

namespace App\Models;

use CodeIgniter\Model;

class Faktur extends Model
{
    protected $table            = 'reservasi';
    protected $primaryKey       = 'idreservasi';
    protected $protectFields    = true;
    protected $allowedFields    = ['idreservasi', 'idpelanggan', 'tgl', 'jamdatang', 'status_bayar', 'nomor_antrian'];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
