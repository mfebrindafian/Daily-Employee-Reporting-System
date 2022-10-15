<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterJabatanModel extends Model
{
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $table = 'mst_jabatan';
    protected $allowedFields = ['nama_jabatan'];

    public function getAllJabatan()
    {
        return $this
            ->table('mst_jabatan')
            ->get()
            ->getResultArray();
    }
}
