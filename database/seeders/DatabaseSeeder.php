<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        User::create([
            'nama'     => 'Zamuro',
            'email'    => 'admin@gmail.com',
            'jabatan'  => 'Admin',
            'password' => Hash::make('zamuro1702'),
            'is_tugas' => false,
        ]);

        User::create([
            'nama'     => 'byan',
            'email'    => 'byan@gmail.com',
            'jabatan'  => 'Karyawan',
            'password' => Hash::make('zamuro1702'),
            'is_tugas' => false,
        ]);

        User::create([
            'nama'     => 'rehan',
            'email'    => 'rehan@gmail.com',
            'jabatan'  => 'Karyawan',
            'password' => Hash::make('zamuro1702'),
            'is_tugas' => false,
        ]);

        User::create([
            'nama'     => 'izhar',
            'email'    => 'izhar@gmail.com',
            'jabatan'  => 'Karyawan',
            'password' => Hash::make('izhar1702'),
            'is_tugas' => false,
        ]);
    }
}
