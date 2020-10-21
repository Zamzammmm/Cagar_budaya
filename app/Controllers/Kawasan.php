<?php

namespace App\Controllers;

use CodeIgniter\HTTP\Request;
use App\Models\KawasanModel;

class Kawasan extends BaseController
{
    protected $kawasanModel;
    public function __construct()
    {
        $this->kawasanModel = new KawasanModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Kawasan Cagar Budaya',
            'kawasan' => $this->kawasanModel->getKawasan()
        ];

        return view('kawasan/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Form Tambah Data Kawasan',
        ];
        return view('kawasan/create', $data);
    }

    public function save()
    {
        $this->kawasanModel->save([
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

        return redirect()->to('/kawasan');
    }

    public function delete($id)
    {
        $this->kawasanModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('/kawasan');
    }

    public function edit($id)
    {
        $kawasan = $this->kawasanModel->query("SELECT * from kawasan where id= {$id} ")->getResult('array');
        $array = array();
        foreach ($kawasan as $data) {
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
        $this->kawasanModel->save([
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

        return redirect()->to('/kawasan');
    }
}
