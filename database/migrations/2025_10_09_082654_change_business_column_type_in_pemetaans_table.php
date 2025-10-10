<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pemetaans', function (Blueprint $table) {
            $table->string('business', 100)->change(); // ubah dari ENUM ke VARCHAR
        });
    }

    public function down(): void
    {
        Schema::table('pemetaans', function (Blueprint $table) {
            $table->enum('business', [
                'Warung Kelontong', 'Makanan dan Minuman', 'Sayur Mayur dan Daging',
                'Pakaian', 'Jajanan Pasar', 'Jasa Fotocopy',
                'Servis Elektronik', 'Jasa Sumur Bor', 'Yang Lain'
            ])->change();
        });
    }
};
