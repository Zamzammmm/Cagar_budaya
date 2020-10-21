<?php

namespace App\Models;

use CodeIgniter\Model;

class SitusModel extends Model
{
    protected $table = 'situs';
    protected $useTimestamps = true;
    protected $allowedFields = ['judul', 'no_regnas', 'sk_penetapan', 'kategori_cb', 'kabupaten_kota', 'provinsi', 'nama_pemilik', 'nama_pengelola'];

    public function getSitus($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->where(['id' => $id])->first();
    }
}