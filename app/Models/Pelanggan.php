<?php

namespace App\Models;

use CodeIgniter\Model;

class Pelanggan extends Model
{
    protected $table            = 'pelanggan';
    protected $primaryKey       = 'idpelanggan';
    protected $protectFields    = true;
    protected $allowedFields    = ['idpelanggan', 'nama', 'alamat', 'nohp', 'jk'];

    // Dates
    protected $useTimestamps = false;
}
