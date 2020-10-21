<?php

namespace App\Controllers;

use CodeIgniter\HTTP\Request;
use App\Models\SitusModel;

class Situs extends BaseController
{
    protected $situsModel;
    public function __construct()
    {
        $this->situsModel = new SitusModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Situs Cagar Budaya',
            'situs' => $this->situsModel->getSitus()
        ];

        return view('situs/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Form Tambah Data Situs',
        ];
        return view('situs/create', $data);
    }

    public function save()
    {
        $this->situsModel->save([
            'judul' => $this->request->getVar('judul'),
            'no_regnas' => $this->request->getVar('no_regnas'),
            'sk_penetapan' => $this->request->getVar('sk_penetapan'),
            'kategori_cb' => $this->request->getVar('kategori_cb'),
            'kabupaten_kota' => $this->request->getVar('kabupaten_kota'),
            'provinsi' => $this->request->getVar('provinsi'),
            'nama_pemilik' => $this->request->getVar('nama_pemilik'),
            'nama_pengelola' => $this->request->getVar('nama_pengelola'),
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');

        return redirect()->to('/situs');
    }

    public function delete($id)
    {
        $this->situsModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('/situs');
    }

    public function edit($id)
    {
        $situs = $this->situsModel->query("SELECT * from situs where id= {$id} ")->getResult('array');
        $array = array();
        foreach ($situs as $data) {
            $array['judul'] = $data['judul'];
            $array['no_regnas'] = $data['no_regnas'];
            $array['sk_penetapan'] = $data['sk_penetapan'];
            $array['kategori_cb'] = $data['kategori_cb'];
            $array['kabupaten_kota'] = $data['kabupaten_kota'];
            $array['provinsi'] = $data['provinsi'];
            $array['nama_pemilik'] = $data['nama_pemilik'];
            $array['nama_pengelola'] = $data['nama_pengelola'];
        }
        $hasil_arr = array('data' => $array);
        echo json_encode($hasil_arr);
    }

    public function update($id)
    {
        $this->situsModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'no_regnas' => $this->request->getVar('no_regnas'),
            'sk_penetapan' => $this->request->getVar('sk_penetapan'),
            'kategori_cb' => $this->request->getVar('kategori_cb'),
            'kabupaten_kota' => $this->request->getVar('kabupaten_kota'),
            'provinsi' => $this->request->getVar('provinsi'),
            'nama_pemilik' => $this->request->getVar('nama_pemilik'),
            'nama_pengelola' => $this->request->getVar('nama_pengelola'),
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah.');

        return redirect()->to('/situs');
    }
}
