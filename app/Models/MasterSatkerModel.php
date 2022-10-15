<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterSatkerModel extends Model
{
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $table = 'mst_satker';
    protected $allowedFields = ['satker', 'email_satker', 'wilsatker_kab', 'wilsatker_kec', 'nip_kepala', 'nip_wakilkepala', 'nip_ppk', 'nip_bendaharapeng'];

    public function getAllSatker()
    {
        return $this
            ->table('mst_satker')
            ->get()
            ->getResultArray();
    }
}
