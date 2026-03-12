<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
    \App\Models\User::create([
        'Username' => 'admin_perpus',
        'Password' => bcrypt('admin123'),
        'Email' => 'admin@gmail.com',
        'NamaLengkap' => 'Administrator Utama',
        'Alamat' => 'Kantor Pusat',
        'Role' => 'admin'
    ]);
}
}
