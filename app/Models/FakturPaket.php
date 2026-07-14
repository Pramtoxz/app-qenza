<?php

namespace App\Models;

use CodeIgniter\Model;

class FakturPaket extends Model
{
    protected $table            = 'detail_paket';
    protected $primaryKey       = 'id';
    protected $protectFields    = true;
    protected $allowedFields    = ['id_detail_kendaraan', 'idpaket'];

    // Dates
    protected $useTimestamps = false;
}
