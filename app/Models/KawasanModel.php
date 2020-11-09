<?php

namespace App\Models;

use CodeIgniter\Model;

class KawasanModel extends Model
{
    protected $table = 'kawasan';
    protected $useTimestamps = true;
    protected $allowedFields = ['judul', 'foto', 'no_regnas', 'sk_penetapan', 'kategori_cb', 'kabupaten_kota', 'provinsi', 'nama_pemilik', 'nama_pengelola'];

    public function getKawasan($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->where(['id' => $id])->first();
    }
}
