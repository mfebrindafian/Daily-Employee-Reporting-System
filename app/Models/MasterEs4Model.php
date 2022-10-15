<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterEs4Model extends Model
{
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $table = 'mst_es4';
    protected $allowedFields = ['deskripsi', 'nip_kepalaes4'];

    public function getAllSeksi()
    {
        return $this
            ->table('mst_es4')
            ->get()
            ->getResultArray();
    }
}
