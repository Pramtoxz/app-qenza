<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Selesai as ModelSelesai;
use CodeIgniter\HTTP\ResponseInterface;
use Hermawan\DataTables\DataTable;

class SelesaiController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Kelola Kendaraan Selesai'
        ];
        return view('selesai/dataselesai', $data);
    }

    public function viewSelesai()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $selesai = $db->table('kendaraan_selesai')
                ->select('kendaraan_selesai.idselesai,
                         reservasi.idreservasi,
                         reservasi.tgl,
                         pelanggan.nama as nama_pelanggan,
                         detail_kendaraan.platnomor,
                         detail_kendaraan.id as id_detail_kendaraan,
                         (SELECT GROUP_CONCAT(p.namapaket SEPARATOR " + ")
                          FROM detail_paket fp
                          JOIN paket_cucian p ON p.idpaket = fp.idpaket
                          WHERE fp.id_detail_kendaraan = detail_kendaraan.id) as namapaket')
                ->join('detail_kendaraan', 'detail_kendaraan.id = kendaraan_selesai.id_detail_kendaraan')
                ->join('reservasi', 'reservasi.idreservasi = detail_kendaraan.idreservasi')
                ->join('pelanggan', 'pelanggan.idpelanggan = reservasi.idpelanggan')
                ->orderBy('kendaraan_selesai.idselesai', 'DESC');

            return DataTable::of($selesai)
                ->add('action', function ($row) {
                    $button1 = '<button type="button" class="btn btn-primary btn-sm btn-detail" data-idselesai="' . $row->idselesai . '"><i class="ri-eye-line"></i></button>';
                    $button2 = '<button type="button" class="btn btn-secondary btn-sm btn-edit" data-idselesai="' . $row->idselesai . '" style="margin-left: 5px;"><i class="ri-pencil-line"></i></button>';
                    $button3 = '<button type="button" class="btn btn-danger btn-sm btn-delete" data-idselesai="' . $row->idselesai . '" style="margin-left: 5px;"><i class="ri-delete-bin-line"></i></button>';
                    
                    $buttonsGroup = '<div style="display: flex;">' . $button1 . $button2 . $button3 . '</div>';
                    return $buttonsGroup;
                }, 'last')
                ->hide('id_detail_kendaraan')
                ->addNumbering()
                ->toJson();
        }
    }

    public function formtambah()
    {
        $db = db_connect();
        
        $today = date('Ymd');
        $prefix = "SLS-$today-";
        
        $query = $db->query("SELECT idselesai FROM kendaraan_selesai WHERE idselesai LIKE ?", ["$prefix%"]);
        $results = $query->getResultArray();
        
        if (empty($results)) {
            $nextNo = 1;
        } else {
            $numbers = [];
            foreach ($results as $row) {
                $num = substr($row['idselesai'], strlen($prefix));
                if (is_numeric($num)) {
                    $numbers[] = (int)$num;
                }
            }
            
            if (!empty($numbers)) {
                $nextNo = max($numbers) + 1;
            } else {
                $nextNo = 1;
            }
        }
        
        $next_id = $prefix . str_pad($nextNo, 4, '0', STR_PAD_LEFT);
        
        $data = [
            'next_id' => $next_id
        ];
        return view('selesai/formtambah', $data);
    }

    public function getPencucianDijemput()
    {
        $db = db_connect();
        $pencucian = $db->query("
            SELECT 
                r.idreservasi,
                r.tgl,
                p.nama as nama_pelanggan,
                COUNT(dk.id) as jumlah_kendaraan,
                GROUP_CONCAT(dk.platnomor SEPARATOR ', ') as plat_list
            FROM detail_kendaraan dk
            JOIN reservasi r ON r.idreservasi = dk.idreservasi
            JOIN pelanggan p ON p.idpelanggan = r.idpelanggan
            WHERE dk.status = 'dijemput'
            AND dk.id NOT IN (SELECT id_detail_kendaraan FROM kendaraan_selesai)
            GROUP BY r.idreservasi, r.tgl, p.nama
            ORDER BY r.tgl DESC
        ")->getResultArray();

        return view('selesai/getpencucian', ['pencucian' => $pencucian]);
    }

    public function viewGetPencucianDijemput()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $pencucian = $db->query("
                SELECT 
                    r.idreservasi,
                    r.tgl,
                    p.nama as nama_pelanggan,
                    COUNT(dk.id) as jumlah_kendaraan,
                    GROUP_CONCAT(dk.platnomor SEPARATOR ', ') as plat_list
                FROM detail_kendaraan dk
                JOIN reservasi r ON r.idreservasi = dk.idreservasi
                JOIN pelanggan p ON p.idpelanggan = r.idpelanggan
                WHERE dk.status = 'dijemput'
                AND dk.id NOT IN (SELECT id_detail_kendaraan FROM kendaraan_selesai)
                GROUP BY r.idreservasi, r.tgl, p.nama
                ORDER BY r.tgl DESC
            ")->getResultArray();

            $data = ['pencucian' => $pencucian];
            return view('selesai/getpencucian', $data);
        }
    }

    public function getKendaraanByFaktur()
    {
        if ($this->request->isAJAX()) {
            $idreservasi = $this->request->getGet('idreservasi');
            $db = db_connect();

            $kendaraan = $db->table('detail_kendaraan dk')
                ->select('dk.id as id_detail_kendaraan,
                         dk.platnomor,
                         dk.status_bayar,
                         k.nama as nama_karyawan,
                         (SELECT GROUP_CONCAT(pc.namapaket SEPARATOR " + ")
                          FROM detail_paket dp
                          JOIN paket_cucian pc ON pc.idpaket = dp.idpaket
                          WHERE dp.id_detail_kendaraan = dk.id) as namapaket,
                         (SELECT SUM(pc.harga)
                          FROM detail_paket dp
                          JOIN paket_cucian pc ON pc.idpaket = dp.idpaket
                          WHERE dp.id_detail_kendaraan = dk.id) as harga')
                ->join('karyawan k', 'k.idkaryawan = dk.idkaryawan', 'left')
                ->where('dk.idreservasi', $idreservasi)
                ->where('dk.status', 'dijemput')
                ->whereNotIn('dk.id', function($builder) {
                    return $builder->select('id_detail_kendaraan')->from('kendaraan_selesai');
                })
                ->get()
                ->getResultArray();

            $belumBayar = array_filter($kendaraan, fn($k) => $k['status_bayar'] === 'belum');
            $totalBelumBayar = array_sum(array_column($belumBayar, 'harga'));

            $sudahDibayar = $db->table('kendaraan_selesai ks')
                ->select('COALESCE(SUM(ks.totaldibayar), 0) as total')
                ->join('detail_kendaraan dk', 'dk.id = ks.id_detail_kendaraan')
                ->where('dk.idreservasi', $idreservasi)
                ->get()
                ->getRowArray();

            return $this->response->setJSON([
                'kendaraan' => $kendaraan,
                'total_belum_bayar' => $totalBelumBayar,
                'sudah_dibayar' => $sudahDibayar['total'] ?? 0
            ]);
        }
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $idselesai = $this->request->getPost('idselesai');
            $idKendaraanList = $this->request->getPost('id_kendaraan_list');
            $jamjemput = $this->request->getPost('jamjemput');
            $totalbayar = $this->request->getPost('totalbayar');
            $totaldibayar = $this->request->getPost('totaldibayar');

            if (empty($idKendaraanList) || !is_array($idKendaraanList)) {
                return $this->response->setJSON(['error' => 'Pilih minimal 1 kendaraan']);
            }

            if (empty($jamjemput)) {
                return $this->response->setJSON(['error' => 'Jam jemput tidak boleh kosong']);
            }

            $db = db_connect();
            $db->transStart();

            $today = date('Ymd');
            $prefix = "SLS-$today-";
            $counter = 0;

            $query = $db->query("SELECT idselesai FROM kendaraan_selesai WHERE idselesai LIKE ?", ["$prefix%"]);
            $existing = $query->getResultArray();
            $numbers = [];
            foreach ($existing as $row) {
                $num = substr($row['idselesai'], strlen($prefix));
                if (is_numeric($num)) $numbers[] = (int)$num;
            }
            $nextNo = !empty($numbers) ? max($numbers) + 1 : 1;

            foreach ($idKendaraanList as $idKendaraan) {
                $kendaraan = $db->table('detail_kendaraan')
                    ->where('id', $idKendaraan)
                    ->get()->getRowArray();

                if (!$kendaraan || $kendaraan['status'] !== 'dijemput') continue;

                $idselesaiItem = $prefix . str_pad($nextNo + $counter, 4, '0', STR_PAD_LEFT);
                $counter++;

                $harga = 0;
                $paketList = $db->table('detail_paket dp')
                    ->select('SUM(pc.harga) as total')
                    ->join('paket_cucian pc', 'pc.idpaket = dp.idpaket')
                    ->where('dp.id_detail_kendaraan', $idKendaraan)
                    ->get()->getRowArray();
                $harga = $paketList['total'] ?? 0;

                $db->table('kendaraan_selesai')->insert([
                    'idselesai' => $idselesaiItem,
                    'id_detail_kendaraan' => $idKendaraan,
                    'jamjemput' => $jamjemput,
                    'totalbayar' => $harga,
                    'totaldibayar' => $totaldibayar,
                ]);

                $db->table('detail_kendaraan')
                   ->where('id', $idKendaraan)
                   ->update(['status' => 'selesai', 'status_bayar' => 'lunas']);
            }

            $idreservasi = $kendaraan['idreservasi'] ?? null;
            if ($idreservasi) {
                $totalKendaraan = $db->table('detail_kendaraan')
                    ->where('idreservasi', $idreservasi)->countAllResults();
                $selesaiCount = $db->table('detail_kendaraan')
                    ->where('idreservasi', $idreservasi)
                    ->where('status', 'selesai')->countAllResults();

                if ($totalKendaraan > 0 && $totalKendaraan === $selesaiCount) {
                    $db->table('reservasi')
                       ->where('idreservasi', $idreservasi)
                       ->update(['status_bayar' => 'lunas']);
                }
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                return $this->response->setJSON(['error' => 'Gagal menyimpan data']);
            }

            return $this->response->setJSON([
                'sukses' => $counter . ' kendaraan berhasil di-checkout',
                'idselesai' => $idselesai
            ]);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $idselesai = $this->request->getPost('idselesai');

            $db = db_connect();
            
            $selesai = $db->table('kendaraan_selesai')
                         ->where('idselesai', $idselesai)
                         ->get()
                         ->getRowArray();
            
            if ($selesai) {
                $kendaraan = $db->table('detail_kendaraan')
                    ->select('idreservasi')
                    ->where('id', $selesai['id_detail_kendaraan'])
                    ->get()->getRowArray();

                $db->table('kendaraan_selesai')->where('idselesai', $idselesai)->delete();
                
                $db->table('detail_kendaraan')
                   ->where('id', $selesai['id_detail_kendaraan'])
                   ->update(['status' => 'dijemput']);

                if ($kendaraan) {
                    $db->table('reservasi')
                       ->where('idreservasi', $kendaraan['idreservasi'])
                       ->update(['status_bayar' => 'belum']);
                }
            }
            
            $json = [
                'sukses' => 'Data Kendaraan Selesai Berhasil Dihapus'
            ];

            return $this->response->setJSON($json);
        }
    }

    public function detail($idselesai)
    {
        $db = db_connect();
        
        $selesaiQuery = $db
            ->table('kendaraan_selesai')
            ->select('kendaraan_selesai.*,
                     detail_kendaraan.id as id_detail_kendaraan,
                     detail_kendaraan.platnomor,
                     detail_kendaraan.idkaryawan,
                     reservasi.idreservasi,
                     reservasi.tgl,
                     reservasi.jamdatang,
                     pelanggan.nama as nama_pelanggan,
                     pelanggan.alamat,
                     pelanggan.nohp,
                     karyawan.nama as nama_karyawan')
            ->join('detail_kendaraan', 'detail_kendaraan.id = kendaraan_selesai.id_detail_kendaraan')
            ->join('reservasi', 'reservasi.idreservasi = detail_kendaraan.idreservasi')
            ->join('pelanggan', 'pelanggan.idpelanggan = reservasi.idpelanggan')
            ->join('karyawan', 'karyawan.idkaryawan = detail_kendaraan.idkaryawan', 'left')
            ->where('kendaraan_selesai.idselesai', $idselesai);
        
        $selesaiData = $selesaiQuery->get()->getRowArray();

        if (!$selesaiData) {
            return redirect()->back()->with('error', 'Data kendaraan selesai tidak ditemukan');
        }

        $paketQuery = $db->table('detail_paket')
            ->select('paket_cucian.namapaket, paket_cucian.harga, paket_cucian.jenis, paket_cucian.upah')
            ->join('paket_cucian', 'paket_cucian.idpaket = detail_paket.idpaket')
            ->where('detail_paket.id_detail_kendaraan', $selesaiData['id_detail_kendaraan'])
            ->get()
            ->getResultArray();

        $totalHarga = 0;
        foreach ($paketQuery as $paket) {
            $totalHarga += $paket['harga'];
        }

        $data = [
            'selesai' => $selesaiData,
            'paketList' => $paketQuery,
            'totalHarga' => $totalHarga
        ];

        return view('selesai/detail', $data);
    }

    public function formedit($idselesai)
    {
        $db = db_connect();
        
        $selesaiQuery = $db
            ->table('kendaraan_selesai')
            ->select('kendaraan_selesai.*,
                     detail_kendaraan.id as id_detail_kendaraan,
                     detail_kendaraan.platnomor,
                     detail_kendaraan.idkaryawan,
                     reservasi.idreservasi,
                     reservasi.tgl,
                     reservasi.jamdatang,
                     pelanggan.nama as nama_pelanggan,
                     pelanggan.alamat,
                     pelanggan.nohp,
                     karyawan.nama as nama_karyawan')
            ->join('detail_kendaraan', 'detail_kendaraan.id = kendaraan_selesai.id_detail_kendaraan')
            ->join('reservasi', 'reservasi.idreservasi = detail_kendaraan.idreservasi')
            ->join('pelanggan', 'pelanggan.idpelanggan = reservasi.idpelanggan')
            ->join('karyawan', 'karyawan.idkaryawan = detail_kendaraan.idkaryawan', 'left')
            ->where('kendaraan_selesai.idselesai', $idselesai);
        
        $selesaiData = $selesaiQuery->get()->getRowArray();

        if (!$selesaiData) {
            return redirect()->back()->with('error', 'Data kendaraan selesai tidak ditemukan');
        }

        $paketQuery = $db->table('detail_paket')
            ->select('paket_cucian.namapaket, paket_cucian.harga, paket_cucian.jenis')
            ->join('paket_cucian', 'paket_cucian.idpaket = detail_paket.idpaket')
            ->where('detail_paket.id_detail_kendaraan', $selesaiData['id_detail_kendaraan'])
            ->get()
            ->getResultArray();

        $totalHarga = 0;
        $paketNames = [];
        foreach ($paketQuery as $paket) {
            $totalHarga += $paket['harga'];
            $paketNames[] = $paket['namapaket'];
        }

        $data = [
            'selesai' => $selesaiData,
            'paketList' => $paketQuery,
            'paketDisplay' => implode(' + ', $paketNames),
            'totalHarga' => $totalHarga
        ];

        return view('selesai/formedit', $data);
    }

    public function updatedata($idselesai = null)
    {
        if ($this->request->isAJAX()) {
            if ($idselesai === null) {
                $idselesai = $this->request->getPost('idselesai');
            }
            
            $jamjemput = $this->request->getPost('jamjemput');
            $totalbayar = $this->request->getPost('totalbayar');
            $totaldibayar = $this->request->getPost('totaldibayar');

            $rules = [
                'jamjemput' => [
                    'label' => 'Jam Jemput',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'totalbayar' => [
                    'label' => 'Total Bayar',
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'numeric' => '{field} harus berupa angka',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $errors = [];
                foreach ($rules as $field => $rule) {
                    $errors["error_$field"] = $this->validator->getError($field);
                }
                $json = [
                    'error' => $errors
                ];
            } else {
                $db = db_connect();
                
                $dataUpdate = [
                    'jamjemput' => $jamjemput,
                    'totalbayar' => $totalbayar,
                    'totaldibayar' => $totaldibayar,
                ];

                $db->table('kendaraan_selesai')
                   ->where('idselesai', $idselesai)
                   ->update($dataUpdate);

                $selesaiRow = $db->table('kendaraan_selesai')
                    ->select('id_detail_kendaraan')
                    ->where('idselesai', $idselesai)
                    ->get()->getRowArray();

                if ($selesaiRow) {
                    $kendaraan = $db->table('detail_kendaraan')
                        ->select('idreservasi')
                        ->where('id', $selesaiRow['id_detail_kendaraan'])
                        ->get()->getRowArray();

                    if ($kendaraan) {
                        $idreservasi = $kendaraan['idreservasi'];
                        $totalKendaraan = $db->table('detail_kendaraan')
                            ->where('idreservasi', $idreservasi)
                            ->countAllResults();
                        $selesaiCount = $db->table('detail_kendaraan')
                            ->where('idreservasi', $idreservasi)
                            ->where('status', 'selesai')
                            ->countAllResults();

                        $db->table('reservasi')
                           ->where('idreservasi', $idreservasi)
                           ->update(['status_bayar' => ($totalKendaraan > 0 && $totalKendaraan === $selesaiCount) ? 'lunas' : 'belum']);
                    }
                }

                $json = [
                    'sukses' => 'Data Kendaraan Selesai Berhasil Diupdate',
                    'idselesai' => $idselesai
                ];
            }

            return $this->response->setJSON($json);
        } else {
            return $this->response->setJSON(['error' => 'Akses tidak valid']);
        }
    }
}
