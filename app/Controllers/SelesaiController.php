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
                         pencucian.idpencucian,
                         pencucian.tgl,
                         pelanggan.nama as nama_pelanggan, 
                         pelanggan.platnomor,
                         paket_cucian.namapaket,')
                ->join('pencucian', 'pencucian.idpencucian = kendaraan_selesai.idpencucian')
                ->join('pelanggan', 'pelanggan.idpelanggan = pencucian.idpelanggan')
                ->join('paket_cucian', 'paket_cucian.idpaket = pencucian.idpaket');

            return DataTable::of($selesai)
                ->add('action', function ($row) {
                    $button1 = '<button type="button" class="btn btn-primary btn-sm btn-detail" data-idselesai="' . $row->idselesai . '"><i class="fas fa-eye"></i></button>';
                    $button2 = '<button type="button" class="btn btn-secondary btn-sm btn-edit" data-idselesai="' . $row->idselesai . '" style="margin-left: 5px;"><i class="fas fa-pencil-alt"></i></button>';
                    $button3 = '<button type="button" class="btn btn-danger btn-sm btn-delete" data-idselesai="' . $row->idselesai . '" style="margin-left: 5px;"><i class="fas fa-trash"></i></button>';
                    
                    $buttonsGroup = '<div style="display: flex;">' . $button1 . $button2 . $button3 . '</div>';
                    return $buttonsGroup;
                }, 'last')
                ->addNumbering()
                ->toJson();
        }
    }

    public function formtambah()
    {
        $db = db_connect();
        
        // Generate ID Selesai
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
            $pencucian = $db->table('pencucian')
                ->select('pencucian.idpencucian, 
                         pencucian.tgl, 
                         pencucian.jamdatang,
                         pelanggan.nama as nama_pelanggan, 
                         pelanggan.platnomor,
                         paket_cucian.namapaket, 
                         paket_cucian.harga,
                         karyawan.nama as nama_karyawan')
                ->join('pelanggan', 'pelanggan.idpelanggan = pencucian.idpelanggan')
                ->join('paket_cucian', 'paket_cucian.idpaket = pencucian.idpaket')
                ->join('karyawan', 'karyawan.idkaryawan = pencucian.idkaryawan')
                ->where('pencucian.status', 'dijemput')
                ->whereNotIn('pencucian.idpencucian', function($builder) {
                    return $builder->select('idpencucian')->from('kendaraan_selesai');
                });

            return DataTable::of($pencucian)
                ->add('action', function ($row) {
                    $button1 = '<button type="button" class="btn btn-primary btn-pilihpencucian" 
                                data-idpencucian="' . $row->idpencucian . '" 
                                data-nama_pelanggan="' . esc($row->nama_pelanggan) . '"
                                data-platnomor="' . esc($row->platnomor) . '"
                                data-namapaket="' . esc($row->namapaket) . '"
                                data-harga="' . $row->harga . '"
                                data-nama_karyawan="' . esc($row->nama_karyawan) . '"
                                data-tgl="' . $row->tgl . '"
                                data-jamdatang="' . $row->jamdatang . '">Pilih</button>';
                    return $button1;
                }, 'last')
                ->addNumbering()
                ->edit('harga', function ($row) {
                    return 'Rp. ' . number_format($row->harga, 0, ',', '.');
                })
                ->toJson();
        }
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $idselesai = $this->request->getPost('idselesai');
            $idpencucian = $this->request->getPost('idpencucian');
            $jamjemput = $this->request->getPost('jamjemput');
            $totalbayar = $this->request->getPost('totalbayar');
            $totaldibayar = $this->request->getPost('totaldibayar');

            $rules = [
                'idpencucian' => [
                    'label' => 'Pencucian',
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
                
                // Insert ke tabel kendaraan_selesai
                $db->table('kendaraan_selesai')->insert([
                    'idselesai' => $idselesai,
                    'idpencucian' => $idpencucian,
                    'jamjemput' => $jamjemput,
                    'totalbayar' => $totalbayar,
                    'totaldibayar' => $totaldibayar,
                ]);

                // Update status pencucian menjadi 'selesai'
                $db->table('pencucian')
                   ->where('idpencucian', $idpencucian)
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
            
            // Ambil data selesai untuk mendapatkan idpencucian
            $selesai = $db->table('kendaraan_selesai')
                         ->where('idselesai', $idselesai)
                         ->get()
                         ->getRowArray();
            
            if ($selesai) {
                // Hapus dari kendaraan_selesai
                $db->table('kendaraan_selesai')->where('idselesai', $idselesai)->delete();
                
                // Update status pencucian kembali ke 'dijemput'
                $db->table('pencucian')
                   ->where('idpencucian', $selesai['idpencucian'])
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
        
        // Join tabel kendaraan_selesai dengan pencucian, pelanggan, paket, dan karyawan
        $selesaiQuery = $db
            ->table('kendaraan_selesai')
            ->select('kendaraan_selesai.*, 
                     pencucian.idpencucian,
                     pencucian.tgl,
                     pencucian.jamdatang,
                     pencucian.status,
                     pelanggan.nama as nama_pelanggan, 
                     pelanggan.alamat, 
                     pelanggan.nohp, 
                     pelanggan.platnomor,
                     paket_cucian.namapaket, 
                     paket_cucian.harga, 
                     paket_cucian.jenis,
                     karyawan.nama as nama_karyawan')
            ->join('pencucian', 'pencucian.idpencucian = kendaraan_selesai.idpencucian')
            ->join('pelanggan', 'pelanggan.idpelanggan = pencucian.idpelanggan')
            ->join('paket_cucian', 'paket_cucian.idpaket = pencucian.idpaket')
            ->join('karyawan', 'karyawan.idkaryawan = pencucian.idkaryawan')
            ->where('kendaraan_selesai.idselesai', $idselesai);
        
        $selesaiData = $selesaiQuery->get()->getRowArray();

        if (!$selesaiData) {
            return redirect()->back()->with('error', 'Data kendaraan selesai tidak ditemukan');
        }

        $data = [
            'selesai' => $selesaiData
        ];

        return view('selesai/detail', $data);
    }

    public function formedit($idselesai)
    {
        $db = db_connect();
        
        // Ambil data selesai beserta data pencucian terkait
        $selesaiQuery = $db
            ->table('kendaraan_selesai')
            ->select('kendaraan_selesai.*, 
                     pencucian.idpencucian,
                     pencucian.tgl,
                     pencucian.jamdatang,
                     pencucian.status,
                     pelanggan.nama as nama_pelanggan, 
                     pelanggan.alamat, 
                     pelanggan.nohp, 
                     pelanggan.platnomor,
                     paket_cucian.namapaket, 
                     paket_cucian.harga, 
                     paket_cucian.jenis,
                     karyawan.nama as nama_karyawan')
            ->join('pencucian', 'pencucian.idpencucian = kendaraan_selesai.idpencucian')
            ->join('pelanggan', 'pelanggan.idpelanggan = pencucian.idpelanggan')
            ->join('paket_cucian', 'paket_cucian.idpaket = pencucian.idpaket')
            ->join('karyawan', 'karyawan.idkaryawan = pencucian.idkaryawan')
            ->where('kendaraan_selesai.idselesai', $idselesai);
        
        $selesaiData = $selesaiQuery->get()->getRowArray();

        if (!$selesaiData) {
            return redirect()->back()->with('error', 'Data kendaraan selesai tidak ditemukan');
        }

        $data = [
            'selesai' => $selesaiData
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
                
                // Update data kendaraan_selesai
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