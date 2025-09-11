<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class AdminSeeder extends Seeder
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

    }
}
