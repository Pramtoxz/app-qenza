<?php

namespace App\Models;

use CodeIgniter\Model;

class FakturKendaraan extends Model
{
    protected $table            = 'detail_kendaraan';
    protected $primaryKey       = 'id';
    protected $protectFields    = true;
    protected $allowedFields    = ['idreservasi', 'platnomor', 'idkaryawan', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
