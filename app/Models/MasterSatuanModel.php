<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterSatuanModel extends Model
{
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $table = 'mst_satuan';
    protected $allowedFields = ['nama_satuan'];

    public function getAll()
    {
        return $this
            ->table($this->table)
            ->select('kd_satuan')
            ->select('nama_satuan')
            ->get()
            ->getResultArray();
    }
}
