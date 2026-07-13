<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Pencucian as ModelPencucian;
use CodeIgniter\HTTP\ResponseInterface;
use Hermawan\DataTables\DataTable;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class PencucianController extends BaseController
{
    private function generateNomorAntrian()
    {
        $db = db_connect();
        $today = date('Y-m-d');

        $maxAntrian = $db->table('pencucian')
            ->select('MAX(nomor_antrian) as max_antrian')
            ->where('tgl', $today)
            ->get()
            ->getRowArray();

        return ($maxAntrian['max_antrian'] ?? 0) + 1;
    }

    public function index()
    {
        $data = [
            'title' => 'Kelola Reservasi'
        ];
        return view('pencucian/datapencucian', $data);
    }

    public function viewCucian()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $produk = $db->table('pencucian')
                ->select('pencucian.idpencucian, pencucian.tgl, pencucian.nomor_antrian,
                         pelanggan.nama, pencucian.platnomor, paket_cucian.namapaket, paket2.namapaket as namapaket2, 
                         karyawan.nama as nama_karyawan, pencucian.status, pencucian.idpaket, pencucian.idpaket2')
                ->join('pelanggan', 'pelanggan.idpelanggan = pencucian.idpelanggan')
                ->join('paket_cucian', 'paket_cucian.idpaket = pencucian.idpaket')
                ->join('paket_cucian as paket2', 'paket2.idpaket = pencucian.idpaket2', 'left')
                ->join('karyawan', 'karyawan.idkaryawan = pencucian.idkaryawan', 'left')
                ->groupBy('idpencucian');
            return DataTable::of($produk)
                ->add('action', function ($row) {
                    $button1 = '<button type="button" class="btn btn-primary btn-sm btn-detail" data-idpencucian="' . $row->idpencucian . '"><i class="ri-eye-line"></i></button>';
                    $buttonsGroup = '<div style="display: flex;">' . $button1;

                    if ($row->status == 'pending') {
                        $buttonAssign = '<button type="button" class="btn btn-success btn-sm btn-assign" data-idpencucian="' . $row->idpencucian . '" style="margin-left: 5px;" title="Assign Karyawan"><i class="ri-user-add-line"></i></button>';
                        $buttonCetak = '<button type="button" class="btn btn-info btn-sm btn-cetak-antrian" data-idpencucian="' . $row->idpencucian . '" style="margin-left: 5px;" title="Cetak Antrian"><i class="ri-printer-line"></i></button>';
                        $buttonEdit = '<button type="button" class="btn btn-secondary btn-sm btn-edit" data-idpencucian="' . $row->idpencucian . '" style="margin-left: 5px;"><i class="ri-pencil-line"></i></button>';
                        $buttonDelete = '<button type="button" class="btn btn-danger btn-sm btn-delete" data-idpencucian="' . $row->idpencucian . '" style="margin-left: 5px;"><i class="ri-delete-bin-line"></i></button>';
                        $buttonBatal = '<button type="button" class="btn btn-warning btn-sm btn-batal" data-idpencucian="' . $row->idpencucian . '" style="margin-left: 5px;" title="Batalkan"><i class="ri-close-line"></i></button>';
                        $buttonsGroup .= $buttonAssign . $buttonCetak . $buttonEdit . $buttonDelete . $buttonBatal;
                    } elseif ($row->status == 'diproses') {
                        $buttonStatus = '<button type="button" class="btn btn-warning btn-sm btn-status" data-idpencucian="' . $row->idpencucian . '" style="margin-left: 5px;" title="Ubah Status"><i class="ri-refresh-line"></i></button>';
                        $buttonEdit = '<button type="button" class="btn btn-secondary btn-sm btn-edit" data-idpencucian="' . $row->idpencucian . '" style="margin-left: 5px;"><i class="ri-pencil-line"></i></button>';
                        $buttonsGroup .= $buttonStatus . $buttonEdit;
                    } elseif ($row->status == 'dijemput') {
                        $buttonStatus = '<button type="button" class="btn btn-warning btn-sm btn-status" data-idpencucian="' . $row->idpencucian . '" style="margin-left: 5px;" title="Ubah Status"><i class="ri-refresh-line"></i></button>';
                        $buttonEdit = '<button type="button" class="btn btn-secondary btn-sm btn-edit" data-idpencucian="' . $row->idpencucian . '" style="margin-left: 5px;"><i class="ri-pencil-line"></i></button>';
                        $buttonsGroup .= $buttonStatus . $buttonEdit;
                    }

                    $buttonsGroup .= '</div>';
                    return $buttonsGroup;
                }, 'last')
                ->addNumbering()
                ->hide('nomor_antrian')
                ->hide('namapaket2')
                ->hide('idpaket')
                ->hide('idpaket2')
                ->edit('nama', function ($row) {
                    return $row->nama;
                })
                ->edit('namapaket', function ($row) {
                    $paket = $row->namapaket;
                    if (!empty($row->namapaket2)) {
                        $paket .= ' + ' . $row->namapaket2;
                    }
                    return $paket;
                })
                ->edit('nama_karyawan', function ($row) {
                    if ($row->status == 'pending') {
                        return '<span class="text-muted"><i>Belum ditugaskan</i></span>';
                    }
                    return $row->nama_karyawan ?: '-';
                })
                ->edit('status', function ($row) {
                    if ($row->status == 'pending') {
                        $antrianText = $row->nomor_antrian ? "Antrian #{$row->nomor_antrian}" : "Menunggu";
                        return '<span class="badge bg-secondary">' . $antrianText . '</span>';
                    } elseif ($row->status == 'diproses') {
                        return '<span class="badge bg-warning">Sedang Proses</span>';
                    } elseif ($row->status == 'dijemput') {
                        return '<span class="badge bg-primary">Siap Dijemput</span>';
                    } elseif ($row->status == 'selesai') {
                        return '<span class="badge bg-success">Selesai</span>';
                    } elseif ($row->status == 'batal') {
                        return '<span class="badge bg-danger">Batal</span>';
                    }
                })
                ->toJson();
        }
    }

    public function formtambah()
    {
        $db = db_connect();
        $today = date('Ymd');
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
            $nextNo = !empty($numbers) ? max($numbers) + 1 : 1;
        }

        $next_id = $prefix . str_pad($nextNo, 4, '0', STR_PAD_LEFT);

        return view('pencucian/formtambah', [
            'next_id' => $next_id
        ]);
    }

    public function getPelanggan()
    {
        return view('pencucian/getpelanggan');
    }

    public function viewGetPelanggan()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $pelanggan = $db->table('pelanggan')
                ->select('pelanggan.idpelanggan, pelanggan.nama as nama_pelanggan, pelanggan.alamat, pelanggan.nohp,
                         active_pencucian.idpencucian as active_idpencucian, active_pencucian.status as active_status')
                ->join('(SELECT pencucian.idpencucian, pencucian.idpelanggan, pencucian.status 
                         FROM pencucian 
                         WHERE pencucian.status IN ("pending", "diproses", "dijemput")) as active_pencucian', 
                         'active_pencucian.idpelanggan = pelanggan.idpelanggan', 'left');

            return DataTable::of($pelanggan)
                ->add('status_pelanggan', function ($row) {
                    if (!empty($row->active_idpencucian)) {
                        return '<span class="badge bg-danger">Sedang Proses</span>';
                    }
                    return '<span class="badge bg-success">Tersedia</span>';
                }, 'last')
                ->add('action', function ($row) {
                    return '<button type="button" class="btn btn-primary btn-pilihpelanggan" 
                                data-idpelanggan="' . $row->idpelanggan . '" 
                                data-nama_pelanggan="' . esc($row->nama_pelanggan) . '"
                                data-alamat="' . esc($row->alamat) . '"
                                data-nohp="' . esc($row->nohp) . '">Pilih</button>';
                }, 'last')
                ->hide('active_idpencucian')
                ->hide('active_status')
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
                    return '<button type="button" class="btn btn-primary btn-pilihpaket" 
                                data-idpaket="' . $row->idpaket . '" 
                                data-namapaket="' . esc($row->namapaket) . '"
                                data-harga="' . $row->harga . '"
                                data-jenis="' . esc($row->jenis) . '">Pilih</button>';
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
            $karyawan = $db->table('karyawan')
                ->select('karyawan.idkaryawan, karyawan.nama as namakaryawan, karyawan.alamat, karyawan.nohp,
                         active_task.idpencucian as task_idpencucian, active_task.platnomor as task_platnomor, active_task.namapaket as task_paket')
                ->join('(SELECT pencucian.idpencucian, pencucian.idkaryawan, pencucian.platnomor, paket_cucian.namapaket 
                         FROM pencucian 
                         JOIN paket_cucian ON paket_cucian.idpaket = pencucian.idpaket 
                         WHERE pencucian.status = "diproses") as active_task', 'active_task.idkaryawan = karyawan.idkaryawan', 'left');

            return DataTable::of($karyawan)
                ->add('status_label', function ($row) {
                    if (empty($row->task_idpencucian)) {
                        return '<span class="badge bg-success">FREE</span>';
                    }
                    $info = 'Sedang cuci';
                    if ($row->task_platnomor) {
                        $info .= ' (' . $row->task_platnomor . ')';
                    }
                    return '<span class="badge bg-danger" title="' . esc($info) . '">BUSY</span>';
                }, 'first')
                ->add('action', function ($row) {
                    if (empty($row->task_idpencucian)) {
                        return '<button type="button" class="btn btn-primary btn-sm btn-pilihkaryawan" 
                                    data-idkaryawan="' . $row->idkaryawan . '" 
                                    data-namakaryawan="' . esc($row->namakaryawan) . '"
                                    data-alamat="' . esc($row->alamat) . '"
                                    data-nohp="' . esc($row->nohp) . '">Pilih</button>';
                    }
                    return '<span class="text-muted"><i class="fas fa-ban"></i> Sedang Cuci</span>';
                }, 'last')
                ->hide('task_idpencucian')
                ->hide('task_platnomor')
                ->hide('task_paket')
                ->addNumbering()
                ->toJson();
        }
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $idpencucian = $this->request->getPost('idpencucian');
            $idpelanggan = $this->request->getPost('idpelanggan');
            $platnomor = $this->request->getPost('platnomor');
            $idpaket = $this->request->getPost('idpaket');
            $idpaket2 = $this->request->getPost('idpaket2');
            $tgl = date('Y-m-d');
            $jamdatang = date('H:i:s');

            $rules = [
                'idpelanggan' => [
                    'label' => 'Pelanggan',
                    'rules' => 'required',
                    'errors' => ['required' => '{field} tidak boleh kosong']
                ],
                'platnomor' => [
                    'label' => 'Plat Nomor',
                    'rules' => 'required',
                    'errors' => ['required' => '{field} tidak boleh kosong']
                ],
                'idpaket' => [
                    'label' => 'Paket',
                    'rules' => 'required',
                    'errors' => ['required' => '{field} tidak boleh kosong']
                ]
            ];

            if (!$this->validate($rules)) {
                $errors = [];
                foreach ($rules as $field => $rule) {
                    $errors["error_$field"] = $this->validator->getError($field);
                }
                return $this->response->setJSON(['error' => $errors]);
            }

            if (!empty($idpaket2)) {
                $db = db_connect();
                $paket1 = $db->table('paket_cucian')->where('idpaket', $idpaket)->get()->getRowArray();
                $paket2 = $db->table('paket_cucian')->where('idpaket', $idpaket2)->get()->getRowArray();

                if ($paket1 && $paket2 && $paket1['jenis'] !== $paket2['jenis']) {
                    return $this->response->setJSON([
                        'error' => ['error_idpaket2' => 'Jenis paket ke-2 harus sama dengan paket ke-1 (' . $paket1['jenis'] . ')']
                    ]);
                }
            }

            $db = db_connect();
            $nomorAntrian = $this->generateNomorAntrian();

            $db->table('pencucian')->insert([
                'idpencucian' => $idpencucian,
                'nomor_antrian' => $nomorAntrian,
                'idpelanggan' => $idpelanggan,
                'platnomor' => strtoupper($platnomor),
                'idpaket' => $idpaket,
                'idpaket2' => !empty($idpaket2) ? $idpaket2 : null,
                'idkaryawan' => null,
                'tgl' => $tgl,
                'jamdatang' => $jamdatang,
                'status' => 'pending',
            ]);

            return $this->response->setJSON([
                'sukses' => 'Reservasi Berhasil Ditambahkan. Nomor Antrian: ' . $nomorAntrian,
                'idpencucian' => $idpencucian,
                'nomor_antrian' => $nomorAntrian
            ]);
        }
    }

    public function assignKaryawan()
    {
        if ($this->request->isAJAX()) {
            $idpencucian = $this->request->getPost('idpencucian');
            $idkaryawan = $this->request->getPost('idkaryawan');

            $rules = [
                'idkaryawan' => [
                    'label' => 'Karyawan',
                    'rules' => 'required',
                    'errors' => ['required' => '{field} harus dipilih']
                ]
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'error' => ['error_idkaryawan' => $this->validator->getError('idkaryawan')]
                ]);
            }

            $db = db_connect();
            $model = new ModelPencucian();
            $pencucian = $model->where('idpencucian', $idpencucian)->first();

            if (!$pencucian) {
                return $this->response->setJSON(['error' => 'Reservasi tidak ditemukan']);
            }

            if ($pencucian['status'] !== 'pending') {
                return $this->response->setJSON(['error' => 'Hanya order dengan status pending yang bisa di-assign']);
            }

            $karyawanSibuk = $db->table('pencucian')
                ->where('idkaryawan', $idkaryawan)
                ->where('status', 'diproses')
                ->countAllResults();

            if ($karyawanSibuk > 0) {
                return $this->response->setJSON([
                    'error' => 'Karyawan sedang sibuk menangani pencucian lain'
                ]);
            }

            $model->update($idpencucian, [
                'idkaryawan' => $idkaryawan,
                'status' => 'diproses'
            ]);

            return $this->response->setJSON([
                'sukses' => 'Karyawan berhasil di-assign. Reservasi sedang diproses.'
            ]);
        }
    }

    public function ubahstatus()
    {
        if ($this->request->isAJAX()) {
            $idpencucian = $this->request->getPost('idpencucian');
            $model = new ModelPencucian();
            $pencucian = $model->where('idpencucian', $idpencucian)->first();

            if (!$pencucian) {
                return $this->response->setJSON(['error' => 'Reservasi tidak ditemukan']);
            }

            $statusBaru = '';
            $message = 'Status Reservasi berhasil diubah';

            if ($pencucian['status'] == 'diproses') {
                $statusBaru = 'dijemput';
            } elseif ($pencucian['status'] == 'dijemput') {
                $statusBaru = 'diproses';
            } elseif ($pencucian['status'] == 'pending') {
                return $this->response->setJSON([
                    'error' => 'Order pending belum bisa diubah statusnya. Silakan assign karyawan terlebih dahulu.'
                ]);
            } else {
                return $this->response->setJSON([
                    'error' => 'Status tidak dapat diubah'
                ]);
            }

            $model->update($idpencucian, ['status' => $statusBaru]);

            return $this->response->setJSON(['sukses' => $message]);
        }
    }

    public function ubahbatal()
    {
        if ($this->request->isAJAX()) {
            $idpencucian = $this->request->getPost('idpencucian');
            $model = new ModelPencucian();
            $pencucian = $model->where('idpencucian', $idpencucian)->first();

            if (!$pencucian) {
                return $this->response->setJSON(['error' => 'Reservasi tidak ditemukan']);
            }

            if ($pencucian['status'] !== 'pending') {
                return $this->response->setJSON([
                    'error' => 'Hanya order dengan status pending yang bisa dibatalkan'
                ]);
            }

            $model->update($idpencucian, ['status' => 'batal']);

            return $this->response->setJSON(['sukses' => 'Reservasi berhasil dibatalkan']);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $idpencucian = $this->request->getPost('idpencucian');
            $db = db_connect();

            $pencucian = $db->table('pencucian')
                ->where('idpencucian', $idpencucian)
                ->get()
                ->getRowArray();

            if (!$pencucian) {
                return $this->response->setJSON(['error' => 'Data reservasi tidak ditemukan']);
            }

            if ($pencucian['status'] !== 'pending') {
                return $this->response->setJSON([
                    'error' => 'Hanya order dengan status pending yang bisa dihapus'
                ]);
            }

            $db->table('pencucian')->where('idpencucian', $idpencucian)->delete();

            return $this->response->setJSON(['sukses' => 'Data Reservasi Berhasil Dihapus']);
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
                     paket_cucian.namapaket, 
                     paket_cucian.harga, 
                     paket_cucian.jenis,
                     paket2.namapaket as namapaket2,
                     paket2.harga as harga2,
                     paket2.jenis as jenis2')
            ->join('pelanggan', 'pelanggan.idpelanggan = pencucian.idpelanggan')
            ->join('paket_cucian', 'paket_cucian.idpaket = pencucian.idpaket')
            ->join('paket_cucian as paket2', 'paket2.idpaket = pencucian.idpaket2', 'left')
            ->where('idpencucian', $idpencucian)
            ->get()->getRowArray();

        if (!$pencucian) {
            return redirect()->back()->with('error', 'Data Reservasi tidak ditemukan');
        }

        return view('pencucian/formedit', ['pencucian' => $pencucian]);
    }

    public function updatedata($idpencucian = null)
    {
        if ($this->request->isAJAX()) {
            if (!$idpencucian) {
                $idpencucian = $this->request->getPost('idpencucian');
            }
            $idpelanggan = $this->request->getPost('idpelanggan');
            $platnomor = $this->request->getPost('platnomor');
            $idpaket = $this->request->getPost('idpaket');
            $idpaket2 = $this->request->getPost('idpaket2');

            $rules = [
                'idpelanggan' => [
                    'label' => 'Pelanggan',
                    'rules' => 'required',
                    'errors' => ['required' => '{field} tidak boleh kosong']
                ],
                'platnomor' => [
                    'label' => 'Plat Nomor',
                    'rules' => 'required',
                    'errors' => ['required' => '{field} tidak boleh kosong']
                ],
                'idpaket' => [
                    'label' => 'Paket',
                    'rules' => 'required',
                    'errors' => ['required' => '{field} tidak boleh kosong']
                ]
            ];

            if (!$this->validate($rules)) {
                $errors = [];
                foreach ($rules as $field => $rule) {
                    $errors["error_$field"] = $this->validator->getError($field);
                }
                return $this->response->setJSON(['error' => $errors]);
            }

            if (!empty($idpaket2)) {
                $db = db_connect();
                $paket1 = $db->table('paket_cucian')->where('idpaket', $idpaket)->get()->getRowArray();
                $paket2 = $db->table('paket_cucian')->where('idpaket', $idpaket2)->get()->getRowArray();

                if ($paket1 && $paket2 && $paket1['jenis'] !== $paket2['jenis']) {
                    return $this->response->setJSON([
                        'error' => ['error_idpaket2' => 'Jenis paket ke-2 harus sama dengan paket ke-1 (' . $paket1['jenis'] . ')']
                    ]);
                }
            }

            $db = db_connect();
            $db->table('pencucian')
                ->where('idpencucian', $idpencucian)
                ->update([
                    'idpelanggan' => $idpelanggan,
                    'platnomor' => strtoupper($platnomor),
                    'idpaket' => $idpaket,
                    'idpaket2' => !empty($idpaket2) ? $idpaket2 : null,
                ]);

            return $this->response->setJSON(['sukses' => 'Update data berhasil']);
        }
    }

    public function detail($idpencucian)
    {
        $db = db_connect();
        $pencucian = $db->table('pencucian')
            ->select('pencucian.*, 
                     pelanggan.nama as nama_pelanggan, 
                     pelanggan.alamat, 
                     pelanggan.nohp,
                     paket_cucian.namapaket, 
                     paket_cucian.harga, 
                     paket_cucian.jenis,
                     paket_cucian.upah,
                     paket2.namapaket as namapaket2,
                     paket2.harga as harga2,
                     paket2.jenis as jenis2,
                     paket2.upah as upah2,
                     karyawan.nama as nama_karyawan')
            ->join('pelanggan', 'pelanggan.idpelanggan = pencucian.idpelanggan')
            ->join('paket_cucian', 'paket_cucian.idpaket = pencucian.idpaket')
            ->join('paket_cucian as paket2', 'paket2.idpaket = pencucian.idpaket2', 'left')
            ->join('karyawan', 'karyawan.idkaryawan = pencucian.idkaryawan', 'left')
            ->where('pencucian.idpencucian', $idpencucian)
            ->get()->getRowArray();

        if (!$pencucian) {
            return redirect()->back()->with('error', 'Data reservasi tidak ditemukan');
        }

        $trackingUrl = site_url("pencucian/tracking/$idpencucian");
        $qrCode = QrCode::create($trackingUrl)->setSize(300)->setMargin(10);
        $writer = new PngWriter();
        $qrCodeImage = $writer->write($qrCode)->getDataUri();

        $totalHarga = $pencucian['harga'] + ($pencucian['harga2'] ?? 0);

        return view('pencucian/detail', [
            'qrCodeImage' => $qrCodeImage,
            'pencucian' => $pencucian,
            'totalHarga' => $totalHarga
        ]);
    }

    public function cetakAntrian($idpencucian)
    {
        $db = db_connect();
        $pencucian = $db->table('pencucian')
            ->select('pencucian.*, 
                     pelanggan.nama as nama_pelanggan, 
                     pelanggan.alamat, 
                     pelanggan.nohp,
                     paket_cucian.namapaket, 
                     paket_cucian.harga, 
                     paket_cucian.jenis,
                     paket2.namapaket as namapaket2,
                     paket2.harga as harga2')
            ->join('pelanggan', 'pelanggan.idpelanggan = pencucian.idpelanggan')
            ->join('paket_cucian', 'paket_cucian.idpaket = pencucian.idpaket')
            ->join('paket_cucian as paket2', 'paket2.idpaket = pencucian.idpaket2', 'left')
            ->where('pencucian.idpencucian', $idpencucian)
            ->get()->getRowArray();

        if (!$pencucian) {
            return redirect()->back()->with('error', 'Data reservasi tidak ditemukan');
        }

        $antrianSebelum = $db->table('pencucian')
            ->where('status', 'pending')
            ->where('nomor_antrian <', $pencucian['nomor_antrian'])
            ->where('tgl', $pencucian['tgl'])
            ->countAllResults();

        $estimasiMenit = ($antrianSebelum + 1) * 30;
        $estimasiWaktu = date('H:i', strtotime($pencucian['jamdatang'] . " + {$estimasiMenit} minutes"));

        $totalHarga = $pencucian['harga'] + ($pencucian['harga2'] ?? 0);

        $trackingUrl = site_url("pencucian/tracking/$idpencucian");
        $qrCode = QrCode::create($trackingUrl)->setSize(200)->setMargin(5);
        $writer = new PngWriter();
        $qrCodeImage = $writer->write($qrCode)->getDataUri();

        return view('pencucian/cetak_antrian', [
            'pencucian' => $pencucian,
            'estimasi_waktu' => $estimasiWaktu,
            'antrian_sebelum' => $antrianSebelum,
            'totalHarga' => $totalHarga,
            'qrCodeImage' => $qrCodeImage
        ]);
    }

    public function tracking($idpencucian = null)
    {
        if (!$idpencucian) {
            return redirect()->to(base_url());
        }

        $db = db_connect();
        $pencucian = $db->table('pencucian')
            ->select('pencucian.*, 
                     pelanggan.nama as nama_pelanggan, 
                     pelanggan.alamat, 
                     pelanggan.nohp,
                     paket_cucian.namapaket, 
                     paket_cucian.harga, 
                     paket_cucian.jenis,
                     paket2.namapaket as namapaket2,
                     paket2.harga as harga2,
                     karyawan.nama as nama_karyawan')
            ->join('pelanggan', 'pelanggan.idpelanggan = pencucian.idpelanggan')
            ->join('paket_cucian', 'paket_cucian.idpaket = pencucian.idpaket')
            ->join('paket_cucian as paket2', 'paket2.idpaket = pencucian.idpaket2', 'left')
            ->join('karyawan', 'karyawan.idkaryawan = pencucian.idkaryawan', 'left')
            ->where('pencucian.idpencucian', $idpencucian)
            ->get()->getRowArray();

        if (!$pencucian) {
            return view('home/tracking', [
                'error' => 'ID Reservasi tidak ditemukan. Pastikan ID yang Anda masukkan benar.'
            ]);
        }

        $pencucian['totalHarga'] = $pencucian['harga'] + ($pencucian['harga2'] ?? 0);

        return view('home/tracking', ['pencucian' => $pencucian]);
    }
}
