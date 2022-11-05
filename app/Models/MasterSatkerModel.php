<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterSatkerModel extends Model
{
    protected $DBGroup = 'siphp2';
    protected $table = 'mst_satker';
    protected $allowedFields = ['satker', 'email_satker', 'wilsatker_kab', 'wilsatker_kec', 'nip_kepala', 'nip_wakilkepala', 'nip_ppk', 'nip_bendaharapeng'];

    public function getAllSatker()
    {
        return $this
            ->table('mst_satker')
            ->get()
            ->getResultArray();
    }

    public function getSatkerById($satker_id)
    {

        return $this
            ->table('mst_satker')
            ->where('kd_satker', $satker_id)
            ->get()
            ->getRowArray();
    }
}
