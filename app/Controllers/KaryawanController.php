<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Karyawan as ModelsKaryawan;
use Hermawan\DataTables\DataTable;

class KaryawanController extends BaseController
{
    public function index()
    {
        $title = [
            'title' => 'Kelola Data Karyawan'
        ];
        return view('karyawan/datakaryawan', $title);
    }

    public function viewKaryawan()
    {
        $db = db_connect();
        $query = $db->table('karyawan')
            ->select('idkaryawan, nama, nohp, alamat');

        return DataTable::of($query)
            ->add('action', function ($row) {
                $button1 = '<button type="button" class="btn btn-primary btn-sm btn-detail" data-idkaryawan="' . $row->idkaryawan . '" data-toggle="modal" data-target="#detailModal"><i class="fas fa-eye"></i></button>';
                $button2 = '<button type="button" class="btn btn-secondary btn-sm btn-edit" data-idkaryawan="' . $row->idkaryawan . '" style="margin-left: 5px;"><i class="fas fa-pencil-alt"></i></button>';
                $button3 = '<button type="button" class="btn btn-danger btn-sm btn-delete" data-idkaryawan="' . $row->idkaryawan . '" style="margin-left: 5px;"><i class="fas fa-trash"></i></button>';

                $buttonsGroup = '<div style="display: flex;">' . $button1 . $button2 . $button3 . '</div>';
                return $buttonsGroup;
            }, 'last')
            ->addNumbering()
            ->toJson();
    }

    public function formtambah()
    {
        $db = db_connect();
        $query = $db->query("SELECT CONCAT('KW', LPAD(IFNULL(MAX(SUBSTRING(idkaryawan, 3)) + 1, 1), 4, '0')) AS auto_number FROM karyawan");
        $row = $query->getRow();
        $title ='Form Tambah Karyawan';
        $data = [
            'title' => $title,
            'auto_number' => $row->auto_number
        ];
        return view('karyawan/formtambah', $data);
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $idkaryawan = $this->request->getPost('idkaryawan');
            $nama = $this->request->getPost('nama');
            $alamat = $this->request->getPost('alamat');
            $nohp = $this->request->getPost('nohp');

            $rules = [
                'nama' => [
                    'label' => 'Nama Karyawan',
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
                $modelKaryawan = new ModelsKaryawan();
                $modelKaryawan->insert([
                    'idkaryawan' => $idkaryawan,
                    'nama' => $nama,
                    'alamat' => $alamat,
                    'nohp' => $nohp
                ]);

                $json = [
                    'sukses' => 'Berhasil Simpan Data Karyawan'
                ];
            }

            return $this->response->setJSON($json);
        } else {
            return $this->response->setJSON([
                'error' => 'Akses tidak valid' 
            ]);
        }
    }


    public function delete()
    {
        if ($this->request->isAJAX()) {
            $idkaryawan = $this->request->getPost('idkaryawan');

            $model = new ModelsKaryawan();
            $model->where('idkaryawan', $idkaryawan)->delete();

            $json = [
                'sukses' => 'Data Karyawan Berhasil Dihapus'
            ];
            return $this->response->setJSON($json);
        }
    }

    public function formedit($idkaryawan)
    {
        $db = db_connect();
        $karyawan = $db->table('karyawan')
            ->select('karyawan.*')
            ->where('karyawan.idkaryawan', $idkaryawan)
            ->get()
            ->getRowArray();

        if (!$karyawan) {
            return redirect()->to('/karyawan')->with('error', 'Data Karyawan tidak ditemukan');
        }

        $data = [
            'karyawan' => $karyawan
        ];

        return view('karyawan/formedit', $data);
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $idkaryawan = $this->request->getPost('idkaryawan');
            $nama = $this->request->getPost('nama');
            $alamat = $this->request->getPost('alamat');
            $nohp = $this->request->getPost('nohp');

            $rules = [
                'nama' => [
                    'label' => 'Nama Karyawan',
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
            ];

            if (!$this->validate($rules)) {
                $errors = [];
                foreach ($rules as $field => $rule) {
                    $errors["error_$field"] = $this->validator->getError($field);
                }

                return $this->response->setJSON([
                    'error' => $errors
                ]);
            }

            $model = new ModelsKaryawan();
            
            $dataUpdate = [
                'nama' => $nama,
                'alamat' => $alamat,
                'nohp' => $nohp,
            ];

            $model->update($idkaryawan, $dataUpdate);

            return $this->response->setJSON([
                'sukses' => 'Data karyawan berhasil diperbarui'
            ]);
        }

        return $this->response->setJSON([
            'error' => 'Akses tidak valid'
        ]);
    }


    public function detail($idkaryawan)
    {
        $db = db_connect();
        $karyawan = $db->table('karyawan')->select('*')
            ->where('idkaryawan', $idkaryawan)->get()->getRowArray();

        if (!$karyawan) {
            return redirect()->back()->with('error', 'Data karyawan tidak ditemukan');
        }

        $data = [
            'karyawan' => $karyawan
        ];

        return view('karyawan/detail', $data);
    }
}
