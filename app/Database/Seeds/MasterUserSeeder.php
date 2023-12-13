<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Psr\Log\LogLevel;

class MasterUserSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();
        $pass = password_hash('', PASSWORD_DEFAULT);
        $data = [
            'username' => '',
            'fullname' => '',
            'email' => '',
            'password' => $pass,
            'token' => '',
            'image' => '',
            'nip_lama_user' => '',
            'is_active' => '',
        ];

        $this->db->table('tbl_user')->insert($data);
    }
}
