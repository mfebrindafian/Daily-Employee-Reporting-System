<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterPendidikanModel extends Model
{
    protected $DBGroup = 'siphp2';
    protected $table = 'mst_pendidikan';
    protected $allowedFields = ['tk_pendidikan'];

    public function getAllPendidikan()
    {
        return $this
            ->table('mst_pendidikan')
            ->get()
            ->getResultArray();
    }
}
