<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RehashPasswords extends Command
{
    protected $signature = 'passwords:rehash';
    protected $description = 'Rehash all user passwords to bcrypt';

    public function handle()
    {
        $users = User::all();
        foreach ($users as $user) {
            // Cek apakah password sudah bcrypt (dimulai dengan $2y$)
            if (!str_starts_with($user->password, '$2y$')) {
                $user->password = Hash::make($user->password);
                $user->save();
                $this->info("Password user {$user->id} berhasil di-hash ulang.");
            }
        }

        $this->info('Semua password lama sudah diubah ke bcrypt.');
    }
}
