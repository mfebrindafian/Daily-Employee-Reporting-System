<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterJabatanModel extends Model
{
    protected $DBGroup = 'siphp2';
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
