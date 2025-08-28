<?php

namespace Database\Seeders;

use App\Models\UMKM;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'id' => 2,
            'name' => 'Penduduk 1',
            'email' => 'penduduk1@gmail.com',
            'password' => 'password',
            'status' => 'approved',
            'role_id' => '2',  //=> 'User'
        ]);

        UMKM::create([
            'user_id' => 2,
            'name' => 'Dewi',
            'nik' => '3273035802950005',
            'address' => 'Jl.Bacip',
            'phone' => '089678903898',
            'business' => 'Warung Kelontong',
            'marketing' => 'Tunai',
            'promotion' => 'Facebook',
            'document' => 'Nomor Induk Berusaha',
        ]);
    }
}
