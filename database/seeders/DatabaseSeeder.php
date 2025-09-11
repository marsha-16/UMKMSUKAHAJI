<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Admin;
use App\Models\UMKM;
use App\Models\Pemetaan;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
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
            'id' => 1,
            'name' => 'Penduduk 1',
            'email' => 'penduduk1@gmail.com',
            'password' => 'password',
            'status' => 'approved',
            'role_id' => '2',  //=> 'User'
        ]);


        // 3. Buat UMKM dengan user_id dari tabel users
        $umkm = UMKM::create([
            'user_id'   => 1,
            'name'      => 'Dewi',
            'nik'       => '3273035802950005',
            'address'   => 'Jl.Bacip',
            'phone'     => '089678903898',
            'business'  => 'Warung Kelontong',
            'marketing' => 'Tunai',
            'promotion' => 'Facebook',
            'document'  => 'Nomor Induk Berusaha',
        ]);

        // 4. Buat pemetaan
        Pemetaan::create([
            'umkm_id'   => $umkm->id,
            'name'      => $umkm->name,
            'nik'       => $umkm->nik,
            'address'   => $umkm->address,
            'phone'     => $umkm->phone,
            'business'  => $umkm->business,
            'marketing' => $umkm->marketing,
            'promotion' => $umkm->promotion,
            'document'  => $umkm->document,
        ]);
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            PemetaanSeeder::class,
            AdminSeeder::class,
        ]);
    }
}
