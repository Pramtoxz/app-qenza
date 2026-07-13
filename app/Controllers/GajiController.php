<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Gaji as ModelGaji;
use Hermawan\DataTables\DataTable;

class GajiController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Kelola Gaji Karyawan'
        ];
        return view('gaji/datagaji', $data);
    }

    public function viewGaji()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $gaji = $db->table('gaji_karyawan')
                ->select('gaji_karyawan.idgaji, karyawan.nama as nama_karyawan, gaji_karyawan.bulan, gaji_karyawan.tahun, gaji_karyawan.jumlah_cucian, gaji_karyawan.total_upah, gaji_karyawan.bonus, gaji_karyawan.potongan, gaji_karyawan.total_bayar, gaji_karyawan.tanggal_bayar, gaji_karyawan.status')
                ->join('karyawan', 'karyawan.idkaryawan = gaji_karyawan.idkaryawan');

            return DataTable::of($gaji)
                ->add('action', function ($row) {
                    $button1 = '<button type="button" class="btn btn-primary btn-sm btn-detail" data-idgaji="' . $row->idgaji . '"><i class="ri-eye-line"></i></button>';
                    $button2 = '<button type="button" class="btn btn-secondary btn-sm btn-edit" data-idgaji="' . $row->idgaji . '" style="margin-left: 5px;"><i class="ri-pencil-line"></i></button>';
                    $button3 = '<button type="button" class="btn btn-danger btn-sm btn-delete" data-idgaji="' . $row->idgaji . '" style="margin-left: 5px;"><i class="ri-delete-bin-line"></i></button>';
                    $buttonsGroup = '<div style="display: flex;">' . $button1 . $button2 . $button3 . '</div>';
                    return $buttonsGroup;
                }, 'last')
                ->hide('tahun')
                ->hide('bonus')
                ->hide('potongan')
                ->edit('bulan', function ($row) {
                    $bulan = [
                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                    ];
                    return ($bulan[$row->bulan] ?? $row->bulan) . ' ' . $row->tahun;
                })
                ->edit('total_upah', function ($row) {
                    return 'Rp. ' . number_format($row->total_upah, 0, ',', '.');
                })
                ->edit('total_bayar', function ($row) {
                    return 'Rp. ' . number_format($row->total_bayar, 0, ',', '.');
                })
                ->edit('tanggal_bayar', function ($row) {
                    return $row->tanggal_bayar ? date('d/m/Y', strtotime($row->tanggal_bayar)) : '-';
                })
                ->edit('status', function ($row) {
                    if ($row->status == 'draft') {
                        return '<span class="badge bg-warning text-dark">Draft</span>';
                    }
                    return '<span class="badge bg-success">Dibayar</span>';
                })
                ->addNumbering()
                ->toJson();
        }
    }

    public function formtambah()
    {
        $db = db_connect();
        $today = date('Ymd');
        $prefix = "GJI-$today-";

        $query = $db->query("SELECT idgaji FROM gaji_karyawan WHERE idgaji LIKE ?", ["$prefix%"]);
        $results = $query->getResultArray();

        if (empty($results)) {
            $nextNo = 1;
        } else {
            $numbers = [];
            foreach ($results as $row) {
                $num = substr($row['idgaji'], strlen($prefix));
                if (is_numeric($num)) {
                    $numbers[] = (int)$num;
                }
            }
            $nextNo = !empty($numbers) ? max($numbers) + 1 : 1;
        }

        $next_id = $prefix . str_pad($nextNo, 4, '0', STR_PAD_LEFT);

        return view('gaji/formtambah', [
            'next_id' => $next_id
        ]);
    }

    public function getKaryawan()
    {
        return view('gaji/getkaryawan');
    }

    public function viewGetKaryawan()
    {
        if ($this->request->isAJAX()) {
            $bulan = $this->request->getGet('bulan');
            $tahun = $this->request->getGet('tahun');

            $db = db_connect();
            $builder = $db->table('karyawan')
                ->select('karyawan.idkaryawan, karyawan.nama, karyawan.alamat, karyawan.nohp,
                         existing.idgaji as existing_idgaji')
                ->join('(SELECT idkaryawan, idgaji FROM gaji_karyawan WHERE bulan = ' . intval($bulan) . ' AND tahun = ' . intval($tahun) . ') as existing', 
                         'existing.idkaryawan = karyawan.idkaryawan', 'left')
                ->where('existing.idkaryawan IS NULL');

            return DataTable::of($builder)
                ->add('action', function ($row) {
                    return '<button type="button" class="btn btn-primary btn-sm btn-pilihkaryawan-gaji" 
                                data-idkaryawan="' . $row->idkaryawan . '" 
                                data-nama="' . esc($row->nama) . '"
                                data-alamat="' . esc($row->alamat) . '"
                                data-nohp="' . esc($row->nohp) . '">Pilih</button>';
                }, 'last')
                ->hide('existing_idgaji')
                ->addNumbering()
                ->toJson();
        }
    }

    public function hitungUpah()
    {
        if ($this->request->isAJAX()) {
            $idkaryawan = $this->request->getPost('idkaryawan');
            $bulan = $this->request->getPost('bulan');
            $tahun = $this->request->getPost('tahun');

            if (!$idkaryawan || !$bulan || !$tahun) {
                return $this->response->setJSON(['error' => 'Lengkapi semua field']);
            }

            $db = db_connect();

            $pencucianList = $db->table('pencucian')
                ->select('pencucian.idpencucian, pencucian.idpaket, pencucian.idpaket2, 
                         paket_cucian.upah as upah1, paket2.upah as upah2')
                ->join('paket_cucian', 'paket_cucian.idpaket = pencucian.idpaket')
                ->join('paket_cucian as paket2', 'paket2.idpaket = pencucian.idpaket2', 'left')
                ->join('kendaraan_selesai', 'kendaraan_selesai.idpencucian = pencucian.idpencucian')
                ->where('pencucian.idkaryawan', $idkaryawan)
                ->where('pencucian.status', 'selesai')
                ->where('MONTH(pencucian.tgl)', $bulan)
                ->where('YEAR(pencucian.tgl)', $tahun)
                ->get()
                ->getResultArray();

            $totalUpah = 0;
            foreach ($pencucianList as $p) {
                $totalUpah += ($p['upah1'] ?? 0) + ($p['upah2'] ?? 0);
            }

            return $this->response->setJSON([
                'sukses' => true,
                'jumlah_cucian' => count($pencucianList),
                'total_upah' => $totalUpah
            ]);
        }
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $idgaji = $this->request->getPost('idgaji');
            $idkaryawan = $this->request->getPost('idkaryawan');
            $bulan = $this->request->getPost('bulan');
            $tahun = $this->request->getPost('tahun');
            $jumlah_cucian = $this->request->getPost('jumlah_cucian');
            $total_upah = $this->request->getPost('total_upah');
            $bonus = $this->request->getPost('bonus') ?: 0;
            $potongan = $this->request->getPost('potongan') ?: 0;
            $tanggal_bayar = $this->request->getPost('tanggal_bayar');
            $status = $this->request->getPost('status');

            $rules = [
                'idkaryawan' => [
                    'label' => 'Karyawan',
                    'rules' => 'required',
                    'errors' => ['required' => '{field} harus dipilih']
                ],
                'bulan' => [
                    'label' => 'Bulan',
                    'rules' => 'required',
                    'errors' => ['required' => '{field} harus dipilih']
                ],
                'tahun' => [
                    'label' => 'Tahun',
                    'rules' => 'required',
                    'errors' => ['required' => '{field} harus diisi']
                ],
            ];

            if (!$this->validate($rules)) {
                $errors = [];
                foreach ($rules as $field => $rule) {
                    $errors["error_$field"] = $this->validator->getError($field);
                }
                return $this->response->setJSON(['error' => $errors]);
            }

            $model = new ModelGaji();
            $existing = $model->where('idkaryawan', $idkaryawan)
                              ->where('bulan', $bulan)
                              ->where('tahun', $tahun)
                              ->first();

            if ($existing) {
                $bulanNama = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                return $this->response->setJSON([
                    'error' => ['error_idkaryawan' => 'Gaji karyawan ini untuk ' . $bulanNama[$bulan] . ' ' . $tahun . ' sudah ada (ID: ' . $existing['idgaji'] . ')']
                ]);
            }

            $total_bayar = $total_upah + $bonus - $potongan;

            $model = new ModelGaji();
            $model->insert([
                'idgaji' => $idgaji,
                'idkaryawan' => $idkaryawan,
                'bulan' => $bulan,
                'tahun' => $tahun,
                'jumlah_cucian' => $jumlah_cucian,
                'total_upah' => $total_upah,
                'bonus' => $bonus,
                'potongan' => $potongan,
                'total_bayar' => $total_bayar,
                'tanggal_bayar' => $tanggal_bayar ?: null,
                'status' => $status ?: 'draft',
            ]);

            return $this->response->setJSON([
                'sukses' => 'Data gaji berhasil disimpan',
                'idgaji' => $idgaji
            ]);
        }
    }

    public function detail($idgaji)
    {
        $db = db_connect();
        $gaji = $db->table('gaji_karyawan')
            ->select('gaji_karyawan.*, karyawan.nama as nama_karyawan, karyawan.alamat, karyawan.nohp')
            ->join('karyawan', 'karyawan.idkaryawan = gaji_karyawan.idkaryawan')
            ->where('idgaji', $idgaji)
            ->get()
            ->getRowArray();

        if (!$gaji) {
            return redirect()->back()->with('error', 'Data gaji tidak ditemukan');
        }

        $pencucianList = $db->table('pencucian')
            ->select('pencucian.idpencucian, pencucian.tgl, pencucian.platnomor,
                     paket_cucian.namapaket, paket_cucian.upah as upah1,
                     paket2.namapaket as namapaket2, paket2.upah as upah2')
            ->join('paket_cucian', 'paket_cucian.idpaket = pencucian.idpaket')
            ->join('paket_cucian as paket2', 'paket2.idpaket = pencucian.idpaket2', 'left')
            ->where('pencucian.idkaryawan', $gaji['idkaryawan'])
            ->where('pencucian.status', 'selesai')
            ->where('MONTH(pencucian.tgl)', $gaji['bulan'])
            ->where('YEAR(pencucian.tgl)', $gaji['tahun'])
            ->get()
            ->getResultArray();

        return view('gaji/detail', [
            'gaji' => $gaji,
            'pencucianList' => $pencucianList
        ]);
    }

    public function slip($idgaji)
    {
        $db = db_connect();
        $gaji = $db->table('gaji_karyawan')
            ->select('gaji_karyawan.*, karyawan.nama as nama_karyawan, karyawan.alamat, karyawan.nohp')
            ->join('karyawan', 'karyawan.idkaryawan = gaji_karyawan.idkaryawan')
            ->where('idgaji', $idgaji)
            ->get()
            ->getRowArray();

        if (!$gaji) {
            return redirect()->back()->with('error', 'Data gaji tidak ditemukan');
        }

        $pencucianList = $db->table('pencucian')
            ->select('pencucian.idpencucian, pencucian.tgl, pencucian.platnomor,
                     paket_cucian.namapaket, paket_cucian.upah as upah1,
                     paket2.namapaket as namapaket2, paket2.upah as upah2')
            ->join('paket_cucian', 'paket_cucian.idpaket = pencucian.idpaket')
            ->join('paket_cucian as paket2', 'paket2.idpaket = pencucian.idpaket2', 'left')
            ->where('pencucian.idkaryawan', $gaji['idkaryawan'])
            ->where('pencucian.status', 'selesai')
            ->where('MONTH(pencucian.tgl)', $gaji['bulan'])
            ->where('YEAR(pencucian.tgl)', $gaji['tahun'])
            ->get()
            ->getResultArray();

        return view('gaji/slip', [
            'gaji' => $gaji,
            'pencucianList' => $pencucianList
        ]);
    }

    public function formedit($idgaji)
    {
        $db = db_connect();
        $gaji = $db->table('gaji_karyawan')
            ->select('gaji_karyawan.*, karyawan.nama as nama_karyawan')
            ->join('karyawan', 'karyawan.idkaryawan = gaji_karyawan.idkaryawan')
            ->where('idgaji', $idgaji)
            ->get()
            ->getRowArray();

        if (!$gaji) {
            return redirect()->back()->with('error', 'Data gaji tidak ditemukan');
        }

        $karyawan = $db->table('karyawan')->select('idkaryawan, nama')->get()->getResultArray();

        return view('gaji/formedit', [
            'gaji' => $gaji,
            'karyawan' => $karyawan
        ]);
    }

    public function updatedata($idgaji = null)
    {
        if ($this->request->isAJAX()) {
            if (!$idgaji) {
                $idgaji = $this->request->getPost('idgaji');
            }

            $bonus = $this->request->getPost('bonus') ?: 0;
            $potongan = $this->request->getPost('potongan') ?: 0;
            $tanggal_bayar = $this->request->getPost('tanggal_bayar');
            $status = $this->request->getPost('status');

            $model = new ModelGaji();
            $gaji = $model->where('idgaji', $idgaji)->first();

            if (!$gaji) {
                return $this->response->setJSON(['error' => 'Data gaji tidak ditemukan']);
            }

            $total_bayar = $gaji['total_upah'] + $bonus - $potongan;

            $model->update($idgaji, [
                'bonus' => $bonus,
                'potongan' => $potongan,
                'total_bayar' => $total_bayar,
                'tanggal_bayar' => $tanggal_bayar ?: null,
                'status' => $status,
            ]);

            return $this->response->setJSON(['sukses' => 'Data gaji berhasil diupdate']);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $idgaji = $this->request->getPost('idgaji');

            $model = new ModelGaji();
            $model->where('idgaji', $idgaji)->delete();

            return $this->response->setJSON(['sukses' => 'Data gaji berhasil dihapus']);
        }
    }
}
