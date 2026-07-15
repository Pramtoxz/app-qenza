<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Faktur;
use App\Models\FakturKendaraan;
use App\Models\FakturPaket;
use Hermawan\DataTables\DataTable;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class FakturController extends BaseController
{
    private function generateIdFaktur()
    {
        $db = db_connect();
        $today = date('Ymd');
        $prefix = "FKP-$today-";

        $query = $db->query("SELECT idreservasi FROM reservasi WHERE idreservasi LIKE ?", ["$prefix%"]);
        $results = $query->getResultArray();

        if (empty($results)) {
            $nextNo = 1;
        } else {
            $numbers = [];
            foreach ($results as $row) {
                $num = substr($row['idreservasi'], strlen($prefix));
                if (is_numeric($num)) {
                    $numbers[] = (int)$num;
                }
            }
            $nextNo = !empty($numbers) ? max($numbers) + 1 : 1;
        }

        return $prefix . str_pad($nextNo, 4, '0', STR_PAD_LEFT);
    }

    public function index()
    {
        $data = [
            'title' => 'Kelola Reservasi'
        ];
        return view('faktur/datafaktur', $data);
    }

    public function viewFaktur()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $query = $db->table('reservasi')
                ->select('reservasi.idreservasi, reservasi.tgl, 
                         pelanggan.nama as nama_pelanggan,
                         (SELECT COUNT(*) FROM detail_kendaraan WHERE detail_kendaraan.idreservasi = reservasi.idreservasi) as jumlah_kendaraan,
                         (SELECT MIN(status) FROM detail_kendaraan WHERE detail_kendaraan.idreservasi = reservasi.idreservasi) as min_status,
                         (CASE WHEN (SELECT COUNT(*) FROM detail_kendaraan WHERE detail_kendaraan.idreservasi = reservasi.idreservasi) > 0 AND (SELECT COUNT(*) FROM detail_kendaraan WHERE detail_kendaraan.idreservasi = reservasi.idreservasi AND status = "selesai") = (SELECT COUNT(*) FROM detail_kendaraan WHERE detail_kendaraan.idreservasi = reservasi.idreservasi) THEN "lunas" ELSE reservasi.status_bayar END) as status_bayar,
                         (SELECT COUNT(*) FROM detail_kendaraan WHERE detail_kendaraan.idreservasi = reservasi.idreservasi AND status != "pending") as non_pending_count,
                         (SELECT CASE MIN(status) WHEN "pending" THEN 1 WHEN "diproses" THEN 2 WHEN "dijemput" THEN 3 WHEN "selesai" THEN 4 WHEN "batal" THEN 5 END FROM detail_kendaraan WHERE detail_kendaraan.idreservasi = reservasi.idreservasi) as status_priority')
                ->join('pelanggan', 'pelanggan.idpelanggan = reservasi.idpelanggan', 'left')
                ->orderBy('status_priority', 'ASC')
                ->orderBy('reservasi.idreservasi', 'DESC');

            return DataTable::of($query)
                ->add('action', function ($row) {
                    $button1 = '<button type="button" class="btn btn-primary btn-sm btn-detail" data-idreservasi="' . $row->idreservasi . '"><i class="ri-eye-line"></i></button>';
                    $buttonCetak = '<button type="button" class="btn btn-info btn-sm btn-cetak-antrian" data-idreservasi="' . $row->idreservasi . '" style="margin-left: 5px;" title="Cetak Antrian"><i class="ri-printer-line"></i></button>';
                    $buttonsGroup = '<div style="display: flex;">' . $button1 . $buttonCetak;

                    if ($row->non_pending_count == 0) {
                        $buttonDelete = '<button type="button" class="btn btn-danger btn-sm btn-delete" data-idreservasi="' . $row->idreservasi . '" style="margin-left: 5px;"><i class="ri-delete-bin-line"></i></button>';
                        $buttonsGroup .= $buttonDelete;
                    }

                    $buttonsGroup .= '</div>';
                    return $buttonsGroup;
                }, 'last')
                ->addNumbering()
                ->hide('status_priority')
                ->edit('min_status', function ($row) {
                    $map = [
                        'pending' => '<span class="badge bg-secondary">Pending</span>',
                        'diproses' => '<span class="badge bg-warning">Diproses</span>',
                        'dijemput' => '<span class="badge bg-info">Menunggu Di Jemput</span>',
                        'selesai' => '<span class="badge bg-success">Selesai</span>',
                        'batal' => '<span class="badge bg-danger">Batal</span>',
                    ];
                    return $map[$row->min_status] ?? '-';
                })
                ->hide('non_pending_count')
                ->edit('nama_pelanggan', function ($row) {
                    return $row->nama_pelanggan ?: '-';
                })
                ->edit('status_bayar', function ($row) {
                    if ($row->status_bayar == 'lunas') {
                        return '<span class="badge bg-success">Lunas</span>';
                    }
                    return '<span class="badge bg-warning">Belum Bayar</span>';
                })
                ->toJson();
        }
    }

    public function formtambah()
    {
        $next_id = $this->generateIdFaktur();

        return view('faktur/formtambah', [
            'next_id' => $next_id
        ]);
    }

    public function getPelanggan()
    {
        return view('faktur/getpelanggan');
    }

    public function viewGetPelanggan()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $pelanggan = $db->table('pelanggan')
                ->select('pelanggan.idpelanggan, pelanggan.nama as nama_pelanggan, pelanggan.alamat, pelanggan.nohp');

            return DataTable::of($pelanggan)
                ->add('action', function ($row) {
                    return '<button type="button" class="btn btn-primary btn-pilihpelanggan" 
                                data-idpelanggan="' . $row->idpelanggan . '" 
                                data-nama_pelanggan="' . esc($row->nama_pelanggan) . '"
                                data-alamat="' . esc($row->alamat) . '"
                                data-nohp="' . esc($row->nohp) . '">Pilih</button>';
                }, 'last')
                ->addNumbering()
                ->hide('idpelanggan')
                ->toJson();
        }
    }

    public function getPaket()
    {
        return view('faktur/getpaket');
    }

    public function viewGetPaket()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $paket = $db->table('paket_cucian')
                ->select('idpaket, namapaket, jenis, harga');

            return DataTable::of($paket)
                ->add('action', function ($row) {
                    return '<button type="button" class="btn btn-primary btn-pilihpaket" 
                                data-idpaket="' . $row->idpaket . '" 
                                data-namapaket="' . esc($row->namapaket) . '"
                                data-harga="' . $row->harga . '"
                                data-jenis="' . esc($row->jenis) . '">Pilih</button>';
                }, 'last')
                ->addNumbering()
                ->hide('idpaket')
                ->edit('harga', function ($row) {
                    return 'Rp. ' . number_format($row->harga, 0, ',', '.');
                })
                ->toJson();
        }
    }

    public function getKaryawan()
    {
        return view('faktur/getkaryawan');
    }

    public function viewGetKaryawan()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $karyawan = $db->table('karyawan')
                ->select('karyawan.idkaryawan, karyawan.nama as namakaryawan, karyawan.alamat, karyawan.nohp,
                         active_task.id as task_id, active_task.platnomor as task_platnomor')
                ->join('(SELECT detail_kendaraan.id, detail_kendaraan.idkaryawan, detail_kendaraan.platnomor 
                         FROM detail_kendaraan 
                         WHERE detail_kendaraan.status = "diproses") as active_task', 'active_task.idkaryawan = karyawan.idkaryawan', 'left');

            return DataTable::of($karyawan)
                ->add('status_label', function ($row) {
                    if (empty($row->task_id)) {
                        return '<span class="badge bg-success">FREE</span>';
                    }
                    $info = 'Sedang diproses';
                    if ($row->task_platnomor) {
                        $info .= ' (' . $row->task_platnomor . ')';
                    }
                    return '<span class="badge bg-danger" title="' . esc($info) . '">BUSY</span>';
                }, 'first')
                ->add('action', function ($row) {
                    if (empty($row->task_id)) {
                        return '<button type="button" class="btn btn-primary btn-sm btn-pilihkaryawan" 
                                    data-idkaryawan="' . $row->idkaryawan . '" 
                                    data-namakaryawan="' . esc($row->namakaryawan) . '"
                                    data-alamat="' . esc($row->alamat) . '"
                                    data-nohp="' . esc($row->nohp) . '">Pilih</button>';
                    }
                    return '<span class="text-muted"><i class="ri-forbid-line"></i> Sedang Proses</span>';
                }, 'last')
                ->hide('idkaryawan')
                ->hide('task_id')
                ->hide('task_platnomor')
                ->addNumbering()
                ->toJson();
        }
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $json = $this->request->getJSON();
            $idreservasi = $json->idreservasi ?? $this->request->getPost('idreservasi');
            $idpelanggan = $json->idpelanggan ?? $this->request->getPost('idpelanggan');
            $kendaraan = $json->kendaraan ?? $this->request->getPost('kendaraan');

            $rules = [
                'idpelanggan' => [
                    'label' => 'Pelanggan',
                    'rules' => 'required',
                    'errors' => ['required' => '{field} tidak boleh kosong']
                ]
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'error' => ['error_idpelanggan' => $this->validator->getError('idpelanggan')]
                ]);
            }

            if (empty($kendaraan) || !is_array($kendaraan)) {
                return $this->response->setJSON([
                    'error' => 'Minimal 1 kendaraan harus ditambahkan'
                ]);
            }

            foreach ($kendaraan as $i => $k) {
                $platnomor = is_array($k) ? ($k['platnomor'] ?? '') : ($k->platnomor ?? '');
                $paket = is_array($k) ? ($k['paket'] ?? []) : ($k->paket ?? []);
                if (empty($platnomor)) {
                    return $this->response->setJSON([
                        'error' => 'Plat nomor kendaraan ke-' . ($i + 1) . ' tidak boleh kosong'
                    ]);
                }
                if (empty($paket) || !is_array($paket) || count($paket) == 0) {
                    return $this->response->setJSON([
                        'error' => 'Minimal 1 paket harus dipilih untuk kendaraan ke-' . ($i + 1)
                    ]);
                }
            }

            $db = db_connect();
            $tgl = date('Y-m-d');
            $jamdatang = date('H:i:s');

            $db->transStart();

            $db->table('reservasi')->insert([
                'idreservasi' => $idreservasi,
                'idpelanggan' => $idpelanggan,
                'tgl' => $tgl,
                'jamdatang' => $jamdatang,
                'status_bayar' => 'belum',
            ]);

            foreach ($kendaraan as $k) {
                $platnomor = is_array($k) ? $k['platnomor'] : $k->platnomor;
                $paket = is_array($k) ? $k['paket'] : $k->paket;
                $db->table('detail_kendaraan')->insert([
                    'idreservasi' => $idreservasi,
                    'platnomor' => strtoupper($platnomor),
                    'idkaryawan' => null,
                    'status' => 'pending',
                ]);
                $idKendaraan = $db->insertID();

                foreach ($paket as $idpaket) {
                    $db->table('detail_paket')->insert([
                        'id_detail_kendaraan' => $idKendaraan,
                        'idpaket' => $idpaket,
                    ]);
                }
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                return $this->response->setJSON(['error' => 'Gagal menyimpan data faktur']);
            }

            return $this->response->setJSON([
                'sukses' => 'Faktur berhasil ditambahkan.',
                'idreservasi' => $idreservasi,
            ]);
        }
    }

    public function assignKaryawan()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
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
            $model = new FakturKendaraan();
            $kendaraan = $model->find($id);

            if (!$kendaraan) {
                return $this->response->setJSON(['error' => 'Data kendaraan tidak ditemukan']);
            }

            if ($kendaraan['status'] !== 'pending') {
                return $this->response->setJSON([
                    'error' => 'Hanya kendaraan dengan status pending yang bisa di-assign'
                ]);
            }

            $karyawanSibuk = $db->table('detail_kendaraan')
                ->where('idkaryawan', $idkaryawan)
                ->where('status', 'diproses')
                ->countAllResults();

            if ($karyawanSibuk > 0) {
                return $this->response->setJSON([
                    'error' => 'Karyawan sedang sibuk menangani kendaraan lain'
                ]);
            }

            $model->update($id, [
                'idkaryawan' => $idkaryawan,
                'status' => 'diproses'
            ]);

            return $this->response->setJSON([
                'sukses' => 'Karyawan berhasil di-assign. Kendaraan sedang diproses.'
            ]);
        }
    }

    public function ubahstatus()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $model = new FakturKendaraan();
            $kendaraan = $model->find($id);

            if (!$kendaraan) {
                return $this->response->setJSON(['error' => 'Data kendaraan tidak ditemukan']);
            }

            $statusBaru = '';

            if ($kendaraan['status'] == 'diproses') {
                $statusBaru = 'dijemput';
            } elseif ($kendaraan['status'] == 'dijemput') {
                $statusBaru = 'diproses';
            } else {
                return $this->response->setJSON([
                    'error' => 'Status tidak dapat diubah'
                ]);
            }

            $model->update($id, ['status' => $statusBaru]);

            return $this->response->setJSON(['sukses' => 'Status kendaraan berhasil diubah']);
        }
    }

    public function ubahbatal()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $model = new FakturKendaraan();
            $kendaraan = $model->find($id);

            if (!$kendaraan) {
                return $this->response->setJSON(['error' => 'Data kendaraan tidak ditemukan']);
            }

            if ($kendaraan['status'] !== 'pending') {
                return $this->response->setJSON([
                    'error' => 'Hanya kendaraan dengan status pending yang bisa dibatalkan'
                ]);
            }

            $model->update($id, ['status' => 'batal']);

            return $this->response->setJSON(['sukses' => 'Kendaraan berhasil dibatalkan']);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $idreservasi = $this->request->getPost('idreservasi');
            $db = db_connect();

            $faktur = $db->table('reservasi')
                ->where('idreservasi', $idreservasi)
                ->get()
                ->getRowArray();

            if (!$faktur) {
                return $this->response->setJSON(['error' => 'Data faktur tidak ditemukan']);
            }

            $nonPending = $db->table('detail_kendaraan')
                ->where('idreservasi', $idreservasi)
                ->where('status !=', 'pending')
                ->countAllResults();

            if ($nonPending > 0) {
                return $this->response->setJSON([
                    'error' => 'Hanya faktur dengan semua kendaraan berstatus pending yang bisa dihapus'
                ]);
            }

            $db->table('reservasi')->where('idreservasi', $idreservasi)->delete();

            return $this->response->setJSON(['sukses' => 'Data Faktur Berhasil Dihapus']);
        }
    }

    public function detail($idreservasi)
    {
        $db = db_connect();
        $faktur = $db->table('reservasi')
            ->select('reservasi.*, pelanggan.nama as nama_pelanggan, pelanggan.alamat, pelanggan.nohp,
                     (CASE WHEN (SELECT COUNT(*) FROM detail_kendaraan WHERE detail_kendaraan.idreservasi = reservasi.idreservasi) > 0 AND (SELECT COUNT(*) FROM detail_kendaraan WHERE detail_kendaraan.idreservasi = reservasi.idreservasi AND status = "selesai") = (SELECT COUNT(*) FROM detail_kendaraan WHERE detail_kendaraan.idreservasi = reservasi.idreservasi) THEN "lunas" ELSE reservasi.status_bayar END) as status_bayar')
            ->join('pelanggan', 'pelanggan.idpelanggan = reservasi.idpelanggan', 'left')
            ->where('reservasi.idreservasi', $idreservasi)
            ->get()->getRowArray();

        if (!$faktur) {
            return redirect()->back()->with('error', 'Data faktur tidak ditemukan');
        }

        $kendaraan = $db->table('detail_kendaraan')
            ->select('detail_kendaraan.*, karyawan.nama as nama_karyawan')
            ->join('karyawan', 'karyawan.idkaryawan = detail_kendaraan.idkaryawan', 'left')
            ->where('detail_kendaraan.idreservasi', $idreservasi)
            ->get()->getResultArray();

        foreach ($kendaraan as &$k) {
            $paketList = $db->table('detail_paket')
                ->select('detail_paket.*, paket_cucian.namapaket, paket_cucian.harga, paket_cucian.jenis')
                ->join('paket_cucian', 'paket_cucian.idpaket = detail_paket.idpaket')
                ->where('detail_paket.id_detail_kendaraan', $k['id'])
                ->get()->getResultArray();

            $k['paket_list'] = $paketList;
            $k['total_harga'] = array_sum(array_column($paketList, 'harga'));
        }

        $totalKeseluruhan = array_sum(array_column($kendaraan, 'total_harga'));

        $trackingUrl = site_url("faktur/tracking/$idreservasi");
        $qrCode = QrCode::create($trackingUrl)->setSize(300)->setMargin(10);
        $writer = new PngWriter();
        $qrCodeImage = $writer->write($qrCode)->getDataUri();

        return view('faktur/detail', [
            'faktur' => $faktur,
            'kendaraan' => $kendaraan,
            'totalKeseluruhan' => $totalKeseluruhan,
            'qrCodeImage' => $qrCodeImage
        ]);
    }

    public function cetakAntrian($idreservasi)
    {
        $db = db_connect();
        $faktur = $db->table('reservasi')
            ->select('reservasi.*, pelanggan.nama as nama_pelanggan, pelanggan.alamat, pelanggan.nohp')
            ->join('pelanggan', 'pelanggan.idpelanggan = reservasi.idpelanggan', 'left')
            ->where('reservasi.idreservasi', $idreservasi)
            ->get()->getRowArray();

        if (!$faktur) {
            return redirect()->back()->with('error', 'Data faktur tidak ditemukan');
        }

        $kendaraan = $db->table('detail_kendaraan')
            ->where('idreservasi', $idreservasi)
            ->get()->getResultArray();

        foreach ($kendaraan as &$k) {
            $paketList = $db->table('detail_paket')
                ->select('detail_paket.*, paket_cucian.namapaket, paket_cucian.harga')
                ->join('paket_cucian', 'paket_cucian.idpaket = detail_paket.idpaket')
                ->where('detail_paket.id_detail_kendaraan', $k['id'])
                ->get()->getResultArray();

            $k['paket_list'] = $paketList;
            $k['total_harga'] = array_sum(array_column($paketList, 'harga'));
        }

        $trackingUrl = site_url("faktur/tracking/$idreservasi");
        $qrCode = QrCode::create($trackingUrl)->setSize(200)->setMargin(5);
        $writer = new PngWriter();
        $qrCodeImage = $writer->write($qrCode)->getDataUri();

        return view('faktur/cetak_antrian', [
            'faktur' => $faktur,
            'kendaraan' => $kendaraan,
            'qrCodeImage' => $qrCodeImage
        ]);
    }

    public function formedit($idreservasi)
    {
        $db = db_connect();
        $faktur = $db->table('reservasi')
            ->select('reservasi.*, pelanggan.nama as nama_pelanggan, pelanggan.alamat, pelanggan.nohp')
            ->join('pelanggan', 'pelanggan.idpelanggan = reservasi.idpelanggan', 'left')
            ->where('reservasi.idreservasi', $idreservasi)
            ->get()->getRowArray();

        if (!$faktur) {
            return redirect()->back()->with('error', 'Data faktur tidak ditemukan');
        }

        $kendaraan = $db->table('detail_kendaraan')
            ->where('idreservasi', $idreservasi)
            ->get()->getResultArray();

        foreach ($kendaraan as &$k) {
            $paketList = $db->table('detail_paket')
                ->select('detail_paket.*, paket_cucian.namapaket, paket_cucian.harga, paket_cucian.jenis')
                ->join('paket_cucian', 'paket_cucian.idpaket = detail_paket.idpaket')
                ->where('detail_paket.id_detail_kendaraan', $k['id'])
                ->get()->getResultArray();

            $k['paket_list'] = $paketList;
        }

        return view('faktur/formedit', [
            'faktur' => $faktur,
            'kendaraan' => $kendaraan
        ]);
    }

    public function updatedata($idreservasi = null)
    {
        if ($this->request->isAJAX()) {
            if (!$idreservasi) {
                $idreservasi = $this->request->getPost('idreservasi');
            }
            $idpelanggan = $this->request->getPost('idpelanggan');
            $kendaraan = $this->request->getPost('kendaraan');
            $hapus_kendaraan = $this->request->getPost('hapus_kendaraan');

            $rules = [
                'idpelanggan' => [
                    'label' => 'Pelanggan',
                    'rules' => 'required',
                    'errors' => ['required' => '{field} tidak boleh kosong']
                ]
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'error' => ['error_idpelanggan' => $this->validator->getError('idpelanggan')]
                ]);
            }

            if (empty($kendaraan) || !is_array($kendaraan)) {
                return $this->response->setJSON([
                    'error' => 'Minimal 1 kendaraan harus ada'
                ]);
            }

            foreach ($kendaraan as $i => $k) {
                if (empty($k['platnomor'])) {
                    return $this->response->setJSON([
                        'error' => 'Plat nomor kendaraan ke-' . ($i + 1) . ' tidak boleh kosong'
                    ]);
                }
                if (empty($k['paket']) || !is_array($k['paket']) || count($k['paket']) == 0) {
                    return $this->response->setJSON([
                        'error' => 'Minimal 1 paket harus dipilih untuk kendaraan ke-' . ($i + 1)
                    ]);
                }
            }

            $db = db_connect();
            $modelKendaraan = new FakturKendaraan();
            $modelPaket = new FakturPaket();

            $db->transStart();

            $db->table('reservasi')
                ->where('idreservasi', $idreservasi)
                ->update(['idpelanggan' => $idpelanggan]);

            if (!empty($hapus_kendaraan) && is_array($hapus_kendaraan)) {
                foreach ($hapus_kendaraan as $idKendaraanHapus) {
                    $kData = $modelKendaraan->find($idKendaraanHapus);
                    if ($kData && $kData['status'] === 'pending' && $kData['idreservasi'] === $idreservasi) {
                        $modelKendaraan->delete($idKendaraanHapus);
                    }
                }
            }

            foreach ($kendaraan as $k) {
                if (!empty($k['id'])) {
                    $existing = $modelKendaraan->find($k['id']);
                    if ($existing && $existing['status'] === 'pending' && $existing['idreservasi'] === $idreservasi) {
                        $modelKendaraan->update($k['id'], [
                            'platnomor' => strtoupper($k['platnomor']),
                        ]);

                        $db->table('detail_paket')
                            ->where('id_detail_kendaraan', $k['id'])
                            ->delete();

                        foreach ($k['paket'] as $idpaket) {
                            $db->table('detail_paket')->insert([
                                'id_detail_kendaraan' => $k['id'],
                                'idpaket' => $idpaket,
                            ]);
                        }
                    }
                } else {
                    $db->table('detail_kendaraan')->insert([
                        'idreservasi' => $idreservasi,
                        'platnomor' => strtoupper($k['platnomor']),
                        'idkaryawan' => null,
                        'status' => 'pending',
                    ]);
                    $idKendaraan = $db->insertID();

                    foreach ($k['paket'] as $idpaket) {
                        $db->table('detail_paket')->insert([
                            'id_detail_kendaraan' => $idKendaraan,
                            'idpaket' => $idpaket,
                        ]);
                    }
                }
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                return $this->response->setJSON(['error' => 'Gagal mengupdate data faktur']);
            }

            return $this->response->setJSON(['sukses' => 'Data faktur berhasil diupdate']);
        }
    }

    public function tracking($idreservasi = null)
    {
        if (!$idreservasi) {
            return redirect()->to(base_url());
        }

        $db = db_connect();
        $faktur = $db->table('reservasi')
            ->select('reservasi.*, pelanggan.nama as nama_pelanggan, pelanggan.alamat, pelanggan.nohp')
            ->join('pelanggan', 'pelanggan.idpelanggan = reservasi.idpelanggan', 'left')
            ->where('reservasi.idreservasi', $idreservasi)
            ->get()->getRowArray();

        if (!$faktur) {
            return view('home/tracking_faktur', [
                'error' => 'ID Faktur tidak ditemukan. Pastikan ID yang Anda masukkan benar.'
            ]);
        }

        $kendaraan = $db->table('detail_kendaraan')
            ->select('detail_kendaraan.*, karyawan.nama as nama_karyawan')
            ->join('karyawan', 'karyawan.idkaryawan = detail_kendaraan.idkaryawan', 'left')
            ->where('detail_kendaraan.idreservasi', $idreservasi)
            ->get()->getResultArray();

        foreach ($kendaraan as &$k) {
            $paketList = $db->table('detail_paket')
                ->select('paket_cucian.namapaket, paket_cucian.harga')
                ->join('paket_cucian', 'paket_cucian.idpaket = detail_paket.idpaket')
                ->where('detail_paket.id_detail_kendaraan', $k['id'])
                ->get()->getResultArray();

            $k['paket_list'] = $paketList;
        }

        return view('home/tracking_faktur', [
            'faktur' => $faktur,
            'kendaraan' => $kendaraan
        ]);
    }
}
