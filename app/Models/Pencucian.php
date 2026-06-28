<?php

namespace App\Models;

use CodeIgniter\Model;

class Pencucian extends Model
{
    protected $table            = 'pencucian';
    protected $primaryKey       = 'idpencucian';
    protected $protectFields    = true;
    protected $allowedFields    = ['idpencucian', 'idkaryawan', 'tgl', 'jamdatang', 'idpelanggan','idpaket', 'status','nomor_antrian'];

    // Dates
    protected $useTimestamps = false;
}
