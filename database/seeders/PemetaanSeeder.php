<?php

namespace Database\Seeders;

use App\Models\Pemetaan;
use App\Models\UMKM;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PemetaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UMKM::create([
            'id' => 1,
            'user_id' => 1,
            'name' => 'Dewi',
            'address' => 'Jl.Bacip',
        ]);
        
        Pemetaan::create([
            'umkm_id' => 1,
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
