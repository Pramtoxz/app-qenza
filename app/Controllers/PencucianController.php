<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelDetailCucianMasuk;
use App\Models\ModelCucianMasuk;
use App\Models\SatuanModel;
use App\Models\JenisCucianModel;
use CodeIgniter\HTTP\ResponseInterface;
use Hermawan\DataTables\DataTable;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\Alignment\LabelAlignment;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use App\Libraries\QRCodeGenerator;
use Endroid\QrCode\QrCode;
use App\Models\Pencucian as ModelPencucian;



class PencucianController extends BaseController
{

    /**
     * Helper function untuk auto-assign karyawan yang tersedia
     * @return string|null idkaryawan yang tersedia atau null jika semua sibuk
     */
    private function getAvailableKaryawan()
    {
        $db = db_connect();
        
        // Cari karyawan yang tidak sedang menangani pencucian dengan status 'diproses'
        $availableKaryawan = $db->table('karyawan')
            ->select('karyawan.idkaryawan')
            ->join('pencucian', 'pencucian.idkaryawan = karyawan.idkaryawan AND pencucian.status = "diproses"', 'left')
            ->where('pencucian.idkaryawan IS NULL')
            ->orderBy('karyawan.idkaryawan', 'ASC') // FIFO berdasarkan ID karyawan
            ->limit(1)
            ->get()
            ->getRowArray();
            
        return $availableKaryawan ? $availableKaryawan['idkaryawan'] : null;
    }

    /**
     * Helper function untuk generate nomor antrian harian
     * @return int nomor antrian berikutnya
     */
    private function generateNomorAntrian()
    {
        $db = db_connect();
        $today = date('Y-m-d');
        
        // Cari nomor antrian tertinggi hari ini
        $maxAntrian = $db->table('pencucian')
            ->select('MAX(nomor_antrian) as max_antrian')
            ->where('tgl', $today)
            ->get()
            ->getRowArray();
            
        return ($maxAntrian['max_antrian'] ?? 0) + 1;
    }

    /**
     * Helper function untuk auto-assign dari antrian
     * @param string $availableKaryawanId
     * @return bool
     */
    private function autoAssignFromQueue($availableKaryawanId)
    {
        $db = db_connect();
        
        // Cari pencucian yang mengantri (FIFO)
        $queuedPencucian = $db->table('pencucian')
            ->select('idpencucian')
            ->where('status', 'antri')
            ->orderBy('tgl', 'ASC')
            ->orderBy('jamdatang', 'ASC')
            ->limit(1)
            ->get()
            ->getRowArray();
            
        if ($queuedPencucian) {
            // Update pencucian dari antri ke diproses dengan karyawan yang tersedia
            $db->table('pencucian')
                ->where('idpencucian', $queuedPencucian['idpencucian'])
                ->update([
                    'idkaryawan' => $availableKaryawanId,
                    'status' => 'diproses'
                ]);
            return true;
        }
        
        return false;
    }

    public function detail($idpencucian)
    {
        $db = db_connect();
        
        // Join tabel pencucian dengan pelanggan, paket, dan karyawan
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
            ->where('pencucian.idpencucian', $idpencucian);
        
        $pencucianData = $pencucianQuery->get()->getRowArray();

        if (!$pencucianData) {
            return redirect()->back()->with('error', 'Data pencucian tidak ditemukan');
        }

        // Membuat QR Code untuk tracking pencucian
        $qrCode = QrCode::create("http://localhost:8080/pencucian/tracking/$idpencucian")
            ->setSize(300)
            ->setMargin(10);

        $writer = new PngWriter();
        $qrCodeImage = $writer->write($qrCode)->getDataUri();

        $data = [
            'qrCodeImage' => $qrCodeImage,
            'pencucian' => $pencucianData
        ];

        return view('pencucian/detail', $data);
    }

    public function index()
    {
        $title = [
            'title' => 'Kelola Pencucian'
        ];
        return view('pencucian/datapencucian', $title);
    }

    public function viewCucian()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $produk = $db->table('pencucian')
                ->select('pencucian.idpencucian,pencucian.tgl, pencucian.nomor_antrian, pelanggan.nama, pelanggan.platnomor, paket_cucian.namapaket , karyawan.nama as nama_karyawan, pencucian.status')
                ->join('pelanggan', 'pelanggan.idpelanggan = pencucian.idpelanggan')
                ->join('paket_cucian', 'paket_cucian.idpaket = pencucian.idpaket')
                ->join('karyawan', 'karyawan.idkaryawan = pencucian.idkaryawan', 'left') // LEFT JOIN untuk handle status antri
                ->groupBy('idpencucian');
            return DataTable::of($produk)
                ->add('action', function ($row) {
                    $button1 = '<button type="button" class="btn btn-primary btn-sm btn-detail" data-idpencucian="' . $row->idpencucian . '" ><i class="fas fa-eye"></i></button>';
                    $buttonsGroup = '<div style="display: flex;">' . $button1;
                    
                    // Tambahkan tombol cetak antrian jika status antri
                    if ($row->status == 'antri') {
                        $buttonCetak = '<button type="button" class="btn btn-success btn-sm btn-cetak-antrian" data-idpencucian="' . $row->idpencucian . '" style="margin-left: 5px;" title="Cetak Nomor Antrian"><i class="fas fa-print"></i></button>';
                        $buttonsGroup .= $buttonCetak;
                    }
                    
                    if ($row->status != 'selesai') {
                        if ($row->status == 'antri') {
                            // Untuk status antri, tombol untuk memproses langsung jika ada karyawan available
                            $button2 = '<button type="button" class="btn btn-info btn-sm btn-status" data-idpencucian="' . $row->idpencucian . '" style="margin-left: 5px;" title="Proses sekarang"><i class="fas fa-play"></i></button>';
                        } else {
                            // Tombol toggle status biasa
                            $button2 = '<button type="button" class="btn btn-warning btn-sm btn-status" data-idpencucian="' . $row->idpencucian . '" style="margin-left: 5px;"><i class="fas fa-sync-alt"></i></button>';
                        }
                        $button3 = '<button type="button" class="btn btn-secondary btn-sm btn-edit" data-idpencucian="' . $row->idpencucian . '" style="margin-left: 5px;"><i class="fas fa-pencil-alt"></i></button>';
                        $button4 = '<button type="button" class="btn btn-danger btn-sm btn-delete" data-idpencucian="' . $row->idpencucian . '" style="margin-left: 5px;"><i class="fas fa-trash"></i></button>';
                        $buttonsGroup .= $button2 . $button3 . $button4;
                    }
                    $buttonsGroup .= '</div>';
                    return $buttonsGroup;
                }, 'last')
                ->addNumbering()

                ->edit('nama_karyawan', function ($row) {
                    if ($row->status == 'antri') {
                        return '<span class="text-muted"><i>Menunggu karyawan...</i></span>';
                    } else {
                        return $row->nama_karyawan ?: '-';
                    }
                })
                ->hide('nomor_antrian')
                ->edit('status', function ($row) {
                    if ($row->status == 'antri') {
                        $antrianText = $row->nomor_antrian ? "Antrian #{$row->nomor_antrian}" : "Mengantri";
                        return '<span class="badge bg-secondary">' . $antrianText . '</span>';
                    } else if ($row->status == 'diproses') {
                        return '<span class="badge bg-warning">Sedang Proses</span>';
                    } else if ($row->status == 'dijemput') {
                        return '<span class="badge bg-primary">Sudah bisa Dijemput</span>';
                    } else if ($row->status == 'selesai') {
                        return '<span class="badge bg-success">Selesai</span>';
                    }
                })
                ->toJson();
        }
    }

    public function formtambah()
    {
        $db = db_connect();
        
        $debug_date = $this->request->getGet('debug_date');
        
        if (!empty($debug_date) && ENVIRONMENT !== 'production') {
            $today = date('Ymd', strtotime($debug_date));
        } else {
            $today = date('Ymd');
        }
        
        $prefix = "FKP-$today-";
        
        $query = $db->query("SELECT idpencucian FROM pencucian WHERE idpencucian LIKE ?", ["$prefix%"]);
        $results = $query->getResultArray();
        
        if (empty($results)) {
            $nextNo = 1;
        } else {
            $numbers = [];
            foreach ($results as $row) {
                $num = substr($row['idpencucian'], strlen($prefix));
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
            'next_id' => $next_id,
            'debug_date' => $debug_date
        ];
        return view('pencucian/formtambah', $data);
    }

    public function getPelanggan()
    {
        return view('pencucian/getpelanggan');
    }

    public function viewGetPelanggan()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            
            // Filter pelanggan yang kendaraannya tidak sedang dalam proses (antri, diproses, dijemput)
            $pelanggan = $db->table('pelanggan')
                ->select('pelanggan.idpelanggan, pelanggan.nama as nama_pelanggan, pelanggan.alamat, pelanggan.nohp, pelanggan.platnomor')
                ->join('pencucian', 'pencucian.idpelanggan = pelanggan.idpelanggan AND pencucian.status IN ("antri", "diproses", "dijemput")', 'left')
                ->where('pencucian.idpelanggan IS NULL'); // Hanya tampilkan pelanggan yang kendaraannya tidak sedang dalam proses

            return DataTable::of($pelanggan)
                ->add('action', function ($row) {
                    $button1 = '<button type="button" class="btn btn-primary btn-pilihpelanggan" 
                                data-idpelanggan="' . $row->idpelanggan . '" 
                                data-nama_pelanggan="' . esc($row->nama_pelanggan) . '"
                                data-alamat="' . esc($row->alamat) . '"
                                data-nohp="' . esc($row->nohp) . '"
                                data-platnomor="' . esc($row->platnomor) . '">Pilih</button>';
                    return $button1;
                }, 'last')
                ->addNumbering()
                ->toJson();
        }
    }

    public function getPaket()
    {
        return view('pencucian/getpaket');
    }

    public function viewGetPaket()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $paket = $db->table('paket_cucian')
                ->select('idpaket, namapaket, harga, jenis, keterangan');

            return DataTable::of($paket)
                ->add('action', function ($row) {
                    $button1 = '<button type="button" class="btn btn-primary btn-pilihpaket" 
                                data-idpaket="' . $row->idpaket . '" 
                                data-namapaket="' . esc($row->namapaket) . '"
                                data-harga="' . $row->harga . '"
                                data-jenis="' . esc($row->jenis) . '">Pilih</button>';
                    return $button1;
                }, 'last')
                ->addNumbering()
                ->edit('harga', function ($row) {
                    return 'Rp. ' . number_format($row->harga, 0, ',', '.');
                })
                ->toJson();
        }
    }

    public function getKaryawan()
    {
        return view('pencucian/getkaryawan');
    }

    public function viewGetKaryawan()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            
            // Filter karyawan yang tidak sedang menangani pencucian dengan status 'diproses'
            $karyawan = $db->table('karyawan')
                ->select('karyawan.idkaryawan, karyawan.nama as namakaryawan, karyawan.alamat, karyawan.nohp')
                ->join('pencucian', 'pencucian.idkaryawan = karyawan.idkaryawan AND pencucian.status = "diproses"', 'left')
                ->where('pencucian.idkaryawan IS NULL') // Hanya tampilkan karyawan yang tidak sedang sibuk
                ->groupBy('karyawan.idkaryawan');

            return DataTable::of($karyawan)
                ->add('action', function ($row) {
                    $button1 = '<button type="button" class="btn btn-primary btn-pilihkaryawan" 
                                data-idkaryawan="' . $row->idkaryawan . '" 
                                data-namakaryawan="' . esc($row->namakaryawan) . '"
                                data-alamat="' . esc($row->alamat) . '"
                                data-nohp="' . esc($row->nohp) . '">Pilih</button>';
                    return $button1;
                }, 'last')
                ->add('status', function ($row) {
                    return '<span class="badge badge-success">Tersedia</span>';
                }, 'first')
                ->addNumbering()
                ->toJson();
        }
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $idpencucian = $this->request->getPost('idpencucian');
            $idpelanggan = $this->request->getPost('idpelanggan');
            $idpaket = $this->request->getPost('idpaket');
            $idkaryawan = $this->request->getPost('idkaryawan');
            $autoAssign = $this->request->getPost('autoAssignKaryawan') == 1;
            $tgl = date('Y-m-d');
            $jamdatang = date('H:i:s');

            // Validation rules - karyawan tidak wajib jika auto-assign
            $rules = [
                'idpelanggan' => [
                    'label' => 'Pelanggan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'idpaket' => [
                    'label' => 'Paket',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]
            ];

            // Jika tidak auto-assign, karyawan wajib dipilih
            if (!$autoAssign) {
                $rules['idkaryawan'] = [
                    'label' => 'Karyawan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus dipilih jika tidak menggunakan auto-assign',
                    ]
                ];
            }

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
                $finalKaryawan = null;
                $finalStatus = 'diproses';
                $nomorAntrian = null;

                if ($autoAssign) {
                    // Mode auto-assign
                    $availableKaryawan = $this->getAvailableKaryawan();
                    
                    if ($availableKaryawan) {
                        $finalKaryawan = $availableKaryawan;
                        $finalStatus = 'diproses';
                        $message = 'Data Pencucian Berhasil Ditambahkan dan Karyawan Otomatis Dipilih';
                    } else {
                        // Semua karyawan sibuk, masuk antrian
                        $finalKaryawan = null;
                        $finalStatus = 'antri';
                        $nomorAntrian = $this->generateNomorAntrian();
                        $message = 'Data Pencucian Berhasil Ditambahkan ke Antrian (Semua Karyawan Sedang Sibuk). Nomor Antrian: ' . $nomorAntrian;
                    }
                } else {
                    // Mode manual selection
                    // Cek apakah karyawan yang dipilih masih available
                    $db = db_connect();
                    $karyawanSibuk = $db->table('pencucian')
                        ->where('idkaryawan', $idkaryawan)
                        ->where('status', 'diproses')
                        ->countAllResults();
                        
                    if ($karyawanSibuk > 0) {
                        $json = [
                            'error' => [
                                'error_idkaryawan' => 'Karyawan sedang sibuk menangani pencucian lain. Silakan pilih karyawan lain atau gunakan auto-assign.'
                            ]
                        ];
                        return $this->response->setJSON($json);
                    }
                    
                    $finalKaryawan = $idkaryawan;
                    $finalStatus = 'diproses';
                    $message = 'Data Pencucian Berhasil Ditambahkan';
                }

                // Insert data pencucian
                $db->table('pencucian')->insert([
                    'idpencucian' => $idpencucian,
                    'nomor_antrian' => $nomorAntrian,
                    'idpelanggan' => $idpelanggan,
                    'idpaket' => $idpaket,
                    'idkaryawan' => $finalKaryawan,
                    'tgl' => $tgl,
                    'jamdatang' => $jamdatang,
                    'status' => $finalStatus,
                ]);

                $json = [
                    'sukses' => $message,
                    'idpencucian' => $idpencucian,
                    'status' => $finalStatus,
                    'nomor_antrian' => $nomorAntrian
                ];
            }
            return $this->response->setJSON($json);
        }
    }
    public function delete()
    {
        if ($this->request->isAJAX()) {
            $idpencucian = $this->request->getPost('idpencucian');

            $db = db_connect();
            $db->table('pencucian')->where('idpencucian', $idpencucian)->delete();
            
            $json = [
                'sukses' => 'Data Pencucian Berhasil Dihapus'
            ];

            return $this->response->setJSON($json);
        }
    }



    public function formedit($idpencucian)
    {
        $db = db_connect();
        $pencucian = $db->table('pencucian')
            ->select('pencucian.*, 
                     pelanggan.nama as nama_pelanggan, 
                     pelanggan.alamat, 
                     pelanggan.nohp, 
                     pelanggan.platnomor,
                     paket_cucian.namapaket, 
                     paket_cucian.harga, 
                     paket_cucian.jenis,
                     karyawan.nama as nama_karyawan,
                     karyawan.alamat as alamat_karyawan,
                     karyawan.nohp as nohp_karyawan')
            ->join('pelanggan', 'pelanggan.idpelanggan = pencucian.idpelanggan')
            ->join('paket_cucian', 'paket_cucian.idpaket = pencucian.idpaket')
            ->join('karyawan', 'karyawan.idkaryawan = pencucian.idkaryawan')
            ->where('idpencucian', $idpencucian)
            ->get()->getRowArray();

        if (!$pencucian) {
            return redirect()->back()->with('error', 'Data Pencucian tidak ditemukan');
        }

        $data = [
            'pencucian' => $pencucian
        ];

        return view('pencucian/formedit', $data);
    }


    public function updatedata($idpencucian = null)
    {
        if ($this->request->isAJAX()) {
            if (!$idpencucian) {
                $idpencucian = $this->request->getPost('idpencucian');
            }
            $idpelanggan = $this->request->getPost('idpelanggan');
            $idpaket = $this->request->getPost('idpaket');
            $idkaryawan = $this->request->getPost('idkaryawan');

            $rules = [
                'idpelanggan' => [
                    'label' => 'Pelanggan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'idpaket' => [
                    'label' => 'Paket',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'idkaryawan' => [
                    'label' => 'Karyawan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $errors = [];
                foreach ($rules as $field => $rule) {
                    $errors["error_$field"] = $this->validator->getError($field);
                }
                return $this->response->setJSON(['error' => $errors]);
            }

            $db = db_connect();
            $dataPencucian = [
                'idpelanggan' => $idpelanggan,
                'idpaket' => $idpaket,
                'idkaryawan' => $idkaryawan,
            ];
            
            $db->table('pencucian')->where('idpencucian', $idpencucian)->update($dataPencucian);

            return $this->response->setJSON(['sukses' => 'Update data berhasil']);
        }
    }

    public function ubahstatus()
    {
        if ($this->request->isAJAX()) {
            $idpencucian = $this->request->getPost('idpencucian');

            $model = new ModelPencucian();
            $pencucian = $model->where('idpencucian', $idpencucian)->first();

            if ($pencucian) {
                $statusBaru = '';
                $message = 'Status Pencucian berhasil diubah';
                
                // Logic perubahan status
                if ($pencucian['status'] == 'diproses') {
                    $statusBaru = 'dijemput';
                    
                    // Ketika karyawan selesai (dari diproses ke dijemput), coba auto-assign dari antrian
                    if ($pencucian['idkaryawan']) {
                        $assigned = $this->autoAssignFromQueue($pencucian['idkaryawan']);
                        if ($assigned) {
                            $message = 'Status berhasil diubah dan pencucian berikutnya dari antrian telah di-assign otomatis';
                        }
                    }
                } elseif ($pencucian['status'] == 'dijemput') {
                    $statusBaru = 'diproses';
                } elseif ($pencucian['status'] == 'antri') {
                    // Dari antri bisa langsung ke diproses jika ada karyawan available
                    $availableKaryawan = $this->getAvailableKaryawan();
                    if ($availableKaryawan) {
                        $statusBaru = 'diproses';
                        // Update dengan karyawan yang tersedia
                        $model->update($idpencucian, [
                            'status' => $statusBaru,
                            'idkaryawan' => $availableKaryawan
                        ]);
                        $message = 'Pencucian berhasil diproses dengan karyawan yang tersedia';
                    } else {
                        $json = [
                            'error' => 'Tidak ada karyawan yang tersedia saat ini'
                        ];
                        return $this->response->setJSON($json);
                    }
                } else {
                    // Status lainnya toggle seperti biasa
                    $statusBaru = ($pencucian['status'] == 'diproses') ? 'dijemput' : 'diproses';
                }

                // Update status (kecuali sudah di-update di atas untuk kasus antri)
                if ($pencucian['status'] != 'antri') {
                    $model->update($idpencucian, ['status' => $statusBaru]);
                }

                $json = [
                    'sukses' => 'Status Pencucian berhasil diubah'
                ];
            } else {
                $json = [
                    'error' => 'Pencucian tidak ditemukan'
                ];
            }

            return $this->response->setJSON($json);
        }
    }

    public function tracking($idpencucian = null)
    {
        if (!$idpencucian) {
            return redirect()->to(base_url());
        }

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
            ->where('pencucian.idpencucian', $idpencucian);
        
        $pencucianData = $pencucianQuery->get()->getRowArray();

        if (!$pencucianData) {
            $data = [
                'error' => 'ID Pencucian tidak ditemukan. Pastikan ID yang Anda masukkan benar.'
            ];
        } else {
            $data = [
                'pencucian' => $pencucianData
            ];
        }

        return view('home/tracking', $data);
    }

    /**
     * Fungsi untuk cetak nomor antrian
     */
    public function cetakAntrian($idpencucian)
    {
        $db = db_connect();
        
        // Ambil data pencucian dengan join ke tabel terkait
        $pencucianQuery = $db
            ->table('pencucian')
            ->select('pencucian.*, 
                     pelanggan.nama as nama_pelanggan, 
                     pelanggan.alamat, 
                     pelanggan.nohp, 
                     pelanggan.platnomor,
                     paket_cucian.namapaket, 
                     paket_cucian.harga, 
                     paket_cucian.jenis')
            ->join('pelanggan', 'pelanggan.idpelanggan = pencucian.idpelanggan')
            ->join('paket_cucian', 'paket_cucian.idpaket = pencucian.idpaket')
            ->where('pencucian.idpencucian', $idpencucian)
            ->where('pencucian.status', 'antri');
        
        $pencucianData = $pencucianQuery->get()->getRowArray();

        if (!$pencucianData) {
            return redirect()->back()->with('error', 'Data pencucian antrian tidak ditemukan');
        }

        // Hitung estimasi waktu berdasarkan posisi antrian
        $antrianSebelum = $db->table('pencucian')
            ->where('status', 'antri')
            ->where('nomor_antrian <', $pencucianData['nomor_antrian'])
            ->where('tgl', $pencucianData['tgl'])
            ->countAllResults();

        // Estimasi 30 menit per pencucian
        $estimasiMenit = ($antrianSebelum + 1) * 30;
        $estimasiWaktu = date('H:i', strtotime($pencucianData['jamdatang'] . " + {$estimasiMenit} minutes"));

        $data = [
            'pencucian' => $pencucianData,
            'estimasi_waktu' => $estimasiWaktu,
            'antrian_sebelum' => $antrianSebelum
        ];

        return view('pencucian/cetak_antrian', $data);
    }


}