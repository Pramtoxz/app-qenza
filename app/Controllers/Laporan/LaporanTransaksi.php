<?php

namespace App\Controllers\Laporan;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class LaporanTransaksi extends BaseController
{
    public function SlipGaji()
    {
        $db = db_connect();
        $karyawan = $db->table('karyawan')
            ->select('idkaryawan, nama')
            ->orderBy('nama', 'ASC')
            ->get()
            ->getResultArray();

        return view('laporan/transaksi/slipgaji', [
            'title' => 'Laporan Slip Gaji',
            'karyawan' => $karyawan
        ]);
    }

    public function getKaryawanSlipGaji()
    {
        if ($this->request->isAJAX()) {
            $idkaryawan = $this->request->getPost('idkaryawan');
            $tglmulai = $this->request->getPost('tglmulai');
            $tglakhir = $this->request->getPost('tglakhir');

            $db = db_connect();

            $karyawan = $db->table('karyawan')
                ->where('idkaryawan', $idkaryawan)
                ->get()
                ->getRowArray();

            if (!$karyawan) {
                return $this->response->setJSON(['error' => 'Karyawan tidak ditemukan']);
            }

            $pencucianList = $db->table('detail_kendaraan')
                ->select('detail_kendaraan.id, detail_kendaraan.platnomor, reservasi.tgl,
                         paket_cucian.namapaket, paket_cucian.upah')
                ->join('reservasi', 'reservasi.idreservasi = detail_kendaraan.idreservasi')
                ->join('detail_paket', 'detail_paket.id_detail_kendaraan = detail_kendaraan.id')
                ->join('paket_cucian', 'paket_cucian.idpaket = detail_paket.idpaket')
                ->where('detail_kendaraan.idkaryawan', $idkaryawan)
                ->where('detail_kendaraan.status', 'selesai')
                ->where('reservasi.tgl >=', $tglmulai)
                ->where('reservasi.tgl <=', $tglakhir)
                ->orderBy('reservasi.tgl', 'ASC')
                ->get()
                ->getResultArray();

            $totalUpah = 0;
            foreach ($pencucianList as $p) {
                $totalUpah += ($p['upah'] ?? 0);
            }

            return $this->response->setJSON([
                'sukses' => true,
                'karyawan' => $karyawan,
                'pencucianList' => $pencucianList,
                'jumlah_cucian' => count($pencucianList),
                'total_upah' => $totalUpah,
                'tglmulai' => $tglmulai,
                'tglakhir' => $tglakhir
            ]);
        }
    }

    public function cetakSlipGaji()
    {
        $idkaryawan = $this->request->getPost('idkaryawan');
        $tglmulai = $this->request->getPost('tglmulai');
        $tglakhir = $this->request->getPost('tglakhir');

        $db = db_connect();

        $karyawan = $db->table('karyawan')
            ->where('idkaryawan', $idkaryawan)
            ->get()
            ->getRowArray();

        if (!$karyawan) {
            return redirect()->back()->with('error', 'Karyawan tidak ditemukan');
        }

        $pencucianList = $db->table('detail_kendaraan')
            ->select('detail_kendaraan.id, detail_kendaraan.platnomor, reservasi.tgl,
                     paket_cucian.namapaket, paket_cucian.upah')
            ->join('reservasi', 'reservasi.idreservasi = detail_kendaraan.idreservasi')
            ->join('detail_paket', 'detail_paket.id_detail_kendaraan = detail_kendaraan.id')
            ->join('paket_cucian', 'paket_cucian.idpaket = detail_paket.idpaket')
            ->where('detail_kendaraan.idkaryawan', $idkaryawan)
            ->where('detail_kendaraan.status', 'selesai')
            ->where('reservasi.tgl >=', $tglmulai)
            ->where('reservasi.tgl <=', $tglakhir)
            ->orderBy('reservasi.tgl', 'ASC')
            ->get()
            ->getResultArray();

        $totalUpah = 0;
        foreach ($pencucianList as $p) {
            $totalUpah += ($p['upah'] ?? 0);
        }

        return view('laporan/transaksi/cetakslipgaji', [
            'karyawan' => $karyawan,
            'pencucianList' => $pencucianList,
            'totalUpah' => $totalUpah,
            'tglmulai' => $tglmulai,
            'tglakhir' => $tglakhir
        ]);
    }

    public function LaporanReservasi()
    {
        $data['title'] = 'Laporan Reservasi';
        return view('laporan/reservasi/reservasi', $data);
    }


    public function viewallLaporanReservasiTanggal()
    {
        $tglmulai = $this->request->getPost('tglmulai');
        $tglakhir = $this->request->getPost('tglakhir');
        $db = db_connect();
        
        // Adaptasi query dari ReservasiController->detail() method dengan join yang tepat
        $reservasi = $db->table('reservasi')
            ->select('
                reservasi.idbooking,
                reservasi.created_at as tanggal_booking, 
                reservasi.tglcheckin, 
                reservasi.tglcheckout, 
                reservasi.status,
                reservasi.tipe,
                reservasi.totalbayar,
                tamu.nama as nama_tamu,
                kamar.id_kamar as kode_kamar,
                kamar.nama as nama_kamar, 
                kamar.harga
            ')
            ->join('tamu', 'tamu.nik = reservasi.nik', 'left')
            ->join('kamar', 'kamar.id_kamar = reservasi.idkamar', 'left')
            ->where('reservasi.tglcheckin >=', $tglmulai)
            ->where('reservasi.tglcheckin <=', $tglakhir)
            ->orderBy('reservasi.idbooking', 'DESC')
            ->get()
            ->getResultArray();
            
        $data = [
            'reservasi' => $reservasi,
            'tglmulai' => $tglmulai,
            'tglakhir' => $tglakhir,
        ];
        $response = [
            'data' => view('laporan/reservasi/viewreservasi', $data),
        ];

        echo json_encode($response);
    }

    public function viewallLaporanReservasiBulan()
    {
        $bulanawal = $this->request->getPost('bulanawal');
        $bulanakhir = $this->request->getPost('bulanakhir');
        
        $db = db_connect();
        
        // Adaptasi query dari ReservasiController->detail() method dengan join yang tepat
        $reservasi = $db->table('reservasi')
            ->select('
                reservasi.idbooking,
                reservasi.created_at as tanggal_booking, 
                reservasi.tglcheckin, 
                reservasi.tglcheckout, 
                reservasi.status,
                reservasi.tipe,
                reservasi.totalbayar,
                tamu.nama as nama_tamu,
                kamar.id_kamar as kode_kamar,
                kamar.nama as nama_kamar, 
                kamar.harga
            ')
            ->join('tamu', 'tamu.nik = reservasi.nik', 'left')
            ->join('kamar', 'kamar.id_kamar = reservasi.idkamar', 'left')
            ->where('reservasi.tglcheckin >=', $bulanawal . '-01')
            ->where('reservasi.tglcheckin <=', $bulanakhir . '-31')
            ->orderBy('reservasi.idbooking', 'DESC')
            ->get()
            ->getResultArray();
            
        $data = [
            'reservasi' => $reservasi,
            'bulanawal' => $bulanawal,
            'bulanakhir' => $bulanakhir,
        ];
        $response = [
            'data' => view('laporan/reservasi/viewreservasi', $data),
        ];

        echo json_encode($response);
    }

    public function LaporanCheckin()
    {
        $data['title'] = 'Laporan Checkin';
        return view('laporan/checkin/checkin', $data);
    }

    public function viewallLaporanCheckinTanggal()
    {
        $tglmulai = $this->request->getPost('tglmulai');
        $tglakhir = $this->request->getPost('tglakhir');
        $db = db_connect();
        
        // Adaptasi query dari CheckinController->detail() method dengan join yang tepat
        $checkin = $db->table('checkin')
            ->select('
                checkin.idcheckin,
                checkin.idbooking,
                checkin.sisabayar,
                checkin.deposit,
                checkin.created_at as tanggal_checkin,
                reservasi.totalbayar,
                reservasi.tglcheckin,
                tamu.nama as nama_tamu,
                kamar.id_kamar as kode_kamar,
                kamar.harga
            ')
            ->join('reservasi', 'reservasi.idbooking = checkin.idbooking', 'left')
            ->join('tamu', 'tamu.nik = reservasi.nik', 'left')
            ->join('kamar', 'kamar.id_kamar = reservasi.idkamar', 'left')
            ->where('checkin.created_at >=', $tglmulai)
            ->where('checkin.created_at <=', $tglakhir)
            ->orderBy('checkin.idcheckin', 'DESC')
            ->get()
            ->getResultArray();
            
        $data = [
            'checkin' => $checkin,
            'tglmulai' => $tglmulai,
            'tglakhir' => $tglakhir,
        ];
        $response = [
            'data' => view('laporan/checkin/viewcheckin', $data),
        ];

        echo json_encode($response);
    }

    public function viewallLaporanCheckinBulan()
    {
        $bulanawal = $this->request->getPost('bulanawal');
        $bulanakhir = $this->request->getPost('bulanakhir');
        
        $db = db_connect();
        
        // Adaptasi query dari CheckinController->detail() method dengan join yang tepat
        $checkin = $db->table('checkin')
            ->select('
                checkin.idcheckin,
                checkin.idbooking,
                checkin.sisabayar,
                checkin.deposit,
                checkin.created_at as tanggal_checkin,
                reservasi.totalbayar,
                reservasi.tglcheckin,
                tamu.nama as nama_tamu,
                kamar.id_kamar as kode_kamar,
                kamar.harga
            ')
            ->join('reservasi', 'reservasi.idbooking = checkin.idbooking', 'left')
            ->join('tamu', 'tamu.nik = reservasi.nik', 'left')
            ->join('kamar', 'kamar.id_kamar = reservasi.idkamar', 'left')
            ->where('checkin.created_at >=', $bulanawal . '-01')
            ->where('checkin.created_at <=', $bulanakhir . '-31')
            ->orderBy('checkin.idcheckin', 'DESC')
            ->get()
            ->getResultArray();
            
        $data = [
            'checkin' => $checkin,
            'bulanawal' => $bulanawal,
            'bulanakhir' => $bulanakhir,
        ];
        $response = [
            'data' => view('laporan/checkin/viewcheckin', $data),
        ];

        echo json_encode($response);
    }

    public function LaporanCheckout()
    {
        $data['title'] = 'Laporan Checkout';
        return view('laporan/checkout/checkout', $data);
    }

    public function viewallLaporanCheckoutTanggal()
    {
        $tglmulai = $this->request->getPost('tglmulai');
        $tglakhir = $this->request->getPost('tglakhir');
        $db = db_connect();
        
        // Adaptasi query dari CheckoutController->detail() method dengan join yang tepat
        $checkout = $db->table('checkout')
            ->select('
                checkout.idcheckout,
                checkout.idcheckin,
                checkout.tglcheckout,
                checkout.potongan,
                checkout.keterangan,
                checkin.deposit,
                reservasi.tglcheckin,
                tamu.nama as nama_tamu,
                kamar.id_kamar as kode_kamar
            ')
            ->join('checkin', 'checkin.idcheckin = checkout.idcheckin', 'left')
            ->join('reservasi', 'reservasi.idbooking = checkin.idbooking', 'left')
            ->join('tamu', 'tamu.nik = reservasi.nik', 'left')
            ->join('kamar', 'kamar.id_kamar = reservasi.idkamar', 'left')
            ->where('checkout.tglcheckout >=', $tglmulai)
            ->where('checkout.tglcheckout <=', $tglakhir . ' 23:59:59')
            ->orderBy('checkout.idcheckout', 'DESC')
            ->get()
            ->getResultArray();
            
        $data = [
            'checkout' => $checkout,
            'tglmulai' => $tglmulai,
            'tglakhir' => $tglakhir,
        ];
        $response = [
            'data' => view('laporan/checkout/viewcheckout', $data),
        ];

        echo json_encode($response);
    }

    public function viewallLaporanCheckoutBulan()
    {
        $bulanawal = $this->request->getPost('bulanawal');
        $bulanakhir = $this->request->getPost('bulanakhir');
        
        $db = db_connect();
        
        // Adaptasi query dari CheckoutController->detail() method dengan join yang tepat
        $checkout = $db->table('checkout')
            ->select('
                checkout.idcheckout,
                checkout.idcheckin,
                checkout.tglcheckout,
                checkout.potongan,
                checkout.keterangan,
                checkin.deposit,
                reservasi.tglcheckin,
                tamu.nama as nama_tamu,
                kamar.id_kamar as kode_kamar
            ')
            ->join('checkin', 'checkin.idcheckin = checkout.idcheckin', 'left')
            ->join('reservasi', 'reservasi.idbooking = checkin.idbooking', 'left')
            ->join('tamu', 'tamu.nik = reservasi.nik', 'left')
            ->join('kamar', 'kamar.id_kamar = reservasi.idkamar', 'left')
            ->where('checkout.tglcheckout >=', $bulanawal . '-01')
            ->where('checkout.tglcheckout <=', $bulanakhir . '-31 23:59:59')
            ->orderBy('checkout.idcheckout', 'DESC')
            ->get()
            ->getResultArray();
            
        $data = [
            'checkout' => $checkout,
            'bulanawal' => $bulanawal,
            'bulanakhir' => $bulanakhir,
        ];
        $response = [
            'data' => view('laporan/checkout/viewcheckout', $data),
        ];

        echo json_encode($response);
    }

    public function LaporanPendapatan()
    {
        $data['title'] = 'Laporan Pendapatan Bersih';
        return view('laporan/pendapatan/pendapatan', $data);
    }

    public function viewallLaporanPendapatanTanggal()
    {
        $tglmulai = $this->request->getPost('tglmulai');
        $tglakhir = $this->request->getPost('tglakhir');
        $db = db_connect();
        
        // Query dengan logika pendapatan yang benar:
        // Pendapatan Checkin = DP + Sisa Bayar
        // Pendapatan Checkout = Potongan (hanya jika ada transaksi checkout)
        // Total = Pendapatan Checkin + Pendapatan Checkout
        $pendapatan = $db->query("
            SELECT 
                dates.tanggal,
                (COALESCE(reservasi_data.total_dp, 0) + COALESCE(checkin_data.total_sisabayar, 0)) as total_checkin,
                COALESCE(checkout_data.total_potongan, 0) as total_checkout,
                ((COALESCE(reservasi_data.total_dp, 0) + COALESCE(checkin_data.total_sisabayar, 0)) + COALESCE(checkout_data.total_potongan, 0)) as total_bersih
            FROM (
                SELECT DISTINCT DATE(created_at) as tanggal FROM checkin WHERE DATE(created_at) BETWEEN ? AND ?
            ) dates
            LEFT JOIN (
                SELECT DATE(checkin.created_at) as tanggal, SUM(checkin.sisabayar) as total_sisabayar
                FROM checkin 
                WHERE DATE(checkin.created_at) BETWEEN ? AND ?
                GROUP BY DATE(checkin.created_at)
            ) checkin_data ON dates.tanggal = checkin_data.tanggal
            LEFT JOIN (
                SELECT DATE(checkin.created_at) as tanggal, SUM(reservasi.totalbayar) as total_dp
                FROM checkin 
                JOIN reservasi ON reservasi.idbooking = checkin.idbooking
                WHERE DATE(checkin.created_at) BETWEEN ? AND ?
                GROUP BY DATE(checkin.created_at)
            ) reservasi_data ON dates.tanggal = reservasi_data.tanggal
            LEFT JOIN (
                SELECT DATE(checkin.created_at) as tanggal, SUM(COALESCE(checkout.potongan, 0)) as total_potongan
                FROM checkin
                INNER JOIN checkout ON checkout.idcheckin = checkin.idcheckin
                JOIN reservasi ON reservasi.idbooking = checkin.idbooking
                WHERE DATE(checkin.created_at) BETWEEN ? AND ?
                AND reservasi.status != 'checkin'
                GROUP BY DATE(checkin.created_at)
            ) checkout_data ON dates.tanggal = checkout_data.tanggal
            WHERE (COALESCE(reservasi_data.total_dp, 0) + COALESCE(checkin_data.total_sisabayar, 0)) > 0
            ORDER BY dates.tanggal ASC
        ", [$tglmulai, $tglakhir, $tglmulai, $tglakhir, $tglmulai, $tglakhir, $tglmulai, $tglakhir])->getResultArray();
            
        $data = [
            'pendapatan' => $pendapatan,
            'tglmulai' => $tglmulai,
            'tglakhir' => $tglakhir,
        ];
        $response = [
            'data' => view('laporan/pendapatan/viewpendapatan', $data),
        ];

        echo json_encode($response);
    }

  
    public function viewallLaporanPendapatanTahun()
    {
        $tahun = $this->request->getPost('tahun');
        
        $db = db_connect();
        
        // Query dengan logika pendapatan yang benar:
        // Pendapatan Checkin = DP + Sisa Bayar
        // Pendapatan Checkout = Potongan (hanya jika ada transaksi checkout)
        // Total = Pendapatan Checkin + Pendapatan Checkout
        $pendapatanPerBulan = $db->query("
            SELECT 
                bulan_data.bulan,
                (COALESCE(reservasi_data.total_dp_bulan, 0) + COALESCE(checkin_data.total_sisabayar_bulan, 0)) as total_checkin_bulan,
                COALESCE(checkout_data.total_potongan_bulan, 0) as total_checkout_bulan,
                ((COALESCE(reservasi_data.total_dp_bulan, 0) + COALESCE(checkin_data.total_sisabayar_bulan, 0)) + COALESCE(checkout_data.total_potongan_bulan, 0)) as total_bersih_bulan
            FROM (
                SELECT DISTINCT MONTH(created_at) as bulan FROM checkin WHERE YEAR(created_at) = ?
            ) bulan_data
            LEFT JOIN (
                SELECT MONTH(checkin.created_at) as bulan, SUM(checkin.sisabayar) as total_sisabayar_bulan
                FROM checkin 
                WHERE YEAR(checkin.created_at) = ?
                GROUP BY MONTH(checkin.created_at)
            ) checkin_data ON bulan_data.bulan = checkin_data.bulan
            LEFT JOIN (
                SELECT MONTH(checkin.created_at) as bulan, SUM(reservasi.totalbayar) as total_dp_bulan
                FROM checkin 
                JOIN reservasi ON reservasi.idbooking = checkin.idbooking
                WHERE YEAR(checkin.created_at) = ?
                GROUP BY MONTH(checkin.created_at)
            ) reservasi_data ON bulan_data.bulan = reservasi_data.bulan
            LEFT JOIN (
                SELECT MONTH(checkin.created_at) as bulan, SUM(COALESCE(checkout.potongan, 0)) as total_potongan_bulan
                FROM checkin
                INNER JOIN checkout ON checkout.idcheckin = checkin.idcheckin
                JOIN reservasi ON reservasi.idbooking = checkin.idbooking
                WHERE YEAR(checkin.created_at) = ?
                AND reservasi.status != 'checkin'
                GROUP BY MONTH(checkin.created_at)
            ) checkout_data ON bulan_data.bulan = checkout_data.bulan
            WHERE (COALESCE(reservasi_data.total_dp_bulan, 0) + COALESCE(checkin_data.total_sisabayar_bulan, 0)) > 0
            ORDER BY bulan_data.bulan ASC
        ", [$tahun, $tahun, $tahun, $tahun])->getResultArray();
        
        $data = [
            'pendapatanPerBulan' => $pendapatanPerBulan,
            'tahun' => $tahun,
            'isLaporanTahun' => true
        ];
        $response = [
            'data' => view('laporan/pendapatan/viewpendapatan', $data),
        ];

        echo json_encode($response);
    }

    // Laporan Transaksi Pencucian (tanpa informasi harga)
    public function LaporanPencucian()
    {
        return view('laporan/transaksi/pencucian');
    }

    public function viewallLaporanPencucian()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();

            $pencucian = $db->table('detail_kendaraan fk')
                ->select('
                    f.idreservasi,
                    f.tgl as tglpencucian,
                    f.jamdatang,
                    fk.status,
                    p.nama as nama_pelanggan,
                    fk.platnomor,
                    k.nama as nama_karyawan,
                    GROUP_CONCAT(pc.namapaket SEPARATOR ", ") as namapaket,
                    GROUP_CONCAT(pc.jenis SEPARATOR ", ") as jenis
                ')
                ->join('reservasi f', 'f.idreservasi = fk.idreservasi')
                ->join('pelanggan p', 'p.idpelanggan = f.idpelanggan', 'left')
                ->join('karyawan k', 'k.idkaryawan = fk.idkaryawan', 'left')
                ->join('detail_paket fp', 'fp.id_detail_kendaraan = fk.id', 'left')
                ->join('paket_cucian pc', 'pc.idpaket = fp.idpaket', 'left')
                ->groupBy('fk.id')
                ->orderBy('f.tgl', 'DESC')
                ->orderBy('f.idreservasi', 'DESC')
                ->get()
                ->getResultArray();

            $data = [
                'pencucian' => $pencucian
            ];

            $response = [
                'data' => view('laporan/transaksi/viewpencucian', $data)
            ];

            return $this->response->setJSON($response);
        }
    }

    public function viewallLaporanPencucianTanggal()
    {
        if ($this->request->isAJAX()) {
            $tglmulai = $this->request->getPost('tglmulai');
            $tglakhir = $this->request->getPost('tglakhir');

            $db = db_connect();

            $pencucian = $db->table('detail_kendaraan fk')
                ->select('
                    f.idreservasi,
                    f.tgl as tglpencucian,
                    f.jamdatang,
                    fk.status,
                    p.nama as nama_pelanggan,
                    fk.platnomor,
                    k.nama as nama_karyawan,
                    GROUP_CONCAT(pc.namapaket SEPARATOR ", ") as namapaket,
                    GROUP_CONCAT(pc.jenis SEPARATOR ", ") as jenis
                ')
                ->join('reservasi f', 'f.idreservasi = fk.idreservasi')
                ->join('pelanggan p', 'p.idpelanggan = f.idpelanggan', 'left')
                ->join('karyawan k', 'k.idkaryawan = fk.idkaryawan', 'left')
                ->join('detail_paket fp', 'fp.id_detail_kendaraan = fk.id', 'left')
                ->join('paket_cucian pc', 'pc.idpaket = fp.idpaket', 'left')
                ->where('f.tgl >=', $tglmulai)
                ->where('f.tgl <=', $tglakhir)
                ->groupBy('fk.id')
                ->orderBy('f.tgl', 'DESC')
                ->orderBy('f.idreservasi', 'DESC')
                ->get()
                ->getResultArray();

            $data = [
                'pencucian' => $pencucian,
                'tglmulai' => $tglmulai,
                'tglakhir' => $tglakhir
            ];

            $response = [
                'data' => view('laporan/transaksi/viewpencucian', $data)
            ];

            return $this->response->setJSON($response);
        }
    }

    public function viewallLaporanPencucianBulan()
    {
        if ($this->request->isAJAX()) {
            $bulan = $this->request->getPost('bulan');
            $tahun = $this->request->getPost('tahun');

            $db = db_connect();

            $pencucian = $db->table('detail_kendaraan fk')
                ->select('
                    f.idreservasi,
                    f.tgl as tglpencucian,
                    f.jamdatang,
                    fk.status,
                    p.nama as nama_pelanggan,
                    fk.platnomor,
                    k.nama as nama_karyawan,
                    GROUP_CONCAT(pc.namapaket SEPARATOR ", ") as namapaket,
                    GROUP_CONCAT(pc.jenis SEPARATOR ", ") as jenis
                ')
                ->join('reservasi f', 'f.idreservasi = fk.idreservasi')
                ->join('pelanggan p', 'p.idpelanggan = f.idpelanggan', 'left')
                ->join('karyawan k', 'k.idkaryawan = fk.idkaryawan', 'left')
                ->join('detail_paket fp', 'fp.id_detail_kendaraan = fk.id', 'left')
                ->join('paket_cucian pc', 'pc.idpaket = fp.idpaket', 'left')
                ->where('MONTH(f.tgl)', $bulan)
                ->where('YEAR(f.tgl)', $tahun)
                ->groupBy('fk.id')
                ->orderBy('f.tgl', 'DESC')
                ->orderBy('f.idreservasi', 'DESC')
                ->get()
                ->getResultArray();

            $data = [
                'pencucian' => $pencucian,
                'bulan' => $bulan,
                'tahun' => $tahun
            ];

            $response = [
                'data' => view('laporan/transaksi/viewpencucian', $data)
            ];

            return $this->response->setJSON($response);
        }
    }

    // Laporan Transaksi Selesai (dengan informasi keuangan lengkap)
    public function LaporanSelesai()
    {
        return view('laporan/transaksi/selesai');
    }

    public function viewallLaporanSelesai()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();

            $selesai = $db->table('kendaraan_selesai')
                ->select('
                    kendaraan_selesai.idselesai,
                    kendaraan_selesai.totalbayar,
                    reservasi.idreservasi,
                    detail_kendaraan.platnomor,
                    pelanggan.nama as nama_pelanggan
                ')
                ->join('detail_kendaraan', 'detail_kendaraan.id = kendaraan_selesai.id_detail_kendaraan')
                ->join('reservasi', 'reservasi.idreservasi = detail_kendaraan.idreservasi')
                ->join('pelanggan', 'pelanggan.idpelanggan = reservasi.idpelanggan', 'left')
                ->orderBy('kendaraan_selesai.idselesai', 'DESC')
                ->get()
                ->getResultArray();

            $data = [
                'selesai' => $selesai
            ];

            $response = [
                'data' => view('laporan/transaksi/viewselesai', $data)
            ];

            return $this->response->setJSON($response);
        }
    }

    public function viewallLaporanSelesaiTanggal()
    {
        if ($this->request->isAJAX()) {
            $tglmulai = $this->request->getPost('tglmulai');
            $tglakhir = $this->request->getPost('tglakhir');

            $db = db_connect();

            $selesai = $db->table('kendaraan_selesai')
                ->select('
                    kendaraan_selesai.idselesai,
                    kendaraan_selesai.totalbayar,
                    reservasi.idreservasi,
                    reservasi.tgl as tglpencucian,
                    detail_kendaraan.platnomor,
                    pelanggan.nama as nama_pelanggan
                ')
                ->join('detail_kendaraan', 'detail_kendaraan.id = kendaraan_selesai.id_detail_kendaraan')
                ->join('reservasi', 'reservasi.idreservasi = detail_kendaraan.idreservasi')
                ->join('pelanggan', 'pelanggan.idpelanggan = reservasi.idpelanggan', 'left')
                ->where('reservasi.tgl >=', $tglmulai)
                ->where('reservasi.tgl <=', $tglakhir)
                ->orderBy('kendaraan_selesai.idselesai', 'DESC')
                ->get()
                ->getResultArray();

            $data = [
                'selesai' => $selesai,
                'tglmulai' => $tglmulai,
                'tglakhir' => $tglakhir
            ];

            $response = [
                'data' => view('laporan/transaksi/viewselesai', $data)
            ];

            return $this->response->setJSON($response);
        }
    }

    public function viewallLaporanSelesaiBulan()
    {
        if ($this->request->isAJAX()) {
            $bulan = $this->request->getPost('bulan');
            $tahun = $this->request->getPost('tahun');

            $db = db_connect();

            $selesai = $db->table('kendaraan_selesai')
                ->select('
                    kendaraan_selesai.idselesai,
                    kendaraan_selesai.totalbayar,
                    reservasi.idreservasi,
                    reservasi.tgl as tglpencucian,
                    detail_kendaraan.platnomor,
                    pelanggan.nama as nama_pelanggan
                ')
                ->join('detail_kendaraan', 'detail_kendaraan.id = kendaraan_selesai.id_detail_kendaraan')
                ->join('reservasi', 'reservasi.idreservasi = detail_kendaraan.idreservasi')
                ->join('pelanggan', 'pelanggan.idpelanggan = reservasi.idpelanggan', 'left')
                ->where('MONTH(reservasi.tgl)', $bulan)
                ->where('YEAR(reservasi.tgl)', $tahun)
                ->orderBy('kendaraan_selesai.idselesai', 'DESC')
                ->get()
                ->getResultArray();

            $data = [
                'selesai' => $selesai,
                'bulan' => $bulan,
                'tahun' => $tahun
            ];

            $response = [
                'data' => view('laporan/transaksi/viewselesai', $data)
            ];

            return $this->response->setJSON($response);
        }
    }
}
