<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterGolonganModel extends Model
{
    protected $DBGroup = 'siphp2';
    protected $table = 'mst_gol';
    protected $allowedFields = ['golongan', 'pangkat'];

    public function getAllGolongan()
    {
        return $this
            ->table('mst_gol')
            ->get()
            ->getResultArray();
    }
}
