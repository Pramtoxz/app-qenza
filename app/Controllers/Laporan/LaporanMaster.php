<?php

namespace App\Controllers\Laporan;

use App\Controllers\BaseController;
use App\Models\AsetModel;
use CodeIgniter\HTTP\ResponseInterface;

class LaporanMaster extends BaseController
{

    public function LaporanPelanggan()
    {
        $data['title'] = 'Laporan Pelanggan';
        return view('laporan/master/pelanggan', $data);
    }

    public function viewallLaporanPelanggan()
    {
        $db = db_connect();
        $pelanggan = $db
            ->table('pelanggan')
            ->select('idpelanggan, nama, alamat, nohp, jk,platnomor') 
            ->groupBy('pelanggan.idpelanggan, pelanggan.nama, pelanggan.alamat, pelanggan.nohp, pelanggan.jk, pelanggan.platnomor')
            ->get()
            ->getResultArray();
        $data = [
            'pelanggan' => $pelanggan,
        ];
        $response = [
            'data' => view('laporan/master/viewpelanggan', $data),
        ];

        echo json_encode($response);
    }


    public function LaporanKaryawan()
    {
        $data['title'] = 'Laporan Karyawan';
        return view('laporan/master/karyawan', $data);
    }

    public function viewallLaporanKaryawan()
    {
        $db = db_connect();
        $karyawan = $db
            ->table('karyawan')
            ->select('idkaryawan, nama, alamat, nohp')
            ->groupBy('karyawan.idkaryawan, karyawan.nama, karyawan.alamat, karyawan.nohp')
            ->get()
            ->getResultArray();
        $data = [
            'karyawan' => $karyawan,
        ];
        $response = [
            'data' => view('laporan/master/viewkaryawan', $data),
        ];

        echo json_encode($response);
    }

    public function LaporanPaket()
    {
        $data['title'] = 'Laporan Paket';
        return view('laporan/master/paket', $data);
    }   

    public function viewallLaporanPaket()
    {
        $db = db_connect();
        $paket = $db
            ->table('paket_cucian')
            ->select('idpaket, namapaket, harga, jenis, keterangan')
            ->groupBy('paket_cucian.idpaket, paket_cucian.namapaket, paket_cucian.harga, paket_cucian.jenis, paket_cucian.keterangan')
            ->get()
            ->getResultArray();
        $data = [
            'paket' => $paket,
        ];
        $response = [
            'data' => view('laporan/master/viewpaket', $data),
        ];

        echo json_encode($response);
    }
}