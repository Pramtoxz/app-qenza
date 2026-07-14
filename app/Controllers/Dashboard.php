<?php

namespace App\Controllers;

use App\Controllers\BaseController;
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
        
        // Faktur statistics
        $totalFaktur = $db->table('reservasi')->countAll();

        // Pencucian statistics (from detail_kendaraan)
        $totalPencucian = $db->table('detail_kendaraan')->countAll();
        $pencucianHariIni = $db->table('detail_kendaraan')
            ->where('DATE(created_at)', date('Y-m-d'))
            ->countAllResults();

        $statusCount = $db->table('detail_kendaraan')
            ->select('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->getResultArray();

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

        // Get recent pencucian: detail_kendaraan → reservasi → pelanggan + karyawan + paket
        $recentPencucian = $db->table('detail_kendaraan fk')
            ->select('fk.id as idkendaraan, fk.platnomor, fk.status,
                     f.idreservasi, f.tgl, f.jamdatang,
                     p.nama as nama_pelanggan,
                     k.nama as nama_karyawan,
                     GROUP_CONCAT(pc.namapaket SEPARATOR ", ") as namapaket')
            ->join('reservasi f', 'f.idreservasi = fk.idreservasi')
            ->join('pelanggan p', 'p.idpelanggan = f.idpelanggan')
            ->join('karyawan k', 'k.idkaryawan = fk.idkaryawan', 'left')
            ->join('detail_paket fp', 'fp.id_detail_kendaraan = fk.id', 'left')
            ->join('paket_cucian pc', 'pc.idpaket = fp.idpaket', 'left')
            ->groupBy('fk.id')
            ->orderBy('f.tgl', 'DESC')
            ->orderBy('f.jamdatang', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        // Get revenue data: kendaraan_selesai → detail_kendaraan → reservasi
        $pendapatanBulanIni = $db->table('kendaraan_selesai ks')
            ->select('SUM(ks.totalbayar) as total')
            ->join('detail_kendaraan fk', 'fk.id = ks.id_detail_kendaraan')
            ->join('reservasi f', 'f.idreservasi = fk.idreservasi')
            ->where('MONTH(f.tgl)', date('m'))
            ->where('YEAR(f.tgl)', date('Y'))
            ->get()
            ->getRow()->total ?? 0;

        $data = [
            'title' => 'Dashboard - Pencucian Qenza',
            'totalPelanggan' => $totalPelanggan,
            'totalKaryawan' => $totalKaryawan,
            'totalPaket' => $totalPaket,
            'totalFaktur' => $totalFaktur,
            'totalPencucian' => $totalPencucian,
            'pencucianHariIni' => $pencucianHariIni,
            'statusStats' => $statusStats,
            'recentPencucian' => $recentPencucian,
            'pendapatanBulanIni' => $pendapatanBulanIni
        ];
        
        return view('dashboard/index', $data);
    } 
}