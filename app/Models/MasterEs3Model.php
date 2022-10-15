<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterEs3Model extends Model
{
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $table = 'mst_es3';
    protected $allowedFields = ['deskripsi', 'nip_kepalaes3', 'nip_wakiles3'];

    public function getAllBidang()
    {
        return $this
            ->table('mst_es3')
            ->get()
            ->getResultArray();
    }

    public function getBidangById($es3_kd)
    {
        return $this
            ->table('mst_es3')
            ->where('kd_es3', $es3_kd)
            ->get()
            ->getRowArray();
    }
}
