<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Pencucian;
use App\Models\Selesai;
use App\Models\Pelanggan;
use App\Models\Karyawan;
use App\Models\Paket;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{
    public function index()
    {
        $db = db_connect();
        
        // Get basic statistics
        $totalPelanggan = $db->table('pelanggan')->countAll();
        $totalKaryawan = $db->table('karyawan')->countAll();
        $totalPaket = $db->table('paket_cucian')->countAll();
        
        // Pencucian statistics
        $totalPencucian = $db->table('pencucian')->countAll();
        $pencucianHariIni = $db->table('pencucian')
            ->where('DATE(tgl)', date('Y-m-d'))
            ->countAllResults();
        
        $statusCount = $db->table('pencucian')
            ->select('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->getResultArray();
        
        // Format status count for easier use
        $statusStats = [
            'pending' => 0,
            'diproses' => 0,
            'dijemput' => 0,
            'selesai' => 0,
            'batal' => 0
        ];
        
        foreach ($statusCount as $status) {
            $statusStats[$status['status']] = $status['count'];
        }
        
        // Get recent pencucian with joins
        $recentPencucian = $db->table('pencucian')
            ->select('pencucian.*, pelanggan.nama as nama_pelanggan, 
                     paket_cucian.namapaket, karyawan.nama as nama_karyawan')
            ->join('pelanggan', 'pelanggan.idpelanggan = pencucian.idpelanggan')
            ->join('paket_cucian', 'paket_cucian.idpaket = pencucian.idpaket')
            ->join('karyawan', 'karyawan.idkaryawan = pencucian.idkaryawan', 'left')
            ->orderBy('pencucian.tgl', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();
        
        // Get revenue data (from selesai table)
        $pendapatanBulanIni = $db->table('kendaraan_selesai ks')
            ->select('SUM(ks.totalbayar) as total')
            ->join('pencucian p', 'p.idpencucian = ks.idpencucian')
            ->where('MONTH(p.tgl)', date('m'))
            ->where('YEAR(p.tgl)', date('Y'))
            ->get()
            ->getRow()->total ?? 0;
        
        $data = [
            'title' => 'Dashboard - Pencucian Qenza',
            'totalPelanggan' => $totalPelanggan,
            'totalKaryawan' => $totalKaryawan,
            'totalPaket' => $totalPaket,
            'totalPencucian' => $totalPencucian,
            'pencucianHariIni' => $pencucianHariIni,
            'statusStats' => $statusStats,
            'recentPencucian' => $recentPencucian,
            'pendapatanBulanIni' => $pendapatanBulanIni
        ];
        
        return view('dashboard/index', $data);
    } 
}