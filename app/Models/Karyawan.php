<?php

namespace App\Models;

use CodeIgniter\Model;

class Karyawan extends Model
{
    protected $table            = 'karyawan';
    protected $primaryKey       = 'idkaryawan';
    protected $protectFields    = true;
    protected $allowedFields    = ['idkaryawan', 'nama', 'alamat', 'nohp'];


    // Dates
    protected $useTimestamps = false;
}
