<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('admin')->insert([
            [
                'admin_name' => 'Admin Pegawai',
                'nip' => '987654',
                'role' => 0, // Pegawai
            ],
            [
                'admin_name' => 'Admin Sisfo',
                'nip' => '436932',
                'role' => 1, // Tim Sisfo
            ]
        ]);
    }
}
