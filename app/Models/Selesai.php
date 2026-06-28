<?php

namespace App\Models;

use CodeIgniter\Model;

class Selesai extends Model
{
    protected $table            = 'kendaraan_selesai';
    protected $primaryKey       = 'idselesai';
    protected $protectFields    = true;
    protected $allowedFields    = ['idselesai', 'idpencucian', 'jamjemput', 'totalbayar', 'totaldibayar'];

    // Dates
    protected $useTimestamps = false;
    
    // Soft Deletes
    protected $useSoftDeletes = false;
}
