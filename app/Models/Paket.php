<?php

namespace App\Models;

use CodeIgniter\Model;

class Paket extends Model
{
    protected $table            = 'paket_cucian';
    protected $primaryKey       = 'idpaket';
    protected $protectFields    = true;
    protected $allowedFields    = ['idpaket', 'namapaket', 'harga', 'jenis', 'keterangan','upah'];

    // Dates
    protected $useTimestamps = false;
}
