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
            'title' => 'Kelola Pencucian'
        ];
        return view('pencucian/datapencucian', $data);
    }

    public function viewCucian()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $produk = $db->table('pencucian')
                ->select('pencucian.idpencucian, pencucian.tgl, pencucian.nomor_antrian, pelanggan.nama, pelanggan.platnomor, paket_cucian.namapaket, karyawan.nama as nama_karyawan, pencucian.status')
                ->join('pelanggan', 'pelanggan.idpelanggan = pencucian.idpelanggan')
                ->join('paket_cucian', 'paket_cucian.idpaket = pencucian.idpaket')
                ->join('karyawan', 'karyawan.idkaryawan = pencucian.idkaryawan', 'left')
                ->groupBy('idpencucian');
            return DataTable::of($produk)
                ->add('action', function ($row) {
                    $button1 = '<button type="button" class="btn btn-primary btn-sm btn-detail" data-idpencucian="' . $row->idpencucian . '"><i class="fas fa-eye"></i></button>';
                    $buttonsGroup = '<div style="display: flex;">' . $button1;

                    if ($row->status == 'pending') {
                        $buttonAssign = '<button type="button" class="btn btn-success btn-sm btn-assign" data-idpencucian="' . $row->idpencucian . '" style="margin-left: 5px;" title="Assign Karyawan"><i class="fas fa-user-plus"></i></button>';
                        $buttonCetak = '<button type="button" class="btn btn-info btn-sm btn-cetak-antrian" data-idpencucian="' . $row->idpencucian . '" style="margin-left: 5px;" title="Cetak Antrian"><i class="fas fa-print"></i></button>';
                        $buttonEdit = '<button type="button" class="btn btn-secondary btn-sm btn-edit" data-idpencucian="' . $row->idpencucian . '" style="margin-left: 5px;"><i class="fas fa-pencil-alt"></i></button>';
                        $buttonDelete = '<button type="button" class="btn btn-danger btn-sm btn-delete" data-idpencucian="' . $row->idpencucian . '" style="margin-left: 5px;"><i class="fas fa-trash"></i></button>';
                        $buttonBatal = '<button type="button" class="btn btn-warning btn-sm btn-batal" data-idpencucian="' . $row->idpencucian . '" style="margin-left: 5px;" title="Batalkan"><i class="fas fa-times"></i></button>';
                        $buttonsGroup .= $buttonAssign . $buttonCetak . $buttonEdit . $buttonDelete . $buttonBatal;
                    } elseif ($row->status == 'diproses') {
                        $buttonStatus = '<button type="button" class="btn btn-warning btn-sm btn-status" data-idpencucian="' . $row->idpencucian . '" style="margin-left: 5px;" title="Ubah Status"><i class="fas fa-sync-alt"></i></button>';
                        $buttonEdit = '<button type="button" class="btn btn-secondary btn-sm btn-edit" data-idpencucian="' . $row->idpencucian . '" style="margin-left: 5px;"><i class="fas fa-pencil-alt"></i></button>';
                        $buttonsGroup .= $buttonStatus . $buttonEdit;
                    } elseif ($row->status == 'dijemput') {
                        $buttonStatus = '<button type="button" class="btn btn-warning btn-sm btn-status" data-idpencucian="' . $row->idpencucian . '" style="margin-left: 5px;" title="Ubah Status"><i class="fas fa-sync-alt"></i></button>';
                        $buttonEdit = '<button type="button" class="btn btn-secondary btn-sm btn-edit" data-idpencucian="' . $row->idpencucian . '" style="margin-left: 5px;"><i class="fas fa-pencil-alt"></i></button>';
                        $buttonsGroup .= $buttonStatus . $buttonEdit;
                    }

                    $buttonsGroup .= '</div>';
                    return $buttonsGroup;
                }, 'last')
                ->addNumbering()
                ->hide('nomor_antrian')
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
                ->select('pelanggan.idpelanggan, pelanggan.nama as nama_pelanggan, pelanggan.alamat, pelanggan.nohp, pelanggan.platnomor')
                ->join('pencucian', 'pencucian.idpelanggan = pelanggan.idpelanggan AND pencucian.status IN ("pending", "diproses", "dijemput")', 'left')
                ->where('pencucian.idpelanggan IS NULL');

            return DataTable::of($pelanggan)
                ->add('action', function ($row) {
                    return '<button type="button" class="btn btn-primary btn-pilihpelanggan" 
                                data-idpelanggan="' . $row->idpelanggan . '" 
                                data-nama_pelanggan="' . esc($row->nama_pelanggan) . '"
                                data-alamat="' . esc($row->alamat) . '"
                                data-nohp="' . esc($row->nohp) . '"
                                data-platnomor="' . esc($row->platnomor) . '">Pilih</button>';
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
                ->join('(SELECT pencucian.idpencucian, pencucian.idkaryawan, pelanggan.platnomor, paket_cucian.namapaket 
                         FROM pencucian 
                         JOIN pelanggan ON pelanggan.idpelanggan = pencucian.idpelanggan 
                         JOIN paket_cucian ON paket_cucian.idpaket = pencucian.idpaket 
                         WHERE pencucian.status = "diproses") as active_task', 'active_task.idkaryawan = karyawan.idkaryawan', 'left');

            return DataTable::of($karyawan)
                ->add('status_label', function ($row) {
                    if (empty($row->task_idpencucian)) {
                        return '<span class="badge badge-success">FREE</span>';
                    }
                    $info = 'Sedang cuci';
                    if ($row->task_platnomor) {
                        $info .= ' (' . $row->task_platnomor . ')';
                    }
                    return '<span class="badge badge-danger" title="' . esc($info) . '">BUSY</span>';
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
            $idpaket = $this->request->getPost('idpaket');
            $tgl = date('Y-m-d');
            $jamdatang = date('H:i:s');

            $rules = [
                'idpelanggan' => [
                    'label' => 'Pelanggan',
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

            $db = db_connect();
            $nomorAntrian = $this->generateNomorAntrian();

            $db->table('pencucian')->insert([
                'idpencucian' => $idpencucian,
                'nomor_antrian' => $nomorAntrian,
                'idpelanggan' => $idpelanggan,
                'idpaket' => $idpaket,
                'idkaryawan' => null,
                'tgl' => $tgl,
                'jamdatang' => $jamdatang,
                'status' => 'pending',
            ]);

            return $this->response->setJSON([
                'sukses' => 'Data Pencucian Berhasil Ditambahkan. Nomor Antrian: ' . $nomorAntrian,
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
                return $this->response->setJSON(['error' => 'Pencucian tidak ditemukan']);
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
                'sukses' => 'Karyawan berhasil di-assign. Pencucian sedang diproses.'
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
                return $this->response->setJSON(['error' => 'Pencucian tidak ditemukan']);
            }

            $statusBaru = '';
            $message = 'Status Pencucian berhasil diubah';

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
                return $this->response->setJSON(['error' => 'Pencucian tidak ditemukan']);
            }

            if ($pencucian['status'] !== 'pending') {
                return $this->response->setJSON([
                    'error' => 'Hanya order dengan status pending yang bisa dibatalkan'
                ]);
            }

            $model->update($idpencucian, ['status' => 'batal']);

            return $this->response->setJSON(['sukses' => 'Pencucian berhasil dibatalkan']);
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
                return $this->response->setJSON(['error' => 'Data pencucian tidak ditemukan']);
            }

            if ($pencucian['status'] !== 'pending') {
                return $this->response->setJSON([
                    'error' => 'Hanya order dengan status pending yang bisa dihapus'
                ]);
            }

            $db->table('pencucian')->where('idpencucian', $idpencucian)->delete();

            return $this->response->setJSON(['sukses' => 'Data Pencucian Berhasil Dihapus']);
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
                     paket_cucian.jenis')
            ->join('pelanggan', 'pelanggan.idpelanggan = pencucian.idpelanggan')
            ->join('paket_cucian', 'paket_cucian.idpaket = pencucian.idpaket')
            ->where('idpencucian', $idpencucian)
            ->get()->getRowArray();

        if (!$pencucian) {
            return redirect()->back()->with('error', 'Data Pencucian tidak ditemukan');
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
            $idpaket = $this->request->getPost('idpaket');

            $rules = [
                'idpelanggan' => [
                    'label' => 'Pelanggan',
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

            $db = db_connect();
            $db->table('pencucian')
                ->where('idpencucian', $idpencucian)
                ->update([
                    'idpelanggan' => $idpelanggan,
                    'idpaket' => $idpaket,
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
                     pelanggan.platnomor,
                     paket_cucian.namapaket, 
                     paket_cucian.harga, 
                     paket_cucian.jenis,
                     karyawan.nama as nama_karyawan')
            ->join('pelanggan', 'pelanggan.idpelanggan = pencucian.idpelanggan')
            ->join('paket_cucian', 'paket_cucian.idpaket = pencucian.idpaket')
            ->join('karyawan', 'karyawan.idkaryawan = pencucian.idkaryawan', 'left')
            ->where('pencucian.idpencucian', $idpencucian)
            ->get()->getRowArray();

        if (!$pencucian) {
            return redirect()->back()->with('error', 'Data pencucian tidak ditemukan');
        }

        $trackingUrl = site_url("pencucian/tracking/$idpencucian");
        $qrCode = QrCode::create($trackingUrl)->setSize(300)->setMargin(10);
        $writer = new PngWriter();
        $qrCodeImage = $writer->write($qrCode)->getDataUri();

        return view('pencucian/detail', [
            'qrCodeImage' => $qrCodeImage,
            'pencucian' => $pencucian
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
                     pelanggan.platnomor,
                     paket_cucian.namapaket, 
                     paket_cucian.harga, 
                     paket_cucian.jenis')
            ->join('pelanggan', 'pelanggan.idpelanggan = pencucian.idpelanggan')
            ->join('paket_cucian', 'paket_cucian.idpaket = pencucian.idpaket')
            ->where('pencucian.idpencucian', $idpencucian)
            ->get()->getRowArray();

        if (!$pencucian) {
            return redirect()->back()->with('error', 'Data pencucian tidak ditemukan');
        }

        $antrianSebelum = $db->table('pencucian')
            ->where('status', 'pending')
            ->where('nomor_antrian <', $pencucian['nomor_antrian'])
            ->where('tgl', $pencucian['tgl'])
            ->countAllResults();

        $estimasiMenit = ($antrianSebelum + 1) * 30;
        $estimasiWaktu = date('H:i', strtotime($pencucian['jamdatang'] . " + {$estimasiMenit} minutes"));

        return view('pencucian/cetak_antrian', [
            'pencucian' => $pencucian,
            'estimasi_waktu' => $estimasiWaktu,
            'antrian_sebelum' => $antrianSebelum
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
                     pelanggan.platnomor,
                     paket_cucian.namapaket, 
                     paket_cucian.harga, 
                     paket_cucian.jenis,
                     karyawan.nama as nama_karyawan')
            ->join('pelanggan', 'pelanggan.idpelanggan = pencucian.idpelanggan')
            ->join('paket_cucian', 'paket_cucian.idpaket = pencucian.idpaket')
            ->join('karyawan', 'karyawan.idkaryawan = pencucian.idkaryawan', 'left')
            ->where('pencucian.idpencucian', $idpencucian)
            ->get()->getRowArray();

        if (!$pencucian) {
            return view('home/tracking', [
                'error' => 'ID Pencucian tidak ditemukan. Pastikan ID yang Anda masukkan benar.'
            ]);
        }

        return view('home/tracking', ['pencucian' => $pencucian]);
    }
}
