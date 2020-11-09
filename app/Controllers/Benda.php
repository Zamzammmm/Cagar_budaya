<?php

namespace App\Controllers;

use CodeIgniter\HTTP\Request;
use App\Models\BendaModel;

class Benda extends BaseController
{
    protected $bendaModel;
    public function __construct()
    {
        $this->bendaModel = new BendaModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Benda Cagar Budaya',
            'benda' => $this->bendaModel->getBenda()
        ];

        return view('benda/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Form Tambah Data Benda',
        ];
        return view('benda/create', $data);
    }

    public function save()
    {
        // ambil gambar
        $uniq = time();
        $filefoto = $this->request->getFile('foto');
        // generate nama foto Random
        $namafoto = $uniq . "_" . $filefoto->getName();
        // pindahkan file ke folder img
        $filefoto->move('img', $namafoto);

        $this->bendaModel->save([
            'judul' => $this->request->getVar('judul'),
            'foto' => $namafoto,
            'no_regnas' => $this->request->getVar('no_regnas'),
            'sk_penetapan' => $this->request->getVar('sk_penetapan'),
            'kategori_cb' => $this->request->getVar('kategori_cb'),
            'kabupaten_kota' => $this->request->getVar('kabupaten_kota'),
            'provinsi' => $this->request->getVar('provinsi'),
            'nama_pemilik' => $this->request->getVar('nama_pemilik'),
            'nama_pengelola' => $this->request->getVar('nama_pengelola'),
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');

        return redirect()->to('/benda');
    }

    public function delete($id)
    {
        $this->bendaModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('/benda');
    }

    public function edit($id)
    {
        $benda = $this->bendaModel->query("SELECT * from benda where id= {$id} ")->getResult('array');
        $array = array();
        foreach ($benda as $data) {
            $array['judul'] = $data['judul'];
            $array['foto'] = $data['foto'];
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
        if (!empty($_FILES['foto']['name'])) {
            $uniq = time();
            $filefoto = $this->request->getFile('foto');
            // Findah Folder
            $namafoto = $uniq . "_" . $filefoto->getName();

            // Ambil Nama
            $filefoto->move('img', $namafoto);
        } else {
            $namafoto = $this->request->getVar('oldfoto');
        }

        $this->bendaModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'no_regnas' => $this->request->getVar('no_regnas'),
            'sk_penetapan' => $this->request->getVar('sk_penetapan'),
            'kategori_cb' => $this->request->getVar('kategori_cb'),
            'kabupaten_kota' => $this->request->getVar('kabupaten_kota'),
            'provinsi' => $this->request->getVar('provinsi'),
            'nama_pemilik' => $this->request->getVar('nama_pemilik'),
            'nama_pengelola' => $this->request->getVar('nama_pengelola'),
            'foto' => $namafoto
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah.');

        return redirect()->to('/benda');
    }
}
