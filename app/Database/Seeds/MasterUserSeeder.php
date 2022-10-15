<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Psr\Log\LogLevel;

class MasterUserSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();
        $pass = password_hash('coolhand', PASSWORD_DEFAULT);
        $data = [
            'username' => 'adminbps',
            'fullname' => 'bps1500',
            'email' => 'bps1500@gmail.com',
            'password' => $pass,
            'token' => 'coolhand',
            'image' => 'image.jpg',
            'nip_lama_user' => '123456789',
            'is_active' => 'Y',
        ];

        $this->db->table('tbl_user')->insert($data);
    }
}
