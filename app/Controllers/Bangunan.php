<?php

namespace App\Controllers;

use CodeIgniter\HTTP\Request;
use App\Models\BangunanModel;

class Bangunan extends BaseController
{
    protected $bangunanModel;
    public function __construct()
    {
        $this->bangunanModel = new BangunanModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Bangunan Cagar Budaya',
            'bangunan' => $this->bangunanModel->getBangunan()
        ];

        return view('bangunan/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Form Tambah Data Bangunan',
        ];
        return view('bangunan/create', $data);
    }

    public function save()
    {
        $this->bangunanModel->save([
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

        return redirect()->to('/bangunan');
    }

    public function delete($id)
    {
        $this->bangunanModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('/bangunan');
    }

    public function edit($id)
    {
        $bangunan = $this->bangunanModel->query("SELECT * from bangunan where id= {$id} ")->getResult('array');
        $array = array();
        foreach ($bangunan as $data) {
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
        $this->bangunanModel->save([
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

        return redirect()->to('/bangunan');
    }
}
