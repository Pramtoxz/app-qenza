<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Pelanggan as ModelsPelanggan;
use Hermawan\DataTables\DataTable;

class PelangganController extends BaseController
{
    public function index()
    {
        $title = [
            'title' => 'Kelola Data Pelanggan'
        ];
        return view('pelanggan/datapelanggan', $title);
    }

    public function viewPelanggan()
    {
        $db = db_connect();
        $query = $db->table('pelanggan')
            ->select('idpelanggan, nama, nohp, jk, platnomor');

        return DataTable::of($query)
            ->add('action', function ($row) {
                $button1 = '<button type="button" class="btn btn-primary btn-sm btn-detail" data-idpelanggan="' . $row->idpelanggan . '" data-toggle="modal" data-target="#detailModal"><i class="fas fa-eye"></i></button>';
                $button2 = '<button type="button" class="btn btn-secondary btn-sm btn-edit" data-idpelanggan="' . $row->idpelanggan . '" style="margin-left: 5px;"><i class="fas fa-pencil-alt"></i></button>';
                $button3 = '<button type="button" class="btn btn-danger btn-sm btn-delete" data-idpelanggan="' . $row->idpelanggan . '" style="margin-left: 5px;"><i class="fas fa-trash"></i></button>';

                $buttonsGroup = '<div style="display: flex;">' . $button1 . $button2 . $button3 . '</div>';
                return $buttonsGroup;
            }, 'last')
            ->edit('jk', function ($row) {
                return $row->jk == 'L' ? 'Laki-laki' : 'Perempuan';
            })
            ->addNumbering()
            ->toJson();
    }

    public function formtambah()
    {
        $db = db_connect();
        $query = $db->query("SELECT CONCAT('PL', LPAD(IFNULL(MAX(SUBSTRING(idpelanggan, 3)) + 1, 1), 4, '0')) AS auto_number FROM pelanggan");
        $row = $query->getRow();
        $title ='Form Tambah Pelanggan';
        $data = [
            'title' => $title,
            'auto_number' => $row->auto_number
        ];
        return view('pelanggan/formtambah', $data);
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $idpelanggan = $this->request->getPost('idpelanggan');
            $nama = $this->request->getPost('nama');
            $alamat = $this->request->getPost('alamat');
            $nohp = $this->request->getPost('nohp');
            $jk = $this->request->getPost('jk');
            $platnomor = $this->request->getPost('platnomor');

            $rules = [
                'nama' => [
                    'label' => 'Nama Pelanggan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'alamat' => [
                    'label' => 'Alamat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'nohp' => [
                    'label' => 'No HP',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'jk' => [
                    'label' => 'Jenkel',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'platnomor' => [
                    'label' => 'Plat Nomor',
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

                $json = [
                    'error' => $errors
                ];
            } else {
                $modelPelanggan = new ModelsPelanggan();
                $modelPelanggan->insert([
                    'idpelanggan' => $idpelanggan,
                    'nama' => $nama,
                    'alamat' => $alamat,
                    'nohp' => $nohp,
                    'jk' => $jk,
                    'platnomor' => $platnomor,
                ]);

                $json = [
                    'sukses' => 'Berhasil Simpan Data'
                ];
            }

            return $this->response->setJSON($json); // Lebih rapi pakai setJSON
        } else {
            return $this->response->setJSON([
                'error' => 'Akses tidak valid' // respon default kalau bukan AJAX
            ]);
        }
    }


    public function delete()
    {
        if ($this->request->isAJAX()) {
            $idpelanggan = $this->request->getPost('idpelanggan');

            $model = new ModelsPelanggan();
            $model->where('idpelanggan', $idpelanggan)->delete();

            $json = [
                'sukses' => 'Data Pelanggan Berhasil Dihapus'
            ];
            return $this->response->setJSON($json);
        }
    }

    public function formedit($idpelanggan)
    {
        $db = db_connect();
        
        // Join tabel tamu dengan users untuk mendapatkan email
        $pelanggan = $db->table('pelanggan')
            ->select('pelanggan.*')
            ->where('pelanggan.idpelanggan', $idpelanggan)
            ->get()
            ->getRowArray();

        if (!$pelanggan) {
            return redirect()->to('/pelanggan')->with('error', 'Data Pelanggan tidak ditemukan');
        }

        $data = [
            'pelanggan' => $pelanggan
        ];

        return view('pelanggan/formedit', $data);
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $idpelanggan = $this->request->getPost('idpelanggan');
            $nama = $this->request->getPost('nama');
            $alamat = $this->request->getPost('alamat');
            $nohp = $this->request->getPost('nohp');
            $jk = $this->request->getPost('jk');
            $platnomor = $this->request->getPost('platnomor');

            $rules = [
                'nama' => [
                    'label' => 'Nama Pelanggan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'alamat' => [
                    'label' => 'Alamat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'nohp' => [
                    'label' => 'No HP',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'jk' => [
                    'label' => 'Jenkel',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'platnomor' => [
                    'label' => 'Plat Nomor',
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

                $json = [
                    'error' => $errors
                ];
            } else {
                $model = new ModelsPelanggan();
                
                $dataUpdate = [
                    'nama' => $nama,
                    'alamat' => $alamat,
                    'nohp' => $nohp,
                    'jk' => $jk,
                    'platnomor' => $platnomor,
                ];

                $model->update($idpelanggan, $dataUpdate);

                $json = [
                    'sukses' => 'Data berhasil diupdate'
                ];
            }

            return $this->response->setJSON($json);
        } else {
            return $this->response->setJSON([
                'error' => 'Akses tidak valid'
            ]);
        }
    }


    public function detail($idpelanggan)
    {
        $db = db_connect();
        $pelanggan = $db->table('pelanggan')->select('*')
            ->where('idpelanggan', $idpelanggan)->get()->getRowArray();

        if (!$pelanggan) {
            return redirect()->back()->with('error', 'Data pelanggan tidak ditemukan');
        }

        $data = [
            'pelanggan' => $pelanggan
        ];

        return view('pelanggan/detail', $data);
    }
}
