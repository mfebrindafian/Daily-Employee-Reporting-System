<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterfungsionalModel extends Model
{
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $table = 'mst_fungsional';
    protected $allowedFields = ['jabatan_fungsional'];

    public function getAllFungsional()
    {
        return $this
            ->table('mst_fungsional')
            ->get()
            ->getResultArray();
    }
}
