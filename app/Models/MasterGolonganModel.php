<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterGolonganModel extends Model
{
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
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
