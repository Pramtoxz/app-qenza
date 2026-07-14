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
        return view('selesai/getpencucian');
    }

    public function viewGetPencucianDijemput()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $pencucian = $db->table('detail_kendaraan')
                ->select('detail_kendaraan.id as id_detail_kendaraan,
                         reservasi.idreservasi,
                         reservasi.tgl,
                         detail_kendaraan.platnomor,
                         pelanggan.nama as nama_pelanggan,
                         (SELECT GROUP_CONCAT(p.namapaket SEPARATOR " + ")
                          FROM detail_paket fp
                          JOIN paket_cucian p ON p.idpaket = fp.idpaket
                          WHERE fp.id_detail_kendaraan = detail_kendaraan.id) as namapaket,
                         (SELECT SUM(p.harga)
                          FROM detail_paket fp
                          JOIN paket_cucian p ON p.idpaket = fp.idpaket
                          WHERE fp.id_detail_kendaraan = detail_kendaraan.id) as harga,
                         karyawan.nama as nama_karyawan')
                ->join('reservasi', 'reservasi.idreservasi = detail_kendaraan.idreservasi')
                ->join('pelanggan', 'pelanggan.idpelanggan = reservasi.idpelanggan')
                ->join('karyawan', 'karyawan.idkaryawan = detail_kendaraan.idkaryawan', 'left')
                ->where('detail_kendaraan.status', 'dijemput')
                ->whereNotIn('detail_kendaraan.id', function($builder) {
                    return $builder->select('id_detail_kendaraan')->from('kendaraan_selesai');
                });

            return DataTable::of($pencucian)
                ->add('action', function ($row) {
                    $button1 = '<button type="button" class="btn btn-primary btn-pilihpencucian" 
                                data-id_detail_kendaraan="' . $row->id_detail_kendaraan . '" 
                                data-nama_pelanggan="' . esc($row->nama_pelanggan) . '"
                                data-platnomor="' . esc($row->platnomor) . '"
                                data-namapaket="' . esc($row->namapaket) . '"
                                data-harga="' . ($row->harga ?? 0) . '"
                                data-nama_karyawan="' . esc($row->nama_karyawan) . '"
                                data-tgl="' . $row->tgl . '">Pilih</button>';
                    return $button1;
                }, 'last')
                ->addNumbering()
                ->edit('harga', function ($row) {
                    return 'Rp. ' . number_format($row->harga ?? 0, 0, ',', '.');
                })
                ->toJson();
        }
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $idselesai = $this->request->getPost('idselesai');
            $id_detail_kendaraan = $this->request->getPost('id_detail_kendaraan');
            $jamjemput = $this->request->getPost('jamjemput');
            $totalbayar = $this->request->getPost('totalbayar');
            $totaldibayar = $this->request->getPost('totaldibayar');

            $rules = [
                'id_detail_kendaraan' => [
                    'label' => 'Faktur Kendaraan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
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
                
                $db->table('kendaraan_selesai')->insert([
                    'idselesai' => $idselesai,
                    'id_detail_kendaraan' => $id_detail_kendaraan,
                    'jamjemput' => $jamjemput,
                    'totalbayar' => $totalbayar,
                    'totaldibayar' => $totaldibayar,
                ]);

                $db->table('detail_kendaraan')
                   ->where('id', $id_detail_kendaraan)
                   ->update(['status' => 'selesai']);

                $json = [
                    'sukses' => 'Data Kendaraan Selesai Berhasil Ditambahkan',
                    'idselesai' => $idselesai
                ];
            }
            return $this->response->setJSON($json);
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
                $db->table('kendaraan_selesai')->where('idselesai', $idselesai)->delete();
                
                $db->table('detail_kendaraan')
                   ->where('id', $selesai['id_detail_kendaraan'])
                   ->update(['status' => 'dijemput']);
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
