<?php

namespace Database\Seeders;

use App\Models\UMKM;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

         Admin::create([
            'id' => 1,
            'name' => 'Admin UMKM Sukahaji',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'status' => 'approved',
            'role_id' => '1',  //=> 'Admin'
        ]);

        User::create([
            'id' => 2,
            'name' => 'Penduduk 1',
            'email' => 'penduduk1@gmail.com',
            'password' => 'password',
            'status' => 'approved',
            'role_id' => '2',  //=> 'User'
        ]);

        
    }
}
