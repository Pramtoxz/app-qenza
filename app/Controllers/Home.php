<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Paket as PaketModel;

class Home extends BaseController
{
   
    public function index()
   {
    $paket = new PaketModel();
    $paket = $paket->findAll();
    $data = [
        'title' => 'Pencucian Qenza',
        'paket' => $paket
    ];
    return view('home/index', $data);
   }

   public function tracking()
   {
       $id = $this->request->getGet('id');
       
       if ($id) {
           $db = db_connect();
           
           // Join tabel pencucian dengan pelanggan, paket, dan karyawan untuk tracking
           $pencucianQuery = $db
               ->table('pencucian')
               ->select('pencucian.*, 
                        pelanggan.nama as nama_pelanggan, 
                        pelanggan.alamat, 
                        pelanggan.nohp, 
                        pelanggan.platnomor,
                        paket_cucian.namapaket, 
                        paket_cucian.harga, 
                        paket_cucian.jenis,
                        karyawan.nama as nama_karyawan')
               ->join('pelanggan', 'pelanggan.idpelanggan = pencucian.idpelanggan')
               ->join('paket_cucian', 'paket_cucian.idpaket = pencucian.idpaket')
               ->join('karyawan', 'karyawan.idkaryawan = pencucian.idkaryawan')
               ->where('pencucian.idpencucian', $id);
           
           $pencucianData = $pencucianQuery->get()->getRowArray();

           if (!$pencucianData) {
               $data = [
                   'error' => 'ID Pencucian "' . $id . '" tidak ditemukan. Pastikan ID yang Anda masukkan benar.'
               ];
           } else {
               $data = [
                   'pencucian' => $pencucianData
               ];
           }
       } else {
           $data = [];
       }

       return view('home/tracking', $data);
   }
}